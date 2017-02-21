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
 * App提示模型
 */
class AppTipModel{
	
	/** 
	 * 根据提示id查询
	 */
	public function getInfoById($tip_id){
		if(empty($tip_id)){
			return false;
		}
	
		$AppTip = M('AppTip');
		$map['tip_id'] = $tip_id;
		$data = $AppTip->where($map)->find();
	
		return $data;
	}
	
	/**
	 * 添加提示信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$AppTip = M('AppTip');
		$result = $AppTip->data($data)->add();
		
		return $result;
	}
	
	/**
	 * 修改提示信息
	 */
	public function edit($where, $data){
		if(empty($where) && empty($data)){
			return false;
		}
	
		$AppTip = M('AppTip');
		$result = $AppTip->where($where)->data($data)->save();
		return $result;
	}
	
	/**
	 * 查询待提示列表
	 * @param 用户id $user_id
	 * @param 用户类型 $user_type 1客户端 2商户端
	 * @return array
	 */
	public function getList($user_id, $user_type=1){
		if(empty($user_id)){
			return false;
		}
		
		$map = array();
		$map['user_type'] = $user_type;
		$map['user_id'] = $user_id;
		$map['status'] = 1;
		
		$AppTip = M('AppTip');
		$list = $AppTip->where($map)->select();	
		return $list;
	}
	
	/**
	 * 清除提示状态
	 * @param 用户id $user_id
	 * @param 用户类型 $user_type
	 * @param 提示类型 $tip_type
	 * @return boolean
	 */
	public function clear($user_id, $user_type, $tip_type){
		if(empty($user_id) && empty($user_type) && empty($tip_type)){
			return false;
		}
		
		$map = array();
		$map['user_type'] = $user_type;
		$map['user_id'] = $user_id;
		$map['tip_type'] = $tip_type;
		
		$data = array();
		$data['status'] = 0;
		$data['updata_time'] = time();
		
		$AppTip = D('Home/AppTip');
		$result = $AppTip->edit($map, $data);
		return $result;		
	} 
	
}