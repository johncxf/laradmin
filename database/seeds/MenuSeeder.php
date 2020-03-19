<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 获取后台菜单配置信息
        $admin_menus = config('menu');
        // 获取前台菜单配置信息
        $index_menus = config('index_menu');
        // 合并菜单
        $config_menus = array_merge($admin_menus,$index_menus);
        // 同步菜单
        $objStoreMenu = new \App\Stores\Admin\MenuStore();
        $objStoreMenu->synchro($config_menus);
    }
}
