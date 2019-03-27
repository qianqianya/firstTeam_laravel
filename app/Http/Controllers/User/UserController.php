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
        $user=json_decode($u_pwd);
        //var_dump($user);die;
        if($u_pwd){
            if($user['u_pwd']==$pwd){
                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('u_id',$user['u_id'],time()+86400,'/','',false,true);
                setcookie('token',$token,time()+86400,'/center','',false,true);

                request()->session()->put('u_token',$token);
                request()->session()->put('u_id',$user['u_id']);
                $data=[
                    'token'=>$token,
                    'u_id'=>$user['u_id'],
                    'msg'=>'登录成功'
                ];
            }else{
                $data=[
                    'msg'=>'账号或密码有误'
                ];
            }
            return json_encode($data);
        }else{
            $data=[
                'error'=>'该用户不存在'
            ];
            return json_encode($data);
        }
    }

    public function quit(){
        setcookie('u_id',null);
        setcookie('token',null);
        request()->session()->pull('u_token',null);
        echo '退出成功';
    }


    //个人中心
    public function mycenter(Request $request){
        $uid = $request->input('u_id');
        $obj = UserModel::where(['u_id'=>$uid])->first();
        return json_encode($obj);
    }

}
