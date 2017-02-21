<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wy at 2015/11/20
// +----------------------------------------------------------------------

namespace Home\Model;

class PriceModel {
	
	/**
	 * 
	 * @param array $goods_list	商品列表
	 * @param number $shop_id	商户id
	 * @param number $pay_type	支付类型
	 * @param unknown $user_id 	用户id
	 * @param unknown $ticket_code	优惠券code
	 * @return array || string
	 */
	public function getPrice($goods_list,$shop_id,$pay_type = 0,$user_id,$ticket_code) {
		//解码商品列表
		$goods_list = json_decode($goods_list,true);
		
		if (!is_array($goods_list)){
			return '';
		}
		
		//商户模型、活动模型、商品模型、区域折扣模型、商户商品模型
		$Shop = D('Home/Shop');
		$Actvity = D('Home/Activity');
		$Goods = D('Home/Goods');
		$Region = D('Home/Region');
		$ShopGoods = D('Home/Shopgoods');
		
		//获取商户信息
		$shop_info = $Shop->getInfoById($shop_id);
		//店铺不存在
		if (empty($shop_info)){
			return '20605';
		}
		//获取地区折扣信息
		$region_info = $Region->getRegionInfoByCity($shop_info['shop_city']);
		$discount = $region_info['distcount'];
		//获取活动列表
		$activity_list = $Actvity->getList(1,1);
		
		//赠品列表
		$gift_list = array();
		
		//总价、折扣、哈哈镜商品总价
		$total_price = 0;
		$hhj_total_price = 0;
		
		
		foreach ($goods_list as $key => $val){
			$goods_id   = $val['goods_id'];
			$num = $val['num'];
			$price = $val['price'];
			
			//商品信息、店铺商品信息
			$goods_info = $Goods->getInfoById($goods_id);
			$shop_goods_info = $ShopGoods->getShopGoodsInfo($shop_id,$goods_id);
			
			//购物车商品错误
			if (empty($shop_goods_info)){
				return '20801';
			}
			
			//购物车商品状态错误
			if ($shop_goods_info['shopgoods_status'] == 1){
				return '20802';
			}
			
			//商品卖出价格
			$_price = number_format($goods_info['goods_price']*$discount,2);
			//商品价格跟店铺所在区域价格比较
			if ($price != $_price && $shop_goods_info['shopgoods_type'] == 0){
				return '20803';
			}
			//购物车商品价格跟店铺价格比较
			if ($price != $shop_goods_info['shopgoods_price'] && $shop_goods_info['shopgoods_type'] == 1){
				return '20803';
			}
			
			//商品总价格
			$total_price += $price;
			//哈哈镜产品价格
			if ($goods_info['goods_type'] == 0){
				$hhj_total_price += $price;
			}
			
			//计算赠品
			foreach($activity_list as $act_item) {
				//当支付方式属于活动支付方式或活动不限支付类型
				if ($act_item['pay_type'] == 0 || $pay_type == $act_item['pay_type']){
					//活动范围拓展
					$range_ext = json_encode($act_item['range_ext'],true);
					
					//活动区域为全国时
					if ($act_item['range_type'] == 1){
						//获取赠品
						$gift_info = $this->getGiftByGoodsType($act_item, $goods_info, $num);
						if ($gift_info){
							$gift_list[] = $gift_info;
						}
					}
					
					//活动区域为省
					if ($act_item['range_type'] == 2){
						foreach ($range_ext as $range_ext_item){
							//商户所在省会在活动区域中
							if ($range_ext_item['province_id'] == $shop_info['shop_province']){
								//获取赠品
								$gift_info = $this->getGiftByGoodsType($act_item, $goods_info, $num);
								if ($gift_info){
									$gift_list[] = $gift_info;
								}
							}
						}
					}
					
					if ($act_item['range_type'] == 3){
						//活动区域为市
						foreach ($range_ext as $range_ext_item){
							//商户所在城市在活动区域中
							if ($range_ext_item['city_id'] == $shop_info['shop_city']){
								//获取赠品
								$gift_info = $this->getGiftByGoodsType($act_item, $goods_info, $num);
								if ($gift_info){
									$gift_list[] = $gift_info;
								}
							}
						}
					}
				}
			}
		}
		
		//获取运费
		$post_free = $this->getDeliverFee($shop_id, $user_id, $total_price);
		
		$data = array();
		$data['gift_list'] = $gift_list;
		$data['total_price'] = number_format($total_price,2, '.', '');
		$data['post_price'] = number_format($post_free,2, '.', '');
		
		return $data;
	}
	
	/**
	 * 获取赠品信息
	 * @param  $goods_num  商品数量
	 * @param  $gift_ext   赠品拓展
	 * @return array 
	 */
	private function giftList($goods_num,$gift_ext) {
		//商品模型
		$Goods = D('Home/Goods');
		//赠品信息
		$gift_info = array();
		$gift_ext = json_encode($gift_ext,true);
		$goods_info = $Goods->getInfoById($gift_ext['goods_id']);
		$gift_info['goods_id'] = $goods_info['goods_id'];
		$gift_info['goods_name'] = $goods_info['goods_name'];
		//计算赠品数量 商品数量/条件数量(直接舍去小数点，只取整数)*赠品数量
		$gift_info['num'] = floor($goods_num/$gift_ext['bud_num'])*$gift_ext['gift_num'];
		$gift_info['icon'] = C('IMG_HTTP_URL').$goods_info['goods_pic3'];
		$gift_info['price'] = 0;
		$gift_info['is_gift'] = 1;
		$gift_info['pungent'] = $goods_info['goods_pungent'];
		
		return $gift_info;
	}
	
	/**
	 * 通过活动商品类型获取赠品
	 * @param $act_info  活动信息
	 * @param $goods_info 商品信息
	 * @param $goods_num  商品数量
	 * @return array
	 */
	private function getGiftByGoodsType($act_info,$goods_info,$goods_num) {
		$gift_info = array();
		//赠品拓展
		$gift_ext = json_encode($act_info['gift_ext'],true);
		//商品拓展
		$goods_ext = json_encode($act_info['goods_ext'],true);
		
		//活动商品类型为所有商品
		if ($act_info['goods_type'] == 1){
			//当前商品类型为哈哈镜产品
			if ($goods_info['goods_type'] == 0){
				$gift_info = $this->giftList($goods_num,$gift_ext);
				break;
			}
		}
		//活动商品类型为 商品品类
		if ($act_info['goods_type'] == 2){
			foreach ($goods_ext as $goods_ext_item){
				//商品分类在活动商品分类中
				if ($goods_ext_item['sort_id'] == $goods_info['goods_sort']){
					$gift_info = $this->giftList($goods_num,$gift_ext);
					break;
				}
			}
		}
		//活动商品分类为  部分商品时
		if ($act_info['goods_type'] == 3){
			foreach ($goods_ext as $goods_ext_item){
				//商品在活动商品中
				if ($goods_ext_item['goods_barcode'] == $goods_info['goods_barcode']){
					$gift_info = $this->giftList($goods_num,$gift_ext);
					break;
				}
			}
		}
		
		return $gift_info;
	}
	
	/**
	 * 
	 * @param unknown $shop_info	店铺id
	 * @param unknown $user_id		用户id
	 * @param unknown $goods_fee	商品金额
	 */
	private function getDeliverFee($shop_id,$user_id,$total_price) {
		//店铺用户模型
		$ShopUser = D('Home/ShopUser');
		//店铺模型
		$Shop = D('Home/Shop');
		$shop_user_info = $ShopUser->$shogetShopUserInfo($shop_id,$user_id);
		$shop_info = $Shop->getInfoById($shop_id);
		//运费
		$post_free = 0; 
		
		if ($shop_user_info['shopuser_free'] == 0 && $total_price < $shop_info['shop_nodeliverfee']){
			$post_free = $shop_info['shop_deliverfee'];
		}
		
		return $post_free;
	}
}

?>