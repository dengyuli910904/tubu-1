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
                if($request->has('searchtxt')){
                    $query->where('title','like','%'.$request->input('searchtxt').'%');
                }
            })
            ->select('id','cover','title','starttime','endtime',
    				 'enrol_starttime','enrol_endtime','cost','limit_count','participation_count',
    				 'apply_count','status','keywords','created_at')
            ->skip($pageindex*$pagesize)
            ->take($pagesize)
            ->orderby('created_at','desc')
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
            ->where('status','<>','0')
            ->skip($pageindex*$pagesize)
            ->take($pagesize)
            ->get();   
        foreach ($list as $val) {
             switch ($val->status) {
                case 0:
                    $val->status_text = '未发布'; //正式发布状态
                    break;
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
        return Common::returnResult('200','获取成功',$list);
    }
    /**
     * 获取活动详情
     */
    public function show(Request $request){
    	$activity = Activities::find($request->input('id'));
    	if(!empty($activity)){
            // $activity->content = htmlspecialchars($activity->content);
            // $activity->text = $activity->content;
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

                $owner = Users::select('id','name','headimg','birthdate','sex','telphone')->find($groups->users_id);
                if(!$owner){
                    $owner = [];
                }
                $data['leaderinfo'] = $owner;
                $idlist = ActivityMember::where('activities_id','=',$request->input('id'))->select('users_id','role')->get();
                $deputyid = [];
                $memberid = [];
                foreach ($idlist as $key => $value) {
                    switch ($value->role) {
                        case 0:
                            array_push($memberid, $value->users_id);
                            // $memberid = $memberid.$value->users_id.',';//($key === (count($idlist)-1)?'':',');
                            break;
                        
                        case 1:
                            array_push($deputyid, $value->users_id);
                            // $deputyid = $deputyid.$value->users_id.',';//($key === (count($idlist)-1)?'':',');
                            break;
                    }
                }
                $deputys = [];
                $members = [];
                if(!empty($deputyid)){
                    $deputys = Users::whereIn('id',$deputyid)->select('id','name','headimg','birthdate','sex','telphone')->get();
                } 
                $data['deputys'] = $deputys;//副领队列表

                if(!empty($memberid)){
                    $members = Users::whereIn('id',$memberid)->select('id','name','headimg','birthdate','sex','telphone')->get();
                    // $members = Users::query('where11 id——0 in ('.$memberid.')')->select('id','name','headimg','birthdate','sex','telphone')->get();
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
                if((float)$activity->cost <= 0){
                    $data['is_pay'] = true;
                }
                if($member){
                    //若用户已经支付或者活动付费类型为
                    if($member->is_pay == 1 || $activity->pay_type == 3){
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
        $group = Groups::find($request->input('groups_id'));
        if(!$group)
            return Common::returnResult('204','该俱乐部记录不存在',"");

        if($request->has('id')){
            $id = $request->input('id');
            $activity = Activities::find($request->input('id'));
        }else{

           $activity = new Activities(); 
           $id = (string)UUID::generate();
           $activity->id = $id;
            $member = new ActivityMember();
            $member->id = UUID::generate();
            $member->role =10;
            $member->activities_id = $id;
            $member->users_id = $request->input('users_id');
            $member->status = 1;//默认通过
            $member->is_pay = 1;
            $member->comment = "创建活动人员";
            $member->save();
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
        $group = Groups::find($activity->groups_id);
        if(!$group)
            return Common::returnResult('204','该俱乐部记录不存在',"");
        $activity->pay_type = $request->input('pay_type'); //活动收费类型 0 免费，1 全包 ，2 定制，3 AA
        $activity->cost = $request->input('cost');
        $activity->cost_intro = $request->input('cost_intro');
        $activity->status = 1;
        if($activity->save()){
            $group->activities_count = (int)$group->activities_count+1;
            $group->save();
            
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
    /**
     * 分享也面
     */
    public function info(Request $request){
        // return view('web.share.activity');
        if(!$request->has('id'))
            return view('error');

        $activity = Activities::find($request->input('id'));
        if(!$activity)
            return view('error');

        $group = Groups::find($activity->groups_id);
        if(!$group)
            return view('error');


        $members = ActivityMember::join('users','users.id','=','activitymembers.users_id')
        ->where('activities_id',$request->input('id'))
        ->select('users.*')
        ->get();

        $data['activity'] = $activity;
        $data['members'] = $members;
        $data['group'] = $group;
        // return $data;
        $data['owner'] = Users::find($activity->users_id);
        return view('web.share.activity',['data'=>$data]);
    }
}
