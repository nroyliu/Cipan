<?php
namespace app\index\controller;

use think\Controller;
use think\Session;

class Index extends  Controller
{
    public function index()
    {
        $isLogin = Session::get("Cipan_Auth");
        if (!is_null($isLogin)){
            echo "已登录";
        }
        return $this->fetch("/index");
    }
}
