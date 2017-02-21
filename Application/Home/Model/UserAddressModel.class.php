<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangpp at 2015/10/23
// +----------------------------------------------------------------------

namespace Home\Model;
use Think\Model;

/**
 * 地址模型
 */
class UserAddressModel{
	
	/**
	 * 地址信息
	 */
	public function getInfoById($address_id, $user_id){
		if(empty($address_id)){
			return false;
		}
		
		$map = array();
		$map['a.useraddress_id'] = $address_id;
		if($user_id){
			$map['a.useraddress_user'] = $user_id;
		}
	
		$Useraddress = M('Useraddress');
		$data = $Useraddress->alias('a')
		                    ->field('a.*,d.province_name,b.city_name,c.area_name AS detail_area')
		                    ->join('LEFT JOIN __CITY__ b ON a.useraddress_city = b.city_id ')
		                    ->join('LEFT JOIN __AREA__ c ON a.useraddress_area = c.area_id ')
		                    ->join('LEFT JOIN __PROVINCE__ d ON c.area_province = d.province_id ')
		                    //LEFT JOIN hhj_province d ON a.useraddress_province = d.province_id
		                    ->where($map)
		                    ->find();
		return $data;
	}
	
	/**
	 * 添加地址信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Useraddress = M('Useraddress');
		$result = $Useraddress->add($data);
	
		return $result;
	}
	
	/**
	 * 删除地址
	 */
	public function del($address_id, $user_id=0){
		if (empty($address_id) && empty($user_id)) {
			return false;
		}
	
		$Useraddress = M('Useraddress');
		$where['useraddress_id'] = $address_id;
		if($user_id){
			$where['useraddress_user'] = $user_id;
		}
		
		$result = $Useraddress->where($where)->delete();	
		return $result;
	}
	
	/**
	 * 获得用户默认地址
	 * @param 用户id $user_id
	 * @return boolean | array
	 */
	public function getDefault($user_id){
		if (empty($user_id)) {
			return false;
		}
		
		$Useraddress = M('Useraddress');
		$data = $Useraddress->alias('a')
							->field('a.*,d.province_name,b.city_name,c.area_name AS detail_area')
							->join('LEFT JOIN __CITY__ b ON a.useraddress_city = b.city_id ')
							->join('LEFT JOIN __AREA__ c ON a.useraddress_area = c.area_id ')
							->join('LEFT JOIN __PROVINCE__ d ON c.area_province = d.province_id ')
							->where('a.useraddress_user=%d and a.useraddress_default=1', $user_id)
							->find();
		return $data;
	}
	
	/**
	 * 修改地址信息
	 */
	public function edit($data, $map){
		if (empty($map)) {
			return false;
		}
		
		$Useraddress = M('Useraddress');
		$result = $Useraddress->where($map)->data($data)->save();
		return $result;
	}
	
	/**
	 * 查询地址列表
	 */
	public function getList() {
		$Useraddress = M('Useraddress');
		
 		$list = $Useraddress->select();	
		return $list;
	}
	
	/**
	 * 获取用户地址列表
	 */
	public function getListByUser($user_id, $num=10) {
		if(empty($user_id)){
			return false;
		}
		
		$sql = "
				SELECT a.*,d.province_name,b.city_name,b.city_baiducode,c.area_name AS detail_area FROM hhj_useraddress a
				LEFT JOIN hhj_city b ON a.useraddress_city = b.city_id
				LEFT JOIN hhj_area c ON a.useraddress_area = c.area_id
				LEFT JOIN hhj_province d ON c.area_province = d.province_id
				WHERE useraddress_user = %d ORDER BY a.useraddress_default desc
				LIMIT 0,%d
		";
		
		$Model = new Model();
		$list = $Model->query($sql, $user_id, $num);
		return $list;
	}
	
	/**
	 * 设置用户的默认地址
	 */
	public function setDefault($address_id, $user_id){	
		if(empty($address_id) || empty($user_id)){
			return false;
		}
		$Useraddress = M('Useraddress');
		
		//先将用户所有地址设置为不默认
		$map = array();
		$map['useraddress_user'] = $user_id;
		$data = array();
		$data['useraddress_default'] = 0;		
		$Useraddress->where($map)->save($data);

		//再将目标地址设置为默认
		$map = array();
		$map['useraddress_id'] = $address_id;
		$map['useraddress_user'] = $user_id;
		$data = array();
		$data['useraddress_default'] = 1;
		$result = $Useraddress->where($map)->save($data);
	
		return $result;
	}
	
	
	/**
	 * 更新用户地址为非默认地址
	 */
	 public function setNoDefault($user_id, $address_id){
	 	if(empty($user_id) || empty($address_id)){
	 		return false;
	 	}
	 	
	 	$data = array();
	 	$data['useraddress_default'] = 0;
	 	
	 	$map = array();
	 	$map['useraddress_user'] = $user_id;
	 	$map['useraddress_id'] = array('not in',array($address_id));
	 	
	 	$Address = M('Useraddress');
	 	$result = $Address->where($map)->save($data);
	 	return $result; 
	 }
	
	
	
	
	
	
	
}