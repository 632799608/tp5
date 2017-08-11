<?php
namespace app\admin\controller;

use think\Controller;
use think\Request;
use app\admin\repository\LogRepository;

class LogController extends Controller
{
	protected $rep;
	public function __construct()
	{
		$this->rep = LogRepository::repositoryInit();
	}
	/**
	 * [index 日志列表视图]
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
		return view('log/index');	
	}
	/**
	 *  [delete 删除日志记录]
	 *  @author zhouzhihon
	 *  @DateTime 2017-07-25T17:47:25+0800
	 *  @param    Request                  $request [description]
	 *  @return   [type]                            [description]
	 */
	public function delete(Request $request)
	{
		$id = input('param.')['id'];
		// return jsonSuccess($request->post(),'删除成功');
		if($request->isPost()){
			if($this->rep->delete($id)){
				return jsonSuccess(1,'删除成功');
			}else{
				return jsonError('删除失败');
			}
		}
	}
}