<?php


namespace app\member\controller;


use app\model\Dict;
use app\model\Type;
use think\Controller;
use think\Request;
use think\Session;

class Manage extends Base
{
    public function get(Request $request){
        if ($request->isPost()){
            $User = Session::get("Cipan_Auth");
            $list = Dict::where("uid",$User->id)->order('create_time',"desc")->select();
            $type = Type::select();
            $filters = array();
            foreach ($type as $item){
                $filters[] = array("id" => $item->id, "value" => $item->name);
            }
            $result = array();
            $result['results'] = $list->toArray();
            $result['filters'] = $filters;
            return json_encode($result);
        }
    }
    public function update(Request $request){
        if ($request->isPost()){
            $User = Session::get("Cipan_Auth");
            $data = $request->param();
            $dictModel = new Dict();
            $result = $dictModel->allowField(['name','type','description'])->save($data,['id'=>$data['id'],'uid'=>$User->id]);
            if($result){
                return json_encode(["status" => 1,"message" => "保存成功"],JSON_UNESCAPED_UNICODE);
            }else{
                return json_encode(["status" => 0,"message" => "未发生改变"],JSON_UNESCAPED_UNICODE);
            }
        }
    }
    public function add(Request $request){
        if ($request->isPost()){
            $User = Session::get("Cipan_Auth");
            $data = $request->param();
            $data['uid'] = $User->id;
            $dictModel = new Dict($data);
            $result = $dictModel->allowField(['name','description','type','uid'])->save();
            if ($result){
                return json_encode(["status" => 1, "message" => "添加成功"]);
            }else{
                return json_encode(["status" => 0, "message" => "添加失败"]);

            }
        }
    }
}