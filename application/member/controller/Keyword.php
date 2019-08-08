<?php


namespace app\member\controller;


use app\model\Dict;
use app\model\Type;
use think\Controller;
use think\Request;
use think\response\Json;

class Keyword extends Controller
{
    public function getlist(){
        return $this->fetch("/member/keywordlist");
    }
    public function manage(){
        return $this->fetch("/member/keywordmanage");
    }
    public function get(Request $request){
        if ($request->isPost()){
            $page = ($request->param('page')) ? $request->param('page') : 1;
            $number = $request->param('results');
            $start = $number * ($page-1);
            $dictModel = new Dict();
            $dictList = $dictModel->limit($start,$number)->select();
            $Count = Dict::count();
            $type = Type::select();
            $filters = array();
            foreach ($type as $item){
                $filters[] = array("text" => $item->name, "value" => "'" . $item->id . "'");
            }
            $result = array();
            $result['results'] = $dictList->toArray();
            $result['total'] = $Count;
            $result['filters'] = $filters;
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
}