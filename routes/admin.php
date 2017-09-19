<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->describe('Display an inspiring quote');

// $api = app('Dingo\Api\Routing\Router');
// $api->version('v1',function($api){
// 	$api->group(['namespace' => 'App\Http\Controllers\Admin'],function($api){
// 		$api->resource('group','GroupsController');
// 	});
// });

// Route::get('/mgroup','GroupsController@index');

// Route::get('/mgroup',function(){
// 	return view('admin.login');
// });
Route::get('/login',function(){
	return view('admin.login');
});

Route::resource('/mgroup','GroupsController');
Route::resource('/mactivity','ActivitiesController');