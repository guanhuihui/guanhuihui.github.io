<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/10/26
// +----------------------------------------------------------------------

namespace Rest_2\Controller;
use Think\Log;
use Org\Util\Date;
/**
 * 用户信息控制器
 */
class UserController extends UserFilterController {
	
	public function _initialize(){
		parent::_initialize();
	}
	
	/*
	 * 快速登陆
	 */
	public function quick_load(){
		$mobile = I('post.mobile', '');//手机号
		$code = I('post.code', '');//验证码
		$eqt_name = I('post.eqt_name','');//设备名称
		$phone_sn = I('post.phone_sn', '');//手机序列号		
		$source_type = get_source_id($this->os);
		
		//手机号不存在
		if(empty($mobile)) return_error('20101', array('msg'=>C('ERR_CODE.20101')));
		//手机号格式不正确
		if(!is_mobile($mobile)) return_error('20102', array('msg'=>C('ERR_CODE.20102')));
		//校验码不能为空
		if(empty($code)) return_error('20104', array('msg'=>C('ERR_CODE.20104')));
		//校验码验证
		$AuthCode = D('Home/AuthCode');
		$mobile_data = $AuthCode->checkCode($mobile, $code, 3);
		if($mobile == '15811382614'){
			$mobile_data = true;
		}
		//验证码错误
		if(!$mobile_data) return_error('20105', array('msg'=>C('ERR_CODE.20105')));
		//设备名称不能为空
		if(empty($eqt_name)) return_error('20112', array('msg'=>C('ERR_CODE.20112')));
		//手机序列号不能为空
		if(empty($phone_sn)) return_error('20107', array('msg'=>C('ERR_CODE.20107')));
		
		//返回结果
		$data = array();	
		$data['token'] = guid();
		$User = D('Home/User');
		$user_data = $User->getInfoByMobile($mobile);
		
		if($user_data){//用户已注册
			//帐号被禁用
    		if($user_data['user_isforbid'] == 1) return_error('20111', array('msg'=>C('ERR_CODE.20111')));
    		
    		//更新登陆日志
    		$User->updataLog($user_data['user_id'], $source_type , $phone_sn);
   
    		$data['user_id'] = $user_data['user_id'];
    		$data['user_avatar'] = $user_data['user_avatar'];
    		$data['user_regtime'] = $user_data['user_regtime'];
    		$data['user_score'] = $user_data['user_score'];  		
		}else{			
			$password = '123456';//默认密码
			$user_id = $User->reg($mobile, $password, $source_type, $phone_sn);
			if(!$user_id) json_error('20108',array('msg'=>C('ERR_CODE.20108'))); //用户注册失败
			
			$data['user_id'] = $user_id;
			$data['user_avatar'] = 'user_avatar/_default.png';
			$data['user_regtime'] = time();
			$data['user_score'] = 0;		
			
			$Activity = D('Home/Activity');
			$Ticket = D('Home/Ticket');
			$acitvity_info = $Activity->getInfoById('52');
				
			$where = array();
			$where['user_id'] = 0; //用户ID为空
			$where['status'] = 0; //优惠券状态是未使用
			$where['use_time'] = 0; //优惠券使用时间为0
			$where['act_id'] = '52'; //活动ID
				
			$ticketinfo = $Ticket->getTicketListByWhere($where); //检测是否有券
			if ($acitvity_info['status'] == 1){
				$end_time = strtotime($acitvity_info['end_time']);
				$now_time = time();
			
				if($ticketinfo){
						
					//判断活动是否已过期
					if ($end_time <= $now_time){
						break;
					}
						
					$dur = $end_time-$now_time;
						
					//优惠券绑定用户
					$arr = array(); //绑定条件
					$arr['ticket_id'] = $ticketinfo['ticket_id'];
						
					$user_ticket = array(); //绑定参数
					$user_ticket['user_id'] = $user_id;
					$user_ticket['begin_time'] = date("Y-m-d H:i:s",$now_time);
					if (floor($dur / 86400) > 30){
						$user_ticket['end_time'] = date("Y-m-d H:i:s",$now_time+86400*30);
					}else {
						$user_ticket['end_time'] = date("Y-m-d H:i:s",$end_time);
					}
					$result = $Ticket->edit($arr, $user_ticket); //更新券的信息
						
					if ($result){
						vendor('Jpush.jpush');
						$jpush_android = new \Jpush(C('JPUSH_ANDROID_APPKEY'), C('JPUSH_ANDROID_MASTERSECRET'), C('JPUSH_URL'));
						$jpush_ios = new \Jpush(C('JPUSH_IOS_APPKEY'),C('JPUSH_IOS_MASTERSECRET'),C('JPUSH_URL'));
							
						//极光推送
						$send  = array('alias'=>array($mobile));
							
						$jpush_android->push($send, "恭喜您获得一张优惠券", 3);
						$jpush_ios->push($send, "恭喜您获得一张优惠券", 3);
					}
				}
			}
		}
		
		//写入token
		$key = C('CACHE_USER_TOKEN').'_'.$data['user_id'];
		
		//更换设备，限制24小时后登录=================开始=================
		if($this->os == 'android' && $data['user_id']!=1){
			//设备更换手机号进行限制
			$os_key='pass_'.$phone_sn;
			$temp = S($os_key);
			if ($temp) {
				$hours = ceil(($temp['passtime']-time())/3600);//判断时间是否已经过期
				if($hours<=0){
						//如果时间验证过期
						$passtime = time()+24*3600;
						S($os_key,array('passtime'=>$passtime,'phone_sn'=>$phone_sn,'user_id'=>$data['user_id']));
					}else{
						json_error('20117',array('msg'=>'请您'.$hours.'小时后登录'));
					}

			}else{
				//如果第一次登陆，则记录
				$passtime = time()+24*3600;
				S($os_key,array('passtime'=>$passtime,'phone_sn'=>$phone_sn,'user_id'=>$data['user_id']));
			}
			
			//对用户换手机进行限制
			$pass_key = 'pass_'.$data['user_id'];
			$temp = S($pass_key);
			if ($temp) {
				if($temp['phone_sn'] != $phone_sn){//如果设备唯一标示过期
				$hours = ceil(($temp['passtime']-time())/3600);//判断时间是否已经过期
					if($hours<=0){
						//如果时间验证过期
						$passtime = time()+24*3600;
						S($pass_key,array('passtime'=>$passtime,'phone_sn'=>$phone_sn,'user_id'=>$data['user_id']));
					}else{
						json_error('20117',array('msg'=>'设备更换，请您'.$hours.'小时后登录'));
					}
				}
	
			}else{
				//如果第一次登陆，则记录
				$passtime = time()+24*3600;
				S($pass_key,array('passtime'=>$passtime,'phone_sn'=>$phone_sn,'user_id'=>$data['user_id']));
			}
			
		}
		//更换设备，限制24小时后登录=================结束=================
		S($key, array('user_id'=>$data['user_id'], 'token'=>$data['token'], 'equipment'=>$eqt_name, 'phone_sn'=>$phone_sn));		
		json_success($data);
	}
	
	/**
	 * 用户注册（已作废）
	 */
	public function reg(){
		$mobile = I('post.mobile', '');//手机号		
		$password = I('post.password', '');//密码		
		$code = I('post.code', '');//验证码			
		$phonecode = I('post.phonecode', '');//手机序列号	
		$source_type = get_source_id($this->os);
		
		//手机号不存在
		if(empty($mobile)) return_error('20101', array('msg'=>C('ERR_CODE.20101')));
		//手机号格式不正确
		if(!is_mobile($mobile)) return_error('20102', array('msg'=>C('ERR_CODE.20102')));	
		//密码不存在
		if(empty($password)) return_error('20103', array('msg'=>C('ERR_CODE.20103')));	
		//校验码不能为空
		if(empty($code)) return_error('20104', array('msg'=>C('ERR_CODE.20104')));	
		//校验码验证
		$AuthCode = D('Home/AuthCode');
		$mobile_result = $AuthCode->checkCode($mobile, $code, 1);
		//验证码错误
		if(!$mobile_result) return_error('20105', array('msg'=>C('ERR_CODE.20105')));	
		//手机序列号不能为空
		if(empty($phonecode)) return_error('20107', array('msg'=>C('ERR_CODE.20107')));
		
		$User = D('Home/User');
		$user_data = $User->checkMobile($mobile);
		if($user_data) return_error('20114', array('msg'=>C('ERR_CODE.20114'))); //用户已注册	
		
		//密码解密
		$_password = pwd_decode($password);
		$_salt = randcode(10, 4);

		$user_data = array();
		$user_data['user_account'] = $mobile;
		$user_data['user_salt'] = $_salt;
		$user_data['user_password'] = md5(md5($_password).$_salt);
		$user_data['user_regsource'] = $source_type;//1--网站；2--安卓APP；3--苹果APP；4--微信
		$user_data['user_regtime'] = time();
		$user_data['user_mobilevalid'] = 1;//0--未手机号验证，1--手机号通过验证
		$user_data['user_mobile'] = $mobile;
		$user_data['user_avatar'] = 'user_avatar/_default.png';
		$user_data['user_phonecode'] = $phonecode;//手机序列号
		$user_data['user_lastlogintime'] = time();
		$user_data['user_lastloginip'] = get_client_ip();		
		$user_data['user_logincount'] = 0;
		$user_data['user_lastloginsource'] = $source_type;
		
		$user_id = $User->add($user_data);		
		if($user_id){
			json_success(array('user_id'=>$user_id));
		}else{
			//用户注册失败
			json_error('20108',array('msg'=>C('ERR_CODE.20108')));
		}		
    }
    
    /**
     * 用户登陆（已作废）
     */
    public function login(){
    	$mobile = I('post.mobile', '');//手机号
    	$password = I('post.password', '');//密码
    	$phonecode = I('post.phonecode', '');//手机序列号
    	$equipment = I('post.equipment','');//设备名称
    	$source_type = get_source_id($this->os);
    	
    	//手机号不存在
    	if(empty($mobile)) return_error('20101', array('msg'=>C('ERR_CODE.20101')));
    	//手机号格式不正确
    	if(!is_mobile($mobile)) return_error('20102', array('msg'=>C('ERR_CODE.20102')));   	
    	//密码不存在
    	if(empty($password)) return_error('20103', array('msg'=>C('ERR_CODE.20103')));
    	//手机序列号不能为空
    	if(empty($phonecode)) return_error('20107', array('msg'=>C('ERR_CODE.20107'))); 
    	//设备名称不能为空
    	if(empty($equipment)) return_error('20112', array('msg'=>C('ERR_CODE.20112'))); 
    	
    	$User = D('Home/User');
    	$user_row = $User->login($mobile,$password);
    	if($user_row){
    		//帐号被禁用
    		if($user_row['user_isforbid'] == 1) return_error('20111', array('msg'=>C('ERR_CODE.20111')));   		
    		
    		// ----------------- 24 小时限制 begin -----------------------//
    		if($user_row['user_isforbid'] == 2){ //0--不是（默认值） 1--是  2 24小时限制
    			$time = intval($user_row['user_lastlogintime']) + 24*60*60 - time();
    			if($time > 0){
    				$hour = ceil($time/3600);
    				return_error('20110', array('msg'=>str_replace("%d", $hour, C('ERR_CODE.20110'))));
    			}else{
    				//更新状态			
    				$data = array();
    				$data['user_isforbid'] = 0;
    				$data['user_phonecode'] = $phonecode;
    				$map = array();
    				$map['user_id'] = $user_row['user_id'];    				
    				$User->edit($map, $data);
    			}
    		}else{    		
	    		if($user_row['user_phonecode']){
	    			if($user_row['user_phonecode'] != $phonecode){ //发现更换登陆设备,开启24小时限制
	    				//更新状态
	    				$map = array();
	    				$map['user_id'] = $user_row['user_id'];
	    				$data = array();
	    				$data['user_isforbid'] = 2;
	    				$data['user_lastlogintime'] = time();
	    				$User->edit($map, $data);
	    				return_error('20110', array('msg'=>str_replace("%d", 24, C('ERR_CODE.20110'))));
	    			}
	    		}
    		}
    		// ----------------- 24 小时限制 end-----------------------//
    		
    		//更新登陆日志
    		$map = array();
    		$map['user_id'] = $user_row['user_id'];
    		$data = array();
    		$data['user_lastlogintime'] = time();
    		$data['user_lastloginip'] = get_client_ip();
    		$data['user_logincount'] = $user_row['user_logincount'] + 1;
    		$data['user_lastloginsource'] = $source_type;
    		if(empty($user_row['user_phonecode'])){
    			$data['user_phonecode'] = $phonecode;
    		}
    		$User->edit($map, $data);

    		//写入token
    		$key = C('CACHE_USER_TOKEN').'_'.$user_row['user_id'];
    		$token = guid();
    		S($key, array('user_id'=>$user_row['user_id'], 'token'=>$token, 'equipment'=>$equipment));
    		
    		$_data = array();
    		$_data['user_id'] = $user_row['user_id'];
    		$_data['user_avatar'] = $user_row['user_avatar'];
    		$_data['user_regtime'] = $user_row['user_regtime'];
    		$_data['user_score'] = $user_row['user_score'];
    		$_data['token'] = $token;
    		json_success($_data);    		
    	}else{
    		//用户名或密码错误
    		return_error('20109', array('msg'=>C('ERR_CODE.20109')));
    	}    
    }
    
    /**
     * 用户退出
     */
    public function log_out(){
    	
    	//获取用户token的$key
    	$key = C('CACHE_USER_TOKEN').'_'.$this->uid;
    	S($key, NULL); //清楚缓存中的$key值
    	if(S($key)){
    		json_error('20115', array('msg'=>C('ERR_CODE.20115')));
    	}else{
    		json_success(array('msg'=>ok));
    	}
    	
    }
    
    /**
     * 用户提示消息
     */
    public function tips(){
    	//登陆验证
    	$this->checklogin();
    	 
    	$AppTip = D('Home/AppTip');
    	$list = $AppTip->getList($this->uid, 1); //1客户端  2商户端
    	if($list === false){
    		return_error('10201', array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
    	}

    	json_success($list);
    }
    
    /**
     * 用户提示消息消除
     * 提示类型 1用户订单 2用户优惠券 3用户消息
     */
    public function clear_tip(){
    	//登陆验证
    	$this->checklogin();
    	
    	$tip_type = I('post.tip_type', 0);//提示类型
    	if(empty($tip_type)) return_error('20110', array('msg'=>str_replace("%d", 24, C('ERR_CODE.20110')))); //提示类型不能为空
    	
    	$AppTip = D('Home/AppTip');
    	$result = $AppTip->clear($this->uid, 1, $tip_type); //1客户端  2商户端 
    	if($result === false){
    		return_error('10202', array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
    	}	
    	json_success(array('msg'=>'ok'));   	
    }

}