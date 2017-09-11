<?php

namespace App\Models;
use DB;

use Illuminate\Database\Eloquent\Model;

class Verifycode extends Model
{
    protected $table="verifycode";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];

	/**
	 * 验证
	 */
	public static function valid($code,$id,$phone,$type){
		//Verifycode
		$valid = DB::table('verifycode')
		->where('id',$id)->where('code',$code)
		->where('phone',$phone)
		->where('is_valid','0')
		->where('type',$type)
		->first();
		if(!$valid){
			return -1; //验证码错误
		}
		// $valid->is_valid = 1;
		// $valid->save();

		$v = DB::table('verifycode')->where('id',$valid->id)->update(['is_valid'=>1]);
		//判断当前时间与之前的时间
		$startdate= $valid->created_at;
		$enddate= time();
		// $date=floor((strtotime($enddate)-strtotime($startdate))/86400);
		// $hour=floor((strtotime($enddate)-strtotime($startdate))%86400/3600);
		$minute=floor((strtotime($enddate)-strtotime($startdate))%86400/60);
		// $second=floor((strtotime($enddate)-strtotime($startdate))%86400%60);
		if($minute >30){
			return -2; //超时
		}
		return 1;

	}
}
