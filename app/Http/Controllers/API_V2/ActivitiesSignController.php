<?php

namespace App\Http\Controllers\API_V2;

use App\Models\Activities_sign;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UUID;
use App\Libraries\Common;
use App\Models\Activities;
use App\Models\ActivityMember;
use App\Models\Activities_sign_rule;

class ActivitiesSignController extends Controller
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
     * 活动签到
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $member = ActivityMember::where('activities_id',$request->input('activities_id'))
            ->where('users_id',$request->input('users_id'))
            ->first();
        if(!$member)
            return Common::returnErrorResult(204,'该用户还没有参加活动','');

         $sign_rule = Activities_sign_rule::where('activities_id',$request->input('activities_id'))
//             ->where('users_id',$request->input('users_id'))
             ->first();
         if(!$sign_rule){
             return Common::returnErrorResult(400,'该活动还未发起签到...','');
         }else{
             //判断是否有迟到
         }
         $sign = new Activities_sign();
         $sign->id = UUID::generate();
         $sign->activities_id = $request->input('activities_id');
         $sign->users_id = $request->input('users_id');
         $result = $sign->save();
         if(!$result)
             return Common::returnErrorResult(400,'签到失败！请刷新之后重试...','');
         else
             return Common::returnErrorResult(200,'签到成功！','');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activities_signController  $activities_signController
     * @return \Illuminate\Http\Response
     */
    public function show(Activities_signController $activities_signController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activities_signController  $activities_signController
     * @return \Illuminate\Http\Response
     */
    public function edit(Activities_signController $activities_signController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activities_signController  $activities_signController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activities_signController $activities_signController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activities_signController  $activities_signController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activities_signController $activities_signController)
    {
        //
    }
}
