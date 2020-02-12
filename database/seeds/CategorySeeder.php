<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $CONN_DB = 'mysql_laradmin';
        $CATE_TB = 'category';
        DB::connection($CONN_DB)->table($CATE_TB)->insert([
            [
                'name' => '默认栏目',
                'alias' => 'default',
                'url' => '',
                'status' => 0,
                'pid' => 0
            ],
            [
                'name' => '博客',
                'alias' => 'blog',
                'url' => 'https://blog.yiqiesuifeng.cn/',
                'status' => 1,
                'pid' => 0
            ]
        ]);
    }
}
