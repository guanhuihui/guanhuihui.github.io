<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }
    //用户退出1
    public function logout(){
        $data=self::user_log_out($this->user_data['user_id'],$this->user_data['token']);
        $_SESSION=array();
    	echo json_encode($data);
    }

    //获取用户积分
    public function get_user_score(){
        $user_score=self::user_score($this->user_data['user_id'],$this->user_data['token']);
        $user_level=ceil($user_score['score'] / 1000);
        if (!$user_level) {
            $user_level=1;
        }
        return array('user_score'=>$user_score['score'],'user_level'=>$user_level);
    }
    public function login(){
        if (!empty($this->user_data)) {
            header("Location:".U("index/index"));
        }else{
            $mobile=$_REQUEST['mobile'];
            $this->assign("mobile",$mobile);
            $this->display();
        }
    }
    //ajax获取短信验证码
    public function getmobile_code(){
        //添加图片验证码
        $verrify = $_REQUEST["verify"];
        if (empty($verrify)) {
            echo json_encode(array('data'=>array('result'=>'error','msg'=>'验证码不能为空')));
            exit();
        }
        if(!sp_check_verify_code()){
            echo json_encode(array('data'=>array('result'=>'error','msg'=>'图片验证码错误')));
            exit();
        }else{
        $mobile=$_POST['mobile'];
        $user_IP = $_SERVER["REMOTE_ADDR"];
        $code=self::public_send_auth_code($mobile,$user_IP);
        echo json_encode(array('result'=>'ok','data'=>$code));
        }
    }

    //用户登录
    public function loginuser(){
    	$mobile=$_POST['mobile'];
    	$code=$_POST['code'];
        $openid=$_SESSION['openid'];
        if (empty($openid)) {
            $data=self::user_quick_load($mobile,$code);
        }else{
            $data=self::weixin_user_quick_load($openid,$mobile,$code);
        }
    	
    	if ($data['result'] == 'ok') {
    		//登录成功，保存值
    		$user_data=$data['data'];
    		$_SESSION['user_data']=$user_data;
            $_SESSION['user_data']['mobile']=$mobile;
            //获得用户默认收货地址
            $address_default_data=A('Address')->address_get_default($user_data['user_id'],$user_data['token']);
            if (!empty($address_default_data)) {
            $_SESSION["user_x"]=$address_default_data['lng'];
            $_SESSION["user_y"]=$address_default_data['lat'];
            $_SESSION["district"]=$address_default_data['district'];
            $_SESSION["city_id"]=$address_default_data['cityid'];
            }

            //如果user_data为空重新请求
            if (empty($_SESSION['user_data'])) {
                self::get_user_data();
            }
            //session存入结束
    		echo json_encode(array('data'=>array('result'=>'ok','msg'=>'登录成功')));
    	}else{
    		//返回错误信息
    		echo json_encode(array('data'=>array('result'=>'error','msg'=>$data['data']['msg'])));
    	}
    	
    }

    //获取短信验证码
    public function public_send_auth_code($mobile,$user_ip){
    	$url=API_URL.'/rest_2/public/send_auth_code';
        $post_data = array();
        $post_data['mobile']=$mobile;//手机号
        $post_data['user_ip']=$user_ip;//ip
        $post_data['type_id']='3';//类型
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return array('result'=>'ok','msg'=>"短信已发送");
            }else{
                return array('result'=>'error','msg'=>$arr['data']['msg']);
            }
        }else{
            return false;
        }
    }

    //登录用户
    public function user_quick_load($mobile,$code){
    	$url=API_URL.'/rest_2/user/quick_load';
        $post_data = array();
        $post_data['mobile']=$mobile;//手机号
        $post_data['code']=$code;//验证码
        $post_data['eqt_name']='weixin';
        $post_data['phone_sn']='123456';
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr;
            }else{
                return $arr;
            }
        }else{
            return false;
        }
    }

    //微信登录用户传openid
    public function weixin_user_quick_load($openid,$mobile,$code){
        $url=API_URL.'/rest_2/user/wx_quick_load';
        $post_data = array();
        $post_data['mobile']=$mobile;//手机号
        $post_data['code']=$code;//验证码
        $post_data['openid']=$openid;//微信唯一标示
        $post_data['eqt_name']='weixin';
        $post_data['phone_sn']='123456';
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr;
            }else{
                return $arr;
            }
        }else{
            return false;
        }
    }

    //用户退出登录
    public function user_log_out($uid,$token){
        $url=API_URL.'/rest_2/user/log_out';
        $post_data = array();
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return array('result'=>'ok','msg'=>"退出成功");
            }else{
                return array('result'=>'error','msg'=>$arr['data']['msg']);
            }
        }else{
            return false;
        }
    }

    //获取用户积分
    public function user_score($uid,$token){
        $url=API_URL.'/rest_2/user/score';
        $post_data = array();
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