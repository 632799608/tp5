<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\repository\UserRepository;
use think\auth\Auth;
use think\Cache;
use think\Session;
use think\Db;

class LoginController extends Controller {

	protected $rep;
	public function __construct()
	{
		$this->rep = UserRepository::repositoryInit();
	}
	/**
	 *  [index 调转登录页面]
	 *  @author zhouzhihon
	 *  @DateTime 2017-05-31T15:31:03+0800
	 *  @return   [type]                   [description]
	 */
	public function index()
	{
		return view('login/index');
	}
	/**
	 *  [verify 验证码]
	 *  @author zhouzhihon
	 *  @DateTime 2017-05-31T15:31:03+0800
	 *  @return   [type]                   [description]
	 */
	public function verify()
	{
		return verify();
	}
	/**
	 *  [login 用户登录]
	 *  @author zhouzhihon
	 *  @DateTime 2017-06-01T13:37:23+0800
	 *  @param    string                   $value [description]
	 *  @return   [type]                          [description]
	 */
	public function login()
	{   
		if(request()->isPost()){
			$username = input('post.username');
			$password = input('post.password');
			$code = input('post.captcha');
			if(!$code){
				$this->error('请填写验证码');
			}
			if(!$username || !$password){
				$this->error('请填写用户名或密码');
			}
			if($code !== session('verify_code')){
				$this->error('验证码错误');
			}
			$map['username'] = $username;
			$map['password'] = think_ucenter_encrypt($password,config('encryptKey'));
			$user = $this->rep->login($map);
			if ($user) {
				if($user['status'] == -1){
					$this->error('该用户已暂停使用');
				}
				$this->rep->loginRecord($user['id']);
				session('user_login', $user);
				//获取当前登录用户的id
				$userId = session('user_login')['id'];
				$auth = new Auth();
				$auth_permission_list = Cache::remember('auth_permission_list',function(){
		             return Db::name('auth_permission')
		                   ->field(['id','name','title','pid','icon'])
		                   ->where('status', 1)
		                   ->order(['sort' => 'DESC', 'id' => 'ASC'])
		                   ->select();;//获取全部节点列表
		        });
		        $menu = [];
				foreach ($auth_permission_list as $value) {
					//获取当前用户所拥有的权限列表
		            if ($auth->check($value['name'], $userId)) {
		                $menu[] = $value;
		            }
		        }
		        Cache::set('menu'.$userId,$menu);//每次用户登录获取用户的权限列表存缓存，退出登录则清除权限缓存
				$this->success('登录成功', 'admin/index/index');
				\think\Hook::listen('user_behavior',$params);
				\think\Hook::exec('app\admin\behavior\UserBehavior','run',$params);
			}else{
				$this->error('用户名或密码错误');
			}
		}
		$this->error('请求错误！');
	}
	/**
	 * [out 退出登录]
	 * @author zhouzhihon
	 * @DateTime 2017-07-12T20:59:47+0800
	 * @return   [type]                   [description]
	 */
	public function out()
	{
		$userId = Session::get('user_login')['id'];
		Cache::rm('menu'.$userId); 
		Session::delete('user_login');
		// 删除缓存数据
		$this->redirect('admin/login/index');
	}
}