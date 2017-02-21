<?php
namespace Home\Controller;
use Think\Controller;
class OrderController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }
    public function index(){
        $this->checkxy();
        $this->checklogin();
        $tal=$_REQUEST['tal'];
        //获取代付款数据
        $order_data_1=self::order_get_list('','1','1000','1',$this->user_data['user_id'],$this->user_data['token']);
        
        //获取待收货数据
        $order_data_2=self::order_get_list('','1','1000','2',$this->user_data['user_id'],$this->user_data['token']);
        //获取待评价数据
        $order_data_3=self::order_get_list('','1','1000','3',$this->user_data['user_id'],$this->user_data['token']);
         //获取全部数据
        $order_data_0=self::order_get_list('','1','5','0',$this->user_data['user_id'],$this->user_data['token']);

        $this->assign("order_data_1",$order_data_1);
        $this->assign("order_data_2",$order_data_2);
        $this->assign("order_data_3",$order_data_3);
        $this->assign("order_data_0",$order_data_0);
        $this->assign("openid",$_SESSION['openid']);
        $this->assign("tal",$tal);
    	$this->display();
    }
    //退款
    public function ajax_apply_refund(){
        $order_no=$_REQUEST['order_no'];
        if (empty($order_no)) {
            echo json_encode(array('result'=>'error','msg'=>'请填写订单号'));
            exit();
        }
        $data=self::apply_refund(array('order_no'=>$order_no),$this->user_data['user_id'],$this->user_data['token']);
        if ($data) {
            echo json_encode(array('result'=>'ok','msg'=>'操作成功'));
            exit();
        }else{
            echo json_encode(array('result'=>'error','msg'=>'订单已取消，刷新页面后重新下单'));
            exit();
        }
    }

    //新退款
    public function ajax_order_refund(){
        $order_id=$_REQUEST['order_id'];
        if (empty($order_id)) {
            echo json_encode(array('result'=>'error','msg'=>'请填写订单号'));
            exit();
        }
        $data=self::order_refund(array('order_id'=>$order_id),$this->user_data['user_id'],$this->user_data['token']);
        if ($data) {
            echo json_encode(array('result'=>'ok','msg'=>'操作成功'));
            exit();
        }else{
            echo json_encode(array('result'=>'error','msg'=>'订单已取消，刷新页面后重新下单'));
            exit();
        }
    }

    //查询订单产品列表
    public function get_order_goods(){
        $order_no=$_REQUEST['order_no'];
        if (empty($order_no)) {
            echo json_encode(array('result'=>'error','msg'=>'订单不存在'));
            exit();
        }
        $order_detail=self::new_order_detail($order_no,$this->user_data['user_id'],$this->user_data['token']);
        if ($order_detail) {
            $goods_list=array();
            foreach ($order_detail['goods_list'] as $key => $one) {
                $goods_list[]=$one;
            }
            foreach ($order_detail['other_gift'] as $key => $one) {
                $goods_list[]=$one;
            }
            foreach ($order_detail['other_list'] as $key => $one) {
                $goods_list[]=$one;
            }
            
            echo json_encode(array('result'=>'ok','msg'=>$goods_list));
            exit();
        }
    }

    //重新支付
    public function order_repay(){
        $this->checkxy();
        $this->checklogin();
        $order_no=$_REQUEST['order_no'];
        $pay_type=$_REQUEST['pay_type'];
        $data=array('order_no'=>$order_no);
        $order_repay_arr=self::get_order_repay($data,$this->user_data['user_id'],$this->user_data['token']);
        if (!$order_repay_arr) {
            echo json_encode(array('result'=>'error','msg'=>'订单已取消，刷新页面后重新下单'));
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


    //再来一单
    public function order_again(){
        $this->checkxy();
        $this->checklogin();
        $shop_id=$_REQUEST['shop_id'];
        $order_no=$_REQUEST['order_no'];
        $data=array('shop_id'=>$shop_id,'order_no'=>$order_no);
        $order_again_data=self::git_order_again($data,$this->user_data['user_id'],$this->user_data['token']);
        if ($order_again_data['msg'] == 'ok') {
            echo json_encode(array('result'=>'ok','msg'=>$shop_id));
            exit();
        }else{
            echo json_encode(array('result'=>'error','msg'=>'产品已卖光'));
            exit();
        }
        //Header("Location: /Cart/index/shop_id/".$shop_id);
    }

    public function state(){
        $this->checkxy();
        $this->checklogin();
        $order_no=$_REQUEST['order_no'];
        $order_log=self::order_status_log($order_no,$this->user_data['user_id'],$this->user_data['token']);
        $order_detail=self::new_order_detail($order_no,$this->user_data['user_id'],$this->user_data['token']);
        $gift_goods_count=array('size'=>0,'gift_size'=>0);


        foreach ($order_detail['goods_list'] as $key => $one) {
                if ($one['goods_type'] != 2) {
                    $gift_goods_count['size']=$gift_goods_count['size']+$one['count'];
                }else{
                    $gift_goods_count['gift_size']=$gift_goods_count['gift_size']+$one['count'];
                }
        }

        foreach ($order_detail['other_list'] as $key => $one) {
                if ($one['goods_type'] != 2) {
                    $gift_goods_count['size']=$gift_goods_count['size']+$one['count'];
                }else{
                    $gift_goods_count['gift_size']=$gift_goods_count['gift_size']+$one['count'];
                }
        }
        foreach ($order_detail['other_gift'] as $key => $one) {

                    $gift_goods_count['gift_size']=$gift_goods_count['gift_size']+$one['count'];
        }
        //取消订单理由
        $cancel_text=self::order_cancel_text('',$this->user_data['user_id'],$this->user_data['token']);
        $order_detail['book_time']=date_Transformation($order_detail['book_time']);
        $order_detail['goods_count']=$order_detail['total_quantity'];
        $this->assign("goods_list",$order_detail['goods_list']);//买一赠一
        $this->assign("other_list",$order_detail['other_list']);//不参加活动商品
        $this->assign("other_gift",$order_detail['other_gift']);//满赠活动
        $this->assign("gift_goods_count",$gift_goods_count);
        $this->assign("order_log",$order_log);
        $this->assign("order_detail",$order_detail);
        $this->assign("user_id",$this->user_data['user_id']);
        $this->assign("mobile",$this->user_data['mobile']);
        $this->assign("cancel_text",$cancel_text);
        $this->assign("openid",$_SESSION['openid']);
    	$this->display();
    }

    public function details(){
    	$this->display();
    }
    //ajax请求，返回有哪些优惠券可以使用
    public function ajax_ticket_check(){
        $ticket_list_ids=$_REQUEST['ticket_list_ids'];
        $cart_ids=$_REQUEST['cart_ids'];
        $shop_id=$_REQUEST['shop_id'];
        $is_book_goods=$_REQUEST['is_book_goods'];
        $where_data=array();
        $where_data['ticket_list_ids']=$ticket_list_ids;
        $where_data['cart_ids']=$cart_ids;
        $where_data['shop_id']=$shop_id;
        $where_data['is_book_goods']=$is_book_goods;
        $ticket_list_check_data=self::get_ticket_list_check($where_data,$this->user_data['user_id'],$this->user_data['token']);
        //组装提示语
        $ticket_str='';
        $ticket_str_buttom='';
        $used_ticket_count=$ticket_list_check_data['data']['used_ticket_count'];//已使用优惠券数量 
        $can_use_ticket_count=$ticket_list_check_data['data']['can_use_ticket_count'];//可使用优惠券数量

        if ($used_ticket_count == '0' && $can_use_ticket_count=='0') {
            $ticket_str='暂无优惠券可以使用';
        }
        if ($used_ticket_count > 0) {
            $ticket_str='您已经使用'.$used_ticket_count.'张优惠券';
            if ($can_use_ticket_count) {
                    $ticket_str_buttom='还有'.$can_use_ticket_count.'张优惠券可以同时使用';
                }else{
                    //$ticket_str_buttom='(已无其他优惠券可以同时使用)';
                }
        }else{
            if ($can_use_ticket_count > 0) {

                $ticket_str='您还有'.$can_use_ticket_count.'张优惠券暂未使用';
            }
        }
        echo json_encode(array('code'=>'200','data'=>array('ticket_str'=>$ticket_str,'ticket_str_buttom'=>$ticket_str_buttom,'can_use_ticket'=>$ticket_list_check_data['data']['can_use_ticket'])));
        exit();

    }
    public function confirm(){
        $this->checkxy();
        $this->checklogin();
        $data=array();
        $data['address_id']=$_REQUEST['address_id'] ? $_REQUEST['address_id'] : 0;
        $data['shop_id']=$_REQUEST['shop_id'];
        $data['cart_ids']=$_REQUEST['cart_ids'];
        $data['ticket_list_ids']=$_REQUEST['ticket_list_ids'];
        $data['act_ticket']=$_REQUEST['act_ticket'];
        $data['deliver_type']=$_REQUEST['deliver_type'];//0送货上门 1到店自提
        $data['goods_ticket']=$_REQUEST['goods_ticket'];
        $data['is_book_goods']=$_REQUEST['is_book_goods'];
        $data['deliver_distance']=$_REQUEST['deliver_distance'];
        $result_data=self::order_confirm($data,$this->user_data['user_id'],$this->user_data['token']);
        $json_data=$result_data['data'];
        if ($result_data['result'] != 'ok') {
            echo $result_data['data'];
            exit();
        }

        $goods_count=0;
        foreach ($json_data['goods_list'] as $key => $one) {
            $goods_count+=$one['count'];
        }
        foreach ($json_data['gift_goods'] as $key => $one) {
            $goods_count+=$one['count'];
        }

        //获取组装提示语，以及可使用的优惠券
        $where_data=array();
        $where_data['ticket_list_ids']=$_REQUEST['ticket_list_ids'];
        $where_data['cart_ids']=$_REQUEST['cart_ids'];
        $where_data['shop_id']=$_REQUEST['shop_id'];
        $where_data['is_book_goods']=$_REQUEST['is_book_goods'];
        $ticket_list_check_data=self::get_ticket_list_check($where_data,$this->user_data['user_id'],$this->user_data['token']);
        //组装提示语
        $ticket_str='';
        $ticket_str_buttom='';
        $used_ticket_count=$ticket_list_check_data['data']['used_ticket_count'];//已使用优惠券数量 
        $can_use_ticket_count=$ticket_list_check_data['data']['can_use_ticket_count'];//可使用优惠券数量

        if ($used_ticket_count == '0' && $can_use_ticket_count=='0') {
            $ticket_str='暂无优惠券可以使用';
        }
        if ($used_ticket_count > 0) {
            $ticket_str='您已经使用'.$used_ticket_count.'张优惠券';
            if ($can_use_ticket_count) {
                    $ticket_str_buttom='还有'.$can_use_ticket_count.'张优惠券可以同时使用';
                }else{
                    //$ticket_str_buttom='(已无其他优惠券可以同时使用)';
                }
        }else{
            if ($can_use_ticket_count > 0) {

                $ticket_str='您还有'.$can_use_ticket_count.'张优惠券暂未使用';
            }
        }
        

                //勾选默认使用的
        foreach ($json_data['ticket_list'] as $key => $one) {
            if ($one['ticket_type'] == '1') {
                $one['state']=0;
                $ticket_list_ids_arr=explode(',',$_REQUEST['ticket_list_ids']);
                foreach ($ticket_list_ids_arr as $k => $v) {
                    if ($one['ticket_id'] == $v) {
                        $one['is_check']=1;
                    }
                }
                foreach ($ticket_list_check_data['data']['can_use_ticket'] as $can_k => $can_v) {
                        if ($one['ticket_id'] == $can_v) {
                            $one['state']=1;
                        }
                    }
                $ticket_data['daijin'][]=$one;
            }elseif ($one['ticket_type'] == '2') { 
                if ($one['ticket_id'] == $_REQUEST['act_ticket']) {
                    $one['is_check']=1;
                }
                $ticket_data['duihuan'][]=$one;
            }elseif ($one['ticket_type'] == '3') {
                if ($one['ticket_id'] == $_REQUEST['goods_ticket']) {
                    $one['is_check']=1;
                }
                $ticket_data['shiwu'][]=$one;
            }
            
        }


        //今日时间选项和多选时间
        $today=date('Y-m-d',time());
        $h=date('H',time());
        $today_time=$json_data['book_hour'];
        $time_arr=array();
        foreach ($today_time as $key => $one) {
            $h_data=explode('-',$one);
            if ($h <= $h_data[0]) {
                $time_arr[]=$one;
            }
        }
        array_splice($json_data['book_day'],0,1);
        //获取商户详细信息
        $shop_data=A('Category')->shop_get_info($_REQUEST['shop_id']);
        //时间选项
        $_time=0;
        if (strpos($_REQUEST['time_ymd'],'年')) {
            $_time=$_REQUEST['time_ymd'];
            $_time=str_replace('年','-',$_time);
            $_time=str_replace('月','-',$_time);
            $_time=str_replace('日','',$_time);

            //转化今天明天
            $ymd=date('Y年m月d日',strtotime("+1 day"));
            $jin_ymd=date('Y年m月d日',time());
            $time_arr=explode(' ', $_REQUEST['time_ymd']);
            if ($time_arr[0] == $jin_ymd) {
                $time_arr[0]=$time_arr[0].'(今天)';
            }
            if ($time_arr[0] == $ymd) {
               $time_arr[0]=$time_arr[0].'(明天)';
            }
            $_REQUEST['time_ymd']=$time_arr[0].' '.$time_arr[1];
        }

        //换算成配送公里
        $gongli=round($_REQUEST['deliver_distance']/1000,2);

        $this->assign("ticket_data",$ticket_data);
        $this->assign("data",$json_data);
        $this->assign("goods_count",$goods_count);
        $this->assign("cart_ids",$_REQUEST['cart_ids']);
        $this->assign("shop_id",$_REQUEST['shop_id']);
        $this->assign("act_ticket",$_REQUEST['act_ticket']);
        $this->assign("deliver_type",$_REQUEST['deliver_type']);
        $this->assign("time_ymd",$_REQUEST['time_ymd']);
        $this->assign("request_data",$_REQUEST);
        $this->assign("ticket_str",$ticket_str);
        $this->assign("ticket_str_buttom",$ticket_str_buttom);
        $this->assign("time_arr",$time_arr);
        $this->assign("shop_data",$shop_data);
        $this->assign("openid",$_SESSION['openid']);
        $this->assign("ticket_count",$ticket_count);
        $this->assign("deliver_distance",$_REQUEST['deliver_distance']);
        $this->assign("gongli",$gongli);
        $this->assign("_time",$_time);
    	$this->display();
    }



    //选择优惠券时，重新获取数据列表，优惠券金额减掉
    public function get_confirm_goods_list(){
        $data=array();
        $data['address_id']=$_REQUEST['address_id'] ? $_REQUEST['address_id'] : 0;
        $data['shop_id']=$_REQUEST['shop_id'];
        $data['cart_ids']=$_REQUEST['cart_ids'];
        $data['deliver_type']=$_REQUEST['deliver_type'];//0送货上门 1到店自提
        $data['ticket_list_ids']=$_REQUEST['ticket_list_ids'];
        $data['act_ticket']=$_REQUEST['act_ticket'];
        $data['goods_ticket']=$_REQUEST['goods_ticket'];
        $data['is_book_goods']=$_REQUEST['is_book_goods'];
        $result_data=self::order_confirm($data,$this->user_data['user_id'],$this->user_data['token']);
        if ($result_data['result'] != 'ok') {
            echo json_encode(array('code'=>'0','data'=>$result_data['data']));
            exit();
        }
        $json_data=$result_data['data'];
        //获取组装提示语，以及可使用的优惠券
        $where_data=array();
        $where_data['ticket_list_ids']=$_REQUEST['ticket_list_ids'];
        $where_data['cart_ids']=$_REQUEST['cart_ids'];
        $where_data['shop_id']=$_REQUEST['shop_id'];
        $where_data['is_book_goods']=$_REQUEST['is_book_goods'];
        $ticket_list_check_data=self::get_ticket_list_check($where_data,$this->user_data['user_id'],$this->user_data['token']);
        //组装提示语
        $ticket_str='';
        $ticket_str_buttom='';
        $used_ticket_count=$ticket_list_check_data['data']['used_ticket_count'];//已使用优惠券数量 
        $can_use_ticket_count=$ticket_list_check_data['data']['can_use_ticket_count'];//可使用优惠券数量

        if ($used_ticket_count == '0' && $can_use_ticket_count=='0') {
            $ticket_str='暂无优惠券可以使用';
        }
        if ($used_ticket_count > 0) {
            $ticket_str='您已经使用'.$used_ticket_count.'张优惠券';
            if ($can_use_ticket_count) {
                    $ticket_str_buttom='还有'.$can_use_ticket_count.'张优惠券可以同时使用';
                }else{
                    //$ticket_str_buttom='(已无其他优惠券可以同时使用)';
                }
        }else{
            if ($can_use_ticket_count > 0) {

                $ticket_str='您还有'.$can_use_ticket_count.'张优惠券暂未使用';
            }
        }
        

                //勾选默认使用的
        foreach ($json_data['ticket_list'] as $key => $one) {
            if ($one['ticket_type'] == '1') {
                $one['state']=0;
                $ticket_list_ids_arr=explode(',',$_REQUEST['ticket_list_ids']);
                foreach ($ticket_list_ids_arr as $k => $v) {
                    if ($one['ticket_id'] == $v) {
                        $one['is_check']=1;
                    }
                }
                foreach ($ticket_list_check_data['data']['can_use_ticket'] as $can_k => $can_v) {
                        if ($one['ticket_id'] == $can_v) {
                            $one['state']=1;
                        }
                    }
                $ticket_data['daijin'][]=$one;
            }elseif ($one['ticket_type'] == '2') { 
                if ($one['ticket_id'] == $_REQUEST['act_ticket']) {
                    $one['is_check']=1;
                }
                $ticket_data['duihuan'][]=$one;
            }elseif ($one['ticket_type'] == '3') {
                if ($one['ticket_id'] == $_REQUEST['goods_ticket']) {
                    $one['is_check']=1;
                }
                $ticket_data['shiwu'][]=$one;
            }
            
        }


        $json_data['ticket_str']=$ticket_str;
        $json_data['ticket_str_buttom']=$ticket_str_buttom;
        //获取优惠券金额
        echo json_encode(array('code'=>'200','data'=>$json_data));
    }




    //获取订单数量单独接口
    public function ajax_goods_count(){
        $data=array();
        $data['address_id']=$_REQUEST['address_id'] ? $_REQUEST['address_id'] : 0;
        $data['shop_id']=$_REQUEST['shop_id'];
        $data['cart_ids']=$_REQUEST['cart_ids'];
        $data['act_ticket']=$_REQUEST['act_ticket'];
        $data['deliver_type']=$_REQUEST['deliver_type'];//0送货上门 1到店自提
        $data['goods_ticket']=$_REQUEST['goods_ticket'];
        $data['ticket_id']=$_REQUEST['ticket_id'];

        $json_data=self::order_confirm($data,$this->user_data['user_id'],$this->user_data['token']);
        $goods_count=0;
        foreach ($json_data['goods_list'] as $key => $one) {
            $goods_count+=$one['count'];
        }
        foreach ($json_data['gift_goods'] as $key => $one) {
            $goods_count+=$one['count'];
        }
        //优惠券显示数量计算
        $ticket_count=0;
        $ticket_str='';
        $ticket_str_buttom='';
        $ticket_data=array();
        $ticket_type_count=array('daijin'=>0,'meituan_daijin'=>0,'duihuan'=>0,'shiwu'=>0,'is_meituan'=>0);
        foreach ($json_data['ticket_list'] as $key => $one) {
            $ticket_count++;
            if ($one['ticket_type'] == '1') {
                $ticket_data['daijin'][]=$one;
                if ($one['ticket_id'] == $_REQUEST['ticket_id']) {
                    if ($one['dump_gift'] == '1') {
                        //说明选中了一张美团券
                        $ticket_type_count['is_meituan']='1';
                        $ticket_str='您已使用'.$one['act_name'];
                        //$ticket_str_buttom='(已无其他优惠券可以同时使用)';
                    }
                }
                if ($one['dump_gift'] == '1') {
                    $ticket_type_count['meituan_daijin']=$ticket_type_count['meituan_daijin']+1;
                }else{
                    $ticket_type_count['daijin']=$ticket_type_count['daijin']+1;
                }
            }elseif ($one['ticket_type'] == '2') {
                $ticket_type_count['duihuan']=$ticket_type_count['duihuan']+1;
            }elseif ($one['ticket_type'] == '3') {
                $ticket_type_count['shiwu']=$ticket_type_count['shiwu']+1;
            }
        }
        if ($ticket_count) {
            $ticket_already=0;//已经使用
            $ticket_no=0;//暂未使用
            if ($ticket_type_count['is_meituan'] == '0') {
                
            
            if (!empty($_REQUEST['act_ticket'])) {
                if ($ticket_type_count['duihuan'] > 0) {
                    $ticket_already=$ticket_already+1;
                }
            }else{
                if ($ticket_type_count['duihuan'] > 0) {
                    $ticket_no=$ticket_no+1;
                }
            }


            if (!empty($_REQUEST['goods_ticket'])) {
                if ($ticket_type_count['shiwu'] > 0) {
                    $ticket_already=$ticket_already+1;
                }
            }else{
                if ($ticket_type_count['shiwu'] > 0) {
                    $ticket_no=$ticket_no+1;
                }
            }

            if (!empty($_REQUEST['ticket_id'])) {
                if ($ticket_type_count['daijin'] > 0) {
                    $ticket_already=$ticket_already+1;
                }
            }else{
                if ($ticket_type_count['daijin'] > 0) {
                    $ticket_no=$ticket_no+1;
                }
            }

            if ($ticket_already) {
                $ticket_str='您已经使用'.$ticket_already.'张优惠券';
                if ($ticket_no) {
                    $ticket_str_buttom='(还有'.$ticket_no.'张优惠券可以同时使用)';
                }else{
                    //$ticket_str_buttom='(已无其他优惠券可以同时使用)';
                }
            }else{
                $ticket_str='您还有'.$ticket_count.'张优惠券暂未使用';
            }
        }
        }else{
            $ticket_str='暂无优惠券可以使用';
        }
        //计算结束
        echo json_encode(array('result'=>'ok','data'=>array('goods_count'=>$goods_count,'ticket_str'=>$ticket_str,'ticket_str_buttom'=>$ticket_str_buttom)));
    }





    //我的订单
    public function MeOrder(){
        $order_id=$_REQUEST['order_id'];
        $goods_visible='1';
        $page_num='5';
        $order_status=$_REQUEST['order_status'];
        $order_data=self::order_get_list($order_id,$goods_visible,$page_num,$order_status,$this->user_data['user_id'],$this->user_data['token']);
        echo json_encode($order_data);
    }
    public function succeed(){
        $out_trade_no=$_REQUEST['order_no'];
        $pay_type=$_REQUEST['pay_type'];
        if ($pay_type=='40') {
            $order_detail=self::new_order_detail($out_trade_no,$this->user_data['user_id'],$this->user_data['token']);
        }elseif($pay_type=='10'){
            $order_detail=self::new_order_detail($out_trade_no,$this->user_data['user_id'],$this->user_data['token']);
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
                    $order_detail=self::new_order_detail($out_trade_no,$this->user_data['user_id'],$this->user_data['token']);
                }else {
                    //交易未成功
                  echo "trade_status=".$_GET['trade_status'];
                }

            }else{
                echo "验证失败";
            }
        }
        

        $shop_near_list=A('Index')->shop_near_list($_SESSION["user_x"],$_SESSION["user_y"]);
        $shop_data=A('Category')->shop_get_info($order_detail['shop_id'],$this->user_data['user_id'],$this->user_data['token']);
        $this->assign("shop_near_list",$shop_near_list);
        $this->assign("order_detail",$order_detail);
        $this->assign("shop_data",$shop_data);
    	$this->display();
    }

    //用户历史订单查询
    public function order_get_list($order_id,$goods_visible='0',$page_num='1',$order_status,$uid,$token){
        $url=API_URL.'/rest_2/order/get_list';
        $post_data = array();
        $post_data['order_id']=$order_id;
        $post_data['goods_visible']=$goods_visible;
        $post_data['page_num']=$page_num;
        $post_data['order_status']=$order_status;
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
//取消订单
    public function cancel(){
        $order_no=$_REQUEST['order_no'];
        $rester=self::order_cancel($order_no,$this->user_data['user_id'],$this->user_data['token']);
        if (!empty($rester)) {
            echo json_encode(array('result'=>'ok','msg'=>"取消成功"));
        }else{
            echo json_encode(array('result'=>'error','msg'=>"取消失败"));
        }

    }

    //新取消订单
    public function cancel_new(){
        $order_no=$_REQUEST['order_no'];
        $reason=$_REQUEST['reason'];
        $rester=self::order_cancel_new($order_no,$reason,$this->user_data['user_id'],$this->user_data['token']);
        echo json_encode(array('result'=>'ok','msg'=>$rester));
    }

    //输出支付宝html
    public function echo_html(){
        $this->display();
    }


    //生产新订单
    public function add(){
        $this->checkxy();
        $this->checklogin();
        $data=array();
        $data['address_id']=$_REQUEST['address_id'];
        $data['shop_id']=$_REQUEST['shop_id'];
        $data['cart_ids']=$_REQUEST['cart_ids'];
        $data['deliver_type']=$_REQUEST['deliver_type'];
        $data['ticket_list_ids']=$_REQUEST['ticket_id'];
        $data['act_ticket']=$_REQUEST['act_ticket'];
        $data['goods_ticket']=$_REQUEST['goods_ticket'];
        $data['pay_type']=$_REQUEST['pay_type'];
        $data['book_time']=$_REQUEST['book_time'];
        $data['message']=$_REQUEST['message'];
        $data['user_name']=$_REQUEST['user_name'];
        $data['telphone']=$_REQUEST['telphone'];
        $data['is_book_goods']=$_REQUEST['is_book_goods'];
        $data['deliver_distance']=$_REQUEST['deliver_distance'];
        $data['stockout_type']=$_REQUEST['stockout_type'];
        $rester_arr=self::order_add($data,$this->user_data['user_id'],$this->user_data['token']);
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

    //微信支付根据订单id调取订单详细信息
    public function weixin_order_date(){
        $order_no=$_REQUEST['order_no'];
        if (!empty($order_no)) {
           $order_detail=self::new_order_detail($order_no,$this->user_data['user_id'],$this->user_data['token']);
            echo self::pay_weixin($order_detail);
            exit();
        }
        
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
                "notify_url"=>$alipay_config['notify_url'],
                "return_url"=>$alipay_config['return_url'],
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

    public function pay_weixin($order_data=''){
        //*******************微信支付***********************
        //初始化日志
        $logHandler= new \CLogFileHandler("../logs/".date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);
        //①、获取用户openid
        $tools = new \JsApiPay();
        //$openId = $tools->GetOpenid();
        if (empty($_SESSION['openid'])) {
            return false;
        }else{
            $openId=$_SESSION['openid'];
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
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = \WxPayApi::unifiedOrder($input);
        
        $jsApiParameters = $tools->GetJsApiParameters($order);
        return $jsApiParameters;
        //********************微信支付结束*********************
    }

    //删除订单
    public function delete(){
        $order_no=$_REQUEST['order_no'];
        $rester=self::order_del($order_no,$this->user_data['user_id'],$this->user_data['token']);
        if (!empty($rester)) {
            echo json_encode(array('result'=>'ok','msg'=>"删除成功"));
        }else{
            echo json_encode(array('result'=>'error','msg'=>"删除失败"));
        }
    }

    //确认订单
    public function complete(){
        $order_no=$_REQUEST['order_no'];
        $rester=self::order_complete($order_no,$this->user_data['user_id'],$this->user_data['token']);
        echo json_encode(array('result'=>'ok','msg'=>"确认订单成功"));
        /*
        if ($rester) {
            echo json_encode(array('result'=>'ok','msg'=>"删除成功"));
        }else{
            echo json_encode(array('result'=>'error','msg'=>"删除失败"));
        }
        */
    }
    //去评价
    public function evaluate(){
        $this->checkxy();
        $this->checklogin();
        $order_no=$_REQUEST['order_no'];
        if (IS_POST) {
            $order_no=$_POST['order_no'];
            $data_score=$_POST['data_score'];
            $s=$_POST['s'];
            $data=array();
            $data['order_no']=$order_no;
            $data['score']=$data_score;
            $data['tag']=$s;
            $data['content']='非常好';
            $rester=self::score_add($data,$this->user_data['user_id'],$this->user_data['token']);
            if ($rester) {
                die(json_encode(array('result'=>'ok','msg'=>"评价成功")));
            }else{
                die(json_encode(array('result'=>'error','msg'=>"评价失败")));
            }
            
        }
        $data=self::score_get_option($order_no,$this->user_data['user_id'],$this->user_data['token']);
        $this->assign("data",$data);
        $this->display();
    }
    //获取评论选项
    public function score_get_option($order_no='0',$uid,$token){
        $url=API_URL.'/rest_2/score/get_option';
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

    //获取订单状态
    public function order_status_log($order_no='0',$uid,$token){
        $url=API_URL.'/rest_2/order/status_log';
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

    //获取订单订单详情
    public function order_detail($order_no='0',$uid,$token){
        $url=API_URL.'/rest_2/order/detail';
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

    //获取新的订单详情
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


    //取消订单
    public function order_cancel($order_no='0',$uid,$token){
        $url=API_URL.'/rest_2/order/cancel';
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
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //新接口取消订单
    public function order_cancel_new($order_no='0',$reason,$uid,$token){
        $url=API_URL.'/rest_2/order/cancel_new';
        $post_data = array();
        $post_data['order_no']=$order_no;
        $post_data['reason']=$reason;
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url,$uid,$token);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return $arr['data']['msg'];
            }else{
                return $arr['data']['msg'];
            }
        }else{
            return $arr['data']['msg'];
        }
    }

    //删除订单
    public function order_del($order_no='0',$uid,$token){
        $url=API_URL.'/rest_2/order/del';
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
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    //用户确认收货 
    public function order_complete($order_no='0',$uid,$token){
        $url=API_URL.'/rest_2/order/complete';
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
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

//用户确认收货 
    public function score_add($data,$uid,$token){
        $url=API_URL.'/rest_2/score/add';
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

    //订单确认
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

    //验证优惠券是否能用，（未使用优惠券时）并且获取还有几张优惠券可用，获取不能用优惠券ID
    public function get_ticket_list_check($data,$uid,$token){
        $url=API_URL.'/rest_2/order/ticket_list_check';
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

    //取消订单txt
    public function order_cancel_text($data,$uid,$token){
        $url=API_URL.'/rest_2/order/order_cancel_text';
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
                return $arr['data'];
            }
        }
    }


    //再来一单
    public function git_order_again($data,$uid,$token){
        $url=API_URL.'/rest_2/order/order_again';
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
                return $arr['data'];
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

    public function get_order_type_count($data,$uid,$token){
        $url=API_URL.'/rest_2/order/get_order_type_count';
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
                return $arr['data'];
            }
        }
    }

    //退款
    public function apply_refund($data,$uid,$token){
        $url=API_URL.'/rest_2/order/apply_refund';
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


    public function order_refund($data,$uid,$token){
        $url=API_URL.'/rest_2/order/order_refund';
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