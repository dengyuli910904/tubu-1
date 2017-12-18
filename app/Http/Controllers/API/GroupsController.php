<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\Users;
use App\Models\GroupMember;
use App\Libraries\Common;
use UUID;
use Dingo\Api\Routing\Helpers;
use App\Models\GroupsApply;
use App\Models\News;
use App\Models\Activities;

class GroupsController extends Controller
{
    use Helpers;
    /**
     * 圈子列表，用于发布活动用
     */
    public function groups(Request $request){
        //需要用户所在的圈子，并且用户为该圈子的领队
        if(!$request->has('users_id')){
            return Common::returnResult(400,'参数错误');
        }

        // $list1 = Groups::where('users_id',$request->input('users_id'))->where('status','1')->select('id','name')->get();

        $list = GroupMember::join('groups as g','g.id','=','groupmember.groups_id')
            ->where('groupmember.users_id',$request->input('users_id'))
            ->where('groupmember.role','>','0')
            ->where('g.status','=','1')
            ->select('g.id','g.name')
            ->groupby('id','name')
            ->get();
        return Common::returnResult(200,'获取成功',$list);
    }
    /**
     * 获取所有的圈子,圈子列表（首页）
     */
    public function index(Request $request){
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

    	$list = Groups::where(function($query) use ($request){
    		if($request->has('searchtxt')){
    			$query->where('name','like','%'.$request->input('searchtxt').'%');
            }
    		// if($request->has('user_id')){
    		// 	//用户登陆情况下，需要查询排除用户的参与的圈子？
    		// 	$query->where('')
    		// }
    	})
        ->where('status','=','1')
    	->orderby('created_at','desc')
        ->skip($pageindex*$pageindex)
        ->take($pagesize)
    	->get();

        //若用户id不为空，则返回一个字段
        $mygroups = [];
        $myapply = [];
        if($request->has('users_id')){
            $mygroups = Groups::join('groupmember as g','groups.id','=','g.groups_id')->where('g.users_id',$request->input('users_id'))->select('groups.id')->get();
            $myapply = Groups::join('groups_apply as ag','groups.id','=','ag.groups_id')->where('ag.users_id',$request->input('users_id'))->where('ag.status','0')->select('groups.id')->get();
        }

        

        // if($mygroups){
        foreach ($list as $val) {
            $val->is_member = 0;//先默认非成员
            foreach ($mygroups as $g) {
                if($val->id == $g->id)
                    $val->is_member = 1;//当条件匹配上则改成是成员
            }
            foreach ($myapply as $ag) {
                if($val->id == $ag->id)
                    $val->is_member = 2;//当条件匹配上则改成是已经申请，但正在待审核
            }
        }
        // }else{
        //     foreach ($list as $val) {
        //         $val->is_member = 0;//非改圈子成员
        //     }
        // }
        

    	return Common::returnResult(200,'获取成功',$list);
    }

    /**
     * 获取圈子详情
     */
    public function show(Request $request){
    	if($request->has('id')){
    		$groups = Groups::find($request->input('id'));
    		if($groups){
                $groups->is_edit = false;
                $groups->user_role = 3;//,'role_text'=>'未申请'];

                if($request->has('users_id')){
                    if( $groups->users_id == $request->input('users_id')){
                        $groups->user_role = 10;
                        $groups->is_edit = true;
                    }else{
                        $member = GroupMember::where('users_id',$request->input('users_id'))->where('groups_id',$request->input('id'))->first();
                        if($member){
                            $groups->user_role = $member->role; //副圈主
                            if($member->role == 1){
                                
                                $groups->is_edit = true;
                            }
                            // $user->role_text = $member->role == 0?'已加入':'副圈主';
                        }else{
                            $app = GroupsApply::where('users_id',$request->input('users_id'))->where('groups_id',$request->input('id'))->first();
                            if($app){
                                $groups->user_role = 2; 
                                // $user->role_text = '申请审核中';
                            }
                        }
                    }
                }


    			$data['groupsinfo'] = $groups;
    			$owner = Users::select('id','name','headimg','birthdate','sex','telphone')->find($groups->users_id);
    			if(!empty($owner)){
    				$owner->role = '1';//1 圈主
    				$owner->rolename = '圈主';
    			}
    			$data['owner'] = $owner;
    			// $data['member'] = array('users_id'=>$groups->users_id,);
                $deputyid = [];
                $memberid = [];
                $deputys = [];
                $members = [];
                $user = [];
    			//参与的用户
    			$idlist = GroupMember::where('groups_id','=',$request->input('id'))->select('users_id','role')->get();
    			foreach ($idlist as $key => $value) {
    				switch ($value->role) {
    					case 0:
                            array_push($memberid,$value->users_id);
    						// $memberid = $memberid.$value->users_id.',';//.($key === (count($idlist)-1)?'':',');
    						break;
    					
    					case 1:
                            array_push($deputyid,$value->users_id);
    						// $deputyid = $deputyid.$value->users_id.',';//.($key === (count($idlist)-1)?'':',');
    						break;
    				}
    			}
                
                // return $deputyid
                if(!empty($deputyid)){
                    $deputys = Users::whereIn('id',$deputyid)->select('id','name','headimg','birthdate','sex','telphone')->get();
                }
    			
                if(!empty($memberid)){
                    $members = Users::whereIn('id',$memberid)->select('id','name','headimg','birthdate','sex','telphone')->get();
                }
    			$data['deputys'] = $deputys;//副圈主列表
    			$data['members'] = $members;//普通成员列表

    			return Common::returnResult(200,'查询成功',$data);
    		}
    		else{
    			return Common::returnResult(204,'该记录不存在',"");
    		}
    	}else{
    		return Common::returnResult(400,'参数不正确',"");
    	}
    }

    /**
     * 编辑圈子信息
     */
    public function edit(Request $request){
        //users_id
     if($request->has('id')){
         $gourps = Groups::find($request->input('id'));
         if(!empty($groups)){
             $groups->name = $request->input('name');
             $groups->intro = $request->input('intro');
             $groups->address = $request->input('address');
             $groups->cover = $request->input('cover');
             if($groups->save()){
                 return Common::returnResult(200,'修改成功',"");
             }else{
                 return Common::returnResult(400,'修改失败',"");
             }
         }
         else{
             return Common::returnResult(204,'该记录不存在',"");
         }
     }else{
         return Common::returnResult(400,'参数不正确',"");
     }
    }
    /**
     * 创建圈子，发送到后台进行审核
     */
    public function store(Request $request){
        $groups = Groups::where('name',$request->input('name'))
            // ->where('address',$request->input('address'))
            ->first();
        if(!$groups){
            $id = (string)UUID::generate();
            $groups = new Groups();
            $groups->id = $id;
            $groups->name = $request->input('name');
            $groups->intro = $request->input('intro');
            $groups->address = $request->input('address');
            $groups->cover = $request->input('cover');
            $groups->users_id = $request->input('users_id');
            if($groups->save()){
                $member = new GroupMember();
                $member->id = UUID::generate();
                $member->role =10;
                $member->groups_id = $id;
                $member->users_id = $request->input('users_id');
                $member->status = 1;//默认通过
                $member->save();
                //TODO:: 后期需要改成用事务处理方式
                return Common::returnSuccessResult(200,'创建成功',$groups);
            }else{
                return Common::returnErrorResult(400,'创建失败',"");
            }
        }else{
            return Common::returnErrorResult(201,'该圈子已存在',"");
        }
        
    }

    /**
     * 获取圈子用户列表
     */
    public function members(Request $request){
        $groups = Groups::find($request->input('id'));
        if($groups){
            $list = GroupMember::join('users as u','u.id','=','groupmember.users_id')
                // ->where('groupmember.users_id',$request->input('users_id'))
                ->where('groupmember.groups_id',$request->input('id'))
                ->select('u.id','u.name','u.headimg','u.birthdate','u.sex','u.telphone','groupmember.role')
                ->get();
                foreach ($list as $val) {
                    switch ($val->role) {
                        case 0:
                            $val->role_text = '普通成员'; 
                            break;
                        case 1:
                            $val->role_text = '副管理员';
                            break;
                        case 10:
                            $val->role_text = '管理员';
                            break;
                    }
                }
            // $data = [];
            // $deputyid = [];
            // $memberid = [];
            // $deputys = [];
            // $members = [];
            // $owner = Users::select('id','name','headimg','birthdate','sex','telphone')->find($groups->users_id);
            // if(!empty($owner)){
            //     $owner->role = '1';//1 圈主
            //     $owner->rolename = '圈主';
            // }

            // $idlist = GroupMember::where('groups_id','=',$request->input('id'))->select('users_id','role')->get();
            // foreach ($idlist as $key => $value) {
            //     switch ($value->role) {
            //         case 0:
            //             array_push($memberid,$value->users_id);
            //             // $memberid = $memberid.$value->users_id.',';//.($key === (count($idlist)-1)?'':',');
            //             break;
                    
            //         case 1:
            //             array_push($deputyid,$value->users_id);
            //             // $deputyid = $deputyid.$value->users_id.',';//.($key === (count($idlist)-1)?'':',');
            //             break;
            //     }
            // }
            // if(!empty($deputyid)){
            //     $deputys = Users::whereIn('id',$deputyid)->select('id','name','headimg','birthdate','sex','telphone')->get();
            // }
            
            // if(!empty($memberid)){
            //     $members = Users::whereIn('id',$memberid)->select('id','name','headimg','birthdate','sex','telphone')->get();
            // }

            // $data['deputys'] = $deputys;//副圈主列表
            // $data['members'] = $members;//普通成员列表
            // $data['owner'] = $owner;

            return Common::returnResult(200,'获取成功',$list);
        }else{
            return Common::returnResult(204,'该俱乐部记录不存在','');
        }
    }

    /**
     * 分享的圈子详情页面
     */
    public function info(Request $request){
        if(!$request->has('id'))
            return view('error');

        $group = Groups::find($request->input('id'));
        if(!$group)
            return view('error');

        $members = GroupMember::join('users','users.id','=','groupmember.users_id')
        ->where('groups_id',$request->input('id'))
        ->select('users.*')
        ->get();

        $act = Activities::where('groups_id',$request->input('id'))
        ->take(10)
        ->get();
        $data['groups'] = $group;
        $data['members'] = $members;
        $data['activity'] = $act;
        // return $data;
        $data['owner'] = Users::find($group->users_id);
        return view('web.share.group',['data'=>$data]);
    }
    
    /**
     * 编辑圈子信息
     */
    // public function edit(Request $request){
    // 	if($request->has('id')){
    // 		$gourps = Groups::find($request->input('id'));
    // 		if(!empty($groups)){
    // 			$groups->name = $request->input('name');
    // 			$groups->intro = $request->input('intro');
    // 			$groups->address = $request->input('address');
    // 			$groups->cover = $request->input('cover');
    // 			if($groups->save()){
    // 				return Common::returnResult(200,'修改成功',"");
    // 			}else{
    // 				return Common::returnResult(400,'修改失败',"");
    // 			}
    // 		}
    // 		else{
    // 			return Common::returnResult(400,'该记录不存在',"");
    // 		}
    // 	}else{
    // 		return Common::returnResult(400,'参数不正确',"");
    // 	}
    // }


    /**
     * 创建圈子，发送到后台进行审核
     */
    // public function store(Request $request){
    //     $groups = Groups::where('name',$request->input('name'))
    //         // ->where('address',$request->input('address'))
    //         ->first();
    //     if(!$groups){
    //         $groups = new Groups();
    //         $groups->id = UUID::generate();
    //         $groups->name = $request->input('name');
    //         $groups->intro = $request->input('intro');
    //         $groups->address = $request->input('address');
    //         $groups->cover = $request->input('cover');
    //         if($groups->save()){
    //             return Common::returnSuccessResult(200,'创建成功',$groups);
    //         }else{
    //             return Common::returnErrorResult(400,'创建失败',"");
    //         }
    //     }else{
    //         return Common::returnErrorResult(400,'该圈子已存在',"");
    //     }
    	
    // }

    /**
     * 获取圈子用户列表
     */
    // public function members(Request $request){
    //     $groups = Groups::find($request->input('id'));
    //     if($groups){
    //         $data = [];
    //         $idlist = GroupMember::where('groups_id','=',$request->input('id'))->select('users_id','role')->get();
    //         foreach ($idlist as $key => $value) {
    //             switch ($value->role) {
    //                 case 0:
    //                     $memberid = $memberid.$value->id.($key === (count($idlist)-1)?'':',');
    //                     break;
                   
    //                 case 1:
    //                     $deputyid = $deputyid.$value->id.($key === (count($idlist)-1)?'':',');
    //                     break;
    //             }
    //         }
    //         if(!empty($deputyid)){
    //             $deputys = Users::where('id','in','('.$deputyid.')')->get();
    //             $data['deputys'] = $deputys;//副圈主列表
    //         }
    //         if(!empty($memberid)){
    //             $members = Users::where('id','in','('.$memberid.')')->get();
    //             $data['members'] = $members;//普通成员列表
    //         }
    //         return Common::returnResult(200,'获取成功',$data);
    //     }else{
    //         return Common::returnResult(400,'该记录不存在','');
    //     }
    // }

    

}
