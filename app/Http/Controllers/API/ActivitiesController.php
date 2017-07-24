<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Libraries\Common;

class ActivitiesController extends Controller
{
    /**
     * 获取活动列表,非登录用户,查询所有活动
     */
    public function index(Request $request){
    	$list = Activities::where('is_able','=','1')
    		->select('id','cover','title''starttime','endtime',
    				 'enrol_starttime','enrol_endtime','cost','limit_count','participation_count',
    				 'apply_count','status','keywords')
    		->get();
    	return Common::returnResult('200','查询成功',$list);
    }

    /**
     * 获取活动详情
     */
    public function show(Request $request){
    	$activity = Activities::find($request->input('id'));
    	if(!empty($activity)){
    		
    	}else{
    		return Common::returnResult('400','该记录不存在',"");
    	}
    }
}
