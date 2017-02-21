<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/11/27
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 订单商品模型
 */
class OrderGoodsModel{
	
	/**
	 * 添加优惠券生成日志
	 * @param $data
	 * @return int
	 */
	public function add($data){
		if(empty($data)){
			return false;
		}
		
		$OrderGoods = M('OrderGoods');
		$result = $OrderGoods->add($data);
		return $result;
	}

	/**
	 * 根据用户id获取订单列表
	 * @param 用户id $user_id
	 * @param 起始订单id $order_id
	 * @param 单页数目 $page_num
	 * @return array
	 */
	public function getList($order_no, $user_id){
		if(empty($order_no) && empty($user_id)) {
			return false;
		}
		
		$map = array();
		$map['order_no'] = $order_no;
		$map['user_id'] = $user_id; 
		
		$OrderGoods = M('OrderGoods');
		$list = $OrderGoods->where($map)->order('detail_id asc')->select();
		if($list){
			//对信息重组
			$_list = array();
			$Goods = D('Home/Goods');
			foreach ($list as $val){
				$goodsinfo = $Goods->getInfoById($val['goods_id']);
				if($goodsinfo){
					if($goodsinfo['goods_sort'] > 5){
						$val['goods_weight'] = $goodsinfo['goods_spec']; //重量。自营商品规格(ml)
						$val['goods_unit'] = ''; //HHJ商品  规格单位(盒)
						$val['goods_pungent'] = $goodsinfo['goods_brandname']; //HHJ商品  规格口味
					}else{
						$val['goods_weight'] = $goodsinfo['goods_weight']; //重量。HHJ商品
						$val['goods_unit'] = $goodsinfo['goods_unit']; //HHJ商品  规格单位(盒)
						$val['goods_pungent'] = get_goods_pungent($goodsinfo['goods_pungent']); //HHJ商品  规格口味
					}
				}
				if($val['goods_price'] == 0){// 赠品去辣度等属性
					$val['goods_weight'] = ''; //重量。HHJ商品
					$val['goods_unit'] = ''; //HHJ商品  规格单位(盒)
					$val['goods_pungent'] = ''; //HHJ商品  规格口味
				}
				$val['goods_pic'] = C('IMG_HTTP_URL').$val['goods_pic'];
				unset($val['notes']);
				$_list[] = $val;
			}			
			$list = $_list;
		}
		return $list;
	}
	
	/**
	 * 获取订单详情
	 * @param 起始订单id $order_no
	 * @return array
	 */
	public function getGoodsList($order_no){
		if(empty($order_no)) {
			return false;
		}
	
		$map = array();
		$map['order_no'] = $order_no;
	
		$OrderGoods = M('OrderGoods');
		$list = $OrderGoods->where($map)->order('detail_id asc')->select();
		if($list){
			//对信息重组
			$_list = array();
			$OrderGoods = D('Home/OrderGoods');
			foreach ($list as $val){
				$val['goods_pic'] = C('IMG_HTTP_URL').$val['goods_pic'];
				unset($val['notes']);
				$_list[] = $val;
			}
			$list = $_list;
		}
		return $list;
	}

	
	/**
	 * 获取订单详情
	 * @param $order_nos  订单编号集合(数组)
	 * @return array
	 */
	public function getGoodsInfo($order_nos){
		if(empty($order_nos)) {
			return false;
		}
		
		$map = array();
		$map['order_no']  = array('in',$order_nos);
	
		$OrderGoods = M('OrderGoods');
		$goods_count = $OrderGoods->where($map)->count();
		
		$map['goods_price']  = 0; //商品价格
		$map['price']  = 0;   //实付金额
		
		$gift_count = $OrderGoods->where($map)->count();
		
		$data = array();
		$data['goods_count'] = $goods_count;
		$data['gift_count'] = $gift_count;
		
		return $data;
		
	}

	
	/**
	 * 查询订单赠品数量
	 * @param unknown $order_no 订单号
	 */
	public function giftsCountByNo($order_no){
		if(empty($order_no)) {
			return false;
		}
		$where['order_no'] = $order_no;
		$where['type'] = 2;
		$OrderGoods = M('OrderGoods');
		$data = $OrderGoods->field('*,sum(count) as count')->where($where)->group('goods_id')->select();
		return $data;
	}

}