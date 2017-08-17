<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SmsController extends Controller
{
    public function sendSms(Request $request) {
        $this->dispatch(new SendSms("13800000000", null, null, null));
        return "ok";
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
