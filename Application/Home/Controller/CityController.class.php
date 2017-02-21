<?php
namespace Home\Controller;
use Think\Controller;
class CityController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
        $this->checkxy();
        $this->checklogin();
    	$city_list_dat=A('Address')->public_city_list();//获取热门城市列表
    	$city_list_dat_az=A('Address')->city_list();//城市列表
    	$this->assign("city_list_dat",$city_list_dat);
    	$this->assign("city_list_dat_az",$city_list_dat_az);
    	$this->display();
    }

    //获取城市区域列表
    public function area_list(){
    	$city_id=$_REQUEST['city_id'];
    	$area=self::public_area_list($city_id);
    	echo json_encode($area);
    }

    //城市列表
    public function city_list(){
        $city_list_dat_az=A('Address')->public_city_list();//城市列表
        echo json_encode($city_list_dat_az);
    }

    //用户历史订单查询
    public function public_area_list($city_id,$area_id='0'){
        $url=API_URL.'/rest_2/public/area_list';
        $post_data = array();
        $post_data['city_id']=$city_id;
        $post_data['area_id']=$area_id;
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