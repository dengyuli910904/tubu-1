<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\Groups;
use App\Models\Users;
use App\Models\ActivityMember;
use App\Libraries\Common;
use UUID;

class ActivitiesController extends Controller
{
    /**
     * 获取活动列表,非登录用户,查询所有活动
     */
    public function index(Request $request){
    	$list = Activities::where('is_able','=','1')
            ->where(function($query) use($request){
                //searchtxt
            })
    		->select('id','cover','title','starttime','endtime','enrol_starttime','enrol_endtime','cost','limit_count','participation_count','apply_count','status','keywords')
    		->get();
    	return Common::returnResult('200','查询成功',$list);
    }

    /**
     * 获取活动详情
     */
    public function show(Request $request){
    	$activity = Activities::find($request->input('id'));
    	if(!empty($activity)){
            $groups = Groups::find($activity->groups_id);
            $data['activityinfo'] = $activity;
            $data['groupsinfo'] = array('name'=>$groups->name,'score'=>$groups->score);
            $owner = Users::find($groups->users_id);
            $data['leaderinfo'] = $owner;
            $idlist = ActivityMember::where('activities_id','=',$request->input('id'))->select('users_id','role')->get();
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
            $data['deputys'] = $deputys;//副领队列表
            $members = Users::where('id','in','('.$memberid.')')->get();
            $data['members'] = $members;//普通成员列表
            return Common::returnResult('200','查询成功',$data);
    	}else{
    		return Common::returnResult('400','该记录不存在',"");
    	}
    }

    /**
     * 进入创建活动页面
     */
    public function create_part1(Request $request){
        $group = Groups::find($request->input('id'));//圈子id

    }
    /*
    *   添加活动——part1
    */
    public function store_part1(Request $request){
        if($request->has('id')){
            $activity = Activities::find($request->input('id'));
        }else{
           $activity = new Activities(); 
           $activity->id = UUID::generate();
        }
        $activity->groups_id = $request->input('groups_id');
        $activity->keywords = $request->input('keywords');
        $activity->cover = $request->input('cover');
        $activity->users_id = $request->input('users_id');
        if($activity->save()){
            return Common::returnResult('200','保存成功',$activity);
        }else{
            return Common::returnResult('400','保存失败',"");
        }
    }

    /*
    *   添加活动——part2
    */
    public function store_part2(Request $request){
        $activity = Activities::find($request->input('id'));
        $activity->title = $request->input('title');
        $activity->starttime = $request->input('starttime');
        $activity->endtime = $request->input('endtime');
        $activity->limit_count = $request->input('limit_count');
        if($activity->save()){
            return Common::returnResult('200','保存成功',array('id'=>$activity->id));
        }else{
            return Common::returnResult('400','保存失败',"");
        }
    }

    /*
    *   添加活动——part3
    */
    public function store_part3(Request $request){
        $activity = Activities::find($request->input('id'));
        $activity->contacts = $request->input('contacts');
        $activity->contacts_tel = $request->input('contacts_tel');
        $activity->content = $request->input('content');
        if($activity->save()){
            return Common::returnResult('200','保存成功',array('id'=>$activity->id));
        }else{
            return Common::returnResult('400','保存失败',"");
        }
    }

    /*
    *   添加活动——part4
    */
    public function store_part4(Request $request){
        $activity = Activities::find($request->input('id'));
        $activity->cost = $request->input('cost');
        $activity->cost_intro = $request->input('cost_intro');
        if($activity->save()){
            return Common::returnResult('200','保存成功',array('id'=>$activity->id));
        }else{
            return Common::returnResult('400','保存失败',"");
        }
    }
    /**
     * 修改活动
     */
    public function update(Request $request){
        $activity = Activities::find($request->input('id'));
        //正式发布，结束报名，取消活动
        switch ($request->input('step')) {
            case 1:
                $status = 1; //正式发布状态
                break;
            case 2:
                $status = 2; //结束报名状态
                break;
            case 3:
                $status = 3; //取消活动
                break;
            case 4:
                $status = 4; //结束活动
                break;
        }
        if(!empty($status)){
            $activity->status = $status;//
            if($activity->save()){
                return Common::returnResult('200','保存成功',array('id'=>$activity->id));
            }else{
                return Common::returnResult('400','保存失败',"");
            }
        }else{
            return Common::returnResult('400','无任何更新',"");
        }
    }
}
