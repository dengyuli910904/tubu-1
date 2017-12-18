<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// $api = app('Dingo\Api\Routing\Router');

Route::prefix('lesong')
    ->group(base_path('routes/lesong.php'));



// Route::prefix('admin')
//     ->namespace('Admin')
//     ->group(base_path('routes/admin.php'));

Route::get('/arrow','HomeController@index');
Route::prefix('api')
    ->namespace('API')
    ->group(base_path('routes/api.php'));
Route::prefix('api')
    ->namespace('API_V2')
    ->group(base_path('routes/api_v2.php'));


Route::prefix('admin')
	->namespace('Admin')
	->group(base_path('routes/admin.php'));

Route::get('/test',function(){
	return view('welcome');
});
Route::get('/',function (){
   return view('web.index');
});

//Route::resource('msg','Web\MessageController');
Route::get('/msg','Web\MessageController@index');
Route::post('/msg/store','Web\MessageController@store');

Route::group(['prefix'=>'web','namespace'=>'Admin'],function(){
	// Route::group(['prefix'=>'activity'],function(){
		Route::resource('activity','ActivitiesController');
		Route::resource('groups','GroupsController');
	// });
});
route::get('/act_publish','Admin\GroupsController@create');
Route::get('/publish',function(){
	return view('web.activity.act_publish');
});

//分享
Route::group(['prefix'=>'share'],function(){
	// Route::get('activity',function(){
	// 	return view('web.share.activity');
	// });
	Route::get('group','API\GroupsController@info');
//	Route::get('activity','API\ActivitiesController@info');
    Route::get('activity','API_V2\ActivitiesController@show');
	Route::get('step','API\StepCountingController@info');
	// Route::get('group',function(){
	// 	return view('web.share.group');
	// });
});

//免责声明
Route::get('disclaimer',function(){
	return view('web.protocol.index');
});
//图片上传
Route::group(['namespace' => 'Common'],function(){
    Route::any('/upload','UeditorController@server');
    Route::post('/fileupload','UeditorController@uploadimg');
});

//发送短信
Route::post('/sendsms','API\VerifyCodeController@sendcode');

//支付功能（微信支付、支付宝支付）
Route::get('/pay','SmsController@pp');

//极光推送
Route::post('/jpush','API\NewsController@sendmsg');

