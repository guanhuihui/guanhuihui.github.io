<?php 

include_once 'ini.php';

//接收前端数据
$_GET['user_name'] ? $user_name = $_GET['user_name'] : '';
$_GET['pass_word'] ? $pass_word = $_GET['pass_word'] : '';

//数据验证
if(empty($user_name)) return array('code'=>'001','msg'=>'用户名不能为空');
if(empty($pass_word)) return array('code'=>'002','msg'=>'密码不能为空');

//数据检索
$sql = "SELECT * FROM hhj_user WHERE user_account = $user_name";
$user_info = mysqli_query($sql);

if(empty($pass_word)) return array('code'=>'003','msg'=>'用户名不存在');

//密码加密  设置自己的加密规则  在这只用md5()函数

$pass_word = md5($pass_word);

if($user_info && $user_info['pass_word'] == $pass_word){
	return array('code'=>'0','msg'=>'登录成功! hello word!!!');
}else{
	return array('code'=>'004','msg'=>'密码错误,请重新输入');
}

