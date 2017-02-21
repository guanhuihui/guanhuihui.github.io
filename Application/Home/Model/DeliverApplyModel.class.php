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
 * 管理员备注订单模型
 */
class DeliverApplyModel{
	
	/** 
	 * 管理员备注订单信息
	 */
	public function getInfoById($deliver_id){
		if(empty($deliver_id)){
			return false;
		}
	
		$Deliverapply = M('Deliverapply');
		$where['deliverapply_id'] = $deliver_id;
		$data = $Deliverapply->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加管理员备注订单信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Deliverapply = M('Deliverapply');
		$result = $Deliverapply->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除管理员备注订单
	 */
	public function del($deliver_id) {
		if (empty($deliver_id)) {
			return false;
		}
	
		$Deliverapply = M('Deliverapply');
		$where['deliverapply_id'] = $deliver_id;
		$result = $Deliverapply->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改管理员备注订单信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['deliverapply_id'])){
			$deliver_id = $data['deliverapply_id'];
			unset($data['deliverapply_id']);
	
			$Deliverapply = M('Deliverapply');
			$result = $Deliverapply->where(" deliverapply_id = %d ",$deliver_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询管理员备注订单列表
	 */
	public function getList() {
		$Deliverapply = M('Deliverapply');
		$list = $Deliverapply->select();
	
		return $list;
	}
}