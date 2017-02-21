<?php
namespace Home\Controller;
use Think\Controller;
class CartController extends CommonController {
	function _initialize() {
        parent::_initialize();
    }
    public function index(){
        $shop_id=$_REQUEST['shop_id'];
        $act_ticket=$_REQUEST['act_ticket'];
        $goods_ticket=$_REQUEST['goods_ticket'];
        $distribution=$_REQUEST['distribution'];
        if ($act_ticket == '') {
            $act_ticket=1;
        }
        if ($goods_ticket == '') {
            $goods_ticket=1;
        }
        $cart_data=self::cart_list($shop_id,$act_ticket,$goods_ticket);
        $address_default=A('Address')->return_address_default();
        //获取全部收货地址
        $address_get_data=A('Address')->address_get_list($this->user_data['user_id'],$this->user_data['token']);

        //获取商户详细信息
        $shop_data=A('Category')->shop_get_info($cart_data['shop_data']['shop_id']);


        //循环购物车id
        $normal_goods_data_art_ids=self::get_act_id($cart_data['shop_cart_data']['normal_goods_data']);
        $book_goods_data_art_ids=self::get_act_id($cart_data['shop_cart_data']['book_goods_data']);


        //今日时间选项和多选时间
        $today=date('Y-m-d',time());
        $h=date('H',time());
        $today_time=$cart_data['shop_cart_data']['normal_goods_data']['book_hour'];
        $time_arr=array();
        foreach ($today_time as $key => $one) {
            $h_data=explode('-',$one);
            if ($h <= $h_data[0]) {
                $time_arr[]=$one;
            }
        }

        //预定产品去掉周六日
        $ymd=date('Y年m月d日',strtotime("+1 day"));
        $jin_ymd=date('Y年m月d日',time());
        // $w_date=date('w',strtotime($ymd));
        // if ($w_date == 6 || $w_date == 0) {
        //     $ymd=date('Y-m-d',strtotime("+3 day"));
        // }

        //计算现货和预定产品优惠金额
        $normal_youhui=$cart_data['shop_cart_data']['normal_goods_data']['cost_amount'] - $cart_data['shop_cart_data']['normal_goods_data']['goods_amount'];
        $book_youhui=$cart_data['shop_cart_data']['book_goods_data']['cost_amount'] - $cart_data['shop_cart_data']['book_goods_data']['goods_amount'];

        $normal_goods_data_book_day=$cart_data['shop_cart_data']['normal_goods_data']['book_day'];
        array_splice($normal_goods_data_book_day,0,1);
        foreach ($normal_goods_data_book_day as $key => $one) {
            $date_ymd=date_Transformation($one);
            if ($date_ymd == $jin_ymd) {
                $date_ymd=$date_ymd.'(今天)';
            }
            if ($date_ymd == $ymd) {
                $date_ymd=$date_ymd.'(明天)';
            }
            $cart_data['shop_cart_data']['normal_goods_data']['book_day_time'][]=$date_ymd;
        }
        $normal_goods_data_book_day=$cart_data['shop_cart_data']['book_goods_data']['book_day'];
        foreach ($normal_goods_data_book_day as $key => $one) {
            $date_ymd=date_Transformation($one);
            if ($date_ymd == $jin_ymd) {
                $date_ymd=$date_ymd.'(今天)';
            }
            if ($date_ymd == $ymd) {
                $date_ymd=$date_ymd.'(明天)';
            }
            $cart_data['shop_cart_data']['book_goods_data']['book_day_time'][]=$date_ymd;
        }

        $this->assign("normal_goods_data_art_ids",$normal_goods_data_art_ids);
        $this->assign("book_goods_data_art_ids",$book_goods_data_art_ids);
        $this->assign("shop_data",$shop_data);
        $this->assign("cart_data",$cart_data);
        $this->assign("shop_cart_data",$cart_data['shop_cart_data']);
        $this->assign("normal_goods_data",$cart_data['shop_cart_data']['normal_goods_data']);
        $this->assign("book_goods_data",$cart_data['shop_cart_data']['book_goods_data']);


        $this->assign("address_default",$address_default);
        $this->assign("address_get_data",$address_get_data);
        $this->assign("shop_id",$shop_id);
        $this->assign("user_current",$_SESSION["user_current"]);
        $this->assign("time_arr",$time_arr);
        $this->assign("distribution",$distribution);
        $this->assign("normal_youhui",$normal_youhui);
        $this->assign("book_youhui",$book_youhui);
        $this->assign("ymd",$ymd);
    	$this->display();
    }


    //获取购物车id
    public function get_act_id($data){
        $art_ids=array();
        foreach ($data['goods_gift_data']['goods_list'] as $key => $value) {
            if (!empty($value['cart_id'])) {
                $art_ids[]=$value['cart_id'];
            }
        }
        foreach ($data['goods_data']['goods_list'] as $key => $value) {
            if (!empty($value['cart_id'])) {
                $art_ids[]=$value['cart_id'];
            }
        }
        foreach ($data['gift_data']['goods_list'] as $key => $value) {
            if (!empty($value['cart_id'])) {
                $art_ids[]=$value['cart_id'];
            }
        }
        $art_ids=implode(',',$art_ids);
        return $art_ids;
    }


    //获取购物车列表
    public function cart_list($shop_id,$act_ticket,$goods_ticket){
        if (empty($shop_id)) {
            $cart_data=self::cart_get_list($this->user_data['user_id'],$this->user_data['token']);
            if (!empty($cart_data[0])) {
                   $shop_data=$cart_data[0];
                   $cart_data_info=self::cart_get_data($shop_data['shop_id'],$act_ticket,$goods_ticket,$this->user_data['user_id'],$this->user_data['token']);
            }
        }else{
            $cart_data_info=self::cart_get_data($shop_id,$act_ticket,$goods_ticket,$this->user_data['user_id'],$this->user_data['token']);
        }
    	
    	return $cart_data_info;
    }

    //获取购物车统计
    public function get_num(){
    	$shop_id=$_REQUEST['shop_id'];
    	$sum_data=self::cart_get_num($shop_id,$this->user_data['user_id'],$this->user_data['token']);
    	if ($sum_data) {
                echo json_encode(array('result'=>'ok','data'=>$sum_data));
            }else{
                echo json_encode(array('result'=>'error','data'=>""));
            }
    }

    //添加购物车
    public function add(){
        $shop_id=$_REQUEST['shop_id'];
        $goods_id=$_REQUEST['goods_id'];
        $count=$_REQUEST['count'];
        if (empty($count)) {
            $count='1';
        }
        $data=array();
        $data['shop_id']=$shop_id;
        $data['goods_id']=$goods_id;
        $data['count']=$count;
        $rester=self::cart_add($data,$this->user_data['user_id'],$this->user_data['token']);
        if ($rester) {
                echo json_encode(array('result'=>'ok','msg'=>"添加成功"));
            }else{
                echo json_encode(array('result'=>'error','msg'=>"添加失败"));
            }
    }

    //删除购物车
    public function del(){
        $cart_id=$_REQUEST['cart_id'];
        $shop_id=$_REQUEST['shop_id'];
        $data=array();
        $data['cart_id']=$cart_id;
        $data['shop_id']=$shop_id;
        $rester=self::cart_del($data,$this->user_data['user_id'],$this->user_data['token']);
        if ($rester) {
                echo json_encode(array('result'=>'ok','msg'=>"删除成功"));
            }else{
                echo json_encode(array('result'=>'error','msg'=>"删除失败"));
            }
    }
    //删除购物车
    public function cart_del($data,$uid,$token){
        $url=API_URL.'/rest_2/cart/del';
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

    //添加购物车
    public function cart_add($data,$uid,$token){
        $url=API_URL.'/rest_2/cart/add';
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

    //修改购物车
    public function edit(){
        $cart_id=$_REQUEST['cart_id'];
        $count=$_REQUEST['count'];
        $data=array();
        $data['cart_id']=$cart_id;
        $data['count']=$count;
        $rester=self::cart_edit($data,$this->user_data['user_id'],$this->user_data['token']);
        if ($rester) {
                echo json_encode(array('result'=>'ok','msg'=>"修改成功"));
            }else{
                echo json_encode(array('result'=>'error','msg'=>"修改失败"));
            }
    }

    //修改购物车
    public function cart_edit($data,$uid,$token){
        $url=API_URL.'/rest_2/cart/edit';
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


    //购物车列表 
    public function cart_get_list($uid,$token){
        $url=API_URL.'/rest_2/cart/get_list';
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

    //获取购物车商品数量
    public function cart_get_num($shop_id,$uid,$token){
        $url=API_URL.'/rest_2/cart/get_num';
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
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    //获取购物车详细信息
    public function cart_get_info($shop_id,$uid,$token){
        $url=API_URL.'/rest_2/cart/get_info';
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
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //新版获取购物车详细信息
    public function cart_get_data($shop_id,$act_ticket,$goods_ticket,$uid,$token){
        $url=API_URL.'/rest_2/cart/get_cart_new';
        $post_data = array();
        $post_data['shop_id']=$shop_id;
        $post_data['act_ticket']=$act_ticket;
        $post_data['goods_ticket']=$goods_ticket;
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