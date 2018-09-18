<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Session;

class Login extends Controller
{
    public function index()
    {
        return $this->fetch();
        
    }

       // 处理登录逻辑
    public function doLogin()
    {
        $param =input('post.');
        if(empty($param['account'])){
            
            $this->error('用户名不能为空');
        }
        
        if(empty($param['pwd'])){
            
            $this->error('密码不能为空');
        }
    

      
            // 验证用户名
      $has = Db::table('user')->where('Use_data',$param['account'])->select();
       if(empty($has)){
            
           $this->error('用户名密码错误');
       }

        //验证密码
        if($has['0']['Password'] != $param['pwd']){
            
            $this->error('用户名密码错误');
       }
        //var_dump($has);
        // 记录用户登录信息
       /* cookie('user_id', $has['id'], 3600);  // 一个小时有效期
        cookie('user_name', $has['user_name'], 3600);
       */ 
        Session::set('name',$has);  
        Session::has('name','index/index');
      
       $this->redirect(url('index/index'));
    }


      public function xiugai()
        {
            return $this->fetch();
            
        }
      public function xiugaiact()
        {
           
           $param =input('post.');
            if(empty($param['account'])){
                
               $this->error('用户名不能为空');
            }
            if(empty($param['new'])){
                
                $this->error('密码不能为空');
            }

            if($param['new']!=$param['newed']){
              $this->error('两次密码不正确');
            }
            
            if(empty($param['old'])){
                
                $this->error('密码不能为空');
            }
         
          
                // 验证用户名
          $has = Db::table('user')->where('Use_data',$param['account'])->select();
           if(empty($has)){
                
               $this->error('用户名密码错误');
           }

            //验证密码
            if($has['0']['Password'] != $param['old']){
                
                $this->error('用户名密码错误');
           } 


          Db::table('user')->where('Use_data',$param['account'])->update(['Password'=>$param['new']]);

           $this->redirect(url('index/index'));
    }
    
}
    ?>