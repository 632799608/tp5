<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Cache;
use app\admin\repository\PermissionRepository;
use think\Validate;

class PermissionController extends Controller
{
	protected $rep;
	public function __construct()
	{
		$this->rep = PermissionRepository::repositoryInit();
	}
	/**
	 * [index 权限列表视图]
	 * @author zhouzhihon
	 * @DateTime 2017-07-02T15:41:31+0800
	 * @param    string                   $value [description]
	 * @return   [type]                          [description]
	 */
	public function index(Request $request)
	{
		if($request->isPost()){
			return $this->rep->index();
		}
		return view('permission/index');	
	}
	/**
	 * [menuList description]
	 * @author zhouzhihon
	 * @DateTime 2017-07-23T16:16:30+0800
	 * @param    Request                  $request [description]
	 * @return   [type]                            [description]
	 */
	public function menuList()
	{
		return sort_parent($this->rep->menuList());
	}
	/**
	 * [create 权限添加试图]
	 * @author zhouzhihon
	 * @DateTime 2017-07-24T16:29:11+0800
	 * @return   [type]                            [description]
	 */
	public function create()
	{
		return view('permission/create',['menu'=>$this->menuList()]);	
	}
	/**
	 * [store 权限添加]
	 * @author zhouzhihon
	 * @DateTime 2017-07-23T11:40:55+0800
	 * @param    Request                  $request [description]
	 */
	public function store(Request $request)
	{
		if($request->isPost()){
			$data = input('post.');
			$result = $this->validate($data,'Permission');
			if(true !== $result){
				return jsonError($result);
			}
			if($this->rep->store($data)){
				Cache::rm('auth_permission_list');
				return jsonSuccess([],'添加成功');
			}else{
				return jsonError('添加失败');
			}
		}
	}
	/**
	 *  [edit 权限编辑视图]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-26T15:55:59+0800
	 *  @return   [type]                   [description]
	 */
	public function edit($id)
	{
		$detail = $this->rep->show($id);
		return view('permission/edit',['menu'=>$this->menuList(),'detail'=>$detail]);
	}
	/**
	 *  [update 编辑权限]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-26T16:01:19+0800
	 *  @param    Request                  $request [description]
	 *  @return   [type]                            [description]
	 */
	public function update(Request $request)
	{
		if($request->isPost()){
			$data = input('post.');
			$result = $this->validate($data,'Permission');
			if(true !== $result){
				return jsonError($result);
			}
			if($this->rep->update($data)){
				Cache::rm('auth_permission_list');
				return jsonSuccess($this->rep->update($data),'编辑成功');
			}else{
				return jsonError('编辑失败');
			}
		}
	}
	/**
	 * [icon description]
	 * @author zhouzhihon
	 * @DateTime 2017-07-24T20:45:20+0800
	 * @return   [type]                   [description]
	 */
	public function icon()
	{
		return view('icon/index');
	}
	/**
	 *  [delete 删除权限]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-25T17:47:25+0800
	 *  @param    Request                  $request [description]
	 *  @return   [type]                            [description]
	 */
	public function delete(Request $request)
	{
		$id = input('param.')['id'];
		if($request->isPost()){
			if($this->rep->delete($id)){
				Cache::rm('auth_permission_list');
				return jsonSuccess($this->rep->delete($id),'删除成功');
			}else{
				return jsonError('删除失败');
			}
		}
	}
}