<?php
namespace app\index\controller;
 
use think\Controller;
 
class Index extends Controller
{
    public function index()
    {
    	echo "您好： " . cookie('user_name') . ', <a href="' . url('login/loginout') . '">退出</a>';
      //return $this->fetch('login/register0');
    } 
  public function register0()
    {
    	//echo "您好： " . cookie('user_name') . ', <a href="' . url('login/loginout') . '">退出</a>';
      return $this->fetch('login/register0');
    }  
}