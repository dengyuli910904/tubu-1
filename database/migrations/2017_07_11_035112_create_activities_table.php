<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('groups_id');//圈子id
            $table->string('users_id');//用户id
            $table->string('cover');//活动封面
            $table->string('title');//活动标题
            $table->text('content')->nullable();//活动内容
            $table->text('cost_intro')->nullable();//活动费用说明
            $table->integer('status')->default(1);//用户状态 0 禁用 1启用
            $table->timestamp('starttime')->nullable();//活动开始时间
            $table->timestamp('endtime')->nullable();//活动结束时间
            $table->timestamp('enrol_starttime')->nullable();//活动报名开始时间
            $table->timestamp('enrol_endtime')->nullable();//活动报名结束时间
            $table->string('contacts')->nullable();//活动联系人名
            $table->string('contacts_tel')->nullable();//活动联系人电话
            $table->double('cost')->default(0);//活动费用
            $table->integer('limit_count')->default(100);//活动限制人数
            $table->integer('participation_count')->default(0);//参与人数
            $table->integer('apply_count')->default(0);//报名人数
            $table->integer('follow_count')->default(0);//关注人数
            $table->integer('collect_count')->default(0);//收藏人数
            $table->integer('status')->default(0);//默认活动状态，0 未发布状态
            $table->string('keywords')->nullable();//活动关键词
            $table->integer('category_id')->default(1);//活动类型
            $table->text('comment')->nullable();//活动备注
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activities');
    }
}
