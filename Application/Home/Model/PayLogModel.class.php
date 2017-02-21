<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2016/03/01
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 支付日志模型
 */
class PayLogModel{
	
	/** 
	 * 日志信息
	 */
	public function getInfoById($log_id){
		if(empty($log_id)){
			return false;
		}
	
		$PayLog = M('PayLog');
		$where['pay_id'] = $log_id;
		$data = $PayLog->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加日志信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$PayLog = M('PayLog');
		$result = $PayLog->data($data)->add();
	
		return $result;
	}
	
}