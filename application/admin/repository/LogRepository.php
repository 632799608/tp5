<?php
namespace app\admin\repository;
use app\common\model\SystemLog;
use think\Db;

class LogRepository
{
	use \app\common\traits\Repository;
	protected $model;
	public function __construct()
	{
		$this->model = SystemLog::modelInit();
	}
	/**
	 *  [index description]
	 *  @author zhouzhihon
	 *  @DateTime 2017-08-01T17:00:10+0800
	 *  @return   [type]                   [description]
	 */
	public function index()
	{
		$map = ['username'=>['like','%'.input('param.name').'%']];
		return $this->model->where($map)->order('id desc')->paginate(input('post.pageSize'),false,['page'=>input('post.page')]);
	}
	/**
	 * [delete 删除日志]
	 * @author zhouzhihon
	 * @DateTime 2017-07-25T23:05:29+0800
	 * @return   [type]                   [description]
	 */
	public function delete($id)
	{
		return $this->model->del($id);
	}

}