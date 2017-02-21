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
 * 区域模型
 */
class AreaModel{
	
	/**
	 * 区域信息
	 */
	public function getInfoById($area_id){
		if(empty($area_id)){
			return false;
		}
	
		$Area = M('Area');
		$where['area_id'] = $area_id;
		$data = $Area->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加区域信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Area = M('Area');
		$result = $Area->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除区域
	 */
	public function del($area_id) {
		if (empty($area_id)) {
			return false;
		}
	
		$Area = M('Area');
		$where['area_id'] = $area_id;
		$result = $Area->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改区域信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['area_id'])){
			$area_id = $data['area_id'];
			unset($data['area_id']);
	
			$Area = M('Area');
			$result = $Area->where(" area_id = %d ",$area_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询区域列表
	 */
	public function getList() {
		$Area = M('Area');
		$list = $Area->select();
	
		return $list;
	}
	
	/**
	 * 根据条件查询区域列表
	 * @param  $where 搜索条件
	 */
	public function getListByWhere($where){
		if(empty($where) || !is_array($where)){
			return false;
		}
		
		$Area = M('Area');
		$list = $Area->where($where)->order('area_order asc')->select();
		return $list;
	}
	
	/**
	 * 根据城市ID 和区域ID 获取区域信息
	 * @param  $city_id 城市ID
	 * @param  $area_id 区域ID
	 */
	public function getListByCityId($city_id, $area_id=0){
		if(empty($city_id)){
			return false;
		}
		
		$Area = M('Area');
		$map = array();
		$map['area_city'] = $city_id;
		if($area_id){
			$map['area_id'] = $area_id;
		}
		$list = $Area->where($map)->order('area_order asc')->select();
		return $list;
	}
}