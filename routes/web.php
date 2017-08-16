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
$api = app('Dingo\Api\Routing\Router');

// $api->version('v1',function($api){
// 	$api->group(['namespace' => 'App\Http\Controllers\API','prefix'=>'groups'], function ($api) {
// 		$api->get('/groups','GroupsController@groups');
// 	});
// });


// Route::prefix('admin')
//     ->namespace('Admin')
//     ->group(base_path('routes/admin.php'));

Route::prefix('api')
    ->namespace('API')
    ->group(base_path('routes/api.php'));


Route::get('/',function(){
	return view('web.activity.act_publish');
});

//图片上传
Route::group(['namespace' => 'Common'],function(){
    Route::any('/upload','UeditorController@server');
    Route::post('/fileupload','UeditorController@uploadimg');
});
//支付功能（微信支付、支付宝支付）