<?php


namespace app\model;


use think\Model;

class Dict extends Model
{
    protected $autoWriteTimestamp = 'datetime';
    protected $updateTime = false;
    public function getTypesAttr($value,$data)
    {
        $type = Type::all();
        $arr = array();
        foreach ($type as $item){
            $arr[$item->id] = $item->data['name'];
        }
        return $arr[$data['type']];
    }
}