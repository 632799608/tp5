<?php
namespace app\common\validate;

use think\Validate;

class User extends Validate
{
    protected $rule = [
        'username'   =>  'require|max:25',
        'password'   =>  'require|max:12|min:6',
        'repassword' =>  'require|confirm:password',
        'mobile'     =>  'require|regex:/^1[34578]\d{9}$/',
        'email'      =>  'require|email',
    ];
    protected $message = [
        'username.require' =>  '管理员名称不能为空',
        'password.require' =>  '密码不能为空',
        'mobile.require' =>  '手机号码不能为空',
        'email.require' =>  '手机号码不能为空',
        'username.max' =>  '管理员名称不能超过25个字符',
        'password.max' =>  '密码最对12个字符',
        'password.min' =>  '密码最少6个字符',
        'mobile.regex' =>  '手机号码有误',
        'email.email' =>  '邮箱格式有误',
    ];
    protected $scene = [

    ];
}