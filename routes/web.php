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

Route::get('/', function () {
    return view('welcome');
});

// Route::prefix('admin')
//     ->namespace('Admin')
//     ->group(base_path('routes/admin.php'));

Route::prefix('api')
    ->namespace('API')
    ->group(base_path('routes/api.php'));

Route::group(['namespace' => 'Common'],function(){
    // Route::any('/upload','UeditorController@server');
    Route::post('/fileupload','UeditorController@uploadimg');
});