<?php

namespace App\Http\Controllers\Like;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class LikeController extends Controller
{
    public function like(Request $request){
        $u_id = $request->input('u_id');
        $goods_id = $request->input('goods_id');
        $status = $request->input('status');

        $like_num = $request->input('like_num');;
        $num = $like_num+1;
        if($num==0){
            $num=1;
        }
        $nums = $like_num-1;
        if(strstr($nums,'-')){
            $nums=0;
        }
        $res = DB::table('laravel_like')->where(['u_id'=>$u_id,'goods_id'=>$goods_id])->first();
        $goods_num = DB::table('laravel_like_num')->where(['goods_id'=>$goods_id])->first();
        if($res){
            //取消点赞
            if($res->status==1){

                if($goods_num){
                    DB::table('laravel_like_num')->where(['goods_id'=>$goods_id])->update(['like_num'=>$nums]);
                    DB::table('laravel_like')->where(['u_id'=>$u_id,'goods_id'=>$goods_id])->update(['status'=>$status]);
                }else{
                    DB::table('laravel_like_num')->insert(['goods_id'=>$goods_id,'like_num'=>1]);
                    DB::table('laravel_like')->where(['u_id'=>$u_id,'goods_id'=>$goods_id])->update(['status'=>$status]);
                }

            //点赞
            }else{
                DB::table('laravel_like_num')->where(['goods_id'=>$goods_id])->update(['like_num'=>$num]);
                DB::table('laravel_like')->where(['u_id'=>$u_id,'goods_id'=>$goods_id])->update(['status'=>1]);
            }
            return json_encode(
                [
                    'status'=>1000,
                    'msg'=>'ok'
                ]
            );

        }else{
            DB::table('laravel_like')->insert(['u_id'=>$u_id,'goods_id'=>$goods_id,'status'=>$status]);

            if($goods_num){

                DB::table('laravel_like_num')->where(['goods_id'=>$goods_id])->update(['like_num'=>$num]);
            }else{
                DB::table('laravel_like_num')->insert(['goods_id'=>$goods_id,'like_num'=>1]);
            }
            return json_encode(
                [
                    'status'=>1000,
                    'msg'=>'ok'
                ]
            );

        }



    }

    public function likecheck(Request $request){
        $u_id = $request->input('u_id');

        $goods_id = $request->input('goods_id');

        $res = DB::table('laravel_like')->where(['u_id'=>$u_id,'goods_id'=>$goods_id])->first();

        if($res){

           $obj = DB::table('laravel_like')->join('laravel_like_num','laravel_like.goods_id','=','laravel_like_num.goods_id')->where(['u_id'=>$u_id,'laravel_like.goods_id'=>$goods_id])->first();
           $obj->like_status = 1;
           return json_encode($obj);
        }else{

           $num = DB::table('laravel_like_num')->where(['goods_id'=>$goods_id])->first();


           if($num){
               $num->like_status = 2;
               return json_encode($num);
           }else{

               return json_encode(['like_num'=>0,'like_status'=>3]);
           }

        }

    }
}
