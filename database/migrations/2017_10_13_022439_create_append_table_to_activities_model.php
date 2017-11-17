<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppendTableToActivitiesModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建活动签到、活动认领模块相关数据表
        //1、活动角色表
        Schema::create('activities_role',function(Blueprint $table){
            $table->string('id')->uniqid();//
            $table->string('code')->uniqid();//权限code
            $table->string('name');//权限名称
            $table->integer('is_hidden')->default(0);//是否隐藏，默认0不隐藏， 1隐藏
            $table->timestamps();
        });
        //2、俱乐部角色表
        Schema::create('groups_role',function(Blueprint $table){
            $table->string('id')->uniqid();
            $table->string('code')->uniqid();//权限code
            $table->string('name');//权限名称
            $table->integer('is_hidden')->default(0);//是否隐藏，默认0不隐藏， 1隐藏
            $table->timestamps();
        });
        //3、活动与角色关联表
        Schema::create('activities_role_user',function(Blueprint $table){
            $table->string('id')->uniqid();
            $table->string('activities_id');//活动id
            $table->string('users_id');//用户id
            $table->string('activities_role_id');//角色id
            $table->string('is_hidden')->default(0);//是否隐藏，默认0不隐藏， 1隐藏
            $table->timestamps();
        });
        //4、俱乐部与角色关联表
         Schema::create('',function(Blueprint $table){
            $table->string('id')->uniqid();
            $table->string('groups_id');//俱乐部id
            $table->string('users_id');//用户id
            $table->string('groups_role_id');//俱乐部角色id
            $table->string('is_hidden')->default(0);//是否隐藏，默认0不隐藏， 1隐藏
            $table->timestamps();
        });
        //5、活动用户签到表
         Schema::create('activities_sign',function(Blueprint $table){
            $table->string('id')->uniqid();
            $table->string('activities_id');//活动id
            $table->string('users_id');//签到用户id
            // $table->string('sign_time');//签到时间，可以考虑按时间戳方式

            $table->timestamps();
         });
        //6、签到规则表
         Schema::create('activities_sign_rule',function(Blueprint $table){
            $table->string('id')->uniqid();
            $table->string('activities_id');//活动id
            $table->timestamp('deadline')->nullable();//签到截止时间
            $table->integer('publishway')->default(0);//惩罚方式，0 不惩罚，1 按分钟罚款，2按小时罚款
            $table->double('publish_num')->default(0);//惩罚单位金额，根据惩罚方式的单位内 金额数
            $table->timestamps();
         });
        //7、活动任务认领申请表
         Schema::create('activities_role_apply',function(Blueprint $table){
            $table->string('id')->uniqid();
            $table->string('activities_id');//活动id
            $table->string('users_id');//用户id
            $table->string('activities_role_id');//申请角色id
            $table->integer('is_pass')->default(0);//是否已经审核 0 未审核， 1 审核通过 ，2 审核不通过
            $table->timestamps();
         });
        //8、
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
