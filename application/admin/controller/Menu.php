<?php
namespace app\admin\controller;

use think\Db;
use think\Request;
use app\admin\model\User as UserModel;


class Menu extends Base
{
    protected $db;

    public function __construct(Request $request = null)
    {
        $this->db = Db::name('menu');
        parent::__construct($request);
    }

    /**
     *Created by PhpStorm.
     * @description:菜单列表
     * @author:ningweibiao
     * @date 2019/5/24 14:03
     * @return mixed
     */
    public function lists()
    {
        $data = $this->db
            ->where('status', 1)
            ->select();
        $this->assign('lists', $data);
        return $this->fetch();
    }

    /**
     *Created by PhpStorm.
     * @description:菜单添加
     * @author:ningweibiao
     * @date 2019/5/24 14:03
     * @param Request $request
     * @return mixed|void
     */
    public function add(Request $request)
    {
        if ($request->isPost()) {
            $post = $request->post();
            $data = [
                'menu_name'         => trim($post['menu_name']),
                'menu_url'          => trim($post['menu_url']),
                'active_url'        => trim($post['active_url']),
                'module'            => trim($post['module']),
                'show'              => $post['show'],
                'fid'               => $post['fid']?$post['fid']:0,
                'status'            => 1,
            ];
            $ret = $this->db
                ->insert($data);
            if ($ret) {
                session('menuArr', null);
                return $this->success('添加成功', '/menu/menu_list');
            } else {
                return $this->error('添加失败');
            }
        }
        $menuList = $this->db
            ->where('status', 1)
            ->select();
        $this->assign('menuList', $menuList);
        return $this->fetch();
    }

    public function edit(Request $request)
    {
        $id = $request->param('id');
        if ($request->isPost()) {
            $post = $request->post();
            $data = [
                'menu_name'         => trim($post['menu_name']),
                'menu_url'          => trim($post['menu_url']),
                'active_url'        => trim($post['active_url']),
                'module'            => trim($post['module']),
                'show'              => $post['show'],
                'fid'               => $post['fid']?$post['fid']:0,
            ];
            $ret = $this->db
                ->where('id', $id)
                ->update($data);
            if ($ret) {
                session('menuArr', null);
                return $this->success('编辑成功', '/menu/menu_list');
            } else {
                return $this->error('编辑失败');
            }
        }
        $menuInfo = $this->db
            ->where('id', $id)
            ->find();
        $menuList = $this->db
            ->where('status', 1)
            ->select();
        $this->assign('id', $id);
        $this->assign('menuInfo', $menuInfo);
        $this->assign('menuList', $menuList);
        return $this->fetch();
    }

    public function del(Request $request)
    {
        $id = $request->param('id');
        $data = ['status' => -1];
        $ret = $this->db
            ->where('id',$id)
            ->update($data);
        if ($ret) {
            session('menuArr', null);
            return $this->success('删除成功', '/menu/menu_list');
        } else {
            return $this->error('删除失败');
        }
    }


}
