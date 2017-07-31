<?php
namespace app\common\validate;

use think\Validate;

class Role extends Validate
{
    protected $rule = [
        'title' =>  'require|unique:auth_role',
    ];
    protected $message = [
        'title.require' =>  '角色名称不能为空',
        'title.unique'  =>  '角色名称已经存在',
    ];
    protected $scene = [
        'add'   =>  ['title'],
        'edit'  =>  ['title'],
    ];
}