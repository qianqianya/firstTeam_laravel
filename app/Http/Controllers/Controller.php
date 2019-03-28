<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    public function checkLogin($token,$uid){
<<<<<<< HEAD

=======
>>>>>>> master
        if(empty($uid)){
            return '您还没登录，请先登录';
        }
        if(empty($token)){
            return '您还没登录，请先登录';
        }

    }
}
