<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupsFollow;
use UUID;
use App\Libraries\Common;

class GroupsFollowController extends Controller
{
    /**
     * 关注圈子
     */
    public function store(Request $request){
    	$follow = GroupsFollow::where('groups_id',$request->input('groups_id'))->where('user_id',$request->input('users_id'))->first();
    	if(!$follow){
    		$follow = new GroupsFollow();
    		$follow->id = UUID::generate();
    		$follow->groups_id = $request->input('groups_id');
    		$follow->user_id = $request->input('user_id');
    		if($follow->save()){
    			return Common::returnSuccessResult(200,'关注成功',[]);
    		}else{
    			return Common::returnErrorResult(400,'关注失败');
    		}
    	}else{
    		return Common::returnErrorResult(201,'您已关注该圈子');
    	}
    }

    /**
     * 取消关注
     */
    public function destory(Request $request){
    	$follow = GroupsFollow::where('groups_id',$request->input('groups_id'))->where('user_id',$request->input('users_id'))->first();
    	if($follow){
    		if($follow->delete()){
    			return Common::returnSuccessResult(200,'取消成功',[]);
    		}
    		else{
    			return Common::returnErrorResult(200,'取消失败');
    		}
    	}else{
    		return Common::returnErrorResult(204,'您还未关注该圈子');
    	}
    }
}
