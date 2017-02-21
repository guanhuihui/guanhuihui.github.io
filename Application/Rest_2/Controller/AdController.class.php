<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ZhaoBo at 2015/11/30
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/**
 * 广告管理
 */
class AdController extends UserFilterController {
	
	public function _initialize(){
   		 parent::_initialize();
	}
	
	/*
	 * 获取启动广告列表
	 */
	public function get_list(){
		/***获取参数***/
		$place = I('post.place', ''); //广告位置,多选中间加逗号，空为全选
		$type = I('post.type_id', '');  //广告类型  1.首页广告   2.启动广告   3.开机广告     默认为''  
		$province_id = I('post.province_id', 0); //省份ID
		$city_id = I('post.city_id', 0); //城市ID
		
		$Banner = D('Home/banner');

		$_list = $Banner->getAdList($type, $place);
		if($_list === false) json_error(10201, array('msg'=>C('ERR_CODE.10201'))); //数据库查询失败
		
		$list = array();		
		if($_list){//区域过滤
			foreach($_list as $val){
				$data = array();
				$data['banner_id'] = $val['banner_id'];  //广告ID
				$data['pic'] = $val['pic'];              //图片路径
				$data['url'] = $val['url'];              //跳转地址
				$data['addtime'] = $val['addtime'];      //广告添加时间
				$data['endtime'] = $val['end_time'];    //广告下线时间
				$data['type'] = $val['type'];            //广告类型区分 1首页广告 2启动广告 3开机广告
				$data['place'] = $val['place'];          //广告位置
				
				//根据区域筛选数据
				$range_ext = json_decode($val['range_ext']);
				if($val['range'] == 1){//全国					
					$list[] = $data;						
				}else if($val['range'] == 2){//省份
					if($province_id && in_array($province_id, $range_ext)){
						$list[] = $data;
					}
				}else if($val['range'] == 3){//市
					if($city_id && in_array($city_id, $range_ext)){
						$list[] = $data;
					}
				}
			}
		}		
		
		json_success($list?$list:null);
	}
	
}