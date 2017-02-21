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
 * 商户订货模型
 */
class ShopOrderModel{
	
	/** 
	 * 商户订货信息shoporder_id
	 */
	public function getInfoById($order_id){
		if(empty($order_id)){
			return false;
		}
	
		$Shoporder = M('Shoporder');
		$where['shoporder_id'] = $order_id;
		$data = $Shoporder->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加商户订货信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Shoporder = M('Shoporder');
		$result = $Shoporder->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除商户订货
	 */
	public function del($order_id) {
		if (empty($order_id)) {
			return false;
		}
	
		$Shoporder = M('Shoporder');
		$where['shoporder_id'] = $order_id;
		$result = $Shoporder->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改商户订货信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['shoporder_id'])){
			$order_id = $data['shoporder_id'];
			unset($data['shoporder_id']);
	
			$Shoporder = M('Shoporder');
			$result = $Shoporder->where(" shoporder_id = %d ",$order_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询商户订货列表
	 */
	public function getList() {
		$Shoporder = M('Shoporder');
		$list = $Shoporder->select();
	
		return $list;
	}
}