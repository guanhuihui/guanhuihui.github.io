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
 * 店铺用户模型
 */
class ShopUserModel{
	
	/**
	 * 店铺用户信息
	 */
	public function getInfoById($user_id){
		if(empty($user_id)){
			return false;
		}
	
		$Shopuser = M('Shopuser');
		$where['shopuser_id'] = $user_id;
		$data = $Shopuser->where($where)->find();
	
		return $data;
	}
	
	
	/**
	 * 添加店铺用户信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Shopuser = M('Shopuser');
		$result = $Shopuser->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除店铺用户
	 */
	public function del($user_id) {
		if (empty($user_id)) {
			return false;
		}
	
		$Shopuser = M('Shopuser');
		$where['shopuser_id'] = $user_id;
		$result = $Shopuser->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改店铺用户信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['shopuser_id'])){
			$user_id = $data['shopuser_id'];
			unset($data['shopuser_id']);
	
			$Shopuser = M('Shopuser');
			$result = $Shopuser->where(" shopuser_id = %d ",$user_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * 查询店铺用户列表
	 */
	public function getList() {
		$Shopuser = M('Shopuser');
		$list = $Shopuser->select();
	
		return $list;
	}
	
	/**
	 * 收藏关系检测
	 */
	public function checkUserFav($shop_id, $user_id){
		
		$Shopuser = M('Shopuser');		
		$map['shopuser_shop'] = $shop_id;
		$map['shopuser_user'] = $user_id;
		
		$data = $Shopuser->where($map)->find();
		return $data;	
	}
	
	/**
	 * getShopUserInfo() 获得商铺用户的信息
	 * 主要用于获取状态（黑名单、是否免运费等）
	 * @param mixed $shopuser_user 用户ID
	 * @return void
	 */
	public function getShopUserInfo($shopuser_shop,$shopuser_user){
		
		$where = " 1 = 1 ";
		
		if ($shopuser_shop){
			$where .= " and shopuser_shop = '$shopuser_shop' ";
		}
		
		if ($shopuser_user){
			$where .= " and shopuser_user = '$shopuser_user' ";
		}
		
		$Shopuser = M('Shopuser');
		$data = $Shopuser->where($where)->find();
		
		return $data;
	}
	
	/**
	 * 收藏店铺
	 */
	public function fav($user_id, $shop_id){
		if(empty($shop_id)){
			return false;
		}
		
		$Shopuser = M('Shopuser');
		$data = array();
		$data['shopuser_shop'] = $shop_id;
		$data['shopuser_user'] = $user_id;
		$data['shopuser_status'] = 0;
		$data['shopuser_free'] = 0;
		$data['shopuser_time'] = time();
		
		$result = $Shopuser->add($data);
		
		//商户被收藏的+1
		$Shop = M('Shop');
		$Shop->where('shop_id=%d', $shop_id)->setInc('shop_favcount',1); // 店铺的被收藏数加1
		return $result;
	}
	
	/**
	 * 收藏的店铺列表
	 *
	 * @param $uid--用户ID  $page=1---第几页，默认第一页 $pagesize=20 默认每页20条数据
	 * @return 成功返回>0的数
	 */
	public function getShopFavList($user_id, $page=1, $pagesize=20){
		if(empty($user_id)){
			return false;
		}
		
		$startrow = ($page - 1) * $pagesize;		
		$sql = "
		SELECT b.shop_id,b.shop_name,b.shop_avatar,b.shop_orderphone1,b.shop_orderphone2,
      		   b.shop_deliverscope,b.shop_opentime1,b.shop_opentime2,b.shop_delivertime1,
               b.shop_delivertime2,b.shop_deliverfee,b.shop_updeliverfee,b.shop_ordercount,
               b.shop_isopen,b.shop_address,b.shop_type,b.shop_baidux,b.shop_baiduy,a.shopuser_free,b.shop_isvip,a.shopuser_status
		FROM hhj_shopuser a
		LEFT JOIN hhj_shop b ON a.shopuser_shop = b.shop_id
		WHERE a.shopuser_user = %d AND a.shopuser_status = 0 
		ORDER BY a.shopuser_id DESC LIMIT %d, %d		
		";
		
		$Model = new Model();
		$list = $Model->query($sql, $user_id, $startrow, $pagesize);
		return $list;
	}
	
	/**
	 * 用户删除收藏店铺
	 */
	public function deleteShopFav($shop_id, $user_id){
		if(empty($shop_id) || empty($user_id)){
			return false;
		}
		
		$Shopuser = M('Shopuser');
		$map = array();
		$map['shopuser_shop'] = $shop_id;
		$map['shopuser_user'] = $user_id;
		$result = $Shopuser->where($map)->delete();
		
		//商户被收藏的-1
		$Shop = M('Shop');
		$Shop->where('shop_id=%d', $shop_id)->setDec('shop_favcount',1); // 商户被收藏的-1
		return $result;
	}
	
	/**
	 * 店铺获取用户粉丝列表
	 */
	public function getUserListByShop($shop_id){
		if(empty($shop_id)){
			return false;
		}
		
		$sql = "
		 	SELECT a.user_id,a.user_account,a.user_avatar,a.user_score,a.user_isvip, b.shopuser_status,b.shopuser_free 
		    FROM hhj_user a 
			LEFT JOIN hhj_shopuser b ON a.user_id = b.shopuser_user  
			WHERE b.shopuser_shop =%d AND a.user_isforbid = 0			
		 	
			";
			
		$Model = new Model();
		$list = $Model->query($sql, $shop_id);
		return $list;
	}
	
	
	/**
	 * 检测店铺是否被用户收藏
	 * @param user_id  用户ID
	 * @param shop_id  店铺ID
	 */
	public function isFav($user_id, $shop_id){
		if(empty($user_id) || empty($shop_id)){
			return false;
		}
		
		$Shopuser = M('Shopuser');
		$map = array();
		$map['shopuser_shop'] = $shop_id;
		$map['shopuser_user'] = $user_id;
		$result = $Shopuser->where($map)->find();
		
		return $result;
	}
	
	/**
	 * 获取店铺的用户信息
	 * @param shop_id  商户ID
	 *
	 */
	public function getUserList($shop_id){
		if(empty($shop_id)){
			return false;
		}
	
		$Shopuser = M('Shopuser');
		$map = array();
		$map['a.shopuser_shop'] = $shop_id;
		
		$list = $Shopuser->alias('a')
		->field('a.*,b.user_account')
		->join('LEFT JOIN __USER__ b ON a.shopuser_user = b.user_id')
		->where($map)
		->select();
	
		return $list;
	}
	
	
}