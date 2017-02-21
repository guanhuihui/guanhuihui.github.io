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
 * 加盟经销商模型
 */
class JoinDealerModel{
	
	/** 
	 * 加盟经销商信息joindealer_id
	 */
	public function getInfoById($dealer_id){
		if(empty($dealer_id)){
			return false;
		}
	
		$Joindealer = M('Joindealer');
		$where['joindealer_id'] = $dealer_id;
		$data = $Joindealer->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加加盟经销商信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Joindealer = M('Joindealer');
		$result = $Joindealer->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除加盟经销商
	 */
	public function del($dealer_id) {
		if (empty($dealer_id)) {
			return false;
		}
	
		$Joindealer = M('Joindealer');
		$where['joindealer_id'] = $dealer_id;
		$result = $Joindealer->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改加盟经销商信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['joindealer_id'])){
			$dealer_id = $data['joindealer_id'];
			unset($data['joindealer_id']);
	
			$Joindealer = M('Joindealer');
			$result = $Joindealer->where(" joindealer_id = %d ",$dealer_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 获取申请加盟经销商列表
	 * parameter  $where为查询条件
	 */
	public function getList($where,$page,$pagesize){
	
		$startrow = ($page - 1) * $pagesize;
		$Shop = M('Joindealer');
		$data = $Shop->where($where)->limit("$startrow, $pagesize")->order('joindealer_id desc')->select();
		return $data;
	}
	
	/**
	 * 申请加盟经销商总数
	 */
	public function count($where=''){
		$Joinshop = M('Joindealer');
		$count = $Joinshop->where($where)->count();
		return $count;
	}
}