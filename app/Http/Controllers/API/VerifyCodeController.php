<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// require('path/to/vendor/autoload.php');
use PhpSms;
use App\Libraries\Common;
use App\Models\Verifycode;
use UUID;
use App\Models\Users;

class VerifyCodeController extends Controller
{
    /**
     * 发送验证码
     */
    public function sendcode(Request $request){
        $type = 0;
        $to = $request->input('phone');
        if($request->has('type'))
            $type = $request->input('type');

        $user = Users::where('telphone',$to)->first();
        if(!$user && $type == 1)
            return Common::returnErrorResult(204,"该手机号未注册",""); 
        else if($user && $type != 1)
            return Common::returnErrorResult(204,"该手机号已被注册",""); 

    	
        $code = rand(1000,9999);
        // 短信模版
        $templates = [
            'Aliyun' => env('SMS_TEMPLATE_CODE'),
        ];
        // 模版数据
        $tempData = [
            'number' => $code,
            'minutes' => env('SMS_MINUTES')
        ];
        // 只希望使用模板方式发送短信，可以不设置content(如:云通讯、Submail、Ucpaas)
        $result = PhpSms::make($templates)->to($to)->template($templates)->data($tempData)->send();
        // return $result;
        if($result['success']){
        	$vcode = new Verifycode();
            $id = UUID::generate();
        	$vcode->id = $id;
        	$vcode->phone = $to;
        	$vcode->code = $code;
        	$vcode->comment = '';
            $vcode->type = $type;
        	$vcode->save();
        	return Common::returnSuccessResult(200,'发送成功',['id'=>(string)$id]);
        }else{
        	$logs = $result['logs'];
        	// return $logs;
        	$msg_code = $logs[0]['result']['code'];
        	$msg = '发送失败，请重新请求';
        	switch ($msg_code) {
        		case 'isv.BUSINESS_LIMIT_CONTROL':
        			$msg = "请求太频繁,60s之后再试";
        			break;
        	}
        	return Common::returnErrorResult(400,$msg);
        }
    }

    /**
     * 验证code .Validator
     */
    public function validator(Request $request){
    	$id = $request->input('id');
    	$code = $request->input('code');
    	$valid = Verifycode::where('id',$id)->where('code',$code)->where('is_valid','0')->first();
    	if($valid){
    		$valid->is_valid = 1;
    		$valid->save();
    		return Common::returnSuccessResult(201,'验证成功','');
    	}else{
    		return Common::returnErrorResult(400,'验证失败');	
    	}
    }
}
