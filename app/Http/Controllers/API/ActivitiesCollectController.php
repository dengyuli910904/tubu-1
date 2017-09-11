<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivitiesCollect;
use App\Libraries\Common;
use UUID;
use App\Models\Activities;

class ActivitiesCollectController extends Controller
{
    /**
     * 收藏活动
     */
    public function store(Request $request){
        $act = Activities::find($request->input('activities_id'));
        if(!$act)
            return Common::returnResult(204,'该活动信息不存在',"");

    	$collect = ActivitiesCollect::where('activities_id',$request->input('activities_id'))->where('user_id',$request->input('users_id'))->first();
    	if(!$collect){
    		$collect = new ActivitiesCollect();
    		$collect->id = UUID::generate();
    		$collect->activities_id = $request->input('activities_id');
    		$collect->user_id = $request->input('users_id');
    		if($collect->save()){
                $act->collect_count = (int)$act->collect_count +1;
                $act->save();
    			return Common::returnSuccessResult(200,'收藏成功','');
    		}else{
    			return Common::returnErrorResult(400,'收藏失败');
    		}
    	}else{
    		return Common::returnErrorResult(201,'您已收藏该活动');
    	}
    }

    /**
     * 取消收藏
     */
    public function destory(Request $request){
         $act = Activities::find($request->input('activities_id'));
        if(!$act)
            return Common::returnResult(204,'该活动信息不存在',"");

    	$collect = ActivitiesCollect::where('activities_id',$request->input('activities_id'))->where('user_id',$request->input('users_id'))->first();
    	if($collect){
    		if($collect->delete()){
                $act->collect_count = (int)$act->collect_count -1;
                $act->save();

    			return Common::returnSuccessResult(200,'取消成功','');
    		}
    		else{
    			return Common::returnErrorResult(400,'取消失败');
    		}
    	}else{
    		return Common::returnErrorResult(204,'您还未收藏该活动');
    	}
    }
}
