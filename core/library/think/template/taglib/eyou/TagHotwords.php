<?php
/***/

namespace think\template\taglib\eyou;

use think\Db;

/**
 * 获取网站搜索的热门关键字
 */
class TagHotwords extends Base
{
    //初始化
    protected function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 获取网站搜索的热门关键字
     * @author wengxianhu by 2018-4-20
     */
    public function getHotwords($num = 0, $subday = 0, $maxlength = 0, $orderby = '', $ordermode = '')
    {
        $nowtime = getTime();
        if(empty($subday)) $subday = 365;
        if(empty($num)) $num = 6;
        if(empty($maxlength)) $maxlength = 20;
        $maxlength = $maxlength + 1;
        $maxlength = $maxlength * 3;
        $mintime = $nowtime - ($subday * 24 * 3600);
        $orderby = $this->getOrderBy($orderby, $ordermode, true);

        $result = Db::name('search_word')->field('word,searchNum')
            ->where("update_time > {$mintime} AND length(word) < {$maxlength}")
            ->orderRaw($orderby)
            ->limit($num)
            ->select();
        $searchurl = url('home/Search/lists');
        foreach ($result as $key => $val) {
            $url = $searchurl;
            if (stristr($searchurl, '?')) {
                $url .= "&keywords=".urlencode($val['word']);
            } else {
                $url .= "?keywords=".urlencode($val['word']);
            }
            $val['url'] = $url;

            $result[$key] = $val;
        }

        return $result;
    }

    // 获取查询排序
    private function getOrderBy($orderby,$ordermode,$isrand=false)
    {
        switch ($orderby) {
            case 'hot':
                $orderby = "is_hot desc, searchNum {$ordermode}, id desc";
                break;
            case 'new':
                $orderby = "id {$ordermode}";
                break;
            case 'sort_order':
                $orderby = "sort_order {$ordermode}, id desc";
                break;
            case 'rand':
                if (true === $isrand) {
                    $orderby = "rand()";
                } else {
                    $orderby = "id {$ordermode}";
                }
                break;

            default:
            {
                if (empty($orderby)) {
                    $orderby = 'sort_order asc, is_hot desc, searchNum desc, id desc';
                }
                break;
            }
        }

        return $orderby;
    }
}