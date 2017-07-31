<?php
use think\auth\Auth;
use think\Session;
/**
 * [checkAuth description]
 * @author zhouzhihon
 * @DateTime 2017-07-04T21:05:20+0800
 * @param    [type]                   $name [模块名称/控制器名称/操作名称]
 * @return   [type]                         [true 有权限 false 没有权限]
 */
function checkAuth($name)
{
	$auth = new Auth();
	$user_id = Session::get('user_login')['id'];
	// if($user_id ==1){
	// 	return true;
	// }
	return $auth->check($name, $user_id);
}