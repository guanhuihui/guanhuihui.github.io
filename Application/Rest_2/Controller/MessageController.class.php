<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ZhaoBo at 2015/11/12
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/**
 * 消息管理
 */
class MessageController extends UserFilterController {
	
	public function _initialize(){
   		parent::_initialize();
	}
	
	/**
	 * 获取用户消息列表
	 */
	public function get_list(){
		//登陆验证
		$this->checklogin();
		
		/********获取接口参数********/
		$type_id = I('post.type_id', 0);//消息类型   默认为0系统消息   1为用户信息
		$province_id = I('post.province_id', 0);//省份ID 默认为空
		$city_id = I('post.city_id', 0);//城市ID  默认为空
		
		/********获取消息列表********/
		$Message = D('Home/Message');
		$AppTip = D('Home/AppTip');
		$AppTip->clear($this->uid, 1, 3);//清除我的消息提示状态
		//参数说明: $send_type 信息类型  $this->uid用户ID $province_id省份ID $city_id城市ID
		$list = $Message->getList($type_id, $this->uid, $province_id, $city_id);
		if($list){
			//对信息重组
			$data = array();
			foreach ($list as $key => $val){
				$data[$key]['messageid'] = $val['message_id'];
				$data[$key]['title'] = $val['title'];
				$data[$key]['content'] = $val['content'];
				$data[$key]['sendtime'] = date('Y-m-d H:i:s',$val['add_time']);
				$data[$key]['sendtype'] = $val['send_type'];
				$data[$key]['messagetype'] = $val['message_type'];
				$data[$key]['userid'] = $val['user_id'];
				$data[$key]['isread'] = $val['status'];
			}
			$list = $data;
		}
		
		if($list === false){ //数据库查询失败
			json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		}else{
			json_success($list);
		}		
	}
	
}