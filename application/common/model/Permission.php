<?php
namespace app\common\model;

use think\Model;

class Permission extends Model
{
	use \app\common\traits\Model;
	// 设置当前模型对应的完整数据表名称
    protected $table = 'auth_permission';
}