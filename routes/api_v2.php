<?php
/**
 * Created by PhpStorm.
 * User: Lily
 * Date: 2017/10/19
 * Time: 17:21
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');


$api->version('v1',function($api){
    //活动
    $api->group(['namespace' => 'App\Http\Controllers\API_V2','prefix'=>'activities'], function ($api) {
        $api->get('act_list','ActivitiesController@index');
        $api->post('set_sign_rule','ActivitiesSignRuleController@store');
        $api->post('sign','ActivitiesSignController@store');
        $api->post('apply','ActivitiesRoleApplyController@store');
        $api->put('examine','ActivitiesRoleApplyController@update');
        $api->get('role_list','ActivitiesRoleController@index');
    });

});