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
 * 经销商模型
 */
class DealerModel{
	
	/**
	 * 添加经销商信息
	 */
	public function getInfoById($dealer_id){
		if(empty($dealer_id)){
			return false;
		}
	
		$Dealer = M('Dealer');
		$map['dealer_id'] = $dealer_id;
		$data = $Dealer->where($map)->find();
	
		return $data;
	}
	
	/**
	 * 添加经销商信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Dealer = M('Dealer');
		$result = $Dealer->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除经销商
	 */
	public function del($dealer_id) {
		if (empty($dealer_id)) {
			return false;
		}
	
		$Dealer = M('Dealer');
		$where['dealer_id'] = $dealer_id;
		$result = $Dealer->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改管理员组信息
	 */
	public function edit($where, $data){
		if(empty($where)||empty($data)){
			return false;
		}

		$Dealer = M('Dealer');
		$result = $Dealer->where($where)->save($data);
		return $result;
	}
	
	/**
	 * 查询管理员组列表
	 */
	public function getList() {
		$Dealer = M('Dealer');
		$list = $Dealer->select();
	
		return $list;
	}
	
	/**
	 * 登录
	 */
	public function login($account,$password) {		
		$where = " dealer_code = '$account' ";		
		$Dealer = M('Dealer');		
		$data = $Dealer->where($where)->find();		
		if ($data){			
			if ( md5(md5($password).$data['dealer_salt']) != $data['dealer_password'] ){
				return -3;
			}			
			return $data;
		}		
		return -4;
		
	}
	
	/**
	 * 获取经销商信息
	 * $where
	 */
	public function dealerInfo($where){
		if(empty($where)){
			return false;
		}
		
		$Dealer = M('Dealer');
		
		$data = $Dealer->where($where)->select();
		
		return $data;
	}
}