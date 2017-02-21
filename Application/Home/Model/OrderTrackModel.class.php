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
class OrderTrackModel{
	
	/** 
	 * 订单跟踪信息
	 */
	public function getInfoById($track_id){
		if(empty($track_id)){
			return false;
		}
	
		$Ordertrack = M('Ordertrack');
		$where['ordertrack_id'] = $track_id;
		$data = $Ordertrack->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加订单跟踪信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Ordertrack = M('Ordertrack');
		$result = $Ordertrack->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除订单跟踪
	 */
	public function del($track_id) {
		if (empty($track_id)) {
			return false;
		}
	
		$Ordertrack = M('Ordertrack');
		$where['ordertrack_id'] = $track_id;
		$result = $Ordertrack->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改订单跟踪信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['ordertrack_id'])){
			$track_id = $data['ordertrack_id'];
			unset($data['ordertrack_id']);
	
			$Ordertrack = M('Ordertrack');
			$result = $Ordertrack->where(" ordertrack_id = %d ",$track_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询订单跟踪列表
	 */
	public function getList() {
		$Ordertrack = M('Ordertrack');
		$list = $Ordertrack->select();
	
		return $list;
	}
	
	/**
	 * 获取商户拒单数量
	 */
	public function getDenyOrderCount($ordertrack_actorid) {
		
		$where = " ordertrack_actortype = 1 and ordertrack_actioncode = 1 ";
		
		if ($ordertrack_actorid){
			$where .= " ordertrack_actorid = '$ordertrack_actorid' ";
		}
		
		$OrderTrack = M('Ordertrack');
		$result = $OrderTrack->where($where)->count();

		return $result;
	}
	
	/**
	 * 获取商户拒单列表
	 */
	public function getDenyOrderList($ordertrack_actorid,$page = 1, $pagesize = 10) {

		$where = " ordertrack_actortype = 1 and ordertrack_actioncode = 1 ";
		
		if ($ordertrack_actorid){
			$where .= " and  ordertrack_actorid = '$ordertrack_actorid' ";
		}
		
		$startRow = ($page - 1) * $pagesize;
		
		$OrderTrack = M('Ordertrack');
		$data = $OrderTrack->where($where)->order(' ordertrack_time desc ')->limit($startRow,$pagesize)->select();

		return $data;
	}
	
}