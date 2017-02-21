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
//活动临时表，用完就删
class LinshiActivetyModel extends Model{
	protected $connection = 'DB_CONFIG1';
	protected $tablePrefix = 'hhj_';
	protected $tableName = 'linshi_activety';
	//插入表
	public function add_data($data){
		if (empty($data)) {
			return false;
		}
		
		$result = $this->data($data)->add();
		return $result;
	}

	//查询
	public function getOpenid($openId,$activety_type=1){
		if(empty($openId)){
			return false;
		}
	
		$where['openId'] = $openId;
		$where['activety_type'] = $activety_type;
		$data = $this->where($where)->find();
	
		return $data;
	}

	//删除
	public function delOpenid($oreder_no){
		if(empty($oreder_no)){
			return false;
		}
		$where['oreder_no'] = $oreder_no;
		$data = $this->where($where)->delete();
	}

	//条件搜索
	public function delArr($arr){
		if(empty($arr)){
			return false;
		}
		$data = $this->where($arr)->delete();
	}
	

}
?>