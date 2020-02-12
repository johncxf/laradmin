<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LinkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CONN_DB = 'mysql_laradmin';
        $LINK_TB = 'link';
        $links = [
            [
                'name' => '一切随风',
                'url' => 'https://blog.yiqiesuifeng.cn/',
                'type' => 'friend',
                'remark' => '个人博客'
            ],
            [
                'name' => 'Github',
                'url' => 'https://github.com/johncxf',
                'type' => 'friend',
                'remark' => '个人Github'
            ]
        ];
        DB::connection($CONN_DB)->table($LINK_TB)->insert($links);
    }
}
