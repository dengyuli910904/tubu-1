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

class GroupsController extends Controller
{
    use Helpers;
    /**
     * 圈子列表，用于发布活动用
     */
    public function groups(Request $request){
        //需要用户所在的圈子，并且用户为该圈子的领队
        $list = Groups::where('status','=','1')->select('id','name')->get();
        // if(!count($list)){
        //     return Common::returnResult(200,'获取成功',"");
        // }
        return Common::returnResult(200,'获取成功',$list);
        // return $this->response->array($list->toArray());
    }
    /**
     * 获取所有的圈子,圈子列表（首页）
     */
    public function index(Request $request){
    	// $str = $request->input('searchtxt');
    	$list = Groups::where(function($query) use ($request){
    		if($request->has('searchtxt')){
    			$query->where('name','like','%'.$request->input('searchtxt').'%');
        }
    		// if($request->has('user_id')){
    		// 	//用户登陆情况下，需要查询排除用户的参与的圈子？
    		// 	$query->where('')
    		// }
    	})
    	->orderby('created_at','desc')
    	->get();
    	return Common::returnResult(200,'获取成功',$list);
    }

    /**
     * 获取圈子详情
     */
    public function show(Request $request){
    	if($request->has('id')){
    		$gourps = Groups::find($request->input('id'));
    		if(!empty($groups)){
    			$data['groupsinfo'] = $groups;
    			$owner = Users::find($groups->users_id);
    			if(!empty($owner)){
    				$owner->role = '1';//1 圈主
    				$owner->rolename = '圈主';
    			}
    			$data['owner'] = $owner;
    			// $data['member'] = array('users_id'=>$groups->users_id,);
    			//参与的用户
    			$idlist = GroupMember::where('groups_id','=',$request->input('id'))->select('users_id','role')->get();
    			foreach ($idlist as $key => $value) {
    				switch ($value->role) {
    					case 0:
    						$memberid = $memberid.$value->id.($key === (count($idlist)-1)?'':',');
    						break;
    					
    					case 1:
    						$deputyid = $deputyid.$value->id.($key === (count($idlist)-1)?'':',');
    						break;
    				}
    			}
    			$deputys = Users::where('id','in','('.$deputyid.')')->get();
    			$data['deputys'] = $deputys;//副圈主列表
    			$members = Users::where('id','in','('.$memberid.')')->get();
    			$data['members'] = $members;//普通成员列表

    			return Common::returnResult(200,'查询成功',$data);
    		}
    		else{
    			return Common::returnResult(400,'该记录不存在',"");
    		}
    	}else{
    		return Common::returnResult(400,'参数不正确',"");
    	}
    }

    /**
     * 编辑圈子信息
     */
    public function edit(Request $request){
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
             return Common::returnResult(400,'该记录不存在',"");
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
            $groups = new Groups();
            $groups->id = UUID::generate();
            $groups->name = $request->input('name');
            $groups->intro = $request->input('intro');
            $groups->address = $request->input('address');
            $groups->cover = $request->input('cover');
            if($groups->save()){
                return Common::returnSuccessResult(200,'创建成功',$groups);
            }else{
                return Common::returnErrorResult(400,'创建失败',"");
            }
        }else{
            return Common::returnErrorResult(400,'该圈子已存在',"");
        }
        
    }

    /**
     * 获取圈子用户列表
     */
    public function members(Request $request){
        $groups = Groups::find($request->input('id'));
        if($groups){
            $data = [];
            $idlist = GroupMember::where('groups_id','=',$request->input('id'))->select('users_id','role')->get();
            foreach ($idlist as $key => $value) {
                switch ($value->role) {
                    case 0:
                        $memberid = $memberid.$value->id.($key === (count($idlist)-1)?'':',');
                        break;
                   
                    case 1:
                        $deputyid = $deputyid.$value->id.($key === (count($idlist)-1)?'':',');
                        break;
                }
            }
            if(!empty($deputyid)){
                $deputys = Users::where('id','in','('.$deputyid.')')->get();
                $data['deputys'] = $deputys;//副圈主列表
            }
            if(!empty($memberid)){
                $members = Users::where('id','in','('.$memberid.')')->get();
                $data['members'] = $members;//普通成员列表
            }
            return Common::returnResult(200,'获取成功',$data);
        }else{
            return Common::returnResult(400,'该记录不存在','');
        }
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
