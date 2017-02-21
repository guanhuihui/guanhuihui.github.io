<?php
namespace Home\Controller;
use Think\Controller;
class ActivitythreeController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }
    public function index(){
        if(!session_id()){
                session_start();
            }
        $error_code=0;
        $error_msg='';
        if ($_SESSION['activity_opid']) {
            $openId=$_SESSION['activity_opid'];
        }else{
            $tools = new \JsApiPay();
            $openId = $tools->GetOpenid();
            $_SESSION['activity_opid']=$openId;
        }



        $shop_id=$_REQUEST['shop_id'];
        if (empty($openId) || empty($shop_id)) {
            $error_code=1;
            $error_msg="请使用微信打开";
            $this->assign("error_code",$error_code);
            $this->assign("error_msg",$error_msg);
            $this->display();
            exit();
        }
        //检查opid是否下过订单
        $LinshiActivety = D('Home/LinshiActivety');
        
        $LinshiActivety_data=$LinshiActivety->getOpenid($openId,'2');
        if (!empty($LinshiActivety_data)) {
            $error_code=1;
            $error_msg="微信号已参加过本次活动";
            $this->assign("error_code",$error_code);
            $this->assign("error_msg",$error_msg);
            $this->display();
            exit();
        }
        //查询店铺详情
        $shop_data=A('Category')->shop_get_info($shop_id);
        //查询活动产品数量是否够用
        // $goods_is_max=self::is_stock_max($shop_id);
        // if ($goods_is_max['msg']!='ok') {
        //     $error_code=1;
        //     $error_msg="活动产品已销售光";
        //     $this->assign("error_code",$error_code);
        //     $this->assign("error_msg",$error_msg);
        //     $this->display();
        //     exit();
        // }

        $this->assign("error_code",$error_code);
        $this->assign("code",$openId);
        $this->assign("shop_data",$shop_data);
        $this->display();
    }
    public function order_ok(){
        $this->display();
    }

    public function order_add(){
        $code=$_REQUEST['code'];
        $shop_id=$_REQUEST['shop_id'];
        $phone=$_REQUEST['phone'];
        $openId=$_SESSION['activity_opid'];
        if (empty($code) || empty($shop_id) || empty($phone) || empty($openId)) {
            echo json_encode(array('result'=>'error','msg'=>'请刷新页面后重试!'));
            exit();
        }
        //查询活动产品数量是否够用
        // $goods_is_max=self::is_stock_max($shop_id);
        // if ($goods_is_max['msg']!='ok') {
        //     echo json_encode(array('result'=>'error','msg'=>'产品已经售卖光，请明天再抢购!'));
        //     exit();
        // }
        //查询opid是否已经下过订单
        $LinshiActivety = D('Home/LinshiActivety');
        $LinshiActivety_data=$LinshiActivety->getOpenid($openId,'2');
        if (!empty($LinshiActivety_data)) {
            echo json_encode(array('result'=>'error','msg'=>'微信号已参加过本次活动!'));
            exit();
        }
        //查询手机号是否经下过订单
        $is_user_account=self::is_activities($phone);
        if ($is_user_account['msg'] != '0') {
            echo json_encode(array('result'=>'error','msg'=>'手机号已参加过活动！'));
            exit();
        }
        //手机号登录注册
        $return_user_data=self::yd_quick_load($phone);
        if ($return_user_data['result'] == 'ok') {
            //登录成功，保存值
            $user_data=$return_user_data['data'];
            if(!session_id()){
                session_start();
            }
            $_SESSION['activity_user_data']=$user_data;
            //删除购物车所有信息重新添加
            $rester=A('Cart')->cart_del(array('shop_id'=>$shop_id),$user_data['user_id'],$user_data['token']);
            if (!$rester) {
                echo json_encode(array('result'=>'error','msg'=>'产品已售卖光'));
                exit();
            }
            $dis='';
            //添加购物车
            $cart_data=array();
            $cart_data['shop_id']=$shop_id;
            $cart_data['goods_id']='6716';
            $cart_data['count']='1';
            $rester_cart_1=self::activity_cart_add($cart_data,$user_data['user_id'],$user_data['token']);
            if (!$rester_cart_1) {
                echo json_encode(array('result'=>'error','msg'=>'产品已售卖光'));
                exit();
            }
            $cart_data=array();
            $cart_data['shop_id']=$shop_id;
            $cart_data['goods_id']='6718';
            $cart_data['count']='1';
            $rester_cart_2=self::activity_cart_add($cart_data,$user_data['user_id'],$user_data['token']);
            if (!$rester_cart_2) {
                echo json_encode(array('result'=>'error','msg'=>'产品已售卖光'));
                exit();
            }
            $dis=$rester_cart_1['cart_id'].','.$rester_cart_2['cart_id'];
            //添加订单信息
            $ymd=date('Y-m-d');
            $ymdhis=$ymd.' '.'11:00-12:00';
            $order_data=array();
            $order_data['address_id']='0';
            $order_data['shop_id']=$shop_id;
            $order_data['cart_ids']=$dis;
            $order_data['deliver_type']='1';
            $order_data['ticket_id']='0';
            $order_data['act_ticket']='0';
            $order_data['goods_ticket']='0';
            $order_data['pay_type']='10';
            $order_data['book_time']=$ymdhis;
            $order_data['message']='';
            $order_data['user_name']='哈哈镜';
            $order_data['telphone']=$phone;
            $order_data['is_book_goods']='1';
            $order_data['scan_code']='1';
            $rester_arr=A('Order')->order_add($order_data,$user_data['user_id'],$user_data['token']);
            if ($rester_arr['result']=='1') {
                $LinshiActivety = D('Home/LinshiActivety');
                $LinshiActivety->add_data(array('openId'=>$openId,'addtime'=>time(),'oreder_no'=>$rester_arr['data']['order_no'],'activety_type'=>'2'));
                 //微信支付
                echo json_encode(array('result'=>'ok','pay_type'=>$order_data['pay_type'],'msg'=>$rester_arr['data']));
                exit();
            }else{
                echo json_encode(array('result'=>'error','msg'=>$rester_arr['data']['msg']));
                exit();
            }
           
        }else{
            echo json_encode(array('result'=>'error','msg'=>'用户登录失败'));
            exit();
        }
        
        

    }

    //微信支付根据订单id调取订单详细信息
    public function weixin_order_date(){
        $order_no=$_REQUEST['order_no'];
        $user_data=$_SESSION['activity_user_data'];
        if (!empty($order_no)) {
           $order_detail=A('Order')->new_order_detail($order_no,$user_data['user_id'],$user_data['token']);
            echo self::pay_weixin($order_detail);
            exit();
        }
        
    }

    public function pay_weixin($order_data=''){
        $user_data=$_SESSION['activity_user_data'];
        $openid=$_SESSION['activity_opid'];
        //*******************微信支付***********************
        //初始化日志
        $logHandler= new \CLogFileHandler("../logs/".date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);
        //①、获取用户openid
        $tools = new \JsApiPay();
        //$openId = $tools->GetOpenid();
        if (empty($openid)) {
            return false;
        }else{
            $openId=$openid;
        }
        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("hahajing");
        $input->SetAttach("hahajing");
        $input->SetOut_trade_no($order_data['order_no']);
        $total_amount=$order_data['total_amount'] * 100;
        $input->SetTotal_fee($total_amount);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("hahajing");
        $input->SetNotify_url("http://weixin.hahajing.com/WxpayAPI_php_v3/example/notify.php");
        //$input->SetNotify_url("http://test.hahajing.com/WxpayAPI_php_v3/example/notify.php");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        return $jsApiParameters;
        //********************微信支付结束*********************
    }

    //获取活动产品库存是否够用
    public function is_stock_max($shop_id){
        $url=API_URL.'/rest_2/cart/is_package_max_stock';
        $post_data = array('shop_id'=>$shop_id);
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
    //判断手机号有没有参加扫码一元活动
    public function is_activities($user_account){
        $url=API_URL.'/rest_2/cart/is_activities';
        $post_data = array();
        $post_data['user_account']=$user_account;
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
    //登录用户
    public function yd_quick_load($mobile){
        $url=API_URL.'/rest_2/user/yd_quick_load';
        $post_data = array();
        $post_data['mobile']=$mobile;//手机号
        $post_data['eqt_name']='weixin';
        $post_data['phone_sn']='123456';
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr;
            }else{
                return $arr;
            }
        }else{
            return false;
        }
    }
     //添加购物车
    public function activity_cart_add($data,$uid,$token){
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
                return $arr['data'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //根据订单编号删除对应的openid
    public function delArr(){
        $oreder_no=$_REQUEST['oreder_no'];
        $activety_type='2';
        $arr=array('oreder_no'=>$oreder_no,'activety_type'=>$activety_type);
        $LinshiActivety = D('Home/LinshiActivety');
        $LinshiActivety->delArr($arr);
    }
}
?>