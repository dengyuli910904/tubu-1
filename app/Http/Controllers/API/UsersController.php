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

class UsersController extends Controller
{
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
        $user = Users::where('telphone', $phone)->where('pwd',$passwd)->first();
        if ($user) {
            return Common::returnSuccessResult('200', "登录成功", $user);
        } else {
            return Common::returnErrorResult('400', "用户名或密码错误");
        }
    }

    public function myMesage(Request $request)
    {
        $list = Messages::where('users_id', $request->input("user_id"))->get();
        return Common::returnSuccessResult('200', '', $list);
    }

    public function myComment(Request $request)
    {
        $list = Messages::where('users_id', $request->input("user_id"))->get();
        return Common::returnSuccessResult('200', '', $list);
    }

    public function myReply(Request $request)
    {
        $list = Evaluations::where('users_id', $request->input('user_id'))->get();
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
        $list = ActivitiesFollow::where('user_id',$request->input('user_id'))->get();
        return Common::returnSuccessResult('200', '获取成功', $list);
    }

    /**
     * 我关注的圈子
     */
    public function watchCircle(Request $request)
    {
        $list = GroupsFollow::where('user_id',$request->input('user_id'))->get();
        return Common::returnSuccessResult('200', '获取成功', $list);
    }
    /**
     * 我收藏的活动
     */
    public function favoriteActivity(Request $request)
    {
        $list = ActivitiesCollect::where('user_id',$request->input('user_id'))->get();
        return Common::returnSuccessResult('200', '获取成功', $list);
    }

    public function myActivity(Request $request)
    {
        $list = ActivityMember::where('users_id', $request->input('userId')
            ->join('activities', 'activities.id = activitymembers.users_id'))
            ->get();
        return Common::returnSuccessResult('200', '', $list);
    }

    public function myCircle(Request $request)
    {
        $list = GroupMember::where('users_id', $request->input('userId')
            ->join('groups', 'groups.id = groupmember.users_id'))
            ->get();
        return Common::returnSuccessResult('200', '', $list);
    }

    public function myCreatedCirclesActivity(Request $request)
    {
        $list = Activities::where('users_id', $request->input('userId'))->get();
        return Common::returnSuccessResult('200', '', $list);
    }
}
