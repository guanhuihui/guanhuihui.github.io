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
 * 城市区域价格模型
 */
class RegionModel{
	
	/** 
	 * 城市区域价格信息
	 */
	public function getInfoById($region_id){
		if(empty($region_id)){
			return false;
		}
	
		$Region = M('Region');
		$where['region_id'] = $region_id;
		$data = $Region->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加城市区域价格信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Region = M('Region');
		$result = $Region->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除城市区域价格
	 */
	public function del($region_id) {
		if (empty($region_id)) {
			return false;
		}
	
		$Region = M('Region');
		$where['region_id'] = $region_id;
		$result = $Region->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改城市区域价格信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['region_id'])){
			$region_id = $data['region_id'];
			unset($data['region_id']);
	
			$Region = M('Region');
			$result = $Region->where(" region_id = %d ",$region_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询城市区域价格列表
	 */
	public function getList() {
		$Region = M('Region');
		$list = $Region->select();
	
		return $list;
	}
	
	function getRegionInfoByCity($city){		
		if(empty($city)){
			return false;
		}
		
		$Region = M('Region');
		$map['region_city'] = $city;
		$data = $Region->where($map)->find();
		if($data){
			$_data = array();
			$_data['id'] = $data['region_id'];
			$_data['city'] = $data['region_city'];
			$_data['distcount']  = $data['region_num'];			
			return $_data;
		}
		
		return false;
	}
}