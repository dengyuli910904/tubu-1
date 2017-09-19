<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepCountingTable extends Migration
{
    /**
     * Run the migrations.
     *  计步表格
     * @return void
     */
    public function up()
    {
        Schema::create('step_counting',function(Blueprint $table){
            $table->string('id')->uniqid();
            $table->string('users_id');
            $table->string('count')->default(0);//计步数
            $table->timestamp('start_time')->nullable();//开始时间
            $table->timestamp('end_time')->nullable();//结束时间
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
