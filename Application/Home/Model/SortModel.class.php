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
 * 产品分类模型
 */
class SortModel{
	
	/**
	 * 分类信息
	 */
	public function getInfoById($sort_id){
		if(empty($sort_id)){
			return false;
		}
	
		$Sort = M('Sort');
		$where['sort_id'] = $sort_id;
		$data = $Sort->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加产品分类信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Sort = M('Sort');
		$result = $Sort->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除产品分类
	 */
	public function del($sort_id) {
		if (empty($sort_id)) {
			return false;
		}
	
		$Sort = M('Sort');
		$where['sort_id'] = $sort_id;
		$result = $Sort->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改产品分类信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['sort_id'])){
			$sort_id = $data['sort_id'];
			unset($data['sort_id']);
	
			$Sort = M('Sort');
			$result = $Sort->where(" sort_id = %d ",$sort_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询产品分类列表
	 */
	public function getList() {
		$Sort = M('Sort');
		$list = $Sort->select();
	
		return $list;
	}
	
	/**
	 * Goods::checkSort()验证商品分类
	 *
	 * @param mixed $type商品类型
	 * @param mixed $sort商品分类
	 * @return
	 */
	public function checkSort($type, $sort){
		
		$Sort = M('Sort');
		$map['sort_id'] = $sort;
		$map['sort_type'] = $type;
		
		$data = $Sort->where($map)->find();
		if($data && $data['sort_id']>0){
			return true;
		}else{
			return false;
		}
	}
	
	//商品分类列表
	//$type----分类 0：哈哈镜；1：自营
	public function sortList($type=0){
		
		$Sort = M('Sort');	

		if(is_numeric($type) && $type > 0){
			$map['sort_parent'] = 0;
			$map['sort_type'] = $type;
		}elseif(is_numeric($type) && $type == 0){
			$map['sort_parent'] = 0;
			$map['sort_type'] = $type;
		}

		$list = $Sort->where($map)->order('sort_order asc, sort_id desc')->select();
		return $list;
	}
	
	/**
	 * $where 根据条件查找
	 */
	public function search($where) {
		
		$Sort = M('Sort');
		$data = $Sort->where($where)->select();
	
		return $data;
	}
	
	/**
	 * $where 根据条件查找
	 */
	public function hhj_sort() {
	
		$where['sort_parent'] = 0;
		$where['sort_type'] = 0;
		$where['sort_id'] = array('neq',7);
		$Sort = M('Sort');
		$list = $Sort->where($where)->order('sort_order asc, sort_id desc')->select();
	
		return $list;
	}
	
	/**
	 * 获取自营分类
	 */
	public function shop_sort() {
	
		$where['sort_parent'] = 0;
		$where['sort_type'] = 1;
		$map['sort_id'] = array('eq',7);
		$map['_logic'] = 'or';
		$map['_complex'] = $where;
		$Sort = M('Sort');
		$list = $Sort->where($map)->order('sort_order asc, sort_id desc')->select();
	
		return $list;
	}
}