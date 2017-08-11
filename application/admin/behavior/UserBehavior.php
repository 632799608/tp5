<?php
namespace app\admin\behavior;

use think\Session;
use think\Db;
use think\Request;

class UserBehavior 
{
	public function __construct()
	{
        $this->request = Request::instance();
	}
    /**
     * [run 检测用户增登录行为]
     * @author zhouzhihon
     * @DateTime 2017-08-09T21:07:08+0800
     * @return   [type]                   [description]
     */
    public function run($params)
    {
        $record = array(
            'name'=>'管理员登录',
            'operate'=>$this->request->module().'/'.$this->request->controller().'/'.$this->request->action(),
            'username'=>Session::get('user_login')['username'],
            'userId'=>Session::get('user_login')['id'],
            'create_time'=>time(),
            'ip'=>get_client_ip(),
        );
        db('system_log')->insert($record);
    }
}