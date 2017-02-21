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
 * 优惠券临时码模型
 */
class ExchangeLogModel{
	
	/** 
	 * 优惠券临时码信息
	 */
	public function getInfoById($exchange_id){
		if(empty($exchange_id)){
			return false;
		}
	
		$Exchangelog = M('Exchangelog');
		$where['exchangelog_id'] = $exchange_id;
		$data = $Exchangelog->where($where)->find();
	
		return $data;
	}
	
	public function getInfoByExchangeLogCode($exchangelog_code) {
		
		if (empty($exchangelog_code)){
			return false;
		}
		
		$Exchangelog = M('Exchangelog');
		$where['exchangelog_code'] = $exchangelog_code;
		$data = $Exchangelog->where($where)->order(' exchangelog_id desc ')->find();
		
		return $data;
	}
	
	/**
	 * 添加优惠券临时码信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Exchangelog = M('Exchangelog');
		$result = $Exchangelog->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除优惠券临时码
	 */
	public function del($exchange_id) {
		if (empty($exchange_id)) {
			return false;
		}
	
		$Exchangelog = M('Exchangelog');
		$where['exchangelog_id'] = $exchange_id;
		$result = $Exchangelog->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改优惠券临时码信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['exchangelog_id'])){
			$exchange_id = $data['exchangelog_id'];
			unset($data['exchangelog_id']);
	
			$Exchangelog = M('Exchangelog');
			$result = $Exchangelog->where(" exchangelog_id = %d ",$exchange_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询优惠券临时码列表
	 */
	public function getList(){
		$Exchangelog = M('Exchangelog');
		$list = $Exchangelog->select();
	
		return $list;
	}
	
	/**
	 * Table_app::getInfoByCode()根据code获取兑换信息
	 *
	 * @param mixed $code
	 * @return
	 */
	public function getInfoByCode($code){
		if(empty($code)){
			return false;
		}
		
		$Exchangelog = M('Exchangelog');
		$map['exchangelog_code'] = $code;
		$data = $Exchangelog->where($map)->order('exchangelog_id desc')->find();

		if($data){
			return self::struct($data);
		}else{
			return false;
		}
	}
	
	public function struct($data){
		$r = array();
		 
		$r['id']       = $data['exchangelog_id'];
		$r['couponid'] = $data['exchangelog_couponid'];
		$r['addtime']  = $data['exchangelog_addtime'];
		$r['status']   = $data['exchangelog_status'];
		$r['code']     = $data['exchangelog_code'];
		return $r;
	}
}