<?php
 
namespace App\Http\Controllers;
// require('/2017-07/tubu_0/vendor/autoload.php'); 
use Illuminate\Http\Request;
// use SendSms;
use App;
use SmsManager;
use Validator;
use PhpSms;
use UUID;
use Pingpp;

class SmsController extends Controller
{
    public function pp(Request $request){
        Pingpp::setApiKey('sk_test_DCSiv9D8GGGOnX9yD8TyPG04');
        // $headers = \Pingpp\Util\Util::getRequestHeaders();
        // $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
        //__DIR__ . 
        // Pingpp\Pingpp::setPrivateKeyPath(__DIR__.'\your_rsa_private_key.pem');
        $result = Pingpp\Charge::create(
            array('order_no'  => '123456789',
                'amount'    => '1',//订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
                'app'       => array('id' => 'app_KqrrLGTOW5CODabT'),
                'channel'   => 'alipay',
                'currency'  => 'cny',
                'client_ip' => '127.0.0.1',
                'subject'   => 'Your Subject',
                'body'      => 'Your Body')
                );
        return $result;
        // \Pingpp\Charge::retrieve('CHARGE_ID');
        // \Pingpp\Charge::all(array('limit' => 5, 'app' => array('id' => 'APP_ID')));

    }
    
    public function sendmsg(Request $request){
        $smsService = App::make(AliyunSms::class);
        $smsService->send(strval($mobile), 'SMS_xxx', ['code' => strval(1234), 'product' => 'xxx']);
    }
    public function sendSms(Request $request) {
        $to = $request->input('mobile');
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
        return $result;
    }

    public function sendReminderEmail(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $job = (new SendReminderEmail($user))->onQueue('emails');

        $this->dispatch($job);
        //延时60s发送
        //$job = (new SendSMSMessages($member, $message))->delay(60);

        //定时发送
        // Carbon::tomorrow()->startOfDay()->diffInSeconds(Carbon::now())
    }
}
