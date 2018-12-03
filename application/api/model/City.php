<?php
namespace app\api\model;

use think\Model;
use think\Db;

class City extends Model
{
  	public function getCitycode($name='北京')
    {
      	$res = Db::name('weather')->where('name',$name)->value('code');
      	return $res;
    }
  
  	public function getCitycodeList()
    {
      	$res = Db::name('weather')->select();
      	return $res;
    }
}