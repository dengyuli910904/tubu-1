<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Libraries\Common;
use UUID;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
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
        if(!$request->has('users_id') || !$request->has('content'))
            return Common::returnResult('204','请输入反馈内容','');

        $feed = Feedback::where('users_id',$request->input('users_id'))->where('content',$request->input('content'))->first();
        if($feed)
            return Common::returnResult('203','请不要重复提交','');

        $feed = new Feedback();
        $feed->id = UUID::generate();
        $feed->users_id = $request->input('users_id');
        $feed->content = $request->input('content');
        if($feed->save()){
            return Common::returnResult('200','反馈成功',"");
        }else{
            return Common::returnResult('400','反馈失败，请重新提交','');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $about = "聚集世界每个角落，乐享乐松！多一次徒步，多一份快乐！";
        return Common::returnResult('200','获取成功',$about);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
