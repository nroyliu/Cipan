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
            $sortField = $request->param('sortField');
            $sortOrder = $request->param('sortOrder');
            $filter = $request->param('type/a');
            $start = $number * ($page-1);
            $dictModel = new Dict();
            if(empty($filter)){
                if ($sortOrder == "descend"){
                    $dictList = $dictModel->order($sortField,'desc')->limit($start,$number)->select();
                }else{
                    $dictList = $dictModel->limit($start,$number)->select();
                }
                $Count = $dictModel->select()->count();
            }else{
                $param = implode(',',$filter);
                if ($sortOrder == "descend"){
                    $dictList = $dictModel->where('type','in',$filter)->order($sortField,'desc')->limit($start,$number)->select();
                    $Count = $dictModel->where('type','in',$filter)->select()->count();
                }else{
                    $dictList = $dictModel->where('type','in',$filter)->limit($start,$number)->select();
                    $Count = $dictModel->where('type','in',$filter)->select()->count();
                }
            }
            $type = Type::select();
            $filters = array();
            foreach ($type as $item){
                $filters[] = array("text" => $item->name, "value" => "" . $item->id . "");
            }
            foreach($dictList as &$item){
                $item['Typetext'] = $item->types;
            }
            $result = array();
            $result['results'] = $dictList->toArray();
            $result['total'] = $Count;
            $result['filters'] = $filters;
            return json_encode($result,JSON_UNESCAPED_UNICODE);
        }
    }
}