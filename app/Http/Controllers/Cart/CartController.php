<?php

namespace App\Http\Controllers\Cart;

use App\Model\CartModel;
use App\Model\GoodsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    /**
     * 购物车添加
     * @param Request $request
     * @return string
     */
    public function cartAdd(Request $request){
        $c_num=$request->input('num');
        $goods_id=$request->input('goods_id');
        $where=[
            'goods_id'=>$goods_id
        ];
        $goods=GoodsModel::where($where)->first();
        $uid='str:web:u_id';
        $u_id = Redis::get($uid);
        if(empty($u_id)){
            $response=[
                'errno'=>1000,
                'msg'  =>'请先登录'
            ];
        }else if(empty($goods)){
            $response=[
                'errno'=>1000,
                'msg'  =>'没有这个商品'
            ];
        }else{
            $data=[
                'goods_id'=>$goods_id,
                'c_num'=>$c_num,
                'c_ctime'=>time(),
                'uid'=>$_COOKIE['u_id'],
                'session_token'=>$_COOKIE['token']
            ];
            $cart=CartModel::insert($data);
            if(empty($cart)){
                $response=[
                    'errno'=>1000,
                    'msg'  =>'加入购物车失败'
                ];
            }else{
                $response=[
                    'errno'=>200,
                    'msg'  =>'加入购物车成功'
                ];
            }
        }

        return json_encode($response);
    }

    /**
     * 购物车展示
     */
    public function cartList(){
        $uid='str:web:u_id';
        $u_id = Redis::get($uid);
        if(empty($u_id)){
            $response=[
                'errno'=>'1000',
                'msg'=>'请先登录'
            ];
        }else {
            $cart_goods = CartModel::where(['uid' => $u_id])->get()->toArray();

            $response[] = '';
            if ($cart_goods) {
                //获取商品最新信息
                foreach ($cart_goods as $k => $v) {
                    $goods_info = GoodsModel::where(['goods_id' => $v['goods_id']])->first()->toArray();
                    //计算订单价格 = 商品数量 * 单价
                    $order_amount = $goods_info['goods_price'] * $v['c_num'];
                    $goods_info['c_id'] = $v['c_id'];
                    $goods_info['c_num'] = $v['c_num'];
                    $goods_info['c_ctime'] = $v['c_ctime'];
                    $goods_info['order_amount']=$order_amount;
                    $response[] = $goods_info;
                }
            }
        }

        //print_r($response);
        return json_encode($response);
    }
}


