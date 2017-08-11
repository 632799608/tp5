<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use think\Hook;
Hook::add('user_behavior',[
    'app\admin\behavior\UserBehavior',
]);
// 应用公共文件
 /**
 *  [verify 验证码]
 *  @author zhouzhihon
 *  @DateTime 2017-05-31T15:31:03+0800
 *  @return   [type]                   [description]
 **/
function verify()
{
    $phrase = new PhraseBuilder;
    // 设置验证码位数,内容
    $code = $phrase->build(4,'0123456789');
    $builder = new CaptchaBuilder($code, $phrase);
    session('verify_code', $builder->getPhrase());
    $builder->build()->output();
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function get_client_ip($type = 0){
    $type = $type ? 1 : 0;
    static $ip = null;
    if (null !== $ip) {
        return $ip[$type];
    }

    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        $pos = array_search('unknown', $arr);
        if (false !== $pos) {
            unset($arr[$pos]);
        }

        $ip = trim($arr[0]);
    } elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u", ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}


/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string 
 */
function think_ucenter_md5($str, $key = 'ThinkUCenter'){
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 (单位:秒)
 * @return string 
 */
function think_ucenter_encrypt($data, $key, $expire = 0) {
    $key  = md5($key);
    $data = base64_encode($data);
    $x    = 0;
    $len  = strlen($data);
    $l    = strlen($key);
    $char =  '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x=0;
        $char  .= substr($key, $x, 1);
        $x++;
    }
    $str = sprintf('%010d', $expire ? $expire + time() : 0);
    for ($i = 0; $i < $len; $i++) {
        $str .= chr(ord(substr($data,$i,1)) + (ord(substr($char,$i,1)))%256);
    }
    return str_replace('=', '', base64_encode($str));
}

/**
 * 系统解密方法
 * @param string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key  加密密钥
 * @return string 
 */
function think_ucenter_decrypt($data, $key){
    $key    = md5($key);
    $x      = 0;
    $data   = base64_decode($data);
    $expire = substr($data, 0, 10);
    $data   = substr($data, 10);
    if($expire > 0 && $expire < time()) {
        return '';
    }
    $len  = strlen($data);
    $l    = strlen($key);
    $char = $str = '';
    for ($i = 0; $i < $len; $i++) {
        if ($x == $l) $x = 0;
        $char  .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++) {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }else{
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return base64_decode($str);
}
/**
 *  [area_sort_parent 递归迭代无限分级]
 *  @author zhouzhihon
 *  @DateTime 2017-06-06T10:14:42+0800
 *  @param    [type]                   $menus [description]
 *  @param    integer                  $pid   [description]
 *  @return   [type]                          [description]
 */
function sort_parent($menus,$pid=0)
{
    $arr = [];
    if (empty($menus)) {
        return '';
    }
    foreach ($menus as $key => $v) {
        if ($v['pid'] == $pid) {
            $v['child'] = sort_parent($menus,$v['id']);
            $arr[] = $v;
        }
    }
    return $arr;
}
/**
 * [jsonError description]
 * @author zhouzhihon
 * @DateTime 2017-07-23T12:59:12+0800
 * @param    string                   $msg [description]
 * @return   [type]                        [description]
 */
function jsonError($msg = '')
{
    $result = [
        'code' => 400,
        'message' => $msg
    ];
    return $result;
}
/**
 * [jsonSuccess description]
 * @author zhouzhihon
 * @DateTime 2017-07-23T12:59:24+0800
 * @param    array                    $data [description]
 * @param    string                   $msg  [description]
 * @return   [type]                         [description]
 */
function jsonSuccess($data = [],$msg = '')
{
    $result = [
        'code' => 200,
        'result' => $data,
        'message' => $msg
    ];
    return $result;
}