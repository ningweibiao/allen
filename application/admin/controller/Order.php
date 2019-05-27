<?php
namespace app\admin\controller;

use think\Db;
use think\Request;

class order extends Base
{
    public function lists()
    {
        return $this->fetch();
    }
    public function add()
    {
        return $this->fetch();
    }
}
