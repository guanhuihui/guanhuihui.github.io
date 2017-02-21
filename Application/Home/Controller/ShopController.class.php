<?php
namespace Home\Controller;
use Think\Controller;
class ShopController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }
    public function index(){

    	$this->display();
    }
    public function shop_list(){
    	// $shop_isvip=$_REQUEST['shop_isvip'] ? $_REQUEST['shop_isvip'] : 1;
    	$city_id=$_REQUEST['city_id'];
    	$area_id=$_REQUEST['area_id'];
    	$lng=$_REQUEST['lng'];
    	$lat=$_REQUEST['lat'];
    	if (empty($city_id)) {
    		$city_id=$_SESSION["city_id"];
    		$shop_data=A('Index')->shop_near_list($lng,$lat,'500');
    	}else{
    		$shop_data=self::shop_area_shop('500',$city_id,$area_id);
    	}
    	$data=array();
        if (!empty($shop_isvip)) {
            foreach ($shop_data as $key => $one) {
                if ($one['shop_isvip'] == $shop_isvip) {
                    $distance=getDistance($lat,$lng,$one['shop_baiduy'],$one['shop_baidux']);
                    $one['distance']=getkm($distance);
                    $data[]=$one;
                }
            }
        }else{
            foreach ($shop_data as $key => $one) {
                    $distance=getDistance($lat,$lng,$one['shop_baiduy'],$one['shop_baidux']);
                    $shop_data[$key]['distance']=getkm($distance);
            }
            $data=$shop_data;
        }
    	echo json_encode($data);
    }

    //获取店铺详细信息
    public function get_shop_json(){
        $shop_id=$_POST['shop_id'];
        $shop_data=A('Category')->shop_get_info($shop_id);
        $distance=getDistance($_SESSION["user_y"],$_SESSION["user_x"],$shop_data['shop_baiduy'],$shop_data['shop_baidux']);
        $shop_data['distance']=getkm($distance);
        echo json_encode($shop_data);
    }

    
     

    public function arrive_navigation(){
    	$this->display();
    }

    //获取区域的店铺列表
    public function shop_area_shop($num='100',$city_id='',$area_id=''){
        $url=API_URL.'/rest_2/shop/area_shop';
        $post_data = array();
        $post_data['num']=$num;//返回条目
        $post_data['city_id']=$city_id;//城市ID
        $post_data['area_id']=$area_id;//城市ID
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

    //用户收藏店铺
    public function favorite_add(){
        $shop_id=$_REQUEST['shop_id'];
        if (empty($shop_id)) {
            echo json_encode(array('result'=>'error','msg'=>"商铺ID不能为空"));
        }else{
            $rester=self::shop_favorite_add($shop_id,$this->user_data['user_id'],$this->user_data['token']);
            if ($rester) {
                echo json_encode(array('result'=>'ok','msg'=>"已收藏"));
            }else{
                echo json_encode(array('result'=>'error','msg'=>"收藏失败"));
            }
        }
    }

    //用户删除店铺收藏
    public function favorite_del(){
        $shop_id=$_REQUEST['shop_id'];
        if (empty($shop_id)) {
            echo json_encode(array('result'=>'error','msg'=>"商铺ID不能为空"));
        }else{
            $rester=self::shop_favorite_del($shop_id,$this->user_data['user_id'],$this->user_data['token']);
            if ($rester) {
                echo json_encode(array('result'=>'ok','msg'=>"立即收藏"));
            }else{
                echo json_encode(array('result'=>'error','msg'=>"取消失败"));
            }
        }
    }



    //用户收藏店铺
    public function shop_favorite_add($shop_id='0',$uid,$token){
        $url=API_URL.'/rest_2/shop/favorite_add';
        $post_data = array();
        $post_data['shop_id']=$shop_id;
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

    //用户删除店铺收藏 
    public function shop_favorite_del($shop_id='0',$uid,$token){
        $url=API_URL.'/rest_2/shop/favorite_del';
        $post_data = array();
        $post_data['shop_id']=$shop_id;
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

    //导航压面
    public function navigation(){
        $this->display();
    }
}