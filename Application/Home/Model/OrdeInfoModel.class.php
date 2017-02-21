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
class OrderInfoModel{
	
	/** 
	 * 管理员备注订单信息
	 */
	public function getInfoById($info_id){
		if(empty($info_id)){
			return false;
		}
	
		$Orderinfo = M('Orderinfo');
		$where['orderinfo_id'] = $info_id;
		$data = $Orderinfo->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加管理员备注订单信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Orderinfo = M('Orderinfo');
		$result = $Orderinfo->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除管理员备注订单
	 */
	public function del($info_id){
		if (empty($info_id)) {
			return false;
		}
	
		$Orderinfo = M('Orderinfo');
		$where['orderinfo_id'] = $info_id;
		$result = $Orderinfo->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改管理员备注订单信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['orderinfo_id'])){
			$info_id = $data['orderinfo_id'];
			unset($data['orderinfo_id']);
	
			$Orderinfo = M('Orderinfo');
			$result = $Orderinfo->where(" orderinfo_id = %d ",$info_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询管理员备注订单列表
	 */
	public function getList(){
		$Orderinfo = M('Orderinfo');
		$list = $Orderinfo->select();
	
		return $list;
	}
}