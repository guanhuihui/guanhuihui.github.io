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
 * 店铺商品模型
 */
class ShopGoodsModel{
	
	/**
	 * 店铺商品信息
	 */
	public function getInfoById($shop_id, $goods_id){
		if(empty($shop_id) || empty($goods_id)){
			return false;
		}
	
		$ShopGoods = M('Shopgoods');
		$where['shopgoods_shop'] = $shop_id;
		$where['shopgoods_goods'] = $goods_id;
		$data = $ShopGoods->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加店铺商品信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$ShopGoods = M('Shopgoods');
		$result = $ShopGoods->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除店铺商品
	 */
	public function del($goods_id) {
		if (empty($goods_id)) {
			return false;
		}
	
		$ShopGoods = M('Shopgoods');
		$where['shopgoods_id'] = $goods_id;
		$result = $ShopGoods->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改店铺商品信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['shopgoods_id'])){
			$goods_id = $data['shopgoods_id'];
			unset($data['shopgoods_id']);
	
			$ShopGoods = M('Shopgoods');
			$result = $ShopGoods->where(" shopgoods_id = %d ",$goods_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 哈哈镜商品修改同时修改产品库
	 */
	public function editShop($data,$where){
		if (empty($where)) {
			return false;
		}
	
		if(isset($where['shopgoods_goods'])){
			
			$ShopGoods = M('Shopgoods');
			$result = $ShopGoods->where($where)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询店铺商品列表
	 */
	public function getList() {
		$ShopGoods = M('Shopgoods');
		$list = $ShopGoods->select();
	
		return $list;
	}
	
	/**
	 * 获取商店所以商品列表
	 */
	public function getShopGoodsList($shop_id){
		if(empty($shop_id)){
			return false;
		}
		
		$sql = "SELECT a.shopgoods_goods,a.shopgoods_sort,c.sort_name,a.shopgoods_type,a.shopgoods_price,a.shopgoods_oprice,a.shopgoods_status,a.shopgoods_stockout,
				b.goods_name,b.goods_spec,b.goods_weight,b.goods_type,b.goods_brandname,b.goods_pungent,b.goods_unit,b.goods_pic3
				FROM hhj_shopgoods a 
				LEFT JOIN hhj_goods b ON a.shopgoods_goods = b.goods_id 
				LEFT JOIN hhj_sort c ON a.shopgoods_sort = c.sort_id 
				WHERE a.shopgoods_shop = %d AND a.shopgoods_status = 0
				ORDER BY a.shopgoods_sort,a.shopgoods_order
				LIMIT 0,2000 ";			
		$Model = new Model();
		$list = $Model->query($sql, $shop_id);
		return $list;
	}
	
	/**
	 * Shop::goodsCount()获取当前分类的商品数量
	 *
	 * @param integer $type 商品类型0；哈哈镜商品；1；自营商品
	 * @param integer $status 上下架状态0；上架；1下架
	 * @param integer $sort
	 * @return
	 */
	public function goodsCount($sid=0, $type = -1, $status = 0, $sort = 0){
		
		$ShopGoods = M('Shopgoods');
		$map = array();
		$map['shopgoods_shop'] = $sid;
		$map['shopgoods_status'] = $status;
		if($type != -1){
			$map['shopgoods_type'] = $type;
		}
		if($sort){
			$map['shopgoods_sort'] = $sort;
		}
		
		$count = $ShopGoods->where($map)->count();
		return $count;	
	}
	
	/**
	 * getShopGoodsInfo() 获得商铺商品价格等信息
	 * 因为自营商品价格和上下架状态可能被商家更改
	 * 所以不通过Goods类获取，而采用本函数
	 *
	 * @param mixed $gid 商品ID
	 * @return void
	 */
	public function getShopGoodsInfo($shop_id, $goods_id){
		$ShopGoods = M('Shopgoods');
		$map = array();
		$map['shopgoods_shop'] = $shop_id;
		$map['shopgoods_goods'] = $goods_id;
		
		$data = $ShopGoods->where($map)->find();
		return $data;
	}
	
	/**
	 * getShopByCategorty()  根据商品分类获取店铺
	 * @param $cat_id  二级分类(20,15,40)
	 * @param $shop_id 店铺ID
	 */
	public function getShopByCategorty($cat_id, $shop_id){
		if(empty($shop_id)){
			return false;
		}
	
		$ShopGoods = M('Shopgoods');
		$map = array();
		$map['shopgoods_shop'] = $shop_id;
		$map['shopgoods_status'] = 0;
		$map['shopgoods_sort'] = array('in', $cat_id);
		$data = $ShopGoods->where($map)->find();
		return $data;
	}
	
	/**
	 * getGoodsByGoodsName()  根据商品名称获取
	 * @param $shop_id 店铺ID
	 * @param $goodsname 商品名称
	 */
	
	public function getGoodsByGoodsName($shop_id, $goodsname){
		if(empty($shop_id) || empty($goodsname)){
			return  false;
		}
	
		$sql = "SELECT a.goods_id,a.goods_name,a.goods_pic3,a.goods_weight,a.goods_spec,a.goods_unit,a.goods_pungent,a.goods_type,a.goods_brandname,
				b.shopgoods_price,b.shopgoods_oprice,b.shopgoods_goods,b.shopgoods_sort,b.shopgoods_shop,b.shopgoods_status,b.shopgoods_stockout
				FROM hhj_goods a
				LEFT JOIN hhj_shopgoods b ON a.goods_id = b.shopgoods_goods
				WHERE b.shopgoods_status=0 AND b.shopgoods_shop = %s AND a.goods_name like '%s'
				LIMIT 0,500 ";
		$Model = new Model();
		$list = $Model->query($sql, $shop_id, $goodsname);
		return $list;
	
	}
	
	/**
	 * 根据条件查找商户商品
	 */
	public function getShopGoods($where, $page = 1, $pagesize = 20){
		$startrow = ($page - 1) * $pagesize;
		$ShopGoods = M('Shopgoods');
		if(empty($where)) $where=1;
		$data = $ShopGoods->where($where)->limit("$startrow, $pagesize")->select();
		return $data;
	}
	
	/**
	 * 根据条件获取商品数量
	 */
	public function getShopGoodsCount($where){
		$ShopGoods = M('Shopgoods');
		if(empty($where)) $where=1;
		$data = $ShopGoods->where($where)->count();
		return $data;
	}
}