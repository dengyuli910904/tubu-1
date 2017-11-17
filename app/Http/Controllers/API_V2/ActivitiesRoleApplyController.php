<?php

namespace App\Http\Controllers\API_V2;

use App\Http\Controllers\Controller;
use App\Models\Activities_role_apply;
use Illuminate\Http\Request;
use App\Libraries\Common;
use UUID;
use App\Models\Activities;

class ActivitiesRoleApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * 任务认领申请
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $act = Activities::where('id',$request->input('activities_id'))->first();
        $apply = Activities_role_apply::where('activities_id',$request->input('activities_id'))->where('users_id',$request->input('users_id'))->first();
        if($apply)
            return Common::returnResult(203,'您已进行过该活动的任务认领','');
        $apply = new Activities_role_apply();
        $apply->id = UUID::generate();
        $apply->activities_id = $request->input('activities_id');
        $apply->users_id = $request->input('users_id');
        $apply->activities_role_id = $request->input(
            'activities_role_id');
        $result = $apply->save();
        if($result)
            return Common::returnResult(200,'您的申请已提交领队审核','');
        else
            return Common::returnResult(400,'您的申请提交失败，请刷新之后重新申请','');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activities_role_applyController  $activities_role_applyController
     * @return \Illuminate\Http\Response
     */
    public function show(Activities_role_applyController $activities_role_applyController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activities_role_applyController  $activities_role_applyController
     * @return \Illuminate\Http\Response
     */
    public function edit(Activities_role_applyController $activities_role_applyController)
    {
        //
    }

    /**
     * 审核任务认领申请
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activities_role_applyController  $activities_role_applyController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $apply = Activities_role_apply::where('activities_id',$request->input('activities_id'))->where('users_id',$request->input('users_id'))->find();
        if(!$apply)
            return Common::returnResult(404,'该用户没有申请记录','');
        $is_pass = $request->inpu('status') ?1:2;
        $apply->is_pass = $is_pass;
        $result = $apply->save();
        if($result)
            return Common::returnResult(200,'审核成功','');
        else
            return Common::returnResult(400,'审核失败，请重新刷新之后再试','');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activities_role_applyController  $activities_role_applyController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activities_role_applyController $activities_role_applyController)
    {
        //
    }
}
