<?php
namespace Home\Controller;
use Think\Controller;
class ShareController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }

    public function index(){
    	$shop_id=$_REQUEST['shop_id'];
    	$shop_data=self::shop_search_goods($shop_id);
        $this->assign("shop_data",$shop_data);
        $this->assign("shop_id",$shop_id);
        $this->display();
    }

        //首页搜索商品列表接口(上限设了25家店铺的商品)
    public function shop_search_goods($shop_id){
        $url=API_URL.'/rest_2/goods/get_promotion_goods';
        $post_data = array();
        $post_data['shop_id']=$shop_id;
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
?>