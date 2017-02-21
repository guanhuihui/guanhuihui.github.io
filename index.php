<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',true);
// 定义应用目录
define('APP_PATH','./Application/');

//接口地址
//define('API_URL','http://192.168.0.200');
//define('API_URL','http://www.hahajing.com');
//define('API_URL','http://192.168.0.200:9002');
//define('API_URL','http://localhost:9003');
define('API_URL','http://210.14.157.252/www');
//define('API_URL','http://test.hahajing.com');
define('IMG_URL','http://hahajing.oss-cn-beijing.aliyuncs.com/userfiles/');
//sign签名关键字
//define('HHJ_API_KEY','WEIXIN');
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';