<?php
namespace Home\Controller;
use Think\Controller;
//引进支付宝插件
require_once(VENDOR_PATH."/alipay.wap.create.direct.pay.by.user-PHP-UTF-8/alipay.config.php");
require_once(VENDOR_PATH."/alipay.wap.create.direct.pay.by.user-PHP-UTF-8/lib/alipay_submit.class.php");
require_once(VENDOR_PATH."/alipay.wap.create.direct.pay.by.user-PHP-UTF-8/lib/alipay_notify.class.php");
//引进微信支付宝插件
require_once C('WWW_ROOT') ."/WxpayAPI_php_v3/lib/WxPay.Api.php";
require_once C('WWW_ROOT') .'/WxpayAPI_php_v3/lib/WxPay.Notify.php';
require_once C('WWW_ROOT') .'/WxpayAPI_php_v3/lib/PayNotifyCallBack.php';
require_once C('WWW_ROOT') .'/WxpayAPI_php_v3/example/log.php';
require_once C('WWW_ROOT') .'/WxpayAPI_php_v3/example/WxPay.JsApiPay.php';
class CommonController extends Controller {
	public $user_data;
	public $user_x;
	public $user_y;
    public $user_current;
    public $appid;
    public $secret;
	function _initialize() {
        if(!session_id()){
            session_start();
        }
        $this->user_data=empty($_SESSION['user_data']) ? '' : $_SESSION['user_data'];
        $this->user_x=empty($_SESSION["user_x"]) ? '' : $_SESSION['user_x'];
        $this->user_y=empty($_SESSION["user_y"]) ? '' : $_SESSION['user_y'];
        $this->new_city_id=empty($_SESSION["new_city_id"]) ? '' : $_SESSION['new_city_id'];//用户当前登录的城市
        $this->user_current=empty($_SESSION["user_current"]) ? '' : $_SESSION['user_current'];
        $this->city_province=empty($_SESSION["city_province"]) ? '' : $_SESSION['city_province'];//省ID
        $this->appid='wx78a74ae276f5adb5';
        $this->secret='c747e99c6d0688dec43b8c522e3a0c1b';
    }

    //判断用户是否已经登录,如果没有登录则跳转到登录页
    public function checklogin(){
        self::get_user_data();
    	$data=A('Index')->is_login($this->user_data['user_id'],$this->user_data['token']);
        if (!$data) {
           $_SESSION['user_data']='';
           header("Location:".U("User/login"));
        }
    }
    //判断经纬度是否为空
    public function checkxy(){
        if (empty($this->new_city_id)) {
            header("Location:".U("Load/index"));
        }
    	if (empty($this->user_x) || empty($this->user_y)) {
    		header("Location:".U("Load/index"));
    	}
        if (empty($this->user_current)) {
            header("Location:".U("Load/index"));
        }
    }

    public function get_user_data(){
            $openid=$_SESSION['openid'];
            $user_data_arr=self::wx_openid($openid);
            if ($user_data_arr) {
                $user_data=$user_data_arr;
                $_SESSION['user_data']=$user_data;
                $_SESSION['user_data']['mobile']=$user_data['mobile'];
                //获得用户默认收货地址
                $address_default_data=A('Address')->address_get_default($user_data['user_id'],$user_data['token']);
                if (!empty($address_default_data)) {
                    $_SESSION["user_x"]=$address_default_data['lng'];
                    $_SESSION["user_y"]=$address_default_data['lat'];
                    $_SESSION["district"]=$address_default_data['district'];
                    $_SESSION["city_id"]=$address_default_data['cityid'];
                    $_SESSION["city_province"]=A('Index')->public_get_city_info($address_default_data['cityid']);
                }

                $this->user_data=$_SESSION['user_data'];
                $this->user_x=$_SESSION["user_x"];
                $this->user_y=$_SESSION["user_y"];
                $this->new_city_id=$_SESSION["new_city_id"];//用户当前登录的城市
                $this->user_current=$_SESSION["user_current"];
                $this->city_province=$_SESSION["city_province"];
                
            }
    }

    //拉取用户信息
    public function wx_openid($openid,$eqt_name='weixin'){
        $url=API_URL.'/rest_2/user/wx_openid';
        $post_data = array();
        $post_data['openid']=$openid;
        $post_data['eqt_name']=$eqt_name;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
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