<?php

namespace app\admin\model;

use think\Model;


class Datum extends Model
{

    

    

    // 表名
    protected $name = 'datum';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
    protected $deleteTime = false;

    // 追加属性
    protected $append = [
        'da_ce_text',
        'year_text'
    ];
    

    protected static function init()
    {
        self::afterInsert(function ($row) {
            $pk = $row->getPk();
            $row->getQuery()->where($pk, $row[$pk])->update(['weigh' => $row[$pk]]);
        });
    }

    
    public function getDaCeList()
    {
        return ['0' => __('Da_ce 0'), '1' => __('Da_ce 1')];
    }

    public function getYearList()
    {
        return ['0' => __('Year 0'), '1' => __('Year 1'), '2' => __('Year 2'), '3' => __('Year 3')];
    }


    public function getDaCeTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['da_ce']) ? $data['da_ce'] : '');
        $list = $this->getDaCeList();
        return isset($list[$value]) ? $list[$value] : '';
    }


    public function getYearTextAttr($value, $data)
    {
        $value = $value ? $value : (isset($data['year']) ? $data['year'] : '');
        $list = $this->getYearList();
        return isset($list[$value]) ? $list[$value] : '';
    }




    public function category()
    {
        return $this->belongsTo('Category', 'category_id', 'id', [], 'LEFT')->setEagerlyType(0);
    }
}
