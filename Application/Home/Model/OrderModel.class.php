<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangpp at 2015/10/23
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;

/**
 * 订单模型 即将作废
 */
class OrderModel{
	
	/** 
	 * 订单信息
	 * @param 订单编号 $order_code
	 * @param 是否排序已删除订单 $excl_del
	 * @return array
	 */
	public function getInfoById($order_id, $excl_del=1){
		if(empty($order_id)){
			return false;
		}
	
		$Order = M('Order');
		$map = array();
		$map['order_id'] = $order_id;
		if($excl_del){
			$map['is_del'] = 0;
		}
		$data = $Order->where($map)->find();
	
		return $data;
	}
	
	/**
	 * 获取订单详情
	 * @param 订单编号 $order_code
	 * @param 是否排序已删除订单 $excl_del
	 * @return array
	 */
	public function getInfoByCode($order_code, $excl_del=1) {
		if (empty($order_code)){
			return false;
		}
		
		$Order = M('Order');
		$map = array();
		$map['order_code'] = $order_code;
		if($excl_del){
			$map['is_del'] = 0;
		}
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
	
		$Order = M('Order');
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
	
		$Order = M('Order');
		$where['order_id'] = $order_id;
		$result = $Order->where($where)->delete();
	
		return $result;
	}
	

	/**
	 * 修改订单信息
	 */
	public function edit($where, $data){
		if(empty($where) && empty($data)){
			return false;
		}
	
		$Order = M('Order');
		$result = $Order->where($where)->data($data)->save();
		return $result;
	}
	
	/**
	 * 查询订单列表
	 */
	public function getList(){
		$Order = M('Order');
		$list = $Order->select();	
		return $list;
	}	
	
	/**
	 * 根据用户id获取订单列表
	 */
	public function getUserList($user_id, $page, $page_num=10){
		if (empty($user_id)) {
			return false;
		}
	 
		$sql = "SELECT a.*,b.shop_name,b.shop_orderphone1,c.usercoupon_price
	    		FROM (SELECT * FROM hhj_order WHERE order_user=%d ORDER BY order_id DESC LIMIT %d,%d) a
	    		LEFT JOIN hhj_shop b ON a.order_shop = b.shop_id
	    		LEFT JOIN hhj_usercoupon c ON c.usercoupon_useorder = a.order_id";	
		$Model = new Model();
		$list = $Model->query($sql, $user_id, $page*$page_num, $page_num);
		if($list){
			$_list = array();
			$Cart = D('Home/Cart');
			$Usercoupon = D('Home/Usercoupon');
			foreach ($list as $val){
				$_list[] = $val;
				$cart_list = $Cart->getListByOrderNo($val['order_code']);
				if($cart_list){
					$_list[]['cart_list'] = $cart_list;
				}
			}
			$list = $_list;
		}
		return $list;
	}
	
	/**
	 * 数量汇总
	 */
	public function getCount($time1='', $time2='', $city_id){
		
		$map = array();
		if($time1 && $time2){
			$map['order_time'] = array('gt', $time1);
			$map['order_time'] = array('lt', $time2);
		}		
		
		if($city_id){			
			$Shop = M('Shop');
			$shop_map = array();
			$shop_map['shop_type'] = 0;
			$shop_map['shop_city'] = $city_id;
			$shop_list = $Shop->where($shop_map)->select();
			if($shop_list){
				$shop_id_arr = array();
				foreach ($shop_list as $val){
					$shop_id_arr[] = $val['shop_id'];
				}				
				$map['order_shop'] = array('in', $shop_id_arr);
			}
		}		
		
		$Order = M('Order');
		$num = $Order->where($map)->count();
		return $num;
	}
	
	/**
	 * 金额汇总
	 */
	public function getSumPrice($time1='', $time2='', $city_id){
	
		$map = array();
		if($time1 && $time2){
			$map['order_time'] = array('gt', $time1);
			$map['order_time'] = array('lt', $time2);
		}
	
		if($city_id){
			$Shop = M('Shop');
			$shop_map = array();
			$shop_map['shop_type'] = 0;
			$shop_map['shop_city'] = $city_id;
			$shop_list = $Shop->where($shop_map)->select();
			if($shop_list){
				$shop_id_arr = array();
				foreach ($shop_list as $val){
					$shop_id_arr[] = $val['shop_id'];
				}
				$map['order_shop'] = array('in', $shop_id_arr);
			}
		}
	
		$Order = M('Order');
		$price = $Order->where($map)->sum('order_payfee');
		return $price;
	}
	
	/**
	 * 根据用户id获取最新订单
	 */
	public function getLastOne($userid){
		if(empty($userid)){
			return false;
		}
		
		$Order = M('Order');
		$map = array();
		if($userid){
			$map['order_user'] = $userid;
		}else{
			$map['order_user'] = array('gt', 0);
		}
		
		$data = $Order->where($map)->order('order_time desc')->find();	
		return $data;
	}
	
	/**
	 * 根据用户id获取下过订单的店铺信息
	 */
	public function getOrderShop($user_id){
		if(empty($user_id)){
			return false;
		}
		
		$sql = "SELECT a.*, b.user_id
	    		FROM  hhj_shop a
	    		LEFT JOIN hhj_order_new b 
				ON a.shop_id = b.shop_id 
				WHERE b.user_id = %d AND a.shop_isopen = 0 AND a.shop_type = 0 
				GROUP BY b.shop_id 
				ORDER BY b.order_id desc
				limit 3; 
	    		";
		$Model = new Model();
		$list = $Model->query($sql, $user_id);
		return $list;
	}
	
}