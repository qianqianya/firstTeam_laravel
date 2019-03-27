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
















#####################################
//个人中心
Route::any('/api/goodsList', 'Goods\GoodsController@goodsList');