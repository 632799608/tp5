<?php
namespace app\admin\behavior;

use think\auth\Auth;
use think\Session;
use think\Db;
use think\Cache;
use think\Request;

class CheckAuth 
{
    use \traits\controller\Jump;
	public function __construct()
	{
        $this->request = $this->request = Request::instance();
	}
    /**
     * [run 检测用户行为]
     * @author zhouzhihon
     * @DateTime 2017-08-09T21:07:08+0800
     * @return   [type]                   [description]
     */
    public function run()
    {
        $this->checkAuth();
        $this->getMenu();
    }
	/**
	 *  [checkAuth 检查权限]
	 *  @author zhouzhihon
	 *  @DateTime 2017-06-05T16:39:24+0800
	 *  @return   [type]                   [description]
	 */
    protected function checkAuth()
    {
        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();
        // 排除权限
        $not_check = ['admin/Login/index', 'admin/Login/verify','admin/Login/out','admin/Login/login'];
        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            if (!Session::has('user_login')) {
                $this->redirect('admin/login/index');
            }
            $auth = new Auth();
            $user_id = Session::get('user_login')['id'];
            if (!$auth->check($module . '/' . $controller . '/' . $action, $user_id)) {
                $this->error('没有权限');
            }
        }
    }
	/**
	 *  [getMenu 获取左侧菜单]
	 *  @author zhouzhihon
	 *  @DateTime 2017-06-05T16:39:37+0800
	 *  @return   [type]                   [description]
	 */
    protected function getMenu()
    {
        //获取当前登录用户的id
        $user_id = Session::get('user_login')['id'];
        $menu = Cache::remember('menu'.$user_id,function(){
            return $this->userMenu();
        });
        $menu = !empty($menu) ? sort_parent($menu) : [];
        \think\View::share('menu',$menu); 
    }
    /**
     * [permissionList 返回所有权限列表]
     * @author zhouzhihon
     * @DateTime 2017-07-11T22:06:52+0800
     * @return   [type]                   [description]
     */
    public function permissionList()
    {
        return Db::name('auth_permission')
                   ->field(['id','name','title','pid','icon'])
                   ->where('status', 1)
                   ->order(['sort' => 'DESC', 'id' => 'ASC'])
                   ->select();
    }
    /**
     * [userMenu 获取用户节点]
     * @author zhouzhihon
     * @DateTime 2017-07-12T20:19:44+0800
     * @return   [type]                   [description]
     */
    public function userMenu()
    {
        $menu = [];
        //获取当前登录用户的id
        $user_id = Session::get('user_login')['id'];
        $auth = new Auth();
        $auth_permission_list = Cache::remember('auth_permission_list',function(){
            return $this->permissionList();//获取全部节点列表
        });
        foreach ($auth_permission_list as $value) {
            //获取当前用户所拥有的权限列表
            if ($auth->check($value['name'], $user_id)) {
                $menu[] = $value;
            }
        }
        return $menu;
    }
}