<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2020/2/23
 * @Time: 14:19
 */

return [
    array(
        'module' => 'home',
        'permission' => 'home::center/ProfileController@index',
        'url' => '/profile/index',
        'name' => '个人中心',
        'icon' => 'fa fa-home',
        'type' => 0,
        'status' => 1,
        'remark' => '个人中心',
        'sort' => 0
    ),
    array(
        'module' => 'home',
        'permission' => 'home::center/ResourceController@index',
        'url' => '/resource',
        'name' => '我的资源',
        'icon' => 'fa fa-briefcase',
        'type' => 0,
        'status' => 1,
        'remark' => '我的资源',
        'sort' => 1
    ),
    array(
        'module' => 'home',
        'permission' => 'home::center/ProfileController@star',
        'url' => '/profile/star',
        'name' => '我的收藏',
        'icon' => 'fa fa-star',
        'type' => 0,
        'status' => 1,
        'remark' => '我的收藏',
        'sort' => 2
    ),
    array(
        'module' => 'home',
        'permission' => 'home::center/ProfileController@moment',
        'url' => '/profile/moment',
        'name' => '最新动态',
        'icon' => 'fa fa-leaf',
        'type' => 0,
        'status' => 1,
        'remark' => '最新动态',
        'sort' => 3
    ),
    array(
        'module' => 'home',
        'permission' => 'home::center/ProfileController@message',
        'url' => '/profile/message',
        'name' => '消息记录',
        'icon' => 'fa fa-bell',
        'type' => 0,
        'status' => 1,
        'remark' => '消息记录',
        'sort' => 4
    ),
    array(
        'module' => 'home',
        'permission' => 'home::center/ProfileController@info',
        'url' => '/profile/info',
        'name' => '基本资料',
        'icon' => 'fa fa-user',
        'type' => 0,
        'status' => 1,
        'remark' => '基本资料',
        'sort' => 5
    ),
    array(
        'module' => 'home',
        'permission' => 'home::center/ProfileController@site',
        'url' => '/profile/site',
        'name' => '账号设置',
        'icon' => 'fa fa-cog',
        'type' => 0,
        'status' => 1,
        'remark' => '账号设置',
        'sort' => 6
    ),
];