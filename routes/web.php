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

//修改密码
Route::any('/updatePwd', 'User\UserController@updatePwd');

//个人中心token
Route::any('/api/token', 'User\UserController@token');


//个人中心
Route::any('/api/mycenter', 'User\UserController@mycenter');

//注册
Route::any('/reg','Register\RegisterController@doReg');

#####################################
//商品
Route::any('/api/goodsList', 'Goods\GoodsController@goodsList');

//商品详情
Route::any('/api/goodsDetails', 'Goods\GoodsController@goodsDetails');

//添加浏览用户
Route::any('/api/goodsHstAdd', 'Goods\GoodsController@goodsHstAdd');

//查询用户浏览
Route::any('/api/goodsHstList', 'Goods\GoodsController@goodsHstList');

//购物车添加
Route::post('/cartAdd', 'Cart\CartController@cartAdd');

//购物车删除
Route::post('/cartDel', 'Cart\CartController@cartDel');

//购物车展示
Route::any('/cartList', 'Cart\CartController@cartList');


//退出
Route::any('/quit','User\UserController@quit');


//点赞
Route::any('/api/like','Like\LikeController@like');


//展示点赞
Route::any('/api/likecheck','Like\LikeController@likecheck');


//收藏
Route::any('/collect','Register\CollectController@collect');

//订单添加
Route::any('/oradd','Order\OrderController@orAdd');

//订单信息
Route::any('/ormsg','Order\OrderController@orMsg');


# 订单列表
Route::any('/orlist','Order\OrderController@orList');

# 浏览次数
Route::post('/browse','Goods\GoodsController@browse');
