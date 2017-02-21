<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ZhaoBo at 2015/12/2
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/**
 * 首页广告管理
 */
class BannerController extends UserFilterController {
	
	public function _initialize(){
   		 parent::_initialize();
	}
	
	/**
	 * 获取广告列表
	 */
	public function get_list(){
		
		/***获取参数***/
		$place = I('post.palce', 1); //广告位置  默认为1 广告1    2为广告2
		$type = I('post.type_id', 1);  //广告类型 默认为1
		$province_id = I('post.province_id', 0); //省份ID
		$city_id = I('post.city_id', 0); //城市ID
		
		$Banner = D('Home/banner');
		$_list = $Banner->getList($place, $type);
		
		if($_list === false) json_error(10201, array('msg'=>C('ERR_CODE.10201'))); //数据库查询失败	
		$list = array();
		foreach($_list as $val){
			$range_ext = json_decode($val['range_ext']);
			//过滤省市
			if($val['range'] == 1){
				$list[] = $val;
			}else if($val['range'] == 2){
				if($province_id && in_array($province_id, $range_ext)){
					$list[] = $val;
				}					
			}else if($val['range'] == 3){
				if($city_id && in_array($city_id, $range_ext)){
					$list[] = $val;
				}
			}
		}
		
 		json_success($list);
	}
	
	
	/**
	 * 获取banner信息
	 */
	public function banner_info(){
		
		$this->display();
	}
	
}