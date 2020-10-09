<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 数据库
        $CONN_DB = 'mysql_laradmin';
        // 第三方用户表
        if (!Schema::connection($CONN_DB)->hasTable('app')) {
            Schema::connection($CONN_DB)->create('app', function (Blueprint $table) {
                $table->increments('app_id');
                $table->unsignedTinyInteger('type')->comment('APP类型: 1.Android 2.IOS 3.WinPhone 4.WebApp 5.SmallApp');
                $table->string('name',20)->comment('app类型名称');
                $table->string('introduce',255)->comment('应用介绍');
                $table->string('small_app_id',32)->comment('小程序id');
                $table->string('small_app_secret',32)->comment('小程序密钥');
                $table->string('url',255)->comment('应用地址');
                $table->unsignedTinyInteger('status')->default(1)->comment('1正常0删除');
                $table->dateTime('create_at')->nullable()->comment('创建时间');
                $table->dateTime('update_at')->nullable()->comment('更新时间');
            });
        }
        // 第三方用户表
        if (!Schema::connection($CONN_DB)->hasTable('oauth_user')) {
            Schema::connection($CONN_DB)->create('oauth_user', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('from',30)->comment('用户来源');
                $table->string('name',30)->comment('第三方昵称');
                $table->string('head_img',255)->comment('头像');
                $table->unsignedInteger('uid')->default(0)->comment('本站用户id');
                $table->dateTime('create_at')->comment('绑定时间');
                $table->dateTime('last_login_time')->comment('最后登录时间');
                $table->ipAddress('last_login_ip')->comment('最后登录ip地址');
                $table->unsignedTinyInteger('status')->default(1)->comment('用户状态：1正常');
                $table->string('access_token',255)->comment('令牌');
                $table->unsignedInteger('expire_at')->comment('access_token过期时间');
                $table->string('openid',50)->comment('第三方用户id');
                $table->string('unionid',32)->comment('联合id');
            });
        }
        // 微信小程序授权表
        if (!Schema::connection($CONN_DB)->hasTable('app_smallapp_session')) {
            Schema::connection($CONN_DB)->create('app_smallapp_session', function (Blueprint $table) {
                $table->bigIncrements('session_id');
                $table->unsignedMediumInteger('app_id')->default(0)->comment('应用id');
                $table->unsignedInteger('uid')->default(0)->comment('本站用户id');
                $table->string('openid',32)->comment('第三方用户id');
                $table->string('unionid',32)->comment('联合id');
                $table->string('session_key',60)->comment('秘钥');
                $table->string('token',255)->comment('令牌');
                $table->unsignedInteger('expire_at')->comment('token过期时间');
                $table->dateTime('create_at')->nullable()->comment('创建时间');
                $table->dateTime('update_at')->nullable()->comment('更新时间');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app');
    }
}
