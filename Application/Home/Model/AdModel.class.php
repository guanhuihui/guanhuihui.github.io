<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/10/23
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 *	banner广告模型
 */
class AdModel{
	
	/**
	 * 根据id获取banner信息
	 */
	public function getInfoById($ad_id){	
		if (empty($ad_id)){
			return false;
		}
		
		$User = M('Ad');
		$map['ad_id'] = $ad_id;
		$data = $User->where($map)->find();		
		return $data;
	}
	
	/**
	 * 添加banner信息
	 */
	public function add($data = null){
		if (empty($data)) {
			return false;
		}
	
		$Ad = M('Ad');
		$result = $Ad->data($data)->add();
		return $result;
	}
	
	/**
	 * 修改banner信息
	 */
	public function edit($data = null){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['ad_id'])){
			$ad_id = $data['ad_id'];
			unset($data['ad_id']);
			
			$Ad = M('Ad');
			$result = $Ad->where(" ad_id = %d ",$ad_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 删除banner
	 */
	public function del($ad_id) {
		if (empty($ad_id)) {
			return false;
		}
	
		$Ad = M('Ad');
		$map['ad_id'] = $ad_id;
		$result = $Ad->where($map)->delete();
		return $result;
	}
	
	/**
	 * 查询banner列表
	 */
	public function getList($ad_status = '',$ad_type = '',$page = 1,$pagesize = 20,$ad_city_id = 0) {	
		$Ad = M('Ad');
		
		$where = '1 = 1';
		
		if ($ad_city_id){
			$where .= " and ad_status = '$ad_status' ";
		}
		
		if($ad_type){
			$where .= " and ad_type = '$ad_type' ";
		}
		
		if($ad_city_id){
			$where .= " and ad_city_id IN (0,$ad_city_id) ";
		}
		
		$startrow = ($page - 1) * $pagesize;
		
		$list = $Ad->where($where)->order(" ad_order asc, ad_id desc ")->limit($startrow,$pagesize)->select();
		
		return $list;
	}
	
	/**
	 * 查询banner列表
	 * $where 条件 
	 */
	public function getLists($where) {
		if(empty($where)){
			return false;
		}
		
		$Ad = M('Ad');
		$list = $Ad->where($where)->order( 'ad_order asc')->limit(6)->select();
		return $list;
	}
	

}
 