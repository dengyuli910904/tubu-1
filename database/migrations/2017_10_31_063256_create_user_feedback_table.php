<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFeedbackTable extends Migration
{
    /**
     * 创建App用户反馈表，用户web端用户留言使用
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leavemsg',function(Blueprint $table){
            $table->string('id')->uniqid();
            $table->string('content');
            $table->integer('starnum')->defaut(1);
            $table->integer('is_hidden')->default(0);//默认显示，1为不显示
            $table->string('username')->nullable();//
            $table->string('telphone')->nullable();
//            $table->json('others')->ablenull();
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
        //
    }
}
