<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsApplyTable extends Migration
{
    /**
     * 圈子用户申请表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_apply', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('groups_id');//活动id
            $table->string('user_id');//用户id
            $table->integer('status')->default(0);//申请状态 0 未审核 1审核通过 2 审核不通过
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
        Schema::dropIfExists('groups_apply');
    }
}
