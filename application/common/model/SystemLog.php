<?php
namespace app\common\model;

use think\Model;

class SystemLog extends Model
{
	use \app\common\traits\Model;
	// 设置当前模型对应的完整数据表名称
    protected $table = 'system_log';
    //操作记录标识
    const note = '日志';
    //操作记录标题
    const title = 'name';
}