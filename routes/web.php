<<<<<<< HEAD
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

<<<<<<< HEAD
=======

//个人中心
Route::any('/api/mycenter', 'User\UserController@mycenter');

>>>>>>> master
//注册
Route::any('/reg','Register\RegisterController@doReg');

#####################################
//商品
Route::any('/api/goodsList', 'Goods\GoodsController@goodsList');

Route::any('/api/goodsDetails', 'Goods\GoodsController@goodsDetails');

<<<<<<< HEAD
//购物车添加
Route::post('/cartAdd', 'Cart\CartController@cartAdd');

//购物车展示
Route::any('/cartList', 'Cart\CartController@cartList');
=======
//商品详情
Route::any('/api/goodsDetails', 'Goods\GoodsController@goodsDetails');



//退出
Route::any('/quit','User\UserController@quit');
<<<<<<< HEAD
=======
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

//个人中心
Route::any('/api/token', 'User\UserController@token');


//注册
Route::any('/reg','Register\RegisterController@doReg');

//个人中心
Route::any('/api/goodsList', 'Goods\GoodsController@goodsList');


# 添加订单
Route::any('/api/oradd', 'Order\OrderController@orAdd');
>>>>>>> zmw
>>>>>>> master
=======


# 添加订单
Route::any('/api/oradd', 'Order\OrderController@orAdd');

>>>>>>> master
