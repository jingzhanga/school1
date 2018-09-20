<?php
namespace app\index\controller;

use think\Controller;
use think\Session;
use think\Db;
header("content-type:text/html;charset=utf-8");
class Insert extends Controller
{
    public function index(){
    	 $t=Session::get('name');
    	 	if(empty($t)){
    	 		 $this->redirect(url('Login/index'));
    	 	}
    	 $dafen	=$t[0]['Use_ID'];
    	 $param =input('post.');
    	 foreach ($param as $key => $value) {
    	 	$var=explode("+", $key);
    	 	var_dump($t[0]['Use_ID']);
    	 	//判断是否打分过
    	 	$res=Db::query("select * from grade where Dafen_ID='$dafen' and Project='$var[0]' and Beidafen_ID='$var[1]'");
    	 	if(empty($res)){
    	 		Db::execute("insert grade (Project,Beidafen_ID,Dafen_ID,Grade) values ('$var[0]','$var[1]',$dafen,$value)");
    	 	}else{
    	 		Db::execute("update grade set grade.Grade=$value where grade.Project='$var[0]' and grade.Beidafen_ID='$var[1]' and grade.Dafen_ID=$dafen");
    	 		//$this->redirect(url('Index/index'));
    	 		$this->success();
    	 	}
    	 }
    }
}