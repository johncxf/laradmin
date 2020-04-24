<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTable extends Migration
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

    }
}
