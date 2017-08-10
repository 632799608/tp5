<?php
namespace app\admin\repository;
use app\common\model\Permission;

class PermissionRepository
{
	use \app\common\traits\Repository;
	protected $model;
	public function __construct()
	{
		$this->model = Permission::modelInit();
	}
	/**
	 *  [index 权限列表]
	 *  @author zhouzhihon
	 *  @DateTime 2017-06-05T14:39:58+0800
	 *  @param    [type]                   $request [description]
	 *  @return   [type]                        [description]
	 */
	public function index()
	{
		$map = ['title'=>['like','%'.input('param.name').'%']];
		return $this->model->where($map)->field('id,name,title,icon,pid')->order('id desc')->paginate(input('post.pageSize'),false,['page'=>input('post.page')]);
	}
	/**
	 * [menuList 菜单列表]
	 * @author zhouzhihon
	 * @DateTime 2017-07-23T16:17:37+0800
	 * @return   [type]                   [description]
	 */
	public function menuList()
	{
		return $this->model->where(['is_menu'=>1])->field('id,name,title,icon,pid')->select();
	}
	/**
	 * [store 添加权限]
	 * @author zhouzhihon
	 * @DateTime 2017-07-23T11:54:25+0800
	 */
	public function store($data)
	{
		return $this->model->create($data);
	}
	/**
	 *  [update 编辑权限]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-26T17:27:48+0800
	 *  @return   [type]                   [description]
	 */
	public function update($data)
	{
		return $this->model->update($data);
	}
	/**
	 * [delete 删除权限]
	 * @author zhouzhihon
	 * @DateTime 2017-07-25T23:05:29+0800
	 * @return   [type]                   [description]
	 */
	public function delete($id)
	{

		return $this->model->destroy(['id','in',$id]);
		if (is_array($id)) {
			return $this->model->where('id','in',$id)->delete();
		}else{
			return $this->model->where(['id'=>$id])->delete();
		}
	}
/**
 *  [show 根据id获取一条权限详情]
 *  @author zhouzhihon
 *  @DateTime 2017-07-26T17:10:28+0800
 *  @param    [type]                   $id [权限id]
 *  @return   [type]                       [description]
 */
	public function show($id)
	{
		return $this->model->get($id);
	}
}