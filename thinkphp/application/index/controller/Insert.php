<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use think\Db;
header("content-type:text/html;charset=utf-8");
class Insert extends Controller
{
    public function index(){
    	 $param =input('post.');
    	 var_dump($param);
    }
}