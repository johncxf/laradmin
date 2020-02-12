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
        // 获取菜单配置信息
        $config_menus = config('menu');
        // 同步菜单
        $objStoreMenu = new \App\Stores\Admin\MenuStore();
        $objStoreMenu->synchro($config_menus);
    }
}
