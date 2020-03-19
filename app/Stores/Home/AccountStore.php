<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/23
 * @Time: 18:39
 */

namespace App\Stores\Home;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class AccountStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $uid
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getGoldLogs($uid,$page=10)
    {
        $res = DB::connection($this->CONN_DB)->table($this->USER_GOLD_LOG_TB)
            ->where('uid',$uid)
            ->paginate($page);
        return $res;
    }

    /**
     * @param $uid
     * @return array
     */
    public function getGoldInfo($uid)
    {
        $used_gold = DB::connection($this->CONN_DB)->table($this->USER_GOLD_LOG_TB)
            ->where(['uid' => $uid, 'type' => 2])
            ->sum('gold');
        $get_gold = DB::connection($this->CONN_DB)->table($this->USER_GOLD_LOG_TB)
            ->where(['uid' => $uid, 'type' => 1])
            ->sum('gold');
        return ['used_gold'=>$used_gold,'get_gold'=>$get_gold];
    }
}