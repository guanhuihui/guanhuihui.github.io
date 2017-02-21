<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/11/11
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/**
 * 优惠券控制器
 */
class CouponController extends UserFilterController {
	
	public function _initialize(){
		parent::_initialize();
	}
	
	/**
	 * 用户优惠券列表
	 */
	public function get_list() {
		//验证登陆
 		$this->checkLogin();
		
		/*******获取参数********/
		$status_type = I('post.status', 0); //优惠券使用状态 0全部  1仅可用优惠券

		/*******获取用户优惠券信息********/
		$Ticket = D('Home/Ticket');
		$AppTip = D('Home/AppTip');
		$AppTip->clear($this->uid, 1, 2);//清除我的优惠券提示状态
		$list = $Ticket->getList($this->uid);
		
		//封装组合优惠券信息
		 if($list){

		 	$data = array();//可用优惠券列表
		 	$arr = array();//不可用优惠券列表
		 	
		 	if($status_type){//可有优惠券优惠券
			 		foreach($list as $key=>$val){
			 			// 优惠券状态 0未使用 1使用中 2已使用 3已作废
			 			$status = $Ticket->getStatus($val['act_status'], $val['act_begin_time'], $val['act_end_time'], $val['status'], $val['begin_time'], $val['end_time']);
			 			if($status < 1){//可用的优惠券列表
			 				$data[$key]['ticket_id'] = $val['ticket_id']; //券ID
			 				$data[$key]['act_id'] = $val['act_id'];  //活动ID
			 				$data[$key]['user_id'] = $val['user_id']; //用户ID
			 				$data[$key]['act_name'] = $val['act_name'];  //活动名称
			 				$data[$key]['act_desc'] = $val['act_desc'];  //活动简介
			 				$data[$key]['notes'] = $val['notes'];  //活动简介
			 				$data[$key]['ticket_price'] = $val['discount_price'];//优惠券面值
			 				$data[$key]['start_price'] = $val['price'];//起步金额
			 				$data[$key]['discount_price'] = $val['discount_price'];//优惠金额
			 				if($val['goods_id']){//实物券时 优惠金额为0
			 					$data[$key]['discount_price'] = 0;
			 				}			 				
			 				$data[$key]['code'] = $val['ticket_code']; //优惠码
			 				$data[$key]['start_date'] = $val['begin_time']; //优惠券开始时间
			 				$data[$key]['end_date'] = $val['end_time']; //优惠券结束时间
			 				$data[$key]['status'] = $status; //优惠券状态
			 			}
			 		}
		 		
			 	    $list = $data; 
		 	}else{//所有优惠券
			 		foreach($list as $key=>$val){
			 			// 优惠券状态 0未使用 1使用中 2已使用 3已作废
			 			$status = $Ticket->getStatus($val['act_status'], '1900-01-01 00:00:00', $val['act_end_time'], $val['status'], '1900-01-01 00:00:00', $val['end_time']);
			 			if($status <= 1){//可用的优惠券列表
			 				$data[$key]['ticket_id'] = $val['ticket_id']; //券ID
			 				$data[$key]['act_id'] = $val['act_id'];  //活动ID
			 				$data[$key]['user_id'] = $val['user_id']; //用户ID
			 				$data[$key]['act_name'] = $val['act_name'];  //活动名称
			 				$data[$key]['act_desc'] = $val['act_desc'];  //活动简介
			 				$data[$key]['notes'] = $val['notes'];  //活动简介
			 				$data[$key]['ticket_price'] = $val['discount_price'];//优惠券面值
			 				$data[$key]['start_price'] = $val['price'];//起步金额
			 				$data[$key]['discount_price'] = $val['discount_price'];//优惠金额
			 				if($val['goods_id']){//实物券时 优惠金额为0
			 					$data[$key]['discount_price'] = 0;
			 				}
			 				$data[$key]['code'] = $val['ticket_code']; //优惠码
			 				$data[$key]['start_date'] = $val['begin_time']; //优惠券开始时间
			 				$data[$key]['end_date'] = $val['end_time']; //优惠券结束时间
			 				$data[$key]['status'] = $status; //优惠券状态
			 			}else{
			 				$arr[$key]['ticket_id'] = $val['ticket_id']; //券ID
			 				$arr[$key]['act_id'] = $val['act_id'];  //活动ID
			 				$arr[$key]['user_id'] = $val['user_id']; //用户ID
			 				$arr[$key]['act_name'] = $val['act_name'];  //活动名称
			 				$arr[$key]['act_desc'] = $val['act_desc'];  //活动简介
			 				$arr[$key]['notes'] = $val['notes'];  //活动简介
			 				$arr[$key]['ticket_price'] = $val['discount_price'];//优惠券面值
			 				$arr[$key]['start_price'] = $val['price'];//起步金额
			 				$arr[$key]['discount_price'] = $val['discount_price'];//优惠金额
			 				if($val['goods_id']){//实物券时 优惠金额为0
			 					$arr[$key]['discount_price'] = 0;
			 				}
			 				$arr[$key]['code'] = $val['ticket_code']; //优惠码
			 				$arr[$key]['start_date'] = $val['begin_time']; //优惠券开始时间
			 				$arr[$key]['end_date'] = $val['end_time']; //优惠券结束时间
			 				$arr[$key]['status'] = $status; //优惠券状态
			 			}
			 		}
			 		
			 		$list = array_merge($data, $arr); //合并数组
		 	 }
		 	
		 }
		 
		if($list === false){ //数据库查询失败
			json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		}else{
			json_success($list);
		}		
	
	}
	
	/**
	 * 绑定优惠券
	 */
	public function bind_ticket(){
		//验证登陆
		$this->checkLogin();
		//优惠券号码
		$ticket_code = I('post.ticket_code', '');
		//转换成大写 
		$ticket_code = strtoupper($ticket_code);
		//优惠券号码不能为空
		if(empty($ticket_code)) json_error(20902, array('msg'=>C('ERR_CODE.20902')));
		
		$Ticket = D('Home/Ticket');
		$result = $Ticket->binding($ticket_code, $this->uid);
		if($result){
			json_success(array('msg'=>'ok'));
		}else{
			//优惠券不存在
			json_error(20901, array('msg'=>C('ERR_CODE.20901')));
		}
	}
	
}