<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/13
 * @Time: 18:55
 */

namespace App\Stores\Home;


use App\Models\Tag;
use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class ResourceStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $uid
     * @param int $page
     * @return bool|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllResource($uid,$page=10)
    {
        if ($uid) {
            $resources = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)
                ->orderBy('create_at','desc')
                ->where('uid',$uid)
                ->paginate($page);
            $items = DB::connection($this->CONN_DB)->table($this->ITEM_TB)
                ->where('type','resource')
                ->select(['id','name'])
                ->get()
                ->toArray();
            $new_item = [];
            foreach ($items as $item) {
                $new_item[$item->id] = $item->name;
            }
            $all_tag = DB::connection($this->CONN_DB)->table($this->TAG_TB)
                ->whereIn('type',['common', 'resource'])
                ->select(['id','name'])
                ->get()
                ->toArray();
            $new_tag = [];
            foreach ($all_tag as $tag) {
                $new_tag[$tag->id] = $tag->name;
            }
            $type = [
                'file' => '文档类',
                'code' => '代码类',
                'picture' => '图片类',
                'package' => '压缩包',
                'default' => '其他'
            ];
            foreach ($resources as $k => $resource) {
                $resource->type = $type[$resource->type];
                $resource->item_name = $new_item[$resource->item_id];
                $tag_ids = DB::connection($this->CONN_DB)->table($this->RESOURCE_TAG_RELATIONSHIP_TB)
                    ->where('resource_id',$resource->id)
                    ->pluck('tag_id')
                    ->toArray();
                $tags = [];
                foreach ($tag_ids as $tag_id) {
                    if (array_key_exists($tag_id,$new_tag)) {
                        $tags[] = [
                            'id' => $tag_id,
                            'name' => $new_tag[$tag_id]
                        ];
                    }
                }
                $resource->tags = $tags;
                $resources[$k] = $resource;
            }
            return $resources;
        } else {
            return false;
        }
    }

    /**
     * 获取所有标签
     * @return mixed
     */
    public function getAllTags()
    {
        return Tag::whereIn('type',['common','resource'])->get()->toArray();
    }

    /**
     * @param $data
     * @param $tag_ids
     * @return bool
     */
    public function addResource($data,$tag_ids)
    {
        if (empty($data) || empty($tag_ids)) {
            return false;
        }
        try {
            DB::connection($this->CONN_DB)->beginTransaction();
            $rid = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)->insertGetId($data);
            foreach ($tag_ids as $tag_id) {
                DB::connection($this->CONN_DB)->table($this->RESOURCE_TAG_RELATIONSHIP_TB)->insert([
                    'resource_id' => $rid,
                    'tag_id' => $tag_id
                ]);
            }
            DB::connection($this->CONN_DB)->commit();
        } catch (\Exception $exception) {
            DB::connection($this->CONN_DB)->rollBack();
            return false;
        }
        return true;
    }

    /**
     * @param $rid
     * @return array
     */
    public function getTagIds($rid)
    {
        return DB::connection($this->CONN_DB)->table($this->RESOURCE_TAG_RELATIONSHIP_TB)
            ->where('resource_id',$rid)
            ->pluck('tag_id')
            ->toArray();
    }

    /**
     * @param $data
     * @param $rid
     * @param array $tag_ids
     * @return bool
     */
    public function updateResource($data,$rid,$uid,$tag_ids=[])
    {
        if (empty($data) || !$rid) {
            return false;
        }
        try {
            DB::connection($this->CONN_DB)->beginTransaction();
            DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)
                ->where(['id'=>$rid,'uid'=>$uid])
                ->update($data);
            if ($tag_ids) {
                DB::connection($this->CONN_DB)->table($this->RESOURCE_TAG_RELATIONSHIP_TB)
                    ->where('resource_id',$rid)->delete();
                foreach ($tag_ids as $tag_id) {
                    DB::connection($this->CONN_DB)->table($this->RESOURCE_TAG_RELATIONSHIP_TB)
                        ->insert(['resource_id'=>$rid,'tag_id'=>$tag_id]);
                }
            }
            DB::connection($this->CONN_DB)->commit();
        } catch(\Exception $exception) {
            DB::connection($this->CONN_DB)->rollBack();
            return false;
        }
        return true;
    }

    /**
     * @param $rid
     * @return bool
     */
    public function deleteResource($rid,$uid)
    {
        try {
            DB::connection($this->CONN_DB)->beginTransaction();
            DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)->delete($rid);
            DB::connection($this->CONN_DB)->table($this->RESOURCE_TAG_RELATIONSHIP_TB)
                ->where(['resource_id'=>$rid,'uid'=>$uid])
                ->delete();
            DB::connection($this->CONN_DB)->commit();
        } catch (\Exception $exception) {
            DB::connection($this->CONN_DB)->rollBack();
            return false;
        }
        return true;
    }
}