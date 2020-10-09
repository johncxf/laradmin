<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        factory(App\User::class, 100)->create();
//        $user = \App\User::find(1);
//        $user->name = '一切随风';
//        $user->email = 'admin@163.com';
//        $user->password = bcrypt('123456');
//        $user->is_admin = true;
//        $user->save();
        $CONN_DB = 'mysql_laradmin';
        $USERS_TB = 'user';
        $ADMIN_TB = 'admin';
        $ROLE_TB = 'role';
        $ROLE_USER_TB = 'role_user';
        $USERS_ACCOUNT_TB = 'user_account';
        $admin = [
            'username' => 'Administrator',
            'avatar' => 'img/default/avatar.jpg',
            'password' => bcrypt('admin_123456'),
            'mobile' => '13777777777',
            'email' => 'admin@qq.com',
            'token' => '123456',
            'create_at' => date('Y-m-d H:i:s', time())
        ];
        $admin_id = DB::connection($CONN_DB)->table($ADMIN_TB)->insertGetId($admin);
        $role = [
            'name' => '超级管理员',
            'pid' => 0,
            'status' => 1,
            'remark' => '拥有最高管理权限',
            'create_time' => date('Y-m-d H:i:s', time()),
            'listorder' => 0
        ];
        $role_id = DB::connection($CONN_DB)->table($ROLE_TB)->insertGetId($role);
        $role_user = [
            'role_id' => $role_id,
            'user_id' => $admin_id,
            'type' => 'admin'
        ];
        DB::connection($CONN_DB)->table($ROLE_USER_TB)->insert($role_user);
        $user = [
            'username' => 'Administrator',
            'password' => bcrypt('admin_123456'),
            'mobile' => '13777777777',
            'email' => 'admin@qq.com',
            'nickname' => '一切随风',
            'avatar' => '',
            'birthday' => '2000-01-01',
            'signature' => '非淡泊无以明志，非宁静无以致远',
            'create_time' => date('Y-m-d H:i:s', time())
        ];
        $user_id = DB::connection($CONN_DB)->table($USERS_TB)->insertGetId($user);
        $user_account = [
            'uid' => $user_id,
            'money' => 0.00,
            'frozen_money' => 0.00,
            'gold' => 0,
            'score' => 0
        ];
        DB::connection($CONN_DB)->table($USERS_ACCOUNT_TB)->insert($user_account);
    }

}
