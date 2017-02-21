<?php

/**
 * url跳转（原生态）
 */
function jump($url){
	header('Location: '.$url);
	exit;
}



/**
 * 错误结果格式化
 */
function json_error($code, $data, $sign=false, $isexit=true){
	$return = array();
	$return['code'] = $code;
	$return['result'] = 'error';
	$return['time'] = time();
	if(is_array($data) && count($data)==0){
		$return['data'] = null;
	}else{
		$return['data'] = $data;
	}	

	if($sign && is_array($data)){
		$return['sign'] = create_sign($data);
	}

	if($isexit){
		echo json_encode($return);
		exit;
	}else{
		return $return;
	}
}

function return_error($code, $data){
	return json_error($code, $data, false, true);
}


/**
 * 正确结果格式化
 */
function json_success($data, $sign=false, $isexit=true){
	$return = array();
	$return['code'] = 0;
	$return['result'] = 'ok';
	$return['time'] = time();
	if(is_array($data) && count($data)==0){
		$return['data'] = null;
	}else{
		$return['data'] = $data;
	}
	
	if($sign && is_array($data)){
		$return['sign'] = create_sign($data);
	}	

	if($isexit){
		echo json_encode($return);
		exit;
	}else{
		return $return;
	}
}

function return_success($data){
	return json_success($data, false, true);
}

/**
 * 检测手机号
 */
function is_mobile($mobile){
	if(preg_match("/^1[0-9]{10}$/", $mobile)){
		return true;
	}else{
		return false;
	}
}

/**
 * 密码加密
 */
function pwd_encode($pwd){
	$pwd .= rand(100, 999);
	$pwd = strrev($pwd);
	$pwd = base64_encode($pwd);
	$pwd = strrev($pwd);
	$pwd = base64_encode($pwd);
	$pwd = strrev($pwd);
	$pwd = base64_encode($pwd);
	return $pwd;
}

/**
 * 密码解密
 */
function pwd_decode($pwd){
	$pwd = base64_decode($pwd);
	$pwd = strrev($pwd);
	$pwd = base64_decode($pwd);
	$pwd = strrev($pwd);
	$pwd = base64_decode($pwd);
	$pwd = strrev($pwd);
	$pwd = substr($pwd, 0, -3);
	return $pwd;
}

/**
 * 获取来源id
 */
function get_source_id($os){
	$source_id = 2;//默认安卓
	
	if($os){		
		if(strtolower($os) == 'android'){
			$source_id = 2;
		}		
		if(strtolower($os) == 'ios'){
			$source_id = 3;
		}
	}

	return $source_id;
}

function guid(){
	$uuid = '';
	if (function_exists('com_create_guid')){
		$uuid = com_create_guid();
	}else{
		mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
		$charid = strtoupper(md5(uniqid(rand(), true)));
		$hyphen = chr(45);// "-"
		$uuid = chr(123)// "{"
		.substr($charid, 0, 8).$hyphen
		.substr($charid, 8, 4).$hyphen
		.substr($charid,12, 4).$hyphen
		.substr($charid,16, 4).$hyphen
		.substr($charid,20,12)
		.chr(125);// "}"
	}

	$uuid = str_replace('-','',$uuid);
	$uuid = str_replace('{','',$uuid);
	$uuid = str_replace('}','',$uuid);
	return $uuid;
}

function randcode($len, $mode = 2){
	$rcode = '';

	switch($mode){
		case 1: //去除0、o、O、l等易混淆字符
			$chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghijkmnpqrstuvwxyz';
			break;
		case 2: //纯数字
			$chars = '0123456789';
			break;
		case 3: //全数字+大小写字母
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
			break;
		case 4: //全数字+大小写字母+一些特殊字符
			$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz~!@#$%^&*()';
			break;
	}

	$count = strlen($chars) - 1;
	mt_srand((double)microtime() * 1000000);
	for($i = 0; $i < $len; $i++) {
		$rcode .= $chars[mt_rand(0, $count)];
	}

	return $rcode;
}

//发送手机短信
function send_sms($mobile, $content){
	if(empty($mobile) || empty($content)){
		return false;
	}
	$WIIMSGSNURL = 'http://sdk999ws.eucp.b2m.cn:8080/sdk/SDKService?wsdl';
	$WIIMSGSN    = '9SDK-EMY-0999-JCRPT';
	$WIIMSGPASS  = '221380';
	$WIIMSGSK    = '126386';

	$client = new SoapClient($WIIMSGSNURL, array('trace' => true, 'exceptions' => true));
	$params = array(
			'arg0' => $WIIMSGSN,
			'arg1' => $WIIMSGSK,
			'arg2' => '',
			'arg3' => array($mobile),
			'arg4' => '【哈哈镜】'.$content,
			'arg5' => '',
			'arg6' => 'GBK',
			'arg7' => 5,
			'arg8' => 8888
	);
	$rt = $client->__soapCall("sendSMS",array('parameters'=>$params));
	if($rt->return==0){
		return true;
	}else{
		return false;
	}
}

/**
 * 接口分页参数page处理
 *
 * @param mixed $pagecount 页数
 * @return
 */
function getPageByApi($page,$pagecount){
	$page = empty($page) ? 1 : trim($page);
	if(!is_numeric($page)) $page = 1;
	if($page < 1) $page = 1;
	if(empty($pagecount))
		$page = 1;

	return $page;
}

//当前非标准时区的问题，所以先获得当前时区的开始时间
function get_passtime_str($time){
	$starttime = strtotime('January 1 1970 00:00:00');
	return date('H:i', $time+$starttime);
}

/**
 * 根据id获取哈哈镜自有产品口味
 */
function get_goods_pungent($pungent_id){
	$goods_pungent_array = C('GOODS_PUNGENT');
	$pungent_name = $goods_pungent_array[$pungent_id];
	if(empty($pungent_name)){
		$pungent_name = '';
	}
	
	return $pungent_name;	
}

/**
 * 获取订单编号
 */
function get_order_no($source){
	$code = get_source_id($source);
	//日期时间串 12位
	$timestr = date('ymdHis');
	$code .= $timestr;
	//随机数 3位
	$rcode = randcode(3);
	$code .= $rcode;
	//校验位：来源和随机数每一位相加的和的个位 1位
	$checksum = substr(get_str_sum($source.$rcode), -1, 1);
	$code .= $checksum;
	return $code;
}


/**
 * getStrSum() 获得数字串每一位相加的和
 */
function get_str_sum($numstr){
	$sum = 0;
	for($i = 0;$i<strlen($numstr); $i++){
		$sum += intval($numstr[$i]);
	}
	return $sum;
}

/**
 * HTMLDecode()将HTMLEncode的数据还原
 *
 * @param mixed $str
 * @return
 */
Function HTMLDecode($str){
	if (!empty($str)){
		$str = str_replace("&amp;","&",$str);
		$str = str_replace("&gt;",">",$str);
		$str = str_replace("&lt;","<",$str);
		$str = str_replace("&nbsp;",CHR(32),$str);
		$str = str_replace("&nbsp;&nbsp;&nbsp;&nbsp;",CHR(9),$str);
		$str = str_replace("&#160;&#160;&#160;&#160;",CHR(9),$str);
		$str = str_replace("&quot;",CHR(34),$str);
		$str = str_replace("&#39;",CHR(39),$str);
		$str = str_replace("",CHR(13),$str);
		$str = str_replace("<br/>",CHR(10),$str);
		$str = str_replace("<br>",CHR(10),$str);
	}
	return $str;
}


/**
 * n2c()将单个阿拉伯数字转换成大写
 *
 * @param mixed $str
 * @return
 */

function n2c($x) //单个数字变汉字
{
	$arr_n = array("零","一","二","三","四","五","六","七","八","九","十");
	return $arr_n[$x];
}

//----------------------常用业务逻辑方法 begin----------------------------------

/**
 * 获取有用活动
 */
function filter_activity($activity_list, $province_id, $city_id){
	$list = array();
	
	if($activity_list){
		foreach($activity_list as $v){
			$ext = json_decode($v['range_ext']);
			if($ext){
				//检测省份类型
				if($v['range_type'] == 1){//全国
					$list[] = $v;
				}else if($v['range_type'] == 2 && in_array($province_id,$ext)){
					$list[] = $v;
				}else if($v['range_type'] == 3 && in_array($city_id,$ext)){
					$list[] = $v;
				}
			}
		}
	}
	
	return $list;
}

//----------------------常用业务逻辑方法 end------------------------------------


