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
 * 用户优惠券模型
 * 
 */

class TicketModel{
	
	/**
	 * 根据code获取优惠券信息
	 * @param 优惠券code $ticket_code
	 * @return array
	 */
	public function getInfoByCode($ticket_code){
		if(empty($ticket_code)){
			return false;
		}
		
		$Ticket = M('Ticket');
		$map['ticket_code'] = $ticket_code;
		$data = $Ticket->where($map)->find();		
		return $data;
	} 
	
	/**
	 * 根据code检测优惠券唯一行
	 * @param 优惠券code $code
	 * @return array
	 */
	public function isOnly($code){
		if(empty($code)){
			return false;
		}
	
		$Ticket = M('Ticket');
		$map['ticket_code'] = $code;
		$data = $Ticket->where($map)->field('ticket_code')->find();
		return $data;
	}
	
	/**
	 * 根据ID检测优惠券唯一行
	 * @param 优惠券ID $ticket_id
	 * @return array
	 */
	public function getInfoById($ticket_id){
		if(empty($ticket_id)){
			return false;
		}
	
		$Ticket = M('Ticket');
		$map['ticket_id'] = $ticket_id;
		$data = $Ticket->where($map)->find();
		return $data;
	}
	
	/**
	 * 修改优惠券信息
	 */
	public function edit($where, $data){
		if(empty($where) && empty($data)){
			return false;
		}
	
		$Ticket = M('Ticket');
		$result = $Ticket->where($where)->data($data)->save();
		return $result;
	}
	
	
	/**
	 * 生成优惠券信息
	 */
	public function add($data){
		if(empty($data)){
			return false;
		}
	
		$Ticket = M('Ticket');
		$result = $Ticket->add($data);
		return $result;
	}
	
	/**
	 * 查询优惠券列表
	 * @param 用户id $user_id
	 * @param number $status
	 * @return unknown
	 */
	public function getUsableList($user_id, $act_type=2){
		$map = array();
		$map['a.user_id'] = $user_id;
		if($act_type){
			$map['b.act_type'] = $act_type;
		}else{
			$map['b.act_type'] = array('exp'," IN (2,3) ");
		}
		$map['a.status'] = 0;
		$map['b.status'] = 1;

		$Ticket = M('Ticket');
		$data = $Ticket->alias('a')
		               ->field('a.*,b.act_name,b.notes,b.act_desc,b.goods_ext,b.goods_type,b.range_type,b.range_ext,b.status as act_status')
		               ->join('LEFT JOIN __ACTIVITY__ b ON a.act_id = b.act_id ')
		               ->order('a.ticket_id desc ')
		               ->where($map)
		               ->select();
		return $data;
	}
	
	/**
	 * 获取活动优惠券详情列表
	 */
	public function getCouponList($page){
	
		$Ticket = M('Ticket'); 
		$data = array();
		$list = $Ticket->alias('a')
				  ->field('a.*,b.act_name')
				  ->join('LEFT JOIN __ACTIVITY__ b ON a.act_id = b.act_id' )
				  ->group('a.act_id')
				  ->page($page.',15')
				  ->select();
		$_list = $Ticket->alias('a')
				  ->group('a.act_id')
				  ->select();
		$data['list'] = $list;
		$data['count'] = count($_list);
		return $data;
	}
	
	/**
	 * 获取活动优惠券的总数
	 * $where 搜索条件  可以为空
	 */
	public function getCount($where = 0){
	
		$Ticket = M('Ticket');
		if($where){
			$result = $Ticket->where($where)->count();
		}else{
			$result = $Ticket->count();
		}
		return $result;
	}
	
	/**
	 * 优惠券绑定
	 * @param 优惠券code $ticket_code
	 */
	public function binding($ticket_code, $user_id){
		$result = false;
		
		$ticket_data = $this->getInfoByCode($ticket_code);
		if($ticket_data){
			$Activity = D('Home/Activity');
			$activity_data = $Activity->getInfoById($ticket_data['act_id']);
			if($activity_data){
				$status = $this->getStatus($activity_data['status'], $activity_data['begin_time'], $activity_data['end_time'], 
						                   $ticket_data['status'], $ticket_data['begin_time'], $ticket_data['end_time']);
				
				//优惠券未使用过
				if($status === '0'){
					$map = array();
					$map['user_id'] = 0;
					$map['status'] = 0;
					$map['ticket_id'] = $ticket_data['ticket_id'];
					
					$data = array();
					$data['user_id'] = $user_id;
					$data['add_time'] = time();
					
					$res = $this->edit($map, $data);
					if($res){
						$result = true;
					}					
				}
			}
		}
		
		return $result;
	}
	
	/**
	 * 获取用户优惠券（最近一个月内）
	 * @param 用户id $user_id
	 * @return boolean
	 */
	public function getList($user_id){
		if(empty($user_id)){
			return false;
		}
		
		$time = time()-60*24*60*60;//格式化当前时间(一个月前)
		
		$Ticket = M('Ticket');
		$where = "hhj_ticket.user_id=%d AND hhj_ticket.add_time > %d";
		$list = $Ticket->field('hhj_activity.act_id,hhj_activity.act_name,hhj_activity.act_desc,hhj_activity.notes,hhj_activity.status as act_status,hhj_activity.begin_time as act_begin_time,hhj_activity.end_time as act_end_time,hhj_ticket.*')
						   ->join('__ACTIVITY__ ON __TICKET__.act_id = __ACTIVITY__.act_id','LEFT')
		                   ->where($where, $user_id, $time)
		                   ->order('hhj_ticket.status asc,hhj_ticket.add_time desc')
		                   ->select();
		return $list;
	}
	
	/**
	 * 获取优惠券状态
	 * @param 活动状态 $act_status
	 * @param 活动开始时间 $act_begin_time
	 * @param 活动结束时间 $act_end_time
	 * @param 优惠券状态 $ticket_status
	 * @param 优惠券开始时间 $ticket_begin_time
	 * @param 优惠券结束时间 $ticket_end_time
	 * @return 优惠券状态 0未使用 1使用中 2已使用 3已作废 
	 */
	public function getStatus($act_status, $act_begin_time, $act_end_time, $ticket_status, $ticket_begin_time, $ticket_end_time){
		if(empty($act_status) && empty($act_begin_time) && empty($act_end_time) && empty($ticket_status) && empty($ticket_begin_time) && empty($ticket_end_time)){
			return 3;
		}
		$status = 3;
		//活动状态 0关闭 1开启
		if($act_status){
			$now = time();
			$act_time1 = strtotime($act_begin_time);
			$act_time2 = strtotime($act_end_time);
			//活动失效期内
			if($act_time1 < $now && $act_time2 > $now){ 
				$ticket_time1 = strtotime($ticket_begin_time);
				$ticket_time2 = strtotime($ticket_end_time);
				//优惠券失效期内
				if($ticket_time1 < $now && $ticket_time2 > $now){
					$status = $ticket_status;
				}				
			}
		}
		
		return $status;
	}
	
	/**
	 * 获取优惠券状态
	 * @param 活动状态 $where
	 * @return 优惠券信息
	 */
	public function getTicketListByWhere($where){
		if(empty($where)){
			return false;
		}
		
		$Ticket = M('Ticket');
		$result = $Ticket->where($where)->find();
		return $result;
	}
	
	/**
	 * 获取优惠券列表信息(根据活动ID)
	 * @param 活动Id act_id
	 * @return list
	 */
	public function getTicketList($act_id, $user_id, $code, $type, $page){
		if(empty($act_id)){
			return false;
		}
		
		$Ticket = M('Ticket');
			
		$data = array();
		
		$map = array();//条件
		$map['a.act_id'] = $act_id;
		if($type == 1){//状态转换
			$map['a.status'] = 0;
		}else if($type == 2){
			$map['a.status'] = 1;
		}else if($type == 3){
			$map['a.status'] = 2;
		}else if($type == 4){
			$map['a.status'] = 3;
		}
		
		if($user_id){
			$map['a.user_id'] = $user_id;
		}
		
		if($code){
			$map['a.ticket_code'] = $code;
		}
		
		$list = $Ticket->alias('a')
				->field('a.*,b.balance_id,b.shop_id,b.add_time as return_time,c.user_account')
				->join('LEFT JOIN __TICKET_BALANCE__ b ON a.ticket_id = b.ticket_id')
				->join('LEFT JOIN __USER__ c ON a.user_id = c.user_id')
				->where($map)
				->page($page.',25')
				->select();
		$count = $Ticket->alias('a')
				->where($map, $act_id)
				->count();
		$data['list'] = $list; //数据信息
		$data['count'] = $count; //总数
		
		return $data;
		
	}
	
	
	/**
	 * 根据不同条件获取优惠券信息
	 * @param 条件信息 $where
	 * @return array
	 */
	public function getInfoByWhere($where){
		if(empty($where)){
			return false;
		}
	
		$Ticket = M('Ticket');
		$data = $Ticket->where($where)->find();
		return $data;
	}
	
	
	/**
	 * 获取优惠券信息
	 * @param 用户id $ticket_id
	 * @return boolean
	 */
	public function getInfo($ticket_id){
		if(empty($ticket_id)){
			return false;
		}
	
		$Ticket = M('Ticket');
		$map = array();
		$map['ticket_id'] = $ticket_id;
		$info = $Ticket->field('hhj_activity.act_id,hhj_activity.act_name,hhj_activity.act_desc,hhj_activity.notes,hhj_activity.status as act_status,hhj_activity.begin_time as act_begin_time,hhj_activity.end_time as act_end_time,hhj_ticket.*')
		->join('__ACTIVITY__ ON __TICKET__.act_id = __ACTIVITY__.act_id','LEFT')
		->where($map)
		->order('hhj_ticket.status asc,hhj_ticket.add_time desc')
		->find();
		return $info;
	}
	
	
}