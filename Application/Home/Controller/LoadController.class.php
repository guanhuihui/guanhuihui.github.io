<?php
namespace Home\Controller;
use Think\Controller;
class LoadController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
    	//微信接口回调1
        if(!session_id()){
            session_start();
        }
    	$code=$_REQUEST['code'];
    	$state=$_REQUEST['state'];
        $openid=$_SESSION['openid'];
    	if (!empty($code) || !empty($openid)) {
    		if(!isset($_SESSION['last_access'])||(time()-$_SESSION['last_access'])>7200){
    			$_SESSION['last_access'] = time();
	    		//获取用户获取用户access_token
		    	$url_access_token="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->secret."&code=".$code."&grant_type=authorization_code";
		    	$access_token_arr=self::get_url_access_token($url_access_token);
		    	//模拟
		    	// $access_token_arr=array();
		    	// $access_token_arr['access_token']='1ujuAOJENczaiOTf8qaoSLHAn5t9vtn1xrraxU6C2AI5YE4hCrg_G0ktjVa6_C42tjfKsVtu52eps0vy4hKxnzabSb0hZ8BVv8A853F2_GM';
		    	// $access_token_arr['expires_in'] = '7200';
		    	// $access_token_arr['refresh_token'] = 'U2kqYUNG7YkobpOIYZ4Ufvh5HMm6Xu9EH6mwfxKXUFQeb4cfbLBbG4G5nTqA_JAvrOJHl09GBBCn88wk1yexwXuqYyM0cm0X_nIBL_-XJ_M';
		    	// $access_token_arr['openid'] = 'o25KXjiETFnnk88L-nO9c4R429Pk';
		    	// $access_token_arr['scope'] = 'snsapi_base';
		    	//模拟结束
		    	$access_token=$access_token_arr['access_token'];
		    	$expires_in=$access_token_arr['expires_in'];//access_token接口调用凭证超时时间，单位（秒）
		    	$refresh_token=$access_token_arr['refresh_token'];//用户刷新access_token
		    	$openid=$access_token_arr['openid'];//用户唯一标识
		    	$scope=$access_token_arr['scope'];//用户授权的作用域，使用逗号（,）分隔
		    	$_SESSION['openid']=$openid;
		    	$_SESSION['access_token']=$access_token;
		    	$_SESSION['refresh_token']=$refresh_token;
		    	//拉取用户信息
		    	// $userinfo_url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
		    	// $userinfo_arr=self::get_url_snsapi_userinfo($userinfo_url);
	    	}
	    	self::get_user_data();
    	}
        if (empty($this->user_data)) {
            header("Location:".U("User/login"));
        }
    	$this->display();
    }

    //获取用户access_token
    public function get_url_access_token($url){
        $json_data=Posts('',$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            return $arr;
        }else{
            return false;
        }
    }

    //拉取用户信息
    public function get_url_snsapi_userinfo($url){
        $json_data=Posts('',$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            return $arr;
        }else{
            return false;
        }
    }

    //获取优惠券是否存在
    public function get_can_use(){
        $data=self::can_use('',$this->user_data['user_id'],$this->user_data['token']);
        if ($data) {
            if ($data['msg']=='ok') {
                 echo json_encode(array('result'=>'ok','msg'=>''));
                exit();
            }else{
                echo json_encode(array('result'=>'error','msg'=>''));
                exit(); 
            }
           
        }else{
            echo json_encode(array('result'=>'error','msg'=>''));
            exit();
        }
    }

    public function can_use($data,$uid,$token){
        $url=API_URL.'/rest_2/Coupon/can_use';
        $post_data = array();
        $post_data=$data;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    

}