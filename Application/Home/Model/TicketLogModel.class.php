<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ZhaoBo at 2015/11/27
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 优惠券日志模型
 * 
 */

class TicketLogModel{
	
	/**
	 * 添加优惠券生成日志
	 * @param $data
	 * @return int
	 */
	public function add($data){
		if(empty($data)){
			return false;
		}
		
		$Ticket = M('TicketLog');
		$result = $Ticket->add($data);		
		return $result;
	}

	/**
	 * 查看活动下的优惠券发放日志
	 * @param $act_id 活动ID
	 * @return array
	 */
	
	public function getTicketLog($act_id){
		if(empty($act_id)){
			return false;
		}
		
		$Ticket = M('TicketLog');
		$map = array();
		$map['act_id'] = $act_id;
		$list = $Ticket->where($map)->select();
		return $list;
		
	}
	
	/**
	 * 删除日志详情
	 * @param $id 日志ID
	 * @return bool
	 */
	public function del($id){
		if(empty($id)){
			return false;
		}
		
		$Ticket = M('TicketLog');
		$map = array();
		$map['log_id'] = $id;
		$result = $Ticket->where($map)->delete();
		return $result;
	}
	
	
	/**
	 * 查看日志内容
	 * @param $id 日志ID
	 * @return bool
	 */
	public function getInfoById($id){
		if(empty($id)){
			return false;
		}
		
		$Ticket = M('TicketLog');
		$map = array();
		$map['log_id'] = $id;
		$info = $Ticket->where($map)->find();
		return $info;
	}
	

	
}