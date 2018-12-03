<?php
namespace app\index\controller;
 
use think\Controller;
 
class Login extends Controller
{
    public function index()
    {
    	return $this->fetch();
    }   
  	    // 处理登录逻辑
    public function doLogin()
    {
      	if(isset($_POST['login'])){
            $param = input('post.');
            if(empty($param['user_name'])){	
                $this->error('用户名不能为空');
            }
            if(empty($param['user_pwd'])){	
                $this->error('密码不能为空');
            }
            // 验证用户名
            $has = db('users')->where('user_name', $param['user_name'])->find();
            if(empty($has)){
                $this->error('用户名密码错误');
            }
            // 验证密码
            if($has['user_pwd'] != md5($param['user_pwd'])){
                $this->error('用户名密码错误');
            }
            // 记录用户登录信息
            cookie('user_id', $has['id'], 3600);  // 一个小时有效期
            cookie('user_name', $has['user_name'], 3600);	
          
            $this->redirect(url('index/index'));
        }
      else if(isset($_POST['register'])){
        	$this->redirect(url('index/register0'));
      }
    }
	
  	    // 退出登录
    public function loginOut()
    {
    	cookie('user_id', null);
    	cookie('user_name', null);
    	
    	$this->redirect(url('login/index'));
    }
	
  	public function register()
    {
      //$this->fetch('login/register');
      //$this->display();
      if(isset($_POST['sub'])){
      	$user_name=$_POST['user_name'];
        $user_pwd1=$_POST['user_pwd1'];
         $user_pwd2=$_POST['user_pwd2'];
        if (empty($user_name) || empty($user_pwd1) || empty($user_pwd2)) {
          $this->error('用户名或者密码不能为空');
        }
        
        if ($user_pwd1 != $user_pwd2) {
          $this->error('两次输入的密码不一致');
        }
        $has = db('users')->where('user_name', $user_name)->find();
    	if(!empty($has)){
    		$this->error('用户名已存在');
    	}
        $data = ['user_name'=>$_POST['user_name'],'user_pwd'=>md5($_POST['user_pwd1'])];
        db('users')->insert($data);
        $this->success('注册成功', 'login/index');
        $this->redirect(url('login/index'));
      }
   }
}
