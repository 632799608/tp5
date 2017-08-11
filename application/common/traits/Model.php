<?php
// +----------------------------------------------------------------------
// | Demo [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Date: 2017/1/27 Time: 上午8:35
// +----------------------------------------------------------------------
namespace app\common\traits;

use think\Session;

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
        self::event('after_insert',function($data){
            self::after_create($data);
        });
        self::event('after_update',function($data){
            self::after_update($data);
        });
        self::event('after_delete',function($data){
            self::after_delete($data);
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
     *  [del 通过id单个和多个删除模型]
     *  @author zhouzhihon
     *  @DateTime 2017-08-11T10:14:39+0800
     *  @param    [type]                   $id [单个id：1 ,多个id:[1,2]]
     *  @return   [type]                       [description]
     */
    public function del($id)
    {
        if (is_numeric($id)) {
            $id = explode(',', $id);
        }
        $arr = [];
        foreach ($id as $value) {
            $arr[] = $value;
        }
        return self::destroy($arr);
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
    public static function after_create($data){
        $operate = '添加';
        self::record($data,$operate);
    }
    /**
     * [after_update 模型更新之后标签位]
     * @author zhouzhihon
     * @DateTime 2017-08-10T22:37:57+0800
     * @return   [type]                   [description]
     */
    public static function after_update($data)
    {
        $operate = '修改';
        self::record($data,$operate);
    }
    /**
     * [after_delete 模型删除之后事件]
     * @author zhouzhihon
     * @DateTime 2017-08-10T22:35:31+0800
     * @return   [type]                   [description]
     */
    public static function after_delete($data)
    {
        $operate = '删除';
        self::record($data,$operate);
    }
    /**
     *  [record description]
     *  @author zhouzhihon
     *  @DateTime 2017-08-11T14:39:05+0800
     *  @param    [type]                   $data [description]
     *  @return   [type]                         [description]
     */
    public static function record($data,$operate)
    {
        if (request()->module() == 'admin') {
            $title = self::title;
            $record = array(
                'name'=>$operate.self::note.'【'.$data->$title.'】',
                'recordId'=>$data->id,
                'operate'=>request()->module().'/'.request()->controller().'/'.request()->action(),
                'username'=>Session::get('user_login')['username'],
                'userId'=>Session::get('user_login')['id'],
                'data'=>$data,
                'create_time'=>date('Y-m-d H:i:s'),
                'ip'=>get_client_ip(),
            );
            db('system_log')->insert($record);
        }
    }
}