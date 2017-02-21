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
 * 商户模型
 */
class ShopModel{
	
	/**
	 * 商户信息
	 */
	public function getInfoById($shop_id){
		if(empty($shop_id)){
			return false;
		}
	
		$Shop = M('Shop');
		$where['shop_id'] = $shop_id;
		$data = $Shop->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 非主键ID获取商户信息
	 * parameter  $where为查询条件
	 */
	public function getShopInfo($where){
		if(empty($where)){
			return false;
		}

		$Shop = M('Shop');
		$data = $Shop->where($where)->find();
	
		return $data;
	}
	
	
	/**
	 * 添加商户信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Shop = M('Shop');
		$result = $Shop->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除商户
	 */
	public function del($shop_id) {
		if (empty($shop_id)) {
			return false;
		}
	
		$Shop = M('Shop');
		$where['shop_id'] = $shop_id;
		$result = $Shop->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改商户信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['shop_id'])){
			$shop_id = $data['shop_id'];
			unset($data['shop_id']);
	
			$Shop = M('Shop');
			$result = $Shop->where(" shop_id = %d ",$shop_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 更新积分
	 * @param 店铺id $shop_id
	 */
	public function updateScore($shop_id){
		if (empty($shop_id)) {
			return false;
		}
		
		$Score = M('Score');
		$avg_score = $Score->where("shop_id=%d and score>0",$shop_id)->avg('score');
		
		$result = false;
		if($avg_score){
			$Shop = M('Shop');
			$data = array();
			$data['score']=$avg_score;
			$result = $Shop->where("shop_id=%d",$shop_id)->data($data)->save();		
		}		
		return $result;
	}
		
	
	/**
	 * 更新店铺销量
	 * @param 店铺id $shop_id
	 * @return boolean
	 */
	public function addOrderCount($shop_id){
		if (empty($shop_id)) {
			return false;
		}
		
		$data = array();
		$data['shop_totalordercount'] = array('exp','shop_totalordercount+1');
		
		$Shop = M('Shop');
		$result = $Shop->where(" shop_id = %d ",$shop_id)->data($data)->save();
		return $result;
	}
	
	/**
	 * 查询商户列表
	 */
	public function getList($shop_isopen = 0,$shop_type = 0,$shop_city) {
		
		$where = " shop_isopen = '$shop_isopen' and shop_type = '$shop_type'";
		
		if ($shop_city){
			$where .= " and shop_city = '$shop_city' ";
		}
		
		$Shop = M('Shop');
		$data = $Shop->where($where)->select();
	
		return $data;
	}
	
	/**
	 * 可视区内的店铺
	 */
	public function getListByMap($sw_lng,$sw_lat,$ne_lng,$ne_lat) {
		
		$where = " shop_baidux between '$sw_lng' and '$ne_lng' and shop_baiduy between '$sw_lat' and '$ne_lat' and shop_isopen = 0  ";
		
		$Shop = M('Shop');
		$data = $Shop->where($where)->select();
		
		return $data;
	}
	
	/**
	 * 根据城市code 获取商户列表
	 */
	public function getListByCity($shop_city) {
		$where = " shop_city = '$shop_city' and shop_isopen = 0 ";
		
		$Shop = M('Shop');
		$data = $Shop->where($where)->select();
		
		return $data;
	}
	
	/**
	 * 根据距离获取最近的店铺
	 */
	public function getListByDistince($lng, $lat, $pagesize=100){
		if(empty($lng) && empty($lat)){
			return false;
		}
		
		$sql = "SELECT hhj_shop.*,
		ROUND(6378.138*2*ASIN(SQRT(POW(SIN( (shop_baiduy*PI()/180-%f*PI()/180)/2),2)+COS(shop_baiduy*PI()/180)*COS(%f*PI()/180)* POW(SIN( (shop_baidux*PI()/180-%f*PI()/180)/2),2)))*1000)
		AS distance
		FROM hhj_shop
		WHERE shop_isopen = 0 				
		ORDER BY distance ASC
		LIMIT %d";		
		$Model = new Model();
		$list = $Model->query($sql, $lat, $lat, $lng, $pagesize);
		return $list;
	}
	
	/**
	 * 根据距离获取最近的网店店铺
	 */
	public function getNetShopListByDistince($lng, $lat, $pagesize=100){
		if(empty($lng) && empty($lat)){
			return false;
		}
	
		$sql = "SELECT hhj_shop.*,
		ROUND(6378.138*2*ASIN(SQRT(POW(SIN( (shop_baiduy*PI()/180-%f*PI()/180)/2),2)+COS(shop_baiduy*PI()/180)*COS(%f*PI()/180)* POW(SIN( (shop_baidux*PI()/180-%f*PI()/180)/2),2)))*1000)
		AS distance
		FROM hhj_shop
		WHERE shop_isopen = 0 AND shop_type = 0
		ORDER BY distance ASC
		LIMIT %d";
		$Model = new Model();
		$list = $Model->query($sql, $lat, $lat, $lng, $pagesize);
		return $list;
	}
	
	/**
	 * 根据距离获取最近的网店店铺
	 */
	public function getNetShopByDistince($lng, $lat, $where){
		if(empty($lng) && empty($lat)){
			return false;
		}
	
		$sql = "SELECT hhj_shop.*,
		ROUND(6378.138*2*ASIN(SQRT(POW(SIN( (shop_baiduy*PI()/180-%f*PI()/180)/2),2)+COS(shop_baiduy*PI()/180)*COS(%f*PI()/180)* POW(SIN( (shop_baidux*PI()/180-%f*PI()/180)/2),2)))*1000)
		AS distance
		FROM hhj_shop
		WHERE $where
		ORDER BY distance ASC
		LIMIT 1";
		$Model = new Model();
		$list = $Model->query($sql, $lat, $lat, $lng);
		return $list;
	}
	
	/**
	 * 根据最近的在配送时间的网店店铺
	 */
	public function getShopListByDistince($lng, $lat, $pagesize=100){
		if(empty($lng) && empty($lat)){
			return false;
		}
		
		$time = $this->getPassTime(date('H:s'));
		
		/*$sql = "SELECT hhj_shop.*,
		ROUND(6378.138*2*ASIN(SQRT(POW(SIN( (shop_baiduy*PI()/180-%f*PI()/180)/2),2)+COS(shop_baiduy*PI()/180)*COS(%f*PI()/180)* POW(SIN( (shop_baidux*PI()/180-%f*PI()/180)/2),2)))*1000)
		AS distance
		FROM hhj_shop
		WHERE shop_isopen = 0 AND shop_type = 0 AND shop_status = 1 AND $time>=shop_delivertime1 AND $time<=shop_delivertime2
		ORDER BY distance ASC
		LIMIT %d";*/
		$sql = "SELECT * FROM (SELECT hhj_shop.*,
		ROUND(6378.138*2*ASIN(SQRT(POW(SIN( (shop_baiduy*PI()/180-%f*PI()/180)/2),2)+COS(shop_baiduy*PI()/180)*COS(%f*PI()/180)* POW(SIN( (shop_baidux*PI()/180-%f*PI()/180)/2),2)))*1000)
		AS distance
		FROM hhj_shop
		WHERE shop_isopen = 0 AND shop_type = 0 AND shop_status = 1 AND $time>=shop_delivertime1 AND $time<=shop_delivertime2
		ORDER BY distance ASC
		LIMIT %d ) AS jieguo ORDER BY shop_isvip DESC";
		$Model = new Model();
		$list = $Model->query($sql, $lat, $lat, $lng, $pagesize);
		return $list;
	}
	
	/**
	 * Shop::getAllShop()获取所有商户
	 *
	 * @return
	 */
	public function getAllShop(){
		
		$where = array(
			'shop_type' => 0
		);
		
		$Shop = M('Shop');
		$data = $Shop->where($where)->select();		
		return $data;
	}
	
	//当前非标准时区的问题，所以先获得当前时区的开始时间
	public function getPassTimeStr($time){
		$starttime = strtotime('January 1 1970 00:00:00');
		return date('H:i', $time+$starttime);
	}
	
	//从标准时区下1970-1-1 0时的秒数
	//$str --形如 hh:mm 的时分
	public function getPassTime($str){
		return strtotime('January 1 1970 '.$str.':00 GMT');
	}
	
	/**
	 * 根据店铺名称模糊查询店铺
	 */
	public function getShopByName($name){
		$where['shop_name'] = array('like','%'.$name.'%');
		$Shop = M('Shop');
		$data = $Shop->where($where)->select();
		return $data;
	}
	
	/**
	 * 获取商户列表
	 * parameter  $where为查询条件
	 */
	public function getShopList($where,$page,$pagesize,$reorder='shop_id'){
		
		$startrow = ($page - 1) * $pagesize;		
		$Shop = M('Shop');
		$data = $Shop->where($where)->limit("$startrow, $pagesize")->order("$reorder desc")->select();	
		return $data;
	}
	
	/**
	 * 获取商户数量
	 * @param integer $where 筛选条件，默认为空
	 * @return
	 */
	public function shopCount($where=''){	
		$Shop = M('Shop');	
		$count = $Shop->where($where)->count();	
		return $count;
	}
	
	/**
	 * 获取商户信息
	 * @param integer $where 筛选条件，默认为空
	 * @return
	 */
	public function getShop($where){
	
		$Shop = M('Shop');
	
		$count = $Shop->where($where)->find();
	
		return $count;
	}
	
	/**
	 *  根据城市获取商户ID
	 *
	 * @param mixed $cityid 城市ID
	 * @return void
	 */
	public function getShopIdListByCity($cityid){
		if(empty($cityid)){
			return false;
		}
		$shop_id = 0;
		$Shop = M('Shop');
		$map = array();
		$map['shop_city'] = $cityid;
		$shopinfo = $Shop->where($map)->field('shop_id')->select();
		if(count($shopinfo) == 1){
			$shop_id =  $shopinfo[0]['shop_id'];
		}else if(count($shopinfo)>1){
			$arr = array();//商品ID
			foreach($shopinfo as $val){
				$arr[] = $val['shop_id'];
			}
			$shop_id = implode(',',$arr);
		}
		
		return $shop_id;
	}
	
	/**
	 * 获取商户信息
	 * @param integer $where 筛选条件，默认为空
	 * @return
	 */
	public function ShopList($where){
	
		$Shop = M('Shop');
	
		$data = $Shop->where($where)->select();
	
		return $data;
	}
	
	/**
	 * 获取商户信息
	 * @param $city_id 城市ID
	 * @param $area_id 区域ID
	 * @param $num  数量
	 * @return
	 */
	public function getShopListByArea($city_id, $area_id, $num){
		if(empty($city_id)){
			return false;
		}
		
		$Shop = M('Shop');
		$map = array();
		$map['shop_city'] = $city_id;
		
		if($area_id){
			$map['shop_area'] = $area_id;
		}
		
		$list = $Shop->where($map)->limit($num)->order('shop_type')->select();
		
		return $list;
	}
	
	/**
	 * 商户赠品数量增加
	 * @param unknown $shop_id
	 */
	public function giftsCountAdd($shop_id,$goods_id,$count=0){
		if (empty($shop_id)) {
			return false;
		}
		$ShopGift = M('ShopGift');
		$where['shop_id'] = array('eq',$shop_id);
		$where['goods_id'] = array('eq',$goods_id);
		$ShopGift->where($where)->setInc('goods_count',$count); // 商户赠品数
	}
	
	/**
	 * 商户赠品数量减少
	 * @param unknown $shop_id
	 */
	public function giftsCountReduce($shop_id,$goods_id,$count=0){
		if (empty($shop_id)) {
			return false;
		}
		$ShopGift = M('ShopGift');
		$where['shop_id'] = array('eq',$shop_id);
		$where['goods_id'] = array('eq',$goods_id);
		$ShopGift->where($where)->setDec('goods_count',$count); // 商户赠品数
	}
	
	/**
	 * 查询商户赠品统计表中是否有此赠品
	 * @param unknown $shop_id
	 * @param unknown $goods_id
	 * @return boolean|Ambigous <\Think\mixed, boolean, NULL, multitype:, unknown, mixed, string, object>
	 */
	public function findGiftByShop($shop_id,$goods_id){
		if (empty($shop_id)) {
			return false;
		}
		$ShopGift = M('ShopGift');
		$where['shop_id'] = array('eq',$shop_id);
		$where['goods_id'] = array('eq',$goods_id);
		$count = $ShopGift->where($where)->find();
		return $count;
	}
	
	/**
	 * 添加商户赠品记录
	 * @param unknown $data
	 * @return boolean|Ambigous <\Think\mixed, boolean, string, unknown>
	 */
	public function addGift($shop_id,$goods_id,$goods_name,$goods_count){
		$data['shop_id'] = $shop_id;
		$data['goods_id'] = $goods_id;
		$data['goods_name'] = $goods_name;
		$data['goods_count'] = $goods_count;
		$ShopGift = M('ShopGift');
		$result = $ShopGift->data($data)->add();
		
		return $result;
	}
	
	//检查密码是否正确
	//(用于重置密码检查旧密码)
	/**
	 * 
	 * @param unknown $sid
	 * @param unknown $pw
	 * @return boolean
	 */
	public function checkPassword($sid, $pw){
		
		$shopinfo = $this->getInfoById($sid);
		$salt     = $shopinfo['shop_salt'];
		$pw_true  = $shopinfo['shop_password'];
	
		$pw_encode = $this->buildPassword($pw, $salt);
		if($pw_encode[1] == $pw_true)
			return true;
		else
			return false;
	}
	
	/**
	 * 生成密码
	 */
	public function buildPassword($pwd, $salt = ''){
		if(!$salt){
			$salt = randcode(10, 4);//生成Salt
		}
		$pwd_new = md5(md5($pwd).$salt);
		return array($salt, $pwd_new);
	}
	
	/**
	 * getCityShopList()获取所在城市的商户
	 * @param  $citylist  城市信息
	 *
	 * @return
	 */
	public function getCityShopList($citylist){
	
		$where = array(
				'shop_type' => 0
		);
		$cityids = array();
		if($citylist){//处理城市结果集
			$citylist = explode('|', rtrim($citylist, '|'));
			if($citylist){
				foreach($citylist as $val){
					$cityids[] = (int)$val;
				}
			}
		}
		
		if($cityids && is_array($cityids)){
			$where['shop_city'] = array('in',$cityids);
		}
		
		$Shop = M('Shop');
		$data = $Shop->where($where)->select();
		return $data;
	}
	
	/**
	 *  根据城市获取网店商户ID
	 *
	 * @param mixed $city_id 城市ID
	 * @return void
	 */
	public function getShopIdsListByCityId($city_id){
		if(empty($city_id)){
			return false;
		}
		
		$Shop = M('Shop');
		$shopids = array();  //店铺ID集合
		$map = array();
		$map['shop_type'] = 0;
		$map['shop_city'] = $city_id;
		$shoplist = $Shop->where($map)->field('shop_id')->select();
		if($shoplist){
			foreach($shoplist as $val){
				$shopids[] = $val['shop_id'];
			}
		}
	
		return $shopids;
	}
	
	/**
	 *  根据经销商ID获取网店商户ID
	 *
	 * @param mixed $dealer_id 经销商ID
	 * @return void
	 */
	public function getShopIdsListByDealer($dealer_id){
		if(empty($dealer_id)){
			return false;
		}
	
		$Shop = M('Shop');
		$shopids = array();  //店铺ID集合
		$map = array();
		$map['shop_type'] = 0;
		$map['shop_dealer'] = $dealer_id;
		$shoplist = $Shop->where($map)->field('shop_id')->select();
		if($shoplist){
			foreach($shoplist as $val){
				$shopids[] = $val['shop_id'];
			}
		}
	
		return $shopids;
	}
}