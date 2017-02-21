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
 * Share模型
 */
class ShareModel{
	
	/** 
	 * Share信息
	 */
	public function getInfoById($share_id){
		if(empty($share_id)){
			return false;
		}
	
		$Share = M('Share');
		$where['share_id'] = $share_id;
		$data = $Share->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加Share信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Share = M('Share');
		$result = $Share->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除Share
	 */
	public function del($share_id) {
		if (empty($share_id)) {
			return false;
		}
	
		$Share = M('Share');
		$where['share_id'] = $share_id;
		$result = $Share->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改Share信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['share_id'])){
			$share_id = $data['share_id'];
			unset($data['share_id']);
	
			$Share = M('Share');
			$result = $Share->where(" share_id = %d ",$share_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询Share列表
	 */
	public function getList() {
		$Share = M('Share');
		$list = $Share->select();
	
		return $list;
	}
	
	/**
	 * Share::getShare() 获取分享
	 *
	 * @param mixed $type 分享类型
	 * @return
	 */
	public function getShare($type=0){
		$Share = M('Share');
		$map['share_type'] = $type;
		$data = $Share->where($map)->find();
		if($data){
			return self::struct($data);
		}else{
			return false;
		}
	}
	
	public function struct($data){
		$r = array();
		 
		$r['shareid']   = $data['share_id'];
		$r['type']      = $data['share_type'];
		$r['spic']      = $data['share_pic'];
		$r['sinfo']     = $data['share_info'];
		$r['surl']      = $data['share_url'];
	
		return $r;
	}
}