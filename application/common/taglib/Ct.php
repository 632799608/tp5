<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

namespace app\common\taglib;

use think\template\TagLib;
use think\auth\Auth;
use think\Session;

class Ct extends Taglib
{
	    // 标签定义
    protected $tags = [
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'hhp'        => ['attr' => ''],
        'auth'     => ['attr' => 'name'],
    ];

    /**
     * php标签解析
     * 格式：
     * {php}echo $name{/php}
     * @access public
     * @param array $tag 标签属性
     * @param string $content 标签内容
     * @return string
     */
    public function tagHhp($tag, $content)
    {
        $parseStr = '<?php ' . $content . ' ?>';
        return $parseStr;
    }
    /**
     * php标签解析
     * 格式：
     * {php}echo $name{/php}
     * @access public
     * @param array $tag 标签属性
     * @param string $content 标签内容
     * @return string
     */
    public function tagAuth($tag, $content)
    {
        $auth = new Auth();
        $user_id = Session::get('user_login')['id'];
        $name = $tag['name'];
        $result = $auth->check($name, $user_id);
        $result = $result == false ? 0 : 1;
        $parseStr  = '<?php if(' . $result . '): ?>' . $content . '<?php endif; ?>';
        return $parseStr;
    }
}
?>