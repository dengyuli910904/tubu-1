<?php

namespace App\Http\Controllers\API;

use App\Models\ActivityMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GroupMember;
use App\Models\Activities;
use App\Libraries\Common;
use App\Models\Users;
use UUID;

class AcitivityMemberController extends Controller
{
    /**
     * 查询活动用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = ActivityMember::join('users as u','u.id','=','activitymembers.users_id')
        ->where('activitymembers.activities_id','=',$request->input('activities_id'))
        ->where(function($query) use ($request){
            // ，searchtxt
        })
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->orderby('role','desc')
        ->select('activitymembers.role','u.*')
        ->get();
        foreach ($list as $val) {
            $val->age = 18;
        }
        // $memberid = '';
        // $deputyid = '';
        // // return $list;
        // foreach ($list as $key => $value) {
        //     // echo $value;
        //     switch ($value->role) {
        //         case 0:
        //             $memberid = $memberid.$value->users_id.',';
        //             break;
                
        //         case 1:
        //             $deputyid = $deputyid.$value->users_id.',';
        //             break;
        //     }
        // }
        // // return $memberid;
        // $deputys = [];
        // $members = [];
        // if(!empty($deputyid)){
        //     $deputys = Users::query(' where id in ('.$deputyid.')')->get();
        // }
        
        // $data['deputys'] = $deputys;//副领队列表
        // if(!empty($memberid)){
        //     $members = Users::query('where id in ('.$memberid.')')->get();
        // }
        
        // $data['members'] = $members;//普通成员列表
        return Common::returnResult('200','查询成功',$list);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $act = Activities::find($request->input('activities_id'));
        if(!$act){
            return Common::returnResult('204','该活动不存在',"");
        }

        $member = ActivityMember::where('activities_id',$request->input('activities_id'))->where('users_id',$request->input('users_id'))->first();
        if($member){
                if($member->is_pay == 0){
                    $need_pay = false;
                if($act->cost >0){
                    $need_pay = true;
                }
                return Common::returnResult('200','参与成功',['need_pay'=>$need_pay,'num'=>$act->cost]);
            }
            return Common::returnResult('201','您已经参与',"");
        }
        $member = new ActivityMember();
        $member->id = UUID::generate();
        $member->activities_id = $request->input('activities_id');
        $member->role = 0;
        $member->users_id = $request->input('users_id');
        $member->comment = $request->input('comment');
        if($member->save()){
            $need_pay = false;
            if($act->cost >0){
                $need_pay = true;
            }
            return Common::returnResult('200','参与成功',['need_pay'=>$need_pay,'num'=>$act->cost]);
        }else{
            return Common::returnResult('400','参与失败',"");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ActivityMember  $activityMember
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityMember $activityMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ActivityMember  $activityMember
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityMember $activityMember)
    {
        //
    }

    /**
     * 设置成员支付状态
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityMember  $activityMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $member = ActivityMember::where('activities_id',$request->input('activities_id'))->where('users_id',$request->input('users_id'))->first();
        if(!$member){
            return Common::returnResult('204','该用户没有参与记录',"");
        }
        $member = ActivityMember::where('users_id',$request->input('users_id'))->where('activities_id',$request->input('activities_id'))->first();
        $member->is_pay = 1;//
        $member->pay_path = 2;//$request->input('pay_path');//1正常支付，2管理员操作，3其他
        if($member->save()){
            return Common::returnResult('200','修改成功',"");
        }else{
            return Common::returnResult('400','修改失败',"");
        }
    }

    /**
     * 设置成员成为副领队
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityMember  $activityMember
     * @return \Illuminate\Http\Response
     */
    public function setrole(Request $request)
    {
        $member = ActivityMember::where('users_id',$request->input('u_id'))->where('activities_id',$request->input('activities_id'))->first();
        if(!$member){
            $member->role = 1; //副领队 ，0： 普通成员
            $member->is_pay = 1;
            if($member->save()){
                return Common::returnResult('200','修改成功',"");
            }else{
                return Common::returnResult('400','修改失败',"");
            }
        }else{
            $activity = Activities::find($request->input('activities_id'));
            if(!$activity){
                return Common::returnResult('204','活动记录不存在',"");
            }
            $groups = GroupMember::where('groups_id',$activity->groups_id)->where('users_id',$request->input('u_id'))->first();
            if(!$groups){
                return Common::returnResult('201','该用户还不属于我们圈子，请先邀请加入圈子在进行角色设置',"");
            }
            $member = new ActivityMember();
            $member->activities_id = $request->input('activities_id');
            $member->role = 1;
            $member->is_pay = 1;
            $member->comment = '由领队设置成为副领队';
            $member->users_id = $request->intpu('users_id');
            $member->comment = $request->input('comment');
            if($member->save()){
                return Common::returnResult('200','设置成功',"");
            }else{
                return Common::returnResult('400','设置失败',"");
            }
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ActivityMember  $activityMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityMember $activityMember)
    {
        //
    }
}
