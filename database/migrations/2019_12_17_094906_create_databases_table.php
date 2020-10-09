<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatabasesTable extends Migration
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
        // 用户表
        if (!Schema::connection($CONN_DB)->hasTable('user')) {
            Schema::connection($CONN_DB)->create('user', function (Blueprint $table) {
                $table->increments('id')->comment('用户ID');
                $table->char('username', 20)->index()->comment('用户名, 不可重复');
                $table->char('mobile', 11)->nullable($value=true)->index()->comment('手机号');
                $table->char('email', 32)->nullable()->unique()->index()->comment('邮箱');
                $table->timestamp('email_verified_at')->nullable()->comment('邮箱验证时间');
                $table->string('password',255)->comment('密码');
                $table->char('nickname', 20)->index()->comment('用户昵称');
                $table->string('avatar', 255)->nullable($value=true)->comment('用户头像地址');
                $table->unsignedTinyInteger('level')->default(0)->comment('等级');
                $table->unsignedTinyInteger('sex')->default(0)->comment('性别；0：保密，1：男；2：女');
                $table->date('birthday')->nullable($value=true)->comment('生日');
                $table->string('signature', 255)->nullable($value=true)->comment('个性签名');
                $table->unsignedTinyInteger('user_status')->default(1)->comment('用户状态 0：禁用； 1：正常');
                $table->unsignedTinyInteger('mobile_status')->default(0)->comment('手机号验证状态:0未验证1已验证');
                $table->unsignedTinyInteger('user_type')->default(2)->comment('用户类型，1:admin ;2:会员');
                $table->integer('successions')->default(0)->comment('连续登录天数');
                $table->integer('max_successions')->default(0)->comment('最大连续登录天数');
                $table->smallInteger('login_failure')->default(0)->comment('失败次数');
                $table->ipAddress('last_login_ip')->nullable($value=true)->comment('最后登录ip');
                $table->dateTime('last_login_time')->default('2000-01-01 00:00:00')->comment('最后登录时间');
                $table->rememberToken();
                $table->dateTime('create_time')->default('2000-01-01 00:00:00')->comment('注册时间');
                $table->dateTime('update_time')->default('2000-01-01 00:00:00')->comment('更新时间');
            });
        }
        // 密码重置表
        if (!Schema::connection($CONN_DB)->hasTable('password_resets')) {
            Schema::connection($CONN_DB)->create('password_resets', function (Blueprint $table) {
                $table->string('email',255)->index();
                $table->string('token',255);
                $table->timestamp('created_at')->nullable();
            });
        }
        // 菜单表
        if (!Schema::connection($CONN_DB)->hasTable('menu')) {
            Schema::connection($CONN_DB)->create('menu', function (Blueprint $table) {
                $table->smallIncrements('id')->comment('ID');
                $table->smallInteger('parentId')->default(0)->comment('父级ID');
                $table->char('module', 20)->comment('模块');
                $table->string('permission', 255)->comment('权限名称(模块::一级菜单/控制器@方法)');
                $table->string('url',255)->comment('url');
                $table->char('name', 50)->comment('名称');
                $table->char('icon', 50)->comment('图标');
                $table->unsignedTinyInteger('type')->default(0)->comment('菜单类型 1：权限认证+菜单；0：只作为菜单');
                $table->unsignedTinyInteger('status')->default(1)->comment('状态，1显示，0不显示');
                $table->string('remark', 255)->comment('备注');
                $table->smallInteger('sort')->default(0)->comment('排序');
            });
        }
        // 管理员表
        if (!Schema::connection($CONN_DB)->hasTable('admin')) {
            Schema::connection($CONN_DB)->create('admin', function (Blueprint $table) {
                $table->increments('id')->comment('ID');
                $table->string('username', 50)->index()->comment('用户名');
                $table->string('password', 255)->comment('密码');
                $table->string('avatar', 255)->nullable($value = true)->comment('头像');
                $table->char('mobile', 11)->index()->comment('手机号');
                $table->char('email', 50)->unique()->index()->comment('邮箱');
                $table->unsignedSmallInteger('login_failure')->default(0)->comment('失败次数');
                $table->dateTime('login_time')->default('2000-01-01 00:00:00')->comment('登录时间');
                $table->ipAddress('login_ip')->default('0.0.0.0')->comment('登录ip');
                $table->string('token', 255)->nullable()->comment('token');
                $table->unsignedTinyInteger('status')->default(1)->comment('状态：1正常 0拉黑');
                $table->dateTime('create_at')->comment('创建时间');
                $table->dateTime('update_at')->default('2000-01-01 00:00:00')->comment('更新时间');
            });
        }
        // 角色表
        if (!Schema::connection($CONN_DB)->hasTable('role')) {
            Schema::connection($CONN_DB)->create('role', function (Blueprint $table) {
                $table->mediumIncrements('id')->comment('ID');
                $table->string('name', 20)->comment('角色名称');
                $table->unsignedSmallInteger('pid')->default(0)->comment('父级ID');
                $table->unsignedTinyInteger('status')->default(1)->comment('状态：1开启 0禁用');
                $table->string('remark', 255)->comment('备注');
                $table->dateTime('create_time')->nullable()->comment('创建时间');
                $table->dateTime('update_time')->nullable()->comment('更新时间');
                $table->smallInteger('listorder')->default(0)->comment('排序');
            });
        }
        // 用户角色对应表
        if (!Schema::connection($CONN_DB)->hasTable('role_user')) {
            Schema::connection($CONN_DB)->create('role_user', function (Blueprint $table) {
                $table->unsignedInteger('role_id')->default(0)->comment('角色ID');
                $table->unsignedInteger('user_id')->default(0)->comment('用户ID');
                $table->char('type', 15)->default('admin')->comment('类型：admin，user');
            });
        }
        // 权限授权表
        if (!Schema::connection($CONN_DB)->hasTable('auth_access')) {
            Schema::connection($CONN_DB)->create('auth_access', function (Blueprint $table) {
                $table->unsignedMediumInteger('role_id')->default(0)->comment('角色ID');
                $table->string('rule_name', 255)->comment('规则唯一英文标识,全小写');
            });
        }
        // 配置表
        if (!Schema::connection($CONN_DB)->hasTable('config')) {
            Schema::connection($CONN_DB)->create('config', function (Blueprint $table) {
                $table->increments('id')->comment('ID');
                $table->string('name', 30)->comment('变量名');
                $table->string('title', 100)->comment('变量标题');
                $table->string('tip', 100)->comment('变量描述');
                $table->string('type', 30)->comment('类型:string,text,int,bool,array,datetime,date,file');
                $table->text('value')->comment('变量值');
                $table->text('content')->comment('变量字典数据');
                $table->string('rule', 100)->comment('验证规则');
                $table->string('extend', 255)->comment('扩展属性');
            });
        }

        // 用户登录日志表
        if (!Schema::connection($CONN_DB)->hasTable('user_login_log')) {
            Schema::connection($CONN_DB)->create('user_login_log', function (Blueprint $table) {
                $table->integer('uid')->primary()->unsigned()->comment('用户id');
                $table->ipAddress('ip')->index()->comment('ip');
                $table->unsignedTinyInteger('status')->comment('登录状态 1成功 0失败');
                $table->char('type', '30')->default('user')->comment('用户表');
                $table->time('create_time')->comment('时间');
            });
        }

        // 验证码表
        if (!Schema::connection($CONN_DB)->hasTable('verify')) {
            Schema::connection($CONN_DB)->create('verify', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('ID');
                $table->unsignedInteger('uid')->default(0)->index()->comment('用户id');
                $table->string('token',255)->comment('验证令牌');
                $table->string('contact')->default('')->comment('联系方式：邮箱号，手机号');
                $table->char('type',50)->default('mail')->comment('验证类型:mail.mobile');
                $table->dateTime('create_at')->nullable()->comment('生成时间');
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
        //
    }
}
