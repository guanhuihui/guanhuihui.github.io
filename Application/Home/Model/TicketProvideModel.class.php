<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ZhaoBo at 2015/11/19
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 优惠券发放记录模块儿
 *
 */

class TicketProvideModel{
	
	/**
	 * 获取用户领取券信息
	 */
	public function getInfoByWhere($where){
		if(empty($where)){
			return false;
		}
		
		$TicketProvide = M('TicketProvide');
		$result = $TicketProvide->where($where)->find();
		return $result;
	}
	
	/**
	 * 添加发券记录
	 */
	public function add($data){
		if(empty($data)){
			return false;
		}
		
		$TicketProvide = M('TicketProvide');
		$result = $TicketProvide->add($data);
		return $result;
	}
	
	/**
	 * 更新发券记录
	 */
	public function save($where, $data){
		if(empty($where) && empty($data)){
			return false;
		}
		
		$TicketProvide = M('TicketProvide');
		$result = $TicketProvide->where($where)->save($data);
		return $result;
		
	}
	
	
	
}