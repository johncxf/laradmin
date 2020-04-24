<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/4/21
 * @Time: 19:38
 */

namespace App\Services\Api;


class BaseService
{
    /**
     * @var array 响应信息
     */
    protected $result = array('code' => 0, 'msg' => '', 'data' => array());
    //应用ID
    protected $app_id = 0;
    //应用信息
    protected $app_info;
    //ip地址
    protected $ip;

    /**
     * BaseService constructor.
     * @param $appInfo
     */
    public function __construct($appInfo)
    {
        //当前请求appID
        $this->app_id = $appInfo['app_id'];
        //当前请求应用信息
        $this->app_info = $appInfo;
        //当前请求ip地址
        $this->ip = get_client_ip(0, true);
    }

}