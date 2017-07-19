<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsFollowTable extends Migration
{
    /**
     * 我关注的圈子
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groups_follow', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('groups_id');//圈子id
            $table->string('user_id');//用户id
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
        Schema::dropIfExists('groups_follow');
    }
}
