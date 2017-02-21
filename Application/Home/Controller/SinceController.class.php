<?php
namespace Home\Controller;
use Think\Controller;
class SinceController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function city_list(){
	    $city_list_dat=A('Address')->city_list();//获取城市列表
	    if (!empty($this->user_data)) {
	    //获取搜索历史
	    	$address_search_list_arr=self::address_search_list('',$this->user_data['user_id'],$this->user_data['token']);
	    	$this->assign("address_search_list_arr",$address_search_list_arr);
		}
		//获取附近店铺地址
		$user_current=$_SESSION['user_current'];
	    $x=$_REQUEST['x'];
	    $y=$_REQUEST['y'];
		$shop_near_list=A('Index')->shop_near_list($x,$y);
        //附近店铺按照等级划分再按照距离划分
        $shop_near_list=my_sort($shop_near_list,'shop_isvip');
        //如果没有附件店铺，调取猜你喜欢
        if (empty($shop_near_list)) {
            $shop_near_list=A('Index')->shop_love_shop();
        }
        if (!is_array($shop_near_list)) {
            $shop_near_list=array();
        }
        $this->assign("shop_near_list",$shop_near_list);
        $this->assign("city_list_dat",$city_list_dat);
        $this->display();
    }

    public function search_del(){
    	$statuses=self::address_search_del('',$this->user_data['user_id'],$this->user_data['token']);
    	if ($statuses) {
    		echo json_encode(array('result'=>'ok','data'=>'删除成功'));
        }else{
            echo json_encode(array('result'=>'error','data'=>"删除失败"));
        }
    }

    //获取搜索列表
    public function address_search_list($data='',$uid,$token){
        $url=API_URL.'/rest_2/address/search_list';
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

    //删除列表
    public function address_search_del($data='',$uid,$token){
        $url=API_URL.'/rest_2/address/search_del';
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
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //添加搜索记录
    public function address_search_add($data='',$uid,$token){
        $url=API_URL.'/rest_2/address/search_add';
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
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}