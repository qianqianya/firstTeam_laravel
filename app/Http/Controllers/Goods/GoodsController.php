<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;


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

        $json = json_encode($obj);

        return $json;
    }
}