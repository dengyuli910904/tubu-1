<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Models\Groups;
use App\Models\Users;
use App\Models\ActivityMember;
use App\Libraries\Common;
use App\Models\ActivitiesCollect;
// use App\Models\Groups;
use UUID;

class ActivitiesController extends Controller
{
    /**
     * 获取活动列表,非登录用户,查询所有活动
     */
    public function index(Request $request){
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

    	$list = Activities::where('is_able','=','1')
            ->where('status','<>','0')
            ->where(function($query) use($request){
                //searchtxt
            })
            ->select('id','cover','title','starttime','endtime',
    				 'enrol_starttime','enrol_endtime','cost','limit_count','participation_count',
    				 'apply_count','status','keywords')
            ->skip($pageindex*$pagesize)
            ->take($pagesize)
    		->get();
            foreach ($list as $val) {
                 switch ($val->status) {
                    case 1:
                        $val->status_text = '报名中'; //正式发布状态
                        break;
                    case 2:
                        $val->status_text = '报名结束'; //结束报名状态
                        break;
                    case 3:
                        $val->status_text = '活动已取消'; //取消活动
                        break;
                    case 4:
                        $val->status_text = '活动已结束'; //结束活动
                        break;
                }
            }
    	return Common::returnResult('200','查询成功',$list);
    }

    /**
     *  查询圈子活动列表
     */
    public function groups_act(Request $request){
        if(!$request->has('id'))
            return Common::returnResult('400','参数错误',[]);
        $group = Groups::find($request->input('id'));
        if(!$group)
            return Common::returnResult('400','圈子不存在或者已经被禁用',[]);
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = Activities::where('groups_id',$request->input('id'))->select('id','cover','title','starttime','keywords','status','apply_count')
        ->skip($pageindex*$pagesize)
        ->take($pagesize)
        ->get();
        return Common::returnResult('200','获取成功',$list);
    }
    /**
     * 获取活动详情
     */
    public function show(Request $request){
    	$activity = Activities::find($request->input('id'));
    	if(!empty($activity)){
            $groups = Groups::find($activity->groups_id);
            $activity->status_text = '待发布'; //结束活动
            if($groups){
                switch ($activity->status) {
                    case 1:
                        $activity->status_text = '报名中'; //正式发布状态
                        break;
                    case 2:
                        $activity->status_text = '报名结束'; //结束报名状态
                        break;
                    case 3:
                        $activity->status_text = '活动已取消'; //取消活动
                        break;
                    case 4:
                        $activity->status_text = '活动已结束'; //结束活动
                        break;
                    default:
                        $activity->status_text = '待发布'; //结束活动
                        break;
                }

                $data['activityinfo'] = $activity;
                $data['groupsinfo'] = array('name'=>$groups->name,'score'=>$groups->score);

                $owner = Users::find($groups->users_id);
                if(!$owner){
                    $owner = [];
                }
                $data['leaderinfo'] = $owner;
                $idlist = ActivityMember::where('activities_id','=',$request->input('id'))->select('users_id','role')->get();
                $deputyid = "";
                $memberid = "";
                foreach ($idlist as $key => $value) {
                    switch ($value->role) {
                        case 0:
                            $memberid = $memberid.$value->id.',';//($key === (count($idlist)-1)?'':',');
                            break;
                        
                        case 1:
                            $deputyid = $deputyid.$value->id.',';//($key === (count($idlist)-1)?'':',');
                            break;
                    }
                }
                $deputys = [];
                $members = [];
                if(!empty($deputyid)){
                    $deputys = Users::query('where id in ('.$deputyid.')')->get();
                } 
                $data['deputys'] = $deputys;//副领队列表
                if(!empty($memberid)){
                    $members = Users::query('where id in ('.$memberid.')')->take(4)->get();
                }
                
                $data['members'] = $members;//普通成员列表

                $collect = ActivitiesCollect::where('user_id',$request->input('users_id'))->where('activities_id',$request->input('id'))->first();
                $data['is_collect'] = false;
                if($collect){
                    $data['is_collect'] = true;
                }

                $member = ActivityMember::where('users_id',$request->input('users_id'))->where('activities_id',$request->input('id'))->first();
                $data['is_sign_in'] = false;
                $data['is_pay'] = false;
                if((float)$activity->cost <=0){
                    $data['is_pay'] = true;
                }
                if($member){
                    if($member->is_pay == 1){
                        $data['is_pay'] = true;
                    }
                    $data['is_sign_in'] = true;
                }


                return Common::returnResult('200','查询成功',$data);
            }else{
                return Common::returnResult('204','圈子不存在或者已经被禁用',[]);
            }
            
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
            $id = $request->input('id');
            $activity = Activities::find($request->input('id'));
        }else{

           $activity = new Activities(); 
           $id = (string)UUID::generate();
           $activity->id = $id;
        }
        // return (string)$id;
        $activity->groups_id = $request->input('groups_id');
        $activity->keywords = $request->input('keywords');
        $activity->cover = $request->input('cover');
        $activity->users_id = $request->input('users_id');
        $activity->content = "";
        $activity->cost_intro = "";
        if($activity->save()){
            return Common::returnResult('200','保存成功',['id' =>  $id ]);
        }else{
            return Common::returnResult('400','保存失败',"");
        }
    }

    /*
    *   添加活动——part2
    */
    public function store_part2(Request $request){
        $activity = Activities::find($request->input('id'));
        if(!$activity){
            return Common::returnResult('400','记录不存在',"");
        }
        $activity->title = $request->input('title');
        $activity->starttime = $request->input('starttime');
        $activity->endtime = $request->input('endtime');
        $activity->enrol_starttime = $request->input('enrol_starttime');
        $activity->enrol_endtime = $request->input('enrol_endtime');
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
        if(!$activity){
            return Common::returnResult('400','记录不存在',"");
        }
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
        if(!$activity){
            return Common::returnResult('400','记录不存在',"");
        }
        $activity->cost = $request->input('cost');
        $activity->cost_intro = $request->input('cost_intro');
        $activity->status = 1;
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
        if(!$activity){
            return Common::returnResult('400','记录不存在',"");
        }
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
            return Common::returnResult('204','无任何更新',"");
        }
    }
}
