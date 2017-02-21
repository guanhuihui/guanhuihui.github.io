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
 * 哈粉定制订单模型
 */
class FansOrderModel{
	
	/** 
	 * 哈粉定制订单信息fansorder_id
	 */
	public function getInfoById($order_id){
		if(empty($order_id)){
			return false;
		}
	
		$Fansorder = M('Fansorder');
		$where['fansorder_id'] = $order_id;
		$data = $Fansorder->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加哈粉定制订单信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Fansorder = M('Fansorder');
		$result = $Fansorder->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除哈粉定制订单
	 */
	public function del($order_id) {
		if (empty($order_id)) {
			return false;
		}
	
		$Fansorder = M('Fansorder');
		$where['fansorder_id'] = $order_id;
		$result = $Fansorder->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改哈粉定制订单信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['fansorder_id'])){
			$order_id = $data['fansorder_id'];
			unset($data['fansorder_id']);
	
			$Fansorder = M('Fansorder');
			$result = $Fansorder->where(" fansorder_id = %d ",$order_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询哈粉定制订单列表
	 */
	public function getList() {
		$Fansorder = M('Fansorder');
		$list = $Fansorder->select();
	
		return $list;
	}
}