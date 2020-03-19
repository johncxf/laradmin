<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/13
 * @Time: 18:55
 */

namespace App\Stores\Home;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class DownloadStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取所有资源信息，按时间倒叙
     * @param int $page
     * @param array $where
     * @return mixed
     */
    public function getAllResources($page=10,$where=[])
    {
        $resources = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)
            ->where(['status' => 1])
            ->where($where)
            ->orderBy('create_at','desc')
            ->limit(100)
            ->paginate($page);
        return $this->delResources($resources);
    }

    /**
     * @param $rid
     * @param $uid
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getResourceInfo($rid,$uid)
    {
        $res = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)
            ->where(['id' => $rid,'status' => 1])
            ->first();
        $users = $this->getKeyValue($this->USER_TB);
        $res->author = $users[$res->uid];
        $exts = config('ext');
        $icon = 'file';
        if ($res->ext && array_key_exists(strtolower($res->ext),$exts)) {
            $icon = $exts[strtolower($res->ext)]['icon'];
        }
        $res->icon = $icon;
        $res->showname = $res->title;
        $res->time = $res->create_at;
        $res->size = $this->getSize($res->size);
        $res->is_star = $this->is_star($res->id,$uid);
        $res->stars = $this->getCountBYRid($res->id,$this->RESOURCE_STAR_TB);
        $res->downloads = $this->getCountBYRid($res->id,$this->DOWNLOAD_TB);
        return $res;
    }

    /**
     * 收藏
     * @param $rid
     * @param $uid
     * @return bool
     */
    public function like($rid,$uid)
    {
        $data = [
            'uid' => $uid,
            'rid' => $rid,
            'create_at' => date('Y-m-d H:i:s',time())
        ];
        try {
            DB::connection($this->CONN_DB)->table($this->RESOURCE_STAR_TB)->insert($data);
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * 取消收藏
     * @param $rid
     * @param $uid
     * @return bool
     */
    public function unlike($rid,$uid)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->RESOURCE_STAR_TB)
                ->where(['uid' => $uid,'rid' => $rid])
                ->delete();
        } catch (\Exception $exception) {
            return false;
        }
        return true;
    }

    /**
     * 从表中获取键值对形式一维数组
     * @param $table
     * @param string $key
     * @param string $val
     * @param array $where
     * @return array
     */
    private function getKeyValue($table,$key='id',$val='nickname',$where=[])
    {
        $res = DB::connection($this->CONN_DB)->table($table)
            ->where($where)
            ->select([$key,$val])
            ->get()
            ->toArray();
        $arr = [];
        foreach ($res as $item) {
            $arr[$item->$key] = $item->$val;
        }
        return $arr;
    }

    /**
     * @param $rid
     * @return \Illuminate\Database\Query\Builder|mixed
     */
    public function getResource($rid)
    {
        $res = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)->find($rid);
        if ($res) {
            $res = (array)$res;
        } else {
            $res = [];
        }
        return $res;
    }

    /**
     * @param $uid
     * @return array
     */
    public function getAccountInfo($uid)
    {
        $account = DB::connection($this->CONN_DB)->table($this->USER_ACCOUNT_TB)
            ->where('uid',$uid)
            ->first();
        if ($account) {
            return (array)$account;
        } else {
            $data = [
                'uid' => $uid,
                'money' => 0.00,
                'frozen_money' => 0.00,
                'gold' => 0,
                'score' => 0
            ];
            DB::connection($this->CONN_DB)->table('user_account')->insert($data);
            return $data;
        }
    }

    /**
     * 下载资源数据处理
     * @param $uid
     * @param $resource
     * @return bool
     */
    public function downloadLog($uid,$resource)
    {
        try {
            DB::connection($this->CONN_DB)->beginTransaction();
            // 下载表数据处理
            $data_download = [
                'uid' => $uid,
                'rid' => $resource['id'],
                'create_at' => date('Y-m-d H:i:s',time())
            ];
            if ($uid != $resource['uid'] &&
                !DB::connection($this->CONN_DB)->table($this->DOWNLOAD_TB)
                    ->where(['uid'=>$uid,'rid'=>$resource['id']])
                    ->first()) {
                $did = DB::connection($this->CONN_DB)->table($this->DOWNLOAD_TB)->insertGetId($data_download);
                // 下载方用户数据处理
                $used_gold = $resource['gold'];
                $account_put = $this->getAccountInfo($uid);
                DB::connection($this->CONN_DB)->table($this->USER_ACCOUNT_TB)
                    ->where(['uid' => $uid])
                    ->decrement('gold', $used_gold);
                $data_decrement = [
                    'uid' => $uid,
                    'gold' => $used_gold,
                    'type' => 2,
                    'source' => 'download',
                    'source_id' => $did,
                    'gold_before' => $account_put['gold'],
                    'gold_after' => $account_put['gold'] - $used_gold,
                    'remark' => '下载资源消耗'.$used_gold.'金币',
                    'create_at' => date('Y-m-d H:i:s',time())
                ];
                DB::connection($this->CONN_DB)->table($this->USER_GOLD_LOG_TB)->insert($data_decrement);
                // 被下载方数据处理
                $reward_gold = $resource['gold'];
                DB::connection($this->CONN_DB)->table($this->USER_ACCOUNT_TB)
                    ->where(['uid' => $resource['uid']])
                    ->increment('gold', $reward_gold);
                DB::connection($this->CONN_DB)->table($this->USER_ACCOUNT_TB)
                    ->where(['uid' => $resource['uid']])
                    ->increment('score', $reward_gold);
                $account_get = $this->getAccountInfo($resource['uid']);
                $data_increment = [
                    'uid' => $resource['uid'],
                    'gold' => $reward_gold,
                    'type' => 1,
                    'source' => 'download',
                    'source_id' => $did,
                    'gold_before' => $account_get['gold'],
                    'gold_after' => $account_get['gold'] + $reward_gold,
                    'remark' => '资源被下载奖励'.$reward_gold.'金币',
                    'create_at' => date('Y-m-d H:i:s',time())
                ];
                DB::connection($this->CONN_DB)->table($this->USER_GOLD_LOG_TB)->insert($data_increment);
            } else {
                DB::connection($this->CONN_DB)->table($this->DOWNLOAD_TB)->insertGetId($data_download);
            }
            DB::connection($this->CONN_DB)->commit();
        } catch (\Exception $exception) {
            DB::connection($this->CONN_DB)->rollBack();
            return false;
        }
        return true;
    }

    /**
     * 是否收藏
     * @param $rid
     * @param $uid
     * @return bool
     */
    public function is_star($rid,$uid)
    {
        if (DB::connection($this->CONN_DB)->table($this->RESOURCE_STAR_TB)
            ->where(['uid' => $uid, 'rid' => $rid])->first()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 智能推荐资源
     * @param $resource_id
     * @return array|mixed
     */
    public function recommend($resource_id)
    {
        $download_top = $this->download_top_rids(5);
        $star_top = $this->star_top_rids(5);
        $rids = $download_top;
        foreach ($star_top as $rid)
        {
            if (!in_array($rid,$download_top) && $rid != $resource_id) {
                $rids[] = $rid;
            }
        }
        $resources = $this->getResourceByRids($rids);
        return $resources;
    }

    /**
     * 获取收藏热门资源
     * @param int $limit
     * @return array|mixed
     */
    public function star_top($limit=10)
    {
        $rids = $this->star_top_rids($limit);
        return $this->getResourceByRids($rids);
    }

    /**
     * 获取下载排行资源
     * @param int $limit
     * @return array|mixed
     */
    public function download_top($limit=10)
    {
        $rids = $this->download_top_rids($limit);
        return $this->getResourceByRids($rids);
    }

    /**
     * 获取收藏量前几的rid
     * @param int $limit
     * @return array
     */
    private function star_top_rids($limit=10)
    {
        $res = DB::connection($this->CONN_DB)->table($this->RESOURCE_STAR_TB)
            ->select(DB::raw('rid,count(*) as num'))
            ->groupBy('rid')
            ->orderBy('num','desc')
            ->limit($limit)
            ->get()
            ->toArray();
        $rids = [];
        foreach ($res as $item) {
            $rids[] = $item->rid;
        }
        return $rids;
    }

    /**
     * 获取下载量前几的rid
     * @param int $limit
     * @return array
     */
    private function download_top_rids($limit=10)
    {
        $res = DB::connection($this->CONN_DB)->table($this->DOWNLOAD_TB)
            ->select(DB::raw('rid,count(id) as num'))
            ->groupBy('rid')
            ->orderBy('num','desc')
            ->limit($limit)
            ->get()
            ->toArray();
        $rids = [];
        foreach ($res as $item) {
            $rids[] = $item->rid;
        }
        return $rids;
    }

    /**
     * 根据资源id获取资源信息
     * @param $rids
     * @return array|mixed
     */
    private function getResourceByRids($rids)
    {
        $resources = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)
            ->where('status',1)
            ->whereIn('id',$rids)
            ->get()
            ->toArray();
        $new_resources = [];
        foreach ($resources as $resource)
        {
            $new_resources[$resource->id] = $resource;
        }
        $ret = [];
        foreach ($rids as $rid) {
            $ret[] = $new_resources[$rid];
        }
        $ret = $this->delResources($ret);
        return $ret;
    }

    /**
     * 处理资源数据
     * @param $data
     * @return mixed
     */
    private function delResources($data)
    {
        $arr_tags = $this->getKeyValue($this->TAG_TB,'id','name',['type'=>'resource']);
        $arr_users = $this->getKeyValue($this->USER_TB);
        $exts = config('ext');
        $icon = 'file';
        foreach ($data as $k => $resource) {
            if ($resource->uid && array_key_exists($resource->uid,$arr_users)) {
                $resource->author = $arr_users[$resource->uid];
            } else {
                $resource->author = '';
            }
            if ($resource->ext && array_key_exists(strtolower($resource->ext),$exts)) {
                $icon = $exts[strtolower($resource->ext)]['icon'];
            }
            $resource->icon = $icon;
            $resource->time = substr($resource->create_at,0,10);
            $tag_ids = DB::connection($this->CONN_DB)->table($this->RESOURCE_TAG_RELATIONSHIP_TB)
                ->where('resource_id',$resource->id)
                ->pluck('tag_id')
                ->toArray();
            $tags = [];
            foreach ($tag_ids as $tag_id) {
                if (array_key_exists($tag_id,$arr_tags)) {
                    $tags[] = [
                        'id' => $tag_id,
                        'name' => $arr_tags[$tag_id]
                    ];
                }
            }
            $resource->tags = $tags;
            $resource->size = $this->getSize($resource->size);
            $resources[$k] = $resource;
        }
        return $data;
    }

    /**
     * 获取所有可下载资源id
     * @return array
     */
    private function getCanDownloadRids()
    {
        $res = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)
            ->where(['status'=>1])
            ->pluck('id')
            ->toArray();
        return $res;
    }

    /**
     * 字节大小换算成kb、mb、gb、形式
     * @param int $size
     * @return int|string
     */
    private function getSize($size=0)
    {
        if ($size >= (1*1024*1024*1024)) {
            $size = round($size/(1024*1024*1024),2).' G';
        } elseif ((1*1024*1024) < $size && $size < (1*1024*1024*1024)) {
            $size = round($size/(1024*1024),2).' mb';
        } else {
            $size = round($size/1024,2).' kb';
        }
        return $size;
    }

    /**
     * @param $rid
     * @param $table
     * @return int
     */
    private function getCountBYRid($rid,$table)
    {
        $num = DB::connection($this->CONN_DB)->table($table)
            ->where('rid',$rid)
            ->count('*');
        if (!$num) {
            $num = 0;
        }
        return $num;
    }
}