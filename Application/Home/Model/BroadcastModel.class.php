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
 * 站内广播模型
 */
class BroadcastModel{
	
	/** 
	 * 站内广播信息
	 */
	public function getInfoById($broadcast_id){
		if(empty($broadcast_id)){
			return false;
		}
	
		$Broadcast = M('Broadcast');
		$where['broadcast_id'] = $broadcast_id;
		$data = $Broadcast->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加站内广播信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Broadcast = M('Broadcast');
		$result = $Broadcast->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除站内广播
	 */
	public function del($broadcast_id, $poster=0) {
		if (empty($broadcast_id)) {
			return false;
		}
	
		$Broadcast = M('Broadcast');
		$map['broadcast_id'] = $broadcast_id;
		if($poster){
			$map['broadcast_poster'] = $poster;
		}
		
		$result = $Broadcast->where($map)->delete();	
		return $result;
	}
	
	/**
	 * 修改站内广播信息
	 */
	public function edit($id, $data){
		if (empty($id)) {
			return false;
		}
	
		$Broadcast = M('Broadcast');
		$result = $Broadcast->where(" broadcast_id = %d ",$id)->save($data);
		return $result;
		
	}
	
	/**
	 * 查询站内广播列表
	 */
	public function getList() {
		$Broadcast = M('Broadcast');
		$list = $Broadcast->select();
	
		return $list;
	}
	
	/**
	 * 获取指定店铺的广播列表
	 * @param unknown $shop_id
	 * @return unknown
	 */
	public function getListByShop($shop_id) {
		
		$Broadcast = M('Broadcast');
		$map['broadcast_poster'] = $shop_id;
		// broadcast_status < 5 and broadcast_status >= 0 
		$map['broadcast_status'] = array('lt', 5);
		$map['broadcast_status'] = array('egt', 0);
		
		$list = $Broadcast->where($map)->order('broadcast_id desc')->select();
	
		return $list;
	}
	
	
	/**
	 * 获取广播数量
	 *
	 * @param mixed $poster 当前商户ID，-1时为所有广播
	 * @return
	 */
	public function getBroadCastNum($poster = -1){
	
		$map = array();
		$map['broadcast_status'] = 0;
		$map['broadcast_poster'] = $poster;
		 
		$num = 0;
		$Broadcast = M('Broadcast');
		if($poster != -1){
			$num = $Broadcast->where($map)->count();
		}else{
			$num = $Broadcast->count();
		}
		
		//查看当前是否有广播未审核
		return $num;
	}
	
	public function getNumByMonth($poster){
	
		$map = array();		
		//查看本月内公告是否有发推送 本月1号时间戳
		$time1 = mktime(0, 0, 0, date('m'), 1, date('Y'));
		$map['broadcast_status'] = 1;
		$map['broadcast_time'] = array('gt', $time1);
		$map['broadcast_time'] = array('lt', time());
		$map['broadcast_poster'] = $poster;
		$map['broadcast_issend'] = 1;
		
		$Broadcast = M('Broadcast');
		$num = $Broadcast->where($map)->count();
		return $num;
	}
	
	/**
	 * 广播发布
	 * @return unknown
	 */
	public function post($broadcast_id, $shop_id){
	
		//检测该广播是否已经审核通过
		$data = $this->getInfoById($broadcast_id);
		if($data){
			if($data['broadcast_status'] != 1){
				return -1;//该广播审核未通过
			}else{
				
				//检测该广播是否已经审核通过
				$bc_data = array();
				$bc_data['broadcast_status'] = 5;
				$map = array();
				$map['broadcast_id'] = $broadcast_id;
				if($shop_id){
					$map['broadcast_poster'] = $shop_id;
				}
				
				$Broadcast = M('Broadcast');
				$result = $Broadcast->where($map)->data($bc_data)->save();				
				
				//再将目标广播发布
				$bc_data['broadcast_status'] = 2;
				$result = $Broadcast->where($map)->data($bc_data)->save();			
				
				return 1;
			}
		}else{
			return -2;//该广播不存在
		}	
	}
	
	/**
	 * 获取发布的单条广播信息
	 */
	public function getShowItem($shop_id){
		
		if(empty($shop_id)){
			return false;
		}
		
		$Broadcast = M('Broadcast');
		$where['broadcast_poster'] = $shop_id;
		$where['broadcast_status'] = 2;
		$data = $Broadcast->where($where)->find();
		
		return $data;
	}
	
	
}