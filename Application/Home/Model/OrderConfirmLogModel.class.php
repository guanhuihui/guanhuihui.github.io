<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/11/27
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 在线支付订单确认订单记录
 */
class OrderConfirmLogModel{	
	/**
	 * 添加订单确认记录
	 */
	public function add_data($data){
		if (empty($data)) {
			return false;
		}
	
		$OrderConfirmLog = M('OrderConfirmLog');
		$result = $OrderConfirmLog->data($data)->add();
		return $result;
	}

	public function edit($where,$data){
		if (empty($data)) {
			return false;
		}
		$OrderConfirmLog = M('OrderConfirmLog');
		$result = $OrderConfirmLog->where($where)->data($data)->save();
		return $result;
	}

	public function getListByWhere($where){
		if(empty($where)){
			return false;
		}
		$OrderConfirmLog = M('OrderConfirmLog');
		
		$list = $OrderConfirmLog->where($where)->select();
	
		return $list;
	}

	public function getSumWhere($where,$field){
		if(empty($where)){
			return false;
		}
		$OrderConfirmLog = M('OrderConfirmLog');
		
		$data = $OrderConfirmLog->where($where)->sum($field);
	
		return $data;
	}

	/**
	 * 订单日志列表
	 */
	public function getLogList($where,$page,$pagesize=20){
		if (empty($where)) {
			return false;
		}
		
		$startrow = ($page - 1) * $pagesize;
		
		$OrderConfirmLog = M('OrderConfirmLog');
		$list = $OrderConfirmLog->where($where)->limit($startrow, $pagesize)->order('id desc')->select();
		return $list;
	}
		/**
	 * 订单日志列表
	 */
	public function getLogList_shop($where,$page,$pagesize=20){
		$startrow = ($page - 1) * $pagesize;
		$OrderConfirmLog = M('OrderConfirmLog');
		//$sql="SELECT a.*,b.`shop_code`,b.`shop_name` FROM hhj_order_confirm_log AS a LEFT JOIN hhj_shop AS b ON a.`shop_id`=b.`shop_id` WHERE $where  ORDER BY a.id DESC LIMIT $startrow,$pagesize";
		$list = $OrderConfirmLog->join('LEFT JOIN hhj_shop on hhj_order_confirm_log.`shop_id` = hhj_shop.`shop_id`')->where($where)->field('hhj_order_confirm_log.*,hhj_shop.shop_name,hhj_shop.shop_code')->limit($startrow, $pagesize)->order('hhj_order_confirm_log.id desc')->select();
		return $list;
	}
	//获取数量
	public function LogCount($where=''){
		$OrderConfirmLog = M('OrderConfirmLog');
		$count = $OrderConfirmLog->where($where)->count();
		return $count;
	}

	public function getLogList_left_shop($where){
		$OrderConfirmLog = M('OrderConfirmLog');
		//$sql="SELECT a.*,b.`shop_code`,b.`shop_name` FROM hhj_order_confirm_log AS a LEFT JOIN hhj_shop AS b ON a.`shop_id`=b.`shop_id` WHERE $where  ORDER BY a.id DESC LIMIT $startrow,$pagesize";
		$list = $OrderConfirmLog->join('LEFT JOIN hhj_shop on hhj_order_confirm_log.`shop_id` = hhj_shop.`shop_id`')->where($where)->field('hhj_order_confirm_log.*,hhj_shop.shop_name,hhj_shop.shop_code')->order('hhj_order_confirm_log.id desc')->select();
		return $list;
	}

	public function get_data_all($where){
		if (empty($where)) {
			return false;
		}
		$OrderConfirmLog = M('OrderConfirmLog');
		$list = $OrderConfirmLog->where($where)->order('id desc')->select();
		return $list;
	}
}