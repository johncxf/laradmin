<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceTable extends Migration
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
        // 资源表
        if (!Schema::hasTable($prefix.'resource')) {
            Schema::create($prefix.'resource', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('ID');
                $table->string('title',255)->default('')->comment('资源名称');
                $table->unsignedInteger('uid')->default(0)->comment('用户id');
                $table->string('content',255)->default('')->comment('内容');
                $table->string('ext',30)->nullable()->comment('文件后缀名');
                $table->integer('size')->default(0)->comment('大小，单位字节');
                $table->char('type',30)->default('default')->comment('类别：file:文档,picture:图片,default:其他');
                $table->unsignedMediumInteger('item_id')->default(0)->comment('所属分类id');
                $table->string('remark',255)->default('')->comment('描述');
                $table->unsignedTinyInteger('status')->default(0)->comment('1显示0隐藏');
                $table->unsignedMediumInteger('gold')->default(0)->comment('所需积分/金币');
                $table->dateTime('create_at')->nullable()->comment('上传时间');
            });
        }
        // 资源标签关联表
        if (!Schema::hasTable($prefix.'resource_tag_relationship')) {
            Schema::create($prefix.'resource_tag_relationship', function (Blueprint $table) {
                $table->unsignedInteger('resource_id')->index()->default(0)->comment('文章id');
                $table->unsignedMediumInteger('tag_id')->index()->default(0)->comment('标签id');
            });
        }
        // 资源收藏表
        if (!Schema::hasTable($prefix.'resource_star')) {
            Schema::create($prefix.'resource_star', function (Blueprint $table) {
                $table->unsignedInteger('uid')->default(0)->comment('用户id');
                $table->unsignedInteger('rid')->default(0)->comment('资源id');
                $table->dateTime('create_at')->nullable()->comment('时间');
            });
        }
        // 资源下载表
        if (!Schema::hasTable($prefix.'download')) {
            Schema::create($prefix.'download', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('下载id');
                $table->unsignedInteger('uid')->default(0)->comment('用户id');
                $table->unsignedInteger('rid')->default(0)->comment('资源id');
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
