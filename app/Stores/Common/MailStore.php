<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/9
 * @Time: 14:14
 */

namespace App\Stores\Common;


use App\Stores\BaseStore;
use Illuminate\Support\Facades\DB;

class MailStore extends BaseStore
{
    /**
     * MailStore constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 是否允许用户再次发送邮件
     * @param $uid
     * @param int $sleep
     * @return bool
     */
    public function pass($uid,$sleep=60)
    {
        $last_time = DB::connection($this->CONN_DB)->table($this->VERIFY_TB)
            ->where('uid',$uid)
            ->orderBy('id','desc')
            ->value('create_at');
        if ($last_time) {
            if ((strtotime($last_time) + $sleep) > time()) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param $data
     * @return bool
     */
    public function saveVerify($data)
    {
        return DB::connection($this->CONN_DB)->table($this->VERIFY_TB)->insert($data);
    }

}