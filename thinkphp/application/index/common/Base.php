<?php
namespace app\index\common;

use think\Controller;
use think\Session;
use think\Db;
header("content-type:text/html;charset=utf-8");

class Base extends Controller{
	


    //验证登录，并获取评价信息
     public function islogin()
    {
   			$t=Session::get('name');
    		if(empty($t)){
    			 $this->redirect(url('Login/index'));
    		}
    		
    		//查询对应的评价主体ID
    		$where['Job_ID']=array('eq',$t[0]['Job_ID']);
    		$where['Unit']=array('eq',$t[0]['Unit']);
            //var_dump($where);
			$has = Db::table('assess')->where($where)->select();
            //var_dump($has);
			foreach ($has as $key=>$arr) {
				$id[]=$arr['ID'];
			}
			$Assess_ID['Assess_ID']=array('in',$id);
			$list=Db::table('edu_cadre')->where($Assess_ID)->select();  
            //var_dump($list);
          return $id;
    }



    //判断是否含有打分项
    public function doresult($result){
        $result=array_filter($result);
             if(empty($result)){
                $this->error('您在这里没有可以打分的选项');
                exit;
             }
             foreach ($result as $key => $value) {
                if(!empty($value)){
                    $jiaoxue=$value;
                }
             }
        return $jiaoxue;
    }
      
}