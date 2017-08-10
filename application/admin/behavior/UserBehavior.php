<?php
namespace app\admin\behavior;

use think\auth\Auth;
use think\Session;
use think\Db;
use think\Cache;
use think\Request;

class UserBehavior 
{
	public function __construct()
	{
        $this->request = $this->request = Request::instance();
	}
    /**
     * [run 检测用户增删改行为]
     * @author zhouzhihon
     * @DateTime 2017-08-09T21:07:08+0800
     * @return   [type]                   [description]
     */
    public function run()
    {

    }
}