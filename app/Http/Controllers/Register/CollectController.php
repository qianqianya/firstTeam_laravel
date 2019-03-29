<?php

namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
class CollectController extends Controller
{
    //收藏
    public function collect(Request $request){
        $goods_id=$request->input('goods_id');
        $uid=$request->input('u_id');
        $token=$request->input('token');
        $status=$request->input('status');
        $time=time();
        $collect='collect_goods_id'.$goods_id;
        $collect_u='collect_u_id'.$uid;
        $responce=$this->checkLogin($token,$uid);
        if($responce=='true'){
            if($status==1){
                Redis::zlncrBy($collect,1,$goods_id);
                Redis::zAdd($collect_u,$time,$goods_id);
                $response=[
                    'errno'=>200,
                    'msg'  =>'收藏成功'
                ];
            }else{
                Redis::zRem($collect_u,$goods_id);
                Redis::zlncrBy($collect,-1,$goods_id);
                $response=[
                    'errno'=>400,
                    'msg'  =>'取消收藏成功'
                ];
            }
            return json_encode($response);
        }else{
            $response=[
                'errno'=>100,
                'msg'  =>$responce
            ];
            return json_encode($response);
        }
    }

    //防非法登录
    public function checkLogin($token,$uid){
        $key='str:web:token'.$uid;
        $res_token=Redis::get($key);
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

