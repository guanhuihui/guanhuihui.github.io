<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/10/26
// +----------------------------------------------------------------------

namespace Rest_2\Controller;
use Think\Log;

/**
 * 订单信息控制器
 */
class OrderController extends UserFilterController {
	
	public function _initialize(){
		parent::_initialize();
	}
	
	/**
	 * 获取拒绝原因列表
	 */
	public function refuse_reason(){
		$list = C('USER_REFUSE_TYPE');
		json_success($list);
	}
	
	/**
	 * 确认收货
	 */
	public function complete(){
		$this->checkLogin();
		$order_no = I('post.order_no', ''); //订单编号
		
		//订单编号不能为空
		if(empty($order_no)) json_error(20703, array('msg'=>C('ERR_CODE.20703')));
		
		$Order = D('Home/OrderNew');
		$order_data = $Order->getInfoByNo($order_no);
		if($order_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		
		//订单已发货
		if($order_data['order_status'] == 5){
			$result = $Order->userComplete($this->uid, $order_data['order_id']);
			if($result){
				//订单日志
				$OrderLog = D('Home/OrderLog');
				$order_log_data = array();
				$order_log_data['order_no'] = $order_data['order_no'];
				$order_log_data['log_type'] = 1;//日志类型 操作
				$order_log_data['oper_type'] = 1;//操作人类型 用户
				$order_log_data['oper_name'] = '';
				$order_log_data['oper_id'] = $this->uid;
				$order_log_data['action_type'] = 8;//用户确认收货
				$order_log_data['log_info'] = '完成';
				$order_log_data['log_desc'] = '订单已完成';
				$order_log_data['add_time'] = time();
				$OrderLog->add($order_log_data);	

				//店铺销售量加1
				$Shop = D('Home/Shop');
				$Shop->addOrderCount($order_data['shop_id']);
				
				
				//验证代金券 如果未使用代金券
				if(!empty($order_data['ticket_id']) || !empty($order_data['act_ticket'])){
					
					$Ticket = D('Home/Ticket');
					if($order_data['ticket_id']){
						//保证优惠券可用------------begin--------------
						//获取优惠券信息
						$tickets = $Ticket->getInfoById($order_data['ticket_id']);
						if(strtotime($tickets['end_time']) < time()){
							json_success(array('msg'=>'ok')); //优惠券已过期
						}
							
						//获取活动信息
						
						$Activity = D('Home/Activity');
						$activity_result = $Activity->getInfoById($tickets['act_id']);
						
						if(strtotime($activity_result['end_time']) < time()){
							json_success(array('msg'=>'ok'));	//活动已结束
						}
						//保证优惠券可用------------end--------------
					}
					
					if($order_data['act_ticket']){
						//保证优惠券可用------------begin--------------
						//获取优惠券信息
						$act_tickets = $Ticket->getInfoById($order_data['act_ticket']);
						if(strtotime($act_tickets['end_time']) < time()){
							json_success(array('msg'=>'ok')); //优惠券已过期
						}
					
						//获取活动信息
							
						$Activity = D('Home/Activity');
						$activity_res = $Activity->getInfoById($act_tickets['act_id']);
							
						if(strtotime($activity_res['end_time']) < time()){
							json_success(array('msg'=>'ok'));	//活动已结束
						}
						//保证优惠券可用------------end--------------
						
						//更新商户赠品统计
// 						$re = $Activity->getAct();
// 						if($re){
// 							$OrderGoods = D('Home/OrderGoods');
// 							$Goods = D('Home/Goods');
// 							$goods_data = $OrderGoods->giftsCountByNo($order_data['order_no']);
// 							foreach($goods_data as $k=>$v){
// 								$goods_c = $Shop->findGiftByShop($order_data['shop_id'],$v['goods_id']);
// 								if($goods_c){
// 									$Shop->giftsCountAdd($order_data['shop_id'],$v['goods_id'],$v['count']);
// 								}else{
// 									$goods_info = $Goods->getInfoById($v['goods_id']);
// 									$Shop->addGift($order_data['shop_id'],$v['goods_id'],$goods_info['goods_name'],$v['count']);
// 								}
// 							}
// 						}
					}
					
					
					$ticket_status = false;  //更新优惠券状态检测变量
					//更新优惠券状态
					if($order_data['ticket_id']){
						$map = array();
						$map['ticket_id'] = $order_data['ticket_id'];
						$map['status'] = 1;
							
						$data = array();
						$data['status'] = 2;
						$data['use_time'] = time();
						$ticket_status = $Ticket->edit($map, $data);
							
					}
					
					//更新买赠兑换券状态
					if($order_data['act_ticket']){
						$act_map = array();
						$act_map['ticket_id'] = $order_data['act_ticket'];
						$act_map['status'] = 1;
					
						$act_data = array();
						$act_data['status'] = 2;
						$act_data['use_time'] = time();
						$Ticket->edit($act_map, $act_data);
					}
					
					if($ticket_status){ //是否更新优惠券状态为已使用
						//验证成功更新返款记录表
						$TicketBalance = D('Home/TicketBalance');						
						$data_balance = array(
								'shop_id' => $order_data['shop_id'],
								'user_id' => $tickets['user_id'],
								'ticket_id' => $tickets['ticket_id'],
								'act_id' => $tickets['act_id'],
								'ticket_price' => $tickets['discount_price'],
								'ticket_discount' => $tickets['return_price'],
								'order_no' => $order_data['order_no'],
								'status' => 0,
								'add_time' => time()
						);
						$balance_data = $TicketBalance->getInfoByTicketId($tickets['ticket_id']);
						if(!$balance_data){
							$TicketBalance->add($data_balance);
						}
						
					}
				}
				/*****给商户发推送*****/
				$Shop = D('Home/Shop');
				$shop_data = $Shop->getInfoById($order_data['shop_id']);
				if($shop_data){
					vendor('Jpush.jpush'); //商品总金额
					$jpush = new \Jpush(C('JPUSH_SHOP_APPKEY'), C('JPush_SHOP_masterSecret'), C('JPush_url'));
					$send  = array('alias'=>array($shop_data['shop_account']));
					$res = $jpush->shopPush($send,'您有一个订单,客户已确认收货',1,1,'','86400','speech.caf');
					Log::write("jpushRes => ".$res);
				}
				
				json_success(array('msg'=>'ok'));				
			}
		}
		
		json_error(20715, array('msg'=>C('ERR_CODE.20715')));//确认收货失败
	}
	
	/**
	 * 用户取消订单
	 */
	public function cancel(){
		$this->checkLogin();
		$order_no = I('post.order_no', ''); //订单编号
		$reason = I('post.reason', ''); //取消原因
		
		//订单编号不能为空
		if(empty($order_no)) json_error(20703, array('msg'=>C('ERR_CODE.20703')));
		
		$Order = D('Home/OrderNew');
		$order_data = $Order->getInfoByNo($order_no);
		if($order_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败 
		
		//设置15分钟无法取消订单
		if(time() > $order_data['add_time']+60*15)  json_error(20713, array('msg'=>C('ERR_CODE.20713')));//订单无法取消
		
		if($order_data['order_status']<=2){	
			$result = $Order->userCancel($this->uid, $order_data['order_id']);
			if($result){
				
				//订单日志
				$OrderLog = D('Home/OrderLog');
				$order_log_data = array();
				$order_log_data['order_no'] = $order_data['order_no'];
				$order_log_data['log_type'] = 1;//日志类型 操作
				$order_log_data['oper_type'] = 1;//操作人类型 用户
				$order_log_data['oper_name'] = '';
				$order_log_data['oper_id'] = $this->uid;
				$order_log_data['action_type'] = 6;//用户取消订单
				$order_log_data['log_info'] = '订单成功取消';
				$order_log_data['log_desc'] = $reason;
				$order_log_data['add_time'] = time();
				$OrderLog->add($order_log_data);
				
				//恢复优惠券状态
				$Ticket = D('Home/Ticket');
				if($order_data['ticket_id']){
					$map['ticket_id'] = $order_data['ticket_id'];
					$ticket_data['status'] = 0;
					$ticket_data['use_time'] = 0;
					$Ticket->edit($map,$ticket_data);
				}
				if($order_data['act_ticket']){
					$map['ticket_id'] = $order_data['act_ticket'];
					$ticket_data['status'] = 0;
					$ticket_data['use_time'] = 0;
					$Ticket->edit($map,$ticket_data);
				}
				
				json_success(array('msg'=>'ok'));
			}
		}
		
		json_error(20713, array('msg'=>C('ERR_CODE.20713')));//订单无法取消
	}

	/**
	 * 用户删除订单
	 */
	public function del(){
		$this->checkLogin();
		$order_no = I('post.order_no', ''); //订单编号
		
		//订单编号不能为空
		if(empty($order_no)) json_error(20703, array('msg'=>C('ERR_CODE.20703')));
		
		$Order = D('Home/OrderNew');
		$order_data = $Order->getInfoByNo($order_no);
		if($order_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败

		if($order_data['order_status']==6 || $order_data['order_status']==7 || $order_data['order_status']==8){
			$result = $Order->userDel($this->uid, $order_data['order_id']);
			if($result){

				//订单日志
				$OrderLog = D('Home/OrderLog');
				$order_log_data = array();
				$order_log_data['order_no'] = $order_data['order_no'];
				$order_log_data['log_type'] = 1;//日志类型 操作
				$order_log_data['oper_type'] = 1;//操作人类型 用户
				$order_log_data['oper_name'] = '';
				$order_log_data['oper_id'] = $this->uid;
				$order_log_data['action_type'] = 9;//用户删除
				$order_log_data['log_info'] = '订单删除';
				$order_log_data['add_time'] = time();
				$OrderLog->add($order_log_data);
				
				json_success(array('msg'=>'ok'));
			}
		}
		
		json_error(20714, array('msg'=>C('ERR_CODE.20714')));//订单无法删除
	}

	
	/**
	 * 获取用户订单列表
	 */
	public function get_list(){
		$this->checkLogin();
		
		$order_id = I('post.order_id', 0); //起始订单号
		$goods_visible = I('post.goods_visible', 0); //是否显示商品
		$page_num = I('post.page_num', 10);//每页条目			

		$Order = D('Home/OrderNew');
		$Shop = D('Home/shop');
		$AppTip = D('Home/AppTip');
		$AppTip->clear($this->uid, 1, 1);//清除我的订单提示状态
		$list = $Order->getUserList($this->uid, $order_id, $page_num, $is_del=0);	

		if($list){
			//对信息重组
			$_list = array();
			$OrderGoods = D('Home/OrderGoods');
			foreach ($list as $val){
				$data = array();
				$data['order_id'] = $val['order_id'];
				$data['order_no'] = $val['order_no'];
				$data['user_id'] = $val['user_id'];
				$data['user_name'] = $val['user_name'];
				$data['mobile'] = $val['mobile'];
				$data['province'] = $val['province'];
				$data['city'] = $val['city'];
				$data['district'] = $val['district'];
				$data['address'] = $val['address'];
				$data['total_quantity'] = $val['total_quantity'];
				$data['goods_amount'] = $val['goods_amount'];
				$data['total_amount'] = $val['total_amount'];
				$data['total_paid'] = $val['total_paid'];
				$data['pay_status'] = $val['pay_status'];
				$data['pay_type'] = $val['pay_type'];
				$data['pay_time'] = $val['pay_time'];
				
				if($val['order_status'] == 1){
					$data['order_status'] = 1;//生成订单
				}else if($val['order_status'] == 5){
					$data['order_status'] = 5;//已发货
				}else if($val['order_status'] == 6 || $val['order_status'] == 7){
					$data['order_status'] = 6;//取消订单
				}else if($val['order_status'] == 8){
					$data['order_status'] = 8;//完成订单
				}else{
					$data['order_status'] = 2;//待发货
				}
				
				$data['shop_id'] = $val['shop_id'];
				if($val['shop_id']){
					$shopinfo = $Shop->getInfoById($val['shop_id']);
					if($shopinfo){
						$data['shop_name'] = $shopinfo['shop_name'];
					}
				}
				$data['add_time'] = date('Y-m-d H:i:s', $val['add_time']);
				
				$goods_list = $OrderGoods->getList($val['order_no'], $this->uid);
				$goods_num = 0;
				$gift_num = 0;
				if($goods_visible){
					$data['goods_list'] = $goods_list;
				}
				if($goods_list){
					foreach ($data['goods_list'] as $v){
						if($v['type']==1){
							$goods_num += 1*$v['count'];
						}else{
							$gift_num += 1*$v['count'];
						}
					}
				}
				$data['goods_num'] =$goods_num;
				$data['gift_num'] =$gift_num;
				
				//0未评分 大于0为分数
				$data['score'] = $val['score'];    		
				
				$_list[] = $data;
			}
			$list = $_list;
		}
		
		if($list === false){ //数据库查询失败
			json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		}else{
			json_success($list);
		}
	}
		
	/**
	 * 订单状态跟踪
	 */
	public function status_log(){
		$this->checkLogin();
		
		$order_no = I('post.order_no', ''); //订单号
		//订单编号不能为空
		if(empty($order_no)) json_error(20703, array('msg'=>C('ERR_CODE.20703')));
		
		$OrderLog = D('Home/OrderLog');
		$list = $OrderLog->getUserList($order_no);		
		if($list){
			//对信息重组
			$_list = array();		
			foreach ($list as $val){
				$data = array();
				$data['log_id'] = $val['log_id'];
				$data['order_no'] = $val['order_no'];
				$data['oper_type'] = $val['oper_type'];
				$data['log_info'] = $val['log_info'];
				$data['log_desc'] = $val['log_desc'];
				$data['add_time'] = $val['add_time'];			
				
				$_list[] = $data;
			}
			$list = $_list;
		}
		
		if($list === false){ //数据库查询失败
			json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		}else{
			json_success($list);
		}		
	}
    	
	/**
	 * 获取订单详情
	 */
	public function detail(){
 		$this->checkLogin();

		$order_no = I('post.order_no', ''); //订单号
		//订单编号不能为空
		if(empty($order_no)) json_error(20703, array('msg'=>C('ERR_CODE.20703')));
		
		$Order = D('Home/OrderNew');
		$order_data = $Order->getInfoByNo($order_no);
		if($order_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		
		if($order_data){
			$data = array();
			$Shop = D('Home/shop');
			$shopinfo = $Shop->getInfoById($order_data['shop_id']);//获取店铺名称
			$data['order_id'] = $order_data['order_id'];
			$data['order_no'] = $order_data['order_no'];
			$data['user_id'] = $order_data['user_id'];
			$data['user_name'] = $order_data['user_name'];
			$data['mobile'] = $order_data['mobile'];
			$data['province'] = $order_data['province'];
			$data['city'] = $order_data['city'];
			$data['district'] = $order_data['district'];
			$data['address'] = $order_data['address'];
			$data['total_quantity'] = $order_data['total_quantity'];
			$data['total_amount'] = $order_data['total_amount'];
			$data['goods_amount'] = $order_data['goods_amount'];
			$data['post_fee'] = $order_data['post_fee'];
			$data['discount'] = $order_data['discount'];
			$data['user_messge'] = $order_data['user_messge'];
			$data['total_paid'] = $order_data['total_paid'];
			$data['order_status'] = $order_data['order_status'];
			$data['shop_id'] = $order_data['shop_id'];
			$data['shop_name'] = $shopinfo['shop_name'];
			$data['shop_phone'] = $shopinfo['shop_orderphone1'];
			$data['deliver_type'] = $order_data['deliver_type'];
			$data['add_time'] = $order_data['add_time'];
			$book_time = trim($order_data['book_time']);
			if(!empty($book_time)){
				$data['book_time'] = $order_data['book_time'];
			}else{
				$data['book_time'] = '今天  立即送达';
			}
			
			if($order_data['deliver_type']){
				$data['book_time'] = '到店自提';
			}
			
			$data['score'] = $order_data['score'];
			$data['act_ticket'] = $order_data['act_ticket'];
			$data['act_tips'] = '';
			if($order_data['act_ticket']){
				$Ticket = D('Home/Ticket');
				$ticketinfo = $Ticket->getInfoById($order_data['act_ticket']);
				if($ticketinfo){
					$Activity = D('Home/Activity');
					$activity_info = $Activity->getInfoById($ticketinfo['act_id']);
					if($activity_info){
						$data['act_tips'] = $activity_info['act_warning'];
					}
				}
			}
			
			$OrderGoods = D('Home/OrderGoods');			
			$list = $OrderGoods->getList($order_data['order_no'], $this->uid);			
			$_list = array();
			$key = 0;
			for($i=0;$i<count($list);$i++){
				$goods_arr = array();
				$goods_arr = $list[$i];
				$goods_arr['gift'] = null;
				$type = $list[$i]['type'];
				if($order_data['act_ticket'] && $type==2 && $key){
					$gift_arr = array();
					$gift_arr['goods_id'] = $goods_arr['goods_id'];
					$gift_arr['goods_name'] = $goods_arr['goods_name'];
					$gift_arr['goods_pic'] = $goods_arr['goods_pic'];
					$gift_arr['count'] = $goods_arr['count'];
					$gift_arr['price'] = $goods_arr['price'];
					$_list[$key-1]['gift'] = $gift_arr;
				}else{				
					$_list[$key] = $goods_arr;
					$key++;
				}
			}			
			
			$data['goods_list'] = $_list ? $_list : null;
			json_success($data);		
		}else{
			//订单不存在
			json_error(20704, array('msg'=>C('ERR_CODE.20704')));
		}
	}
	
	/**
	 * 订单确认页
	 */
	public function confirm(){
		$this->checkLogin();
		
		$address_id = I('post.address_id', 0); //收货地址id
		$shop_id = I('post.shop_id', 0); //店铺id
		$cart_ids = I('post.cart_ids', ''); //购物车id 1,2,3,4 可多选
		$ticket_id = I('post.ticket_id', 0); //优惠券id
		$deliver_type = I('post.deliver_type', 0); //配送方式 0送货上面 1到店自提
		$act_ticket = I('post.act_ticket', 0); //买赠券id
		
		if(empty($shop_id)) json_error(20705, array('msg'=>C('ERR_CODE.20705')));//店铺ID不能为空
		if(empty($cart_ids)) json_error(20706, array('msg'=>C('ERR_CODE.20706')));//购物车ID不能为空
		
		$data = array();

		//获取收货地址
		$Address = D('Home/UserAddress');
		$address_data = $Address->getInfoById($address_id, $this->uid);
		if($address_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		if($address_data){
			$data['address_info']['address_id'] = $address_data['useraddress_id'];
			$data['address_info']['username'] = $address_data['useraddress_name'];
			$data['address_info']['phone'] = $address_data['useraddress_phone'];
			$data['address_info']['province'] = $address_data['province_name'];
			$data['address_info']['city'] = $address_data['city_name'];
			$data['address_info']['area'] = $address_data['useraddress_district'];
			$data['address_info']['address'] = $address_data['useraddress_address'];
		}else{
			json_error(20707, array('msg'=>C('ERR_CODE.20707')));//收货地址不存在
		}


		//获取店铺信息
		$Shop = D('Home/Shop');
		$shop_data = $Shop->getInfoById($shop_id);
		if($shop_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		if(!$shop_data) json_error(20708, array('msg'=>C('ERR_CODE.20708')));//店铺不存在
		
		//支付方式
		$data['pay_type'] = array(array('type_id'=>'40', 'type_name'=>'货到付款')); //40货到付款
		//配送时间
		if($shop_data['shop_delivertime2']){
			if(!$shop_data['shop_delivertime1']){
				$shop_data['shop_delivertime1'] = 0;
			}
			
			//日期选项
			$data['book_day'] = array(date("Y-m-d",time()),date("Y-m-d",strtotime("+1 day")),date("Y-m-d",strtotime("+2 day")),date("Y-m-d",strtotime("+3 day")),date("Y-m-d",strtotime("+4 day")));
			//小时段选项
			$data['book_hour'] = array();
			$_num = intval(($shop_data['shop_delivertime2']-$shop_data['shop_delivertime1'])/3600);
			if($_num){
				$starttime = strtotime('January 1 1970 00:00:00') + $shop_data['shop_delivertime1'];
				for($i=0; $i<$_num; $i++) {
	  				$data['book_hour'][] = date('H:i', $starttime+($i*3600)).'-'.date('H:i', $starttime+(($i+1)*3600));
				}
			}	
		}

		$goods_info = $this->goods_calculate($shop_id, $shop_data['shop_deliverfee'], $cart_ids, $ticket_id, $shop_data['shop_province'], $shop_data['shop_city'], 1, $deliver_type, $shop_data['shop_isvip'],$act_ticket);
		$data = array_merge($data, $goods_info);	
		$data['tips'] = '全场满200元免运费';
		$data['pay_status'] = C('PAY_STATUS');
		if($shop_data['shop_city'] == 133){
			$data['activity'] = '哈哈镜鸭系列卤味买二赠一（大盒特惠装除外）';//活动描述
		}else{
			$data['activity'] = '哈哈镜全系列卤味买二赠一（大盒特惠装除外）';//活动描述
		}
		
		
		json_success($data);
	}
	
	/**
	 * 添加订单
	 */
	public function add(){
		$this->checkLogin();

		$address_id = I('post.address_id', 0); //收货地址id
		$shop_id = I('post.shop_id', 0); //店铺id
		$cart_ids = I('post.cart_ids', ''); //购物车id 1,2,3,4 可多选		
		$ticket_id = I('post.ticket_id', 0); //优惠券id
		$pay_type = I('post.pay_type', 40); //支付类型 40货到付款     20支付宝支付
		$deliver_type = I('post.deliver_type', 0); //配送方式 0送货上面 1到店自提
		$message = I('post.message', ''); //用户留言	
		$book_time = I('post.book_time', ''); //预约时间 2015-11-22 11:00-12:00 格式
		$act_ticket = I('post.act_ticket', 0); //买赠券id
		//到店自提可用
		$user_name = I('post.user_name', ''); //到店自提人姓名
		$telphone = I('post.telphone', ''); //到店自提人电话
		//经纬度计算 超距离拒绝下单
		
		//添加订单
		$result = $this->add_order($address_id, $shop_id, $cart_ids, $ticket_id, $message, $pay_type, $book_time, $deliver_type, $act_ticket,$user_name,$telphone);
		if($result == false){
			json_error(20710, array('msg'=>C('ERR_CODE.20710')));//订单生成失败
		}else{			
			
			//生成订单自动收藏店铺
			$Shopuser = D('Home/ShopUser');
			//检测店铺是否已收藏
			$is_fav = $Shopuser->isFav($this->uid, $shop_id);
			$vshop_id = 0;
			//收藏店铺
			if(!$is_fav){
				$vshop_id = $shop_id;
				//$Shopuser->Fav($this->uid, $shop_id);
			}
			
			$share_arr = array();
			$share_arr['title'] = '哈哈镜订单分享,红包嗨起来';
			$share_arr['content'] = '~哈哈镜给您派大奖~ 快来刮分千万红包优惠券吧！！！手慢无哦~~';
			$share_arr['url'] = 'http://www.hahajing.com/activity/app_envelope';		

			if($pay_type != 40){//线上支付方式
				$Order = D('Home/OrderNew');
				$orderinfo = $Order->getInfoByNo($result);
				$data = array();
				$data['order_no']=$result;				
				$data['order_title'] = '订单标题';
				$data['order_desc'] ='订单描述';
				$data['total_amount'] = $orderinfo['total_amount'];
				$data['is_available'] = '1'; //是否为支付订单   0为否  1为是
				$data['pay_status'] = C('PAY_STATUS');
				$data['share'] = $share_arr;
				$data['vshop_id'] = $vshop_id;
				json_success($data);
			}else{
				$data = array();
				$data['order_no']=$result;
				$data['order_title'] = '';
				$data['order_desc'] ='';
				$data['total_amount'] = 0;
				$data['is_available'] = 0; //是否为支付订单   0为否  1为是
				$data['pay_status'] = 0;
				$data['share'] = $share_arr;
				$data['vshop_id'] = $vshop_id;
				json_success($data);
			}
		}
	}
	
	/**
	 * 获取可用优惠券列表
	 * @param 商品列表 $googs_array
	 * @param 省份id $province_id
	 * @param 城市id $city_id
	 * @return array | boolean
	 */
	private function get_ticket_list($googs_array, $province_id=0, $city_id=0, $is_vip=-1){
		//可用优惠券列表
		$list = array();
		//北京市非vip店不可以使用优惠券
		if($city_id == 133 && $is_vip==0){
			return null;
		}
	
		$Ticket = D('Home/Ticket');
		//1优惠券状态位判断
		$ticket_list = $Ticket->getUsableList($this->uid, 2);
		//json_success($ticket_list);
		if($ticket_list){
			foreach($ticket_list as $val){
				
				$goods_ext = json_decode($val['goods_ext']);//限制数据
				//2优惠券使用区域判断 *************begin****************
				$rang_flag = false;
				//区域类型 1全国 2省 3市
				if($val['range_type'] == '1'){
					$rang_flag = true;
				}else if($val['range_type'] == '2'){
					$rang = json_decode($val['range_ext']);
					if(is_array($rang) && in_array($province_id, $rang)){
						$rang_flag = true;
					}
				}else if($val['range_type'] == '3'){
					$rang = json_decode($val['range_ext']);
					if(is_array($rang) && in_array($city_id, $rang)){
						$rang_flag = true;
					}
				}
				if($rang_flag == false) continue;	
				//2优惠券使用区域判断 *************end****************			
					
				//3优惠券使用时间判断 *************begin****************
				$time1 = strtotime($val['begin_time']);
				$time2 = strtotime($val['end_time']);
				$now = time();
				$sort_list = null;
				if($now>$time1 && $now<$time2){					
					$sort_list = $goods_ext->ids;
				}
				//3优惠券使用时间判断 *************end****************		
	
				//4优惠券商品起步金额判断 *************begin****************
				if($sort_list){
					$_goods_amount = 0;//待优惠商品
					foreach($googs_array as $goods){
						if(in_array($goods['goods_sort'],$sort_list) && !in_array($goods['goods_id'], $goods_ext->exclude_goods)){
							$_goods_amount += floatval($goods['price'])*intval($goods['count']);
						}
					}
					//Log::write('------------- amount='.$_goods_amount.' price='.$val['price']);
					if($_goods_amount >= $val['price']){//大于起步金额
						$_data = array();
						$_data['ticket_id'] = $val['ticket_id'];
						$_data['act_name'] = $val['act_name'];
						$_data['act_desc'] = $val['act_desc'];
						$_data['notes'] = $val['notes'];						
						$_data['ticket_price'] = $val['discount_price'];//优惠券面值
						$_data['start_price'] = $val['price'];//起步金额
						$_data['discount_price'] = $val['discount_price'];//优惠金额
						if($val['goods_id']){//实物券时 优惠金额为0
							$_data['discount_price'] = 0;
						}
						$_data['label'] = $val['label'];
						$_data['start_date'] = $val['begin_time'];
						$_data['end_date'] = $val['end_time'];						
						$list[] = $_data;//向优惠券列表中添加优惠券
					}
				}
				//4优惠券商品起步金额判断 *************end****************
			}
		}
	
		return count($list)==0 ? null : $list;
	}
		
	/**
	 * 商品计算
	 * @param 商店id $shop_id
	 * @param 运费 $post_fee
	 * @param 购物车id $cart_ids
	 * @param 优惠券id $ticket_id
	 * @param 省份id $province_id
	 * @param 城市id $city_id
	 * @param 计算类型 $type 0基本运算 1包含可用优惠券列表、预定时间列表
	 * @param 配送方式 $deliver_type 0送货上面 1到店自提
	 * @param 买赠券 $act_ticket 
	 * @return array
	 */
	private function goods_calculate($shop_id, $post_fee, $cart_ids, $ticket_id=0, $province_id=0, $city_id=0, $type=0, $deliver_type=0, $is_vip=-1,&$act_ticket=0){	
		$data = array();
		
		//活动查询
		$Activity = D('Home/Activity');
		$activity_list = $Activity->getList(1, 1);
		if($activity_list === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		//买X赠X
		$act_gift_list = filter_activity($activity_list, $province_id, $city_id);
		//优惠券处理
		$Ticket = D('Home/Ticket');
		$ticket_data = null;
		if($ticket_id){
			//北京市非vip店不可以使用优惠券
			if($city_id == 133 && $is_vip==0){
				json_error(20903, array('msg'=>C('ERR_CODE.20903')));//优惠券仅限VIP使用
			}
			
			$_ticket_data = $Ticket->getInfoById($ticket_id);
			//确保优惠券的归属人及状态位正确
			if($_ticket_data && $_ticket_data['user_id']==$this->uid && $_ticket_data['status']==0){
				$activity_data = $Activity->getInfoById($_ticket_data['act_id']);
			    //优惠券的隶属活动有效性校验
			    if($activity_data && $activity_data['status'] == 1){
			    	//优惠券使用时间校验
			    	$time1 = strtotime($_ticket_data['begin_time']);
			    	$time2 = strtotime($_ticket_data['end_time']);
			    	$now = time();
			    	if($now>$time1 && $now<$time2){
			    		$ticket_data = $_ticket_data;
			    		$goods_ext = json_decode($activity_data['goods_ext']);//限制数据
			    		//优惠券使用的商品分类限制
			    		$ticket_data['sort_list'] = $goods_ext->ids;
			    		$ticket_data['exclude_goods'] = $goods_ext->exclude_goods;
			    	}	
			    }
			}
			
			if(!$ticket_data){
				json_error(20711, array('msg'=>C('ERR_CODE.20711')));//优惠券不存在或失效
			}
		}
		
		//优惠金额
		$data['discount'] = 0;
		//赠品
		$data['gift_goods'] = array();		
		//订单列表
		$Cart = D('Home/Cart');
		$cart_list = $Cart->getList($this->uid, $shop_id, $cart_ids, 'asc');
		if($cart_list === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		if($cart_list){
			//商品列表
			$googs_array = array();
			$ShopGoods = D('Home/ShopGoods');
			$goods_amount = 0;//商品金额
			$_goods_amount = 0;//待优惠商品
			$total_quantity = 0;//商品数量			
			foreach ($cart_list as $val){
				$cart_data = array();
				$cart_data['cart_id'] = $val['cart_id'];
				$cart_data['goods_id'] = $val['goods_id'];
				$cart_data['goods_name'] = $val['goods_name'];
				if($val['goods_sort']>5){
					$cart_data['goods_weight'] = $val['goods_spec']; //重量。自营商品规格(ml)
					$cart_data['goods_unit'] = ''; //HHJ商品  规格单位(盒)
					$cart_data['goods_pungent'] = $val['goods_brandname']; //HHJ商品  规格口味
				}else{
					$cart_data['goods_weight'] = $val['goods_weight']; //重量。HHJ商品
					$cart_data['goods_unit'] = $val['goods_unit']; //HHJ商品  规格单位(盒)
					$cart_data['goods_pungent'] = get_goods_pungent($val['goods_pungent']); //HHJ商品  规格口味
				}
				$cart_data['goods_pic'] = C('IMG_HTTP_URL').$val['goods_pic3'];
				$cart_data['count'] = $val['count'];				
				$shop_goods_data = $ShopGoods->getShopGoodsInfo($val['shop_id'], $val['goods_id']);
				if($shop_goods_data){
					$cart_data['price'] = $shop_goods_data['shopgoods_price'];
					$cart_data['goods_sort'] = $shop_goods_data['shopgoods_sort'];
					//计算优惠分类中的商品金额
					if($ticket_data && in_array($shop_goods_data['shopgoods_sort'], $ticket_data['sort_list']) && !in_array($val['goods_id'], $ticket_data['exclude_goods'])){
						$_goods_amount += floatval($cart_data['price'])*intval($cart_data['count']);
					}
				}else{
					json_error(20709, array('msg'=>C('ERR_CODE.20709')));//价格参数获取失败
				}
		
				$goods_amount += floatval($cart_data['price']) * intval($cart_data['count']);
				$total_quantity += intval($cart_data['count']);
				$googs_array[] = $cart_data;
			}
			
			$Goods = D('Home/Goods');
			//买x赠x 赠品添加 ----------------begin------------------------
			foreach ($act_gift_list as $gift){
				$goods_ext = json_decode($gift['goods_ext']);//商品限制
				$_goods_gift_num = 0;
				foreach ($cart_list as $val){					
					if($gift['gift_ext']){									
						//赠品判断
						$is_gift = false;						
						if($gift['goods_type']==2){//根据分类
							$_goods_data = $Goods->getInfoById($val['goods_id']);							
							if($_goods_data && in_array($_goods_data['goods_sort'], $goods_ext->ids) && !in_array($val['goods_id'], $goods_ext->exclude_goods)){
								$is_gift = true;
							}							
						}else if($gift['goods_type']==3){ //根据买赠活动中的商品id数组，对商品类别进行过滤
							if(in_array($val['goods_id'], $goods_ext->ids)){
								$is_gift = true;
							}
						}
					
						//如果有赠品
						if($is_gift) $_goods_gift_num = $_goods_gift_num + $val['count'];
					}					
				}
				
				//买赠配置信息
				$ext = json_decode($gift['gift_ext']);
				//Log::write('$ext->buy_num = '.$ext->buy_num);
				$gift_goods = $Goods->getInfoById($ext->goods_id);
				$gift_data = array();
				$gift_data['goods_id'] = $ext->goods_id;
				$gift_data['goods_name'] = '[赠]'.$gift_goods['goods_name'];
				$gift_data['goods_pic'] = C('IMG_HTTP_URL').$gift_goods['goods_pic3'];
				//赠品数量
				//Log::write('$ext->bud_num = '.$ext->buy_num);
				//Log::write('count/bud_num = '.intval($val['count'] / $ext->buy_num));
				Log::write('$_goods_gift_num = '.$_goods_gift_num);
				$gift_data['count'] = intval($_goods_gift_num / $ext->buy_num) * $ext->gift_num;
				$gift_data['price'] = '0.00';
				if($gift_data['count']){
					$data['gift_goods'][] = $gift_data;
				}
			}			
			//买x赠x 赠品添加 ----------------end------------------------
			
			//新版买赠 赠品添加 ----------------begin---------------------
			//保证旧版买赠无效
			if(empty($act_gift_list) && $act_ticket){
				$_list = $Activity->getList(3,1);
				//根据店铺地址信息过滤活动
				$_activity_list = filter_activity($_list, $province_id, $city_id);
				if(count($_activity_list)>0){
					$Ticket = D('Home/Ticket');
					$map = array();
					$map['ticket_id'] = $act_ticket;
					$map['user_id'] = $this->uid;
					$now = date('Y-m-d H:i:s');
					$map['begin_time'] = array('lt', $now);
					$map['end_time'] = array('gt', $now);
					
					//获取买赠券列表
					$act_ticket_data = $Ticket->getTicketListByWhere($map);
					if($act_ticket_data){
						//获取赠品信息
						$_goods_list = $this->add_gifts($_activity_list[0], $act_ticket_data, $googs_array);
						if(count($_goods_list)>count($googs_array)){
							//$data['gift_goods'] = $gift_list;
							$googs_array = $_goods_list;
						}else{
							$act_ticket = 0;
						}
					}
				}
			}			
			//新版买赠 赠品添加 ----------------end-----------------------

			if($ticket_data){
				if($_goods_amount >= $ticket_data['price']){//大于起步金额
					if($ticket_data['goods_id']){//实物券
						$gift_goods = $Goods->getInfoById($ticket_data['goods_id']);
						$gift_data = array();
						$gift_data['goods_id'] = $ext->goods_id;
						$gift_data['goods_name'] = '[赠]'.$gift_goods['goods_name'];
						$gift_data['goods_pic'] = C('IMG_HTTP_URL').$gift_goods['goods_pic3'];
						$gift_data['count'] = 1;
						$gift_data['price'] = '0.00';
						$data['gift_goods'][] = $gift_data;
						
						$data['discount'] = 0;
					}else{//抵金券
						$data['discount'] = $ticket_data['discount_price']; 
					}
				}else{
					json_error(20712, array('msg'=>C('ERR_CODE.20712')));//优惠券未满足使用条件
				}
			}
				
			//商品列表
			$data['goods_list'] = $googs_array;
			//商品数量
			$data['total_quantity'] = $total_quantity;
			//商品总价格
			$data['goods_amount'] = $goods_amount;
		}else{			
			json_error(20701, array('msg'=>C('ERR_CODE.20701')));//商品不存在
		}		
		
		//可用优惠券列表
		if($type) $data['ticket_list'] = $this->get_ticket_list($googs_array, $province_id, $city_id, $is_vip);

		//运费
		$data['post_fee'] = floatval($post_fee);
		if($data['goods_amount']>=200){
			$data['post_fee'] = 0;
		}
		
		//价格计算
		if($deliver_type){
			$data['total_amount'] = $data['goods_amount'] - $data['discount'];
			//$data['total_amount'] = $data['total_amount']; //应付金额
			$data['total_paid'] = '0.00'; //实付金额
		}else{
			$data['total_amount'] = $data['goods_amount'] + $data['post_fee'] - $data['discount'];
			//$data['total_amount'] = $data['total_amount']; //应付金额
			$data['total_paid'] = '0.00'; //实付金额
		}
		$data['total_amount'] = $data['total_amount'] > 0 ? $data['total_amount'] : 0;

		return $data;
	}
	
	/**
	 * 生成新订单
	 * @param 收货地址id $address_id
	 * @param 店铺id $shop_id
	 * @param 用户留言 $message
	 * @param 支付类型 $pay_type
	 * @param 预定时间 $book_time
	 * @param 配送方式 $deliver_type
	 * @return boolean
	 */
	private function add_order($address_id, $shop_id, $cart_ids, $ticket_id, $message, $pay_type, $book_time, 
			$deliver_type, $act_ticket,$user_name='',$telphone=''){
		//Log::write("deliver_type => ".$deliver_type);
		//获取收货地址

		$Address = D('Home/UserAddress');
		$address_data = $Address->getInfoById($address_id, $this->uid);
		if($address_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		if(!$address_data) json_error(20707, array('msg'=>C('ERR_CODE.20707')));//收货地址不存在		
		
		$Shop = D('Home/Shop');
		$shop_data = $Shop->getInfoById($shop_id);
		if($shop_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		if(!$shop_data) json_error(20708, array('msg'=>C('ERR_CODE.20708')));//店铺不存在
		if(!$shop_data['shop_deliverscope']){
			if(!$deliver_type) json_error(20719, array('msg'=>C('ERR_CODE.20719')));//店铺配送距离为0时 不能下送货上闷订单,请下到店自提
		}

		//商品计算
		$goods_data = $this->goods_calculate($shop_id, $shop_data['shop_deliverfee'], $cart_ids, $ticket_id, $shop_data['shop_province'], $shop_data['shop_city'], 0, $deliver_type , $shop_data['shop_isvip'], $act_ticket);
		
		//大于起送金额
		if($shop_data['shop_updeliverfee']>$goods_data['goods_amount']){
			//Log::write("deliver_type => ".$deliver_type);
			//送货上门才有起送金额
			if(empty($deliver_type)){
				json_error(20716, array('msg'=>C('ERR_CODE.20716'))); //商品金额小于起送金额
			}
		}
		
		//判断代售点不能下单
		if($shop_data['shop_type'] == 1){
			json_error(20717, array('msg'=>C('ERR_CODE.20717')));//此店已不支持网上下单
		}
		//1正常营业 2不可下单 3关店
		if($shop_data['shop_status'] > 1){
			json_error(20718, array('msg'=>C('ERR_CODE.20718')));//放假中,暂不配送哦!
		}
		
		$order_data = array();
		$order_data['order_no'] = get_order_no($this->os);
		$order_data['user_id'] = $this->uid;
		$order_data['user_name'] = $address_data['useraddress_name']; //收货人姓名
		$order_data['mobile'] = $address_data['useraddress_phone']; //收货手机号
		$order_data['province'] = $address_data['province_name']; //收货省份
		
		$order_data['city'] =  $address_data['city_name']; //收货城市
		$order_data['district'] = $address_data['useraddress_district']; //收货区域
		
		$order_data['address_id'] = $address_id; //地址ID
		$order_data['address'] = $address_data['useraddress_address']; //详细地址		
		$order_data['user_messge'] = $message; //用户留言		
		$order_data['total_quantity'] = $goods_data['total_quantity']; //商品总数
		$order_data['goods_amount'] = $goods_data['goods_amount']; //商品总金额
		
		$order_data['ticket_id'] = $ticket_id; //优惠券id
		$order_data['act_ticket'] = $act_ticket; //活动券id
		$order_data['discount'] = $goods_data['discount']; //优惠费用		
		$order_data['total_amount'] = $goods_data['total_amount']; //应付金额
		$order_data['total_paid'] = $goods_data['total_paid']; //实付金额
		
		$order_data['source'] = get_source_id($this->os); //实付金额
		$order_data['order_status'] = 1; //新订单
		$order_data['trade_no'] = ''; //交易编号
		$order_data['pay_type'] = $pay_type; //支付类型 10微信支付  20支付宝支付  30银行卡支付  40货到付款  50转账汇款  90其他
		if($pay_type != 40){ //非货到付款40 时 支付状态为10等待支付
			$order_data['pay_status'] = 10;
		}else{
			$order_data['pay_status'] = 90; //支付状态 10等待支付 20支付进行中 30支付成功 40支付失败 50退款 90其他
		}
		
		$order_data['pay_time'] = 0;//支付时间 默认为0
		$order_data['shop_id'] = $shop_id;
		if($deliver_type){
			$order_data['deliver_type'] = 1; //配送方式 0送货上面 1到店自提
			$order_data['post_fee'] = 0;
		}else{
			$order_data['deliver_type'] = 0;
			$order_data['post_fee'] = $goods_data['post_fee']; //运费
		}
		
		if(trim($book_time)){
			$order_data['is_book'] = 1; //是否预定 0否 1是			
			$order_data['book_time'] = $book_time; //预约时间 2015-11-22 11:00-12:00
		}else{
			$order_data['is_book'] = 0; //是否预定 0否 1是
			$order_data['book_time'] = ''; //预约时间 2015-11-22 11:00-12:00
		}		
		$order_data['confirm_time'] = 0; //商户确认时间
		$order_data['add_time'] = time(); //订单生成时间

		$Order = D('Home/OrderNew');
		$result = $Order->add($order_data); //生成新订单
		if($result){
			//订单详情
			$OrderGoods = D('Home/OrderGoods');	
			foreach($goods_data['goods_list'] as $val){
				$order_goods_data = array();
				$order_goods_data['order_no'] = $order_data['order_no'];
				$order_goods_data['user_id'] = $this->uid;
				$order_goods_data['goods_id'] = $val['goods_id'];
				$order_goods_data['goods_name'] = $val['goods_name'];
				$order_goods_data['goods_pic'] = str_replace(C('IMG_HTTP_URL'), '', $val['goods_pic']);
				$order_goods_data['goods_price'] = $val['price'];
				$order_goods_data['price'] = $val['price'];
				$order_goods_data['count'] = $val['count'];
				$order_goods_data['type'] = isset($val['type'])?$val['type']:1;
				$order_goods_data['notes'] = '';
				$OrderGoods->add($order_goods_data);
			}
			
			foreach($goods_data['gift_goods'] as $val){
				$order_goods_data = array();
				$order_goods_data['order_no'] = $order_data['order_no'];
				$order_goods_data['user_id'] = $this->uid;
				$order_goods_data['goods_id'] = $val['goods_id'];
				$order_goods_data['goods_name'] = $val['goods_name'];
				$order_goods_data['goods_pic'] = str_replace(C('IMG_HTTP_URL'), '', $val['goods_pic']);
				$order_goods_data['goods_price'] = 0;
				$order_goods_data['price'] = 0;
				$order_goods_data['count'] = $val['count'];
				$order_goods_data['type'] = 0;
				$order_goods_data['notes'] = '';
				$OrderGoods->add($order_goods_data);
			}
			
			$Ticket = D('Home/Ticket');
			//优惠券
			if($ticket_id){				
				$Ticket->edit(array('ticket_id'=>$ticket_id), array('status'=>1,'use_time'=>time()));
			}
			//买赠券
			if($act_ticket){
				$Ticket->edit(array('ticket_id'=>$act_ticket), array('status'=>1,'use_time'=>time()));
			}
			
			//订单日志
			$OrderLog = D('Home/OrderLog');
			$order_log_data = array();
			$order_log_data['order_no'] = $order_data['order_no'];
			$order_log_data['log_type'] = 1;//日志类型 操作
			$order_log_data['oper_type'] = 1;//操作人类型 用户
			$order_log_data['oper_name'] = '用户';
			$order_log_data['oper_id'] = $this->uid;
			$order_log_data['action_type'] = 1;//生成订单
			$order_log_data['log_info'] = '订单提交成功';
			$order_log_data['log_desc'] = "订单编号：{$order_data['order_no']}"; //,店铺：{$shop_data['shop_name']}
			$order_log_data['add_time'] = time();			
			$OrderLog->add($order_log_data);
			
			//后台订单日志
			$order_log_admin = array();
			$order_log_admin['order_no'] = $order_data['order_no'];
			$order_log_admin['log_type'] = 1;//日志类型 操作
			$order_log_admin['oper_type'] = 1;//操作人类型 用户
			$order_log_admin['oper_name'] = '用户';
			$order_log_admin['oper_id'] = $this->uid;
			$order_log_admin['action_type'] = 0;//生成订单
			$order_log_admin['log_info'] = '订单提交成功';
			$order_log_admin['log_desc'] = "店铺：{$shop_data['shop_name']}"; //,店铺：{$shop_data['shop_name']}
			$order_log_admin['add_time'] = time();				
			$OrderLog->add($order_log_admin);
			
			//发送店铺通知
			$this->send_shop_message($shop_data, $address_data, $order_data['order_no'] ,$goods_data['goods_amount']);
			
			//删除购物车中冗余信息
			$Cart = D('Home/Cart');
			$Cart->del($this->uid, $cart_ids);
			
			return $order_data['order_no'];
		}
		
		return false;
	}	
	
	/**
	 * 发送店铺通知
	 */
	private function send_shop_message($shop_data, $address_data ,$order_no ,$goods_amount){
		//推送通知+短信
		vendor('Jpush.jpush'); //商品总金额
		$jpush = new \Jpush(C('JPUSH_SHOP_APPKEY'), C('JPush_SHOP_masterSecret'), C('JPush_url'));
		$send  = array('alias'=>array($shop_data['shop_account']));
		$res = $jpush->shopPush($send,'老板:您有一个新订单,点击处理-> ->',1,1,'','86400','speech.caf');
		Log::write("jpushRes => ".$res);
			
		$content = '老板:您有一个新订单，订单号'.$order_no.',商品总金额'.$goods_amount.'元,收货人'.$address_data['useraddress_name'].',电话'.$address_data['useraddress_phone'].',请尽快处理哦 !';
		send_sms($shop_data['shop_contact'], $content);
		Log::write("sms => ".$shop_data['shop_contact']);
	}
	
	/**
	 * 计算买赠活动，特殊处理
	 * @param unknown $activity 活动
	 * @param unknown $ticket_data
	 * @param unknown $cart_list
	 * @return multitype:multitype:string number NULL
	 */
	private function add_gifts($activity_data, $ticket_data, $goods_list){
		$_goods_list = array();
		if($ticket_data){
			$Goods = D('Home/Goods');
			$ShopGoods = D('Home/ShopGoods');			
			//限制数据
			$goods_ext = json_decode($activity_data['goods_ext']);
			$gift_ext = json_decode($activity_data['gift_ext']);
			$ticket_amount = floatval($ticket_data['price']);//优惠价格区间

			foreach ($goods_list as $val){
				//赠品判断
				$is_gift = false;
				if($activity_data['goods_type']==2){//根据分类
					if(in_array($val['goods_sort'], $goods_ext->ids) && !in_array($val['goods_id'], $goods_ext->exclude_goods)){
						$is_gift = true;
					}
				}else if($activity_data['goods_type']==3){ //根据买赠活动中的商品id数组，对商品类别进行过滤
					if(in_array($val['goods_id'], $goods_ext->ids)){
						$is_gift = true;
					}
				}
			
				if($is_gift){
					//商品数量
					$_gift_num = 0;
					for ($i=0; $i<$val['count']; $i++) {
						$ticket_amount -= floatval($val['price']);
						if($ticket_amount >= 0) {
							$_gift_num += 1;
						}else{
							break;
						}
					}
					
					if($ticket_amount>0){					 
						$_gift_id = $gift_ext->gift_id;
						//特殊赠品处理
						$_exclude_gift_list = $gift_ext->exclude_gift;
						if($_exclude_gift_list){
							foreach ($_exclude_gift_list as $_gift){
								if($_gift->goods_id == $val['goods_id']){
									$_gift_id = $_gift->gift_id;
									break;
								}
							}
						}
						
						$_num = $val['count'] - $_gift_num;
						$val['count'] = $_gift_num;
						$_goods_list[] = $val;
						
						$gift_goods = $Goods->getInfoById($_gift_id);
						$_gift_arr = $val;
						$_gift_arr['goods_id'] = $_gift_id;
						$_gift_arr['goods_name'] = '[赠]'.$gift_goods['goods_name'];
						$_gift_arr['goods_pic'] = C('IMG_HTTP_URL').$gift_goods['goods_pic3'];
						$_gift_arr['count'] = $_gift_num;
						$_gift_arr['price'] = '0.00';
						$_gift_arr['type'] = 2;
						$_goods_list[] = $_gift_arr;									
						if($_num){
							$val['count'] = $_num;
							$_goods_list[] = $val;						
						}	
					}else{
						$_goods_list[] = $val;
					}		
				}else{
					$_goods_list[] = $val;
				}
			}				
		}
		
		return $_goods_list;
	}

	/**
	 * 订单重新支付
	 * @param 订单编号 order_no
	 */
	public function pay_again(){
		$order_no = I('post.order_no', ''); //订单编号
		
		//订单编号不能为空
		if(empty($order_no)) json_error(20703, array('msg'=>C('ERR_CODE.20703')));
		
		$Order = D('Home/OrderNew');
		$order_data = $Order->getInfoByNo($order_no);
		if($order_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
		
		$data = array();
		$data['order_no'] = $order_data['order_no'];        //订单编号
		$data['order_title'] = '订单标题';                  //订单标题
		$data['order_desc'] = '订单描述';
		$data['total_amount'] = $order_data['total_amount']; //订单金额
		if(is_array($order_data['pay_status'], array(10,40))){                
			$data['is_available'] = '1';                   //可支付订单
		}else{
			$data['is_available'] = '0';                   //不可付订单
		}
		$data['pay_status'] = C('PAY_STATUS');             //线上支付开关
		
		$order_data = $data;
		
		json_success($order_data);
	}
	

}