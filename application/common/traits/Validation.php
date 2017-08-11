<?php
namespace app\common\traits;

trait Validation
{
    /**
     *  [$_mo 单例]
     *  @var null
     */
    private static $_Va = null;
    /**
     * [validateInit 单例的初始化]
     * @author zhouzhihon
     * @DateTime 2017-07-22T11:29:50+0800
     * @return   [type]                   [description]
     */
    public static function validateInit(){
        if(self::$_Va === null){
            self::$_Va = new self();
        }
        return self::$_Va;
    }
}