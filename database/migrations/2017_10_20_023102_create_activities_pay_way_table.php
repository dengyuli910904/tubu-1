<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesPayWayTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_pay_way',function(Blueprint $table){
            $table->integer('id')->uniqid();
            $table->integer('code')->uniqid();
            $table->string('name')->uniqid();
            $table->integer('is_hidden')->default(0);// 是否隐藏 ；0：不隐藏，1：隐藏
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
