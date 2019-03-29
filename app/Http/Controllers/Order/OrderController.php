<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    # 添加订单
    public  function orAdd(Request $request){
           # 添加订单
        $money  = $request->input('money');
        $num  = $request->input('num');
        $orDate = [
            'o_name'=>$this->orNumAdd()
            ,'o_amount'=>$money
            ,'o_integral'=>null
            ,'uid'=>$_COOKIE['u_id']
            ,'o_ctime'=>time()
            ,'is_delete'=>null
            ,'is_pay'=>null
            ,'pay_amount'=>$num
            ,'pay_ctime'=>null
            ,'status'=>1
        ];

        $res = DB::table('laravel_order')->insert($orDate);
        if($res){
            $reset = [
                'code'=>200
                ,'msg'=>'下单成功'
            ];
        }else{
            $reset = [
                'code'=>500
                ,'msg'=>'下单失败'
            ];
        }

        return json_encode($reset);
    }



    # 获取订单页面信息
    public function  orMsg(){
        $u_id = $_COOKIE['u_id'];

        $u_dada = DB::table('laravel_user')->where(['u_id'=>$u_id])->first();
        return  json_encode($u_dada->u_name);
    }


    # 生成订单号
    public function orNumAdd(){
        return  date('YmdHis').rand(10000,99999);
    }

    # 订单列表
    public  function orList(){
        $u_id = $_COOKIE['u_id'];
        $u_dada = DB::table('laravel_user')->where(['u_id'=>$u_id])->get();
        if($u_dada){
            $data = $u_dada->toArray();
            foreach($data as $k=>$v){
                if($v['status']==1){
                    $v['status']='未支付';
                }
                $v['o_ctime']=date('Y-m-d H:i:s',$v['o_ctime']);
            }
        }
        return json_encode($data);
    }
}