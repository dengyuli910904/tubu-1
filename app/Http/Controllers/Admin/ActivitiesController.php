<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\Activities;
use App\Models\GroupMember;
use UUID;
use Redirect,Input;

class ActivitiesController extends Controller
{

    public function index(Request $request){
        $users_id = 1;
        $list = Activities::where('users_id',$users_id)->paginate(5);
        return view('web.activity.act_list',['data'=>$list]);
    }

    /**
    *  修改活动信息
    */
    public function edit($id){
        $activity = Activities::find($id);
        if($activity){
            $user_id = $activity->users_id;
            $groups = GroupMember::where('groupmember.users_id',$user_id)
                ->where('groupmember.role','1')
                ->where('groupmember.status','1')
                ->join('groups as g','g.id','=','groupmember.groups_id')
                ->select('g.name','g.id')
                ->get();
            return view('web.activity.act_edit',['model'=>$activity,'groups'=>$groups]);
        }else{
            return Redirect::back()->withInput()->withErrors('未找到记录');
        }
    }
    /**
     * 更新
     */
    public function update(Request $request,$id){
        $activity = Activities::find($id);
        if($activity){
            $activity->groups_id = $request->input('groups_id');
            // $activity->users_id = $users_id;
            $activity->cover = $request->input('cover');
            $activity->title = $request->input('title');
            $activity->content = $request->input('editorValue');
            $activity->cost_intro = $request->input('cost_intro');
            $activity->starttime = $request->input('starttime');
            // $activity->endtime = $request->input('endtime');
            $activity->enrol_starttime = $request->input('enrol_starttime');
            // $activity->enrol_endtime = $request->input('enrol_endtime');
            $activity->contacts = $request->input('contacts');
            $activity->contacts_tel = $request->input('contacts_tel');
            $activity->cost = $request->input('cost');
            $activity->limit_count = $request->input('limit_count');
            $activity->keywords = $request->input('keywords');
            $activity->comment = $request->input('comment');
            if($activity->save()){
                return Redirect::back();
            }else{
                return Redirect::back()->withInput()->withErrors('编辑失败');
            }
        }else{
            return Redirect::back()->withInput()->withErrors('未找到记录');
        }
    }
    /**
     * 添加活动
     */
    public function create(Request $request){
    	$user_id = '1';
    	$groups = GroupMember::where('groupmember.users_id',$user_id)
    		->where('groupmember.role','1')
    		->where('groupmember.status','1')
    		->join('groups as g','g.id','=','groupmember.groups_id')
    		->select('g.name','g.id')
    		->get();
    	return view('web.activity.act_publish',array('groups' =>$groups));
    }

    /**
     * 存储活动
     */
    public function store(Request $request){
    	$users_id = 1;
        if(!$request->has('groups_id')){
            return Redirect::back()->withInput()->withErrors('必须要选择圈子才能进行发布'); 
        }
    	$activity = Activities::where('groups_id',$request->input('groups_id'))
    		->where('title',$request->input('title'))
    		->first();
    	if(!$activity){
    		$activity = new Activities();
            $activity->id = UUID::generate();
    		$activity->groups_id = $request->input('groups_id');
    		$activity->users_id = $users_id;
    		$activity->cover = $request->input('cover');
    		$activity->title = $request->input('title');
    		$activity->content = $request->input('editorValue');
    		$activity->cost_intro = $request->input('cost_intro');
    		$activity->starttime = $request->input('starttime');
    		// $activity->endtime = $request->input('endtime');
    		$activity->enrol_starttime = $request->input('enrol_starttime');
    		// $activity->enrol_endtime = $request->input('enrol_endtime');
    		$activity->contacts = $request->input('contacts');
            $activity->contacts_tel = $request->input('contacts_tel');
            $activity->cost = $request->input('cost');
            $activity->limit_count = $request->input('limit_count');
            $activity->keywords = $request->input('keywords');
            $activity->comment = $request->input('comment');
            if($activity->save()){
                return Redirect::back();
            }else{
                return Redirect::back()->withInput()->withErrors('添加失败');
            }

    	}else{
    		return Redirect::back()->withInput()->withErrors('已有该活动记录');
    	}
    }
}
