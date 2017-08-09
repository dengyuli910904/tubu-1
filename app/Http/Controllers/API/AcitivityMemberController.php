<?php

namespace App\Http\Controllers\API;

use App\Models\ActivityMember;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AcitivityMemberController extends Controller
{
    /**
     * 查询活动用户列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = ActivityMember::where('activities_id','=',$request->input('activities_id'))
        ->where(function($query) use ($request){
            // ，searchtxt
        })
        ->select('users_id','role')->get();
        foreach ($list as $key => $value) {
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
        $member = new ActivityMember();
        $member->activities_id = $request->input('activities_id');
        $member->role = 0;
        $member->users_id = $request->intpu('users_id');
        $member->comment = $request->input('comment');
        if($member->save()){
            return Common::returnResult('200','参与成功',"");
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
        $member = ActivityMember::where('users_id',$request->input('users_id'))->where('activities_id',$request->input('activities_id'))->first();
        $member->role = 1; //副领队 ，0： 普通成员
        if($member->save()){
            return Common::returnResult('200','修改成功',"");
        }else{
            return Common::returnResult('400','修改失败',"");
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
