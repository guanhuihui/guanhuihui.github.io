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
 * 邀请模型
 */
class InviteModel{
	
	/** 
	 * 邀请信息
	 */
	public function getInfoById($invite_id){
		if(empty($invite_id)){
			return false;
		}
	
		$Invite = M('Invite');
		$where['invite_id'] = $invite_id;
		$data = $Invite->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加邀请信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Invite = M('Invite');
		$result = $Invite->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除邀请
	 */
	public function del($invite_id) {
		if (empty($invite_id)) {
			return false;
		}
	
		$Invite = M('Invite');
		$where['invite_id'] = $invite_id;
		$result = $Invite->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改邀请信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['invite_id'])){
			$invite_id = $data['invite_id'];
			unset($data['invite_id']);
	
			$Invite = M('Invite');
			$result = $Invite->where(" invite_id = %d ",$invite_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询邀请列表
	 * $invite_type 1 用户 -----  2 商户
	 */
	public function getList($invite_user,$invite_type = 1) {
		
		$where = " invite_type = '$invite_type' ";
		
		if ($invite_user){
			$where .= " and invite_user = '$invite_user' ";
		}
		
		$Invite = M('Invite');
		$data = $Invite->where($where)->select();
		
		return $data;
	}
}