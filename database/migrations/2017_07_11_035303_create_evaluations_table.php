<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * 活动评价表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('activities_id');//圈子id
            $table->string('users_id');//用户id
            $table->text('content')->nullable();//评价内容
            $table->integer('starlevel')->default(0);//星级
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
        Schema::dropIfExists('evaluations');
    }
}
