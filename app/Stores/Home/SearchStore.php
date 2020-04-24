<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/3/19
 * @Time: 19:13
 */

namespace App\Stores\Home;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class SearchStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 搜索资源
     * @param $keyword
     * @return array|mixed
     */
    public function getSearchResult($keyword)
    {
        $searchByTitle = $this->getResultByTitle($keyword);
        $searchByItem = $this->getResultByItem($keyword);
        $searchByTag = $this->getResultByTag($keyword);
        $rids = array_merge($searchByTitle,$searchByItem,$searchByTag);
        $rids = array_unique($rids);
        return (new DownloadStore())->getResourceByRids($rids);
    }

    /**
     * 根据资源标题搜索
     * @param $keyword
     * @param int $limit
     * @return array
     */
    private function getResultByTitle($keyword,$limit=5)
    {
        $res = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)
            ->where('title','like', '%'.$keyword.'%')
            ->limit($limit)
            ->pluck('id')
            ->toArray();
        return $res;
    }

    /**
     * 根据资源分类搜索
     * @param $keyword
     * @param int $limit
     * @return array
     */
    private function getResultByItem($keyword,$limit=5)
    {
        $res = [];
        $item_ids = DB::connection($this->CONN_DB)->table($this->ITEM_TB)
            ->whereIn('type',['resource','common'])
            ->where('name','like', '%'.$keyword.'%')
            ->pluck('id');
        if ($item_ids) {
            $res = DB::connection($this->CONN_DB)->table($this->RESOURCE_TB)
                ->whereIn('item_id',$item_ids)
                ->limit($limit)
                ->pluck('id')
                ->toArray();
        }
        return $res;
    }

    /**
     * 根据标签获取资源id
     * @param $keyword
     * @param int $limit
     * @return array
     */
    private function getResultByTag($keyword,$limit=5)
    {
        $res = [];
        $tag_ids = DB::connection($this->CONN_DB)->table($this->TAG_TB)
            ->whereIn('type',['resource','common'])
            ->where('name','like', '%'.$keyword.'%')
            ->limit($limit)
            ->pluck('id');
        if ($tag_ids) {
            $res = DB::connection($this->CONN_DB)->table($this->RESOURCE_TAG_RELATIONSHIP_TB)
                ->whereIn('tag_id',$tag_ids)
                ->limit($limit)
                ->pluck('resource_id')
                ->toArray();
        }
        return $res;
    }
}