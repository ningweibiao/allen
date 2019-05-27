<?php
/**
 * author:ningweibiao
 * createTime:2019/5/24 17:27
 * description:
 */

namespace app\admin\validate;

use think\Validate;

class UserValidate extends Validate
{
    protected $rule =   [
        'name'  => 'require|max:25',
        'age'   => 'number|between:1,120',
        'email' => 'email',
        'mobile' => 'require|number|length:11|checkMobile:thinkphp',
    ];

    protected $message  =   [
        'mobile.require' => '手机号必须',
        'mobile.number' => '手机号必须是数字',
        'mobile.length' => '手机号必须11位数字',
        'name.require' => '名称必须',
        'name.max'     => '名称最多不能超过25个字符',
        'age.number'   => '年龄必须是数字',
        'age.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',
    ];

    protected $scene = [
        'login'  =>  ['mobile'],
    ];
    // 自定义验证规则
    protected function checkMobile($value)
    {
        if(preg_match("/^1[34578]\d{9}$/", $value)){
            return true;
        } else {
            return '手机号不合法';
        }
    }
}