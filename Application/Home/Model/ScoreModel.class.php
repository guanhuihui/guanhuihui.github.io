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
 * 评分模型
 */
class ScoreModel{
	
	/**
	 * 获取评分信息
	 */
	public function getInfoById($score_id){
		if(empty($score_id)){
			return false;
		}
	
		$Score = M('Score');
		$where['score_id'] = $score_id;
		$data = $Score->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 获取评分信息
	 */
	public function getOrderNo($order_no){
		if(empty($order_no)){
			return false;
		}
	
		$Score = M('Score');
		$where['order_no'] = $order_no;
		$data = $Score->where($where)->order('score_id desc')->find();
	
		return $data;
	}
	
	/**
	 * 添加评分信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		//保存评分记录
		$Score = M('Score');
		$result = $Score->data($data)->add();
		//需改订单评分
		$Order = M('OrderNew');
		$Order->where("order_no='%s'",$data['order_no'])->data(array('score' => $data['score']))->save();	
		return $result;
	}
	
	/**
	 * 根据条件查询评论
	 * $where
	 */
	public function getList($where,$page,$pagesize){
		$startrow = ($page - 1) * $pagesize;
		$Score = M('Score');
		$data = $Score->where($where)->limit("$startrow, $pagesize")->order('score_id desc')->select();
		
		return $data;
	}
	
	/**
	 * 总数
	 */
	public function count($where){
		$Score = M('Score');
		
		$count = $Score->where($where)->count();
		
		return $count;
	}
}