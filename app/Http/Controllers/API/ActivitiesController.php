<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\Groups;
use App\Models\Users;
use App\Models\ActivityMember;
use App\Libraries\Common;

class ActivitiesController extends Controller
{
    /**
     * 获取活动列表,非登录用户,查询所有活动
     */
    public function index(Request $request){
    	$list = Activities::where('is_able','=','1')
    		->select('id','cover','title''starttime','endtime',
    				 'enrol_starttime','enrol_endtime','cost','limit_count','participation_count',
    				 'apply_count','status','keywords')
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
                        $memberid = $memberid.$value->id.($key === (count($idlist)-1):''?',');
                        break;
                    
                    case 1:
                        $deputyid = $deputyid.$value->id.($key === (count($idlist)-1):''?',');
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
        $activity = new Activities();
        $activity->id = UUID::generate();
        $activity->groups_id = $request->input('groups_id');
        $activity->keywords = $request->input('keywords');
        $activity->cover = $request->input('cover');
        if($activity->save()){
            return Common::returnResult('200','保存成功',array('id'=>$activity->id));
        }else{
            return Common::returnResult('400','保存失败',"");
        }
    }

     /*
    *   添加活动——part2
    */
    public function store_part2(Request $request){
        $activity = new Activities();
        $activity->id = UUID::generate();
        $activity->groups_id = $request->input('groups_id');
        $activity->keywords = $request->input('keywords');
        $activity->cover = $request->input('cover');
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

    }
}
