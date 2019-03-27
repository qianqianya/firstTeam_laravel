<?php

namespace App\Http\Controllers\Register;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\UsersModel;
class RegisterController extends Controller
{
    //注册
    public function doReg(Request $request){
        $name=$request->input('name');
        $email=$request->input('email');
        $pwd=$request->input('pwd');
        $rpwd=$request->input('rpwd');
        if($rpwd==$pwd){
            $data=[
                'name'=>$name,
                'email'=>$email,
                'pwd'=>$pwd

            ];
            UsersModel::insert($data);
            $response=[
                'errno'=>200,
                'msg'  =>'注册成功'
            ];
        }else{
            $response=[
                'errno'=>400,
                'msg'  =>'确认密码与密码不一致'
            ];
        }
        return json_encode($response);
    }
}
