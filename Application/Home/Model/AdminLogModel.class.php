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
 * 日志模型
 */
class AdminLogModel{
	
	/** 
	 * 日志信息
	 */
	public function getInfoById($log_id){
		if(empty($log_id)){
			return false;
		}
	
		$Adminlog = M('Adminlog');
		$where['adminlog_id'] = $log_id;
		$data = $Adminlog->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加日志信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Adminlog = M('Adminlog');
		$result = $Adminlog->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除日志
	 */
	public function del($log_id) {
		if (empty($log_id)) {
			return false;
		}
	
		$Adminlog = M('Adminlog');
		$where['adminlog_id'] = $log_id;
		$result = $Adminlog->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改日志信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['adminlog_id'])){
			$log_id = $data['adminlog_id'];
			unset($data['adminlog_id']);
	
			$Adminlog = M('Adminlog');
			$result = $Adminlog->where(" adminlog_id = %d ",$log_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询日志列表
	 */
	public function getList(){
		$Adminlog = M('Adminlog');
		$list = $Adminlog->select();
	
		return $list;
	}
	
	/**
	 * 后台管理员日志
	 * @param $user_id 管理员ID
	 * @param $info 日志信息
	 */
	public function admin_log($user_id, $info){
		$data = array();
		$data['adminlog_admin'] = $user_id;
		$data['adminlog_time'] = time();
		$data['adminlog_log'] = $info;
		$data['adminlog_ip'] = get_client_ip();
		
		$Adminlog = M('adminlog');
		$result = $Adminlog->add($data);
		return $result;		
	}
	
}