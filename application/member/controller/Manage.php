<?php


namespace app\member\controller;


use app\model\Dict;
use app\model\Type;
use think\console\command\make\Model;
use think\Controller;
use think\Request;
use think\Session;

class Manage extends Controller
{
    public function get(Request $request){
        if ($request->isPost()){
            $User = Session::get("Cipan_Auth");
            $list = Dict::where("uid",$User->id)->select();
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
}