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
 * 微信支付凭证
 */
class ShopWithdrawalsPayLogModel{	
	/**
	 * 添加记录
	 */
	public function add_data($data){
		if (empty($data)) {
			return false;
		}
	
		$ShopWithdrawalsPayLog = M('ShopWithdrawalsPayLog');
		$result = $ShopWithdrawalsPayLog->data($data)->add();
		return $result;
	}

	public function getListByWhere($where){
		if(empty($where)){
			return false;
		}
		$ShopWithdrawalsPayLog = M('ShopWithdrawalsPayLog');
		
		$list = $ShopWithdrawalsPayLog->where($where)->select();
	
		return $list;
	}
	//修改
	public function edit($where,$data){
		if (empty($data)) {
			return false;
		}
		$ShopWithdrawalsPayLog = M('ShopWithdrawalsPayLog');
		$result = $ShopWithdrawalsPayLog->where($where)->data($data)->save();
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
		
		$ShopWithdrawalsPayLog = M('ShopWithdrawalsPayLog');
		$list = $ShopWithdrawalsPayLog->where($where)->limit($startrow, $pagesize)->order('id desc')->select();
		return $list;
	}
}