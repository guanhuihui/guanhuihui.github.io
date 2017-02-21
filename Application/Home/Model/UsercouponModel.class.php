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
 * 用户优惠券模型
 */
class UsercouponModel{
	
	/** 
	 * 用户优惠券信息
	 */
	public function getInfoById($coupon_id){
		if(empty($coupon_id)){
			return false;
		}
	
		$Usercoupon = M('Usercoupon');
		$where['usercoupon_id'] = $coupon_id;
		$data = $Usercoupon->where($where)->find();
	
		return $data;
	}
	
	public function getInfoByConponId($usercoupon_coupon) {
		
		if (empty($usercoupon_coupon)){
			return false;
		}
		
		$Usercoupon = M('Usercoupon');
		$where['usercoupon_coupon'] = $usercoupon_coupon;
		$where['usercoupon_status'] = '0';
		$data = $Usercoupon->where($where)->order(' usercoupon_id ')->select();
		
		return $data;
	}
	
	public function getInfoByUseOrder($usercoupon_useorder) {
		
		if (empty($usercoupon_useorder)){
			return false;
		}
		
		$Usercoupon = M('Usercoupon');
		$where['usercoupon_useorder'] = $usercoupon_useorder;
		$data = $Usercoupon->where($where)->select();
		
		return $data;
	}
	
	/**
	 * 根据订单id获取优惠券信息
	 */
	public function getInfoByOrderId($order_id){
		if(empty($order_id)){
			return false;
		}
	
		$Usercoupon = M('Usercoupon');
		$where['usercoupon_useorder'] = $order_id;
		$data = $Usercoupon->where($where)->order('usercoupon_id desc')->find();	
		return $data;
	}
	
	/**
	 * 添加用户优惠券信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
		
		$usercoupon_info = $this->getInfoByConponId($data['coupon_id']);
		
		if ($usercoupon_info){
			
			$_data = array();
			$_data['usercoupon_id'] = $usercoupon_info['usercoupon_id'];
			$_data['usercoupon_user'] = $data['uid'];
			$_data['usercoupon_status'] = 1;
			$_data['usercoupon_startday'] = $data['startday']?$data['startday']:strtotime(date("Y-m-d 00:00:00"));
			$_data['usercoupon_endday'] = $_data['usercoupon_startday'] + 86400 * $data['days'] - 1 ;
			$_data['usercoupon_gettime'] = time();
			$_data['usercoupon_type'] = $data['type'];
			
			$Usercoupon = M('Usercoupon');
			$result = $Usercoupon->save($_data);
			
			return $result;
		}
		
		return false;
	}
	
	/**
	 * 删除用户优惠券
	 */
	public function del($coupon_id) {
		if (empty($coupon_id)) {
			return false;
		}
	
		$Usercoupon = M('Usercoupon');
		$where['usercoupon_id'] = $coupon_id;
		$result = $Usercoupon->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改用户优惠券信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['usercoupon_id'])){
			$coupon_id = $data['usercoupon_id'];
			unset($data['usercoupon_id']);
	
			$Usercoupon = M('Usercoupon');
			$result = $Usercoupon->where(" usercoupon_id = %d ",$coupon_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询用户优惠券列表
	 */
	public function getList($user_id,$page = 1,$page_size = 10) {
		if (empty($user_id)){
			return false;
		}
		
		$start_row = ($page-1)*$page_size;
		$Usercoupon = M('Usercoupon');
		$where['usercoupon_user'] = $user_id;
		$list = $Usercoupon->where($where)->order(' usercoupon_gettime desc ')->limit($start_row,$page_size)->select();
		
		return $list;
	}
	
	public function getCountByUser($user_id) {
		if (empty($user_id)){
			return false;
		}
		
		$Usercoupon = M('Usercoupon');
		$where['usercoupon_user'] = $user_id;
		$count = $Usercoupon->where($where)->count();
		
		return $count;
	}
	
	/**
	 * Table_usercoupon::shopVerifyList()老板监控验证
	 *
	 * @param integer $shopid
	 * @param integer $page
	 * @param integer $pagesize
	 * @return
	 */
	static public function shopVerifyList($shopid=0, $page = 1, $pagesize = 10000, $start_time = 0, $end_time = 0, $city = 0, $city_id =0, $shopnames = 0){

		$startrow = ($page - 1) * $pagesize;
		
		$and = '';
		if($start_time && $end_time){
			$and .= " and usercoupon_usetime > $start_time and usercoupon_usetime < $end_time";
		}elseif(!$start_time && !$end_time){
			$and .= " and usercoupon_usetime > $start_time and usercoupon_usetime < $end_time";
		}
		if($shopid){
			$and .= " and usercoupon_useshop in ($shopid)";
		}
		
		$table = 
				"SELECT a.usercoupon_useshop, b.shop_name AS shopname, b.shop_account AS shopcode,a.price,a.uccount,c.city_id,c.city_name
				 FROM 
					(
						SELECT usercoupon_useshop, SUM(usercoupon_price) AS price, COUNT(usercoupon_id) AS uccount 
						FROM hhj_usercoupon WHERE usercoupon_useshop IS NOT NULL AND usercoupon_isverify = 0 AND usercoupon_status = 2
						 $and
						GROUP BY usercoupon_useshop ORDER BY usercoupon_id DESC
					) a 
					LEFT JOIN hhj_shop b ON a.usercoupon_useshop = b.shop_id
					LEFT JOIN hhj_city c ON b.shop_city = c.city_id 
				 ";
		
		
	
		$sql_se = '';
		if($city){
			$sql_se = "select SUM(t.uccount) as totalcount, t.city_id, t.city from ($table) t where t.city like '%$city%' order by t.shopcode asc limit $startrow, $pagesize";
		}elseif($city_id && !$shopnames){				
			$sql_se = "select t.usercoupon_useshop,t.shopname,t.uccount from ($table) t where t.city_id = ".$city_id;				
		}elseif($city_id && $shopnames){				
			$sql_se = "select t.usercoupon_useshop,t.shopname,t.uccount from ($table) t where t.shopname like '%".$shopnames."%'";
		}else{	
			$sql_se = "select SUM(t.uccount) as totalcount, t.city_id, t.city from ($table) t group by t.city_id order by t.shopcode asc limit $startrow, $pagesize";
		}
	
		$Model = new Model();		
		$list = $Model->query($sql_se);
		
		return $list;
	}
	
	/**
	 * 获取优惠码的分发情况
	 *
	 * @param integer $get 0 剩余的，1 已领取的
	 */
	public function getCount($get = 0, $start_time = 0, $end_time = 0){
	
		$map = array();
		if($get){
			$map['usercoupon_user'] = array('is not', 'null');
		}else{
			$map['usercoupon_user'] = array('is', 'null');
		}
		if($start_time && $end_time){
			$map['user_regtime'] = array('gt', $start_time);
			$map['user_regtime'] = array('lt', $end_time);
		}
	
		$Usercoupon = M('Usercoupon');
		$num = $Usercoupon->where($map)->count();		
		return $num;	
	}
	
	/**
	 * Table_usercoupon::getCountByTime()获取某一时间之前或之后的数据
	 *
	 * @param mixed $sid
	 * @param mixed $time
	 * @param integer $ex -1：之前的，1，之后的
	 * @return
	 */
	public function getCountByTime($sid = 0, $verify=0, $name = 0, $stime = 0, $etime = 0){

		$map = array();
		if($sid){
			$map['usercoupon_useshop'] = array('in', $sid);
		}	
	
		//使用时间
		if($stime && $etime){
			$map['user_regtime'] = array('gt', $stime);
			$map['user_regtime'] = array('lt', $etime);
		}
	
		if($name){
			
			$Coupon = M('Coupon');
			$coupon_list = $Coupon->getList($name);
			$coupon_id_arr = array();
			foreach($coupon_list as $val){
				$coupon_id_arr[] = $val['coupon_id'];
			}
			$map['usercoupon_coupon'] = array('in', $coupon_id_arr);
		}

		//是否验证
		if($verify == 0 || $verify == 1){
			$map['usercoupon_isverify'] = $verify;
			$map['usercoupon_user'] = array('is not', 'null');
			$map['usercoupon_status'] = 2;
		}
		
		$UserCoupon = M('Usercoupon');
		$list = $UserCoupon->field('count(usercoupon_id) as total,sum(usercoupon_price) as totalprice')->where($map)->select();
		return $list;
	}
	
	/**
	 * 获取商户兑换的优惠码数量
	 *
	 * @param mixed $sid 商户ID
	 * @param mixed $mintime 最小时间
	 * @param mixed $maxtime 最大时间
	 * @return
	 */
	public function countExchangeByShop($sid, $mintime, $maxtime){
		
		$Usercoupon = M('Usercoupon');
		$map = array();
		$map['usercoupon_useshop'] = $sid;
		$map['usercoupon_usetime'] = array('gt', $mintime);
		$map['usercoupon_usetime'] = array('lt', $maxtime);
		
		$count = $Usercoupon->where($map)->count();
		return $count;
	}
	
	/**
	 * 获取在这个商户用的优惠码
	 *
	 * @param mixed $sid 商户ID
	 * @param mixed $mintime 时间区间 小的
	 * @param mixed $maxtime 时间区间 大的
	 * @return
	 */
	public function getExchangeList($sid, $mintime, $maxtime, $page = 1, $pagesize = 20){
		$Usercoupon = M('Usercoupon');
		$map = array();
		$map['usercoupon_useshop'] = $sid;
		$map['usercoupon_usetime'] = array('gt', $mintime);
		$map['usercoupon_usetime'] = array('lt', $maxtime);
		
		$list = $Usercoupon->where($map)->order('usercoupon_usetime desc')->limit('$startrow, $pagesize')->select();
		if($list){
			$rt = array();
			foreach($list as $key => $val){
				$rt[$key] = self::struct($val);
			}
			return $rt;
		}else{
			return false;
		}
	}
	
	public function struct($data){	
		$r = array();
		$r['usercouponid'] = $data['usercoupon_id'];
		$r['couponid']     = $data['usercoupon_coupon'];
		$r['distid']       = $data['usercoupon_distid'];
		$r['userid']       = $data['usercoupon_user'];
		$r['code']         = $data['usercoupon_code'];
		$r['status']       = $data['usercoupon_status'];
		$r['startday']     = $data['usercoupon_startday'];
		$r['endday']       = $data['usercoupon_endday'];
		$r['usetime']      = $data['usercoupon_usetime'];
		$r['useshop']      = $data['usercoupon_useshop'];
		$r['useorder']     = $data['usercoupon_useorder'];
		$r['phonecode']    = $data['usercoupon_phonecode'];
		$r['gettime']      = $data['usercoupon_gettime'];
		$r['isverify']     = $data['usercoupon_isverify'];
		$r['price']        = $data['usercoupon_price'];
		$r['excode']       = $data['usercoupon_excode'];
		$r['type']       = $data['usercoupon_type'];
		return $r;	
	}
	
	/**
	 * 代金券兑换
	 *
	 * @param mixed $shop
	 * @param mixed $couponid
	 * @return
	 */
	public function userVoucherExchange($shopid, $couponid, $code){		
	
		$Usercoupon = M('Usercoupon');
		$data = array();
		$data['usercoupon_id'] = $couponid;
		$data['usercoupon_status'] = 2;
		$data['usercoupon_usetime'] = time();
		$data['usercoupon_useshop'] = $shopid;
		$data['usercoupon_excode'] = $code;
		
		$result = $Usercoupon->edit($data);
		if($result){
			$Coupon = D('Coupon');
			$coupon_data = $Coupon->getInfoById($couponid);
			//更新优惠券
			$settlement = $coupon_data ? $coupon_data['offset'] : 0;
			// 更新抵押金额
			$Shop = M('Shop');
			$Shop->where('shop_id=%d',$shopid)->setInc('shop_offset', $settlement);			
		}

		return $result;
	}
	
	/**
	 * 获取订单中的商品信息
	 * @param 订单编号 $orderid
	 * @return 金额 number
	 */
	public function getVoucherByOid($orderid){
		$money = 0;
		if(empty($orderid)){
			return $money;
		}
	
		$Usercoupon = M('Usercoupon');
		$map = array();
		$map['usercoupon_useorder'] = $orderid;
		$data = $Usercoupon->where($map)->find();
		if($data){
			$money = $data['usercoupon_price'];
		}
	
		return $money;
	}
	
	/**
	 * 获取用户优惠卷数量
	 *
	 * @param mixed $uid 用户ID
	 * @return void
	 */
	public function countCouponByUser($uid){
		//本月第一天
		$firstday = mktime(0, 0, 0, date('m'), 1, date('Y'));
		//下月第一天
		$lastday  = mktime(0, 0, 0, date('m')+1, 1, date('Y'))-1;
		
		$map = array();
		$map['usercoupon_user'] = $uid;
		$map['usercoupon_endday'] = array('egt', $firstday);
		$map['usercoupon_endday'] = array('elt', $lastday);
		
		$Usercoupon = M('Usercoupon');
		$count = $Usercoupon->where($map)->count();
		return $count;
	}
	
	/**
	 * listByUser() 通过用户ID查询用户的优惠券
	 *
	 * @param mixed $userid
	 * @param integer $page
	 * @param integer $pagesize
	 * @return
	 */
	public function listByUser($userid, $page = 1, $pagesize = 20){
		$startrow = ($page - 1) * $pagesize;
		//本月第一天
		$firstday = mktime(0, 0, 0, date('m'), 1, date('Y'));
		//下月第一天
		$lastday  = mktime(0, 0, 0, date('m')+1, 1, date('Y'));

		$map = array();
		$map['usercoupon_user'] = $userid;
		$map['usercoupon_endday'] = array('egt', $firstday);
		$map['usercoupon_endday'] = array('elt', $lastday);
		
		$Usercoupon = M('Usercoupon');
		$list = $Usercoupon->where($map)->select();
		if($list){
			$_list = array();
			foreach($list as $val){
				$_list[] = self::struct($val);
			}
			return $_list;
		}else{
			return false;
		}
	}
	
	/**
	 * Table_usercoupon::getCouponInfoBycoupon()根据代金券获取代金券信息
	 *
	 * @param mixed $voucher
	 * @return
	 */
	public function getCouponInfoBycoupon($voucher){		
		$sql = "
				SELECT a.coupon_name,a.coupon_type,a.coupon_goods,a.coupon_enjoy,a.coupon_n,a.coupon_endday 
				FROM hhj_coupon a
				LEFT JOIN hhj_usercoupon b ON a.coupon_id = b. usercoupon_coupon
				WHERE a.coupon_type IN (1,4,7) AND b.usercoupon_code = '%s'
		";
	
		$Model = new Model();
		$data = $Model->where($sql, $voucher)->find();
		return $data;
	}
	
	/**
	 * 根据条件获取优惠券
	 */
	public function getCouponList($where){
		if(empty($where)){
			return false;
		}
		
		$Usercoupon = M('Usercoupon');
		$result = $Usercoupon->where($where)->select();
		return $result;
	}
}