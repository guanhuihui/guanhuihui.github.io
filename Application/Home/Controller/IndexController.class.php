<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }
    //首页
    public function index(){
        $this->checkxy();
        self::check_userdata();
    	$banner_list=self::banner_get_list('1',$_SESSION['city_id']);
        //旧产品分类屏蔽
        // $category_get_list=self::category_get_list();
        // foreach ($category_get_list as $key => $one) {
        //     $ids=implode(',',$one['cat_ids']);
        //     $category_get_list[$key]['cat_ids_str']=$ids;
        //     $shop_id=A('Category')->shop_category_shop($ids,$_SESSION["user_x"],$_SESSION["user_y"]);
        //     $category_get_list[$key]['shop_id']=$shop_id;
        // }

        //首页获取附近预定商铺
        $reserve_shop=self::get_reserve_shop($_SESSION["user_x"],$_SESSION["user_y"]);
        //新产品分类分类
        $category_get_list=self::get_list_new();
        foreach ($category_get_list as $key => $one) {
            $ids='';
            $ids=implode(',',$one['cat_ids']);
            $category_get_list[$key]['cat_ids_str']='0';
            //获取预定店铺
            if ($one['cat_id'] == '9') {
                if (empty($reserve_shop['shop_id'])) {
                    $category_get_list[$key]['shop_id']='';
                }else{
                    $category_get_list[$key]['shop_id']=$reserve_shop['shop_id'];
                }
                $category_get_list[$key]['url_type']=1;
            }

            if ($one['cat_id'] == '1' || $one['cat_id'] == '2' || $one['cat_id'] == '3') {
                $shop_id=A('Category')->shop_category_shop($ids,$_SESSION["user_x"],$_SESSION["user_y"],$one['is_book']);
                $category_get_list[$key]['shop_id']=$shop_id;
                $category_get_list[$key]['url_type']=1;
            }

        }
        $shop_near_list=self::shop_near_list($_SESSION["user_x"],$_SESSION["user_y"]);
        //附近店铺按照等级划分再按照距离划分
        //$shop_near_list=my_sort($shop_near_list,'shop_isvip');
        $shop_near_list=self::isvip_sort($shop_near_list);
        //如果没有附件店铺，调取猜你喜欢
        if (empty($shop_near_list)) {
            $shop_near_list=self::shop_love_shop();
        }
        if (!is_array($shop_near_list)) {
            $shop_near_list=array();
        }

        $city_list_dat=A('Address')->public_city_list();//获取热门城市列表
        $city_list_dat_az=A('Address')->city_list();//城市列表
        //小喇叭
        $shop_get_promotion=A('Category')->shop_get_promotion('',$this->new_city_id);
        //获取用户经纬度
        $user_current=$_SESSION['user_current'];
        //获取用户积分
        $user_score=A('User')->get_user_score();
        //首页商品活动BANNER
        $offer_one_data=self::offer_list($_SESSION['city_id'],$_SESSION['city_province'],1);
        $offer_one_data=self::update_offer_data($offer_one_data);

        $offer_two_data=self::offer_list($_SESSION['city_id'],$_SESSION['city_province'],2);
        $offer_two_data=self::update_offer_data($offer_two_data);
        //给美恰提供信息
        //$meiqia_data=self::order_meiqia_orderinfo($this->user_data['user_id'],$this->user_data['token']);
        $this->assign("user_score",$user_score);
        $this->assign("category_get_list",$category_get_list);
        $this->assign("banner_list",$banner_list);
        $this->assign("shop_near_list",$shop_near_list);
        $this->assign("shop_love_shop",$shop_love_shop);
        $this->assign("district",$_SESSION["district"]);
        $this->assign("user_mobile",$this->user_data['mobile']);

        $this->assign("city_list_dat",$city_list_dat);
        $this->assign("city_list_dat_az",$city_list_dat_az);
        $this->assign("shop_get_promotion",$shop_get_promotion);
        $this->assign("user_current",$user_current);
        $this->assign("meiqia_data",$meiqia_data);
        $this->assign("reserve_shop",$reserve_shop);
        $this->assign("openid",$_SESSION['openid']);
        $this->assign("offer_one_data",$offer_one_data);
        $this->assign("offer_two_data",$offer_two_data);
    	$this->display();
    }


    public function update_offer_data($offer_one_data){
        foreach ($offer_one_data as $key => $one) {
            if ($one['offer_is_show'] == '1') {
                $offer_one_data[$key]['url']='/me/app_html_all?url='.$one['offer_url'].'&name=优惠活动';
            }else{
                $shop_id=0;
                //查看是商品分类跳转还是商品ID跳转
                if ($one['offer_jump_direction'] == '0') {
                    $shop_id=A('Category')->shop_category_shop($one['offer_sort'],$_SESSION["user_x"],$_SESSION["user_y"]);
                }else{
                    $shop_id=A('Category')->get_shopbygoodsid($one['goods_id'],$_SESSION["user_x"],$_SESSION["user_y"]);
                }
                if ($shop_id) {
                    $offer_one_data[$key]['url']='/Category/index/cat_id/'.$one['cat_id'].'/son_cat_id/'.$one['offer_sort'].'/shop_id/'.$shop_id;
                }else{
                    $offer_one_data[$key]['url']='javasript:void(0);';
                    $offer_one_data[$key]['alert']='onclick="getclickinfo('."'附近没有预定店铺'".');"';
                }
            }
        }
        return $offer_one_data;
    }

    public function isvip_sort($shop_near_list){
        $sum_list=array();
        $isvip5=array();
        $isvip4=array();
        $isvip1=array();
        $isvip2=array();
        $isvip3=array();
        foreach ($shop_near_list as $key => $one) {
            if ($one['shop_isvip'] == '5') {
                $isvip5[]=$one;
            }elseif ($one['shop_isvip'] == '4') {
                $isvip4[]=$one;
            }elseif ($one['shop_isvip'] == '1') {
                $isvip1[]=$one;
            }elseif ($one['shop_isvip'] == '2') {
                $isvip2[]=$one;
            }elseif ($one['shop_isvip'] == '3') {
                $isvip3[]=$one;
            }
        }

        $isvip5=my_sort($isvip5,'sort_distance');
        $isvip4=my_sort($isvip4,'sort_distance');
        $isvip2=my_sort($isvip2,'sort_distance');
        $isvip1=my_sort($isvip1,'sort_distance');
        $isvip3=my_sort($isvip3,'sort_distance');
        $sum_list=array_merge($isvip5,$isvip4,$isvip1,$isvip2,$isvip3);
        //截取十个
        $count=1;
        $data=array();
        foreach ($sum_list as $key => $one) {
            if ($count <= 10) {
                $data[]=$one;
                $count++;
            }else{
                break;
            }
        }
        return $data;

    }

    //获取未确认订单数量
    public function get_untreated(){
        if (empty($this->user_data)) {
            echo json_encode(array('code'=>'200','date'=>'0'));
            exit();
        }else{
            $untreated=self::order_untreated($this->user_data['user_id'],$this->user_data['token']);
            echo json_encode(array('code'=>'200','date'=>$untreated['count']));
            exit();
        }
    }



    //获取广告
    public function banner_get_list($place,$city_id){
    	$url=API_URL.'/rest_2/ad/get_list';
    	$post_data = array();
    	$post_data['type_id']='1';
    	$post_data['place']=$place;
    	$post_data['province_id']='1';
    	$post_data['city_id']=$city_id;
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
    //获取首页分类
    public function category_get_list(){
        $url=API_URL.'/rest_2/category/get_list';
        $post_data = array();
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

    //新获取首页分类
    public function get_list_new(){
        $url=API_URL.'/rest_2/category/get_list_new';
        $post_data = array();
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

    //获取最近的店铺列表 
    public function shop_near_list($lng,$lat,$num='100',$city_id=''){
        $url=API_URL.'/rest_2/shop/near_list';
        $post_data = array();
        $post_data['lng']=$lng;//经度
        $post_data['lat']=$lat;//纬度
        $post_data['num']=$num;//返回条目
        $post_data['city_id']=$city_id;//城市ID
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                $data=$arr['data'];
                foreach ($data as $key => $one) {
                    $distance=getDistance($_SESSION["user_y"],$_SESSION["user_x"],$one['shop_baiduy'],$one['shop_baidux']);
                    $data[$key]['distance']=getkm($distance);
                    $data[$key]['sort_distance']=$distance;
                }
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    //猜你喜欢的店铺列表接口
    public function shop_love_shop(){
        $url=API_URL.'/rest_2/shop/love_shop';
        $post_data = array();
        $post_data['lng']=$_SESSION["user_x"];//经度
        $post_data['lat']=$_SESSION["user_y"];//纬度
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                $data=$arr['data'];
                foreach ($data as $key => $one) {
                    $distance=getDistance($_SESSION["user_y"],$_SESSION["user_x"],$one['shop_baiduy'],$one['shop_baidux']);
                    $data[$key]['distance']=getkm($distance);
                }
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //城市ID和省份ID转换接口 
    public function public_change_code($city_code){
        $url=API_URL.'/rest_2/public/change_code';
        $post_data = array();
        $post_data['city_code']=$city_code;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data']['city_id'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    public function public_change_code_sheng($city_code){
        $url=API_URL.'/rest_2/public/change_code';
        $post_data = array();
        $post_data['city_code']=$city_code;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data']['city_province'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    //获取数据库城市ID的省份ID
    public function public_get_city_info($city_code){
        $url=API_URL.'/rest_2/public/get_city_info';
        $post_data = array();
        $post_data['city_id']=$city_code;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data']['city_province'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //获取经纬度
    public function getXY(){
        if(!session_id()){
            session_start();
        }
        $user_x=$_REQUEST['x'];
        $user_y=$_REQUEST['y'];
        $district=$_REQUEST['district'];
        $baidu_city_id=$_REQUEST['city_id'];
        $_SESSION['user_current']=$_REQUEST;
        //判断是否已经登录，如果登录，地址显示默认地址
        if (!empty($this->user_data)) {
            $address_default=self::address_get_default($this->user_data['user_id'],$this->user_data['token']);
            $_SESSION["user_x"]=$address_default['lng'] ? $address_default['lng'] : $user_x;
            $_SESSION["user_y"]=$address_default['lat'] ? $address_default['lat'] : $user_y;
            $_SESSION["district"]=$address_default['district'] ? $address_default['district'] : $district;
            $_SESSION["city_id"]=$address_default['cityid'] ? $address_default['cityid'] : self::public_change_code($baidu_city_id);
            $_SESSION["city_province"]=self::public_get_city_info($_SESSION["city_id"]);//城市省份id
            $_SESSION["new_city_id"]=self::public_change_code($baidu_city_id);//当前位置城市id
            $_SESSION["new_city_province"]=self::public_change_code_sheng($baidu_city_id);//当前城市省份id
            echo json_encode(array('ok'));
        }else{
            if (!empty($user_x) && !empty($user_y)) {
                $_SESSION["user_x"]=$user_x;
                $_SESSION["user_y"]=$user_y;
                $_SESSION["district"]=$district;
                $_SESSION["city_id"]=self::public_change_code($baidu_city_id);
                $_SESSION["new_city_id"]=self::public_change_code($baidu_city_id);
                $_SESSION["new_city_province"]=self::public_change_code_sheng($baidu_city_id);
                $_SESSION["city_province"]=self::public_change_code_sheng($baidu_city_id);
                echo json_encode(array('ok'));
            }else{
                echo json_encode(array('error'));
            }
        }
        
    }

    //获取经纬度
    public function get_user_xy(){
        if(!session_id()){
            session_start();
        }
        if (!empty($_SESSION["user_x"]) && !empty($_SESSION["user_y"])) {
            echo json_encode(array('result'=>'ok','data'=>array('x'=>$_SESSION["user_x"],'y'=>$_SESSION["user_y"])));
        }else{
            echo json_encode(array('result'=>'error'));
        }
    }

    //获取用户默认地址 
    public function address_get_default($uid,$token){
        $url=API_URL.'/rest_2/address/get_default';
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

    //给美恰提供的用户最后一个订单订信息
    public function order_meiqia_orderinfo($uid,$token){
        $url=API_URL.'/rest_2/order/meiqia_orderinfo';
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

    //判断用户是否已经登录
    public function is_login($uid,$token){
        $url=API_URL.'/rest_2/UserFilter/checkLogin';
        $post_data = array();
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'error') {
                    return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }

    //默认调用
    public function check_userdata(){
        //self::get_user_data();
        $data=A('Index')->is_login($this->user_data['user_id'],$this->user_data['token']);
        if (!$data) {
           $_SESSION['user_data']='';
        }
    }

    public function get_reserve_shop($lng,$lat){
        $url=API_URL.'/rest_2/Activity/reserve_shop';
        $post_data = array();
        $post_data['lng']=$lng;//经度
        $post_data['lat']=$lat;//纬度
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                $data=$arr['data'];
                return $data;
            }else{
                return false;
            }
        }else{
            return false;
        }
    
    }

    //用户已发货未完成订单数量
    public function order_untreated($uid,$token){
        $url=API_URL.'/rest_2/order/untreated';
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

    //获取活动专区的列表信息 
    public function offer_list($city_id,$province_id,$offer_type=1){
        $url=API_URL.'/rest_2/offer/get_list';
        $post_data = array();
        $post_data['city_id']=$city_id;
        $post_data['offer_type']=$offer_type;
        $post_data['province_id']=$province_id;
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