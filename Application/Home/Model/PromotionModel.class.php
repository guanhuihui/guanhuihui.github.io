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
 * 促销公告模型
 */
class PromotionModel{
	
	/** 
	 * 促销公告信息
	 */
	public function getInfoById($promotion_id){
		if(empty($promotion_id)){
			return false;
		}
	
		$Promotion = M('Promotion');
		$where['promotion_id'] = $promotion_id;
		$data = $Promotion->where($where)->find();
	
		return $data;
	}
	
	public function getLastInfo($shop_id){
		if(empty($shop_id)){
			return false;
		}
		
		$Promotion = M('Promotion');
		$map = array();
		$map['promotion_shop'] = $shop_id;
		$map['promotion_status'] = 2;		
		$time = time();
		$map['promotion_startday'] = array('lt',$time);
		$map['promotion_days'] = array('gt',$time);		
		$data = $Promotion->where($map)->order('promotion_id desc')->find();
		return $data;
	}
	
	public function getInfoByShopId($shop_id,$promotion_status = 2) {
		
		$where = " promotion_status = $promotion_status ";
		
		if ($shop_id){
			$where .= " and promotion_shop = '$shop_id' ";
		}
		
		$Promotion = M('Promotion');
		$data =$Promotion->where($where)->find();
		
		return $data;
	}
	
	/**
	 * 添加促销公告信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Promotion = M('Promotion');
		$result = $Promotion->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除促销公告
	 */
	public function del($promotion_id) {
		if (empty($promotion_id)) {
			return false;
		}
	
		$Promotion = M('Promotion');
		$where['promotion_id'] = $promotion_id;
		$result = $Promotion->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改促销公告信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['promotion_id'])){
			$promotion_id = $data['promotion_id'];
			unset($data['promotion_id']);
	
			$Promotion = M('Promotion');
			$result = $Promotion->where(" promotion_id = %d ",$promotion_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询促销公告列表
	 */
	public function getList() {
		$Promotion = M('Promotion');
		$list = $Promotion->select();
	
		return $list;
	}
	
	/**
	 * setStatus()  设置所属商户下的公告状态
	 * @param mixed $sid 商户id
	 * @param mixed $pid 公告id 默认是 0--全部公告
	 * @param mixed $status 状态值 1：通过；4：不通过  默认为5--失效
	 */
	public function setStatus($sid, $status=5, $pid=0){
		$where = array();
		$data = array();
		if($pid){
			$where['promotion_id'] = $pid;
			$where['promotion_shop'] = $sid;
		}else{
			$where['promotion_shop'] = $sid;
		}
		
		$data['promotion_status'] = $status;
		
		$Promotion = M('Promotion');
		$result = $Promotion->where($where)->save($data);
		return $result;
	}
	
	/**
	 * 获取商户广告
	 */
	public function getByWhere($where){
		if (empty($where)) {
			return false;
		}
		$Promotion = M('Promotion');
		$data =$Promotion->where($where)->find();
		return $data;
	}
}