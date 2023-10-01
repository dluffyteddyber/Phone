<?php
/***/

namespace app\api\controller;

class Other extends Base
{
    /*
     * 初始化操作
     */
    
    public function _initialize() {
        parent::_initialize();
        session('user'); // 哪里用到 session_id() , 哪个文件就加上这行代码
    }

    /**
     * 广告位js
     */
    public function other_show()
    {
        $pid = input('pid/d',1);
        $row = input('row/d',1);
        $where = array(
            'pid'=>$pid,
            'status'=>1,
            // 'start_time'=>array('lt', getTime()),
        );
        $ad = M("ad")->where($where)
            // ->where('end_time', ['>', getTime()], ['=', 0], 'or')
            ->order("sort_order asc")
            ->limit($row)
            ->cache(true,EYOUCMS_CACHE_TIME, 'ad') // 如果查询条件有时间字段，一定要去掉这行，避免产生一堆缓存文件
            ->select();
        foreach ($ad as &$value) {
            $value['intro'] = htmlspecialchars_decode($value['intro']);
            $value['intro'] = str_replace("\r\n", "", $value['intro']);
            $value['intro'] = str_replace("'", "\'", $value['intro']);
        }
        $this->assign('ad', $ad);
        return $this->fetch();
    }
}