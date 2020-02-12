<?php
/*
 * @Description: 
 * @Author: chenxf
 * @LastEditors: chenxf
 * @Date: 2019/12/20
 * @Time: 21:48
 */
return [
    // 站长角色ID
    'webMasterRoleIds' => 1,
    // Logo地址
    'webLogo' => 'img/default/webLogo.png',
    /**
     * 菜单模板选择
     * _menu：默认三级菜单
     * _menu_link：一级菜单作为链接
     */
    'menu_template' => '_menu',
    // 菜单栏链接
    'menu_link' => [
        'status' => 1,// 1开启 0关闭
        'title' => '相关链接',// 标题
        'links' => [
            ['name' => '相关文档', 'icon' => 'fa-circle text-danger', 'url' => 'https://github.com/johncxf'],
            ['name' => '个人博客', 'icon' => 'fa-circle text-warning', 'url' => 'https://blog.yiqiesuifeng.cn/'],
            ['name' => 'Github', 'icon' => 'fa-circle text-info', 'url' => 'https://github.com/johncxf'],
        ]
    ],
];