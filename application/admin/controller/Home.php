<?php
/**
 * author:ningweibiao
 * createTime:2019/5/16 13:47
 * description:
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Request;

class Home extends Base
{
    public function index()
    {
        return $this->fetch();
    }
}