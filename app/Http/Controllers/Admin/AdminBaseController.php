<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminBaseController extends Controller
{
    // 默认连接数据库
    protected $CONN_DB;

    public function __construct()
    {
        $this->CONN_DB = 'mysql_laradmin';
    }

    /**
     * 获取登录用户信息
     * @param string $guard
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected function getUserInfo($guard='')
    {
        if ($guard) {
            return auth($guard)->user();
        }
        return auth()->user();
    }
    /**
     *  获取用户登录信息
     * @param string $guard
     * @return int|string|null
     */
    protected function getUserId($guard='')
    {
        if ($guard) {
            return auth($guard)->id();
        }
        return auth()->id();
    }
}
