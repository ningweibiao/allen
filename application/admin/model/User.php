<?php
/**
 * author:ningweibiao
 * createTime:2019/5/16 16:13
 * description:
 */
namespace app\admin\model;

use think\Model;

class User extends Model
{
    public function lists()
    {
        $ret = $this
            ->where('status', 1)
            ->paginate(10, false, ['query' => request()->param()]);
        return $ret?$ret:[];
    }
}