<?php
namespace app\index\common;

use think\Controller;
use think\Session;
use think\Db;
header("content-type:text/html;charset=utf-8");

class Base extends Controller{
	
     public function islogin()
    {
   			$t=Session::get('name');
    		if(empty($t)){
    			 $this->redirect(url('Login/index'));
    		}
    		//var_dump($t);
    		
    		//查询对应的评价主体ID
    		$where['Job_ID']=array('eq',$t[0]['Job_ID']);
    		$where['Unit']=array('eq',$t[0]['Unit']);
			$has = Db::table('assess')->where($where)->select();

			foreach ($has as $key=>$arr) {
				$id[]=$arr['ID'];
			}
			$Assess_ID['Assess_ID']=array('in',$id);
			$list=Db::table('edu_cadre')->where($Assess_ID)->select();  
          
    }
      
}