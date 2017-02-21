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
 * 哈粉定制商品模型
 */
class FansGoodsModel{
	
	/** 
	 * 哈粉定制商品信息fansgoods_id
	 */
	public function getInfoById($goods_id){
		if(empty($goods_id)){
			return false;
		}
	
		$Fansgoods = M('Fansgoods');
		$where['fansgoods_id'] = $goods_id;
		$data = $Fansgoods->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加哈粉定制商品信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Fansgoods = M('Fansgoods');
		$result = $Fansgoods->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除哈粉定制商品
	 */
	public function del($goods_id) {
		if (empty($goods_id)) {
			return false;
		}
	
		$Fansgoods = M('Fansgoods');
		$where['fansgoods_id'] = $goods_id;
		$result = $Fansgoods->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改哈粉定制商品信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['fansgoods_id'])){
			$goods_id = $data['fansgoods_id'];
			unset($data['fansgoods_id']);
	
			$Fansgoods = M('Fansgoods');
			$result = $Fansgoods->where(" fansgoods_id = %d ",$goods_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询哈粉定制商品列表
	 */
	public function getList() {
		$Fansgoods = M('Fansgoods');
		$map = array();
		$map[fansgoods_status] = 0;
		$list = $Fansgoods->order('fansgoods_id desc')->select();
	
		return $list;
	}
}