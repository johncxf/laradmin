<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/5
 * @Time: 16:33
 */

namespace App\Stores\Admin;


use App\Models\Admin;
use App\Stores\BaseStore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserStore extends BaseStore
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取后台管理用户登录信息
     * @return mixed
     */
    public function getAdminUsers()
    {
        // 获取当前用户id
        $uid = Auth::guard('admin')->id();
        // 查询用户信息
        $user = Admin::where('id', $uid)->first()->toArray();

        return $user;
    }

    public function getAllUsers($where=[],$page=10)
    {
        $ret = DB::connection($this->CONN_DB)->table($this->USER_TB)
            ->where($where)
            ->paginate($page);
        return $ret;
    }
}