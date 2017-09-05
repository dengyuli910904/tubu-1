<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Orders;
use App\Libraries\Common;
use App\Models\Activities;
use UUID;
use Pingpp;
class OrdersController extends Controller
{
    /**
     * 生成订单
     */
    public function store(Request $request){
        $act = Activities::find($request->input('activities_id'));
        if(!$act){
            return Common::returnErrorResult(204,'活动信息不存在');
        }
        $code = rand(1000000,9999999).time();
    	$orders = new Orders();
        $order_no = UUID::generate();

    	$orders->id = $order_no;
    	$orders->activities_id = $request->input('activities_id');
    	// $orders->user_id = 
        $orders->title = $act->title;
    	$orders->ordernum = $code;
        $orders->user_id = $request->input('users_id');
    	$orders->sum = (float)$act->cost;
        $orders->channel = $request->input('channel');
    	if($orders->save()){
            // Pingpp::setApiKey('sk_test_DCSiv9D8GGGOnX9yD8TyPG04');
            Pingpp::setApiKey('sk_live_yLOmjPzLSKiP14e18KGWbbP0');
        // $headers = \Pingpp\Util\Util::getRequestHeaders();
        // $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
        //__DIR__ . 
            header('Authorization: Bearer API-Key');
            Pingpp\Pingpp::setPrivateKeyPath('../your_rsa_private_key.pem');
             // return $id;
            $result = Pingpp\Charge::create(
                array('order_no'  => $code = $code,
                    'amount'    => (float)$orders->sum*100,//订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
                    'app'       => array('id' => 'app_KqrrLGTOW5CODabT'),
                    'channel'   => $request->input('channel'),
                    'currency'  => 'cny',
                    'client_ip' => '127.0.0.1',
                    'subject'   => '乐松',
                    'body'      => $act->title
                    )
                );
        // return $result;
    		return Common::returnSuccessResult(200,'订单生成成功',json_encode($result));
    	}else{
    		return Common::returnErrorResult(400,'订单生成失败');	
    	}
    }

    public function getcharge(Request $request){
         Pingpp::setApiKey('sk_test_DCSiv9D8GGGOnX9yD8TyPG04');
        // $headers = \Pingpp\Util\Util::getRequestHeaders();
        // $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;
        //__DIR__ . 
            header('Authorization: Bearer API-Key');
            Pingpp\Pingpp::setPrivateKeyPath('../your_rsa_private_key.pem');
             // return $id;
        $result = Pingpp\Charge::create(
            array('order_no'  => $code = rand(1000000,9999999).time(),
                'amount'    => 1,//订单总金额, 人民币单位：分（如订单总金额为 1 元，此处请填 100）
                'app'       => array('id' => 'app_KqrrLGTOW5CODabT'),
                'channel'   => $request->input('channel'),
                'currency'  => 'cny',
                'client_ip' => '127.0.0.1',
                'subject'   => '乐松',
                'body'      => "test"
                )
            );
        return $result;
    }
    /**
     * 订单状态变更
     */
    public function update(Request $request){
        // $json = $request; 
        // return $json;
        
        $data = $request->input('data');
        
        $obj = $data['object'];
        // return Common::returnSuccessResult(200,'订单不存在',$data);

    	$orders = Orders::where('id',$request->input('id'))->first();
        if($orders)
        {
            if((float)$obj->amount == (float)$orders->num*100){
                $orders->status = 0;
                if($json->type == 'charge.succeeded'){
                    $orders->status = 1;
                }
                $orders->save();
                return Common::returnSuccessResult(200,'success',"");
            }else{
                return Common::returnSuccessResult(200,'支付金额不一致',"");
            }
        }else{
            return Common::returnSuccessResult(200,'订单不存在',"");
        }
        
    	// $orders
    	// 根据返回的数据设置支付状态
    }
}
