<?php
namespace app\index\controller;

use app\index\common\Base;
use think\Controller;
use think\Session;
use think\Db;
header("content-type:text/html;charset=utf-8");
class Index extends Base
{
    
    public function index()
    {
    		
    		$this->islogin();
        	return $this ->  fetch();
        
    }
     


     /************
        教学单位处级干部
       ******/
     public function one(){

     	$t=Session::get('name');
            if(empty($t)){
                 $this->redirect(url('Login/index'));
            }
            $where['Job_ID']=array('eq',$t[0]['Job_ID']);
            $where['Unit']=array('eq',$t[0]['Unit']);
            $has = Db::table('assess')->where($where)->select();

            foreach ($has as $key=>$arr) {
                $id[]=$arr['ID'];
            }
            $Assess_ID['Assess_ID']=array('in',$id);
            $list=Db::table('edu_cadre')->where($Assess_ID)->select();
		//var_dump($Assess_ID);
//var_dump($id);
//多个身份合成一个数组
			
for($i=0;$i<count($id);$i++){
		$result[] = Db::query("select * from edu_cadre left join user on edu_cadre.Unit=user.Unit and edu_cadre.Job_ID=user.Job_ID left join project on edu_cadre.Project=project.ID left join unit on edu_cadre.Unit=unit.Unit_ID where edu_cadre.Assess_ID='$id[$i]'");
     }
    
     foreach ($result as $key => $value) {
        if(!empty($value)){
            $jiaoxue=$value;
        }
     }
     foreach ($jiaoxue as $a => $b) {
       $c[$b['Unit_Name']][$b['Name']]['Project'][$b['Project']]=$b['ID'];
       $c[$b['Unit_Name']][$b['Name']]['Use_ID']=$b['Use_ID'];
     }
// var_dump($c);
     $this->assign("c", $c); 
     $this->assign("jiaoxue", $jiaoxue);    
     return $this ->  fetch();
        
     }
       

       /************
       教学单位领导班子
       ******/
     public function two(){
     	$t=Session::get('name');
    		if(empty($t)){
    			 $this->redirect(url('Login/index'));
    		}
    		$where['Job_ID']=array('eq',$t[0]['Job_ID']);
    		$where['Unit']=array('eq',$t[0]['Unit']);
			$has = Db::table('assess')->where($where)->select();

			foreach ($has as $key=>$arr) {
				$id[]=$arr['ID'];
			}
			$Assess_ID['Assess_ID']=array('in',$id);
			$list=Db::table('edu_cadre')->where($Assess_ID)->select();
		
			for($i=0;$i<count($id);$i++){
            $result[] = Db::query("select * from edu_unit left join unit on edu_unit.Unit=unit.Unit_ID left join project on edu_unit.Project=project.ID where edu_unit.Assess_ID='$id[$i]'");
     }

             foreach ($result as $key => $value) {
                if(!empty($value)){
                    $jiaoxue=$value;
                }
             }
                 $this->assign("jiaoxue", $jiaoxue);    
                 return $this ->  fetch();
     }




  /************
      非教学单位领导干部
       ******/
     public function three(){
        $t=Session::get('name');
            if(empty($t)){
                 $this->redirect(url('Login/index'));
            }
            $where['Job_ID']=array('eq',$t[0]['Job_ID']);
            $where['Unit']=array('eq',$t[0]['Unit']);
            $has = Db::table('assess')->where($where)->select();

            foreach ($has as $key=>$arr) {
                $id[]=$arr['ID'];
            }
            $Assess_ID['Assess_ID']=array('in',$id);
            $list=Db::table('edu_cadre')->where($Assess_ID)->select();
        
            for($i=0;$i<count($id);$i++){
            $result[] = Db::query("select * from unedu_cadre left join user on unedu_cadre.Unit=user.Unit and unedu_cadre.Job_ID=user.Job_ID left join project on unedu_cadre.Project=project.ID left join unit on unedu_cadre.Unit=unit.Unit_ID where unedu_cadre.Assess_ID='$id[$i]'");
     }
             foreach ($result as $key => $value) {
                if(!empty($value)){
                    $jiaoxue=$value;
                }
             }
             foreach ($jiaoxue as $a => $b) {

              $c[$b['Unit_Name']][$b['Name']]['Project'][$b['Project']]=$b['ID'];
            $c[$b['Unit_Name']][$b['Name']]['Use_ID']=$b['Use_ID'];
        
     }

                 $this->assign("c", $c); 
                 $this->assign("jiaoxue", $jiaoxue);    
                 return $this ->  fetch();
     }



       /************
       非教学单位领导班子
       ******/
     public function four(){
        $t=Session::get('name');
            if(empty($t)){
                 $this->redirect(url('Login/index'));
            }
            $where['Job_ID']=array('eq',$t[0]['Job_ID']);
            $where['Unit']=array('eq',$t[0]['Unit']);
            $has = Db::table('assess')->where($where)->select();

            foreach ($has as $key=>$arr) {
                $id[]=$arr['ID'];
            }
            $Assess_ID['Assess_ID']=array('in',$id);
            $list=Db::table('edu_cadre')->where($Assess_ID)->select();
        
            for($i=0;$i<count($id);$i++){
            $result[] = Db::query("select * from unedu_unit left join unit on unedu_unit.Unit=unit.Unit_ID left join project on unedu_unit.Project=project.ID where unedu_unit.Assess_ID='$id[$i]'");
     }
             foreach ($result as $key => $value) {
                if(!empty($value)){
                    $jiaoxue=$value;
                }
             }
                 $this->assign("jiaoxue", $jiaoxue);    
                 return $this ->  fetch();
     }

     /*********退出
        

     **************/
    public function quit()
    {
    	
	    	//session_unset('name');
			//session_destroy();
			Session::clear();
			//删除用于自动登录的COOKIE
			@setcookie('auto', '', time() - 3600, '/');

			//跳转致登录页
			$this->redirect(url('index/index'));
        	//return $this->fetch();
        
    }


    }
