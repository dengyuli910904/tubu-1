<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Activities extends Model
{
    protected $table="activities";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
	public function getCreatedAtAttribute($date)
    {
         // 默认100天前输出完整时间，否则输出人性化的时间
        if (Carbon::now() > Carbon::parse($date)->addDays(100)) {
            return Carbon::parse($date);
        }

        return Carbon::parse($date)->diffForHumans();
    }

    /**
     * 查询活动列表
     */
    public static function  act_list($act,$orderBy,$skip = 0,$pagesize = 10){
        $data = $act//::where($wheres)
        ->skip($skip)
        ->take($pagesize)
        ->select('id','cover','title','starttime','endtime',
                     'enrol_starttime','enrol_endtime','cost','limit_count','participation_count',
                     'apply_count','status','keywords','created_at','pay_type')
        ->orderBy($orderBy,'desc')
        ->get();
//            self::where(array("status"=>["<>","0"]))->orderBy($orderBy)->skip($skip)->take($pagesize)->get();
        return $data;
    }
}
