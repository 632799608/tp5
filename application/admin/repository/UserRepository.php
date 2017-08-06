<?php
namespace app\admin\repository;
use app\common\model\User;
use app\common\model\Role;
use think\Db;

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
	 * [store 添加管理员]
	 * @author zhouzhihon
	 * @DateTime 2017-07-23T11:54:25+0800
	 */
	public function store($data)
	{
		$exp = Db::transaction(function () use ($data){
		    $user = $this->model->create($data);
		    $user->roles()->attach(array_filter(explode(',', input('post.roles'))));
		});
		return $exp;
	}
	/**
	 *  [update 编辑管理员]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-26T17:27:48+0800
	 *  @return   [type]                   [description]
	 */
	public function update($data)
	{
		$exp = Db::transaction(function () use ($data){
		    Db::table('auth_user_role')->where(['uid'=>input('post.id')])->delete();	
		    $user = $this->model->update($data);
		    $user->roles()->attach(array_filter(explode(',', input('post.roles'))));
		});
		return $exp;
	}
	/**
	 * [delete 删除管理员]
	 * @author zhouzhihon
	 * @DateTime 2017-07-25T23:05:29+0800
	 * @return   [type]                   [description]
	 */
	public function delete($id)
	{
		$exp = Db::transaction(function () use ($id){
			if(is_array($id)){
				$this->model->where('id','in',$id)->delete();
				Db::table('auth_user_role')->where('uid','in',$id)->delete();
			}else{
				$this->model->where(['id'=>$id])->delete();
				Db::table('auth_user_role')->where(['uid'=>$id])->delete();	
			}
		});
		return $exp;
	}
	/**
	 *  [show 根据id获取一条管理员详情]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-26T17:10:28+0800
	 *  @param    [type]                   $id [角色id]
	 *  @return   [type]                       [description]
	 */
	public function show($id)
	{
		return $this->model->where('id',$id)->find();
	}
	/**
	 * [role 当前管理员拥有的角色id]
	 * @author zhouzhihon
	 * @DateTime 2017-08-04T22:43:02+0800
	 * @param    [type]                   $id [description]
	 * @return   [type]                       [description]
	 */
	public function role($id)
	{
		$role = Db::table('auth_user_role')->where(['uid'=>$id])->select();
		$arr = [];
		foreach ($role as $value) {
			array_push($arr, $value['group_id']);
		}
		return $arr;
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