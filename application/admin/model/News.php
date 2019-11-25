<?php

namespace app\admin\model;

use think\Model;


class News extends Model
{

    

    

    // 表名
    protected $name = 'news';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'ne_ce_text',
        'ne_time_text',
        'status_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getNeCeList()
    {
        return ['0' => __('Ne_ce 0'), '1' => __('Ne_ce 1')];
    }

    public function getStatusList()
    {
        return ['0' => __('Status 0'), '1' => __('Status 1'), '2' => __('Status 2')];
    }


    public function getNeCeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['ne_ce']) ? $data['ne_ce'] : '');
        $list = $this->getNeCeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getNeTimeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['ne_time']) ? $data['ne_time'] : '');
        return is_numeric($value) ? date("Y-m-d H:i:s", $value) : $value;
    }


    public function getStatusTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['status']) ? $data['status'] : '');
        $list = $this->getStatusList();
        return isset($list[$value]) ? $list[$value] : '';
    }

    protected function setNeTimeAttr($value)
    {
        return $value === '' ? null : ($value && !is_numeric($value) ? strtotime($value) : $value);
    }


}
