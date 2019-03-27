<?php

namespace App\Http\Controllers\Goods;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{
    public function goodsList()
    {
        $obj = DB::table('laravel_goods')->get();
        $json = json_encode($obj);
        return $json;
    }
}