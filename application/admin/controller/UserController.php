<?php
namespace app\admin\controller;
use app\admin\controller\BaseController;
use think\Request;
use app\admin\repository\UserRepository;
use think\Validate;

class UserController extends BaseController
{
	protected $rep;
	public function __construct()
	{
		$this->rep = UserRepository::repositoryInit();
	}
	/**
	 * [index 管理员列表视图]
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
		return view('user/index');	
	}
	/**
	 * [create 管理员添加试图]
	 * @author zhouzhihon
	 * @DateTime 2017-07-24T16:29:11+0800
	 * @return   [type]                            [description]
	 */
	public function create()
	{
		return view('user/create',['role'=>$this->rep->roleList()]);	
	}
	/**
	 *  [edit 管理员编辑视图]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-26T15:55:59+0800
	 *  @return   [type]                   [description]
	 */
	public function edit($id)
	{
		$detail = $this->rep->show($id);
		//管理员拥有的权限
		$roleMenu = array_filter(explode(',', $detail['rules']));
		return view('user/edit',[]);
	}
	/**
	 * [show description]
	 * @author zhouzhihon
	 * @DateTime 2017-08-03T23:59:32+0800
	 * @param    [type]                   $id [description]
	 * @return   [type]                       [description]
	 */
	public function show($id)
	{
		
	}
	/**
	 * [store 管理员添加]
	 * @author zhouzhihon
	 * @DateTime 2017-07-23T11:40:55+0800
	 * @param    Request                  $request [description]
	 */
	public function store(Request $request)
	{
		if($request->isPost()){
			$data['username'] = input('post.username');
			$data['password'] = input('post.password');
			$data['email'] = input('post.email');
			$data['mobile'] = input('post.mobile');
			$data['reg_ip'] = get_client_ip();
			$result = $this->validate(input('post.'),'User');
			if(true !== $result){
				return jsonError($result);
			}
			if($this->rep->store($data) == null){
				return jsonSuccess([],'添加成功');
			}else{
				return jsonError('添加失败');
			}
		}
	}
	/**
	 *  [update 编辑管理员]
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
	 *  [delete 删除管理员]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-25T17:47:25+0800
	 *  @param    Request                  $request [description]
	 *  @return   [type]                            [description]
	 */
	public function delete(Request $request)
	{
		$id = input('param.')['id'];
		if($request->isPost()){
			if($this->rep->delete($id) == null){
				return jsonSuccess([],'删除成功');
			}else{
				return jsonError('删除失败');
			}
		}
	}
}