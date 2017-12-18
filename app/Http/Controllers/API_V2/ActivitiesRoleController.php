<?php

namespace App\Http\Controllers\API_V2;

use App\Models\Activities_role;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Libraries\Common;

class ActivitiesRoleController extends Controller
{
    /**
     * 获取活动的角色列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $role = Activities_role::get();
        if(!$role)
            return Common::returnResult(204,'暂无数据','');
        return Common::returnResult(200,'获取数据成功',$role);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activities_roleController  $activities_roleController
     * @return \Illuminate\Http\Response
     */
    public function show(Activities_roleController $activities_roleController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activities_roleController  $activities_roleController
     * @return \Illuminate\Http\Response
     */
    public function edit(Activities_roleController $activities_roleController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activities_roleController  $activities_roleController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activities_roleController $activities_roleController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activities_roleController  $activities_roleController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activities_roleController $activities_roleController)
    {
        //
    }

}
