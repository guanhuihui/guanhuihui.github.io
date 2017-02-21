<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/10/19
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 基本配置模型
 */
class ConfigModel{
	
	/**
	 * 基本配置信息
	 */
	public function getInfo(){	
		
		$Config = M("Config");
		$data = $Config->find();
		
		return $data;
	}
	
	/**
	 * 基本配置信息
	 */
	public function getInfoByType($type){
		
		$field = " config_agreement ".$type;
		
		$Config = M("Config");
		$data = $Config->field($field)->select();
	
		if ($data){
			return $data[0][$field];
		}
		
		return 0;
	}

}
