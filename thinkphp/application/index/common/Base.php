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
        //print_r($result);
             if(empty($result)){
                $this->error('您在这里没有可以打分的选项');
                
             }else{
             foreach ($result as $key => $value) {
                if(!empty($value)){
                    $jiaoxue=$value;
                }
             }
}
        return $jiaoxue;
    }



//数组分页
    public function fenye($c,$params){
        $pagecount=count($c);
        if(!array_key_exists('id', $params)){
          $pagenow=1;
          $pageid=1;
        }else{$pagenow=$params['pagenow'];
              $pageid=$params['id'];
            }
        if($pageid==1){
          $pagenow=1;
        }elseif($pageid==2){
          if($pagenow>1){
            $pagenow=$pagenow-1;
          }else{
            $pagenow=1;
          }
        }elseif($pageid==3){
          if($pagenow<$pagecount){
            $pagenow=$pagenow+1;
          }else{
            $pagenow=$pagecount;
          }
        }elseif($pageid==4){
          $pagenow=$pagecount;
        }
        if(array_key_exists('page', $params)){
          $pagenow=$params['page'];
        }
       //var_dump($pagenow);
        foreach ($c as $key => $value) {
          $d[]=$key;
          $f[]=$value;
        }
        $t=$pagenow-1;
        $unit=$d[$t];
        $man=$f[$t];
        //var_dump($man);
        $this->assign("unit", $unit);
        $this->assign("man", $man);

        $this->assign("pagecount", $pagecount);
        $this->assign("pagenow", $pagenow);
    }
      
}