<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangpp at 2015/10/23
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 验证短信模型
 */
class MobileCheckModel{
	
	/** 
	 * 验证短信信息
	 */
	public function getInfoById($check_id){
		if(empty($check_id)){
			return false;
		}
	
		$Mobilecheck = M('Mobilecheck');
		$where['mobilecheck_id'] = $check_id;
		$data = $Mobilecheck->where($where)->find();
	
		return $data;
	}
	
	
	
	/**
	 * 添加验证短信信息
	 */
	public function add($mobilecheck_phone){
		
		if ($mobilecheck_phone){
			return false;
		}
		
		$mobilecheck_code = randcode(4,2);
		
		$MobileCheck = M('Mobilecheck');
		$MobileCheck->mobilecheck_phone = $mobilecheck_phone;
		$MobileCheck->mobilecheck_code = $mobilecheck_code;
		$MobileCheck->mobilecheck_time = time();
		$result = $MobileCheck->add();
		
		if ($result){
			return $mobilecheck_code;
		}
	
		return $result;
	}
	
	/**
	 * 删除验证短信
	 */
	public function del($check_id) {
		if (empty($check_id)) {
			return false;
		}
	
		$Mobilecheck = M('Mobilecheck');
		$where['mobilecheck_id'] = $check_id;
		$result = $Mobilecheck->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改验证短信信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['mobilecheck_id'])){
			$check_id = $data['mobilecheck_id'];
			unset($data['mobilecheck_id']);
	
			$Mobilecheck = M('Mobilecheck');
			$result = $Mobilecheck->where(" mobilecheck_id = %d ",$check_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询验证短信列表
	 */
	public function getList() {
		$Mobilecheck = M('Mobilecheck');
		$list = $Mobilecheck->select();
	
		return $list;
	}
	
	/**
	 * 校验码验证
	 * @param unknown $mobile 手机号
	 * @param unknown $code 校验码
	 */
	public function check($mobile, $code){
		if(empty($mobile) && empty($code)){
			return false;
		}
		
		$Mobilecheck = M('Mobilecheck');
		$map['mobilecheck_phone'] = $mobile;
		$map['mobilecheck_code'] = $code;
		$map['mobilecheck_time'] = array('gt', time() - C('MOBILE_VALID_TIME'));
		$data = $Mobilecheck->where($map)->order('mobilecheck_id desc')->find();
		
		return $data;
	}
	
}