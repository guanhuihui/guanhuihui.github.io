<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Liukw at 2016/02/14
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/**
 * 评分接口模块
 */
class ScoreController extends UserFilterController {
	
	public function _initialize(){
   		 parent::_initialize();
	}
	
	/**
	 * 初始化评论选项
	 */
	public function get_option(){
		$this->checkLogin();
		//订单编号
		$order_no = I('post.order_no', ''); 
		//订单编号不能为空
		if(empty($order_no)) json_error(20703, array('msg'=>C('ERR_CODE.20703')));
		
		$Order = D('Home/OrderNew');
		$order_data = $Order->getInfoByNo($order_no);
		//数据库查询失败
		if($order_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		//订单不存在
		if(empty($order_data)) json_error(20704, array('msg'=>C('ERR_CODE.20704')));
		
		$goods_list = null;
		$OrderGoods = D('Home/OrderGoods');
		$_goods_list = $OrderGoods->getGoodsList($order_data['order_no']);
		//数据整理
		if($_goods_list){
			$goods_list = array();
			foreach ($_goods_list as $val){
				$data = array();
				$data['goods_id'] = $val['goods_id'];
				$data['goods_name'] = $val['goods_name'];
				$data['goods_pic'] = $val['goods_pic'];
				$data['type'] = $val['type'];
				$goods_list[] = $data;
			}
		}
		
		$data = array();
		//订单编号
		$data['order_no'] = $order_data['order_no'];
		//下单时间
		$data['add_time'] = $order_data['add_time'];		
		//商品列表
		$data['goods_list'] = $goods_list;
		//选择标签
		$data['tag'] = array('送货速度快','服务态度好','商品质量优','价格比较便宜','送货前主动联系我','使用礼貌用语','当面验货很贴心','味道好');

 		json_success($data);
	}
	
	
	/**
	 * 添加评分
	 */
	public function add(){
		$this->checkLogin();
		//订单编号
		$order_no = I('post.order_no', '');
		//评价等级
		$score = I('post.score', 0);
		//标签
		$tag = I('post.tag', '');
		//评价内容
		$content = I('post.content', '');
		
		//订单编号不能为空
		if(empty($order_no)) json_error(20703, array('msg'=>C('ERR_CODE.20703')));		
		//评价等级不能为空
		if(empty($score)) json_error(21103, array('msg'=>C('ERR_CODE.21103')));
		//保证等级不越界
		if($score>5) $score=5;
		if($score<0) $score=0;
		//评价内容不能为空
// 		if(empty($content)) json_error(21104, array('msg'=>C('ERR_CODE.21104')));
		
		$Order = D('Home/OrderNew');
		$order_data = $Order->getInfoByNo($order_no);
		//数据库查询失败
		if($order_data === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		//订单不存在
		if(empty($order_data)) json_error(20704, array('msg'=>C('ERR_CODE.20704')));
		//保证用户操作自有订单
		if($order_data['user_id']!=$this->uid) json_error(10403, array('msg'=>C('ERR_CODE.10403')));
		//完成订单才可评分
		if($order_data['order_status']!=8) json_error(21101, array('msg'=>C('ERR_CODE.21101')));
		//订单已评分
		if($order_data['score']) json_error(21102, array('msg'=>C('ERR_CODE.21102')));
		$shop_id = $order_data['shop_id'];
		
		//保存评分信息
		$Score = D('Home/Score');
		$score_data = array();
		$score_data['order_no'] = $order_no;
		$score_data['shop_id'] = $shop_id;
		$score_data['score'] = $score;
		$score_data['tag'] = $tag;
		$score_data['content'] = $content;
		$score_data['add_time'] = time();
		$result = $Score->add($score_data);
		if($result){			
			//更新店铺积分
			$Shop = D('Home/Shop');
			$Shop->updateScore($shop_id);
			json_success(array('msg'=>'ok'));
		}
		
		//订单评分失败
		json_error(21101, array('msg'=>C('ERR_CODE.21101')));
	}
	
}