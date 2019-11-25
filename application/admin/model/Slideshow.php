<?php

namespace app\admin\model;

use think\Model;


class Slideshow extends Model
{

    

    

    // 表名
    protected $name = 'slideshow';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = false;

    // 定义时间戳字段名
    protected $createTime = false;
    protected $updateTime = false;
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'sl_ce_text'
    ];
    

    
    public function getSlCeList()
    {
        return ['0' => __('Sl_ce 0'), '1' => __('Sl_ce 1')];
    }


    public function getSlCeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['sl_ce']) ? $data['sl_ce'] : '');
        $list = $this->getSlCeList();
        return isset($list[$value]) ? $list[$value] : '';
    }




}
