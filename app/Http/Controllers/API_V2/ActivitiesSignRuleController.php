<?php

namespace App\Http\Controllers\API_V2;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activities_sign_rule;
use UUID;
use App\Libraries\Common;

class ActivitiesSignRuleController extends Controller
{
    public function __construct(Request $request)
    {
        //        if($request->input('id')){
        //            self::$act = Activities::find($request->input('id'));
        //        }else{
        //            self::$act = new Activities();
        //        }
        //        return self::$act;
    }
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
     * 设置签到规则
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = Activities_sign_rule::where('activities_id',$request->input('activities_id'))->first();
        if(!$rule)
        {
            $rule = new Activities_sign_rule();
            $rule->id = UUID::generate();
        }
        $rule->activities_id = $request->input('activities_id');
        $rule->deadline = $request->input('deadline');
        $rule->publishway = $request->input('publish_way');
        $rule->publish_num = $request->input('publish_num');
        $result = $rule->save();
        if($result){
            return Common::returnResult(200,'设置成功','');
        }else{
            return Common::returnResult(400,'设置失败','');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Activities_sign_ruleController  $activities_sign_ruleController
     * @return \Illuminate\Http\Response
     */
    public function show(Activities_sign_ruleController $activities_sign_ruleController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Activities_sign_ruleController  $activities_sign_ruleController
     * @return \Illuminate\Http\Response
     */
    public function edit(Activities_sign_ruleController $activities_sign_ruleController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Activities_sign_ruleController  $activities_sign_ruleController
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Activities_sign_ruleController $activities_sign_ruleController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Activities_sign_ruleController  $activities_sign_ruleController
     * @return \Illuminate\Http\Response
     */
    public function destroy(Activities_sign_ruleController $activities_sign_ruleController)
    {
        //
    }
}
