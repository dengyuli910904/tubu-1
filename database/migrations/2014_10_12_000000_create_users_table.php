<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->string('id')->uniqid(); //采用uuid形式
            $table->string('name');
            $table->string('headimg')->nullable();//用户头像
            $table->string('pwd');//->unique();
            $table->timestamp('birthdate');
            $table->string('address')->nullable();//
            $table->boolean('sex')->default(1);//性别，0为女 1为男
            $table->string('telphone');//联系电话
            $table->string('email')->nullable();//邮箱
            $table->string('wx_openid')->nullable();//微信绑定id
            $table->string('sina_openid')->nullable();//微博绑定id
            $table->string('qq_openid')->nullable();//qq绑定id
            $table->string('solt');//密码验证
            // $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
