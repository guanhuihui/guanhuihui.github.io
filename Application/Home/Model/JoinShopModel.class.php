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
 * 加盟商户模型
 */
class JoinShopModel{
	
	/** 
	 * 加盟商户信息joinshop_id
	 */
	public function getInfoById($shop_id){
		if(empty($shop_id)){
			return false;
		}
	
		$Joinshop = M('Joinshop');
		$where['joinshop_id'] = $shop_id;
		$data = $Joinshop->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加加盟商户信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Joinshop = M('Joinshop');
		$result = $Joinshop->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除加盟商户
	 */
	public function del($shop_id) {
		if (empty($shop_id)) {
			return false;
		}
	
		$Joinshop = M('Joinshop');
		$where['joinshop_id'] = $shop_id;
		$result = $Joinshop->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改加盟商户信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['joinshop_id'])){
			$shop_id = $data['joinshop_id'];
			unset($data['joinshop_id']);
	
			$Joinshop = M('Joinshop');
			$result = $Joinshop->where(" joinshop_id = %d ",$shop_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 获取申请加盟商户列表
	 * parameter  $where为查询条件
	 */
	public function getList($where,$page,$pagesize){
	
		$startrow = ($page - 1) * $pagesize;
		$Shop = M('Joinshop');
		$data = $Shop->where($where)->limit("$startrow, $pagesize")->order('joinshop_id desc')->select();
		return $data;
	}
	
	/**
	 * 申请加盟商户总数
	 */
	public function count($where=''){
		$Joinshop = M('Joinshop');
		$count = $Joinshop->where($where)->count();
		return $count;
	}
}