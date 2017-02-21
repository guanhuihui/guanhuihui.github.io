<?php
return array(
	/* 数据库配置 */
  	'DB_TYPE'   => 'mysqli', // pdo mysqli
 	'DB_HOST'   => '192.168.1.253', // 服务器地址
  	'DB_NAME'   => 'case_hhj', // 数据库名
  	'DB_USER'   => 'case_hhj', // 用户名
  	'DB_PWD'    => 'hahajing@db', // 密码
  	'DB_PORT'   => '3306', // 端口
  	'DB_PREFIX' => 'hhj_', // 数据库表前缀

  // 	'DB_TYPE'   => 'mysqli', // pdo mysqli
 	// 'DB_HOST'   => '210.14.157.252', // 服务器地址
  // 	'DB_NAME'   => 'case_hhj', // 数据库名
  // 	'DB_USER'   => 'root', // 用户名
  // 	'DB_PWD'    => 'hahajing@2016!@#$%^', // 密码
  // 	'DB_PORT'   => '3306', // 端口
  // 	'DB_PREFIX' => 'hhj_', // 数据库表前缀


  	'DB_CONFIG1' => array(
    'db_type'  => 'mysqli',
    'db_user'  => 'root',
    'db_pwd'   => 'hahajing@2016!@#$%^',
    'db_host'  => '210.14.157.252',
    'db_port'  => '3306',
    'db_name'  => 'case_hhj',
    'db_prefix' => 'hhj_',
    ),

	// 'DB_TYPE'   => 'mysqli', // pdo mysqli
 // 	'DB_HOST'   => '192.168.0.200', // 服务器地址
 //  	'DB_NAME'   => 'case_hhj', // 数据库名
 //  	'DB_USER'   => 'root', // 用户名
 //  	'DB_PWD'    => 'root', // 密码
 //  	'DB_PORT'   => '3306', // 端口
 //  	'DB_PREFIX' => 'hhj_', // 数据库表前缀

  	'MODULE_ALLOW_LIST'=>array('Home','Rest_2'),
	'DEFAULT_MODULE' => 'Home',  // 默认模块

	//常用地址111
	'WWW_URL'	 => 'http://www.hahajing.com/',	
	'DOMAIN'     => '.hahajing.com',
	'HHJ_API_KEY' => 'rxhdu4iekro9333jdh6d', //对外接口校验KEY
	//上传图片URL路径
	'IMG_HTTP_URL' => 'http://hahajing.oss-cn-beijing.aliyuncs.com/userfiles/',
	//'IMG_WWW_URL' => 'http://192.168.0.200/userfiles/',
		
	//缓存前缀
	'CACHE_PREFIX' => 'file_',
		
	//极光推送JPush参数 用户
	'JPUSH_URL' => 'https://api.jpush.cn/v3/push',
	'JPUSH_IOS_APPKEY' => '567ac4363cbb31db26e67618',
	'JPUSH_IOS_MASTERSECRET' => 'c7449010d4416c2b8ec46584',		
	'JPUSH_ANDROID_APPKEY' => 'e78dcf0bcb7994f3b6c8a9ee',
	'JPUSH_ANDROID_MASTERSECRET' => '3bf43ad32fba6ec72d328d1e',	
	//极光推送JPush参数 商户
	'JPUSH_SHOP_APPKEY' => 'cad07cf1519feaf1df61504b',
	'JPUSH_SHOP_MASTERSECRET' => 'cae8604d13d213156e5a7bb9',
);