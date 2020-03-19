<?php

namespace App\Listeners;

use App\Events\RegEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\DB;

class RegListener
{
    /**
     * @var string 默认连接数据库
     */
    protected $CONN_DB;

    /**
     * @var string admin表,用户表
     */
    protected $USER_TB;

    /**
     * 用户信息
     * @var
     */
    protected $USER;
    /**
     * Create the event listener.
     *
     * @return void
     */
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->CONN_DB = 'mysql_laradmin';
        $this->USER_TB = 'user';
    }

    /**
     * Handle the event.
     *
     * @param  RegEvent  $event
     * @return void
     */
    public function handle(RegEvent $event)
    {
        // 用户信息
        $this->USER = $event->getUser();

        $this->addAccount($this->USER['id']);
    }

    /**
     * @param $uid
     * @return bool
     */
    protected function addAccount($uid)
    {
        $data = [
            'uid' => $uid,
            'money' => 0.00,
            'frozen_money' => 0.00,
            'gold' => 0,
            'score' => 0
        ];
        return DB::connection($this->CONN_DB)->table('user_account')->insert($data);
    }
}
