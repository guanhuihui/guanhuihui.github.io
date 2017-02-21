<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangpp at 2016/0309
// +----------------------------------------------------------------------

namespace Rest_2\Controller;
use Think\Log;

/**
 * 订货系统接口
 */
class OrderSystemController{
	
	/**
	 * 获取商户赠品数量
	 */
	public function shop_gift_count(){
		$shop_id = I('post.shop_id', 0); //商户id
		if(empty($shop_id)) json_error(22001, array('msg'=>C('ERR_CODE.22001')));
		$ShopGift = M('Home/ShopGift');
		$where['shop_id'] = array('eq',$shop_id);
		$shop_gift = $ShopGift->where($where)->group('goods_id')->select();
		
		json_success($shop_gift);
	}
	
	/**
	 * 更改商户赠品数量
	 * $status 1为加 2为减
	 */
	public function shop_gift_change(){
		$shop_id = I('post.shop_id', 0);
		$status = I('post.status', 0);
		$goods_id = I('post.goods_id', 0);
		$number = I('post.number', 0);
		if(empty($shop_id)) json_error(22001, array('msg'=>C('ERR_CODE.22001')));
		if(empty($status)) json_error(22002, array('msg'=>C('ERR_CODE.22002')));
		if(empty($goods_id)) json_error(22003, array('msg'=>C('ERR_CODE.22003')));
		$Shop = D('Home/Shop');
		if($status == 1){
			$Shop->giftsCountAdd($shop_id,$goods_id,$number);
		}elseif($status == 2){
			$Shop->giftsCountReduce($shop_id,$goods_id,$number);
		}
		json_success(array('msg'=>'ok'));
	}
	
	public function gift_count_by_shop(){
		$shop_id = I('post.shop_id', 0); //商户id
		$goods_id = I('post.goods_id', 0); 
		if(empty($shop_id)) json_error(22001, array('msg'=>C('ERR_CODE.22001')));
		if(empty($goods_id)) json_error(22003, array('msg'=>C('ERR_CODE.22003')));
		$ShopGift = M('Home/ShopGift');
		$where['shop_id'] = array('eq',$shop_id);
		$where['goods_id'] = array('eq',$goods_id);
		$res = $ShopGift->where($where)->find();
		
		json_success(array('count'=>$res['goods_count']));
	}
}