<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ZhaoBo at 2016/01/06
// +----------------------------------------------------------------------

namespace  Home\Model;

/***
 * 领取优惠券用户信息记录模型
 */

class TicketDrawModel{
	
	/***
	 * 获取未领取优惠券的用户列表信息
	 * 
	 */
	public function getUserList($num=1000){
		$map = array();
		$map['is_draw'] = 0;
		
		$TicketDraw = M('TicketDraw');
		$list = $TicketDraw->where($map)->limit($num)->select();
		return $list;
	}
	
	
	/***
	 * 更新成功领取优惠券的状态
	 *
	 */
	public function edit($id){
		if(empty($id)){
			return false;
		}
		
		$map = array();
		$map['id'] = $id;
		
		$data = array();
		$data['is_draw'] = 1;
		
		$TicketDraw = M('TicketDraw');
		$result = $TicketDraw->where($map)->save($data);
		return $result;
	}
	
	

	/***
	 *添加记录 
	 *
	 */
	public function add($data){
		if(empty($data)){
			return false;
		}
		
		$TicketDraw = M('TicketDraw');
		$result = $TicketDraw->add($data);
		return $result;
	}
		
}