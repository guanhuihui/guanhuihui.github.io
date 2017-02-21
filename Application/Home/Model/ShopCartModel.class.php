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
 * 商户订货购物车模型
 */
class ShopCartModel{
	
	/** 
	 * 商户订货购物车信息shopcart_id
	 */
	public function getInfoById($cart_id){
		if(empty($cart_id)){
			return false;
		}
	
		$Shopcart = M('Shopcart');
		$where['shopcart_id'] = $cart_id;
		$data = $Shopcart->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加商户订货购物车信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Shopcart = M('Shopcart');
		$result = $Shopcart->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除商户订货购物车
	 */
	public function del($cart_id) {
		if (empty($cart_id)) {
			return false;
		}
	
		$Shopcart = M('Shopcart');
		$where['shopcart_id'] = $cart_id;
		$result = $Shopcart->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改商户订货购物车信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['shopcart_id'])){
			$cart_id = $data['shopcart_id'];
			unset($data['shopcart_id']);
	
			$Shopcart = M('Shopcart');
			$result = $Shopcart->where(" shopcart_id = %d ",$cart_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询商户订货购物车列表
	 */
	public function getList() {
		$Shopcart = M('Shopcart');
		$list = $Shopcart->select();
	
		return $list;
	}
}