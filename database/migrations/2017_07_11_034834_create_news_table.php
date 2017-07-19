<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('users_id');//消息发送人id
            $table->string('content');//消息内容
            $table->string('tag')->nullable();//消息标签
            $table->string('groups_id');//所属圈子id
            $table->string('activities_id');//活动id
            $table->integer('status')->default(1);//默认显示
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
        Schema::dropIfExists('news');
    }
}
