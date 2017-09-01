<?php

namespace App\Http\Controllers\Admin;

use App\Models\FriendshipModel;
use Illuminate\Http\Request;
use Redirect, Input;
//use UUID;
use DB;

use App\Http\Controllers\Controller;

class FriendshipController extends Controller
{
	public function __construct()
	{
		$this->middleware('check.permission');
	}

	public function index(Request $request)
	{
		$wheres = [];
		$data = $request->all();
		if (!empty($data['name'])) {
			$wheres['name'] = $data['name'];
		}
		$list = FriendshipModel::where($wheres)->orderby('created_at','desc')->paginate(5);
		return view('admin.friendship.index', ['list' => $list, 'data' => $data]);
	}

	public function show($id)
	{
	}

	public function create()
	{
		return view('admin.friendship.create');
	}

	public function store(Request $request)
	{
		$ofriendship = FriendshipModel::where('name', $request->input('name'))->first();
		if (!$ofriendship) {
			$friendship = new FriendshipModel();
			$friendship->name = $request->input('name');
			$friendship->url = $request->input('url');
			$friendship->cover = $request->input('cover');
			$friendship->is_hidden = $request->input('is_hidden');
			$friendship->sort = $request->input('sort');
			$result = $friendship->save();
			if ($result) {
				return Redirect::back();
			}
			return Redirect::back()->withInput()->withErrors('添加失败');
		}
		return Redirect::back()->withInput()->withErrors('友情链接已存在');
	}

	public function edit($id)
	{
		$data = FriendshipModel::find($id);
		return view('admin.friendship.edit', ['data' => $data]);
	}

	public function update(Request $request, $id)
	{
		$friendship = FriendshipModel::find($id);
		if ($friendship) {
			$friendship->name = $request->input('name');
			$friendship->url = $request->input('url');
			$friendship->cover = $request->input('cover');
			$friendship->is_hidden = (int) $request->input('is_hidden', 0);
			$friendship->sort = (int) $request->input('sort', 0);
			$result = $friendship->save();
			if ($result) {
				return Redirect::back();
			}
			return Redirect::back()->withInput()->withErrors('修改失败');
		}
		return Redirect::back()->withInput()->withErrors('友情链接不存在');
	}

	public function destroy($id)
	{
		$friendship = FriendshipModel::find($id);
		if ($friendship) {
			$result = $friendship->delete();
			if ($result) {
				return response()->json(['status' => 0, 'msg' => '删除成功']);
			}
			return response()->json(['status' => 0, 'msg' => '删除失败']);
		}
		return response()->json(['status' => 0, 'msg' => '友情链接不存在']);
	}


}
