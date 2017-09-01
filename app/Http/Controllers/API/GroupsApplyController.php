<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupsApply;
use App\Libraries\Common;
use App\Models\GroupMember;
use App\Models\Groups;
use App\Models\Users;
use App\Models\News;
use UUID;

class GroupsApplyController extends Controller
{
    /**
     * 申请加入圈子
     */
    public function store(Request $request){
        if(!$request->has('groups_id') || !$request->has('users_id'))
            return Common::returnResult(400,'参数不正确',"");

        $group = Groups::find($request->input('groups_id'));
        if(!$group)
            return Common::returnResult(204,'该圈子信息不存在',"");

        $user = Users::find($request->input('users_id'));
        if(!$user)
            return Common::returnResult(204,'用户信息不存在',"");

        $apply = GroupsApply::where('groups_id',$request->input('groups_id'))->where('users_id',$request->input('users_id'))->where('status','0')->first();
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
            return Common::returnResult(201,'您的申请记录正在审核当中',"");
        }
    	
    }
    /**
     * 用户被邀请进入圈子
     */
    public function invite(Request $request){
        //users_id 当前登录用户id ，invite_users_id //被邀请用户id
        if(!$request->has('groups_id') || !$request->has('users_id') || !$request->has('invite_users_id'))
            return Common::returnResult(400,'参数不正确',"");

        $group = Groups::find($request->input('groups_id'));
        if(!$group)
            return Common::returnResult(204,'该圈子信息不存在',"");

        $user = Users::find($request->input('users_id'));
        if(!$user)
            return Common::returnResult(204,'用户信息不存在',"");

        $invitor = Users::find($request->input('invite_users_id'));
        if(!$invitor)
            return Common::returnResult(204,'您邀请的用户没有记录',"");

        $apply = GroupsApply::where('groups_id',$request->input('groups_id'))->where('users_id',$request->input('invite_users_id'))->where('status','0')->first();
        if(!$apply){
            $apply = new GroupsApply();
            $apply->id = UUID::generate();
            $apply->groups_id = $request->input('groups_id');
            $apply->users_id = $request->input('users_id');
            $apply->invite_users_id = $request->input('invite_users_id');
            $apply->type = 1;
            if($apply->save()){
                return Common::returnResult(200,'邀请成功',"");
            }else{
                return Common::returnResult(400,'邀请失败',"");
            }
        }else{
            return Common::returnResult(201,'该用户已有申请记录,请直接对用户申请进行审核',"");
        }
    }
    /**
     * 审核用户加入圈子
     */
    public function update(Request $request){
        
    	if(!$request->has('id'))
            return Common::returnResult(400,'参数不正确',"");

		$apply = GroupsApply::find($request->input('id'));
		if(empty($apply))
            return Common::returnResult(204,'该记录不存在',"");

		if($request->input('status') == 1){
			//通过
			$apply->status = 1;//
            $member = GroupMember::where('groups_id',$apply->groups_id)->where(function($query) use ($apply){
                $query->where('users_id', $apply->users_id)
                ->orWhere('users_id', $apply->invite_users_id);
            })->first();
            if(!$member){
                $member = new GroupMember();
                $member->id = UUID::generate();
                $member->groups_id = $apply->groups_id;
                $member->users_id = $apply->type == 0 ?$apply->users_id: $apply->invite_users_id;
                $member->save();
            }
		}else{
			//不通过
			$apply->status = 2;//不通过
		}

		if($apply->save()){
            $new = new News();
            $new->id =  UUID::generate();
            $new->users_id = $apply->type == 0 ?$apply->users_id: $apply->invite_users_id;
            $new->content = $apply->status ==1?($apply->type == 1?'您的加入申请已经通过审核':'您邀请的用户已同意加入'):($apply->type == 1?'您的加入申请被拒绝':'您邀请的用户已拒绝加入');
            $new->groups_id = $apply->groups_id;

			return Common::returnResult(200,'修改成功',"");
		}else{
			return Common::returnResult(400,'修改失败',"");
		}
		
    }
}
