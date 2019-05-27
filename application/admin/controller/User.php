<?php
namespace app\admin\controller;

use think\Db;
use think\Request;
use think\Session;
use app\admin\model\User as UserModel;
use app\admin\validate\UserValidate;


class User extends Base
{
    protected $db;

    public function __construct(Request $request = null)
    {
        $this->db = Db::name('user');
        parent::__construct($request);
    }

    /**
     *Created by PhpStorm.
     * @description:登录页
     * @author:ningweibiao
     * @date 2019/5/16 13:36
     * @param Request $request
     * @return mixed
     */
    public function login(Request $request)
    {
        if ($request->isPost()) {
            $mobile = $request->post('mobile');
            $tmpPassword = $request->post('password');
            $userValidate = new UserValidate();
            $result   = $userValidate->scene('login')->check($request->post());
            if(!$result){
                return $this->error($userValidate->getError());
            }
            $password = $this->db
                ->where('mobile', $mobile)
                ->where('status', 1)
                ->value('password');
            if ($tmpPassword == $password) {
                $this->success('登录成功', '/home/index');
            } else {
                $this->error('手机号或密码错误');
            }

        }
        return $this->fetch();
    }

    /**
     *Created by PhpStorm.
     * @description:用户列表
     * @author:ningweibiao
     * @date 2019/5/16 15:39
     */
    public function lists()
    {
        $UserModel = new UserModel();
        $ret = $UserModel->lists();
        $lists = $ret->toArray()['data'];
        $pageHtml = $ret->render();
        $this->assign('lists', $lists);
        $this->assign('pageHtml', $pageHtml);
        return $this->fetch();
    }

    /**
     *Created by PhpStorm.
     * @description:退出登录
     * @author:ningweibiao
     * @date 2019/5/16 17:35
     */
    public function logout()
    {
        Session::clear();
        return $this->redirect('/user/user_login');
    }

    /**
     *Created by PhpStorm.
     * @description:添加用户
     * @author:ningweibiao
     * @date 2019/5/16 17:36
     */
    public function add(Request $request)
    {
        if ($request->isPost()) {
            $posts = $request->post();
            $file = request()->file('image');
            if ($file) {
                // 移动到框架应用根目录/uploads/ 目录下
                $info = $file->move( './uploads', true,false);
                if($info){
                    //图片上传地址
                    $saveName =  $info->getSaveName();
                    $fileName =  $info->getFilename();
                    $timePath = date('Ymd', time());
                    $smallPath = $timePath.'/s_'.$fileName;
                    $image = \think\Image::open('./uploads/'.$saveName);
                    $image->thumb(100, 100)->save('./uploads/'.$smallPath);
                }else{
                    // 上传失败获取错误信息
                    return $file->getError();
                }
            }

            $data = [
                'user_name'             => trim($posts['userName']),
                'password'              => $posts['password'],
                'mobile'                => $posts['mobile'],
                'sex'                   => $posts['sex'],
                'province'              => $posts['province'],
                'city'                  => $posts['city'],
                'area'                  => $posts['area'],
                'remark'                => trim($posts['remark']),
                'create_time'           => time(),
                'status'                => 1,
                'face'                  => $smallPath,
            ];
            $ret = $this->db
                ->insert($data);
            if ($ret) {
                return $this->success('添加成功', '/user/user_list');
            } else {
                return $this->error('添加失败');
            }

        }

        return $this->fetch();
    }

    /**
     *Created by PhpStorm.
     * @description:用户修改
     * @author:ningweibiao
     * @date 2019/5/22 16:26
     * @param Request $request
     * @return mixed|void
     */
    public function edit(Request $request)
    {
        $id = $request->param('id');
        if ($request->isPost()) {
            $posts = $request->post();
            $data = [
                'user_name'             => trim($posts['userName']),
                'password'              => trim($posts['password']),
                'mobile'                => trim($posts['mobile']),
                'sex'                   => $posts['sex'],
                'province'              => $posts['province'],
                'city'                  => $posts['city'],
                'area'                  => $posts['area'],
                'remark'                => trim($posts['remark']),
                'update_time'           => time(),
            ];
            $file = request()->file('image');
            if ($file) {
                // 移动到框架应用根目录/uploads/ 目录下
                $info = $file->move( './uploads', true,false);
                if($info){
                    //图片上传地址
                    $saveName =  $info->getSaveName();
                    $fileName =  $info->getFilename();
                    $timePath = date('Ymd', time());
                    $smallPath = $timePath.'/s_'.$fileName;
                    $image = \think\Image::open('./uploads/'.$saveName);
                    $image->thumb(100, 100)->save('./uploads/'.$smallPath);
                    $data['face'] = $smallPath;
                }else{
                    // 上传失败获取错误信息
                    return $file->getError();
                }
            }

            $ret = $this->db
                ->where('id',$id)
                ->update($data);
            if ($ret) {
                return $this->success('修改成功', '/user/user_list');
            } else {
                return $this->error('修改失败');
            }

        }
        $userInfo = $this->db
            ->where('id', $id)
            ->find();
        $this->assign('id', $id);
        $this->assign('userInfo', $userInfo);
        return $this->fetch();
    }

    /**
     *Created by PhpStorm.
     * @description:用户删除
     * @author:ningweibiao
     * @date 2019/5/22 16:59
     * @param Request $request
     */
    public function del(Request $request)
    {
        $id = $request->param('id');
        $data = ['status' => -1];
        $ret = $this->db
            ->where('id',$id)
            ->update($data);
        if ($ret) {
            return $this->success('删除成功', '/user/user_list');
        } else {
            return $this->error('删除失败');
        }
    }
}
