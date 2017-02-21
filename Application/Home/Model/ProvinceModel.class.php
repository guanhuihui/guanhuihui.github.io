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
 * 省模型
 */
class ProvinceModel{
	
	/**
	 * 省信息
	 */
	public function getInfoById($province_id){
		if(empty($province_id)){
			return false;
		}
	
		$Province = M('Province');
		$where['province_id'] = $province_id;
		$data = $Province->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加省信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Province = M('Province');
		$result = $Province->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除省
	 */
	public function del($province_id) {
		if (empty($province_id)) {
			return false;
		}
	
		$Province = M('Province');
		$where['province_id'] = $province_id;
		$result = $Province->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改省信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['province_id'])){
			$province_id = $data['province_id'];
			unset($data['province_id']);
	
			$Province = M('Province');
			$result = $Province->where(" province_id = %d ",$province_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询省列表
	 */
	public function getList() {
		$Province = M('Province');
		$list = $Province->order('province_order asc')->select();
	
		return $list;
	}
	
	/**
	 * 查询省列表
	 */
	public function provinceList($where) {
		$Province = M('Province');
		$list = $Province->where($where)->order('province_order asc')->select();
	
		return $list;
	}
}