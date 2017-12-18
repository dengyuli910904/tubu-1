<?php
use Illuminate\Http\Request;
/**
 * Created by PhpStorm.
 * User: Lily
 * Date: 2017/11/21
 * Time: 14:43
 */

//app下载页面
Route::get('/download',function(){
    return view('lesong.download');
});

Route::get('/apk',function(){
    return response()->download(
        realpath(base_path('public/lesong/')).'/com.livesong.travel-2017-11-08.apk'
    );
});

Route::group(['prefix' => 'act'],function(){
   Route::get('index',function(){
       return view('lesong.index');
   });
//   Route::get('detail',function(){
//       return view('lesong.act.detail');
//   });
    Route::get('detail','API_V2\ActivitiesController@show');
    Route::get('users',function(){
        return view('lesong.act.users');
    });
    Route::get('role','API_V2\ActivitiesRoleApplyController@index');
//    Route::get('role',function(){
//        return view('lesong.act.role');
//    });

    Route::get('sign','API_V2\ActivitiesSignRuleController@create');
});

Route::group(['prefix' => 'user'], function(){
    Route::get('login', function(){
       return view('lesong.home.login');
    });

    Route::get('regist', function(){
        return view('lesong.home.regist');
    });

    Route::get('index',function(){
        return view('lesong.home.index');
    });

    Route::get('setting',function(){
        return view('lesong.home.setting');
    });
    Route::post('loginout','API_V2\UsersController@loginout');
});

Route::group(['prefix' => 'message'], function(){
    Route::get('index',function(){
        return view('lesong.message.index');
    });
});