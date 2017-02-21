<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ZhaoBo at 2015/11/17
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/** 
 * 手机验证码管理
 */
class PublicController extends UserFilterController{
	
	public function _initialize(){
		parent::_initialize();
	}
	
	/**
	 * 获取手机验证码
	 */	
	public function send_auth_code(){
		
		/********接收参数********/
		$mobile = I('post.mobile', ''); //手机号
		$type = I('post.type_id', 1);  //验证类型 默认为注册	

		/********验证参数********/
		if(empty($mobile)) return_error('20101', array('msg'=>C('ERR_CODE.20101'))); //手机号不能为空
		if(empty($type)) return_error('20301', array('msg'=>C('ERR_CODE.20301'))); //验证类型为空

		$AuthCode = D('Home/AuthCode');
		$result = $AuthCode->checkSendFrequency($mobile, $type); //发送间隔判断
		if(!$result) return_error('20302', array('msg'=>C('ERR_CODE.20302'))); //请稍后再尝试
		
		$code = rand(1000,9999); //生成校验码
		$auth_id = $AuthCode->addCode($mobile, $code, $type);
		if($auth_id){
			$content = '手机验证码为'.$code.'，有效期10分钟。';
			send_sms($mobile, $content);
			json_success(array('auth_id' => $auth_id));
		}else{
			//获取验证码失败
			json_error('20303',array('msg'=>C('ERR_CODE.20303')));
		}		
	}
	
	/**
	 * 版本检测 赵波
	 */
	public function check_version(){
		/********接收参数********/
		$version_number = $this->client_version; //版本号信息
		
		if(empty($version_number))	json_error(20304, array('msg'=>C('ERR_CODE.20304'))); //非法版本参数
		
		$version = explode(".", $version_number);
		$number = 0;
		if(count($version)==3){
			$number = $version[0]*100*100 + $version[1]*100 + $version[2];
		}
		
		$data = array();//版本返回信息
		$data['is_upgrade'] = 0;
		$data['app_isforce'] = 0;
		$data['app_url'] = '';
		
		if($number && $number<1){
			$data['is_upgrade'] = 1;
			$data['app_isforce'] = 1;
			$data['app_url'] = '';			
		}
		
		json_success($data);
	}

	/**
	 * 城市ID和省份ID 转换接口  赵波
	 */
	public function change_code(){
		/**接收参数**/
		$city_code = I('post.city_code', 0);  //百度城市code
		if(empty($city_code))  json_error(20506, array('msg'=>C('ERR_CODE.20506'))); //城市code不能为空
		
		//获取城市ID和省份ID
		$City = D('Home/city');
		$result = $City->changeCityCode($city_code);
		if($result){
			$citylist = $City->getList();
			if($citylist){
				$data = array(); //城市列表容器
				foreach($citylist as $key=>$val){
					$data[$key]['city_id'] = $val['city_id'];
					$data[$key]['city_name'] = $val['city_name'];
					$data[$key]['city_alpha'] = $val['city_alpha'];
				}
				$result['citylist'] = $data;
			}
		}
		
		if($result === false){
			json_error(10201, array('msg'=>C('ERR_CODE.10201'))); //数据库查询失败
		}else{
			json_success($result);
		}
	}
	
	
	/**
	 * 获取城市信息列表   赵波
	 */
	public function city_list(){
		
		$data = array();
		//设置热门城市ID配置 (北京,成都,重庆,广州,杭州,南京,上海,深圳,天津,武汉,西安)
		
// 		$hot_city = array(133,61,37,45,103,104,46,132,65,56);
		
		$City = D('Home/City');
		//热门城市列表
		$host_list = $City->getList(true, 'city_order asc');
		if($host_list === false) json_error(10201, array('msg'=>C('ERR_CODE.10201'))); //数据库查询失败
		
		//城市列表信息
		$city_list = $City->getList();
		if($city_list === false) json_error(10201, array('msg'=>C('ERR_CODE.10201'))); //数据库查询失败
		
		$data['host_city'] = $host_list;
		$data['city_list'] = $city_list;
		
		json_success($data);
		
	}
	
	/**
	 * 获取城市区域信息   赵波
	 */
	public function area_list(){
		
		/**接收参数**/
		$city_id = I('post.city_id', 0);  //城市id
		$area_id = I('post.area_id', 0);  //区域id
		
		if(empty($city_id))  json_error(20506, array('msg'=>C('ERR_CODE.20506'))); //城市id不能为空
		$City = D('Home/City');
		$Area = D('Home/Area');
		
		$city_info = $City->getInfoById($city_id);
		
		//获取区域信息
		$area_list = $Area->getListByCityId($city_id, $area_id);
		if($area_list === false) json_error(10201, array('msg'=>C('ERR_CODE.10201'))); //数据库查询失败
		
		$list = array();
		if($area_list){
			foreach($area_list as $val){
				$val['city_name'] = $city_info['city_name'];
				if(count($list)==0){
					$v = $val;
					$v['area_id'] = '0';
					$v['area_name'] = '全城';
					$list[] = $v;
				}
				$list[] = $val;
			}			
		}
		
		json_success($list);		
	}
}