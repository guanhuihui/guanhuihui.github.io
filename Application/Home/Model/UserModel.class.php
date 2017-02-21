<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/10/20
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 用户模型
 */
class UserModel{
	
	/**
	 * 根据用户id获取用户信息
	 */
	public function getInfoById($user_id){	
		if(empty($user_id)){
			return false;
		}
		$User = M('User');
		$map['user_id'] = $user_id;
		$data = $User->where($map)->find();
		
		return $data;
	}
	
	/**
	 * 根据手机号获取用户信息
	 */
	public function getInfoByMobile($mobile){
		if(empty($mobile)){
			return false;
		}
	
		$User = M('User');
		$map['user_mobile'] = $mobile;
		$data = $User->where($map)->find();
		
		return $data;
	}
	
	/**
	 * 获取用户信息
	 * $where
	 */
	public function getShop($where){
		
		$User = M('User');
		$data = $User->where($where)->find();
		
		return $data;
	}
	
	/**
	 * 添加用户信息
	 */
	public function add($data = null){
		if(empty($data)){
			return false;
		}
	
		$User = M('User');
		$result = $User->data($data)->add();
		return $result;
	}
	
	/**
	 * 根据id删除用户
	 */
	public function del($user_id){
		if(empty($user_id)){
			return false;
		}
		
		$User = M('User');
		$where['user_id'] = $user_id;
		$result = $User->where($where)->delete();
		return $result;
	}
	
	/**
	 * 修改用户信息 
	 */
	public function edit($where, $data){
		if(empty($where)||empty($data)){
			return false;
		}

		$User = M('User');
		$result = $User->where($where)->save($data);
		return $result;
	}
	
	/**
	 * 查询用户列表
	 */
	public function getList(){
		$User = M('User');
		$list = $User->select();
		return $list;
	}
	
	/**
	 * 用户登陆
	 * @param 用户手机号 $mobile
	 * @param 登陆面膜 $password
	 * @return boolean
	 */
	public function login($mobile, $password){
		if(empty($mobile) || empty($password)){
			return false;
		}
		
		$User = M('User');
		$map['user_account'] = $mobile;
		$data = $User->where($map)->find();
		
		if($data){			
			$_password = md5(md5($password).$data['user_salt']);
			if($_password == $data['user_password']){
				return $data;
			}
		}
		
		return false;
	}

	
	/**
	 * 数量汇总
	 */
	public function getCount($start_time='', $end_time=''){	
		$User = M('User');
		$map = array();
		if($start_time && $end_time){
			$map['user_regtime'] =  array(array('gt',$start_time),array('lt',$end_time),'and');
		}
		$num = $User->where($map)->count();
		return $num;
	}
	
	/**
	 * 检测手机号是否存在
	 */
	public function checkMobile($mobile){
		if(empty($mobile)){
			return false;
		}
	
		$User = M('User');
		$map['user_mobile'] = $mobile;
		$data = $User->where($map)->find();
		if($data){
			return true;
		}else{
			return false;
		}		
	}
	
	//修改密码
	public function changePassWord($user_id, $mobile, $pwd){		
		if(empty($mobile) && empty($pwd)){
			return false;
		}
		
		$salt = randcode(10, 4);
		$password = md5(md5($pwd).$salt);

		$data = array();
		$data['user_salt'] = $salt;
		$data['user_password'] = $password;
		
		$map = array();
		$map['user_id'] = $user_id;
 		$map['user_account'] = $mobile;
		
		$User = M('User');
		$result = $User->where($map)->save($data);
		return $result;
	}


	/**
	 * 设置用户分组
	 * 
	 * @param 用户ID $uid 
	 * @param 分组id $group
	 * @param mixed $num 数值
	 * @return boolean
	 */
	public function setUserGroup($uid, $group, $num){
		if(empty($uid)){
			return false;
		}
		$data = array();
		//判断哪个字段
		if($group == '1'){
			$data['user_isvip'] = $num;
		}else if($group == '2'){
			$data['user_istester'] = $num;
		}else if($group == '3'){
			$data['user_isforbid'] = $num;
		}	
		
		$User = M('user');
		$result = $User->where('user_id=%d',$uid)->save($data);
		return $result;	
	}
	
	/**
	 * 注册新用户
	 * @param 用户手机号 $mobile
	 * @param 密码 $password
	 * @param 来源 $source_type
	 * @param 手机序列号 $phone_sn
	 * @return boolean or user_id
	 */
	public function reg($mobile, $password, $source_type=1, $phone_sn=''){
		if(empty($mobile) && empty($password)){
			return false;
		}
		$salt = randcode(10, 4);
		
		$user_data = array();
		$user_data['user_account'] = $mobile;
		$user_data['user_salt'] = randcode(10, 4);
		$user_data['user_password'] = md5(md5($password).$salt);
		$user_data['user_regsource'] = $source_type;//1--网站；2--安卓APP；3--苹果APP；4--微信
		$user_data['user_regtime'] = time();
		$user_data['user_mobilevalid'] = 1;//0--未手机号验证，1--手机号通过验证
		$user_data['user_mobile'] = $mobile;
		$user_data['user_avatar'] = 'user_avatar/_default.png';
		$user_data['user_phonecode'] = $phone_sn;//手机序列号
		$user_data['user_lastlogintime'] = time();
		$user_data['user_lastloginip'] = get_client_ip();
		$user_data['user_logincount'] = 0;
		$user_data['user_lastloginsource'] = $source_type;			
		$result = $this->add($user_data);
		return $result;
	}
	
	/**
	 * 更新用户登陆日志
	 * @param 用户id $user_id
	 * @param 来源类型 $source_type
	 * @param 手机序列号 $phone_sn
	 * @return boolean
	 */
	public function updataLog($user_id, $source_type ,$phone_sn=''){
		//更新登陆日志
		$map = array();
		$map['user_id'] = $user_id;
		$data = array();
		$data['user_lastlogintime'] = time();
		$data['user_lastloginip'] = get_client_ip();
		$data['user_logincount'] = array('exp','user_logincount+1');
		$data['user_lastloginsource'] = $source_type;
		$data['user_phonecode'] = $phone_sn;
		$result = $this->edit($map, $data);
		return $result;
	}
	
	/**
	 * 获取用户信息
	 * $where
	 */
	public function getUser($where){
	
		$User = M('User');
		$data = $User->where($where)->find();
	
		return $data;
	}
}
