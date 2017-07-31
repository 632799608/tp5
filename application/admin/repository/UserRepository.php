<?php
namespace app\admin\repository;
use app\common\model\User;

class UserRepository
{
	use \app\common\traits\Repository;
	protected $model;
	public function __construct()
	{
		$this->model = User::modelInit();
	}
	/**
	 *  [login 查询用户信息]
	 *  @author zhouzhihon
	 *  @DateTime 2017-06-05T14:39:58+0800
	 *  @param    [type]                   $map [description]
	 *  @return   [type]                        [description]
	 */
	public function login($map)
	{
		return $this->model->where($map)->find();
	}
     /**
      *  [loginRecord 登录记录 ip 时间]
      *  @author zhouzhihon
      *  @DateTime 2017-06-05T14:40:39+0800
      *  @param    string                   $value [description]
      *  @return   [type]                          [description]
      */
    public function loginRecord($id)
    {
    	return $this->model->update([ 
	        'id'              => $id ,
	        'last_login_time' => time(), 
	        'last_login_ip'   => get_client_ip() 
     	]);
    }

}