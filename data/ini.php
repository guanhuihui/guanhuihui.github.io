<?php 


$db_host = '127.0.0.1';
$db_name = 'case_hhj';
$db_user = 'root';
$db_password = '';

//1链接数据库
$link = mysqli_connect($db_host,$db_user,$db_password,'','3306') or die('mysqli connect error 111');
// var_dump($link);
mysqli_query($link,'SET NAMES UTF8');
mysqli_select_db($link,$db_name) or die('mysqli connect error 222');





