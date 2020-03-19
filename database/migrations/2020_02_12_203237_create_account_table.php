<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccountTable extends Migration
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
        // 用户余额表
        if (!Schema::hasTable($prefix.'user_account')) {
            Schema::create($prefix.'user_account', function (Blueprint $table) {
                $table->unsignedInteger('uid')->primary()->comment('用户id');
                $table->decimal('money',10,2)->default(0.00)->comment('可用金额');
                $table->decimal('frozen_money',10,2)->default(0.00)->comment('冻结金额');
                $table->unsignedInteger('gold')->default(0)->comment('金币数量');
                $table->unsignedInteger('score')->default(0)->comment('总积分');
            });
        }
        // 积分记录表
        if (!Schema::hasTable($prefix.'user_gold_log')) {
            Schema::create($prefix.'user_gold_log', function (Blueprint $table) {
                $table->bigIncrements('id')->comment('id');
                $table->unsignedInteger('uid')->default(0)->comment('用户uid');
                $table->unsignedMediumInteger('gold')->default(0)->comment('金币记录');
                $table->unsignedTinyInteger('type')->default(0)->comment('金币类型:1奖励,2消耗');
                $table->char('cate',30)->default('')->comment('类型');
                $table->char('source',30)->default('')->comment('奖励/消耗方式');
                $table->char('source_id',30)->default('')->comment('单号ID');
                $table->unsignedInteger('gold_before')->default(0)->comment('记录产生前余额');
                $table->unsignedInteger('gold_after')->default(0)->comment('记录产生后余额');
                $table->string('remark',255)->nullable()->comment('备注');
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
//        Schema::dropIfExists('account');
    }
}
