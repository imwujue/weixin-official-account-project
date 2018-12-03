<?php
namespace app\api\model;

use think\Model;
use think\Db;

class Weather extends Model{
	public function getWeatherInfo($code = 101010100)
    {
      	$res = Db::name('weather')->where('code',$code)->value('val');
      	return $res;
    }
  
  	public function getWeatherInfoList()
    {
      	$res = Db::name('weather')->select();
      	return $res;
    }
}