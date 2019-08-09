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
            header("location:/member/account");
        }
        return $this->fetch("/index");
    }
}
