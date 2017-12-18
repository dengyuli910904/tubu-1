<?php

namespace App\Http\Controllers\API_V2;

use App\Http\Controllers\Controller;
use App\Models\Activities_role_apply;
use Illuminate\Http\Request;
use App\Libraries\Common;
use Illuminate\Support\Facades\Redirect;
use UUID;
use App\Models\Activities;
use App\Models\Activities_role;
use App\Models\ActivityMember;

class ActivitiesRoleApplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->has('id')){

            return view('lesong.act.role',['data' => $request->all()]);
        }else{
            return Redirect::back();
        }
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
        $act_role = ActivityMember::where('activities_id',$request->input('activities_id'))->where('users_id',$request->input('users_id'))->first();
        // Activities::where('id',$request->input('activities_id'))->first();
        if(!$act_role){
            return Common::returnResult(204,'您还未参与该活动','');
        }else{
            if($act_role->is_pay == 0){
                return Common::returnResult(204,'请先支付参与活动的费用','');
            }
        }
        
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
        $apply = Activities_role_apply::where('activities_id',$request->input('activities_id'))->where('users_id',$request->input('users_id'))->first();
        if(!$apply)
            return Common::returnResult(404,'该用户没有申请记录','');
        $status = 1;
        if($request->has('status')){
            $status = $request->input('status');
        }
        $is_pass = $status;
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

    /**
     * find someone's role of the activity
     * @param Request $request
     */
    public function userhasrole(Request $request){
        if($request->has('users_id') && $request->has('id')){
            $data = $request->all();
            $role = Activities_role::where('activities_id',$data['id'])->where('users_id',$data['users_id'])->select('activities_role_id')->first();
            if(!$role){
                //用户还没有角色
                $apply = Activities_role_apply::where('activities_id',$data['id'])->where('users_id',$data['users_id'])->select('activities_role_id','is_pass')->first();
                if(!$apply){
                    $result['role_status'] = -1;//还未申请过
                }else{
                    $result['apply'] = $apply;
                    $result['role_status'] = $apply->is_pass; //申请了，审核状态中
                }
            }else{
                //用户已经承担了角色
                $result['role'] = $role;
                $result['role_status'] = -2; ////用户已经承担了角色
            }
            return Common::returnResult(200,'查询成功',['data' => $result]);
        }else{
            return Common::returnResult(400,'参数错误','');
        }
    }
}
