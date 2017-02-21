<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhaobo at 2015/12/2
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 *	banner广告模型
 */
class BannerModel{
	
	/**
	 * 根据id获取banner信息
	 */
	public function getInfoById($banner_id){	
		if (empty($banner_id)){
			return false;
		}
		
		$Banner = M('banner');
		$map['banner_id'] = $banner_id;
		$result = $Banner->where($map)->find();		
		return $result;
	}
	
	/**
	 * 获取已发布上线的Banner列表
	 * param   $place 广告位置
	 * param   $type 广告类型
	 */
	public function getList($place, $type){
		$where = "status=2 AND place= %d AND type = %d AND posttime<%d AND end_time>%d";
		
		$map=array();
		$map[] = $place;
		$map[] = $type;
		$map[] = time();
		$map[] = time();
		
		$Banner = M('banner');
		$list = $Banner->where($where, $map)->order('banner_order asc')->select();
		return $list;
	}	
	
	/**
	 * 获取已发布上线的Banner列表
	 * param   $place 广告位置  (支持多个1,2,3)
	 * param   $type 广告类型 (支持多个1,2,3)
	 */
	public function getAdList($type, $place){
	
		$time = time();
		$map=array();
		$map['status'] = 2;
		$map['posttime'] = array('lt',$time);
		$map['end_time'] = array('gt',$time);
		
		if(!empty($type)){
			$map['type']  = array('in',$type);
		}
		
		if(!empty($place)){
			$map['place']  = array('in',$place);
		}

		$Banner = M('banner');
		$list = $Banner->where($map)->order('banner_order asc')->select();
		return $list;
	}
	
	/**
	 * 添加广告
	 * param   $data 添加数据
	 */
	public function add($data){
		if(empty($data)){
			return false;
		}
		
		$Banner = M('banner');
		$result = $Banner->add($data);
		return $result;
	}
	
	/**
	 * 修改广告
	 * param   $id   修改条件
	 * param   $data 修改数据
	 */
	public function edit($id, $data){
		if(empty($id)){
			return false;
		}
		
		$map = array();
		$map['banner_id'] = $id;
		$Banner = M('banner');
		$result = $Banner->where($map)->save($data);
		return $result;
	}
	
	/**
	 * 修改广告
	 * param   $id   修改条件
	 */
	public function del($id){
		if(empty($id)){
			return false;
		}
		
		$map = array();
		$map['banner_id'] = $id;
		$Banner = M('banner');
		$result = $Banner->where($map)->delete();
		return $result;
	}
	

	
}
 