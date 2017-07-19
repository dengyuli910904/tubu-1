<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('name');//圈子名称
            $table->string('intro');//圈子简介
            $table->string('cover');//圈子封面
            $table->integer('member_count')->default(0);//圈子成员数
            $table->integer('activities_count')->default(0);//圈子活动总数
            $table->integer('focus_count')->default(0);//关注人数
            $table->string('address')
            $table->string('users_id')->nullable();//创建者id
            $table->int('score')->default(10);//圈子分数，以分数来区分等级
            $table->integer('status')->default(1);//默认正常 0 禁用 1启用
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
        Schema::dropIfExists('groups');
    }
}
