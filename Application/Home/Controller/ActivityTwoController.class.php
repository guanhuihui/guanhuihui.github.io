<?php
namespace Home\Controller;
use Think\Controller;
class ActivityTwoController extends CommonController {
    function _initialize() {
        parent::_initialize();
        $this->phone_arr = array('13381132197','13381132190','18911491054','13548081636','13910878054','13501233304','13810253518','18210533742','15810128956','18201028526','15010325014','15010533670','13241835282','18201028526','18600027944','18610540844','15810748732','13466556166','13701225084','13811643687','18910268622','15901529371','15601019258','13910783596','18810898900','18801022546','18518370165','18513872424','18311442952','13911824822','13811552512','13936501881','18618204113','15810128956','18500219475','15160020755','18201377292','18618496879','18610010155','17710522044','18601379957','13910731893','18612610128','13717688529','18618368411','18614074943','13807156178','13901304467','13651287433','13910564505','15101163550','13854283268','13910714202','17710279292','15210089030','18810616191','15210280090','18910021561','18514465711','13426070049','15901172368','13811531722','13546484973','13146204691','13811530290','18513835004','13754877882','15911002807','18001258162','15201155410','18501369309','13552533521','15718870032','15175598285','18601911626','13301078632','15801576893','13835873761','15010041988','13520444286','15911085693','13466683012','13601075708','15910649117','18610036221','13126658990','13241025667','18001028461','18504625388','13161127117','13651161926','13381035587','13260324084','13811609748','18514529256','13701388532','13501130378','13810209744','13552973453','13911710165','13041210157','18611633968','18665858059','13001286647','18600746458','17896033914','13811088830','15801264945','13581979982','18101081418','18610989976','15001129988','18501255454','15321881101','13910823158','13810308010','15120005784','13810316700','15810076130','13911388500','13701375275','13911831339','13661339301','13910558107','13901085038','18830469982','15810378616','18813103229','15733182865','18833517002','18910350620','13269855127','18800129746','18612461263','15801575689','13520988182','13801042172','18622076597','13651290545','13521198256','13716906564','13810345134','15810577807','18911028386','18610181213','13381100058','15210658132','13811052663','13381220781','13901242176','13581680605','18610247387','15810991575','13661031373','13811170887','18601284884','18910673952','17600858500','18910569644','13810721945','15659030908','13901385197','18600003347','13521582628','18210292320','15001281711','13901278160','13811926203','18910239957','13701244084','13466558922','13522524071','13501188980','13901378847','13901244826','13701134462','18601116691','13552579466','13811437783','13511000803','15601017001','13911562340','18701387343','13311385710','13501307731','18910357260','13911746511','18601208055','18600045006','13488709105','18811001212','13901335033','13439117559','13601004890','18911905560','13001953671','13001962650','13911269143','18601118681','13810730940','13811710929','13501374518','18511878762','13501063182','13901191121','18600193680','18611492128','18611302500','18600200850','13911020598','13701169745','13811509483','13901278160','13801212852','18201165609','18611553123','13901040637','13146095554','13581966144','18601736391','13811134770','18601208949','15801253771','13001092517','13810575808','13911829982','13661036757','18600757191','18616116922','13488653598','18611375260','13810575808','15811213722','18123353979','13501188980','13391399203','13810666863','13701294123','13910276764','13601392411','13621207576','18210120533','13522439726','13521336853',18633026803 ,18500295944 ,15201290415 ,18618105280 ,13910871466 ,18630175500 ,18500067631 ,13381158258 ,18600372246 ,18611096111 ,18813094892 ,15810395706 ,18800129485 ,13681373276 ,13601105725 ,13810065441 ,18611100574 ,18500206865 ,18510237668 ,13466566471 ,13810225432 ,15910560325 ,15827501222 ,18612271736 ,13810587128 ,13581974640 ,15811137146 ,13426370146 ,13910657301 ,18611629113 ,13910897241 ,13501060758 ,13426083034 ,13581966144 ,13146095554 ,13381132197 ,13911829982 ,13661036757 ,18600757191 ,18616116922 ,13488653598 ,13701294123 ,13910276764,13801004410,13901582414,13701228728,13311385326,15001190249,18513037618,15801262743,18611010056,13501188980,13811651476,13520245056,18600520629,13671349455,13661164967,13311385326,13522393622,13811448964,15652906691);
    }
    public function index(){
        exit();
    	$this->display();
    }
    public function index_ok(){
    	$this->display();
    }

    //请求输入手机号码
    public function get_ticket_2(){
    	$phone=$_REQUEST['phone'];
    	if (empty($phone)) {
    		echo json_encode(array('result'=>'error','msg'=>'请求输入手机号码'));
            exit();
    	}
    	$return_data=self::get_get_ticket_2($phone);
    	if ($return_data) {
    		if ($return_data['code'] == '1') {
    			echo json_encode(array('result'=>'ok','msg'=>'优惠券已领取成功'));
            	exit();
    		}else{
    			echo json_encode(array('result'=>'error','msg'=>$return_data['msg']));
            exit();
    		}
    		
    	}else{
    		echo json_encode(array('result'=>'error','msg'=>'领取失败！'));
            exit();
    	}

    }

    public function get_get_ticket_2($phone){
        $url=API_URL.'/activity/get_ticket_2';
        $post_data = array('phone'=>$phone);
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            return $arr;
        }else{
            return false;
        }
    }

    //协议
    public function get_xieyi(){
        $this->display();
    }
    //滴滴领券页面
    public function set_didi_ticket(){
        header("Location:".'http://weixin.hahajing.com/ActivityTwo/share_index/pid/1');
        exit();
        $_SESSION['activity_opid']='';
        //微信授权
        $is_weixin=$_REQUEST['is_weixin'];
        if ($is_weixin == '1') {
            $tools = new \JsApiPay();
            $openId = $tools->GetOpenid();
            $_SESSION['activity_opid']=$openId;
        }
        
        $openId=$_REQUEST['sine'];
        $weibo=$_REQUEST['weibo'];
        $ip=$_SERVER["REMOTE_ADDR"];
        $LinshiIp = D('Home/LinshiIp');
        $type=2;
        if (!empty($openId)) {
            //存储微信id
            $_SESSION['activity_opid']=$openId;
            $type=1;
        }
        
        if (!empty($weibo)) {
            $type=3;
        }
        //添加ip记录
        $data=array('ip'=>$ip,'add_time'=>time(),'url_type'=>$type);
        $LinshiIp->add_data($data);
        $this->display();
    }

    //购物车页面
    public function phone_login(){
        echo "<h1>活动已经结束</h1>";
        exit();
        //$openId='o25KXjiETFnnk88L-nO9c4R429Pk';
        if ($_SESSION['openid'] != '') {
            $openId=$_SESSION['openid'];
        }
        if (!empty($openId)) {
            //存储微信id
            $_SESSION['activity_opid']=$openId;
        }
        $phone=$_REQUEST['phone'];
        $shop_id='5055';
        $goods_id='6750';
        if (empty($phone)) {
            echo "手机号不能为空";
            exit();
        }
        //用户登录
        $return_user_data=self::yd_quick_load($phone);
        if ($return_user_data['result'] == 'ok') {
            //登录成功，保存值
            $user_data=$return_user_data['data'];
            if(!session_id()){
                session_start();
            }
            $_SESSION['activity_user_data']=$user_data;
            //获取是否有火锅未支付订单
            $order_on=self::get_not_paid_hotpo($user_data['user_id'],$user_data['token']);
            if ($order_on) {
                //如果有支付订单，直接跳转到支付页
                Header("Location:/ActivityTwo/state?order_on=".$order_on);
            }
            //添加数据
            $data=array();
            $data['shop_id']=$shop_id;
            $data['goods_id']=$goods_id;
            $data['count']=1;
            self::activity_cart_add($data,$user_data['user_id'],$user_data['token']);
            //获取单一购物车信息
            $cart_data_info=self::cart_get_data($shop_id,'0','0',$user_data['user_id'],$user_data['token']);
            $cart_goods_count=0;//购物车数量
            $cart_id=0;//购物车ID
            $book_ticket_id=0;//优惠券ID
            if (!empty($cart_data_info)) {
                $goods_list=$cart_data_info['shop_cart_data']['book_goods_data']['goods_data']['goods_list'];
                foreach ($goods_list as $key => $one) {
                    if ($one['goods_id'] == $goods_id) {
                        $cart_goods_count=$cart_goods_count+$one['count'];
                        $cart_id=$one['cart_id'];
                        $book_ticket_id=$cart_data_info['shop_cart_data']['book_goods_data']['book_ticket_id'];
                    }
                }
            }

            //判断时间
            //截止时间
            $end_time=date("Y/m/d",time());
            $current_time=date('H',time());
            $xianshi_data=array();
            if ($current_time < 11) {
                $end_time=date("Y/m/d",time());
                //时间定为后天，大后天
                $xianshi_data['hou_time']=date("m-d",strtotime("+1 day"));
                $xianshi_data['dahouhou_time']=date("m-d",strtotime("+2 day"));
            }else{
                $end_time=date("Y/m/d",strtotime("+1 day"));
                $xianshi_data['hou_time']=date("m-d",strtotime("+2 day"));
                $xianshi_data['dahouhou_time']=date("m-d",strtotime("+3 day"));
            }
            $this->assign("book_ticket_id",$book_ticket_id);
            $this->assign("cart_goods_count",$cart_goods_count);
            $this->assign("cart_id",$cart_id);
            $this->assign("xianshi_data",$xianshi_data);
            $this->assign("end_time",$end_time);
            $this->display();
        }else{
            echo "请重新打开页面";
            exit();
        }

    }




    //结算页
    public function confirm(){
        $shop_id='5055';
        $goods_id='6750';
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        $openid=$_SESSION['activity_opid'];

        //获取默认收货地址
        $address_default=self::address_get_default($activity_user_data['user_id'],$activity_user_data['token']);
        $address_id=0;
        if (!empty($address_default)) {
            $address_id=$address_default['addressid'];
        }
        //获取订单结算页数据
        $data=array();
        $data['address_id']=$address_id;
        $data['shop_id']=$shop_id;
        $data['cart_ids']=$_REQUEST['cart_ids'];
        $data['ticket_list_ids']=$_REQUEST['ticket_list_ids'];
        $data['deliver_type']='0';
        $data['is_book_goods']='1';
        $data['is_local_act']='1';

        $result_data=self::order_confirm($data,$activity_user_data['user_id'],$activity_user_data['token']);
        $json_data=$result_data['data'];
        if ($result_data['result'] != 'ok') {
            echo '请重新打开页面11';
            exit();
        }
        $goods_list=$json_data['goods_list'];
        $count=0;
        foreach ($goods_list as $key => $one) {
            if ($one['goods_id'] == $goods_id) {
                $count=$count+$one['count'];
            }
        }
        $data_day=self::get_book_hour();

        //判断时间
        $current_time=date('H',time());
        $xianshi_data=array();
        if ($current_time < 11) {
            //时间定为后天，大后天
            $xianshi_data['hou_time']=date("Y-m-d",strtotime("+1 day"));
            $xianshi_data['dahouhou_time']=date("Y-m-d",strtotime("+2 day"));
        }else{
            $xianshi_data['hou_time']=date("Y-m-d",strtotime("+2 day"));
            $xianshi_data['dahouhou_time']=date("Y-m-d",strtotime("+3 day"));
        }
        $this->assign("xianshi_data",$xianshi_data);
        $this->assign("openid",$openid);
        $this->assign("data",$json_data);
        $this->assign("data_day",$data_day);
        $this->assign("address_default",$address_default);
        $this->assign("count",$count);
        $this->assign("cart_ids",$_REQUEST['cart_ids']);
        $this->assign("ticket_list_ids",$_REQUEST['ticket_list_ids']);
        // print_r($address_default);
        // exit();

        $this->display();
    }

    //添加订单
    public function add(){
        $shop_id='5055';
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        $openid=$_SESSION['activity_opid'];

        $data=array();
        $data['address_id']=$_REQUEST['address_id'];
        $data['shop_id']=$shop_id;
        $data['cart_ids']=$_REQUEST['cart_ids'];
        $data['deliver_type']='0';
        $data['ticket_list_ids']=$_REQUEST['ticket_list_ids'];
        $data['pay_type']=$_REQUEST['pay_type'];
        $data['book_time']=$_REQUEST['book_time'];
        $data['user_name']=$_REQUEST['user_name'];
        $data['telphone']=$_REQUEST['telphone'];
        $data['is_book_goods']='1';
        $data['is_local_act']='1';
        $rester_arr=self::order_add($data,$activity_user_data['user_id'],$activity_user_data['token']);
        if ($rester_arr['result']=='1') {
            //如果是到店自提，则直接跳转成功页
            if ($data['pay_type'] == '40') {
                echo json_encode(array('result'=>'ok','pay_type'=>$data['pay_type'],'msg'=>$rester_arr['data']));
                exit();
            }else{
                //判断支付开关是否开启
            if (($rester_arr['data']['pay_status'] == 1) && ($rester_arr['data']['shop_pay_status'] == 1)) {
                if ($_REQUEST['pay_type'] == '10') {
                    //微信支付
                    echo json_encode(array('result'=>'ok','pay_type'=>$data['pay_type'],'msg'=>$rester_arr['data']));
                    exit();
                }elseif ($_REQUEST['pay_type'] == '20') {
                    //支付宝支付
                    $zhifubao_html=self::pay_zhifubao($rester_arr['data']);
                    echo json_encode(array('result'=>'ok','pay_type'=>$data['pay_type'],'msg'=>$rester_arr['data'],'html'=>$zhifubao_html));
                    exit();
                }
            }else{
                echo json_encode(array('result'=>'error','msg'=>'暂时不支持支付，请选择到店自提'));
                exit();
            }

            }
            
            
        }else{
            echo json_encode(array('result'=>'error','msg'=>$rester_arr['data']['msg']));
        }
    }

    //添加地址
    public function set_address_add(){
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        //订单确认页需要数据
        $ticket_list_ids=$_REQUEST['ticket_list_ids'];
        $cart_ids=$_REQUEST['cart_ids'];
        if (IS_POST) {
            $name=$_POST['name'];//用户名称
            $district=$_POST['district'];//用户区域地址信息
            $address=$_POST['address'];//用户地址 
            $mobile=$_POST['mobile'];//用户手机号

            $data=array();
            $data['name']=$name;
            $data['district']=$district;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $data['city_id']='133';
            $data['lat']='39.946525076484';
            $data['lng']='116.43688920825';
            $rester=self::address_add($data,$activity_user_data['user_id'],$activity_user_data['token']);
            if ($rester) {
                //设置默认收货地址
                self::address_set_default($rester,$activity_user_data['user_id'],$activity_user_data['token']);
                Header("Location:/ActivityTwo/confirm?ticket_list_ids=$ticket_list_ids&cart_ids=$cart_ids");
                
            }else{
                Header("Location:/ActivityTwo/confirm?ticket_list_ids=$ticket_list_ids&cart_ids=$cart_ids");
            }
        }
        $this->assign("ticket_list_ids",$_REQUEST['ticket_list_ids']);
        $this->assign("cart_ids",$_REQUEST['cart_ids']);
        $this->display();
    }
    //修改地址
        public function edit(){
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        $address_id=$_REQUEST['address_id'];

        if (IS_POST) {
            //订单确认页需要数据
            $ticket_list_ids=$_REQUEST['ticket_list_ids'];
            $cart_ids=$_REQUEST['cart_ids'];

            $data=array();
            $name=$_POST['name'];//用户名称
            $district=$_POST['district'];//用户区域地址信息
            $address=$_POST['address'];//用户地址 
            $mobile=$_POST['mobile'];//用户手机号
            $address_id=$_POST['address_id'];//id
            $data=array();
            $data['address_id']=$address_id;
            $data['name']=$name;
            $data['district']=$district;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $data['city_id']='133';
            $data['lng']='39.946525076484';
            $data['lat']='116.43688920825';
            $rester=self::address_edit($data,$activity_user_data['user_id'],$activity_user_data['token']);
            if ($rester) {
                header("Location:".U("ActivityTwo/confirm?ticket_list_ids=$ticket_list_ids&cart_ids=$cart_ids"));
            }
        }
        $address_data=address_detail($address_id,$activity_user_data['user_id'],$activity_user_data['token']);
        $this->assign("address_data",$address_data);
        $this->assign("address_id",$address_id);
        $this->display();
    }

    //生产新订单
    public function order_add($data,$uid,$token){
        $url=API_URL.'/rest_2/order/add';
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
                return array('result'=>'1','data'=>$arr['data']);
            }else{
                return array('result'=>'0','data'=>$arr['data']);
            }
        }else{
            return array('result'=>'0','data'=>array('msg'=>'提交订单失败'));
        }
    }

        public function get_book_hour($endtime_time='79200'){
        $data['book_day'] = array('2016-12-03','2016-12-04');
        $data['book_hour'] = array();
        $starttime_time = '43200';
        //$endtime_time = '79200';
        //小时段选项
        $data['book_hour'] = array();
        $_num = intval(($endtime_time-$starttime_time)/3600);
        if($_num){
            $starttime = strtotime('January 1 1970 00:00:00') + $starttime_time;
            for($i=0; $i<$_num; $i++) {
                $data['book_hour'][] = date('H:i', $starttime+($i*3600)).'-'.date('H:i', $starttime+(($i+1)*3600));
            }
        }
        return $data;
    }


    //订单详情
    public function state(){
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        $openid=$_SESSION['activity_opid'];
        $order_no=$_REQUEST['order_on'];
        //$order_no='5161130150453653614';
        $count=0;
        $order_detail=self::new_order_detail($order_no,$activity_user_data['user_id'],$activity_user_data['token']);
        if (!empty($order_detail)) {
            $other_list=$order_detail['other_list'];
            foreach ($other_list as $key => $one) {
                if ($one['goods_id'] == '6750') {
                   $count= $one['count'];
                }
            }
        }
        $this->assign("order_detail",$order_detail);
        $this->assign("openid",$openid);
        $this->assign("count",$count);
        $this->assign("user_data",$activity_user_data);
        $this->display();
    }

    public function new_order_detail($order_no='0',$uid,$token){
        $url=API_URL.'/rest_2/order/order_detail';
        $post_data = array();
        $post_data['order_no']=$order_no;
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
    //重新支付
    public function order_repay(){
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        $openid=$_SESSION['activity_opid'];

        $order_no=$_REQUEST['order_no'];
        $pay_type=$_REQUEST['pay_type'];
        $data=array('order_no'=>$order_no);
        $order_repay_arr=self::get_order_repay($data,$activity_user_data['user_id'],$activity_user_data['token']);
        if (!$order_repay_arr) {
            echo json_encode(array('result'=>'error','msg'=>'订单已取消，关闭页面后重新下单'));
            exit();
        }
        if (($order_repay_arr['pay_status'] == 1) && ($order_repay_arr['shop_pay_status'] == 1)) {
        
        if ($pay_type == '10') {
            //微信支付
            echo json_encode(array('result'=>'ok','pay_type'=>'10','msg'=>$order_repay_arr['order_no']));
            exit();
        }elseif ($_REQUEST['pay_type'] == '20') {
            //支付宝支付
            $zhifubao_html=self::pay_zhifubao($order_repay_arr);
            echo json_encode(array('result'=>'ok','pay_type'=>20,'msg'=>$order_repay_arr['order_no'],'html'=>$zhifubao_html));
            exit();
        }
        }

    }

        //重新支付
    public function get_order_repay($data,$uid,$token){
        $url=API_URL.'/rest_2/order/pay_again';
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

    //订单确认页
    public function order_confirm($data,$uid,$token){
        $url=API_URL.'/rest_2/order/confirm';
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
                return array('result'=>'ok','data'=>$arr['data']);
            }else{
                return array('result'=>'error','data'=>$arr['data']['msg']);
            }
        }else{
            return false;
        }
    }

    //微信支付根据订单id调取订单详细信息
    public function weixin_order_date(){
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];

        $order_no=$_REQUEST['order_no'];
        if (!empty($order_no)) {
           $order_detail=self::new_order_detail($order_no,$activity_user_data['user_id'],$activity_user_data['token']);
            echo self::pay_weixin($order_detail);
            exit();
        }
    }


    public function pay_weixin($order_data=''){
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

        //支付宝支付公共方法
    public function pay_zhifubao($order_data=''){
        //支付宝支付dome
            /**************************请求参数**************************/
            //商户订单号，商户网站订单系统中唯一订单号，必填
            $WIDout_trade_no=rand(100000000,1000000000);
            $out_trade_no = $order_data['order_no'];
            //$out_trade_no =$WIDout_trade_no;
            //订单名称，必填
            $subject = 'hahajing';
            //付款金额，必填
            $total_fee = $order_data['total_amount'];
            //收银台页面上，商品展示的超链接，必填
            $show_url = 'http://weixin.hahajing.com/';
            //商品描述，可空
            $body = 'hahajing';
            /************************************************************/
            $alipaySubmit = new \ZfPayConfig();
            $alipay_config=$alipaySubmit->reutn_config();
            //构造要请求的参数数组，无需改动
            $parameter = array(
                "service"=>$alipay_config['service'],
                "partner"=>$alipay_config['partner'],
                "seller_id"=>$alipay_config['seller_id'],
                "payment_type"=>$alipay_config['payment_type'],
                "notify_url"=>'http://www.hahajing.com/pay/alipay_notify',
                "return_url"=>'http://weixin.hahajing.com/ActivityTwo/succeed',
                "_input_charset"=>trim(strtolower($alipay_config['input_charset'])),
                "out_trade_no"=>$out_trade_no,
                "subject"=>$subject,
                "total_fee"=>$total_fee,
                "show_url"=>$show_url,
                "app_pay" => "Y",//启用此参数能唤起钱包APP支付宝
                "body"=>$body,
                //其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.2Z6TSk&treeId=60&articleId=103693&docType=1
                //如"参数名"    => "参数值"   注：上一个参数末尾需要“,”逗号。     
              );

              //建立请求
              $alipaySubmit = new \AlipaySubmit($alipay_config);
              $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
              return $html_text;
              //支付宝支付结束
    }

    public function succeed(){
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];

        $out_trade_no=$_REQUEST['order_no'];
        $pay_type=$_REQUEST['pay_type'];
        if ($pay_type=='40') {
            $order_detail=self::new_order_detail($out_trade_no,$activity_user_data['user_id'],$activity_user_data['token']);
        }elseif($pay_type=='10'){
            $order_detail=self::new_order_detail($out_trade_no,$activity_user_data['user_id'],$activity_user_data['token']);
        }else{
            ////计算得出通知验证结果
            $alipaySubmit = new \ZfPayConfig();
            $alipay_config=$alipaySubmit->reutn_config();
            $alipayNotify = new \AlipayNotify($alipay_config);
            $verify_result = $alipayNotify->verifyReturn();
            if($verify_result) {//验证成功
                //商户订单号
                $out_trade_no = $_GET['out_trade_no'];
                //支付宝交易号
                $trade_no = $_GET['trade_no'];
                //交易状态
                $trade_status = $_GET['trade_status'];
                if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //如果有做过处理，不执行商户的业务程序
                    //交易已成功
                    $order_detail=self::new_order_detail($out_trade_no,$activity_user_data['user_id'],$activity_user_data['token']);
                }else {
                    //交易未成功
                  echo "trade_status=".$_GET['trade_status'];
                }

            }else{
                echo "验证失败";
            }
        }
        

        $this->assign("order_detail",$order_detail);
        $this->assign("user_data",$activity_user_data);
        $this->display();
    }

    public function get_detailed(){
        $this->display();
    }

    //添加购物车
    public function cart_add(){
        if (empty($_SESSION['activity_user_data'])) {
            echo json_encode(array('result'=>'error','msg'=>"添加失败，请重新打开页面"));
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        
        $shop_id='5055';
        $goods_id='6750';
        $count=$_REQUEST['count'];
        if (empty($count)) {
            $count='1';
        }
        $data=array();
        $data['shop_id']=$shop_id;
        $data['goods_id']=$goods_id;
        $data['count']=$count;
        $rester=self::activity_cart_add($data,$activity_user_data['user_id'],$activity_user_data['token']);

        if ($rester) {
            //获取相应数据
            //获取单一购物车信息
            $cart_data_info=self::cart_get_data($shop_id,'0','0',$activity_user_data['user_id'],$activity_user_data['token']);
            $cart_goods_count=0;//购物车数量
            $cart_id=0;//购物车ID
            $book_ticket_id=0;//优惠券ID
            if (!empty($cart_data_info)) {
                $goods_list=$cart_data_info['shop_cart_data']['book_goods_data']['goods_data']['goods_list'];
                foreach ($goods_list as $key => $one) {
                    if ($one['goods_id'] == $goods_id) {
                        $cart_goods_count=$cart_goods_count+$one['count'];
                        $cart_id=$one['cart_id'];
                        $book_ticket_id=$cart_data_info['shop_cart_data']['book_goods_data']['book_ticket_id'];
                    }
                }
            }

                echo json_encode(array('result'=>'ok','msg'=>"添加成功",'arr'=>array('cart_goods_count'=>$cart_goods_count,'cart_id'=>$cart_id,'book_ticket_id'=>$book_ticket_id)));
            }else{
                echo json_encode(array('result'=>'error','msg'=>"添加失败"));
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

    //查看未支付火锅订单
    public function get_not_paid_hotpo($uid,$token){
        $url=API_URL.'/rest_2/order/not_paid_hotpo';
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

    //新版获取购物车详细信息
    public function cart_get_data($shop_id,$act_ticket,$goods_ticket,$uid,$token){
        $url=API_URL.'/rest_2/cart/get_cart_new';
        $post_data = array();
        $post_data['shop_id']=$shop_id;
        $post_data['act_ticket']=$act_ticket;
        $post_data['goods_ticket']=$goods_ticket;
        $post_data['special_act']='1';
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

    //获取默认收货地址
    public function address_get_default($uid,$token){
        $url=API_URL.'/rest_2/address/get_default';
        $post_data = array();
        $post_data['address_id']=$address_id ;
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

        //添加地址
    public function address_add($data,$uid,$token){
        $url=API_URL.'/rest_2/address/add';
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
                return $arr['data']['address_id'];
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

        //设置默认收货地址
    public function address_set_default($address_id,$uid,$token){
        $url=API_URL.'/rest_2/address/set_default';
        $post_data = array();
        $post_data['address_id']=$address_id ;
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

        //根据收货地址id获取详细信息
    public function address_detail($address_id,$uid,$token){
        $url=API_URL.'/rest_2/address/detail';
        $post_data = array();
        $post_data['address_id']=$address_id ;
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


    //**************************新活动***********************
    //填写手机号页面
    public function act_one_yuan(){
        echo "<h2>活动已经结束</h2>";
        exit();
        $_SESSION['activity_opid']='';
        //微信授权
        $tools = new \JsApiPay();
        $openId = $tools->GetOpenid();
        $_SESSION['activity_opid']=$openId;

        $LinshiIp = D('Home/LinshiIp');
        $ip=$_SERVER["REMOTE_ADDR"];
        $data=array('ip'=>$ip,'add_time'=>time(),'url_type'=>'4');
        $LinshiIp->add_data($data);
        $this->display();
    }
    //是否有已付款一元购订单
    public function get_is_one_yuan(){
        $phone=$_REQUEST['phone'];
        if (empty($phone)) {
            echo json_encode(array('result'=>'error','msg'=>'手机号不能为空'));
            exit();
        }
        //判断手机号是否是种子手机号
        $is_zhongzi=false;
        $phone_arr_a=$this->phone_arr;
        foreach ($phone_arr_a as $key => $one) {
            if ($one == $phone) {
                $is_zhongzi=true;
            }
        }
        if (!$is_zhongzi) {
            echo json_encode(array('result'=>'error','msg'=>'您手机号不符合要求'));
            exit();
        }
        //用户登录
        $return_user_data=self::yd_quick_load($phone);
        if ($return_user_data['result'] == 'ok') {
            //登录成功，保存值
            $user_data=$return_user_data['data'];
            if(!session_id()){
                session_start();
            }
        }
        //判断是否下过一元订单
        $return_data=self::is_one_yuan($user_data['user_id'],$user_data['token']);
        if (!$return_data) {
            echo json_encode(array('result'=>'ok'));
        }else{
            echo json_encode(array('result'=>'er_ok','msg'=>'您已下过订单，不可重复下单','pid'=>$user_data['user_id']));
        }
    }
    public function is_one_yuan($uid,$token){
        $url=API_URL.'/rest_2/order/is_one_yuan';
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
    //产品详情页
    public function xiangqing(){ 
        $openId=$_SESSION['activity_opid'];
        if (empty($openId)) {
            echo "请用微信打开连接";
            exit();
        }
        $phone=$_REQUEST['phone'];
        $shop_id='5055';
        $goods_id='6750';
        if (empty($phone)) {
            echo "手机号不能为空";
            exit();
        }
        $is_zhongzi=false;
        $phone_arr_a=$this->phone_arr;
        foreach ($phone_arr_a as $key => $one) {
            if ($one == $phone) {
                $is_zhongzi=true;
            }
        }
        if (!$is_zhongzi) {
            echo "您手机号不符合要求";
            exit();
        }
        //用户登录
        $return_user_data=self::yd_quick_load($phone);
        if ($return_user_data['result'] == 'ok') {
            //登录成功，保存值
            $user_data=$return_user_data['data'];
            if(!session_id()){
                session_start();
            }
            $_SESSION['activity_user_data']=$user_data;
            //判断时候下过订单
            $return_data=self::is_one_yuan($user_data['user_id'],$user_data['token']);
            if ($return_data) {
                echo "您已下过订单，不可重复下单";
                exit();
            }
            //获取是否有火锅未支付订单
            $order_on=self::yiyuan_get_not_paid_hotpo($user_data['user_id'],$user_data['token']);
            if ($order_on) {
                //如果有支付订单，直接跳转到支付页
                Header("Location:/ActivityTwo/state?order_on=".$order_on);
            }
            //添加数据
            $data=array();
            $data['shop_id']=$shop_id;
            $data['goods_id']=$goods_id;
            $data['count']=1;
            self::activity_cart_add($data,$user_data['user_id'],$user_data['token']);
            //获取单一购物车信息
            $cart_data_info=self::cart_get_data($shop_id,'0','0',$user_data['user_id'],$user_data['token']);
            $cart_goods_count=0;//购物车数量
            $cart_id=0;//购物车ID
            $book_ticket_id=0;//优惠券ID
            if (!empty($cart_data_info)) {
                $goods_list=$cart_data_info['shop_cart_data']['book_goods_data']['goods_data']['goods_list'];
                foreach ($goods_list as $key => $one) {
                    if ($one['goods_id'] == $goods_id) {
                        $cart_goods_count=$cart_goods_count+$one['count'];
                        $cart_id=$one['cart_id'];
                        $book_ticket_id=$cart_data_info['shop_cart_data']['book_goods_data']['book_ticket_id'];
                    }
                }
            }

            //判断时间
            $current_time=date('H',time());
            $xianshi_data=array();
            if ($current_time < 11) {
                //时间定为后天，大后天
                $xianshi_data['hou_time']=date("m-d",strtotime("+1 day"));
                $xianshi_data['dahouhou_time']=date("m-d",strtotime("+2 day"));
            }else{
                $xianshi_data['hou_time']=date("m-d",strtotime("+2 day"));
                $xianshi_data['dahouhou_time']=date("m-d",strtotime("+3 day"));
            }
            $this->assign("book_ticket_id",$book_ticket_id);
            $this->assign("cart_goods_count",$cart_goods_count);
            $this->assign("cart_id",$cart_id);
            $this->assign("xianshi_data",$xianshi_data);
            $this->assign("user_data",$user_data);
            $this->display();
        }else{
            echo "请重新打开页面";
            exit();
        }
    }


    //订单结算页
    public function confirm_html(){
        $shop_id='5055';
        $goods_id='6750';
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        $openid=$_SESSION['activity_opid'];

        //获取默认收货地址
        $address_default=self::address_get_default($activity_user_data['user_id'],$activity_user_data['token']);
        $address_id=0;
        if (!empty($address_default)) {
            $address_id=$address_default['addressid'];
        }
        //获取订单结算页数据
        $data=array();
        $data['address_id']=$address_id;
        $data['shop_id']=$shop_id;
        $data['cart_ids']=$_REQUEST['cart_ids'];
        //$data['ticket_list_ids']=$_REQUEST['ticket_list_ids'];
        $data['deliver_type']='0';
        $data['is_book_goods']='1';
        $data['is_local_act']='2';

        $result_data=self::order_confirm($data,$activity_user_data['user_id'],$activity_user_data['token']);
        $json_data=$result_data['data'];
        if ($result_data['result'] != 'ok') {
            echo '请重新打开页面11';
            exit();
        }
        $goods_list=$json_data['goods_list'];
        $count=0;
        foreach ($goods_list as $key => $one) {
            if ($one['goods_id'] == $goods_id) {
                $count=$count+$one['count'];
            }
        }
        $shop_data=A('Category')->shop_get_info($shop_id);
        $data_day=self::get_book_hour();

        //判断时间
        $current_time=date('H:i',time());
        $xianshi_data=array();
        $end_time=$shop_data['shop_bookend_time'];
        if (empty($end_time)) {
            $end_time='23:00';
        }
        $hi_time=self::get_passtime_str($end_time);
        if ($current_time < $hi_time) {
            //时间定为后天，大后天
            for ($i=1; $i <= 7; $i++) { 
                $yuyue_time='';
               $yuyue_time=date("Y-m-d",strtotime("+$i day"));
               if ($yuyue_time != '2016-12-21') {
                  $xianshi_data[]=$yuyue_time;
               }
               
            }
        }else{
            for ($i=2; $i <= 8; $i++) { 
                $yuyue_time='';
                $yuyue_time=date("Y-m-d",strtotime("+$i day"));
                if ($yuyue_time != '2016-12-21') {
                  $xianshi_data[]=$yuyue_time;
                }
            }
        }
        $this->assign("xianshi_data",$xianshi_data);
        $this->assign("openid",$openid);
        $this->assign("data",$json_data);
        $this->assign("data_day",$data_day);
        $this->assign("address_default",$address_default);
        $this->assign("count",$count);
        $this->assign("cart_ids",$_REQUEST['cart_ids']);
        $this->assign("ticket_list_ids",$_REQUEST['ticket_list_ids']);
        $this->assign("user_data",$activity_user_data);
        $this->display();
    }

    public function get_passtime_str($time){
        $starttime = strtotime('January 1 1970 00:00:00');
        return date('H:i', $time+$starttime);
    }

    //查看是否有一元购订单
    public function yiyuan_get_not_paid_hotpo($uid,$token){
        $url=API_URL.'/rest_2/order/not_paid_one_yuan';
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


    //分享页面的首页
    public function share_index(){
        // $tools = new \JsApiPay();
        // $openId = $tools->GetOpenid();
        $pid=$_REQUEST['pid'];
        if (empty($pid)) {
            echo "请重新打开页面";
            exit();
        }
        // $LinshiIp = D('Home/LinshiIp');
        // $ip=$_SERVER["REMOTE_ADDR"];
        // $data=array('ip'=>$ip,'add_time'=>time(),'url_type'=>'5');
        // $LinshiIp->add_data($data);
        //如果领取过优惠券，显示优惠券
        $this->assign("pid",$pid);
        $this->display();
    }
    public function add_lin(){
        $LinshiIp = D('Home/LinshiIp');
        $ip=$_SERVER["REMOTE_ADDR"];
        $data=array('ip'=>$ip,'add_time'=>time(),'url_type'=>'6');
        $LinshiIp->add_data($data);
    }
    //领取券
    public function get_act_ticket(){
        $phone=$_REQUEST['phone'];
        $pid=$_REQUEST['pid'];
        if (empty($phone)) {
            echo json_encode(array('result'=>'error','msg'=>'手机号不能为空'));
            exit();
        }
        //登录
        $return_user_data=self::yd_quick_load($phone);
        if ($return_user_data['result'] == 'ok') {
            //登录成功，保存值
            $user_data=$return_user_data['data'];
            if(!session_id()){
                session_start();
            }
            $_SESSION['zhongzi_user_data']=$user_data;     
            //判断是否领过券接口
            $is_tickets=self::is_get_tickets(array('user_tel'=>$phone),$user_data['user_id'],$user_data['token']);
            if (!$is_tickets) {
                $ticket_list=self::get_ticket_list('',$user_data['user_id'],$user_data['token']);
                echo json_encode(array('result'=>'ok','msg'=>'优惠券领取成功','ticket_list'=>$ticket_list));
                exit();
            }
            //领券接口
            $add_ticket_arr=self::set_act_ticekts(array('user_id'=>$user_data['user_id'],'seed_user_id'=>$pid),$user_data['user_id'],$user_data['token']);
            if (!$add_ticket_arr) {
                echo json_encode(array('result'=>'error','msg'=>'优惠券领取失败，请重新打开'));
                exit();
            }
            //添加关系表数据
            self::seed_add(array('pid'=>$pid,'cid'=>$user_data['user_id']));
            $ticket_list=self::get_ticket_list('',$user_data['user_id'],$user_data['token']);
            echo json_encode(array('result'=>'ok','msg'=>'优惠券领取成功','ticket_list'=>$ticket_list));
            exit();
        }
        
    }

    //优惠券显示页面
    public function ticket_list_html(){
        $user_data=$_SESSION['zhongzi_user_data'];
        if (empty($user_data)) {
               echo "请重新打开页面";
           }
        $ticket_list=self::get_ticket_list('',$user_data['user_id'],$user_data['token']);
        $this->assign("ticket_list",$ticket_list);
        $this->display();
    }
    //判断是否领取过券
    public function is_get_tickets($data,$uid,$token){
        $url=API_URL.'/ticket/is_get_ticket';
        $post_data = array();
        $post_data=$data;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['code'];
            if ($arr_statuses == '1') {
                return true;
            }else{
                return false;
            }
            }else{
            return false;
        }
    }

    //优惠券列表
    public function get_ticket_list($data,$uid,$token){
        $url=API_URL.'/rest_2/coupon/get_ticket_list';
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

    //领取优惠券
    public function set_act_ticekts($data,$uid,$token){
        $url=API_URL.'/ticket/get_act_tickets';
        $post_data = array();
        $post_data=$data;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['code'];
            if ($arr_statuses == '1') {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }


    //一元购添加地址
    public function set_address_add_yiyuan(){
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        //订单确认页需要数据
        $ticket_list_ids=$_REQUEST['ticket_list_ids'];
        $cart_ids=$_REQUEST['cart_ids'];
        if (IS_POST) {
            $name=$_POST['name'];//用户名称
            $district=$_POST['district'];//用户区域地址信息
            $address=$_POST['address'];//用户地址 
            $mobile=$_POST['mobile'];//用户手机号

            $data=array();
            $data['name']=$name;
            $data['district']=$district;
            $data['address']=$address;
            $data['mobile']=$mobile;
            $data['city_id']='133';
            $data['lat']='39.946525076484';
            $data['lng']='116.43688920825';
            $rester=self::address_add($data,$activity_user_data['user_id'],$activity_user_data['token']);
            if ($rester) {
                //设置默认收货地址
                self::address_set_default($rester,$activity_user_data['user_id'],$activity_user_data['token']);
                Header("Location:/ActivityTwo/confirm_html?ticket_list_ids=$ticket_list_ids&cart_ids=$cart_ids");
                
            }else{
                Header("Location:/ActivityTwo/confirm_html?ticket_list_ids=$ticket_list_ids&cart_ids=$cart_ids");
            }
        }
        $this->assign("ticket_list_ids",$_REQUEST['ticket_list_ids']);
        $this->assign("cart_ids",$_REQUEST['cart_ids']);
        $this->display();
    }


    public function seed_add($data){
        $url=API_URL.'/rest_2/SeedRelation/add';
        $post_data = array();
        $post_data=$data;
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

        //添加订单
    public function yiyuan_add(){
        $shop_id='5055';
        if (empty($_SESSION['activity_user_data'])) {
            echo "请重新打开页面";
            exit();
        }
        $activity_user_data=$_SESSION['activity_user_data'];
        $openid=$_SESSION['activity_opid'];

        $data=array();
        $data['address_id']=$_REQUEST['address_id'];
        $data['shop_id']=$shop_id;
        $data['cart_ids']=$_REQUEST['cart_ids'];
        $data['deliver_type']='0';
        $data['ticket_list_ids']=$_REQUEST['ticket_list_ids'];
        $data['pay_type']=$_REQUEST['pay_type'];
        $data['book_time']=$_REQUEST['book_time'];
        $data['user_name']=$_REQUEST['user_name'];
        $data['telphone']=$_REQUEST['telphone'];
        $data['is_book_goods']='1';
        $data['is_local_act']='2';
        $rester_arr=self::order_add($data,$activity_user_data['user_id'],$activity_user_data['token']);
        if ($rester_arr['result']=='1') {
            //如果是到店自提，则直接跳转成功页
            if ($data['pay_type'] == '40') {
                echo json_encode(array('result'=>'ok','pay_type'=>$data['pay_type'],'msg'=>$rester_arr['data']));
                exit();
            }else{
                //判断支付开关是否开启
            if (($rester_arr['data']['pay_status'] == 1) && ($rester_arr['data']['shop_pay_status'] == 1)) {
                if ($_REQUEST['pay_type'] == '10') {
                    //微信支付
                    echo json_encode(array('result'=>'ok','pay_type'=>$data['pay_type'],'msg'=>$rester_arr['data']));
                    exit();
                }elseif ($_REQUEST['pay_type'] == '20') {
                    //支付宝支付
                    $zhifubao_html=self::pay_zhifubao($rester_arr['data']);
                    echo json_encode(array('result'=>'ok','pay_type'=>$data['pay_type'],'msg'=>$rester_arr['data'],'html'=>$zhifubao_html));
                    exit();
                }
            }else{
                echo json_encode(array('result'=>'error','msg'=>'暂时不支持支付，请选择到店自提'));
                exit();
            }

            }
            
            
        }else{
            echo json_encode(array('result'=>'error','msg'=>$rester_arr['data']['msg']));
        }
    }

    //分享页面
    public function fenxiang(){
        $this->assign("pid",$_REQUEST['pid']);
        $this->display();
    }

    //统计
    public function get_linshi_tongji(){
        $LinshiIp = D('Home/LinshiIp');
        //首页
        $shou=$LinshiIp->data_all_count(array('url_type'=>'4'));
        $shou=$shou+56;
        //领券
        $ling=$LinshiIp->data_all_count(array('url_type'=>'5'));
        $ling=$ling+79;
        //点击
        $dian=$LinshiIp->data_all_count(array('url_type'=>'6'));
        $this->assign("shou",$shou);
        $this->assign("ling",$ling);
        $this->assign("dian",$dian);
        $this->display();
    }
}
?>