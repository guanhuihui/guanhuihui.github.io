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
 * 加盟模型
 */
class JoinModel{
		
	/**
	 * 添加网店加盟信息
	 */
	public function addJoinShop($data){
		if (empty($data)) {
			return false;
		}
	
		$JoinShop = M('Joinshop');
		$result = $JoinShop->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 添加经销商加盟信息
	 */
	public function addJoinDealer($data){
		if (empty($data)) {
			return false;
		}
	
		$JoinDealer = M('Joindealer');
		$result = $JoinDealer->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 添加代售点加盟信息
	 */
	public function addJoinSale($data){
		if (empty($data)) {
			return false;
		}
	
		$JoinSale = M('Joinsale');
		$result = $JoinSale->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 添加网店加盟信息
	 */
	public function JoinShopByCode($data){
		if (empty($data)) {
			return false;
		}
	
		$JoinShop = M('Joinshop');
		$result = $JoinShop->where($data)->find();
	
		return $result;
	}
	
}