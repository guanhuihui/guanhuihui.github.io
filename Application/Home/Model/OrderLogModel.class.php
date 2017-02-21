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
 * 订单日志模型
 */
class OrderLogModel{
	
	/**
	 * 用户订单处理日志(仅限客户端展示)
	 * @param unknown $order_no
	 * @param unknown $user_id
	 * @return boolean|unknown
	 */
	public function getUserList($order_no){
		if (empty($order_no)) {
			return false;
		}
		
		$map = array();
		$map['order_no'] = $order_no;
		$map['log_type'] = 1;
		//log类型  1生成订单 2商户拒单 3重新分配 4调度完毕 5已发货 6取消订单 7作废订单 8完成订单9删除订单 10待支付 11支付完成
		$map['action_type'] = array('exp',' IN (1,5,6,7,8,10,11) ');
		
		$OrderLog = M('OrderLog');
		$list = $OrderLog->where($map)->order('log_id desc')->select();
		return $list;
	}
	
	/**
	 * 根据订单号，操作类型获取日志
	 * @param unknown $order_no 订单号
	 * @param unknown $action 操作类型
	 * @return boolean|unknown
	 */
	public function getInfoByAction($order_no,$action){
		if (empty($order_no)) {
			return false;
		}
	
		$map = array();
		$map['order_no'] = $order_no;
		$map['action_type'] = $action;
		
		$OrderLog = M('OrderLog');
		$list = $OrderLog->where($map)->order('log_id desc')->find();
		return $list;
	}
	
	/**
	 * 订单日志列表
	 * @param 订单编号 $order_no
	 * @param 日志类型 $log_type 1备注 2操作 0全部
	 * @param 操作者类型 $oper_type 1用户 2商户 3管理员 0全部
	 * @param 操作人id $oper_id
	 * @return array
	 */
	public function getList($order_no, $log_type=0, $oper_type=0, $oper_id=0){
		if (empty($order_no)) {
			return false;
		}

		$map = array();
		$map['order_no'] = $order_no; 
		if($log_type){
			$map['log_type'] = $log_type;
		}		
		if($oper_type){
			$map['oper_type'] = $oper_type;
		}
		if($oper_id){
			$map['oper_id'] = $oper_id;
		}
		
		$OrderLog = M('OrderLog');
		$list = $OrderLog->where($map)->order('log_id desc')->select();
		return $list;
	}
	
	public function getInfoByNo($order_no){
		if(empty($order_no)){
			return false;
		}
	
		$OrderLog = M('OrderLog');
		$map['order_no'] = $order_no;
		$data = $OrderLog->where($map)->find();
	
		return $data;
	}
	
	/**
	 * 添加订单日志信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$OrderLog = M('OrderLog');
		$result = $OrderLog->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 订单日志列表
	 */
	public function getLogList($where,$page,$pagesize=20){
		if (empty($where)) {
			return false;
		}
		
		$startrow = ($page - 1) * $pagesize;
		
		$OrderLog = M('OrderLog');
		$list = $OrderLog->where($where)->limit($startrow, $pagesize)->order('log_id desc')->select();
		return $list;
	}
}