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
 * 配送员模型
 */
class DeliverModel{
	
	/** 
	 * 配送员信息
	 */
	public function getInfoById($deliver_id){
		if(empty($deliver_id)){
			return false;
		}
	
		$Deliver = M('Deliver');
		$where['deliver_id'] = $deliver_id;
		$data = $Deliver->where($where)->find();
	
		return $data;
	}
	
	
	/**
	 * 添加配送员信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Deliver = M('Deliver');
		$result = $Deliver->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除配送员
	 */
	public function del($deliver_shop,$deliver_id) {
		if (empty($deliver_id)) {
			return false;
		}
		$where = array();
		$where['deliver_id'] = $deliver_id;
		
		if($deliver_shop){
			$where['deliver_shop'] = $deliver_shop;
		}
	
		$Deliver = M('Deliver');
		$result = $Deliver->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改配送员信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['deliver_id'])){
			$deliver_id = $data['deliver_id'];
			unset($data['deliver_id']);
	
			$Deliver = M('Deliver');
			$result = $Deliver->where(" deliver_id = %d ",$deliver_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 修改配送员信息(新方法)
	 * @param  $where  更新条件
	 * @param  $data  更新数据
	 */
	public function save($where, $data){
		if(empty($where)) {
			return false;
		}
	
		$Deliver = M('Deliver');
		$result = $Deliver->where($where)->data($data)->save();
		return $result;
		
		
	}
	
	/**
	 * 查询配送员列表
	 */
	public function getList() {
		$Deliver = M('Deliver');
		$list = $Deliver->select();
	
		return $list;
	}
	
	/**
	 * 添加配送员
	 */
	public function addDeliverApply($deliver_shop,$name,$phone) {
		
		$last_deliver = $this->getLastDeliver($deliver_shop);
		
		$number = substr($last_deliver['deliver_account'], -2);
		
		if ($number){
			$number += 1;
		}else{
			$number = substr($last_deliver['deliver_account'], -1)+1;
		}
		
		$ctt = '';
		
		if ($number>10){
			$ctt = '0'.$number;
		}else{
			$ctt = $number;
		}
		
		$Shop = D('Shop');
		$shop_info = $Shop->getInfoById($deliver_shop);
		$account = $shop_info['shop_code'].$ctt;
		
		$salt = randcode(10,4);
		
		$Deliver = M('Deliver');
		$Deliver->deliver_shop = $deliver_shop;
		$Deliver->deliver_name = $name;
		$Deliver->deliver_account = $account;
		$Deliver->deliver_password = md5(md5('123456').$salt);
		$Deliver->deliver_salt = $salt;
		$Deliver->deliver_phone = $phone;
		$Deliver->deliver_addtime = time();
		$Deliver->deliver_status = 0;
		$result = $Deliver->add();
		
		if ($result){
			$data = array();
			$data['id'] = $result;
			$data['name'] = $name;
			$data['account'] = $account;
			$data['time'] = date('Y-m-d H:i:s');
			$data['statuid'] = '0';
		}
	
		return 0;
		
	}
	
	/**
	 *  获取当前配送员账号数量
	 */
	public function getDeliverCount($shopid = 0,$status = '-1') {
		
		$where = ' 1 = 1 ';
		
		if ($shopid){
			$where .= " and deliver_shop = '$shopid' ";
		}
		
		if ($status != '-1' && is_numeric($status)){
			$where .= " and deliver_status = '$status' ";
		}
		
		$Deliver = M('Deliver');
		$result = $Deliver->where($where)->count();
		
		return $result;
	}
	
	/**
	 * 获取最后配送员
	 */
	public function getLastDeliver($deliver_shop = 0,$status = '-1') {
		
		$where = ' 1 = 1 ';
		
		if ($deliver_shop){
			$where .= " and deliver_shop = '$deliver_shop' ";
		}
		
		if ($status != '-1' && is_numeric($status)){
			$where .= " deliver_status = '$status' ";
		}
		
		$Deliver = M('Deliver');
		$data = $Deliver->where($where)->order(' deliver_id desc ')->find();
		
		return $data;
	}
	
	/**
	 * 获取申请配送员列表
	 */
	public function getApplyList($deliver_shop = 0){
		
		$where = ' 1 = 1 ';
		
		if ($deliver_shop){
			$where .= " deliver_shop = '$deliver_shop' ";
		}
		
		$Deliver = M('Deliver');
		$data = $Deliver->where($where)->order(' deliver_id desc ')->select();
		
		return $data;
	}
	
	/**
	 * 根据条件获取配送员列表
	 */
	public function applyList($where){
		$Deliver = M('Deliver');
		$data = $Deliver->where($where)->select();
		
		return $data;
	}
	
}