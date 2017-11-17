<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use UUID;
use App\Models\Leavemsg;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pagesize = 30;
        $pageindex = 0;
        if($request->has('pagesize')){
            $pagesize = $request->input('pagesize');
        }
        if($request->has('pageindex')){
            $pageindex = $request->input('pageindex');
        }
        $list = Leavemsg::where('is_hidden',0)->orderBy('created_at','desc')->skip($pagesize*$pageindex)->take($pagesize)->get();
        return view('web.message.index',['data'=>$list,'count'=>count($list)]);
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
        if(empty($request->input('content')))
        {
            return Redirect::back();
        }
        $msg = Leavemsg::where('content',$request->input('content'))->where('starnum',$request->input('starnum'))->first();
        if(!$msg){
            $msg = new Leavemsg();
            $msg->id = UUID::generate();
            $msg->content = $request->input('content');
            $msg->starnum = $request->input('starnum');
            $msg->save();
//            $list = Leavemsg::where('is_hidden',0)->get();
            return Redirect::back();
//            return view('web.message.index',['data'=>$list,'count'=>count($list)]);
        }
        return Redirect::back();
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
