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
 * 统计模型
 */
class StatisticModel{
	
	/** 
	 * 统计信息
	 */
	public function getInfoById($statistic_id){
		if(empty($statistic_id)){
			return false;
		}
	
		$Statistic = M('Statistic');
		$where['statistic_id'] = $statistic_id;
		$data = $Statistic->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加统计信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Statistic = M('Statistic');
		$result = $Statistic->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除统计
	 */
	public function del($statistic_id) {
		if (empty($statistic_id)) {
			return false;
		}
	
		$Statistic = M('Statistic');
		$where['statistic_id'] = $statistic_id;
		$result = $Statistic->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改统计信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['statistic_id'])){
			$statistic_id = $data['statistic_id'];
			unset($data['statistic_id']);
	
			$Statistic = M('Statistic');
			$result = $Statistic->where(" statistic_id = %d ",$statistic_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询统计列表
	 */
	public function getList(){
		$Statistic = M('Statistic');
		$list = $Statistic->select();
	
		return $list;
	}
}