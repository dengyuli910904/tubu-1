<?php

namespace App\Http\Controllers\API;

use App\Libraries\Common;
use App\Models\Activities;
use App\Models\ActivityMember;
use App\Models\Evaluations;
use App\Models\GroupMember;
use App\Models\Messages;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users;
use App\Models\ActivitiesFollow;
use App\Models\GroupsFollow;
use App\Models\ActivitiesCollect;
use App\Models\GroupsApply;
use App\Models\Groups;
use App\Models\News;
use App\Models\Verifycode;
use DB;
use UUID;

class UsersController extends Controller
{

    /**
     * 修改用户信息-电话
     */
    public function alter_tel(Request $request){
        $user = Users::find($request->input('users_id'));
        if(!$user){
            return Common::returnErrorResult('400', "用户记录不存在");
        }
        if($user->telphone == $request->input('phone')){
            return Common::returnErrorResult('203', "没有信息进行修改");
        }
        $user->telphone = $request->input('phone');
        if($user->save()){
             return Common::returnResult('200', "设置成功", $user);
        } else {
            return Common::returnErrorResult('400', "设置失败");
        }
    }
    /**
     * 修改用户信息- 头像
     */
    public function alter_img(Request $request){
        $user = Users::find($request->input('users_id'));
        if(!$user){
            return Common::returnErrorResult('400', "用户记录不存在");
        }
        if($user->headimg == $request->input('url')){
            return Common::returnErrorResult('203', "没有信息进行修改");
        }
        $user->headimg = $request->input('url');
        if($user->save()){
             return Common::returnResult('200', "设置成功", $user);
        } else {
            return Common::returnErrorResult('400', "设置失败");
        }
    }
    /**
     * 修改用户信息 - 性别
     */
    public function alter_sex(Request $request){
        $user = Users::find($request->input('users_id'));
        if(!$user){
            return Common::returnErrorResult('400', "用户记录不存在");
        }
        if($user->sex == $request->input('sex')){
            return Common::returnErrorResult('203', "没有信息进行修改");
        }
        $user->sex = $request->input('sex');
        if($user->save()){
             return Common::returnResult('200', "设置成功", $user);
        } else {
            return Common::returnErrorResult('400', "设置失败");
        }
    }
    /**
     * 修改用户信息 - 出生日期
     */
    public function alter_birth(Request $request){
        $user = Users::find($request->input('users_id'));
        if(!$user){
            return Common::returnErrorResult('400', "用户记录不存在");
        }
        if($user->birthdate == $request->input('birthdate')){
            return Common::returnErrorResult('203', "没有信息进行修改");
        }
        $user->birthdate = $request->input('birthdate');
        if($user->save()){
             return Common::returnResult('200', "设置成功", $user);
        } else {
            return Common::returnErrorResult('400', "设置失败");
        }
    }
    /**
     * 修改用户信息 - 昵称
     */
    public function alter_name(Request $request){
        $user = Users::find($request->input('users_id'));
        if(!$user){
            return Common::returnErrorResult('400', "用户记录不存在");
        }
        if($user->name == $request->input('name')){
            return Common::returnErrorResult('203', "没有信息进行修改");
        }
        $user->name = $request->input('name');
        if($user->save()){
             return Common::returnResult('200', "设置成功", $user);
        } else {
            return Common::returnErrorResult('400', "设置失败");
        }
    }

    /**
     * @param Request $request
     * @return mixed
     * 登录
     */
    public function login(Request $request)
    {
        $phone = $request->input("phone");
        $passwd = $request->input("pwd");

        if (empty($phone) || empty($passwd)) {
            return Common::returnErrorResult("400", "缺少参数");
        }
        $user = Users::where('telphone', $phone)->first();
        $pwd = md5($passwd.$user->solt);
       
        if ($user->pwd == $pwd) {
            return Common::returnResult('200', "登录成功", $user);
        } else {
            return Common::returnErrorResult('400', "用户名或密码错误");
        }
    }

    /**
     * 第三方授权登陆
     */
    public function third_party_wx_login(Request $request){
        $user = Users::where('wx_openid',$request->input('openid'))->first();
        if($user){
            $user->is_bind_tel = false;
            if(!empty($user->telphone)){
                $user->is_bind_tel = true;
            }
            return Common::returnResult('200', "登录成功", $user);
        }else{
            $user = new Users();
            $id = UUID::generate();
            $user->id = (string)$id;
            $user->name = $request->input('name');
            $user->headimg = $request->input('headimg');
            $user->sex = $request->input('sex');
            if($user->save()){
                $user->id = (string)$id;
                $user->is_bind_tel = false;
                return Common::returnResult('200', "登录成功", $user);
            }else{
                return Common::returnResult('400', "登录失败，请重新登录");
            }
        }
    }
    public function third_party_sina_login(Request $request){
        $user = Users::where('sina_openid',$request->input('openid'))->first();
        if($user){
            $user->is_bind_tel = false;
            if(!empty($user->telphone)){
                $user->is_bind_tel = true;
            }
            return Common::returnResult('200', "登录成功", $user);
        }else{
            $user = new Users();
            $id = UUID::generate();
            $user->id = (string)$id;
            $user->name = $request->input('name');
            $user->headimg = $request->input('headimg');
            $user->sex = $request->input('sex');
            if($user->save()){
                $user->id = (string)$id;
                $user->is_bind_tel = false;
                return Common::returnResult('200', "登录成功", $user);
            }else{
                return Common::returnResult('400', "登录失败，请重新登录");
            }
        }
    }
    public function third_party_qq_login(Request $request){
        $user = Users::where('qq_openid',$request->input('openid'))->first();
        if($user){
            $user->is_bind_tel = false;
            if(!empty($user->telphone)){
                $user->is_bind_tel = true;
            }
            return Common::returnResult('200', "登录成功", $user);
        }else{
            $user = new Users();
            $id = UUID::generate();
            $user->id = (string)$id;
            $user->name = $request->input('name');
            $user->headimg = $request->input('headimg');
            $user->sex = $request->input('sex');
            if($user->save()){
                $user->id = (string)$id;
                $user->is_bind_tel = false;
                return Common::returnResult('200', "登录成功", $user);
            }else{
                return Common::returnResult('400', "登录失败，请重新登录");
            }
        }
    }
    /**
     * 注册
     */
    public function register(Request $request){
        // $v = New Verifycode();
        $valid = Verifycode::valid($request->input('code'),$request->input('code_id'),$request->input('phone')); // 
        switch ($valid) {
            case -1:
                return Common::returnResult("201",'验证码错误',''); 
                break;
            
            case -2:
                return Common::returnResult("201",'验证码超时，请重新发送',''); 
                break;
        }
        // if($valid){
            $valid = Verifycode::where('id',$request->input('code_id'))->where('code',$request->input('code'))->where('is_valid','0')->first();
            $valid->is_valid = 1;
            $valid->save();
            $user = Users::where('telphone',$request->input('phone'))->first();
            if(!$user){
                $solt = UUID::generate();
                $user = new Users();
                $user->id = UUID::generate();
                $user->telphone = $request->input('phone');
                $user->solt = $solt;
                $user->pwd = md5($request->input('pwd').$solt);
                $user->headimg = 'http://lstubu-img-app.oss-cn-shenzhen.aliyuncs.com/timg.jpg';
                if($user->save()){
                    $user = Users::where('telphone', $request->input('phone'))->where('pwd',$user->pwd)->first();
                    return Common::returnResult('200', "注册成功",$user);
                }else{
                    return Common::returnResult('400', "注册失败",'');
                }
            }else{
                return Common::returnResult('201', "该手机号已注册",'');
            }
        // }else{
        //     return Common::returnResult("201",'验证码错误','');   
        // }
    }

    public function myMesage(Request $request)
    {
        // if(!$request->has('users_id'))
        //     return Common::returnErrorResult('400', "参数不正确");
        // $user = Users::find($request->input('users_id'));
        // if(!$user)
        //     return Common::returnErrorResult('400', "用户记录不存在");

        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = Messages::where('users_id', $request->input("users_id"))
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->get();
        return Common::returnSuccessResult('200', '', $list);
    }

    public function myComment(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = Messages::where('users_id', $request->input("users_id"))
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->get();
        return Common::returnSuccessResult('200', '', $list);
    }

    public function myReply(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = Evaluations::where('users_id', $request->input('users_id'))
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->get();
        foreach ($list as $key => $value) {
            $activity = Activities::find($value->activities_id);
            $list['activity'] = $activity;
        }
        return Common::returnSuccessResult('200', '', $list);
    }

    /**
     * 我关注的活动
     */
    public function watchActivity(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = ActivitiesFollow::where('user_id',$request->input('users_id'))
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->get();
        return Common::returnSuccessResult('200', '获取成功', $list);
    }

    /**
     * 我关注的圈子
     */
    public function watchCircle(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = GroupsFollow::join('activities as a','a.id','=','activities_follow.activities_id')
        ->where('user_id',$request->input('users_id'))
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->get();
        return Common::returnSuccessResult('200', '获取成功', $list);
    }
    /**
     * 我收藏的活动
     */
    public function favoriteActivity(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = ActivitiesCollect::join('activities as a','a.id','=','activities_collect.activities_id')
        ->where('activities_collect.user_id',$request->input('users_id'))
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->get();
        return Common::returnSuccessResult('200', '获取成功', $list);
    }

    /**
     * 我参与的活动
     */
    public function myActivity(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = ActivityMember::join('activities', 'activities.id','=','activitymembers.users_id')
            ->where('activitymembers.users_id', $request->input('users_id'))
            ->skip($pagesize*$pageindex)
            ->take($pagesize)
            ->get();
        return Common::returnSuccessResult('200', '', $list);
    }

    /**
     * 我加入的圈子
     */
    public function myCircle(Request $request)
    {   
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = GroupMember::join('groups', 'groups.id','=','groupmember.users_id')
            ->where('groupmember.users_id', $request->input('users_id'))
            ->skip($pageindex*$pagesize)
            ->take($pagesize)
            ->get();
        return Common::returnSuccessResult('200', '', $list);
    }

    public function myCreatedCirclesActivity(Request $request)
    {
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = Activities::where('users_id', $request->input('users_id'))
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->get();
        return Common::returnSuccessResult('200', '获取成功', $list);
    }

    /**
     * 我的活动消息
     */

    /**
     * 我的通知消息
     */
    public function systemmsg(Request $request){
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');

        $list = News::join('users as u','u.id','=','news.users_id')
        ->join('activities as a','a.id','=','news.activities_id')
        ->join('groups as g','g.id','=','news.groups_id')
        ->where('news.type','0')->orWhere('news.users_id',$request->input('users_id'))
        ->select('news.content','a.title as act_name','a.cover as act_cover',
            'g.name as group_name','u.name as user_name','u.headimg',
            'g.cover as group_cover','g.id as groups_id','a.id as act_id',
            'news.created_at','news.type','news.status')
        ->orderby('news.created_at')
        ->skip($pagesize*$pageindex)
        ->take($pagesize)
        ->get();
        foreach ($list as $val) {
            //0 系统消息,1 圈子消息 2 活动消息 
            switch ($val->type) {
                case 0:
                    $val->cover = "http://lstubu-img-app.oss-cn-shenzhen.aliyuncs.com/QQ20170822154133.png";
                    $val->title = "乐松";
                    if(!empty($val->user_name)){
                        $val->content = $val->user_name.$val->content;
                    }
                    
                    break;
                case 1:
                    $val->cover = $val->group_cover;
                    $val->title = $val->group_name;
                    if(!empty($val->user_name)){
                        $val->content = $val->user_name.$val->content;
                    }
                    break;
                case 2:
                    $val->cover = $val->act_cover;
                    $val->title = $val->act_name;
                    if(!empty($val->user_name)){
                        $val->content = $val->user_name.$val->content;
                    }
                // case 3:
                //     $val->cover = $val->headimg;
                //     $val->title = $val->act_name;
                //     if(!empty($val->user_name)){
                //         $val->content = $val->user_name.$val->content;
                //     }
                    break;
            }
        }
        return Common::returnSuccessResult('200', '获取成功', $list);
    }

    /**
     * 我的审核消息
     */
    public function applymsg(Request $request){
        $pageindex = 0;
        $pagesize = 5;
        if($request->has('pageindex'))
            $pageindex = $request->input('pageindex');
        if($request->has('pagesize'))
            $pagesize = $request->input('pagesize');
        //我被邀请加入圈子的消息
        //我创建的圈子或者我负责的圈子有人申请的消息
        // if(!$request->has('users_id'))

        //我申请的圈子id
        $apply_gid = GroupsApply::where('invite_users_id',$request->input('users_id'))->select('groups_id','status')->get();
        //我创建的圈子的申请消息
        $create_gid = GroupsApply::join('groups as g','g.id','=','groups_apply.groups_id')->where('g.users_id',$request->input('users_id'))->select('g.id','groups_apply.status')->get();
        //我管理的圈子
        $deputy_gid = GroupsApply::join('groupmember as g','g.groups_id','=','groups_apply.groups_id')->where('g.users_id',$request->input('users_id'))->where('g.role','1')->select('g.groups_id','groups_apply.status')->get();
        
        $gid = [];
        // foreach ($apply_gid as $val) {
        //     // $gid = $gid.$val->groups_id.',';
        //     array_push($gid, $val->groups_id);
        // }
        foreach ($create_gid as $val) {
            // $gid = $gid.$val->id.',';
            array_push($gid, $val->id);
        }
        foreach ($deputy_gid as $val) {
            // $gid = $gid.$val->groups_id.',';
            array_push($gid, $val->groups_id);
        }
        $list = GroupsApply::join('users as u','u.id','=','groups_apply.users_id')
            ->join('groups as g','g.id','=','groups_apply.groups_id')
            ->whereIn('groups_apply.groups_id',$gid)
            ->orWhere('groups_apply.invite_users_id',$request->input('users_id'))
            ->select('groups_apply.id','u.name','u.headimg','groups_apply.status','groups_apply.type','u.birthdate','u.sex','g.name as groupsname')
            ->orderby('groups_apply.created_at','desc')
            ->skip($pagesize*$pageindex)
            ->take($pagesize)
            ->get();
        foreach ($list as $val) {
                $val->age = 18;
            switch ($val->type) {
                case 0:
                    //用户主动申请
                    $val->content = '申请加入'.$val->groupsname;
                    $val->btn_str = '通过';
                    break;
                
                case 1:
                    //用户被邀请
                    $val->content = $val->groupsname.'邀请您加入'; 
                    $val->btn_str = '同意';
                    break;
            }
        }
        
        $data['list'] = $list;
        $data['is_latest'] = 1;//0 目前不是最新的，1 目前是最新的，可重新拉取
        // $groups = groups::query('select groups.id,groups.name groups_apply.status as statusss,groups_apply.users_id from groups join groups_apply  on groups_apply.groups_id = groups.id where id in ('.$gid.')')
        //::join('groupmember as g','g.groups_id','=','groups.id')->query('where id in ('.$gid.')')
        // ->select('groups.id','groups.name','groups_apply.status','groups_apply.users_id')
        // $list = Users::join('groups_apply','users.id','=','groups_apply.users_id','right')
        // ->join('groups_apply','users.id','=','groups_apply.invite_users_id',)
        // ->whereIn('groups_apply.groups_id',$gid)
        // ->select('users.name','users.headimg','groups_apply.status','groups_apply.users_id')
        // ->get();
        return Common::returnSuccessResult('200', '获取成功', $data);
    }
}
