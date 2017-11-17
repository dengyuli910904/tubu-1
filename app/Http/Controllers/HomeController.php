<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Arrow;

class HomeController extends Controller
{
    public function index(){
        $time_out = 30;
        Arrow::getInstance()->run(function() use ($time_out){
            return 'hhhhh'.time();
            sleep($time_out);
        });
    }
}
