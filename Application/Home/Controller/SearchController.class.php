<?php
namespace Home\Controller;
use Think\Controller;
class SearchController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
    	if (IS_POST) {
    		$goodsname=$_POST['goodsname'];
    		$lng=$_SESSION["user_x"];
    		$lat=$_SESSION["user_y"];
    		$goods_data=self::shop_search_goods($goodsname,$lng,$lat,$this->user_data['user_id'],$this->user_data['token']);
    		$this->assign("goods_data",$goods_data);
    	}
    	$this->display();
    }
    //首页搜索商品列表接口(上限设了25家店铺的商品)
    public function shop_search_goods($goodsname,$lng,$lat,$uid,$token){
        $url=API_URL.'/rest_2/shop/search_goods';
        $post_data = array();
        $post_data['goodsname']=$goodsname;
        $post_data['lng']=$lng;
        $post_data['lat']=$lat;
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