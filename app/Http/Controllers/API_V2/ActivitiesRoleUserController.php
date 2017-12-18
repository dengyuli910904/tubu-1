<?php

namespace App\Http\Controllers\API_V2;

use App\Models\Activities_role_user;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Libraries\Common;
use UUID;

class ActivitiesRoleUserController extends Controller
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
     * 用户与活动角色记录存储[该方法应该是在审核的时候采用事务方式执行]
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Activities_role_user::where('activities_id',$request->input('activities_id'))
            ->where('users_id',$request->input('users_id'))
            ->where('activities_role_id',$request->input('activities_role_id'))
            ->find();
        if($user)
            return Common::returnResult(201,'该用户已经承担了角色');
        else
            return Common::returnResult(200,'设置成功','');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activities_role_userController  $activities_role_userController
     * @return \Illuminate\Http\Response
     */
    public function show(Activities_role_userController $activities_role_userController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activities_role_userController  $activities_role_userController
     * @return \Illuminate\Http\Response
     */
    public function edit(Activities_role_userController $activities_role_userController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activities_role_userController  $activities_role_userController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activities_role_userController $activities_role_userController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activities_role_userController  $activities_role_userController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activities_role_userController $activities_role_userController)
    {
        //
    }
}
