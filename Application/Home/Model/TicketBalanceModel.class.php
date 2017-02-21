<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangpp at 2015/11/19
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 优惠券返款模型 
 */
class TicketBalanceModel{
	
	/**
	 * 添加返款信息记录
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$TicketBalance = M('TicketBalance');
		$result = $TicketBalance->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 根据优惠券ID获得返款信息
	 * @param $ticket_id 优惠券id
	 * @return array
	 */
	public function getInfoByTicketId($ticket_id){
		if(empty($ticket_id)){
			return false;
		}
	
		$TicketBalance = M('TicketBalance');
		$map['ticket_id'] = $ticket_id;
		$data = $TicketBalance->where($map)->find();
		return $data;
	}
	
	/**
	 * 获取商户返款优惠券列表
	 * $shop_id 商户ID
	 * $status 获取状态1，当天；2，未结算3，已结算
	 * $page 页码
	 * $pagesize 每页记录数
	 */
	public function getShopTickeList($shop_id,$status=1,$page=1,$pagesize=20){
		
		$startrow = ($page - 1) * $pagesize;
		
		$TicketBalance = M('TicketBalance');
		
		$map['shop_id'] = $shop_id;
		
		if($status == 1){
			$starttime = strtotime(date('Y-m-d 00:00:00'));
			$endtime = time();
			$map['_string'] = "add_time>=$starttime and add_time <=$endtime";
		}elseif($status == 2){
			$map['status'] = 0;
		}elseif($status == 3){
			$map['status'] = 1;
		}
		
		$r = $TicketBalance->where($map)->limit($startrow, $pagesize)->order('add_time desc')->select();
		
		if($r){
			$rt = array();
			foreach($r as $key => $val){
				//或缺优惠券信息
				$where['ticket_id'] = $val['ticket_id'];
				$Ticket = M('Ticket');
				$data = $Ticket->where($where)->find();
				$rt[$key]['code'] = $data['ticket_code'];
				$rt[$key]['usetime'] = date('Y-m-d H:i:s',$data['use_time']);
				$rt[$key]['price'] = $val['ticket_discount'];
				
				//获取活动信息
				$Activity = M('Activity');
				$awhere['act_id'] = $val['act_id'];
				$activitys = $Activity->where($awhere)->find();
				$rt[$key]['activity'] = $activitys['act_name'];
				
			}
			return $rt;
		}
		
	}
	
	/**
	 * 交易信息
	 * $shopid 商户ID
	 */
	public function balanceInformation($shopid){
		
		//获取信息未结算
		$TicketBalance = M('TicketBalance');
		$map['status'] = 0;
		$map['shop_id'] = $shopid;
		$aftercount = $TicketBalance->where($map)->count();
		$aftersum = $TicketBalance->where($map)->sum('ticket_discount');
		
		//已结算
		$where['status'] = 1;
		$where ['shop_id'] = $shopid;
		$beforcount = $TicketBalance->where($where)->count();
		$beforsum = $TicketBalance->where($where)->sum('ticket_discount');
		
		if(empty($beforsum)){
			$beforsum = 0;
		}
		
		if(empty($aftersum)){
			$aftersum = 0;
		}
		$rt = array();
		$rt['not_balance_num'] = $aftercount;
		$rt['not_balance_money'] = $aftersum;
		
		$rt['balance_num'] = $beforcount;
		$rt['balance_money'] = $beforsum;
		return $rt;
	}

	
	
	/**
	 * 
	 * 获得商品返款列表信息
	 * @param $act_id 活动id 支持多个(12,15,18)
	 * @param $shop_id 商户id 支持多个(12,15,18)
	 * @param $is_back 返款状态    -1 全部 1未返款 2已返款 3.不返款
	 * @param $_start_time 开始时间 
	 * @param $_end_time 结束时间 
	 * @param $page 页码  
	 * @return array
	 */
	public function getShopTicketBackList($act_id, $shop_id, $is_back, $_start_time, $_end_time, $page){
		
		$TicketBalance = M('TicketBalance');
		
		$data = array();
		$map = array();
		if($act_id){
			$map['a.act_id'] = array('in', $act_id);
		}
		if($shop_id){
			$map['a.shop_id'] = array('in', $shop_id);
		}
		if($is_back == 1){
			$map['a.status'] = 0;
		}else if($is_back == 2){
			$map['a.status'] = 1;
		}else if($is_back == 3){
			$map['a.status'] = 3;
		}
		
		if($_start_time && empty($_end_time)){
			$map['a.add_time'] = array('gt',$_start_time);
		}
		
		if($_start_time && $_end_time){
			$map['a.add_time'] = array('between',array($_start_time,$_end_time));
		}
		
		$list = $TicketBalance->alias('a')
			    ->field('a.balance_id,COUNT(a.balance_id) as number,SUM(a.ticket_discount) as total_price,a.shop_id,b.shop_code,b.shop_name')
		        ->join('LEFT JOIN __SHOP__ b ON a.shop_id = b.shop_id ')
		        ->where($map)
		        ->page($page.',20')
		        ->group('a.shop_id')
		        ->order('b.shop_code')
		        ->select();
		$count = $TicketBalance->alias('a')
		        ->where($map)
		        ->group('shop_id')
		        ->select();
		$data['list'] = $list;
		$data['count'] = count($count);
		
		return $data;	
	}
	
	
	/**
	 *
	 * 获得商品返款列表信息
	 * @param $act_id 活动id 支持多个(12,15,18)
	 * @param $shop_id 商户id 支持多个(12,15,18)
	 * @param $_start_time 开始时间
	 * @param $_end_time 结束时间
	 * @return array
	 */
	public function getTicketBackNum($act_id, $shop_id, $_start_time, $_end_time){
	
		$TicketBalance = M('TicketBalance');
	
		$data = array();
		$map = array();
		if($act_id){
			$map['act_id'] = array('in', $act_id);
		}
		if($shop_id){
			$map['shop_id'] = array('in', $shop_id);
		}
	
		if($_start_time && empty($_end_time)){
			$map['add_time'] = array('gt',$_start_time);
		}
	
		if($_start_time && $_end_time){
			$map['add_time'] = array('between',array($_start_time,$_end_time));
		}
		
		//获取3种返款状态的统计单数和总金额
		/***未结款单数和金额****/
		$map['status'] = 0;
		$no_accounts = $TicketBalance
					 ->field('COUNT(balance_id) as number,SUM(ticket_discount) as total_price')
				     ->where($map)
				     ->find();
		
		if(empty($no_accounts['total_price'])){
			$no_accounts['total_price'] = 0;
		}
		
		/***已结款单数和金额****/
		$map['status'] = 1;
		$yes_accounts = $TicketBalance
					 ->field('COUNT(balance_id) as number,SUM(ticket_discount) as total_price')
					 ->where($map)
					 ->find();
		
		if(empty($yes_accounts['total_price'])){
			$yes_accounts['total_price'] = 0;
		}
		
		/***不结款单数和金额****/
		$map['status'] = 3;
		$_accounts = $TicketBalance
					 ->field('COUNT(balance_id) as number,SUM(ticket_discount) as total_price')
					 ->where($map)
					 ->find();
		if(empty($_accounts['total_price'])){
			$_accounts['total_price'] = 0;
		}
		
		$data['no_accounts'] = $no_accounts;
		$data['yes_accounts'] = $yes_accounts;
		$data['accounts'] = $_accounts;
		
	
		return $data;
	}
	
	
	

	
	/**
	 * 监控返款总数
	 */
	public function count($where){
		$TicketBalance = M('TicketBalance');
		$count = $TicketBalance->where($where)->count();
		return $count;
	}
	
	/**
	 *
	 * 获得商品返款列表信息
	 * @param $act_id 活动id 支持多个(12,15,18)
	 * @param $shop_id 商户id 
	 * @param $is_back 是否返款id 全部 -2 未返款-0  已返款-1 不返款-3
	 * @param $start_time 开始时间
	 * @param $end_time 结束时间
	 * @param $page 页码
	 * @return array
	 */
	public function getShopTicketdetail($act_id, $shop_id, $is_back, $start_time, $end_time, $page){
		if(empty($shop_id)){
			return false;
		}
		
		$data = array();
		$map = array();
		$map['shop_id'] = $shop_id;
		
		if($act_id){
			$map['act_id'] = array('in', $act_id);
		}
		if($is_back == 1){
			$map['status'] = 0;
		}else if($is_back == 2){
			$map['status'] = 1;
		}else if($is_back == 3){
			$map['status'] = 3;
		}
		if($start_time && empty($end_time)){
			$map['add_time'] = array('gt',$start_time);
		}
		
		if($start_time && $end_time){
			$map['add_time'] = array('between',array($start_time,$end_time));
		}
		$TicketBalance = M('TicketBalance');
		$list = $TicketBalance->where($map)->page($page.',15')->select();
		$count = $TicketBalance->where($map)->count();
		$data['list'] = $list;
		$data['count'] = $count;
		
		return $data;
	}
	
	
	/**
	 *
	 * 返款操作
	 * @param $shop_id 商户id
	 * @param $act_id 活动id 支持多个(12,15,18)
	 * @param $start_time 开始时间
	 * @param $end_time 结束时间
	 * @return array
	 */
	public function setTicketStatus($shop_id, $act_id, $start_time, $end_time){
		if(empty($shop_id)){
			return false;
		}
		
		$TicketBalance = M('TicketBalance');
		$data = array(); //更新的数据
		$map = array();  //条件
		$map['shop_id'] = $shop_id;
		$map['status'] = 0;
		
		if($act_id){
			$map['act_id'] = array('in', $act_id);
		}
	
		if($start_time && $end_time){
			$map['add_time'] = array('between',array($start_time,$end_time));
		}
		
		$data['status'] = 1;
		$result = $TicketBalance->where($map)->save($data);
		
		return $result;
		
	}
	
	
	/**
	 *
	 * 返款数据导出
	 * @param $shop_id 商户id  支持多个(12,15,18)
	 * @param $act_id 活动id 支持多个(12,15,18)
	 *  @param $is_back 是否返款id 全部 -2 未返款-0  已返款-1 不返款-3
	 * @param $start_time 开始时间
	 * @param $end_time 结束时间
	 * @return array
	 */
	public function getTicketOutList($act_id, $shop_id, $is_back, $start_time, $end_time){
	
		$TicketBalance = M('TicketBalance');
		
		$map = array();  //条件
		if($shop_id){
			$map['a.shop_id'] = array('in', $shop_id);
		}

		if($act_id){
			$map['a.act_id'] = array('in', $act_id);
		}
		
		if($is_back == 1){
			$map['a.status'] = 0;
		}else if($is_back == 2){
			$map['a.status'] = 1;
		}else if($is_back == 3){
			$map['a.status'] = 3;
		}
		
		if($start_time && empty($end_time)){
			$map['a.add_time'] = array('gt',$start_time);
		}
		
		if($start_time && $end_time){
			$map['a.add_time'] = array('between',array($start_time,$end_time));
		}
	
		$list = $TicketBalance->alias('a')
				->field('a.shop_id,b.shop_code,b.shop_name,b.shop_contacter,b.shop_contact,COUNT(a.balance_id) as number,SUM(a.ticket_discount) as price')
				->join('LEFT JOIN __SHOP__ b ON a.shop_id = b.shop_id')
				->where($map)
				->group('a.shop_id')
				->order('b.shop_code')
				->limit(10000)
				->select();//上限10000条数据
	
		return $list;
	
	}
	
	/**
	 * 每个城市兑换情况
	 */
	public function cityBalance($map){
		$TicketBalance = M('TicketBalance');
		$list = $TicketBalance->alias('a')
				->field('COUNT(a.balance_id) as number,a.shop_id,b.shop_name')
				->join('LEFT JOIN __SHOP__ b ON a.shop_id = b.shop_id ')
				->where($map)
				->group('a.shop_id')
				->order('b.shop_code')
				->select();
		return $list;
	}
}