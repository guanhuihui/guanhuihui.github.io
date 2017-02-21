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
 * 管理员组模型 
 */
class AdminGroupModel{
	
	/**
	 * 管理员组信息
	 */
	public function getInfoById($group_id){
		if(empty($group_id)){
			return false;
		}
	
		$Admingroup = M('Admingroup');
		$where['admingroup_id'] = $group_id;
		$data = $Admingroup->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加管理员组信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Admingroup = M('Admingroup');
		$result = $Admingroup->data($data)->add();
		
		return $result;
	}
	
	/**
	 * 删除管理员组
	 */
	public function del($group_id) {
		if (empty($group_id)) {
			return false;
		}
	
		$Admingroup = M('Admingroup');
		$where['admingroup_id'] = $group_id;
		$result = $Admingroup->where($where)->delete();
		
		return $result;
	}
	
	/**
	 * 修改管理员组信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['admingroup_id'])){
			$group_id = $data['admingroup_id'];
			unset($data['admingroup_id']);
				
			$Admingroup = M('Admingroup');
			$result = $Admingroup->where(" admingroup_id = %d ",$group_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询管理员组列表
	 */
	public function getList() {
		$Admingroup = M('Admingroup');
		$list = $Admingroup->select();
		
		return $list;
	}
}