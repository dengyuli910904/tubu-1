<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupmemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupmember', function (Blueprint $t) {
            $t->string('id')->uniqid();//采用uuid
            $t->integer('role')->default(0);//成员角色 0 普通成员 1 副圈主
            $t->string('groups_id');//圈子id
            $t->string('users_id');//用户id
            $t->integer('status')->default(1);//用户状态 0 禁用 1启用
            $t->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('groupmember');
    }
}
