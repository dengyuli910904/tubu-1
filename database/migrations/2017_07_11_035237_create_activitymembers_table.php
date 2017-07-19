<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitymembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activitymembers', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('activities_id');//圈子id
            $table->integer('role')->default(0);//成员角色 0 普通成员 1 副领队
            $table->string('users_id');//用户id
            $table->integer('is_pay')->default(0);//是否已经支付 0未支付 1已经付
            $table->integer('pay_path');// 支付方式， 正常支付，后台支付
            $table->string('comment');//备注
            $table->integer('status')->default(1);//用户状态 0 禁用 1启用
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
        Schema::dropIfExists('activitymembers');
    }
}
