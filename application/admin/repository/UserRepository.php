<?php
namespace app\admin\repository;
use app\common\model\User;
use app\common\model\Role;

class UserRepository
{
	use \app\common\traits\Repository;
	protected $model;
	public function __construct()
	{
		$this->model = User::modelInit();
	}
	/**
	 *  [index description]
	 *  @author zhouzhihon
	 *  @DateTime 2017-08-01T17:00:10+0800
	 *  @return   [type]                   [description]
	 */
	public function index()
	{
		$map = ['username'=>['like','%'.input('param.name').'%']];
		return $this->model->where($map)->with('roles')->order('id desc')->paginate(input('post.pageSize'),false,['page'=>input('post.page')]);
	}
	/**
	 *  [roleList 角色列表]
	 *  @author zhouzhihon
	 *  @DateTime 2017-08-01T17:48:13+0800
	 *  @return   [type]                   [description]
	 */
	public function roleList()
	{
		return Role::field('id,title')->select();
	}
	/**
	 *  [login 查询管理员信息]
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