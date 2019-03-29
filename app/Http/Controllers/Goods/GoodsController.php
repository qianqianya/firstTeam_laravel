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
}
