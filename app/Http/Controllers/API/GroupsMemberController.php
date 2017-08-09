<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupMember;

class GroupsMemberController extends Controller
{
    /**
     * 设置圈子成员成为领队
     */
    public function setrole(Request $request){
        $members = GroupMember::where('groups_id',$request->input('groups_id'))->where('users_id',$request->input('users_id'))->first();
        if(!empty($members)){
            $members->role = 1;//设置成员成为领队
            if($members->save()){
            	return Common::returnResult(200,'设置成功',"");
            }else{
            	return Common::returnResult(400,'设置失败',"");
            }
        }else{
            return Common::returnResult(400,'该记录不存在',"");
        }
    }
    /**
     * 设置成为副圈主
     */
    public function setleader(Request $request){
        $members = GroupMember::where('groups_id',$request->input('groups_id'))->where('users_id',$request->input('users_id'))->first();
        if(!empty($members)){
            $members->role = 2;//设置成员成为副圈主
            if($members->save()){
                return Common::returnResult(200,'设置成功',"");
            }else{
                return Common::returnResult(400,'设置失败',"");
            }
        }else{
            return Common::returnResult(400,'该记录不存在',"");
        }
    }

    /**
     * 设置圈子领队成为普通圈子成员
     */
    public function cancelrole(Request $request){
    	$members = GroupMember::where('groups_id',$request->input('groups_id'))->where('users_id',$request->input('users_id'))->first();
        if(!empty($members)){
            $members->role = 0;//设置成员成为领队
            if($members->save()){
            	return Common::returnResult(200,'设置成功',"");
            }else{
            	return Common::returnResult(400,'设置失败',"");
            }
        }else{
            return Common::returnResult(400,'该记录不存在',"");
        }
    }
}
