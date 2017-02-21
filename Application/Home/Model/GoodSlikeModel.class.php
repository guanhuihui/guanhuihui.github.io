<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangpp at 2015/10/23
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 订单跟踪模型
 */
class GoodsLikeModel{
	
	/** 
	 * 订单跟踪信息goodslike_id
	 */
	public function getInfoById($like_id){
		if(empty($like_id)){
			return false;
		}
	
		$Goodslike = M('Goodslike');
		$where['goodslike_id'] = $like_id;
		$data = $Goodslike->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加订单跟踪信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Goodslike = M('Goodslike');
		$result = $Goodslike->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除订单跟踪
	 */
	public function del($like_id) {
		if (empty($like_id)) {
			return false;
		}
	
		$Goodslike = M('Goodslike');
		$where['goodslike_id'] = $like_id;
		$result = $Goodslike->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改订单跟踪信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['goodslike_id'])){
			$like_id = $data['goodslike_id'];
			unset($data['goodslike_id']);
	
			$Goodslike = M('Goodslike');
			$result = $Goodslike->where(" goodslike_id = %d ",$like_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询订单跟踪列表
	 */
	public function getList() {
		$Goodslike = M('Goodslike');
		$list = $Goodslike->select();
	
		return $list;
	}
	
	/**
	 * 点赞～
	 *
	 * @param mixed $uid  用户ID
	 * @param mixed $gid  商品ID
	 * @return >0点赞成功
	 */
	public function like($uid, $gid){

		$data = array();
		$data['goodslike_goods'] = $gid;
		$data['goodslike_user'] = $uid;
		$data['goodslike_time'] = time();
		
		$Goodslike = M('Goodslike');
		$result = $Goodslike->data($data)->add();
		
		//更新喜欢数量
		$Goods = M('Goods');
		$Goods->where(" goods_id = %d ", $gid)->setInc('goods_likecount');

		return $result;
	}
	
	/**
	 * 是否点过赞～
	 *
	 * @param mixed $uid  用户ID
	 * @param mixed $gid  商品ID
	 * @return  0--未赞  1--已赞
	 */
	public function isLike($uid, $gid){
	
		$Goodslike = M('Goodslike');
		$map['goodslike_user'] = $uid;
		$map['goodslike_goods'] = $gid;
		
		$data = $Goodslike->where($map)->find();
		if($data){
			return true;
		}else{
			return false;
		}
	}
}