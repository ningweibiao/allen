<?php
/**
 * author:ningweibiao
 * createTime:2019/5/16 16:13
 * description:
 */
namespace app\admin\model;

use think\Model;

class Menu extends Model
{
    public function lists()
    {
        $ret = $this
            ->where('status', 1)
            ->select();
        return $ret?$ret:[];
    }

    /**
     *Created by PhpStorm.
     * @description:左边菜单
     * @author:ningweibiao
     * @date 2019/5/24 15:53
     * @return array
     */
    public function menuArr()
    {
        $lists = $this
            ->where('status', 1)
            ->where('show', 1)
            ->order('id, fid')
            ->select();
        $menuList = collection($lists)->toArray();
        $moduleArr = array_unique(array_column($menuList, 'module'));
        $menuArr = [];
        foreach ($moduleArr as $item) {
            foreach ($menuList as $k => $v) {
                if ($item == $v['module']) {
                    $menuArr[$item]['module'] = $item;
                    $menuArr[$item]['data'][] = $v;
                }
            }
        }
//        dump($menuArr);die();
        return $menuArr?$menuArr:[];
    }

    /**
     *Created by PhpStorm.
     * @description:获取高亮url
     * @author:ningweibiao
     * @date 2019/5/24 17:06
     * @param array $where
     * @return mixed|string
     */
    public function getActiveUrl($where = [])
    {
        $active_url = $this
            ->where($where)
            ->value('active_url');
        return $active_url?$active_url:'';
    }

}