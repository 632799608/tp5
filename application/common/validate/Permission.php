<?php
namespace app\common\validate;

use think\Validate;

class Permission extends Validate
{
    protected $rule = [
        'name'  =>  'require|unique:auth_permission',
        'title' =>  'require|unique:auth_permission',
    ];
    protected $message = [
        'name.require'  =>  '权限别名不能为空',
        'name.unique'   =>  '权限别名已经存在',
        'title.require' =>  '权限名称不能为空',
        'title.unique'  =>  '权限名称已经存在',
    ];
    protected $scene = [
        'add'   =>  ['name','title'],
        'edit'  =>  ['name','title'],
    ];
}