<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhaobo at 2015/11/17
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 验证短信模型 
 */
class AuthCodeModel{
	
	/**
	 * 检测验证码的发送频率
	 */
	public function checkSendFrequency($mobile, $codetype){
		if(empty($mobile)){
			return false;
		}
		
		$AuthCode = M('AuthCode');
		$map = array();
		$map['mobile'] = $mobile;
		$map['auth_type'] = $codetype;
		$map['add_time'] = array('gt', time() - intval(C('SMS_INTERVAL_TIME')));
		$result = $AuthCode->where($map)->find();
		if($result){
			return false;
		}
		return true;
	}
	
	
	/**
	 * 添加校验信息
	 */	
	public function add($data){
		if(empty($data)){
			return false;
		}

		$AuthCode = M('AuthCode');
		$result = $AuthCode->add($data);
		return $result;
	}
	
	/**
	 * 生产校验码
	 * @param 用户手机号 $mobile
	 * @param 校验类型 $type
	 * @return $code
	 */
	public function addCode($mobile, $code, $type=1){
		if(empty($mobile) && empty($code)){
			return false;
		}
		
		$now = time(); //生成当前时间	
		
		$data = array();
		$data['auth_type'] = $type;
		$data['mobile'] = $mobile;
		$data['auth_code'] = $code;
		$data['add_time'] = $now;
		$data['disable_time'] = $now + intval(C('SMS_EXPIRE_TIME'));
		
		$result = $this->add($data);
		return $result;	
	} 
	
	/**
	 * 短信验证码校验
	 * @param 手机号 $mobile
	 * @param 校验码 $code
	 * @param 短信类型 $type
	 */
	public function checkCode($mobile, $code ,$type=1){
		if(empty($mobile) && empty($code)){
			return false;
		}
		
		$AuthCode = M('AuthCode');
		$map = array();
		$map['mobile'] = $mobile;		
		$map['auth_type'] = $type;
		$map['auth_code'] = $code;
		$map['disable_time'] = array('gt', time());
		$result = $AuthCode->where($map)->find();
		if($result){
			return true;
		}
		return false;	
	}
	
	/**
	 * 根据手机号获取验证码信息
	 */
	public function getInfoByMobile($mobile) {
		if(empty($mobile)){
			return false;
		}
	
		$map = array();
		$map['mobile'] = $mobile;
	
		$AuthCode = M('AuthCode');
		$data = $AuthCode->where($map)->order('add_time desc')->find();
	
		return $data;
	}
	
	
	/**
	 * 更新验证码时间
	 */
	public function updateTime($mobile){
		if(empty($mobile)){
			return false;
		}
	
		$map = array();
		$map['mobile'] = $mobile;
	
		$data = array();
		$data['add_time'] = time();
	
		$AuthCode = M('AuthCode');
		$codeinfo = $AuthCode->where($map)->order('add_time desc')->find();
	
		$arr = array();
		$arr['auth_id'] = $codeinfo['auth_id'];
		$data = $AuthCode->where($arr)->save($data);
	
		return $data;
	}
}