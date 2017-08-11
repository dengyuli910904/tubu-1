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
    public function store(Request $request){
        $apply = GroupsApply::where('groups_id',$request->input('groups_id'))->where('users_id',$request->input('u_id'))->first();
        if(!$apply){
            $apply = new GroupsApply();
            $apply->id = UUID::generate();
            $apply->groups_id = $request->input('groups_id');
            $apply->users_id = $request->input('users_id');
            $apply->type = 0;
            if($apply->save()){
                return Common::returnResult(200,'申请成功',"");
            }else{
                return Common::returnResult(400,'申请失败',"");
            }
        }else{
            return Common::returnResult(400,'该用户已有申请记录',"");
        }
    	
    }
    /**
     * 用户被邀请进入圈子
     */
    public function invite(Request $request){
        //users_id 当前登录用户id ，invite_users_id //被邀请用户id
        $apply = GroupsApply::where('groups_id',$request->input('groups_id'))->where('users_id',$request->input('invite_users_id'))->first();
        if(!$apply){
            $apply = new GroupsApply();
            $apply->id = UUID::generate();
            $apply->groups_id = $request->input('groups_id');
            $apply->users_id = $request->input('invite_users_id');
            $apply->type = 1;
            if($apply->save()){
                return Common::returnResult(200,'邀请成功',"");
            }else{
                return Common::returnResult(400,'邀请失败',"");
            }
        }else{
            return Common::returnResult(400,'该用户已有申请记录',"");
        }
    }
    /**
     * 审核用户加入圈子
     */
    public function update(Request $request){
        
    	if($request->has('id')){
    		$apply = GroupsApply::find($request->input('id'));
    		if(!empty($apply)){
    			if($request->input('status') == 1){
    				//通过
    				$apply->status = 1;//
    				$member = new GroupMember();
                    $member->id = UUID::generate();
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
