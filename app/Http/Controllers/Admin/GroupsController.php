<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Groups;
use App\Models\Activities;
use Redirect,Input;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        // $users_id = 1;
        $list = Groups::paginate(5);
        return view('admin.groups.index',['data'=>$list]);
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
        // var_dump($request);
        // return;
        $group = Groups::find($id);
        if(!$group)
            return Redirect::back()->withInput()->withErrors('未找到记录');

        if($request->has('handle_type')){
            switch ($request->input('handle_type')) {
                case 'status':
                    $group->status = !$group->status;
                    break;
                case 'is_pass':
                    $group->is_pass = $request->input('is_pass');
                    break;
            }
            if($group->save()){
                return Redirect::back();
            }else{
                return Redirect::back()->withInput()->withErrors('修改失败');
            }
        }else{
            return Redirect::back()->withInput()->withErrors('参数错误');
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
        $model = Groups::find($id);
        if(!empty($model)){
            if($model->delete()){
                return response()->json(['status' => 0, 'msg' => '删除成功']);
            }else{
                return response()->json(['status' => 0, 'msg' => '删除失败']);
            }
        }else{
            return response()->json(['status' => 0, 'msg' => '圈子不成功']);
        }
    }
}
