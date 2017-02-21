<?php
namespace Home\Controller;
use Think\Controller;
class CouponController extends CommonController {
	function _initialize() {
        parent::_initialize();
        
    }
    public function index(){
        $this->checkxy();
        $this->checklogin();
    	$coupon_data=self::coupon_get_list($this->user_data['user_id'],$this->user_data['token']);

    	//获取剩余几天过期
    	foreach ($coupon_data as $key => $one) {
            //去掉金额.00
            $coupon_data[$key]['ticket_price']=floatval($one['ticket_price']);
    		$start_time=time();
    		$end_time_data=strtotime($one['end_date']);
    		$diff= $end_time_data-$start_time;
    		$coupon_data[$key]['surplus']= ceil($diff/(24*60*60));
    	}

    	$this->assign("coupon_data",$coupon_data);
    	$this->display();
    }

    public function coupon_bind(){
    	$ticket_code=$_POST['ticket_code'];
    	$data=self::coupon_bind_ticket($ticket_code,$this->user_data['user_id'],$this->user_data['token']);
    	echo json_encode($data);
    }

    //获取可使用的店铺ID
    public function get_ticket_shop(){
        $ticket_id=$_REQUEST['ticket_id'];
        $data=array('lng'=>$_SESSION["user_x"],'lat'=>$_SESSION["user_y"],'ticket_id'=>$ticket_id);
        $shop_id=self::ticket_shop($data,$this->user_data['user_id'],$this->user_data['token']);
        if ($shop_id) {
            echo json_encode(array('result'=>'ok','msg'=>$shop_id['msg']));
            exit();
        }else{
            echo json_encode(array('result'=>'error','msg'=>'附近没有可使用商店'));
            exit();
        }
    }
    //绑定优惠券
    public function coupon_bind_ticket($ticket_code,$uid,$token){
    	$url=API_URL.'/rest_2/coupon/bind_ticket';
        $post_data = array();
        $post_data['ticket_code']=$ticket_code;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return array('result'=>'ok','msg'=>'绑定成功!');
            }else{
                return array('result'=>'error','msg'=>$arr['data']['msg']);
            }
        }else{
            return false;
        }
    }



    //获取用户优惠券
    public function coupon_get_list($uid,$token){
    	$url=API_URL.'/rest_2/coupon/get_list';
        $post_data = array();
        $post_data['status']='0';
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

    //获取优惠券可使用店铺
    public function ticket_shop($data,$uid,$token){
        $url=API_URL.'/rest_2/Activity/ticket_shop';
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