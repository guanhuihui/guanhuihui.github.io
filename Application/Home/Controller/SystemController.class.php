<?php
namespace Home\Controller;
use Think\Controller;
class SystemController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
	//系统消息
    public function message(){
        $this->checkxy();
        $this->checklogin();
    	//获取系统消息
    	$message_data=self::message_get_list('0',$this->new_city_id,$this->user_data['user_id'],$this->user_data['token']);
    	//获取用户消息
    	$MeMessage_data=self::message_get_list('1',$this->new_city_id,$this->user_data['user_id'],$this->user_data['token']);
        foreach ($message_data as $key => $one) {
            $message_data[$key]['content']=preg_replace('/(\d{11})/','<a href="tel:$1">$1</a>',$one['content']);
        }
        foreach ($MeMessage_data as $key => $one) {
            $MeMessage_data[$key]['content']=preg_replace('/(\d{11})/','<a href="tel:$1">$1</a>',$one['content']);
        }
    	
    	$this->assign("message_data",$message_data);
    	$this->assign("MeMessage_data",$MeMessage_data);

    	$this->display();
    }
    public function MeMessage(){
    	$this->display();
    }

    //获取用户消息
    public function message_get_list($type_id,$city_id,$uid,$token){
        $url=API_URL.'/rest_2/message/get_list';
        $post_data = array();
        $post_data['type_id']=$type_id;
        $post_data['city_id']=$city_id;
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