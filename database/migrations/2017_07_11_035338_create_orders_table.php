<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * 订单表
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('activities_id');//活动id
            $table->string('user_id');//用户id
            $table->string('comment')->nullable();//备注
            $table->string('ordernum')->nullable();//支付编号
            $table->integer('status')->nullable();//z支付状态码
            $table->string('title')->nullable();//订单标题
            $table->integer('is_valid')->default(0);// 0 未验证，1已验证
            $table->string('channel',20)->default('');//支付方式 alipay,wx
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
        Schema::dropIfExists('orders');
    }
}
