<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $CONN_DB = 'mysql_laradmin';
        $CONFIG_TB = 'config';

        $config = [
            [
                'name' => 'name',
                'title' => 'Site name',
                'tip' => '请填写站点名称',
                'type' => 'string',
                'value' => 'Laradmin',
                'content' => '',
                'rule' => 'required',
                'extend' => '',
            ],
            [
                'name' => 'beian',
                'title' => 'Beian',
                'tip' => '浙ICP备17055405号',
                'type' => 'string',
                'value' => '浙ICP备17055405号',
                'content' => '',
                'rule' => '',
                'extend' => '',
            ],
            [
                'name' => 'mail_type',
                'title' => 'Mail type',
                'tip' => '选择邮件发送方式',
                'type' => 'select',
                'value' => '1',
                'content' => '["Please select","SMTP","Mail"]',
                'rule' => '',
                'extend' => '',
            ],
            [
                'name' => 'mail_smtp_host',
                'title' => 'Mail smtp host',
                'tip' => '错误的配置发送邮件会导致服务器超时',
                'type' => 'string',
                'value' => 'smtp.qq.com',
                'content' => '',
                'rule' => '',
                'extend' => '',
            ],
            [
                'name' => 'mail_smtp_port',
                'title' => 'Mail smtp port',
                'tip' => '(不加密默认25,SSL默认465,TLS默认587)',
                'type' => 'string',
                'value' => '465',
                'content' => '',
                'rule' => '',
                'extend' => '',
            ],
            [
                'name' => 'mail_smtp_user',
                'title' => 'Mail smtp user',
                'tip' => '（填写完整用户名）',
                'type' => 'string',
                'value' => '10000',
                'content' => '',
                'rule' => '',
                'extend' => '',
            ],
            [
                'name' => 'mail_smtp_pass',
                'title' => 'Mail smtp password',
                'tip' => '（填写您的密码）',
                'type' => 'string',
                'value' => 'password',
                'content' => '',
                'rule' => '',
                'extend' => '',
            ],
            [
                'name' => 'mail_verify_type',
                'title' => 'Mail vertify type',
                'tip' => '（SMTP验证方式[推荐SSL]）',
                'type' => 'select',
                'value' => '2',
                'content' => '["None","TLS","SSL"]',
                'rule' => '',
                'extend' => '',
            ],
            [
                'name' => 'mail_from',
                'title' => 'Mail from',
                'tip' => '',
                'type' => 'string',
                'value' => '1448726891@qq.com',
                'content' => '',
                'rule' => '',
                'extend' => '',
            ],
        ];
        DB::connection($CONN_DB)->table($CONFIG_TB)->insert($config);
    }
}
