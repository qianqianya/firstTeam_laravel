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
        $name=$request->input('name');
        $pwd=$request->input('u_pwd');
        if(substr_count($name,'@')){
            $where=[
                'u_email'=>$name
            ];
        }elseif(is_numeric($name)&&strlen($name)==11){
            $where=[
                'u_tel'=>$name
            ];
        }else{
            $where=[
                'u_name'=>$name
            ];
        }

        $where=[
            'name'=>$name
        ];

        $u_pwd=UsersModel::where($where)->first();
        $user=json_decode($u_pwd,true);
        //var_dump($user);die;

        if($u_pwd){
            if($user['u_pwd']==$pwd){
                $token = substr(md5(time().mt_rand(1,99999)),10,10);
                //token存redis
                $key='str:web:token'.$user['u_id'];
                $uid='str:web:u_id';
                Redis::set($key,$token);
                Redis::set($uid,$user['u_id']);
                Redis::expire($key,86400);
                Redis::expire($uid,86400);


                $data=[
                    'status'=>1000,
                    'token'=>$token,
                    'u_id'=>$user['u_id'],
                    'msg'=>'登录成功'
                ];
                return json_encode($data);

            }else{
                $data=[
                    'status'=>1,
                    'msg'=>'账号或密码有误'
                ];
                return json_encode($data);
            }

        }else{
            $data=[
                'msg'=>'该用户不存在'
            ];
            return json_encode($data);
        }

    }

    public function quit(Request $request){
        $uid=$request->input('u_id');
        $u_id='str:web:u_id'.$uid;
        $key='str:web:token'.$uid;
        $is=Redis::del($key);
        if($is==1){
            $response=[
                'status'=>200,
                'msg'  =>'退出成功'
            ];
        }else{
            $response=[
                'status'=>400,
                'msg'  =>'非法操作'
            ];
        }
        return json_encode($response);
    }



    //个人中心
    public function mycenter(Request $request){
        $uid = $request->input('u_id');
        $obj = UsersModel::where(['u_id'=>$uid])->first();
        return json_encode($obj,JSON_UNESCAPED_UNICODE);
    }

}
