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
 * App模型
 */
class AppModel{
	
	/** 
	 * App信息
	 */
	public function getInfoById($app_id){
		if(empty($app_id)){
			return false;
		}
	
		$App = M('App');
		$where['app_id'] = $app_id;
		$data = $App->where($where)->find();
	
		return $data;
	}
	
	public function getInfoByPlatform($app_platform) {
		
		$where = " app_type = 1 ";
		
		if ($app_platform){
			$where .= " and app_platform = '$app_platform' ";
		}
		
		$App = M('App');
		$data = $App->where($where)->find();
		
		return $data;
	}
	
	/**
	 * 添加App信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$App = M('App');
		$result = $App->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除App
	 */
	public function del($app_id){
		if (empty($app_id)) {
			return false;
		}
	
		$App = M('App');
		$where['app_id'] = $app_id;
		$result = $App->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改App信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['app_id'])){
			$app_id = $data['app_id'];
			unset($data['app_id']);
	
			$App = M('App');
			$result = $App->where(" app_id = %d ",$app_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询App列表
	 */
	public function getList(){
		$App = M('App');
		$list = $App->select();
	
		return $list;
	}
	
	/**
	 * Table_dealer::getApp() 获得App信息
	 *
	 * @param mixed $source
	 * @return
	 */
	public function getApp($platform){		
		$App = M('App');
		$map['app_type'] = 1; 
		$map['app_platform'] = $platform;
		
		$data = $App->where($map)->find();
		if($data){
			return self::struct($data);
		}else{
			return false;
		}
	}
	
	/**
	 * 获取最新的APP
	 *
	 * @param mixed $type 客户端类型
	 * @param mixed $platform 客户端平台
	 * @return
	 */
	public function getNewApp($type, $platform){
		$App = M('App');
		$map['app_type'] = $type;
		$map['app_platform'] = $platform;
		
		$data = $App->where($map)->order('app_id desc')->find();
		if($data){
			return self::struct($data);
		}else{
			return false;
		}
	}
	
	public function struct($data){
		$r = array();
		 
		$r['appid']     = $data['app_id'];
		$r['type']      = $data['app_type'];
		$r['platform']  = $data['app_platform'];
		$r['isforce']   = $data['app_isforce'];
		$r['joinclose'] = $data['app_joinclose'];
		$r['joinsale']  = $data['app_joinsale'];
		$r['joindealer']= $data['app_joindealer'];
		$r['name']      = $data['app_name'];
		$r['version']   = $data['app_version'];
		$r['info']      = $data['app_info'];
		$r['url']       = $data['app_url'];
		$r['dnumber']   = $data['app_dnumber'];
		return $r;
	}
}