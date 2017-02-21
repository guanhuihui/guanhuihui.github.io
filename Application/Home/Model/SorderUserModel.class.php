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
 * 商户订单用户模型
 */
class SorderUserModel{
	
	/** 
	 * 商户订单用户信息
	 */
	public function getInfoById($user_id){
		if(empty($user_id)){
			return false;
		}
	
		$Sorderuser = M('Sorderuser');
		$where['sorderuser_id'] = $user_id;
		$data = $Sorderuser->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加商户订单用户信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Sorderuser = M('Sorderuser');
		$result = $Sorderuser->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除商户订单用户
	 */
	public function del($user_id) {
		if (empty($user_id)) {
			return false;
		}
	
		$Sorderuser = M('Sorderuser');
		$where['sorderuser_id'] = $user_id;
		$result = $Sorderuser->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改商户订单用户信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['sorderuser_id'])){
			$user_id = $data['sorderuser_id'];
			unset($data['sorderuser_id']);
	
			$Sorderuser = M('Sorderuser');
			$result = $Sorderuser->where(" sorderuser_id = %d ",$user_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询商户订单用户列表
	 */
	public function getList(){
		$Sorderuser = M('Sorderuser');
		$list = $Sorderuser->select();
	
		return $list;
	}
	
	/**
	 * ShopOnAPP::orderUserlist()店铺用户列表
	 *
	 * @param integer $page
	 * @param integer $pagesize
	 * @return
	 */
	public function orderUserlist($shop_id, $page=1, $pagesize=20){
		if(empty($shop_id)){
			return false;
		}
		
		$Sorderuser = M('Sorderuser');		
		$startrow = ($page - 1) * $pagesize;		
		//SQL参数过滤
		$map['sorderuser_shop'] = $shop_id;		
		$list = $Sorderuser->where($map)->order('sorderuser_id desc')->limit("$startrow, $pagesize");
		return $list;	
	}
}