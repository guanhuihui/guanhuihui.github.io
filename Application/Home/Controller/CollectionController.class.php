<?php
namespace Home\Controller;
use Think\Controller;
class CollectionController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
    	//获取收藏店铺
    	if (!empty($this->user_data)) {
    		$favorite_shops=self::shop_favorite_shops($this->user_data['user_id'],$this->user_data['token']);
            foreach ($favorite_shops as $key => $one) {
                    $distance=getDistance($_SESSION["user_y"],$_SESSION["user_x"],$one['shop_baiduy'],$one['shop_baidux']);
                    $favorite_shops[$key]['distance']=getkm($distance);
                }
    		//获取收藏的店铺
    		echo json_encode(array('result'=>'ok','data'=>json_encode($favorite_shops)));
    	}else{
    		echo json_encode(array('result'=>'error','msg'=>"请重新登录"));
    	}
    }

    //获取收藏的店铺
    public function shop_favorite_shops($uid,$token){
    	$url=API_URL.'/rest_2/shop/favorite_shops';
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