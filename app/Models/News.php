<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use JPush\Client as JPushClient;
use UUID;

class News extends Model
{
    protected $table="news";
    public $timestamp = true;
    protected $casts = [
	    'id' => 'string'
	];
	/**
	 * 发送圈子内容消息-圈子
	 */
	public static function send_group_msg($users_id,$groups_id,$content){
		// $jpush = new JPushClient(config('jpush.appKey'), config('jpush.masterSecret'));
	 //    $response = $jpush->push()
	 //        ->setPlatform('all')
	 //        ->addAllAudience( ["registration_id" => $users_id])
	 //        ->setNotificationAlert($content)
	 //        ->send();
	 //    if($response['http_code'] == 200){
	    	$new = new News();
            $new->id =  UUID::generate();
            $new->users_id = $users_id;
            $new->content = $content;// $apply->status ==1?($apply->type == 1?'您的加入申请已经通过审核':'您邀请的用户已同意加入'):($apply->type == 1?'您的加入申请被拒绝':'您邀请的用户已拒绝加入');
            $new->groups_id = $groups_id;// $apply->groups_id;
            $new->type = 1;
            $new->save();
            return true;
	    // }
	    // else{
	    // 	return false;
	    // }
	}

	/**
	 * 发送活动内容消息-活动
	 */
	public static function send_act_msg($users_id,$activities_id,$content){
		// $jpush = new JPushClient(config('jpush.appKey'), config('jpush.masterSecret'));
	 //    $response = $jpush->push()
	 //        ->setPlatform('all')
	 //        ->addAllAudience( ["registration_id" => $users_id])
	 //        ->setNotificationAlert($content)
	 //        ->send();
	 //    if($response['http_code'] == 200){
	    	$new = new News();
            $new->id =  UUID::generate();
            $new->users_id = $users_id;
            $new->content = $content;// $apply->status ==1?($apply->type == 1?'您的加入申请已经通过审核':'您邀请的用户已同意加入'):($apply->type == 1?'您的加入申请被拒绝':'您邀请的用户已拒绝加入');
            $new->activities_id = $activities_id;// $apply->groups_id;
            $new->type = 2;
            $new->save();
            return true;
	    // }
	    // else{
	    // 	return false;
	    // }
	}

	public static function sendall($content){
		$jpush = new JPushClient(config('jpush.appKey'), config('jpush.masterSecret'));
	    $response = $jpush->push()
	        ->setPlatform('all')
	        ->addAllAudience()
	        ->setNotificationAlert($content)
	        ->send();
	    // print_r($response);
	    if($response['http_code'] == 200){
	    	$new = new News();
            $new->id =  UUID::generate();
            $new->users_id = $users_id;
            $new->content = $content;// $apply->status ==1?($apply->type == 1?'您的加入申请已经通过审核':'您邀请的用户已同意加入'):($apply->type == 1?'您的加入申请被拒绝':'您邀请的用户已拒绝加入');
            $new->activities_id = $activities_id;// $apply->groups_id;
            $new->type = 0;
            $new->save();
            return true;
	    }
	    else{
	    	return false;
	    }
	}
}
