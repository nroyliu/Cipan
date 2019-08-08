<?php
namespace app\member\controller;

use app\model\Dict;
use app\model\Type;
use app\model\User;
use think\Controller;
use think\Request;
use think\Session;

class account extends Controller
{
    public function types(Request $request){
        if ($request->isPost()){
            $typeModel = Type::all();
            $types = array();
            foreach ($typeModel as $item){
                $number = Dict::where("type", $item->id)->count();
                $types[] = ["name" =>$item->name, "number" =>$number];
            }
            return json_encode($types);
        }
    }
    public function home(){
        return $this->fetch("/member/home");
    }
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
    public function gettype(Request $request){
        if ($request->isPost()){
            $type = Type::select();
            $filters = array();
            foreach ($type as $item){
                $filters[] = array("id" => $item->id, "value" => $item->name);
            }
            return json_encode($filters,JSON_UNESCAPED_UNICODE);
        }

    }
}