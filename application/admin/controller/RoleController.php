<?php
namespace app\admin\controller;
use app\admin\controller\BaseController;
use think\Request;
use think\Cache;
use app\admin\repository\RoleRepository;
use think\Validate;

class RoleController extends BaseController
{
	protected $rep;
	public function __construct()
	{
		$this->rep = RoleRepository::repositoryInit();
	}
	/**
	 * [index 角色列表视图]
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
		return view('role/index');	
	}
	/**
	 * [create 角色添加试图]
	 * @author zhouzhihon
	 * @DateTime 2017-07-24T16:29:11+0800
	 * @return   [type]                            [description]
	 */
	public function create()
	{
		return view('role/create',['menu'=>$this->menuList()]);	
	}
	/**
	 *  [edit 角色编辑视图]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-26T15:55:59+0800
	 *  @return   [type]                   [description]
	 */
	public function edit($id)
	{
		$detail = $this->rep->show($id);
		//角色拥有的权限
		$roleMenu = array_filter(explode(',', $detail['rules']));
		return view('role/edit',[
					'menu'=>$this->menuList(),
					'detail'=>$detail,
					'roleMenu'=>$roleMenu
				]);
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
	 * [store 角色添加]
	 * @author zhouzhihon
	 * @DateTime 2017-07-23T11:40:55+0800
	 * @param    Request                  $request [description]
	 */
	public function store(Request $request)
	{
		if($request->isPost()){
			$data = input('post.');
			$result = $this->validate($data,'Role');
			if(true !== $result){
				return jsonError($result);
			}
			if($this->rep->store($data)){
				return jsonSuccess([],'添加成功');
			}else{
				return jsonError('添加失败');
			}
		}
	}
	/**
	 *  [update 编辑角色]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-26T16:01:19+0800
	 *  @param    Request                  $request [description]
	 *  @return   [type]                            [description]
	 */
	public function update(Request $request)
	{
		if($request->isPost()){
			$data = input('post.');
			$result = $this->validate($data,'Role');
			if(true !== $result){
				return jsonError($result);
			}
			if($this->rep->update($data)){
				Cache::rm('auth_permission_list');
				return jsonSuccess([],'编辑成功');
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
	 *  [delete 删除角色]
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
				return jsonSuccess($this->rep->delete($id),'删除成功');
			}else{
				return jsonError('删除失败');
			}
		}
	}
}