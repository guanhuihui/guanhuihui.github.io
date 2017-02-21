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
 * 加盟代售点模型
 */
class JoinSaleModel{
	
	/** 
	 * 加盟代售点信息joinsale_id
	 */
	public function getInfoById($sale_id){
		if(empty($sale_id)){
			return false;
		}
	
		$Joinsale = M('Joinsale');
		$where['joinsale_id'] = $sale_id;
		$data = $Joinsale->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加加盟代售点信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Joinsale = M('Joinsale');
		$result = $Joinsale->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除加盟代售点
	 */
	public function del($sale_id) {
		if (empty($sale_id)) {
			return false;
		}
	
		$Joinsale = M('Joinsale');
		$where['joinsale_id'] = $sale_id;
		$result = $Joinsale->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改加盟代售点信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['joinsale_id'])){
			$sale_id = $data['joinsale_id'];
			unset($data['joinsale_id']);
	
			$Joinsale = M('Joinsale');
			$result = $Joinsale->where(" joinsale_id = %d ",$sale_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 获取申请加盟代售点列表
	 * parameter  $where为查询条件
	 */
	public function getList($where,$page,$pagesize){
	
		$startrow = ($page - 1) * $pagesize;
		$Shop = M('Joinsale');
		$data = $Shop->where($where)->limit("$startrow, $pagesize")->order('joinsale_id desc')->select();
		return $data;
	}
	
	/**
	 * 申请加盟代售点总数
	 */
	public function count($where=''){
		$Joinshop = M('Joinsale');
		$count = $Joinshop->where($where)->count();
		return $count;
	}
}