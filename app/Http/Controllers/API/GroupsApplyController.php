<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupsApply;
use App\Libraries\Common;
use App\Models\GroupMember;
use UUID;

class GroupsApplyController extends Controller
{
    /**
     * 申请加入圈子
     */
    public function create(Request $request){
    	$apply = new GroupsApply();
    	$apply->id = UUID::generate();
    	$apply->groups->id = $request->input('groups_id');
    	$apply->user_id = $request->input('user_id');
    	if($apply->save()){
			return Common::returnResult(200,'申请成功',"");
		}else{
			return Common::returnResult(400,'申请失败',"");
		}
    }

    /**
     * 审核用户加入圈子
     */
    public function edit(Request $request){
    	if($request->has('id')){
    		$apply = GroupsApply::find($request->input('id'));
    		if(!empty($apply)){
    			if($request->input('status') === 1){
    				//通过
    				$apply->status = 1;//
    				$member = new GroupMember();
    				$member->groups_id = $apply->groups_id;
    				$member->users_id = $apply->users_id;
    				$member->save();
    			}else{
    				//不通过
    				$apply->status = 2;//不通过
    			}
    			if($apply->save()){
    				return Common::returnResult(200,'修改成功',"");
    			}else{
    				return Common::returnResult(400,'修改失败',"");
    			}
    		}
    		else{
    			return Common::returnResult(400,'该记录不存在',"");
    		}
    	}else{
    		return Common::returnResult(400,'参数不正确',"");
    	}
    }
}
