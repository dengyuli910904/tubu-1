<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

// $api->version('v1', function ($api) {
//     $api->resource('group','App\API\GroupsController');
// });

$api->version('v1',function($api){
	//圈子接口
	$api->group(['namespace' => 'App\Http\Controllers\API','prefix'=>'groups'], function ($api) {
		//圈子列表，用于发布活动用，@param users_id
		$api->get('/lists','GroupsController@groups');
		//获取所有的圈子,圈子列表（首页） @param users_id,searchtxt
		$api->get('/getlist','GroupsController@index');
		//圈子详情,@param id(圈子id),users_id(用户uid),
		$api->get('/info','GroupsController@show');
		//编辑圈子信息,@param id(圈子id),name(圈子名称),intro(圈子简介),address(圈子地址),cover(圈子封面图url)
		$api->put('/edit','GroupsController@edit');
		//创建圈子，发送到后台进行审核 @param name(名称),intro(简介),address(地址)，cover(封面图url)
		$api->post('/create','GroupsController@store');
		//获取圈子用户列表 @param id(圈子id)，users_id(登陆用户id)
		$api->get('/members','GroupsController@members');

		//用户申请加入圈子 @param users_id(申请用户id)，groups_id 圈子id
		$api->post('/applys','GroupsApplyController@store');
		//用户被邀请进入圈子 @param users_id 当前登录用户id ，invite_users_id //被邀请用户id
		$api->post('/invite','GroupsApplyController@invite');
		//审核用户加入圈子 @param id(申请记录id)，status(1 通过，2不通过)

		$api->put('/doapply','GroupsApplyController@update');

		//设置成为领队 @param groups_id(圈子id)，users_id(成员id)
		$api->put('/setrole','GroupsMemberController@setrole');
		//设置成为领队 @param groups_id(圈子id)，users_id(成员id)

		$api->put('/setleader','GroupsMemberController@setleader');
		//设置圈子领队成为普通圈子成员@param groups_id(圈子id)，users_id(成员id)
		$api->put('/cancelrole','GroupsMemberController@cancelrole');
		//关注圈子
		$api->post('/follow','GroupsFollowController@store');
		//取消圈子
		$api->delete('/follow','GroupsFollowController@destory');
		//获取圈子的活动列表
		$api->get('/groups_act','ActivitiesController@groups_act');
	});

	//活动接口
	$api->group(['namespace' => 'App\Http\Controllers\API','prefix'=>'activities'], function ($api) {
		//获取活动列表 @param searchtxt(搜索关键词,若无搜索则可以不用传参)，users_id(当前登录用户id)
		$api->get('/activities','ActivitiesController@index');
		//活动详情 @param id (活动id)，users_id(当前登录用户id)
		$api->get('/info','ActivitiesController@show');
		//添加活动信息,groups_id 圈子id，keywords 活动关键词，cover 活动封面
		$api->post('/store_partone','ActivitiesController@store_part1');
		//修改活动信息1 @param id(活动id，若为第一次添加则不需要传此参数)，groups_id 圈子id，keywords 活动关键词，cover 活动封面
		$api->put('/store_partone','ActivitiesController@store_part1');
		//修改活动信息2 @param id(活动id)，title(活动标题)，starttime(活动开始时间)，endtime(活动结束时间)，limit_count(活动人数上限)
		$api->put('/store_parttwo','ActivitiesController@store_part2');
		//修改活动信息3 @param id(活动id)，contacts(活动联系人)，contacts_tel(联系人电话)，content(活动内容)
		$api->put('/store_partthree','ActivitiesController@store_part3');
		//修改活动信息4 @param id(活动id)，cost(活动费用)，cost_intro(费用说明)
		$api->put('/store_partfour','ActivitiesController@store_part4');
		//修改活动状态 @param id(活动id)，step(活动状态 1 正式发布，2结束报名状态，3 取消活动，4 活动结束)，users_id 当前登录用户id 
		$api->put('/setstatus','ActivitiesController@update');
		//搜索用户（在prefix为users中）
		//关注活动
		$api->post('/follow','ActivitiesFollowController@store');
		//取消关注
		$api->delete('/follow','ActivitiesFollowController@destory');
		//收藏活动
		$api->post('/collect','ActivitiesCollectController@store');
		//取消关注
		$api->delete('/collect','ActivitiesCollectController@destory');
	});
	//活动留言

	$api->group(['namespace'=>'App\Http\Controllers\API','prefix'=>'messages'],function($api){

		//活动留言列表 @param activites_id(活动id)，users_id(当前用户id)
		$api->get('/lists','MessagesController@index');
		//设置留言显示状态 @param id(留言id)，status(留言状态，0 显示 ，1不显示)
		$api->put('/setstatus','MessagesController@update');
		//回复活动留言/发布活动留言 @param users_id(当前登录用户id)，content(留言内容)，activites_id(活动id)，parent_id(若留言则不传该参数，若为回复则传入参数)
		$api->post('/leavemsg','MessagesController@store');
		
	});
	//活动评价

	$api->group(['namespace'=>'App\Http\Controllers\API','prefix'=>'evaluations'],function($api){

		//获取活动评价列表 @param activites_id(活动id)，users_id 当前登陆用户id
		$api->get('/lists','EvaluationsController@index');
		//活动评价 @param users_id(当前登陆id)，content(评价内容)，activities_id(活动id)，starlevel(评价星级)
		$api->post('/publish','EvaluationsController@store');
		//设置活动评价显示状态 id(评价id)，users_id(当前登陆用户id)，status(状态 0 显示 1不显示)
		$api->post('/setstatus','EvaluationsController@update');
		
	});
	//活动成员
	$api->group(['namespace' => 'App\Http\Controllers\API','prefix'=>'amembers'], function ($api) {
		//获取活动成员列表 @activities_id(活动id),users_id (当前登录用户id)，searchtxt(搜索关键字，若不搜索则不需要传参)
		$api->get('/members','AcitivityMemberController@index');
		//设置成员付费状态 @param users_id(成员id)，activities_id(活动id)
		$api->put('/changefee','AcitivityMemberController@update');
		//用户参与活动 @param activities_id(活动id),users_id(当前登陆用户id)，comment(备注)
		$api->post('/takein','AcitivityMemberController@store');
		//设置成员副领队身份 @param users_id(成员id)，activities_id(活动id)
		$api->put('/setrole','AcitivityMemberController@store');
	});


	//我的
	$api->group(['namespace'=> 'App\Http\Controllers\API','prefix' => 'user'],function($api){
		//登录
		$api->post('/login','UsersController@login');
		//注册
		$api->post('/register','UsersController@register');
		//我的消息
		$api->get('/messages','UsersController@myMesage');
		//我的评价
		$api->get('/comments','UsersController@myComment');
		//我的回复
		$api->get('/replies','UsersController@myReply');
		//我的活动
		$api->get('/activities','UsersController@myActivity');
		//我的圈子
		$api->get('/groups','UsersController@myCircle');
		//我创建的活动
		$api->get('/createdact','UsersController@myCreatedCirclesActivity');

		//我关注的活动
		$api->get('/followacts','UsersController@watchActivity');
		//我关注的圈子
		$api->get('/followgroups','UsersController@watchCircle');
		//我收藏的活动
		$api->get('/collectacts','UsersController@favoriteActivity');

		//我的审核消息
		$api->get('/applymsg','UsersController@applymsg');
		//我的通知消息
		$api->get('/systemmsg','UsersController@systemmsg');

		//修改用户信息-电话 code,code_id,phone
		$api->put('/tel','UsersController@alter_tel');
		//修改用户信息-头像
		$api->put('/headimg','UsersController@alter_img');
		//修改用户信息-性别
		$api->put('/sex','UsersController@alter_sex');
		//修改用户信息-出生日期
		$api->put('/birth','UsersController@alter_birth');
		//修改用户信息-昵称
		$api->put('/name','UsersController@alter_name');

		//设置密码
		$api->put('/pwd','UsersController@alter_pwd');


		//第三方登陆
		$api->post('/login_wx','UsersController@third_party_wx_login');
		$api->post('/login_qq','UsersController@third_party_qq_login');
		$api->post('/login_sina','UsersController@third_party_sina_login');
	});

	//公用
	$api->group(['namespace'=>'App\Http\Controllers\API','prefix'=>'order'],function($api){
		$api->get('/alipay','OrdersController@alipay');
		$api->get('/alistatus','OrdersController@alistatus');
		$api->post('/payinfo','OrdersController@store');
		$api->post('/paystatus','OrdersController@update');
		$api->post('/getcharge','OrdersController@getcharge');
	});

	//反馈
	$api->group(['namespace'=>'App\Http\Controllers\API','prefix'=>'system'],function($api){
		$api->post('/feedback','FeedbackController@store');
		$api->get('/about','FeedbackController@show');
	});
});
