<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVerifycodeTable extends Migration
{
    /**
     * 验证码发送表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('verifycode', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('phone');//圈子id
            $table->string('code');//用户id
            $table->string('comment')->nullable();//备注
            $table->integer('is_valid')->default(0);// 0 未验证，1已验证
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
        Schema::dropIfExists('verifycode');
    }
}
