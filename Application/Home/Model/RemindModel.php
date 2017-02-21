<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: wy at 2015/11/06
// +----------------------------------------------------------------------
namespace Home\Model;

class RemindModel {
	
	public function getList() {
		
		$where = " 1 = 1 ";
		
		$Remind = M('Remind');
		$data = $Remind->where($where)->select();
		
		return $data;
	}
	
}

?>