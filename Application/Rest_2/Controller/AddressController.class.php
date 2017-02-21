<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: ZhaoBo at 2015/11/13
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/**
 * 地址管理
 */
class AddressController extends UserFilterController {
	
	public function _initialize(){
   		 parent::_initialize();
	}
	
	public function detail(){
		//登陆验证
		$this->checkLogin();
		$address_id = I('post.address_id', 0); //用户地址ID 0时获取默认地址
		
		$Address = D('Home/UserAddress');
		$address_data = null;
		if($address_id){
			$address_data = $Address->getInfoById($address_id);
		}else{
			$address_data = $Address->getDefault($this->uid);
		}		
		
		if($address_data){
			$data = array();
			$data['addressid'] = $address_data['useraddress_id'];
			$data['userid'] = $address_data['useraddress_user'];
			$data['username'] = $address_data['useraddress_name'];
			$data['phone'] = $address_data['useraddress_phone'];			
			$data['provincename'] = $address_data['province_name'];
			$data['cityname'] = $address_data['city_name'];
			$data['cityid'] = $address_data['useraddress_city'];
			$data['provinceid'] = $address_data['useraddress_province'];
			$data['areaname'] = $address_data['detail_area'];
			$data['district'] = $address_data['useraddress_district'];
			$data['lng'] = $address_data['useraddress_lng'];
			$data['lat'] = $address_data['useraddress_lat'];
			$data['address'] = $address_data['useraddress_address'];
			$data['default'] = $address_data['useraddress_default'];
			$address_data = $data;
	   }
	   
	   if($address_data === false){
	   	  json_error(10201, array('msg'=>C('ERR_CODE.10201'))); //数据库查询失败
	   }else{
	   	  json_success($address_data);
	   }
	}
	
	/**
	 * 根据用户ID获取地址列表
	 */	
	public function get_list(){
		//显示数量
		$num = I('post.num', 10);
		
		//登陆验证
 		$this->checkLogin();
							
		/********获取用户地址信息列表********/
		$Address = D('Home/UserAddress');
				
		$list = $Address->getListByUser($this->uid, $num);
		if ($list){
			//对信息重组
			$data = array();
			
			foreach ($list as $key => $val){
				//检测地址中是否有特殊符号
				$res = preg_match('/,|@|!|。/i', $val['useraddress_district']);
				if($val['useraddress_lng'] == 0 || $val['useraddress_lat'] == 0 || $res){//过滤经纬度为0 的地址
					continue;
				}
				
				$data[$key]['addressid'] = $val['useraddress_id'];
				$data[$key]['userid'] = $val['useraddress_user'];
				$data[$key]['username'] = $val['useraddress_name'];
				$data[$key]['district'] = $val['useraddress_district'];
				$data[$key]['lng'] = $val['useraddress_lng'];
				$data[$key]['lat'] = $val['useraddress_lat'];
				$data[$key]['address'] = $val['useraddress_address'];
				$data[$key]['phone'] = $val['useraddress_phone'];
				$data[$key]['areaid'] = $val['useraddress_area'];
				$data[$key]['cityid'] = $val['useraddress_city'];
				$data[$key]['provinceid'] = $val['useraddress_province'];
				$data[$key]['default'] = $val['useraddress_default'];
				$data[$key]['provincename'] = $val['province_name'];
				$data[$key]['cityname'] = $val['city_name'];
				$data[$key]['areaname'] = $val['detail_area'];
				$data[$key]['city_baiducode'] = $val['city_baiducode'];
			 }
			 $list = array_values($data);
			 
		}
      	
		if($list === false){ //数据库查询失败
			json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		}else{
 			json_success($list);
			
		}						
	}
	
	/**
	 * 用户添加地址（新地址为默认地址）赵波
	 */
	public function add(){
		//登陆验证
		$this->checkLogin();
		
		$city_id = I('post.city_id', 0); //用户城市ID
		
		/********接收添加的信息********/
		$data = array();
		$data['useraddress_user'] = $this->uid;  //用户ID
		$data['useraddress_name'] = I('post.name', ''); //用户名
		$data['useraddress_district'] = I('post.district', '');//用户定位区域
		$data['useraddress_address'] = I('post.address', ''); //用户地址
		$data['useraddress_phone'] = I('post.mobile', ''); //用户手机号
		$data['useraddress_city'] = $city_id; //用户城市ID
		$data['useraddress_default'] = 1; //设置为默认地址
		$data['useraddress_lng'] = I('post.lng', 0);  //百度经度
		$data['useraddress_lat'] = I('post.lat', 0);  //百度纬度
		
		if(empty($data['useraddress_name'])) json_error(20502, array('msg'=>C('ERR_CODE.20502'))); //收件人名字不能为空
		if(empty($data['useraddress_address'])) json_error(20503, array('msg'=>C('ERR_CODE.20503'))); //地址不能为空
		if(empty($data['useraddress_phone'])) json_error(20504, array('msg'=>C('ERR_CODE.20504'))); //收件人手机号不能为空
		if(empty($data['useraddress_district'])) json_error(20505, array('msg'=>C('ERR_CODE.20505'))); //区域信息不能为空
		if(empty($city_id)) json_error(20506, array('msg'=>C('ERR_CODE.20506'))); //城市ID不能为空
		
		/********添加地址信息********/		
		$City = D('Home/City');
		$cityinfo = $City->getInfoById($city_id);
		if($cityinfo){
			$data['useraddress_province'] = $cityinfo['city_province']; //用户省份ID
		}
		
		$Address = D('Home/UserAddress');
		$address_id = $Address->add($data); //写入数据
		if(!$address_id) json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
		
		/********初始化旧地址的状态********/
		$Address->setNoDefault($this->uid, $address_id);
		
		json_success(array('address_id'=>$address_id));
	}
	
	/**
	 * 设计默认地址 赵波
	 */
	public function set_default(){
		//登陆验证
		$this->checkLogin();
		
		/*****接收参数*******/
		$address_id = I('post.address_id', 0); //用户地址ID
		
		if(empty($address_id)) json_error(20501, array('msg'=>C('ERR_CODE.20501'))); //地址ID不能为空
		
		/*****设置默认地址*******/
		$Address = D('Home/UserAddress');		
		$result = $Address->setDefault($address_id, $this->uid);
		if($result === false) json_error(10202, array('msg'=>C('ERR_CODE.10202'))); //数据库更新失败
		
		json_success(array('msg'=>'ok'));		
	}
	
	
	/**
	 * 获取用户的默认地址 赵波
	 */
	public function get_default(){
		//登陆验证
		$this->checkLogin();
		
		/*****获取用户的默认地址*******/
		$Address = D('Home/UserAddress');
		$result = $Address->getDefault($this->uid);
		if($result === false) json_error(10202, array('msg'=>C('ERR_CODE.10202'))); //数据库更新失败
		
		if($result){
			$data = array();
			$data['addressid'] = $result['useraddress_id'];
			$data['userid'] = $result['useraddress_user'];
			$data['username'] = $result['useraddress_name'];
			$data['district'] = $result['useraddress_district'];
			$data['lng'] = $result['useraddress_lng'];
			$data['lat'] = $result['useraddress_lat'];
			$data['address'] = $result['useraddress_address'];
			$data['phone'] = $result['useraddress_phone'];
			$data['areaid'] = $result['useraddress_area'];
			$data['cityid'] = $result['useraddress_city'];
			$data['provinceid'] = $result['useraddress_province'];
			$data['default'] = $result['useraddress_default'];
			$data['provincename'] = $result['province_name'];
			$data['cityname'] = $result['city_name'];
			$data['areaname'] = $result['detail_area'];
			
			$result = $data;
		}
		json_success($result);
	}
	
	
	/**
	 * 获取用户上次下单的地址 赵波
	 */
	
	public function get_last(){
		//登陆验证
		$this->checkLogin();
		
		$Order = D('Home/OrderNew');
		$Address = D('Home/UserAddress');
		
		/*****获取用户的最后一单地址*******/
		$last_orderinfo = $Order->getLastOrderAddress($this->uid);

		/*****获取用户的地址信息*******/
		$result = array();
		if($last_orderinfo['address_id']){
			$result = $Address->getInfoById($last_orderinfo['address_id'], $this->uid);
			if($result === false) json_error(10202, array('msg'=>C('ERR_CODE.10202'))); //数据库更新失败

			if($result){
				$data = array();
				$data['addressid'] = $result['useraddress_id'];
				$data['userid'] = $result['useraddress_user'];
				$data['username'] = $result['useraddress_name'];
				$data['district'] = $result['useraddress_district'];
				$data['lng'] = $result['useraddress_lng'];
				$data['lat'] = $result['useraddress_lat'];
				$data['address'] = $result['useraddress_address'];
				$data['phone'] = $result['useraddress_phone'];
				$data['areaid'] = $result['useraddress_area'];
				$data['cityid'] = $result['useraddress_city'];
				$data['provinceid'] = $result['useraddress_province'];
				$data['default'] = $result['useraddress_default'];
				$data['provincename'] = $result['province_name'];
				$data['cityname'] = $result['city_name'];
				$data['areaname'] = $result['detail_area'];
			
				$result = $data;
			}
		}
		
		json_success($result);
	}
	
	
	/**
	 * 修改地址 赵波
	 */
	public function edit(){
		//登陆验证
		$this->checkLogin();
		$address_id = I('post.address_id', 0); //用户地址ID
		$city_id = I('post.city_id', 0); //用户城市ID
		
		/********接收修改的信息********/
		$data = array();
		$data['useraddress_name'] = I('post.name', ''); //用户名
		$data['useraddress_district'] = I('post.district', '');//用户定位区域
		$data['useraddress_address'] = I('post.address', ''); //用户地址
		$data['useraddress_phone'] = I('post.mobile', ''); //用户手机号
		$data['useraddress_city'] = $city_id; //用户城市ID
		$data['useraddress_lng'] = I('post.lng', 0); //百度经度
		$data['useraddress_lat'] = I('post.lat', 0); //百度纬度
		
		if(empty($address_id)) json_error(20501, array('msg'=>C('ERR_CODE.20501'))); //地址ID不能为空
		if(empty($data['useraddress_name'])) json_error(20502, array('msg'=>C('ERR_CODE.20502'))); //收件人名字不能为空
		if(empty($data['useraddress_address'])) json_error(20503, array('msg'=>C('ERR_CODE.20503'))); //地址不能为空
		if(empty($data['useraddress_phone'])) json_error(20504, array('msg'=>C('ERR_CODE.20504'))); //收件人手机号不能为空
		if(empty($data['useraddress_district'])) json_error(20505, array('msg'=>C('ERR_CODE.20505'))); //区域信息不能为空
		if(empty($city_id)) json_error(20506, array('msg'=>C('ERR_CODE.20506'))); //城市ID不能为空
		/********更新地址信息********/		
		$City = D('Home/City');
		$cityinfo = $City->getInfoById($city_id);
		if($cityinfo){
			$data['useraddress_province'] = $cityinfo['city_province']; //用户省份ID
		}
		
		$Address = D('Home/UserAddress');
		$where = array();
		$where['useraddress_id'] = $address_id; 
		$result = $Address->edit($data, $where); //数据更新
		if($result === false) json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
		
		json_success(array('msg'=>'ok'));
	}
	
	/**
	 * 删除用户地址
	 */
	public function del(){
		//显示数量
		$address_id = I('post.address_id', 0);
		
		if(empty($address_id)) json_error(20501, array('msg'=>C('ERR_CODE.20501'))); //地址ID不能为空
		
		$Address = D('Home/UserAddress');
		$result = $Address->del($address_id, $this->uid);
		if($result === false) json_error(10202, array('msg'=>C('ERR_CODE.10202'))); //数据库更新失败
		
		json_success(array('msg'=>'ok'));
	}
	
}