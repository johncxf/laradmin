<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/1/9
 * @Time: 19:54
 */

namespace App\Stores\Home;


use App\Models\Category;
use App\Stores\BaseStore;
use App\Tools\MenuUtils;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeStore extends BaseStore
{
    /**
     * HomeStore constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取单个栏目信息
     * @param $alias
     * @return bool
     */
    public function getCategory($alias)
    {
        return Category::where('alias', $alias)->first()->toArray();
    }

    /**
     * @param $limit
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getArticles($limit=10)
    {
        return DB::connection($this->CONN_DB)->table($this->ARTICLE_TB)
        ->where(['status' => 2,'is_top' => 1])
        ->orderBy('create_at', 'desc')
        ->paginate($limit);
    }

    /**
     * 获取友情链接
     * @param int $limit
     * @return array
     */
    public function getFriendLinks($limit=10)
    {
        return DB::connection($this->CONN_DB)->table($this->LINK_TB)
            ->limit($limit)
            ->get()
            ->toArray();
    }

}