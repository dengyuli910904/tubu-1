<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\StepCounting;
use UUID;
use App\Libraries\Common;
use App\Models\Users;
use DB;

class StepCountingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dt = \Carbon\Carbon::now();
        $year = $dt->year;
        $month = $dt->month;
        $range1 =  \Carbon\Carbon::createFromDate($year,1,1);
        $range2 = \Carbon\Carbon::createFromDate($year,$month,1);
         // echo $range;
        $year_count = StepCounting::where('created_at', '>=', $range1)
            ->where('users_id',$request->input('users_id'))
            ->get([
                // DB::raw('Date(created_at) as date'),
                DB::raw('sum(count) as value')
            ])->first();
        $month_count = StepCounting::where('created_at', '>=', $range2)
            ->where('users_id',$request->input('users_id'))
            ->get([
                // DB::raw('Date(created_at) as date'),
                DB::raw('sum(count) as value')
            ])->first();
            $data = [];
        $data['year'] = ['key'=>$year,'value'=>$year_count['value']];
        $data['month'] = ['key'=>$month,'value'=>$month_count['value']];
        return Common::returnResult(200,'获取成功',$data);
    }

    /**
     * 获取本月记录
     */
    public function getlist(Request $request){
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $dt = \Carbon\Carbon::now();
        $year = $dt->year;
        $month = $dt->month;
        $range2 = \Carbon\Carbon::createFromDate($year,$month,1);

        $list = StepCounting::where('created_at', '>=', $range2)
        ->where('users_id',$request->input('users_id'))
        ->skip($pageindex*$pageindex)
        ->take($pagesize)
        ->orderby('end_time','desc')
        ->get();
        foreach ($list as $step) {
            $step->time = Common::left_time(strtotime($step->end_time),strtotime($step->start_time),3);
        }
        return Common::returnResult(200,'获取成功',$list);
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
        if(!$request->has('users_id'))
            return Common::returnResult(400,'参数不正确','');

        $user =Users::find($request->input('users_id'));
        if(!$user)
            return Common::returnResult(400,'该用户记录不存在或者已经被禁用','');

        $step = StepCounting::where('users_id',$request->input('users_id'))->whereNull('end_time')->orderby('created_at','desc')->first();
        if($step)
            $step->delete();
            // return Common::returnResult(200,'正在计步','');
        $step = new StepCounting();
        $step->id = UUID::generate();
        $step->users_id = $request->input('users_id');
        $step->start_time = date('y-m-d h:i:s',time());
        $step->count = 0;
        if($step->save()){
            return Common::returnResult(200,'操作成功','');
        }else{
            return Common::returnResult(400,'失败，请重试','');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(!$request->has('users_id'))
            return Common::returnResult(400,'参数不正确','');

        $user =Users::find($request->input('users_id'));
        if(!$user)
            return Common::returnResult(400,'该用户记录不存在或者已经被禁用','');

        $step = StepCounting::where('users_id',$request->input('users_id'))->whereNull('end_time')->orderby('created_at','desc')->first();
        if(!$step)
            return Common::returnResult(400,'您没有开始记录','');

        $step->id = UUID::generate();
        $step->users_id = $request->input('users_id');
        $step->count = $request->input('count');
        $step->end_time = date('y-m-d h:i:s',time());
        if($step->save()){
            return Common::returnResult(200,'成功','');
        }else{
            return Common::returnResult(400,'失败，请重试','');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * 计步分享
     */
    public function info(Request $request){
        if(!$request->has('id'))
            return view('error');
        $step = StepCounting::find($request->input('id'));
        if(!$step)
            return view('error');
        $user = Users::find($step->users_id);
        if(!$user)
            return view('error');
        $step->use_time = Common::left_time(strtotime($step->end_time),strtotime($step->start_time),3);
        $step->date = date("Y-m-d",(int)strtotime($step->end_time));
        $data['step'] = $step;
        $data['user'] = $user;
        return view('web.share.step',['data'=>$data]);
    }
}
