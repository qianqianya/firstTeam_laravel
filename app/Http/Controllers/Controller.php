<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redis;
class Controller extends BaseController
{
    public function checkLogin($token,$uid){
        $u_id=Redis::lindex('key','str:web:u_id');
        $res_token=Redis::lindex('key','str:web:token'.$u_id);
        if(empty($uid)){
            return '您还没登录，请先登录';
        }
        if(empty($token)){
            return '您还没登录，请先登录';
        }
        if($res_token!=$token){
            return '非法登录';
        }
        return true;
    }

}

