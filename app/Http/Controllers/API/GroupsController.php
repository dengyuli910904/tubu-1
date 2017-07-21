<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Libraries\Common;

class GroupsController extends Controller
{
    /**
     * 获取所有的圈子,圈子列表（首页）
     */
    public function list(Request $request){
    	// $str = $request->input('searchtxt');
    	$list = Groups::where(function($query) use ($request){
    		if($request->has('searchtxt'))){
    			$query->where('name','like','%'.$str.'%');
    		}
    		// if($request->has('user_id')){
    		// 	//用户登陆情况下，需要查询排除用户的参与的圈子？
    		// 	$query->where('')
    		// }
    	})
    	->orderby('create_at','desc')
    	->get();
    	return Common::returnResult(200,'获取成功',$list);
    }

    /**
     * 获取圈子详情
     */
    public function groups(Request $request){
    	if($request->has('id')){
    		$gourps = Groups::find($request->input('id'));
    		if(!empty($groups)){
    			return Common::returnResult(200,'查询成功',$groups);
    		}
    		else{
    			return Common::returnResult(400,'该记录不存在',"");
    		}
    	}else{
    		return Common::returnResult(400,'参数不正确',"");
    	}
    }

}
