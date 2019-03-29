<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//登陆
Route::any('/api/login', 'User\UserController@login');

//个人中心token
Route::any('/api/token', 'User\UserController@token');


//个人中心
Route::any('/api/mycenter', 'User\UserController@mycenter');

//注册
Route::any('/reg','Register\RegisterController@doReg');

#####################################
//商品
Route::any('/api/goodsList', 'Goods\GoodsController@goodsList');

Route::any('/api/goodsDetails', 'Goods\GoodsController@goodsDetails');


Route::post('/cartAdd', 'Cart\CartController@cartAdd');

//购物车展示
Route::any('/cartList', 'Cart\CartController@cartList');

Route::any('/api/goodsDetails', 'Goods\GoodsController@goodsDetails');



//退出
Route::any('/quit','User\UserController@quit');


//点赞
Route::any('/api/like','Like\LikeController@like');


//展示点赞
Route::any('/api/likecheck','Like\LikeController@likecheck');



//展示点赞
Route::any('/api/likecheck','Like\LikeController@likecheck');





//收藏
Route::any('/collect','Register\CollectController@collect');


Route::any('/oradd','Order\OrderController@orAdd');


Route::any('/ormsg','Order\OrderController@orMsg');

