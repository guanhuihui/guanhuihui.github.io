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
 * 优惠活动模型
 */
class CouponModel{
	
	/** 
	 * 优惠活动信息
	 */
	public function getInfoById($coupon_id){
		if(empty($coupon_id)){
			return false;
		}
	
		$Coupon = M('Coupon');
		$where['coupon_id'] = $coupon_id;
		$data = $Coupon->where($where)->find();
	
		return $data;
	}

	public function getCouponByType($coupon_type) {
		if (empty($coupon_type)){
			return false;
		}
		
		$Coupon = M('Coupon');
		$where['coupon_type'] = $coupon_type;
		$where['coupon_status'] = 0;
		$data = $Coupon->where($where)->select();
		
		return $data;
	}
	
	/**
	 * 添加优惠活动信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Coupon = M('Coupon');
		$result = $Coupon->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除优惠活动
	 */
	public function del($coupon_id) {
		if (empty($coupon_id)) {
			return false;
		}
	
		$Coupon = M('Coupon');
		$where['coupon_id'] = $coupon_id;
		$result = $Coupon->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改优惠活动信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['coupon_id'])){
			$coupon_id = $data['coupon_id'];
			unset($data['coupon_id']);
	
			$Coupon = M('Coupon');
			$result = $Coupon->where(" coupon_id = %d ",$coupon_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	public function isGetCoupon($cid, $userid, $days){
		//零时定义活动开始时间和结束时间
		$ACTSTART = strtotime('2015-10-29');
		$gettime = $ACTSTART;
		$nowtime  = time();	
		if($nowtime > $ACTSTART){
			$tday = ceil(($nowtime - $ACTSTART)/(86400*$days));	
			$gettime = $ACTSTART+(86400*$days*$tday);
		}
	
		$Coupon = M('Coupon');
		
		$Coupon->where()-count();
		
		$stime = $gettime - 86400*$days;
		if($days){
			$sql    = "select count(usercoupon_id) as couponCount from hhj_usercoupon where usercoupon_coupon = $cid and usercoupon_user = $userid and usercoupon_gettime <= $gettime and usercoupon_gettime >= $stime";
		}else{
			$sql    = "select count(usercoupon_id) as couponCount from hhj_usercoupon where usercoupon_coupon = $cid and usercoupon_user = $userid ";
		}
	
		$r   = $mysql->sqlQuery($sql);
	
		return $r[0]['couponCount'];
	}
	
	/**
	 * Coupon::getCouponByName()根据活动名称查找活动id
	 *
	 * @param mixed $city
	 * @return
	 */
	public function getInfoByName($cityid, $name=""){		
		if(empty($cityid) || empty($name)){
			return false;
		}
		
		$City = M('City');
		$city_data = $City->getCityByBaiduCode($cityid);
		if($city_data){
		    $Coupon = M('Coupon');
		    $data = $Coupon->where("coupon_status=0 and coupon_name='$name'and (coupon_city=$city or coupon_province=$province or coupon_nation=1) ",$name, $city_data['city_id'], $city_data['city_province'])
		    ->order('coupon_id desc')->find();		
		    return $data;
		}
		
		return false;
	}
	
	/**
	 * 查询优惠活动列表
	 */
	public function getList($coupon_name) {
		$Coupon = M('Coupon');
		$map = array();
		if($coupon_name){
			$map['coupon_name'] = $coupon_name; 
		}
		$list = $Coupon->where($map)->select();
	
		return $list;
	}
	
	/**
	 * 获取优惠券
	 * @param $city_code 城市编码
	 */
	public function getUseCoupon($city_code){
		if(empty($city_code)){
			return false;
		}
		
		$City = M('City');
		$city_data = $City->getCityByBaiduCode($city_code);
		if($city_data){
			$Coupon = M('Coupon');
			$sql = "
			select * from hhj_coupon 
			where coupon_status = 0 and coupon_startday <= %d and coupon_endday > %d and coupon_type >= 1 and coupon_type < 9 
			and (coupon_city = %d or coupon_province = %d or coupon_nation = 1 ) 
			order by coupon_id desc
			";
			
			$Model = new Model();
			$time = time();
			$list = $Model->query($sql, time(), time(), $city_code, $city_data['city_province']);
			if($list){
				$_list = array();
				foreach($list as $val){
					$_list[] = self::struct($val);
				}
				return $_list;
			}
			return $list;	
		}		
		return false;		
	}
	
	public function struct($data){	
		$r = array();		 
		$r['couponid']  = $data['coupon_id'];
		$r['name']      = $data['coupon_name'];
		$r['content']   = $data['coupon_content'];
		$r['shop']      = $data['coupon_shop'];
		$r['area']      = $data['coupon_area'];
		$r['city']      = $data['coupon_city'];
		$r['province']  = $data['coupon_province'];
		$r['nation']    = $data['coupon_nation'];
		$r['gtype']     = $data['coupon_gtype'];
		$r['gsort']     = $data['coupon_gsort'];
		$r['goods']     = $data['coupon_goods'];
		$r['type']      = $data['coupon_type'];
		$r['couponx']   = $data['coupon_x'];
		$r['coupony']   = $data['coupon_y'];
		$r['addtime']   = $data['coupon_addtime'];
		$r['days']      = $data['coupon_days'];
		$r['ischecked'] = $data['coupon_ischecked'];
		$r['startday']  = $data['coupon_startday'];
		$r['endday']    = $data['coupon_endday'];
		$r['starttime'] = $data['coupon_startday'];
		$r['endtime']   = $data['coupon_endday'];
		$r['offset']    = $data['coupon_offset'];
		$r['status']    = $data['coupon_status'];
		$r['ico']       = $data['coupon_ico'];
		$r['enjoy']     = $data['coupon_enjoy'];
		$r['gift']      = $data['coupon_gift'];
		$r['pricen']      = $data['coupon_n'];
		return $r;	
	}
	
	
	
	
}