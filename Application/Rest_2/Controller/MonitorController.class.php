<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangpp at 2016/01/19
// +----------------------------------------------------------------------

namespace Rest_2\Controller;
use Think\Controller;

class MonitorController extends Controller {
	//获取指定月份的第一和最后一天
	Public function mFristAndLast($y = "", $m = ""){
		if ($y == "") $y = date("Y");
		if ($m == "") $m = date("m");
		$m = sprintf("%02d", intval($m));
		$y = str_pad(intval($y), 4, "0", STR_PAD_RIGHT);
	
		$m>12 || $m<1 ? $month=1 : $month=$m;
		$firstday = strtotime($y .'-'. $month .'-'. '01' ."00:00:00");
		//$firstday = strtotime($y . $m . "01000000");
		$firstdaystr = date("Y-m-01", $firstday);
		$lastday = strtotime(date('Y-m-d 23:59:59', strtotime("$firstdaystr +1 month -1 day")));
	
		return array(
				"firstday" => $firstday,
				"lastday" => $lastday
		);
	}
	
	/**
	 * 监控数据
	 */
	public function collection(){
		//获取参数
		$city = I('post.city')?I('post.city'):0;
		$y = I('post.y')?I('post.y'):0;
		$m = I('post.m')? I('post.m'):0;
		
		//根据城市获取订单总数
		$OrderNew = D('Home/OrderNew');
		$City = D('Home/City');
		$Shop = D('Home/Shop');
		$TicketBalance = D('Home/TicketBalance');
		$User = D('Home/User');
		
		if($y && $m){
			$time = $this->mFristAndLast($y,$m);
			$s = $time['firstday'];
			$e = $time['lastday'];
		}else{
			$s = strtotime(date('Y-m-d'));
			$e = strtotime(date('Y-m-d 23:59:59'));
		}
		$today_start = strtotime(date('Y-m-d'));
		$today_end = strtotime(date('Y-m-d 23:59:59'));
		$list = $OrderNew -> cityOrderCount($city,$s,$e);
		
		foreach($list as $k=>$v){
			$city_info = $City->getInfoByName($v['city']);
			$where['shop_city'] = $city_info['city_id'];
			$where['shop_type'] = 0;
			$shop_list = $Shop->ShopList($where);//根据城市获取商户
			$shop_ids = '';
			foreach($shop_list as $k =>$v ){
				$shop_ids[$k] = $v['shop_id'];
			}
			$sids = implode(',',$shop_ids);
			$map['shop_id'] = array('in',$sids);
			$tickecount = $TicketBalance->count($map);
			$list[$k]['tickecount'] = $tickecount;
		}
		
		//注册总人数
		$usercount = $User->getCount() + 300000;
		//今天注册人数
		$todayuser = $User->getCount($today_start,$today_end);
		//昨天注册人数
		$beginYesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));
		$endYesterday=mktime(0,0,0,date('m'),date('d'),date('Y'))-1;
		$yesterdayuser = $User->getCount($beginYesterday,$endYesterday);
		//今天订单金额
		$todayprice = $OrderNew->totalPrice($today_start,$today_end);
		//昨天订单金额
		$zoprice = $OrderNew->totalPrice($beginYesterday,$endYesterday);
		if($y && $m){
			//指定月份兑换量
			$month_where['add_time'] =  array(array('gt',$s),array('lt',$e),'and'); 
			$monthcoupon = $TicketBalance->count($month_where);
			//指定月份订单金额
			$monthoprice = $OrderNew -> cityOrderCount(0,$s,$e);
		
			echo json_encode_cn(array('monthcoupon' => $monthcoupon, 'monthoprice' => $monthoprice));
			exit;
		}else{
			//当月兑换量
			$mo = mFristAndLast(date('Y'),date('m'));
			//当月订单金额
			$month_where['add_time'] =  array(array('gt',$mo['firstday']),array('lt',$mo['lastday']),'and');
			$monthoprices = $TicketBalance->count($month_where);
			$monthcoupons = $OrderNew -> cityOrderCount(0,$mo['firstday'],$mo['lastday']);
		}
		//今日兑换
		$today_where['add_time'] = array(array('gt',$today_start),array('lt',$today_end),'and');
		$todaychange = $TicketBalance->count($today_where);
		//今日订单
		$todayorder = $OrderNew -> cityOrderCount(0,$today_start,$today_end);
		//昨天订单
		$zorder = $OrderNew -> cityOrderCount(0,$beginYesterday,$endYesterday);
	}
}

?>