<?php

namespace App\Http\Controllers\User;

use App\Model\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $email=$request->input('u_email');
        $pwd=$request->input('u_pwd');

        $where=[
            'u_email'=>$email
        ];
        $u_pwd=UserModel::where($where)->first();
        if($u_pwd){
            if($u_pwd['u_pwd']==$pwd){
                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('u_id',$u_pwd['u_id'],time()+86400,'/','',false,true);
                setcookie('token',$token,time()+86400,'/center','',false,true);

                request()->session()->put('u_token',$token);
                request()->session()->put('u_id',$u_pwd['u_id']);
                $data=[
                    'token'=>$token,
                    'u_id'=>$u_pwd['u_id']
                ];
                $res=json_encode($data,true);
                if($res) {
                    echo '登录成功';
                }
            }else{
                $data=[
                    'error'=>'密码错误'
                ];
                echo json_encode($data);
            }
        }else{
            $data=[
                'error'=>'该用户不存在'
            ];
            echo json_encode($data);
        }
    }

    //用户中心验证
    public function token()
    {
        $uid=$_POST['u_id'];
        $oldtoken=$_POST['token'];
        $newtoken=Redis::get("token:one:$uid");
        if($oldtoken==$newtoken){
            return 1;
        }else{
            return 0;
        }
    }

}
