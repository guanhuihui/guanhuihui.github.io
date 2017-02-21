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
 * 订单模型
 */
class OrderNewModel{
	
	/** 
	 * 订单信息
	 */
	public function getInfoById($order_id){
		if(empty($order_id)){
			return false;
		}
	
		$Order = M('OrderNew');
		$map['order_id'] = $order_id;
		$data = $Order->where($map)->find();
	
		return $data;
	}
	
	public function getInfoByNo($order_no){
		if(empty($order_no)){
			return false;
		}
	
		$Order = M('OrderNew');
		$map['order_no'] = $order_no;
		$data = $Order->where($map)->find();
	
		return $data;
	}
	
	/**
	 * 添加订单信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Order = M('OrderNew');
		$result = $Order->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除订单
	 */
	public function del($order_id) {
		if (empty($order_id)) {
			return false;
		}
	
		$Order = M('OrderNew');
		$where['order_id'] = $order_id;
		$result = $Order->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改订单信息
	 */
	public function edit($where, $data){
		if(empty($where)||empty($data)){
			return false;
		}

		$Order = M('OrderNew');
		$result = $Order->where($where)->save($data);
		return $result;
	}
	
	/**
	 * 用户删除订单
	 * @param 用户id $user_id
	 * @param 订单id $order_id
	 * @return boolean
	 */
	public function userDel($user_id, $order_id){
		if(empty($user_id) && empty($order_id)){
			return false;
		}
	
		$map = array();
		$map['order_id'] = $order_id;
		$map['user_id'] = $user_id;
		$map['order_status'] = array('exp',' IN (1,6,7,8) ');
		$map['is_del'] = 0;
	
		$data = array();
		$data['is_del'] = 1;
		$result = $this->edit($map, $data);
		return $result;
	}
	
	/**
	 * 用户取消订单
	 * @param 用户id $user_id
	 * @param 订单id $order_id
	 * @return boolean
	 */
	public function userCancel($user_id, $order_id){
		if(empty($user_id) && empty($order_id)){
			return false;
		}
	
		$map = array();
		$map['order_id'] = $order_id;
		$map['user_id'] = $user_id;
		$map['order_status'] = 1;
		$map['is_del'] = 0;
		
	
		$data = array();
		$data['order_status'] = 6;//取消
		$result = $this->edit($map, $data);
		return $result;
	}
	
	/**
	 * 用户确认收货
	 * @param 用户id $user_id
	 * @param 订单id $order_id
	 * @return boolean
	 */
	public function userComplete($user_id, $order_id){
		if(empty($user_id) && empty($order_id)){
			return false;
		}
	
		$map = array();
		$map['order_id'] = $order_id;
		$map['user_id'] = $user_id;
		$map['order_status'] = 5;
		$map['is_del'] = 0;
	
		$data = array();
		$data['order_status'] = 8;//订单完成
		$result = $this->edit($map, $data);
		return $result;
	}

	/**
	 * 根据用户id获取订单列表
	 * @param 用户id $user_id
	 * @param 起始订单id $order_id
	 * @param 单页数目 $page_num
	 * @param 是否删除-1全部 $is_del
	 * @return array
	 */
	public function getUserList($user_id, $order_id=0, $page_num=10, $is_del=-1){
		if (empty($user_id)) {
			return false;
		}
		
		$map = array();
		$map['user_id'] = $user_id; 
		if($order_id){
			$map['order_id'] = array('lt', $order_id);
		}		
		if($is_del==0){
			$map['is_del'] = 0;
		}
		
		$Order = M('OrderNew');
		$list = $Order->where($map)->limit($page_num)->order('order_id desc')->select();
		return $list;
	}
	
	/**
	 * 根据用户id获取订单列表
	 * @param $shop_id 商户id
	 * @param $status 订单状态    1新订单  5已发货 8已完成
	 * @param $page 页码
	 * @return $pagesize 每页数量
	 */
	public function getShopList($shop_id, $status, $page = 1, $pagesize = 20){
		if (empty($shop_id)) {
			return false;
		}
		
		//当前
		$time   = time();
		//近7天
		$seven  = strtotime("-7 days");
		//近30天
		$thirty = strtotime("-30 days");
		
		$startrow = ($page - 1) * $pagesize;
		
		//检查订单状态
		$orderstatus = array(1, 5, 8);
		if(!in_array($status, $orderstatus))	return -1;
		
		$map = array();
		$map['shop_id'] = $shop_id;
		if($status == 1){
			$map['order_status'] = array('in','1,3');
		}else{
			$map['order_status'] = $status;
		}
		
		$map['add_time'] = array('egt',$thirty);
		
	
		$Order = M('OrderNew');
		$list = $Order->where($map)->limit($startrow, $pagesize)->order('order_id desc')->select();
		if($list){
			
			$re_list=array();
			foreach($list as $key => $val){
				//筛选线上支付的订单，未支付成功的不提示商户
				if($status == 1){
					if($val['pay_type']!=40 && $val['pay_status']!=30){
						unset($list[$key]);
					}else{
						$re_list[]=$list[$key];
					}
				}else{
					$re_list = $list;
				}
			}
			
			$re = array();
			foreach($re_list as $rk => $rv){
				
				$re[$rk]['code'] = $rv['order_no'];
				$re[$rk]['username'] = $rv['user_name'];
				$re[$rk]['ordertime'] = date('Y-m-d H:i:s', $rv['add_time']);
				$re[$rk]['usermessge'] = $rv['user_messge'];  //用户留言
				$re[$rk]['mobile'] = $rv['mobile']; //收货手机号
				if($rv['deliver_type'] == 1){//配送方式
					$re[$rk]['address'] = '';
				}else{
					$re[$rk]['address'] = $rv['city'].$rv['district'].$rv['address'];
				}
					
				$re[$rk]['goods_amount'] = $rv['goods_amount'];  //商品总金额
				$re[$rk]['discount'] = $rv['discount'];   //优惠费用
				$deliver_type = $rv['deliver_type'];
				$re[$rk]['deliver_type'] = C("ORDER_deliver_TYPE.$deliver_type");  //配送方式 
				$re[$rk]['isbook'] = $rv['is_book'];  //是否预定
				
				if($rv['is_book']){
					//$booktime = json_decode($rv['book_time']);
					if($rv['book_time'] == '到店自提'){
						$re[$rk]['booktime'] = '';
					}else{
						$re[$rk]['booktime'] = $rv['book_time'];
					}
				}else{
					$re[$rk]['booktime'] = '即时配送';
				}
				//是否使用优惠券
				if(empty($rv['ticket_id'])){
					$re[$rk]['isticket'] = 0;
				}else{
					$re[$rk]['isticket'] = 1;
				}
				
				$re[$rk]['post_fee'] = $rv['post_fee'];  //运费
				$re[$rk]['total_amount'] = $rv['total_amount'];  //实付金额
				$paytype=$rv['pay_type'];
				$re[$rk]['paytype'] = C("ORDER_PAY_TYPE.$paytype");  //付款方式
				$re[$rk]['paytime'] = !empty($rv['pay_time'])?date('Y-m-d H:i', $rv['pay_time']):'';//支付时间
				
				$deliveryman = self::getDeliverByCode($rv['order_no'],$rv['order_status']);  //操作人员
				
				//获取配送员
				if($rv['order_status'] ==0 || $rv['order_status'] ==2 || $rv['order_status'] ==4){
					$re[$rk]['deliveryman'] = $deliveryman;//操作人员
				}else{
					$re[$rk]['deliveryman'] = "";
				}
				
				//获取购买商品
				$cartinfo = self::getGoodsByOrderNo($rv['order_no']);
				$re[$rk]['cartinfo'] = $cartinfo;
				
			}
		}
		return $re;
	}
	
	/**
	 * 根据用户id获取订单列表
	 * @param $shop_id 商户id
	 * @param $status 订单状态    1新订单 5已发货 8已完成
	 */
	public function getShopCount($shop_id, $status){
		if (empty($shop_id)) {
			return false;
		}
		
		$map = array();
		$map['shop_id'] = $shop_id;
		
		if($status == 1){
			$map['order_status'] = array('in','1,3');
		}else{
			$map['order_status'] = $status;
		}
		//近30天
		$thirty = strtotime("-30 days");
		$map['add_time'] = array('egt',$thirty);
		$Order = M('OrderNew');
		$count = $Order->where($map)->count();
		$rs = array();
		$rs['count'] = $count;
		
		$totalfee = $Order->where($map)->sum("total_amount");
		if(empty($totalfee)){
			$rs['totalfee'] = 0;
		}else{
			$rs['totalfee'] = $totalfee;
		}
		return $rs;
	}
	
	/**
	 * 根据用户id获取订单列表
	 * @param $order_code 订单号
	 * @param $status 订单状态    0新订单 1商户拒单 2已发货  4已取消 5已完成
	 */
	public function getDeliverByCode($order_code, $status){
		
		$map = array();
		$map['order_no'] = $order_code;
		if($status == 0){
			$map['action_code'] = 1;
		}else if($status == 2){
			$map['action_code'] = 3;
		}else if($status == 4){
			$map['action_code'] = 4;
		}
		
		$OrderLog = M('OrderLog');
		$rs = $OrderLog->where($map)->order('log_id desc')->find();
		if($rs){
			return $rs['oper_name'].':'.$rs['log_info'];
		}else{
			return '';
		}
	}
	
	/**
	 * 根据订单号获取订单商品
	 * @param $order_code 订单号
	 */
	public function getGoodsByCode($order_code){
	
		$map = array();
		$map['order_no'] = $order_code;
		
	
		$OrderGoods = M('OrderGoods');
		$rs = $OrderGoods->where($map)->order('detail_id asc')->select();
		if($rs){
			$r = array();
			foreach($rs as $rk=>$rs){
				$r[$rk]['goodsid'] = $rs['goods_id'];
				//查询商品信息
				$Goods = M('Goods');
				$where['goods_id'] = $rs['goods_id'];
				$goodsInfo = $Goods->where($where)->find();
				$r[$rk]['goodspic'] = !empty($rs['goods_pic'])? C("IMG_HTTP_URL").$rs['goods_pic']: '';
				$r[$rk]['goodsname'] = $rs['goods_name'];
				if($goodsInfo['goods_type'] == 0){
					$pungent = $goodsInfo['goods_pungent'];
					$r[$rk]['pungent'] = C("GOODS_PUNGENT.$pungent");
				}else
					$r[$rk]['pungent'] = !empty($goodsInfo['goods_brandname'])?$goodsInfo['goods_brandname']:'';
			
				$r[$rk]['price'] = $rs['price'];   //实付价格
				$r[$rk]['originprice'] = $rs['goods_price'];  //商品价格
				$r[$rk]['isgift'] = $rs['type'];  //商品类型 0默认 1赠品
				$r[$rk]['count'] = $rs['count'];   //数量
				$r[$rk]['type'] = $goodsInfo['goods_type'];    //1：自营，0：哈哈镜商品 
			}
			return $r;
		}else{
			return array();
		}
		
	}
	
	/**
	 * 根据优惠券获取订单信息
	 * $ticket_id
	 */
	public function getOrderInfoByTicket($ticket_id){
		
		if(empty($ticket_id)){
			return false;
		}
		
		$Order = M('OrderNew');
		$map['ticket_id'] = $ticket_id;
		$data = $Order->where($map)->find();
		
		return $data;
	}
	
	/**
	 * 获取订单数量
	 * @param integer $where 筛选条件，默认为空
	 * @return
	 */
	public function OrderCount($where=''){
	
		$OrderNew = M('OrderNew');
	
		$count = $OrderNew->where($where)->count();
	
		return $count;
	}
	
	/**
	 * 后台订单列表
	 */
	public function GetOrderList($where,$page,$pagesize){
		
		$OrderNew = M('OrderNew');
		$list = $OrderNew->where($where)->page($page,$pagesize)->order('order_id desc')->select();
		if($list){
			return $list;
		}else{
			return 0;
		}
	}
	
	/**
	 * 根据条件获取订单信息
	 */
	public function getOrderInfo($where){
		$OrderNew = M('OrderNew');
		$list = $OrderNew->where($where)->order('order_id desc')->select();
		if($list){
			return $list;
		}else{
			return 0;
		}
	}
	
	/**
	 * 获取订单数量
	 * @param integer $where 筛选条件，默认为空
	 * @return
	 */
	public function cityOrderCount($city = 0,$s = 0,$e = 0){
	
		$Model = M();
		
		$sql = "SELECT COUNT(order_id) as ordercount,city FROM hhj_order_new WHERE 1";
	
		if($city){
			$sql .= " AND city LIKE '%$city%'";
		}
		
		if($s && $e){
			$sql .= " AND add_time>=$s and add_time<= $e";
		}
		$sql .= ' GROUP BY city ORDER BY ordercount DESC';
		$row = $Model->query($sql);
		return $row;
	}
	
	/**
	 * 订单总金额
	 */
	public function totalPrice($start,$end,$city=''){
		$Model = M();
		
		$sql = "SELECT SUM(total_amount) as totalprice FROM hhj_order_new WHERE order_status = 8";
		
		if($start && $end){
			$sql .= " AND add_time >= $start AND add_time <= $end";
		}
		if($city){
			$sql .= " AND city = '$city'";
		}
		$row = $Model->query($sql);
		return $row[0]['totalprice'];
	}
	
	
	/**
	 * 获取用户最后一次订单地址
	 */
	public function getLastOrderAddress($user_id){
		if(empty($user_id)){
			return false;
		}
		
		$OrderNew = M('OrderNew');
		$map = array();
		$map['user_id'] = $user_id;
		$result = $OrderNew->where($map)->order('order_id desc')->find();
		
		return $result;
	}
	
	/**
	 * 查找在线支付，但是未成功订单总数
	 */
	public function paymentFailureCount($shopid){
		if(empty($shopid)){
			return false;
		}
		$OrderNew = M('OrderNew');
		$where['shop_id'] = $shopid;
		$where['pay_type'] = array('neq', 40);
		$where['pay_status'] = array('neq', 30);
		$where['order_status'] = array('eq', 1);
		//近30天
		$thirty = strtotime("-30 days");
		$where['add_time'] = array('egt',$thirty);
		$result = $OrderNew->where($where)->count();
		
		return $result;
	}
	
	/**
	 * 商户查询订单数 , 商品数, 及赠品数
	 * @param  shop_id  店铺ID
	 * @param  begin_time  开始时间
	 * @param  end_time  结束时间
	 */
	public function getOrderCount($shop_id, $begin_time, $end_time){
		if(empty($shop_id)){
			return false;
		}
		
		$OrderNew = M('OrderNew');
		
		$map = array();
		$map['shop_id'] = $shop_id;
		$map['act_ticket']  = array('neq',0); //新买赠券活动
		$map['order_status'] = 8;  //已完成订单
		$map['add_time']  = array('between',array($begin_time,$end_time)); //时间段条件
		
		$count = $OrderNew->where($map)->count(); //订单数
		$order_nos = $OrderNew->where($map)->field('order_no')->select(); //订单编号
		
		$data = array();
		$orders = array();
		
		if($order_nos){ //将订单编号 储存起来
			foreach($order_nos as $val){
				$orders[] = $val['order_no'];
			}
		}
		
		$data['order_count'] = $count;
		$data['order_nos'] = $orders;

		return $data;
	}
	
	/**
	 * 根据订单号获取排序后商品
	 * @param unknown $order_no
	 * @return unknown|multitype:
	 */
	public function getGoodsByOrderNo($order_no){
		$OrderGoods = M('OrderGoods');
		//购买商品
		$map['order_no'] = $order_no;
		$map['type'] = 1;
		$rs = $OrderGoods->where($map)->order('detail_id asc')->select();
		//赠送商品
		$gift_map['order_no'] = $order_no;
		$gift_map['type'] = array(array('eq',0),array('eq',2), 'or') ;
		$res = $OrderGoods->field('*,sum(count) as count')->where($gift_map)->order('detail_id asc')->group('goods_id')->select();
		if($res){
			//商品合并
			$result = array_merge($rs,$res);
		}else{
			$result = $rs;
		}
		
		if($result){
			$r = array();
			foreach($result as $rk=>$rs){
				$r[$rk]['goodsid'] = $rs['goods_id'];
				//查询商品信息
				$Goods = M('Goods');
				$where['goods_id'] = $rs['goods_id'];
				$goodsInfo = $Goods->where($where)->find();
				$r[$rk]['goodspic'] = !empty($rs['goods_pic'])? C("IMG_HTTP_URL").$rs['goods_pic']: '';
				$r[$rk]['goodsname'] = $rs['goods_name'];
				if($goodsInfo['goods_type'] == 0){
					$pungent = $goodsInfo['goods_pungent'];
					$r[$rk]['pungent'] = C("GOODS_PUNGENT.$pungent");
				}else
					$r[$rk]['pungent'] = !empty($goodsInfo['goods_brandname'])?$goodsInfo['goods_brandname']:'';
					
				$r[$rk]['price'] = $rs['price'];   //实付价格
				$r[$rk]['originprice'] = $rs['goods_price'];  //商品价格
				$r[$rk]['isgift'] = $rs['type'];  //商品类型 0默认 1赠品
				$r[$rk]['count'] = $rs['count'];   //数量
				$r[$rk]['type'] = $goodsInfo['goods_type'];    //1：自营，0：哈哈镜商品
			}
			return $r;
		}else{
			return array();
		}
	}
}