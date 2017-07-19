<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivitiesFollowTable extends Migration
{
    /**
     * 我关注的活动
     *
     * @return void
     */
    public function up()
    {
        Schema::create('activities_follow', function (Blueprint $table) {
            $table->string('id')->uniqid();//采用uuid
            $table->string('activities_id');//活动id
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
        Schema::dropIfExists('activities_follow');
    }
}
