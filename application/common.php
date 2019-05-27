<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 *Created by PhpStorm.
 * @description:数组转换成树形
 * @author:ningweibiao
 * @date 2019/5/24 15:17
 * @param $data
 * @param int $pId
 * @return array
 */
function arrayToTree($data, $pId = 0)
{
    $tree = [];
    foreach($data as $k => $v)
    {
        if($v['fid'] == $pId)
        {
            $v['children'] = arrayToTree($data, $v['id']);
            $tree[] = $v;
        }
    }
    return $tree;
}

