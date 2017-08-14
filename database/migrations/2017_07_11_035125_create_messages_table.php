<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('users_id');//用户id
            $table->text('content')->nullable();//活动留言内容
            $table->integer('status')->default(0);//默认显示，1不显示
            $table->string('activites_id');//活动id 
            $table->string('parent_id')->nullable();//若为活动留言，则为空，若留言回复，则填入留言的id
            // $table->string('replay_users_id')->nullable();//活动留言回复人，若为留言则为空，若为留言回复则为回复人id
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
        Schema::dropIfExists('messages');
    }
}
