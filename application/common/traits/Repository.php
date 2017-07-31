<?php
namespace app\common\traits;

trait Repository
{
    /**
     *  [$model description]
     *  @var [type]
     */
    protected $model;
    /**
     *  [$_repo 单例]
     *  @var null
     */
    private static $_repo = null;
    /**
     * [repositoryInit 单例的初始化]
     * @author zhouzhihon
     * @DateTime 2017-07-22T11:31:14+0800
     * @return   [type]                   [description]
     */
    public static function repositoryInit(){
        if(self::$_repo === null){
            self::$_repo = new self();
        }
        return self::$_repo;
    }

    final protected function __clone()
    {

    }
}