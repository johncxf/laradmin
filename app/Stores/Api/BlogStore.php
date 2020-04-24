<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/4/22
 * @Time: 17:28
 */

namespace App\Stores\Api;


use App\Tools\MenuUtils;
use Illuminate\Support\Facades\DB;

class BlogStore
{
    /**
     * @var string 数据库
     */
    private $CONN_DN_BLOG = 'mysql_blog';

    /**
     * @var string 分类标签表
     */
    protected $METAS_TB = 'metas';

    /**
     * @var string 文章表
     */
    protected $CONTENTS_TB = 'contents';

    /**
     * @var string 文章分类对应关系表
     */
    protected $RELATIONSHIPS_TB = 'relationships';

    public function __construct()
    {

    }

    /**
     * @return array
     */
    public function getLists()
    {
        // 所有分类数据
        $categories = DB::connection($this->CONN_DN_BLOG)->table($this->METAS_TB)
            ->where(['type' => 'category'])
            ->orderBy('order', 'asc')
            ->select(['name','mid','parent','order'])
            ->get()
            ->toArray();
        if (!$categories) {
            return [];
        }
        // 所有文章id
        $cids = DB::connection($this->CONN_DN_BLOG)->table($this->RELATIONSHIPS_TB)
            ->orderBy('cid','desc')
            ->get()
            ->groupBy('mid')
            ->toArray();
        $new_cids = [];
        foreach ($cids as $key => $cid) {
            foreach ($cid as $k => $v) {
                $new_cids[$key][] = $v->cid;
            }
        }
        // 博客文章
        $contents = DB::connection($this->CONN_DN_BLOG)->table($this->CONTENTS_TB)
            ->where(['status' => 'publish'])
            ->orderBy('created','desc')
            ->select(['cid','title','views','created'])
            ->get()
            ->toArray();
        $new_contents = [];
        foreach ($contents as $key => $content) {
            $new_contents[$content->cid] = [
                'cid' => $content->cid,
                'title' => $content->title,
                'pv' => $content->views,
                'time' => $this->transformDate($content->created)
            ];
        }
        // 分类文章数组
        $data_contents = [];
        foreach ($new_cids as $key => $item) {
            foreach ($item as $k => $v) {
                $data_contents[$key][$v] = $new_contents[$v];
            }
        }
        // 返回的数据
        $list = [];
        $categories = $this->dealCate($categories);
        foreach ($categories as $key => $cate) {
            $list[$key] = [
                'id' => $key,
                'name' => $cate['name'],
                'mid' => $cate['mid']
            ];
            if (array_key_exists($cate['mid'],$data_contents)) {
                $list[$key]['content'] = array_values($data_contents[$cate['mid']]);
            }
        }

        return $list;
    }

    /**
     * 获取文章详情
     * @param $cid
     * @return array|\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Query\Builder|object|null
     */
    public function getContentDetail($cid)
    {
        $content = DB::connection($this->CONN_DN_BLOG)->table($this->CONTENTS_TB)
            ->where(['status' => 'publish','cid' => $cid])
            ->first();
        if ($content) {
            $content = (array)$content;
            $content['created'] = date('Y-m-d H:i',$content['created']);
            $content['author'] = '一切随风';
            $slug = '';
            if (!is_numeric($content['slug'])) {
                $slug = DB::connection($this->CONN_DN_BLOG)->table($this->METAS_TB)
                    ->where(['slug' => $content['slug']])
                    ->value('name');
            }
            // 所有标签id
            $allTagIds = DB::connection($this->CONN_DN_BLOG)->table($this->METAS_TB)
                ->where(['type' => 'tag'])
                ->pluck('mid');
            // 所有标签名
            $allTags = DB::connection($this->CONN_DN_BLOG)->table($this->METAS_TB)
                ->where(['type' => 'tag'])
                ->get()
                ->toArray();
            $arrAllTags = [];
            foreach ($allTags as $key => $item) {
                $arrAllTags[$item->mid] = $item->name;
            }
            // 文章对应的标签id
            $tagIds = DB::connection($this->CONN_DN_BLOG)->table($this->RELATIONSHIPS_TB)
                ->whereIn('mid',$allTagIds)
                ->where(['cid' => $cid])
                ->pluck('mid');
            $tags = [];
            if ($tagIds) {
                foreach ($tagIds as $tagId) {
                    if ($tagId && array_key_exists($tagId, $arrAllTags)) {
                        $tags[] = $arrAllTags[$tagId];
                    }
                }
            }
            if ($slug) {
                array_push($tags,$slug);
            }
            $content['tags'] = $tags;
        }
        return $content;
    }

    /**
     * 增加pv
     * @param $cid
     * @return bool
     */
    public function read($cid)
    {
        try {
            DB::connection($this->CONN_DN_BLOG)->table($this->CONTENTS_TB)
                ->where('cid',$cid)
                ->increment('views');
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * 时间格式转化
     * @param $time 时间戳
     * @return false|string
     */
     protected function transformDate($time)
     {
         if (!$time) {
             return '未知';
         }
         $now_year = date('Y', time());
         if (date('Y',$time) < $now_year) {// 往年
             $res = date('Y',$time).'年';
         } elseif (($time + (60 * 60 * 24 * 3)) < time()) {// 三天前
             $res = '三天前';
         } elseif (($time + (60 * 60 * 24 * 2)) < time()) {
             $res = '两天前';
         } elseif (($time + (60 * 60 * 24)) < time()) {
             $res = '昨天';
         } else {
             $res = date('H:i',$time);
         }
         return $res;
     }

    /**
     * @param $category
     * @return array
     */
     protected function dealCate($category)
     {
         $data = [];
         foreach ($category as $key => $cate) {
             $data[$cate->mid] = (array)$cate;
         }
         $data = (new MenuUtils())->generateTree($data,'mid','parent','_child', 0);
         $arr = [];
         $i = 0;
         foreach ($data as $key => $item) {
             $arr[$i] = [
                 'name' => $item['name'],
                 'mid' => $item['mid'],
                 'order' => $item['order'],
             ];
             $i++;
             if (isset($item['_child'])) {
                 foreach ($item['_child'] as $k => $v) {
                     $arr[$i] = [
                         'name' => $v['name'],
                         'mid' => $v['mid'],
                         'order' => $v['order'],
                     ];
                     $i++;
                 }
             }
         }
         return $arr;
     }
}