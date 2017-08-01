<?php
namespace app\common\model;

use think\Model;

class User extends Model
{
	use \app\common\traits\Model;
	// 设置当前模型对应的完整数据表名称
    protected $table = 'auth_user';
    /**
     *  [roles 多对多关联roles]
     *  @author zhouzhihon
     *  @DateTime 2017-08-01T17:24:12+0800
     *  @return   [type]                   [description]
     */
    public function roles()
    {
        return $this->belongsToMany('Role','auth_user_role','group_id','uid');
    }
}