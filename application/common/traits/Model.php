<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Date: 2017/1/27 Time: 上午8:35
// +----------------------------------------------------------------------
namespace app\common\traits;

trait Model
{
    /**
     *  [$_mo 单例]
     *  @var null
     */
    private static $_mo = null;
    protected static function init()
    {
        self::event('before_insert',function(&$data){
            self::before_create($data);
        });
        self::event('before_update',function(&$data){
            self::before_update($data);
        });
        self::event('after_insert',function(){
            self::after_create();
        });
        self::event('after_update',function(){
            self::after_update();
        });
        self::event('before_delete',function(){
            self::after_delete();
        });
    }
    /**
     * [modelInit 单例的初始化]
     * @author zhouzhihon
     * @DateTime 2017-07-22T11:29:14+0800
     * @return   [type]                   [description]
     */
    public static function modelInit(){
        if(self::$_mo === null){
            self::$_mo = new self();
        }
        return self::$_mo;
    }
    /**
     * [before_create 调用模型添加之前事件]
     * @author zhouzhihon
     * @DateTime 2017-07-22T15:35:24+0800
     * @param    [type]                   &$data [description]
     * @return   [type]                          [description]
     */
    public static function before_create(&$data){
        $data->create_time = time();
    }
    /**
     * [before_update 调用模型更新之前事件]
     * @author zhouzhihon
     * @DateTime 2017-07-22T15:36:11+0800
     * @param    [type]                   &$data [description]
     * @return   [type]                          [description]
     */
    public static function before_update(&$data){
        $data->update_time = time();
    }
    /**
     * [after_create 模型更新之后事件]
     * @author zhouzhihon
     * @DateTime 2017-08-10T21:26:42+0800
     * @return   [type]                   [description]
     */
    public static function after_create(){

    }
    /**
     * [after_update 模型更新之后标签位]
     * @author zhouzhihon
     * @DateTime 2017-08-10T22:37:57+0800
     * @return   [type]                   [description]
     */
    public static function after_update()
    {
        
    }
    /**
     * [after_delete 模型删除之后事件]
     * @author zhouzhihon
     * @DateTime 2017-08-10T22:35:31+0800
     * @return   [type]                   [description]
     */
    public static function after_delete()
    {
                \think\Log::write('controller666666666677'.request()->controller());
        \think\Log::write('action666666666688'.request()->action());
        \think\Log::write('module666666666699'.request()->module());
    }
}