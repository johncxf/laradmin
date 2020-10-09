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
use GeoIp2\Database\Reader;
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

    /**
     * @param array $where
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllUsers($where=[],$page=10)
    {
        $ret = DB::connection($this->CONN_DB)->table($this->USER_TB)
            ->where($where)
            ->paginate($page);
        $city = '';
        $country = '';
        foreach ($ret as $key => $item) {
            $ip = $item->last_login_ip;
            if (!empty($ip)) {
                $country = getCountryByIP($ip);
                $city = getCityByIP($ip);
            }

            $ret[$key]->country = $country;
            $ret[$key]->city = $city;
        }

        return $ret;
    }

    /**
     * @param array $where
     * @param int $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getOauthUser($where=[],$page=10)
    {
        $ret = DB::connection($this->CONN_DB)->table($this->OAUTH_USER)
            ->where($where)
            ->paginate($page);
        return $ret;
    }

    /**
     * @param $uid
     * @return \Illuminate\Database\Query\Builder|mixed
     */
    public function getUserById($uid)
    {
        return DB::connection($this->CONN_DB)->table($this->USER_TB)->find($uid);
    }

    /**
     * 启用用户
     * @param $uid
     * @return bool
     */
    public function enable($uid)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->USER_TB)
                ->where('id',$uid)
                ->update(['user_status' => 1]);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }

    /**
     * 禁用用户
     * @param $uid
     * @return bool
     */
    public function forbidden($uid)
    {
        try {
            DB::connection($this->CONN_DB)->table($this->USER_TB)
                ->where('id',$uid)
                ->update(['user_status' => 0]);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}