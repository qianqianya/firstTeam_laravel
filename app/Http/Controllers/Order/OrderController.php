<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public  function orAdd(Request $request){
        #cort id

        
        $data = DB::table('laravel_cart')
            ->join('laravel_goods', function($join)
            {
                $join->on('laravel_cart.goods_id', '=', 'laravel_goods.goods_id');
            })
            ->get()->toArray();

        print_r($data);
    }
}