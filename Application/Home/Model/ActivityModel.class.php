<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wy at 2015/11/20
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 活动模型 
 */
class ActivityModel {
	
	public function getInfoById($act_id) {
		if(empty($act_id)){
			return false;
		}
		
		$Activity = M('Activity');
		$where['act_id'] = $act_id;
		$data = $Activity->where($where)->find();
		
		return $data;
	}
	
	/**
	 * 获取活动列表
	 * @param 活动类型 $act_type	 1买赠 2优惠券 3买赠券
	 * @param 活动状态 $status  0关闭 1开启
	 */
	public function getList($act_type,$status) {
		$map = array();
		
		if ($act_type){
			$map['act_type'] = $act_type;
		}		
		if ($status){
			$map['status'] = 1;
			$now = date('Y-m-d H:i:s');
			$map['begin_time'] = array('lt', $now);
			$map['end_time'] = array('gt', $now);
		}
		
		$Activity = M('Activity');
		$data = $Activity->where($map)->select();
		return $data;
	}
	
	
	/**
	 * 获取活动列表
	 * @param $where  获取条件
	 * 
	 */
	public function getActivityList($where){
		if(empty($where)){
			return false;
		}
		
		$Activity = M('Activity');
		$data = $Activity->where($where)->select();
		
		return $data;
	}

	/**
	 * 添加活动
	 */
	public function add($data){
		if(empty($data)){
			return false;
		}
		
		$Activity = M('Activity');
		$result = $Activity->add($data);
		return $result;
	}
	
	/**
	 * 获取活动信息
	 * @param $where 条件
	 */
	public function getActInfo($where){
		if(empty($where) || !is_array($where)){
			return false;
		}
		
		$Activity = M('Activity');
		$result = $Activity->where($where)->find();
		return $result;
		
	}
	
	/**
	 * 修改活动信息
	 */
	public function edit($id, $data){
		if(empty($id)){
			return false;
		}
		$map = array();
		$map['act_id'] = $id;
		
		$Activity = M('Activity');
		$result = $Activity->where($map)->save($data);
		return $result;
	}
	
	/**
	 * 修改活动信息
	 */
	public function del($act_id){
		if(empty($act_id)){
			return false;
		}
		
		$map = array();
		$map['act_id'] = $act_id;
		
		$Activity = M('Activity');
		$result = $Activity->where($map)->delete();
		return $result;
		
	}
	
	/**
	 * 获取活动优惠券的详情信息
	 */
	public function getActivityTicketInfo($act_id){
		if(empty($act_id)){
			return false;
		}
		
		$Activity = M('Activity');
		$map = array();
		$map['a.act_id'] = $act_id;
		
		$info = $Activity->alias('a')
			    ->field('a.*,b.price,b.discount_price,b.return_price,b.add_time as ticket_add_time,b.begin_time as start_time,b.end_time as over_time,b.goods_id')
		        ->join('LEFT JOIN __TICKET__ b ON a.act_id = b.act_id ')
		        ->where($map)
		        ->find();
		
		return $info;
	}
	
	/**
	 * 获取返款的优惠券活动列表
	 */
	public function getActList() {
		
		$map = array();
		$map['act_type'] = 2;
		
		$Activity = M('Activity');
		$data = $Activity->where($map)->group('act_name')->select();
		return $data;
	}
	
	/**
	 * 根据活动名称获取活动信息
	 * @param 活动名称 $act_name  
	 */
	public function getActIdByActName($act_name){
		if(empty($act_name)){
			return false;
		}
		$map = array();
		$map['act_type'] = 2;
		$map['act_name'] = $act_name;
		
		$Activity = M('Activity');
		$data = $Activity->where($map)->field('act_id')->select();
		return $data;
		
	}
	
	/**
	 * 获取在线新买赠活动
	 */
	public function getAct(){
		$where['act_type'] = 3;
		$where['status'] = 1;
		$time = date('Y-m-d H:i:s');
		$where['begin_time'] = array('lt',$time);
		$where['end_time'] = array('gt',$time);
		
		$Activity = M('Activity');
		$result = $Activity->where($where)->find();
		return $result;
	}
}

?>