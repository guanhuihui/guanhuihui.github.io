<?php
namespace Home\Controller;
use Think\Controller;
class CategoryController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }
    public function index(){
        $shop_id=$_REQUEST['shop_id'];
        $get_cat_id=$_REQUEST['cat_id'] ? $_REQUEST['cat_id'] : 0;
        $get_son_cat_id=$_REQUEST['son_cat_id'] ? $_REQUEST['son_cat_id'] : 0;


        $distribution=$_REQUEST['distribution'] ? $_REQUEST['distribution'] : 0;

        $son_cat_arr=explode(',', $son_cat_id);
        if (empty($shop_id)) {
            $son_cat_id=$_GET['son_cat_id'];
            $shop_id=self::shop_category_shop($son_cat_id,$_SESSION["user_x"],$_SESSION["user_y"]);
            if (!$shop_id) {
                header("Location:".U("index/index"));
            }
        }
        $category_get_list=A('Index')->category_get_list();//分类
        //$shop_goods_data=self::goods_shop_goods($shop_id,$cat_id);//获取商户产品
        $shop_goods_data=self::goods_shop_goods($shop_id);//获取商户产品;
        if (empty($this->user_data)) {
            $shop_data=self::shop_get_info($shop_id);
            $arr=self::cart_goods_sum($shop_goods_data,'');
        }else{
            $shop_data=self::shop_get_info($shop_id,$this->user_data['user_id'],$this->user_data['token']);
            //获取购物车总量
            $sum_data=A('Cart')->cart_get_num($shop_id,$this->user_data['user_id'],$this->user_data['token']);
            //$shop_goods_data=self::cart_goods_sum($shop_goods_data,$sum_data);
            $arr=self::cart_goods_sum($shop_goods_data,$sum_data);
        }
        $shop_goods_data_arr=array();
        
        if (empty($cat_id)) {
            $shop_goods_data_arr[0]=$arr['goods_data'][0];

        }else{
            foreach ($arr['goods_data'] as $key => $one) {
                if ($one['cat_id'] == $cat_id) {
                    $shop_goods_data_arr[0]=$one;
                }
            }
        }
        

        
    	$category_second=self::goods_shop_goods($shop_id,0,0,1);//获取一级和二级分类
    	//$shop_get_promotion=self::shop_get_promotion($shop_id);
        $is_yuding=0;//判断是否有预定类
        foreach ($category_second as $key => $one) {
            if ($one['cat_id'] == '9') {
                $is_yuding=1;
            }
        }
        //取出默认的二级分类id
        $defule_son_cat_id=$shop_goods_data_arr[0]['list'][0]['son_cat_id'];
        //如果一级二级分类为空，选择默认
        if (empty($cat_id)) {
           $cat_id=$category_second[0]['cat_id'];
           $son_cat_id=$defule_son_cat_id;
        }


        //店铺详情
        $shop_date_yunfei=self::shop_get_info_yunfei(array('shop_id'=>$shop_id),$this->user_data['user_id'],$this->user_data['token']);
        if (empty($shop_date_yunfei['post_fee_tip'])) {
            $shop_date_yunfei['post_fee_tip']='';
        }
    	$this->assign("shop_goods_data_list",$shop_goods_data_arr);
    	$this->assign("category_get_list",$category_get_list);
    	//$this->assign("shop_get_promotion",$shop_get_promotion);
    	$this->assign("shop_data",$shop_data);
        $this->assign("shop_id",$shop_id);
        $this->assign("user_current",$_SESSION["user_current"]);
        $this->assign("category_second",$category_second);
        $this->assign("defule_son_cat_id",$defule_son_cat_id);
        $this->assign("defule_cat_id",$cat_id);
        $this->assign("sum_data",$sum_data);
        $this->assign("distribution",$distribution);
        $this->assign("is_yuding",$is_yuding);
        $this->assign("shop_date_yunfei",$shop_date_yunfei);

        $this->assign("get_cat_id",$get_cat_id);
        $this->assign("get_son_cat_id",$get_son_cat_id);

    	$this->display();
    }

    //ajax请求返回商户id
    public function get_shop_id(){
        //添加统计
        self::add_statistics();
        $reserve_shop=A('Index')->get_reserve_shop($_SESSION["user_x"],$_SESSION["user_y"]);
        header("Location:".U("/Category/index/shop_id/".$reserve_shop['shop_id']."/tongji/1"));
    }

    //循环产品列表，获取购物车数量
    public function cart_goods_sum($goods_data,$cart_data){
        $price=$cart_data['price'];
        $ticket_data_list=$cart_data['ticket_data_list'];
        //只要大于1，全局禁止刷新
        $total=0;
        //清除无效大类
        foreach ($goods_data as $key => $one) {
            if (empty($one['list'])) {
                unset($goods_data[$key]); 
            }
        }

        $goods_data=array_merge($goods_data);
        $book_key=0;
        $immediate_key=0;
        foreach ($goods_data as $key => $one) {
            foreach ($one['list'] as $_k => $_v) {
                foreach ($_v['goods_list'] as $_ks => $_vs) {
                    if ($one['is_book']== '1') {
                        $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['large_key']=$book_key;
                    }else{
                        $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['large_key']=$immediate_key;
                    }
                    
                    $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['in_key']=$_k;
                    $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['small_key']=$_ks;
                    //默认所有产品添加字段
                    $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['is_refresh']='0';//是否要刷新
                    $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['biao_refresh']='0';
                    //循环优惠券可使用产品ID
                    foreach ($ticket_data_list as $ks => $vs) {
                        if ($_vs['goods_id'] == $vs['goods_id']) {
                            $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['is_refresh']='1';//是否要刷新
                            $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['biao_refresh']='1';
                            $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['ticket_price']='1';
                            $price=round($goods_data[$key]['list'][$_k]['goods_list'][$_ks]['goods_price'] - $vs['ticket_price'],2);
                            $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['goods_price']=$price;
                        }
                    }
                    

                    //购物车循环
                    
                    foreach ($cart_data['goods_list'] as $cat_k => $cat_v) {
                        if ($_vs['goods_id'] == $cat_v['goods_id']) {
                            $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['cart_goods_count']=$cat_v['count'];
                            //如果购物车中含有代金券的产品，价格修改
                            foreach ($ticket_data_list as $ks => $vs) {
                                if ($cat_v['goods_id'] == $vs['goods_id']) {
                                    $total=1;
                                    // $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['goods_price']=$goods_data[$key]['list'][$_k]['goods_list'][$_ks]['goods_price'] + $vs['ticket_price'];
                                    // $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['is_refresh']='0';
                                }
                            }
                        }
                        
                    }
                    
                }

            }
            if ($one['is_book']== '1') {
                $book_key++;
            }else{
                $immediate_key++;
            }
        }
        //所有产品恢复原价，禁止刷新
        if ($total) {
            foreach ($goods_data as $key => $one) {
                foreach ($one['list'] as $_k => $_v) {
                    foreach ($_v['goods_list'] as $_ks => $_vs) {
                        foreach ($ticket_data_list as $ks => $vs) {
                            if ($_vs['goods_id'] == $vs['goods_id']) {
                                $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['is_refresh']='0';//是否要刷新
                                $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['biao_refresh']='1';
                                $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['ticket_price']='1';
                                $goods_data[$key]['list'][$_k]['goods_list'][$_ks]['goods_price']=$goods_data[$key]['list'][$_k]['goods_list'][$_ks]['goods_price'] + $vs['ticket_price'];
                            }
                        }
                    }
                }
            }
        }


        $arr=array('goods_data'=>$goods_data);
        return $arr;
    }

    public function store_switch(){
        $user_current=$_SESSION['user_current'];
        $x=$_SESSION['user_x'];
        $y=$_SESSION['user_y'];
        if (empty($x) && empty($y)) {
           $x=$user_current['x'];
            $y=$user_current['y'];
        }
        $shop_near_list=A('Address')->new_shop_near_list($x,$y);
        $shop_near_list=my_sort($shop_near_list,'distance');
        //去除代售点
        $shop_list=array();
        foreach ($shop_near_list as $key => $one) {
            if ($one['shop_isvip'] != '3') {
                $one['distance']=getkm($one['distance']);
                $shop_list[]=$one;
            }
        }
        $this->assign("user_current",$_SESSION["user_current"]);
        $this->assign("shop_near_list",$shop_list);
        $this->display();
    }

    //根据店铺id获取商品数据
    public function get_shop_goods(){
        $shop_id=$_REQUEST['shop_id'];
        $shop_goods_data=self::goods_shop_goods($shop_id);//获取商户产品

        if (!empty($this->user_data)) {
            //获取购物车总量
            $sum_data=A('Cart')->cart_get_num($shop_id,$this->user_data['user_id'],$this->user_data['token']);
            $shop_goods_data=self::cart_goods_sum($shop_goods_data,$sum_data);
        }else{
            $shop_goods_data=self::cart_goods_sum($shop_goods_data,'');
        }
        die(json_encode($shop_goods_data['goods_data']));
    }

    //获取店铺内搜索产品
    public function like_goods(){
        $distribution=$_REQUEST['distribution'] ? $_REQUEST['distribution'] : 0;
        $goods_name=$_REQUEST['goods_name'];
        $shop_id=$_REQUEST['shop_id'];
        $shop_goods_data=self::goods_shop_goods($shop_id);//获取商户产品
        $data=array();
        foreach ($shop_goods_data as $key => $value) {
            foreach ($value['list'] as $k => $val) {
                foreach ($val['goods_list'] as $ks => $one) {
                    if (strpos($one['goods_name'],$goods_name) !== false) {
                        $data[]=$one;
                    }
                }
            }
        }
        $shop_data=self::shop_get_info($shop_id);

        if (!empty($this->user_data)) {
            //获取购物车总量
            $sum_data=A('Cart')->cart_get_num($shop_id,$this->user_data['user_id'],$this->user_data['token']);
            foreach ($data as $key => $one) {
                foreach ($sum_data['goods_list'] as $cat_k => $cat_v) {
                    if ($one['goods_id'] == $cat_v['goods_id']) {
                        $data[$key]['cart_goods_count']=$cat_v['count'];
                    }
                    }
            }
        }
        $this->assign("shop_id",$shop_id);
        $this->assign("shop_data",$shop_data);
        $this->assign("data",$data);
        $this->assign("sum_data",$sum_data);
        $this->assign("distribution",$distribution);
        $this->display();
    }



    //获取商户详细信息
    public function shop_get_info($shop_id,$uid='',$token=''){
    	$url=API_URL.'/rest_2/shop/get_info';
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
                $distance=getDistance($_SESSION["user_y"],$_SESSION["user_x"],$arr['data']['shop_baiduy'],$arr['data']['shop_baidux']);
                $arr['data']['distance']=getkm($distance);
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //根据二级分类获取最近的店铺信息 
    public function shop_category_shop($son_cat_id='',$lng,$lat,$is_book=''){
    	$url=API_URL.'/rest_2/shop/category_shop';
        $post_data = array();
        $post_data['lng']=$lng;
        $post_data['lat']=$lat;
        $post_data['son_cat_id']=$son_cat_id;
        $post_data['is_book']=$is_book;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data']['shop_id'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

        //根据二级分类获取最近的店铺信息 
    public function get_shopbygoodsid($goods_id='',$lng,$lat){
        $url=API_URL.'/rest_2/shop/get_shopbygoodsid';
        $post_data = array();
        $post_data['lng']=$lng;
        $post_data['lat']=$lat;
        $post_data['goods_id']=$goods_id;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data']['shop_id'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //获取所有二级分类产品
    public function goods_shop_goods($shop_id,$cat_id='0',$son_cat_id='0',$hidden_goods='0'){
    	$url=API_URL.'/rest_2/goods/shop_goods';
        $post_data = array();
        $post_data['shop_id']=$shop_id;
        $post_data['cat_id']=$cat_id;
        $post_data['son_cat_id']=$son_cat_id;
        $post_data['hidden_goods']=$hidden_goods;
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
    //获取店铺促销广告信息接口
    public function shop_get_promotion($shop_id='',$city_id=''){
    	$url=API_URL.'/rest_2/shop/get_promotion';
        $post_data = array();
        $post_data['shop_id']=$shop_id;
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

    //点击统计
       public function add_statistics(){
        $url=API_URL.'/rest_2/Activity/add_statistics';
        $post_data = array();
        $post_data['device']='3';
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

    //获取店铺详情
    public function shop_get_info_yunfei($data,$uid,$token){
        $url=API_URL.'/rest_2/shop/get_info';
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
        }
    }


}