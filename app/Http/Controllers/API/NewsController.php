<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JPush\Client as JPushClient;
use App\Models\News;

class NewsController extends Controller
{
    public function sendmsg(Request $request){
    	// $result = News::sendall('深圳市立松信息技术有限公司推送测试');
    	// if(!$result){
    	// 	$new = new News
    	// }
    	// return $result;
    	// $jpush = new JPushClient(config('jpush.appKey'), config('jpush.masterSecret'));
	    // $response = $jpush->push()
	    //     ->setPlatform('all')
	    //     ->addRegistrationId('67110c70-913f-11e7-af0c-99b62957f6c4')
	    //     // ->addAllAudience( ["registration_id" => '3b2651f0-92fd-11e7-bdf0-6909865c40e8'])
	    //     // ->setNotificationAlert('hello tp3.2')
	    //     ->message('test test')
	    //     ->send();
	    // print_r($response);
    }
}
