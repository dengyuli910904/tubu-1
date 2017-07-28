<?php

namespace App\Http\Controllers\API;

use App\Models\Evaluations;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EvaluationsController extends Controller
{
    /**
     * 获取活动评价列表
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = Evaluations::where('activites_id','=',$request->input('activites_id'))->get();
        foreach ($list as $key => $value) {
            $user = Users::find($value->users_id);
            $list['userinfo'] = $user;
        }
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
        $evalustion = new Evaluations();
        $evalustion->id = UUID::generate();
        $evalustion->users_id = $request->input('users_id');
        $evalustion->content = $request->input('content');
        $evalustion->activites_id = $request->input('activites_id');
        $evalustion->starlevel = $request->input('starlevel');
        if($evalustion->save()){
            return Common::returnResult('200','评论成功',"");
        }else{
            return Common::returnResult('400','评论失败',"");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Evalustions  $evalustions
     * @return \Illuminate\Http\Response
     */
    public function show(Evalustions $evalustions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Evalustions  $evalustions
     * @return \Illuminate\Http\Response
     */
    public function edit(Evalustions $evalustions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Evalustions  $evalustions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $evalution = Evaluations::find($request->input('id'));
        $evalution->status = $request->input('status');
        if($evalution->save()){
            return Common::returnResult('200','修改成功',"");
        }else{
            return Common::returnResult('400','修改失败',"");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Evalustions  $evalustions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Evalustions $evalustions)
    {
        //
    }
}
