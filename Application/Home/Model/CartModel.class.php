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
 * 购物车模型
 */
class CartModel{
	
	/** 
	 * 购物车信息
	 */
	public function getInfoById($cart_id){
		if(empty($cart_id)){
			return false;
		}
	
		$Cart = M('CartNew');
		$where['cart_id'] = $cart_id;
		$data = $Cart->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 查询购物车商品数量汇总
	 * @param 用户id $user_id
	 * @param 店铺id $shop_id
	 * @return number
	 */
	public function getGoodsNum($user_id, $shop_id, $goods_id=0){
		if(empty($shop_id) && empty($shop_id)) {
			return 0;
		}
		
		$Cart = M('CartNew');
		$map = array();
		$map['shop_id'] = $shop_id;
		$map['user_id'] = $user_id;
		if($goods_id){
			$map['goods_id'] = $goods_id;
		}		
		
		$num = $Cart->where($map)->sum('count');
		$list = $Cart->where($map)->select();
		return $num;
	}
	
	/**
	 * 查询购物车商品列表
	 * @param 用户id $user_id
	 * @param 店铺id $shop_id
	 * @return $list
	 */
	public function getCartGoodsList($user_id, $shop_id, $goods_id=0){
		if(empty($shop_id) && empty($shop_id)) {
			return 0;
		}
	
		$map = array();
		$map['a.shop_id'] = $shop_id;
		$map['a.user_id'] = $user_id;
		if($goods_id){
			$map['a.goods_id'] = $goods_id;
		}
		
		$Cart = M('CartNew');
		$list = $Cart->alias('a')
		->field('a.*,b.shopgoods_price')
		->join('LEFT JOIN __SHOPGOODS__ b ON a.shop_id=b.shopgoods_shop AND a.goods_id=b.shopgoods_goods ')
		->where($map)
		->select();
		return $list;
	}
	
	/**
	 * 添加购物车信息
	 * @param 用户id $user_id
	 * @param 店铺id $shop_id
	 * @param 商品id $goods_id
	 * @param 商品数量 $count
	 * @param 商品类型 $type 0默认 1赠品
	 * @return cart_id or boolean
	 */
	public function add($user_id, $shop_id, $goods_id, $count=1, $type=0){
		if(empty($user_id) && empty($shop_id) && empty($goods_id)) {
			return false;
		}
	
		$Cart = M('CartNew');
		$map = array();
		$map['user_id'] = $user_id;
		$map['shop_id'] = $shop_id;
		$map['goods_id'] = $goods_id;
		$cart_data = $Cart->where($map)->find();
		
		$cart_id = false;
		if($cart_data){
			$data = array();
			$data['count'] = array('exp', 'count+'.$count);		
			$result = $Cart->where("cart_id=%d", $cart_data['cart_id'])->data($data)->save();
			if($result){
				$cart_id = $cart_data['cart_id'];
			}
		}else{
			$data = array();
			$data['user_id'] = $user_id;
			$data['shop_id'] = $shop_id;
			$data['goods_id'] = $goods_id;
			$data['count'] = $count;
			$data['type'] = $type;
			$data['add_time'] = time();
			$cart_id = $Cart->data($data)->add();
		}
		return $cart_id;
	}	
	
	/**
	 * 修改购物车信息
	 * @param 用户id $user_id
	 * @param 购物车id $cart_id
	 * @param 商品数量 $count
	 * @return boolean
	 */
	public function edit($user_id, $cart_id, $count){
		if(empty($user_id) && empty($cart_id) && empty($count)){
			return false;
		}
		
		$map = array();
		$map['cart_id'] = $cart_id;
		$map['user_id'] = $user_id;
		
		$data = array();
		$data['count'] = $count; 
	
		$Cart = M('CartNew');
		$result = $Cart->where($map)->data($data)->save();
		return $result;
	}
	
	/**
	 * 删除购物车
	 * @param 用户id $user_id
	 * @param 购物车id $cart_id
	 * @return boolean
	 */
	public function del($user_id, $cart_id) {
		if(empty($user_id) && empty($cart_id)) {
			return false;
		}
	
		$Cart = M('CartNew');
		$map = array();
		$map['cart_id'] = array('exp'," IN ($cart_id) ");
		$map['user_id'] = $user_id;
		
		$result = $Cart->where($map)->delete();	
		return $result;
	}
	
	/**
	 * 删除购物车
	 * @param 用户id $user_id
	 * @param 店铺id $shop_id
	 * @return boolean
	 */
	public function delCartByShopId($user_id, $shop_id){
		if(empty($user_id) && empty($shop_id)) {
			return false;
		}
	
		$Cart = M('CartNew');
		$map = array();
		$map['shop_id'] = $shop_id;
		$map['user_id'] = $user_id;
	
		$result = $Cart->where($map)->delete();
		return $result;
	}
	
	/**
	 * 查询购物车列表
	 * @param 用户id $user_id
	 * @param 购物车id $cart_id 默认为空，多选如1,2,3,4
	 * @return array
	 */
	public function getList($user_id, $shop_id=0, $cart_ids='', $asc='desc') {
		if (empty($user_id)){
			return false;
		}
		
		$map = array();
		$map['a.user_id'] = $user_id;
		if($shop_id){
			$map['a.shop_id'] = $shop_id;
		}
		if($cart_ids){
			$map['a.cart_id'] = array('exp',' IN ('.$cart_ids.') ');
		}
		
		$Cart = M('CartNew');
		$list = $Cart->alias('a')
		             ->field('a.*,b.goods_name,b.goods_type,b.goods_sort,b.goods_pic1,b.goods_pic2,b.goods_pic3,b.goods_weight,b.goods_unit,b.goods_spec,b.goods_pungent,b.goods_brandname,c.shop_name,c.shop_baidux,c.shop_baiduy,c.shop_deliverscope')
		             ->join('LEFT JOIN __GOODS__ b ON a.goods_id=b.goods_id ')
		             ->join('LEFT JOIN __SHOP__ c ON a.shop_id=c.shop_id ')
		             ->where($map)
		             ->order('a.add_time '.$asc)
		             ->select();
		return $list;
	}
	
	/**
	 * 查询单个店铺的购物车列表
	 * @param 用户id $user_id
	 * @param 店铺id $shop_id 默认最后添加的店铺
	 * @return array
	 */
	public function getListForShop($user_id, $shop_id=0) {
		if (empty($user_id)){
			return false;
		}
	
		$map = array();
		$map['a.user_id'] = $user_id;
		if($shop_id){
			$map['a.shop_id'] = $shop_id;
		}
	
		$Cart = M('CartNew');
		$list = $Cart->alias('a')
		->field('a.*,b.goods_name,b.goods_type,b.goods_price,b.goods_sort,b.goods_pic1,b.goods_pic2,b.goods_pic3,b.goods_weight,b.goods_unit,b.goods_spec,b.goods_pungent,b.goods_brandname,c.shop_name,c.shop_baidux,c.shop_baiduy,c.shop_deliverscope')
		->join('LEFT JOIN __GOODS__ b ON a.goods_id=b.goods_id ')
		->join('LEFT JOIN __SHOP__ c ON a.shop_id=c.shop_id ')
		->where($map)
		->order('a.add_time asc')
		->select();
		
		//店铺唯一处理
		if($list){
			$_list = array();
			$shop_id = 0;
			foreach ($list as $val){
				if(empty($shop_id)){
					$shop_id = $val['shop_id'];
				}
				
				if($shop_id == $val['shop_id']){
					$_list[] = $val;
				}				
			}			
			return $_list;
		}		
		return $list;
	}
	
	/**
	 * 获取订单中的商品信息（即将作废）
	 */
	public function getListByOrderNo($order_num){
		if(empty($order_num)){
			return false;
		}
		
		$sql = "SELECT a.*,b.* FROM (SELECT * FROM hhj_cart WHERE cart_ordercode='%s' ORDER BY cart_id ASC) a 
				LEFT JOIN hhj_goods b ON a.cart_goods = b.goods_id";	
		$Model = new Model();		
		$list = $Model->query($sql, $order_num);	
		return $list;
	}
	
	/**
	 * 获取订单中的商品信息（即将作废）
	 *
	 * @param mixed $ordercode 订单号
	 * @return
	 */
	public function getCartByCode($ordercode){
		if(empty($ordercode)){
			return false;
		}
		
		$Cart = M('Cart');
		$map = array();
		$map['cart_ordercode'] = $ordercode;
		$list = $Cart->where($map)->select();
		if($list){
			$_list = array();
			$Goods = M('Goods');
			$goods_pungent_array = C('GOODS_PUNGENT');
			foreach($list as $val){
				$_list[]['goodsid'] = $val['cart_goods'];
				$goods_data = $Goods->getInfoById($val['cart_goods']);
				
				$_list[]['goodspic'] = !empty($goods_data['goods_pic3'])? C('IMG_HTTP_URL').$goods_data['goods_pic3'] : '';
				$_list[]['goodsname'] = $ginfo->name;
				if($ginfo->type == 0){
					$_list[]['pungent'] = $goods_pungent_array[$goods_data['goods_pungent']];
				}else
					$_list[]['pungent'] = !empty($goods_data['goods_brandname'])? $goods_data['goods_brandname'] : '';
			
				$_list[]['price'] = $val['cart_price'];
				$_list[]['originprice'] = $val['cart_originprice'];
				$_list[]['isdiscount'] = $val['cart_isdiscount'];
				$_list[]['count'] = $val['cart_count'];
				$_list[]['type'] = empty($goods_data['goods_type']) ? '': $goods_data['goods_type'];
			}
			
			return $_list;
		}
		
		return false;
	}
}