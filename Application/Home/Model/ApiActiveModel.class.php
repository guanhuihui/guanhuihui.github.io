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
 * 接口调用统计模型
 */
class ApiactiveModel{
	
	/** 
	 * 接口调用统计信息
	 */
	public function getInfoById($active_id){
		if(empty($active_id)){
			return false;
		}
	
		$Apiactive = M('Apiactive');
		$where['Apiactive_id'] = $active_id;
		$data = $Apiactive->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加接口调用统计信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Apiactive = M('Apiactive');
		$result = $Apiactive->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除接口调用统计
	 */
	public function del($active_id) {
		if (empty($active_id)) {
			return false;
		}
	
		$Apiactive = M('Apiactive');
		$where['Apiactive_id'] = $active_id;
		$result = $Apiactive->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改接口调用统计信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['Apiactive_id'])){
			$active_id = $data['Apiactive_id'];
			unset($data['Apiactive_id']);
	
			$Apiactive = M('Apiactive');
			$result = $Apiactive->where(" Apiactive_id = %d ",$active_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询接口调用统计列表
	 */
	public function getList() {
		$Apiactive = M('Apiactive');
		$list = $Apiactive->select();
	
		return $list;
	}
}