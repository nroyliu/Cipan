<?php
namespace app\member\controller;

use app\model\User;
use think\Controller;
use think\Request;
use think\Session;

class account extends Controller
{
    public function index(){
        return $this->fetch("/member/index");
    }
    public function login(Request $request){
        if ($request->isPost()){
            $map  = array();
            $map['username'] = ["=",trim($request->param('username'))];
            $map['password'] = ["=",md5(trim($request->param('password')))];
            $user = User::where($map)->find();
            if (!is_null($user)){
                Session::set("Cipan_Auth",null);
                Session::set("Cipan_Auth",$user);
                return json_encode(["status" => 1, "messages" => "登录成功"],JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(["status" => 0, "messages" => "账号或密码错误"],JSON_UNESCAPED_UNICODE);
            }
        }

    }
}