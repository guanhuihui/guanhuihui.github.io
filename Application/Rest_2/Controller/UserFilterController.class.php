<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/10/23
// +----------------------------------------------------------------------

namespace Rest_2\Controller;
use Think\Controller;

/**
 * 对外接口数据校验控制器（对外接口需要继承此类）
 */
class UserFilterController extends Controller {
	
	/* 必填字段 */
	protected $accept_encoding = '';//固定字符串:gzip
	protected $client_version = '';//客户端版本号码，当前全部使用0
	protected $lang = '';//客户端语言环境，取值为：CN或EN
	protected $os = '';//操作系统名称：取值为android或ios
	/* 非必填字段*/
	protected $token = '';//上次登录后者修改密码后返回的数据。
	protected $uid = '';//未登录用户传递为空，否则返回上次登录操作返回的编号。
	
	
	/**
	 * 控制器初始化
	 */
	public function _initialize(){		
		$this->checkHeader();
		$this->checkIP();
		//$this->checkVersion();
		$this->checkSign();		
	}
	
	/**
	 * 获取表头信息
	 * @return Ambigous <string, unknown>
	 */
	private function getHeaders(){
		$headers = '';
		foreach ($_SERVER as $name => $value){
			if(substr($name, 0, 5) == 'HTTP_'){
				$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
			}
		}
		return $headers;
	}
	
	/**
	 * 校验报头信息
	 */
	public function checkHeader(){
		//获取当前URL
		$url =  'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'];
		//获取报头信息
		$header = self::getHeaders();
		//echo var_dump($header);
		//获取传入accept_encoding
		if(empty($header['Accept-Encoding'])){

			return_error(10301, array("msg"=>C('ERR_CODE.10301')));
		}else{
			$this->accept_encoding = $header['Accept-Encoding'];
		}
	
		//获取传入的版本号
		if(empty($header['Client-Version'])){
			return_error(10302, array("msg"=>$header));
			return_error(10302, array("msg"=>C('ERR_CODE.10302')));
		}else{

			$this->client_version = $header['Client-Version'];
		}
	
		//获取传入的客户端语言环境
		if(empty($header['Lang'])){
			return_error(10303, array("msg"=>C('ERR_CODE.10303')));
		}else{
			$this->lang = $header['Lang'];
		}
	
		//获取传入的操作系统名称
		if(empty($header['Os'])){
			return_error(10304, array("msg"=>C('ERR_CODE.10304')));
		}else{
			$this->os = $header['Os'];
		}
	
		//获取传入的token
		$this->token = isset($header['Token']) ? $header['Token'] : '';
	
		//获取传入的uid
		$this->uid = isset($header['Uid']) ? $header['Uid'] : '';
	}
	    
	/**
	 * 校验IP(暂未开放)
	 */
	public function checkIP(){
		return true;
	}
	
	/**
	 * 版本检查(暂未开放)
	 */
	public function checkVersion(){		
		if($this->os == 'android'){			
			$version_number = $this->client_version; //版本号信息
			$version = explode(".", $version_number);
			$number = 0;
			if(count($version)==3){
				$number = $version[0]*100*100 + $version[1]*100 + $version[2];
			}
			
			if($number < 40100){
				return_error(10104, array("msg"=>'版本过低'.$this->client_version,'app_url'=>'http://api.hahajing.com/userfiles/app/new_hhj_4.1.0.apk'));
			}
// 		}else if($this->os == 'iOS'){
// 			$version_number = $this->client_version; //版本号信息
// 			$version = explode(".", $version_number);
// 			$number = 0;
// 			if(count($version)==3){
// 				$number = $version[0]*100*100 + $version[1]*100 + $version[2];
// 			}
				
// 			if($number < 70004){
// 				return_error(10104, array("msg"=>'版本过低'.$this->client_version,'app_url'=>'https://itunes.apple.com/cn/app/id645965568'));
// 			}
		}
		return true;
	}
	
	/**
	 * 校验Sign
	 */
	public function checkSign(){
		// 获取传入sign
		$sign_veryfy = I('post.sign','');
		//Log::write("sign_veryfy->".$sign_veryfy);
		$_sign = create_sign($_POST);
		//Log::write("_sign->".$_sign);
	
		if($_sign){
			// 对比sign字段
			if($sign_veryfy != $_sign){
				//sign验证失败，非法请求
				return_error(10305, array("msg"=>C('ERR_CODE.10305')));
			}
		}
	}
	
	/**
	 * 校验用户登陆状态
	 */
	public function checkLogin() {
		/*
		$key = C('CACHE_USER_TOKEN').'_'.$this->uid;
		$data = S($key);
		if($data){			
			if($data['user_id'] == $this->uid && $data['token'] == $this->token){
				return true;
			}else{
				//设备在其它设备上登陆
				return_error(10307, array("msg"=>str_replace("%", $data['equipment'], C('ERR_CODE.10307'))));
			}
		}
		
		//token校验失败
		return_error(10306, array("msg"=>C('ERR_CODE.10306'))); 
		*/
		return true;
	}
}