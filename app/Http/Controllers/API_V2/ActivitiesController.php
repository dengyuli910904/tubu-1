<?php

namespace App\Http\Controllers\API_V2;

use function Couchbase\defaultDecoder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Activities;
use App\Libraries\Common;

class ActivitiesController extends Controller
{
//    protected $act;

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
     * 首页获取活动列表
     * 定位地址&（收费类型||活动类型||热门||最新）&关键词
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');
        $skip = $pageindex*$pagesize;

        $search_key = $request->input('search_key');//1、最新； 2、热门；3、标签；4、付费类型
        $search_value = $request->input('search_value');
        $wheres['status'] = array('<>','0');
        if($request->has('search_txt')){
            $wheres['title'] = array('like','%'.$request->input('search_txt').'%');
        }
        if($request->has('situation')){
            $wheres['address'] = $request->input('situation');
        }
        $orderBy = 'updated_at';
        $act = new Activities();
        switch ($search_key){
            case '2':
                $orderBy = 'follow_count';
                //根据热门排序搜索
                break;
            case '3':
                $wheres['keywords'] = $search_value;
                //根据标签获取内容
                break;
            case '4':
                $wheres['pay_type'] = $search_value; //活动类型 0 免费，1 全包 ，2 定制，3 AA
                //根据付费类型查询
                break;
            default:
                //根据发布时间查询

                break;
        }
//        return $wheres;
        $list = $act::act_list($wheres,$orderBy,$skip,$pagesize);
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
