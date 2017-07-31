<?php
namespace app\admin\controller;

use app\admin\controller\BaseController;
use Think\Request;
use Think\Config;

class IndexController extends BaseController
{
    public function index()
    {
		return view('index/index');
    }
}
