<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlideSeeder extends Seeder
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
        $SLIDE_TB = 'slide';
        $slides = [
            [
                'name' => 'banner1',
                'content' => 'img/default/banner1.jpg',
                'type' => 'home',
                'status' => 1,
                'sort' => 1,
            ],
            [
                'name' => 'banner2',
                'content' => 'img/default/banner2.jpg',
                'type' => 'home',
                'status' => 1,
                'sort' => 2,
            ],
            [
                'name' => 'banner3',
                'content' => 'img/default/banner3.jpg',
                'type' => 'home',
                'status' => 1,
                'sort' => 3,
            ]
        ];
        DB::connection($CONN_DB)->table($SLIDE_TB)->insert($slides);
    }
}
