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
 * 管理员模型 
 */
class AdminModel{
	
	/**
	 * 根据id获取管理员信息 
	 */
	public function getInfoById($admin_id){
		if(empty($admin_id)){
			return false;
		}
		
		$Admin = M('Admin');
		$where['admin_id'] = $admin_id;
		$data = $Admin->where($where)->find();
		
		return $data;
	}
	
	/**
	 * 增加管理员 
	 */
	public function Add($data){
		if(empty($data)){
			return false;
		}
		
		$Admin = M('Admin');
		$result = $Admin->data($data)->add();
		return $result;
	}
	
	/**
	 * 根据id删除管理员 
	 */
	public function del($admin_id){
		if(empty($admin_id)){
			return false;
		}
		
		$Admin = M('Admin');
		$where['admin_id'] = $admin_id;
		$result = $Admin->where($where)->delete();
		return $result;
	}
	
	/**
	 * 修改管理员信息
	 */
	public function edit($where, $data){
		if(empty($where) && empty($data)){
			return false;
		}
		
		$Admin = M('Admin');
		$result = $Admin->where($where)->data($data)->save();
		return $result;
	}
	/**
	 * 获取管理员列表
	 */
	public function getList(){
		$Admin = M('Admin');
		$list = $Admin->select();
		return $list;
	}
	
	/**
	 * 登陆校验
	 * @param $account 登录名
	 * @param $password 登陆密码
	 * @param $set_cookie 是否保持登陆状态
	 * @return -1 账号不存在 1登陆成功 -3密码错误
	 */
	public function login($account, $password, $set_cookie=0){
		$Admin = M('Admin');
		$map = array();
		$map['admin_account'] = $account;
		$admin_data = $Admin->where($map)->find();
		if(!$admin_data){
			return -1; //账户不存在
		}
		
		$AdminGroup = M('Admingroup');
		$map = array();
		$map['admingroup_id'] = $admin_data['admin_group'];
		$group_data = $AdminGroup->where($map)->find();
		$auth = '';//获取用户权限信息
		if($group_data){
			$auth = $group_data['admingroup_auth'];
			//$auth = explode('|', $group_data['admingroup_auth']);
		}
		
		$pass_code = get_pass_code($password, $admin_data['admin_salt']);		
		if($pass_code == $admin_data['admin_password']){
			//设置登陆标记
			$this->setLogin($admin_data['admin_id'], $account, $password, $auth, $set_cookie, $group_data['admingroup_name']);
			//更新登陆信息
			$this->updateLoginStatus($admin_data['admin_id']);
			return 1;
		}else{
			return -3;//密码错误
		}		
	}
	
	//更新登陆信息
	public function updateLoginStatus($user_id){
		$Admin = M('Admin');
		
		$map = array();
		$map['admin_id'] = $user_id;
		
		$data = array();
		$data['admin_lastloginip'] = get_ip();
		$data['admin_lastlogintime'] = time();
		$data['admin_logincount'] = array('exp','admin_logincount+1');		
		return $this->edit($map, $data);
	}
	
	//设置登陆cookie,session
	public function setLogin($user_id, $account, $password, $auth='', $set_cookie=0, $admingroup_name){	
		//设置cookie
		if($set_cookie){
			$time = time()+(3600*24*7);
			setcookie('HHJ_AID', $this->id, $time);
			setcookie('HHJ_HIDEPASS', md5($password.$user_id), $time);
		}else{
			setcookie('HHJ_AID', '');
			setcookie('HHJ_HIDEPASS', '');
		}
		
		//设置session
		session('HHJ_AID', $user_id);
		session('HHJ_ACOUNT', $account);
		session('HHJ_ADMINGROUP', $admingroup_name);
		session('HHJ_AUTH', $auth);
	}
	
}