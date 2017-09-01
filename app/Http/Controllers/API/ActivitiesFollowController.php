<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivitiesFollow;
use UUID;
use App\Libraries\Common;

class ActivitiesFollowController extends Controller
{
    /**
     * 关注活动
     */
    public function store(Request $request){
    	$follow = ActivitiesFollow::where('activities_id',$request->input('activities_id'))->where('user_id',$request->input('users_id'))->first();
    	if(!$follow){
    		$follow = new ActivitiesFollow();
    		$follow->id = UUID::generate();
    		$follow->activities_id = $request->input('activities_id');
    		$follow->user_id = $request->input('user_id');
    		if($follow->save()){
    			return Common::returnSuccessResult(200,'关注成功','');
    		}else{
    			return Common::returnErrorResult(400,'关注失败');
    		}
    	}else{
    		return Common::returnErrorResult(201,'您已关注该活动');
    	}
    }

    /**
     * 取消关注
     */
    public function destory(Request $request){
    	$follow = ActivitiesFollow::where('activities_id',$request->input('activities_id'))->where('user_id',$request->input('users_id'))->first();
    	if($follow){
    		if($follow->delete()){
    			return Common::returnSuccessResult(200,'取消成功','');
    		}
    		else{
    			return Common::returnErrorResult(200,'取消失败');
    		}
    	}else{
    		return Common::returnErrorResult(204,'您还未关注该活动');
    	}
    }
}
