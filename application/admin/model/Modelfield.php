<?php
/***/
namespace app\admin\model;

use think\Model;
use traits\model\SoftDelete;

/**
 * 标签索引
 */
class Modelfield extends Model
{
    //初始化
    protected function initialize()
    {
        // 需要调用`Model`的`initialize`方法
        parent::initialize();
    }

}