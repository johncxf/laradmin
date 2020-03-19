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
        // 表前缀
        $prefix = 'la_';
        // 用户表
        if (!Schema::hasTable($prefix.'user')) {
            Schema::create($prefix.'user', function (Blueprint $table) {
                $table->increments('id')->comment('用户ID');
                $table->char('username', 20)->index()->comment('用户名, 不可重复');
                $table->char('mobile', 11)->nullable($value=true)->index()->comment('手机号');
                $table->char('email', 32)->unique()->index()->comment('邮箱');
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
        if (!Schema::hasTable($prefix.'password_resets')) {
            Schema::create($prefix.'password_resets', function (Blueprint $table) {
                $table->string('email',255)->index();
                $table->string('token',255);
                $table->timestamp('created_at')->nullable();
            });
        }
        // 菜单表
        if (!Schema::hasTable($prefix.'menu')) {
            Schema::create($prefix.'menu', function (Blueprint $table) {
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
        if (!Schema::hasTable($prefix.'admin')) {
            Schema::create($prefix.'admin', function (Blueprint $table) {
                $table->increments('id')->comment('ID');
                $table->string('username', 50)->index()->comment('用户名');
                $table->string('password', 255)->comment('密码');
                $table->string('avatar', 255)->nullable($value = true)->comment('头像');
                $table->char('mobile', 11)->index()->comment('手机号');
                $table->char('email', 50)->unique()->index()->comment('邮箱');
                $table->unsignedSmallInteger('login_failure')->default(0)->comment('失败次数');
                $table->dateTime('login_time')->default('2000-01-01 00:00:00')->comment('登录时间');
                $table->ipAddress('login_ip')->default('0.0.0.0')->comment('登录ip');
                $table->string('token', 255)->comment('token');
                $table->unsignedTinyInteger('status')->default(1)->comment('状态：1正常 0拉黑');
                $table->dateTime('create_at')->comment('创建时间');
                $table->dateTime('update_at')->default('2000-01-01 00:00:00')->comment('更新时间');
            });
        }
        // 角色表
        if (!Schema::hasTable($prefix.'role')) {
            Schema::create($prefix.'role', function (Blueprint $table) {
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
        if (!Schema::hasTable($prefix.'role_user')) {
            Schema::create($prefix.'role_user', function (Blueprint $table) {
                $table->unsignedInteger('role_id')->default(0)->comment('角色ID');
                $table->unsignedInteger('user_id')->default(0)->comment('用户ID');
                $table->char('type', 15)->default('admin')->comment('类型：admin，user');
            });
        }
        // 权限授权表
        if (!Schema::hasTable($prefix.'auth_access')) {
            Schema::create($prefix.'auth_access', function (Blueprint $table) {
                $table->unsignedMediumInteger('role_id')->default(0)->comment('角色ID');
                $table->string('rule_name', 255)->comment('规则唯一英文标识,全小写');
            });
        }
        // 配置表
        if (!Schema::hasTable($prefix.'config')) {
            Schema::create($prefix.'config', function (Blueprint $table) {
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
        // 栏目表
        if (!Schema::hasTable($prefix.'category')) {
            Schema::create($prefix.'category', function (Blueprint $table) {
                $table->mediumIncrements('id')->comment('ID');
                $table->char('name', 100)->comment('栏目名称');
                $table->char('alias', 100)->unique()->comment('栏目缩略名');
                $table->char('icon', 30)->nullable($value = true)->comment('图标');
                $table->string('url', 255)->nullable($value = true)->comment('跳转地址');
                $table->unsignedTinyInteger('status')->comment('状态：1显示 0隐藏');
                $table->mediumInteger('pid')->comment('父级栏目ID');
                $table->unsignedMediumInteger('sort')->default(0)->comment('排序');
            });
        }
        // 分类表
        if (!Schema::hasTable($prefix.'item')) {
            Schema::create($prefix.'item', function (Blueprint $table) {
                $table->mediumIncrements('id')->comment('ID');
                $table->char('name', 100)->comment('分类名称');
                $table->string('remark',255)->nullable($value = true)->comment('备注');
                $table->char('type',30)->default('article')->index()->comment('类型:article,resource');
                $table->mediumInteger('pid')->comment('父级分类ID');
            });
        }
        // 标签表
        if (!Schema::hasTable($prefix.'tag')) {
            Schema::create($prefix.'tag', function (Blueprint $table) {
                $table->increments('id')->comment('ID');
                $table->char('name', 100)->comment('标签名称');
                $table->char('type',30)->default('article')->index()->comment('类型:article,resource');
                $table->string('remark',255)->nullable($value = true)->comment('备注');
            });
        }
        // 文章表
        if (!Schema::hasTable($prefix.'article')) {
            Schema::create($prefix.'article', function (Blueprint $table) {
                $table->Increments('id')->comment('ID');
                $table->string('title', 255)->index()->comment('文章标题');
                $table->unsignedInteger('uid')->default(0)->comment('创建者UID');
                $table->string('author', 255)->nullable()->comment('作者');
                $table->mediumInteger('cid')->default(0)->index()->comment('栏目ID');
                $table->text('content')->comment('文章内容');
                $table->string('thumb', 255)->nullable($value = true)->comment('缩略图');
                $table->unsignedTinyInteger('is_top')->default(0)->comment('是否置顶：1是 0否');
                $table->string('remark', 255)->nullable()->comment('摘要');
                $table->unsignedTinyInteger('status')->default(1)->comment('文章状态：1未发布2已发布');
                $table->integer('pv')->default(0)->comment('pv');
                $table->dateTime('create_at')->comment('创建时间');
                $table->dateTime('update_at')->default('2000-01-01 00:00:00')->comment('更新时间');
            });
        }
        // 链接表
        if (!Schema::hasTable($prefix.'link')) {
            Schema::create($prefix.'link', function (Blueprint $table) {
                $table->mediumIncrements('id')->comment('ID');
                $table->string('name', 255)->comment('链接名称');
                $table->string('url', 255)->comment('链接地址');
                $table->string('type', 255)->default('friend')->comment('链接类型：友链 friend');
                $table->string('img', 255)->nullable($value = true)->comment('链接图片');
                $table->string('remark',255)->nullable($value = true)->comment('描述');
            });
        }
        // 用户登录日志表
        if (!Schema::hasTable($prefix.'user_login_log')) {
            Schema::create($prefix.'user_login_log', function (Blueprint $table) {
                $table->integer('uid')->primary()->unsigned()->comment('用户id');
                $table->ipAddress('ip')->index()->comment('ip');
                $table->unsignedTinyInteger('status')->comment('登录状态 1成功 0失败');
                $table->char('type', '30')->default('user')->comment('用户表');
                $table->time('create_time')->comment('时间');
            });
        }
        // 文章分类关联表
        if (!Schema::hasTable($prefix.'article_item_relationship')) {
            Schema::create($prefix.'article_item_relationship', function (Blueprint $table) {
                $table->unsignedInteger('article_id')->index()->default(0)->comment('文章id');
                $table->unsignedMediumInteger('item_id')->index()->default(0)->comment('分类id');
            });
        }
        // 文章标签关联表
        if (!Schema::hasTable($prefix.'article_tag_relationship')) {
            Schema::create($prefix.'article_tag_relationship', function (Blueprint $table) {
                $table->unsignedInteger('article_id')->index()->default(0)->comment('文章id');
                $table->unsignedMediumInteger('tag_id')->index()->default(0)->comment('标签id');
            });
        }
        // 评论表
        if (!Schema::hasTable($prefix.'article_comment')) {
            Schema::create($prefix.'article_comment', function (Blueprint $table) {
                $table->increments('id')->comment('评论id');
                $table->unsignedInteger('article_id')->index()->default(0)->comment('文章id');
                $table->unsignedInteger('uid')->default(0)->comment('评论者uid');
                $table->unsignedInteger('pid')->default(0)->comment('父节点id，为0代表对文章的评论');
                $table->unsignedInteger('target_id')->default(0)->comment('保存被回复者的uid');
                $table->text('content')->comment('评论内容');
                $table->unsignedTinyInteger('status')->default(0)->comment('0未审核1审核通过2审核未通过');
                $table->dateTime('create_at')->comment('发表时间');
            });
        }
        // 验证码表
        if (!Schema::hasTable($prefix.'verify')) {
            Schema::create($prefix.'verify', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('ID');
                $table->unsignedInteger('uid')->default(0)->index()->comment('用户id');
                $table->string('token',255)->comment('验证令牌');
                $table->string('contact')->default('')->comment('联系方式：邮箱号，手机号');
                $table->char('type',50)->default('mail')->comment('验证类型:mail.mobile');
                $table->dateTime('create_at')->nullable()->comment('生成时间');
            });
        }
        // 幻灯片表
        if (!Schema::hasTable($prefix.'slide')) {
            Schema::create($prefix.'slide', function (Blueprint $table) {
                $table->increments('id')->comment('ID');
                $table->char('name',50)->default('')->comment('名称');
                $table->string('content',255)->default('')->comment('图片地址');
                $table->unsignedMediumInteger('sort')->default(0)->comment('排序');
                $table->char('type',30)->default('home')->comment('类型：home');
                $table->unsignedTinyInteger('status')->default(0)->comment('状态：1显示0隐藏');
            });
        }
        // 文章收藏表
        if (!Schema::hasTable($prefix.'article_star')) {
            Schema::create($prefix.'article_star', function (Blueprint $table) {
                $table->unsignedInteger('uid')->default(0)->comment('用户id');
                $table->unsignedInteger('article_id')->default(0)->comment('文章id');
                $table->dateTime('create_at')->nullable()->comment('时间');
            });
        }
        // 文章点赞表
        if (!Schema::hasTable($prefix.'article_praise')) {
            Schema::create($prefix.'article_praise', function (Blueprint $table) {
                $table->unsignedInteger('uid')->default(0)->comment('用户id');
                $table->unsignedInteger('article_id')->default(0)->comment('文章id');
                $table->dateTime('create_at')->nullable()->comment('时间');
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
