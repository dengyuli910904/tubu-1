<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivitiesCollect;

class ActivitiesCollectController extends Controller
{
    /**
     * 收藏活动
     */
    public function store(Request $request){
    	$ActivitiesCollectController = ActivitiesCollect::where('activities_id',$request->input('activities_id'))->where('user_id',$request->input('user_id'))->first();
    	if(!$collect){
    		$collect = new ActivitiesCollect();
    		$collect->id = UUID::generate();
    		$collect->activities_id = $request->input('activities_id');
    		$collect->user_id = $request->input('user_id');
    		if($collect->save()){
    			return Common::returnSuccessResult(200,'关注成功',[]);
    		}else{
    			return Common::returnErrorResult(400,'关注失败');
    		}
    	}else{
    		return Common::returnErrorResult(400,'您已收藏该活动');
    	}
    }

    /**
     * 取消收藏
     */
    public function destory(Request $request){
    	$collect = ActivitiesCollect::where('activities_id',$request->input('activities_id'))->where('user_id',$request->input('user_id'))->first();
    	if($collect){
    		if($collect->delete()){
    			return Common::returnSuccessResult(200,'取消成功',[]);
    		}
    		else{
    			return Common::returnErrorResult(200,'取消失败');
    		}
    	}else{
    		return Common::returnErrorResult(200,'您还未收藏该活动');
    	}
    }
}
