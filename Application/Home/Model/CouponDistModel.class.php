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
 * 用户优惠券模型
 */
class CouponDistModel{
	
	/** 
	 * 用户优惠券信息coupondist_id
	 */
	public function getInfoById($dist_id){
		if(empty($dist_id)){
			return false;
		}
	
		$Coupondist = M('Coupondist');
		$where['coupondist_id'] = $dist_id;
		$data = $Coupondist->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加用户优惠券信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Coupondist = M('Coupondist');
		$result = $Coupondist->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除用户优惠券
	 */
	public function del($dist_id) {
		if (empty($dist_id)) {
			return false;
		}
	
		$Coupondist = M('Coupondist');
		$where['coupondist_id'] = $dist_id;
		$result = $Coupondist->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改用户优惠券信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['coupondist_id'])){
			$dist_id = $data['coupondist_id'];
			unset($data['coupondist_id']);
	
			$Coupondist = M('Coupondist');
			$result = $Coupondist->where(" coupondist_id = %d ",$dist_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询用户优惠券列表
	 */
	public function getList() {
		$Coupondist = M('Coupondist');
		$list = $Coupondist->select();
	
		return $list;
	}
}