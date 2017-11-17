<?php
/**
 * Created by PhpStorm.
 * User: Lily
 * Date: 2017/10/17
 * Time: 15:04
 */

namespace App\Libraries;
use


class Arrow
{
    static $instance;
    /**
     * @return static
     */
    public static function getInstance(){
        if(null == Arrow::$instance)
            Arrow::$instance = new Arrow();
        return Arrow::$instance;
    }

    public function run($rb){
        $pid = pcntl_fork();
        if($pid>0){
            pcntl_wait($status);
        }elseif($pid == 0){
            $cid = pcntl_fork();
            if($cid > 0){
                exit();
            }elseif($cid == 0){
                $rb();
            }else{
                exit();
            }
        }else{
            exit();
        }
    }
}