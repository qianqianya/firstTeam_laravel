<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;


class GoodsController extends Controller
{
    public function goodsList()
    {
        $obj = DB::table('laravel_goods')->get();
        $json = json_encode($obj);
        return $json;
    }

    public function goodsDetails(Request $request){
        $goods_id = $request->input('goods_id');

        $obj = DB::table('laravel_goods')->where(['goods_id'=>$goods_id])->first();

        $key='str:user_goodsid'.$goods_id;

        Redis::zIncrBy($key,1,$goods_id);

        $json = json_encode($obj);
        return $json;
    }

    public function browse(Request $request){
        $goods_id=$request->input('goods_id');
        $key='str:user_goodsid'.$goods_id;
        $goods_id=Redis::zScore($key,$goods_id);

        $json = json_encode($goods_id);
        return $json;
    }

    public function goodsHstAdd(Request $request){
        $u_id = $request->input('u_id');
        $goods_id = $request->input('goods_id');
        $res = DB::table('laravel_goods_hst')->where(['u_id'=>$u_id,'goods_id'=>$goods_id])->first();

        if(!$res){
            DB::table('laravel_goods_hst')->insert(['u_id'=>$u_id,'goods_id'=>$goods_id]);
            return json_encode(
                [
                    'status'=>1000,
                    'msg'=>'mysql add ok'
                ]
            );
        }

        return json_encode(
            [
                'status'=>1000,
                'msg'=>'Data already exists'
            ]
        );

    }

    public function goodsHstList(Request $request){
        $goods_id = $request->input('goods_id');

        $obj = DB::table('laravel_goods_hst')->
        join('laravel_user','laravel_goods_hst.u_id','=','laravel_user.u_id')->
        join('laravel_goods','laravel_goods_hst.goods_id','=','laravel_goods.goods_id')->
        where(['laravel_goods_hst.goods_id'=>$goods_id])->
        get();


            $json = json_encode($obj);

            return $json;
        

    }
}
