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
 * 推送信息模型
 */
class MessageModel{
	
	/** 
	 * 推送信息信息
	 */
	public function getInfoById($msg_id){
		if(empty($msg_id)){
			return false;
		}
	
		$Message = M('Message');
		$where['message_id'] = $msg_id;
		$data = $Message->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加推送信息信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Message = M('Message');
		$result = $Message->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除推送信息
	 */
	public function del($msg_id) {
		if (empty($msg_id)) {
			return false;
		}
	
		$Message = M('Message');
		$where['message_id'] = $msg_id;
		$result = $Message->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改推送信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['msg_id'])){
			$msg_id = $data['msg_id'];
			unset($data['msg_id']);
	
			$Message = M('Message');
			$result = $Message->where(" message_id = %d ",$msg_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	
	/**
	 * 查询用户信息列表(返回最近一月数据);
	 */
	public function getList($type_id, $user_id, $province_id=0, $city_id=0){
		//最近一月
		$time = time() - intval(C('MESSAGE_GET_TIME'));		
		$Message = M('Message');
		
		$where = '';
		$id_array = array();
		if($type_id){ //用户消息
			$where = "message_type=1 AND send_type=3 AND user_id=%d AND add_time>%d";
			$id_array[] = $user_id;
			$id_array[] = $time;
		}else{ //系统消息
			$where = "message_type=0 AND send_type in (0,1,2) AND (FIND_IN_SET(%d, province) OR FIND_IN_SET(%d, city) OR send_type=0) AND add_time>%d";
			$id_array[] = $province_id;
			$id_array[] = $city_id;
			$id_array[] = $time;
		}
		
		$list = $Message->where($where, $id_array)->order('add_time desc')->select();
		return $list;
	}
	
	/**
	 * 更改阅读状态
	 */
	public function alterRead($msg_id,$msg_isread = 0) {

		if (empty($msg_id)){
			return false;
		}
		
		$where = " message_id = '$msg_id' ";
		
		$Message = M('Message');
		$result = $Message->where($where)->data(array('status' => $msg_isread))->save();
		
		return $result;
	}
	
	/**
	 * 获取信息数量
	 */
	public function getMsgCount($msg_type, $msg_sendid, $msg_province, $msg_city) {
		
		if($msg_type == 2 ){
			$where = " msg_type = '$msg_type' and ( msg_sendid = '-1' or msg_province = '$msg_province' or msg_city = '$msg_city' ) ";
		}else{
			$where = " msg_type = '$msg_type' and ( msg_sendid in ('-1','$msg_sendid') or msg_province = '$msg_province' or msg_city = '$msg_city' ) ";
		}
		
		$Message = M('Message');
		$count = $Message->where($where)->count();
		
		return $count;
	}
	
	/**
	 * Table_msg::countUnreadMsg()获取未读数量
	 *
	 * @param mixed $type 收件人类型
	 * @param mixed $sendid 收件人ID
	 * @return void
	 */
	public function countUnreadMsg($type, $send_id){
		if(empty($type) && empty($send_id)){
			return false;
		}
		
		$map = array();
		$map['msg_type'] = $type;
		$map['msg_sendid'] = $send_id;
		
		$Message = M('Message');
		$count = $Message->where($map)->count();
		return $count;
	}
	
	/**
	 * 推送列表
	 */
	public function getAllList($where, $page, $pagesize = 20){
		
		$startrow = ($page - 1) * $pagesize;
		
		$Message = M('Message');
		$list = $Message->where($where)->order('add_time desc')->limit("$startrow, $pagesize")->select();
		return $list;
	}
	
	/**
	 * 获取总数
	 */
	public function getCount($where){
		$Message = M('Message');
		$count = $Message->where($where)->count();
		return $count;
	}
	
}