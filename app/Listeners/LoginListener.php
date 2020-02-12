<?php

namespace App\Listeners;

use App\Events\LoginEvent;
use App\Tools\funcUtils;
use Illuminate\Support\Facades\DB;
use function Sodium\increment;

class LoginListener
{
    /**
     * @var string 默认连接数据库
     */
    protected $CONN_DB;

    /**
     * @var string admin表,用户表
     */
    protected $ADMIN_TB, $USER_TB;

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
    public function __construct()
    {
        $this->CONN_DB = 'mysql_laradmin';
        $this->ADMIN_TB = 'admin';
        $this->USER_TB = 'user';
    }

    /**
     * Handle the event.
     *
     * @param  LoginEvent  $event
     * @return void
     */
    public function handle(LoginEvent $event)
    {
        // 用户信息
        $this->USER = $event->getUser();
        // guard
        $guard = $event->getGuard();
        // status
        $status = $event->getStatus();
        // 后台管理中心登录监听
        if (isset($guard) && $guard == 'admin') {
            if (isset($status) && $status == 'success') { //登录成功
                $this->AdminLoginSuccess($event->getIp());
            } else {//登录失败
                $this->AdminLoginFail();
            }
        } else {
            if (isset($status) && $status == 'success') { //登录成功
                $this->loginSuccess($event->getIp());
            } else {//登录失败
                $this->loginFail();
            }
        }

    }

    /**
     * 后台管理中心登录成功
     * @param $ip
     */
    protected function AdminLoginSuccess($ip)
    {
        $login_info = [
            'login_ip' => $ip,
            'login_time' => date('y-m-d H:i:s', time()),
        ];
        DB::connection($this->CONN_DB)->table($this->ADMIN_TB)->where(['id' => $this->USER->id])->update($login_info);
    }

    /**
     * 后台管理中心登录失败
     */
    protected function AdminLoginFail()
    {
        DB::connection($this->CONN_DB)->table($this->ADMIN_TB)->where(['username' => $this->USER])->increment('login_failure');
    }

    /**
     * 用户登录成功操作
     * @param $ip
     */
    protected function loginSuccess($ip)
    {
        $login_info = [
            'last_login_ip' => $ip,
            'last_login_time' => date('y-m-d H:i:s', time()),
        ];
        $maxSuccessions = $this->USER->max_successions;
        $successions = $this->USER->successions;
        $last_login_time = $this->USER->last_login_time;
        if ($successions < 1) {// 首次登陆
            $login_info['successions'] = 1;
            $login_info['max_successions'] = 1;
        } else {
            if ((new funcUtils())->isSomeday(strtotime($last_login_time), 0) === false) {
                if ((new funcUtils())->isSomeday(strtotime($last_login_time), 1)) {// 连续登陆
                    DB::connection($this->CONN_DB)->table($this->USER_TB)->where(['id' => $this->USER->id])->increment('successions');
                    if ($maxSuccessions < $successions + 1) {
                        $login_info['max_successions'] = $maxSuccessions + 1;
                    }
                } else {
                    $login_info['successions'] = 1;
                }
            }
        }
        DB::connection($this->CONN_DB)->table($this->USER_TB)->where(['id' => $this->USER->id])->update($login_info);
    }

    /**
     * 用户登录失败操作
     */
    protected function loginFail()
    {
        DB::connection($this->CONN_DB)->table($this->USER_TB)->where(['email' => $this->USER])->increment('login_failure');
    }
}
