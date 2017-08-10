<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\controller\BaseController;
use Think\Request;
use Think\Config;

class IndexController extends Controller
{
    public function index()
    {
		return view('index/index');
    }
}
