<?php

namespace App\Http\Controllers\User;


use App\Model\UsersModel;
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

        $u_pwd=UsersModel::where($where)->first();
        $user=json_decode($u_pwd,true);
        //var_dump($user);die;
        if($u_pwd){
            if($user['u_pwd']==$pwd){
                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                setcookie('u_id',$u_pwd['u_id'],time()+86400,'/','',false,true);
                setcookie('token',$token,time()+86400,'/','',false,true);

                request()->session()->put('u_token',$token);
                request()->session()->put('u_id',$user['u_id']);


                //token存redis
                $key='str:web:token'.$user['u_id'];
                Redis::set($key,$token);
                Redis::expire($key,86400);
                $data=[
                    'status'=>1000,
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

    public function quit(Request $request){
        $uid=$request->input('u_id');
        $key='str:web:token'.$uid;
        $is=Redis::del($key);
        if($is==1){
            $response=[
                'errno'=>200,
                'msg'  =>'退出成功'
            ];
        }else{
            $response=[
                'errno'=>400,
                'msg'  =>'非法操作'
            ];
        }
        return json_encode($response);
    }


    //个人中心
    public function mycenter(Request $request){
        $uid = $request->input('u_id');
        $obj = UserModel::where(['u_id'=>$uid])->first();
        return json_encode($obj);
    }

}
