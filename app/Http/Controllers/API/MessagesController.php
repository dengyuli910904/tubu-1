<?php

namespace App\Http\Controllers\API;

use App\Models\Messages;
use App\Models\Users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use UUID;
class MessagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $list = Messages::where('activites_id','=',$request->input('activites_id'))->get();
        foreach ($list as $key => $value) {
            $user = Users::find($value->users_id);
            $list['userinfo'] = $user;
            if($value->parent_id != ""){
                $message = Messages::find($value->id);
                $u = Users::find($message->users_id);
                $list['replayuser'] = $u;
            }else{
                $list['replayuser'] = array();
            }
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
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = new Messages();
        $message->id = UUID::generate();
        $message->users_id = $request->input('users_id');
        $message->content = $request->input('content');
        $message->activites_id = $request->input('activites_id');
        if($request->has('parent_id')){
            $message->parent_id = $request->input('parent_id');
        }
        if($message->save()){
            return Common::returnResult('200','留言成功',"");
        }else{
            return Common::returnResult('400','留言失败',"");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function show(Messages $messages)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function edit(Messages $messages)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $message = Messages::find($request->input('id'));
        $message->status = $request->input('status');
        if($message->save()){
            return Common::returnResult('200','修改成功',"");
        }else{
            return Common::returnResult('400','修改失败',"");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Messages  $messages
     * @return \Illuminate\Http\Response
     */
    public function destroy(Messages $messages)
    {
        //
    }
}
