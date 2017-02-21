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
 * 城市模型
 */
class CityModel{
	
	/**
	 * 城市信息
	 */
	public function getInfoById($city_id){
		if(empty($city_id)){
			return false;
		}
	
		$City = M('City');
		$map['city_id'] = $city_id;
		$data = $City->where($map)->find();
	
		return $data;
	}
	
	/**
	 * 百度城市code和数据库中的城市ID 进行转换
	 */
	public function changeCityCode($city_code){
		if(empty($city_code)){
			return false;
		}
		
		$map = array();
		$map['city_baiducode'] = $city_code;
		
		$City = M('City');
		$data = $City->where($map)->find();
		return $data;
	}
	
	/**
	 * 百度城市名称获取数据库中的城市ID
	 */
	public function getInfoByName($city_name){
		if(empty($city_name)){
			return false;
		}
	
		$map = array();
		$map['city_name'] = $city_name;
	
		$City = M('City');
		$data = $City->where($map)->find();
		return $data;
	}
	
	
	/**
	 * 城市信息
	 */
	public function getCityByArea($city_id){
		if(empty($city_id)){
			return false;
		}
	
		$City = M('City');
		$where = " area_city = '$city_id' ";
		$data = $City->where($where)->order(" area_order asc , area_id desc ")->select();
	
		return $data;
	}
	
	
	
	/**
	 * 城市信息
	 */
	public function getCityByBaiduCode($city_baiducode) {
		
		if (empty($city_baiducode)){
			return false;
		}
		
		$where = " city_baiducode = '$city_baiducode' ";
		$City = M('City');
		$data = $City->where($where)->find();
		
		return $data;
	}
	
	/**
	 * 添加城市信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$City = M('City');
		$result = $City->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除城市
	 */
	public function del($city_id) {
		if (empty($city_id)) {
			return false;
		}
	
		$City = M('City');
		$map['city_id'] = $city_id;
		$result = $City->where($map)->delete();
	
		return $result;
	}
	
	/**
	 * 修改城市信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['city_id'])){
			$city_id = $data['city_id'];
			unset($data['city_id']);
	
			$City = M('City');
			$result = $City->where(" city_id = %d ",$city_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询城市列表
	 */
	public function getList($is_hot=false, $order='city_id asc') {
		$City = M('City');
		if($is_hot){
			$map['city_ishot'] = 1;
			$list = $City->where($map)->order($order)->select();
		}else{
			$list = $City->order($order)->select();
		}
	
		return $list;
	}
	
	/**
	 * 条件查询城市列表
	 * @param $where 条件
	 */
	public function getListByWhere($where = 0) {
		if(empty($where)){
			$where = '1';
		}
		
		$City = M('City');
		$list = $City->where($where)->order('city_order asc')->select();
		
		return $list;
	}
	
	/**
	 * 根据城市名称搜索城市信息
	 */
	public function getCityByName($name){
		if(empty($name)){
			return false;
		}
		
		$City = M('City');
		$map['city_name'] = $name;
		$data = $City->where($map)->find();
		
		return $data;
	}
}