<?php
/**
 * author:ningweibiao
 * createTime:2019/5/16 13:46
 * description:
 */

namespace app\admin\controller;

use think\Controller;
use think\Db;
use think\Session;
use think\Request;
use app\admin\model\Menu;

class Base extends Controller
{
    public function _initialize()
    {
        $request = Request::instance();
        $sction  = $request->action();
        $controller  = $request->controller();
        $nowPath  = $request->path();
        $menuModel = new Menu();
        $nowPath = $menuModel->getActiveUrl(['menu_url'=>'/'.$nowPath]);
        session_start();
        //左边菜单
        $menuArr = Session::get('menuArr');
        if (empty($menuArr)) {
            $menuArr = $menuModel->menuArr();
            Session::set('menuArr',$menuArr);
        }
        $this->assign('nowPath', $nowPath);
        $this->assign('menuArr', $menuArr);
    }
}