<?php
namespace Home\Controller;
use Think\Controller;
//引进微信插件
require_once(VENDOR_PATH ."/WxpayAPI_php_v3/lib/WxPay.Api.php");
require_once(VENDOR_PATH .'/WxpayAPI_php_v3/lib/WxPay.Notify.php');
require_once(VENDOR_PATH .'/WxpayAPI_php_v3/lib/PayNotifyCallBack.php');
require_once(VENDOR_PATH .'/WxpayAPI_php_v3/example/log.php');
require_once(VENDOR_PATH .'/WxpayAPI_php_v3/example/WxPay.JsApiPay.php');
//二维码插件
require_once(VENDOR_PATH."/phpqrcode/lib/full/qrlib.php");
//商户返款
class ShopBackController extends Controller {
	//商家绑定微信ID首页
	public function wx_shop_binding_index(){
		$tools = new \JsApiPay();
        $openId = $tools->GetOpenid();
		//$openId='o25KXjiETFnnk88L-nO9c4R429Pk';
        if (empty($openId)) {
        	echo "请使用微信客户端打开!";
        }else{
        	$_SESSION['openId']=$openId;
        }
        $this->display();
	}

	//生成商户绑定页面的URL
	public function get_shop_url_img(){
		$openId=$_SESSION['openId'];
		$shop_code=$_POST['shop_code'];
		if (empty($openId)) {
			echo json_encode(array('result'=>'error','msg'=>'请重新使用微信客户端打开'));
            exit();
		}
		if (empty($shop_code)) {
			echo json_encode(array('result'=>'error','msg'=>'请输入商户ID'));
            exit();
		}else{
			if (!is_numeric($shop_code)) {
				echo json_encode(array('result'=>'error','msg'=>'商户ID错误'));
            	exit();
			}
		}
		
		//查询商户编号是否存在
		$Shop = D('Home/Shop');
		$shop_data=$Shop->getShopInfo(array('shop_code'=>$shop_code));
		if (empty($shop_data)) {
			echo json_encode(array('result'=>'error','msg'=>'商户ID错误'));
            exit();
		}else{
			echo json_encode(array('result'=>'ok','msg'=>''));
        	exit();
		}
	}

	public function get_img(){
		$shop_code=$_REQUEST['shop_code'];
		//查询商户编号是否存在
		$Shop = D('Home/Shop');
		$shop_data=$Shop->getShopInfo(array('shop_code'=>$shop_code));
		if (empty($shop_data)) {
			echo '商户ID错误';
            exit();
		}else{
			$url='http://weixin.hahajing.com/home/ShopBack/shop_binding/shop_id/'.$shop_data['shop_id'];
			$encode_url=urlEncode($url);
			$balk_url="https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx78a74ae276f5adb5&redirect_uri=".$encode_url."&response_type=code&scope=snsapi_userinfo&state=abc#wechat_redirect";

			$errorCorrectionLevel = 'L';
		    $matrixPointSize = 4;
		    $textData = $balk_url;
		    $QRcode=new \QRcode();
		   // echo $QRcode::png($textData, $pngFilename, $errorCorrectionLevel, $matrixPointSize, 2);
		   	ob_clean();//这个一定要加上，清除缓冲区  
		    $img=$QRcode::png($textData, false, $errorCorrectionLevel, $matrixPointSize, 2);
		}
		
	}

	//商户ID绑定微信
	public function shop_binding(){
		$code=$_REQUEST['code'];
    	$state=$_REQUEST['state'];
        $openId=$_SESSION['openId'];
    	if (!empty($code) || !empty($openId)) {
	    		//获取用户获取用户access_token
		    	$url_access_token="https://api.weixin.qq.com/sns/oauth2/access_token?appid=wx78a74ae276f5adb5&secret=c747e99c6d0688dec43b8c522e3a0c1b&code=".$code."&grant_type=authorization_code";
		    	$access_token_arr=self::get_url_access_token($url_access_token);
		    	if (empty($access_token_arr['openid'])) {
					echo '请重新使用微信客户端打开';
		            exit();
				}
		    	$access_token=$access_token_arr['access_token'];
		    	$expires_in=$access_token_arr['expires_in'];//access_token接口调用凭证超时时间，单位（秒）
		    	$refresh_token=$access_token_arr['refresh_token'];//用户刷新access_token
		    	$openId=$access_token_arr['openid'];//用户唯一标识
		    	$scope=$access_token_arr['scope'];//用户授权的作用域，使用逗号（,）分隔
		    	$_SESSION['openId']=$openId;
		    	$_SESSION['access_token']=$access_token;
		    	$_SESSION['refresh_token']=$refresh_token;
		    	//拉取用户基本信息
		    	$user_info_url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openId."&lang=zh_CN";
		    	$user_data=self::get_url_access_token($user_info_url);
		    	$_SESSION['nickname']=$user_data['nickname'];
    	}
		// $tools = new \JsApiPay();
  //       $openId = $tools->GetOpenid();
		//$openId='o25KXjiETFnnk88L-nO9c4R429Pk';
        if (empty($openId)) {
			echo '请重新使用微信客户端打开';
            exit();
		}
		$_SESSION['openId']=$openId;
		$shop_id=$_REQUEST['shop_id'];
		if (empty($shop_id)) {
			echo '请输入商户ID';
            exit();
		}else{
			if (!is_numeric($shop_id)) {
				echo '请输入商户ID';
            	exit();
			}
		}
		$Shop = D('Home/Shop');
		$shop_data=$Shop->getShopInfo(array('shop_id'=>$shop_id));
		if (empty($shop_data)) {
			//$_SESSION['user_end_time']=time();
			echo '商户ID错误';
            exit();
		}else{
			$_SESSION['shop_id']='';
			$_SESSION['shop_id']=$shop_id;
			$shop_contact=$shop_data['shop_contact'];
			if (strlen($shop_data['shop_contact']) != 11) {
				$shop_data['msg'] ='请联系哈哈镜客服，把手机号填写完全';
			}else{
				$shop_data['msg'] ='验证码将发送到：'.substr_replace($shop_data['shop_contact'],'****',3,6);
			}
			$this->assign("shop_data",$shop_data);
			$this->display();
		}
	}

	public function get_url_access_token($url){
        $json_data=Posts('',$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            return $arr;
        }else{
            return false;
        }
    }


	//发送验证码
	public function set_shop_auth_code(){
		$shop_id=$_SESSION['shop_id'];
		if (empty($shop_id)) {
			echo json_encode(array('result'=>'error','msg'=>'商户ID错误'));
            exit();
		}
		$Shop = D('Home/Shop');
		//添加图片验证码
        $verrify = $_REQUEST["verify"];
        if (empty($verrify)) {
            echo json_encode(array('result'=>'error','msg'=>'验证码不能为空'));
            exit();
        }
        if(!sp_check_verify_code()){
            echo json_encode(array('result'=>'error','msg'=>'图片验证码错误'));
            exit();
        }
		$shop_data=$Shop->getShopInfo(array('shop_id'=>$shop_id));
		if (empty($shop_data)) {
			echo json_encode(array('result'=>'error','msg'=>'商户ID错误'));
            exit();
		}else{
			if (empty($shop_data['shop_contact'])) {
				echo json_encode(array('result'=>'error','msg'=>'请联系哈哈镜客服，并把手机号填写上'));
            	exit();
			}else{
				if (strlen($shop_data['shop_contact']) != 11) {
					echo json_encode(array('result'=>'error','msg'=>'请联系哈哈镜客服，并把手机号填写上'));
            		exit();
				}
			}
			$user_IP = $_SERVER["REMOTE_ADDR"];
			$is_code=self::public_send_auth_code($shop_data['shop_contact'],'5',$user_IP);
			echo json_encode($is_code);
        	exit();
            }
	}

	//绑定商户微信唯一标示和商户标示
	public function wx_binding(){
		$openId=$_SESSION['openId'];
		$code=$_REQUEST['code'];
		$shop_id=$_SESSION['shop_id'];
		$user_name=$_REQUEST['user_name'];
		$nickname=$_SESSION['nickname'];//微信昵称

		$Shop = D('Home/Shop');
		if (empty($openId)) {
			echo '请重新使用微信客户端打开';
            exit();
		}
		if (empty($code)) {
			echo json_encode(array('result'=>'error','msg'=>'验证码不能为空'));
            exit();
		}
		if (empty($user_name)) {
			echo json_encode(array('result'=>'error','msg'=>'姓名不能为空'));
            exit();
		}
		//校验码验证
		$AuthCode = D('Home/AuthCode');
		$shop_data=$Shop->getShopInfo(array('shop_id'=>$shop_id));
		$mobile_data = $AuthCode->checkCode($shop_data['shop_contact'], $code, 5);
		if (!$mobile_data) {
			echo json_encode(array('result'=>'error','msg'=>'验证码错误'));
            exit();
		}
		//判断这个商户是否绑定过
		if ($shop_data['openid']) {
			echo json_encode(array('result'=>'error','msg'=>'失败/不可重复绑定'));
            exit();
		}
		//微信唯一ID和商户绑定
		$up_shop=array();
		$up_shop['shop_id']=$shop_id;
		$up_shop['openid']=$openId;
		$up_shop['user_name']=$user_name;
		$up_shop['binding_state']='0';
		$up_shop['nickname']=$nickname;
		$is_up=$Shop->edit($up_shop);
		if ($is_up) {
			echo json_encode(array('result'=>'ok','msg'=>'绑定成功,管理员将进行审核'));
            exit();
		}else{
			echo json_encode(array('result'=>'error','msg'=>'绑定失败'));
            exit();
		}
	}


	//商户提现
	public function shop_withdrawals_html(){
		$openId=$_SESSION['openId'];
		//$openId='o25KXjiETFnnk88L-nO9c4R429Pk';
        if (empty($openId)) {
        	$tools = new \JsApiPay();
        	$openId = $tools->GetOpenid();
        	$_SESSION['openId']=$openId;
        }else{
        	$_SESSION['openId']=$openId;
        }

        //查找商户表微信唯一标识
        $Shop = D('Home/Shop');
        $shop_data=$Shop->getShopInfo(array('openid'=>$openId));
        if (empty($shop_data)) {
        	echo "您微信公共号未被授权，请联系哈哈镜客服";
        	exit();
        }
        $model_m = M();
        //统计账户金额，等于本周一到周日的已完成单子总额+提现金额+奖励金
        //周四0点前是上周一到本周的的完成总金额
        $week = date('w');
        $jiangli=0;
        if ($week > 3) {
        	$cycle=self::get_data_ymd();
	        $zhou_mon=$cycle['mon'].' 00:00:00';//周一
	        $zhou_sun=$cycle['sun'].' 23:59:59';//周日
	        $zhou_mon_time=strtotime($zhou_mon);
	        $zhou_sun_time=strtotime($zhou_sun);
	        $sql="SELECT SUM(`fee`) AS amount FROM hhj_order_confirm_log WHERE confirm_time >= $zhou_mon_time AND confirm_time <= $zhou_sun_time and shop_id=".$shop_data['shop_id'];
	        $amount=$model_m->query($sql);
	        // $count_sql="SELECT COUNT(*) AS jianglijin FROM hhj_order_confirm_log WHERE confirm_time >= $zhou_mon_time AND confirm_time <= $zhou_sun_time and shop_id=".$shop_data['shop_id'];
	        // $jiangli=$model_m->query($count_sql);
        }else{
        	$monday=self::last_week_monday();
        	$cycle=self::get_data_ymd();
	        $zhou_mon=$monday.' 00:00:00';//周一
	        $zhou_sun=$cycle['sun'].' 23:59:59';//周日
	        $zhou_mon_time=strtotime($zhou_mon);
	        $zhou_sun_time=strtotime($zhou_sun);
	        $sql="SELECT SUM(`fee`) AS amount FROM hhj_order_confirm_log WHERE confirm_time >= $zhou_mon_time AND confirm_time <= $zhou_sun_time and shop_id=".$shop_data['shop_id'];
	        $amount=$model_m->query($sql);
	        // $count_sql="SELECT COUNT(*) AS jianglijin FROM hhj_order_confirm_log WHERE confirm_time >= $zhou_mon_time AND confirm_time <= $zhou_sun_time and shop_id=".$shop_data['shop_id'];
	        // $jiangli=$model_m->query($count_sql);
        }
        $sum_amount=round($amount[0]['amount'] + $shop_data['shop_payment'],2);

        //获取上周和本周统计
        $tongji=self::get_statistics_data($shop_data['shop_id']);
        $this->assign("shop_data",$shop_data);
        $this->assign("sum_amount",$sum_amount);
        $this->assign("tongji",$tongji);
        $this->assign("shop_id",$shop_data['shop_id']);
		$this->display();
	}

	public function get_statistics_data($shop_id){
		$model_m = M();
		$last_week=array();
		$this_week=array();
		//获取上周数据
		$monday=self::last_week_monday();
        $zhou_mon=$monday.' 00:00:00';//周一
        $zhou_sun=date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")-date("w")+7-7,date("Y")));//周日
        $zhou_mon_time=strtotime($zhou_mon);
        $zhou_sun_time=strtotime($zhou_sun);
        $sql="SELECT SUM(`fee`) AS amount FROM hhj_order_confirm_log WHERE confirm_time >= $zhou_mon_time AND confirm_time <= $zhou_sun_time and shop_id=".$shop_id;
        $amount=$model_m->query($sql);
        $count_sql="SELECT COUNT(*) AS jianglijin FROM hhj_order_confirm_log WHERE confirm_time >= $zhou_mon_time AND confirm_time <= $zhou_sun_time and shop_id=".$shop_id;
        $jiangli=$model_m->query($count_sql);
        $last_week['sum_price']=$amount[0]['amount'] ? $amount[0]['amount'] : 0;
        $last_week['sum_count']=$jiangli[0]['jianglijin'] ? $jiangli[0]['jianglijin'] : 0;
        $last_week['sum_jiangli']=0;
        if ($monday == '2017-01-09') {
        	$last_week['sum_jiangli']=$jiangli[0]['jianglijin'] ? $jiangli[0]['jianglijin'] : 0;
        }


        //获取本周数据
        $cycle=self::get_data_ymd();
        $ben_zhou_mon=$cycle['mon'].' 00:00:00';//周一
        $ben_zhou_sun=$cycle['sun'].' 23:59:59';//周日
        $ben_zhou_mon_time=strtotime($ben_zhou_mon);
        $ben_zhou_sun_time=strtotime($ben_zhou_sun);
        $ben_sql="SELECT SUM(`fee`) AS amount FROM hhj_order_confirm_log WHERE confirm_time >= $ben_zhou_mon_time AND confirm_time <= $ben_zhou_sun_time and shop_id=".$shop_id;
        $ben_amount=$model_m->query($ben_sql);
        $ben_count_sql="SELECT COUNT(*) AS jianglijin FROM hhj_order_confirm_log WHERE confirm_time >= $ben_zhou_mon_time AND confirm_time <= $ben_zhou_sun_time and shop_id=".$shop_id;
        $ben_jiangli=$model_m->query($ben_count_sql);
        $this_week['sum_price']=$ben_amount[0]['amount'] ? $ben_amount[0]['amount'] : 0;
        $this_week['sum_count']=$ben_jiangli[0]['jianglijin'] ? $ben_jiangli[0]['jianglijin'] : 0;
        $this_week['sum_jiangli']=0;
        $data=array();
        $data['last_week']=$last_week;
        $data['this_week']=$this_week;
        return $data;
	}

	public function shop_order_list(){
		$page = $_REQUEST['p']; //页码
		$shop_id=$_REQUEST['shop_id'];
		$Shop = D('Home/Shop');
		$OrderConfirmLog = D('Home/OrderConfirmLog');
		$where=array();
		$where['hhj_order_confirm_log.shop_id']=$shop_id;
		if (!$page) {
			$page=1;
		}
		$where['hhj_order_confirm_log.confirm_time'] = array('egt','1483891200');
		$order_data=$OrderConfirmLog->getLogList($where,$page,10);
		$count = $OrderConfirmLog->LogCount($where);
		$Page = new \Think\Page($count,10);// 分页
		$show = $Page->show();// 分页显示输出
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('order_data',$order_data);
		$this->display();
	}




	//获取本周周一到周日的日期
	public function get_data_ymd(){
		$week = date('w');
		$weeks['mon'] = date('Y-m-d',strtotime( '+'. 1-$week .' days' ));
		$weeks['tue'] = date('Y-m-d',strtotime( '+'. 2-$week .' days' ));
		$weeks['wed'] = date('Y-m-d',strtotime( '+'. 3-$week .' days' ));
		$weeks['thu'] = date('Y-m-d',strtotime( '+'. 4-$week .' days' ));
		$weeks['fri'] = date('Y-m-d',strtotime( '+'. 5-$week .' days' ));
		$weeks['sat'] = date('Y-m-d',strtotime( '+'. 6-$week .' days' ));
		$weeks['sun'] = date('Y-m-d',strtotime( '+'. 7-$week .' days' ));
		return $weeks;
	}
	//获取上周一日期
	public function last_week_monday(){
    	if (date('l',time()) == 'Monday') return date('Y-m-d',strtotime('last monday'));
    	return date('Y-m-d',strtotime('-1 week last monday'));
    }



	//商户提现
	public function Withdrawals(){
		$amount=$_POST['amount'];
		$Shop = D('Home/Shop');
		$ShopWithdrawalsPayLog = D('Home/ShopWithdrawalsPayLog');
		$ShopWithdrawalsLog = D('Home/ShopWithdrawalsLog');
		$openId=$_SESSION['openId'];
		//$openId='o25KXjiETFnnk88L-nO9c4R429Pk';

		//周四0点前半个小时，后半个小时禁止取款
        $time_w = date("w");
        if($time_w == 3){
        	$j=date("H:i");
			$h=strtotime($j);//获得当前小时和分钟的时间时间戳
			$z=strtotime('23:30');//获得指定分钟时间戳，00:00
			$x=strtotime('24:00');//获得指定分钟时间戳，00:29
			if($h >= $z && $h <= $x){
			 	echo json_encode(array('result'=>'error','msg'=>'周三11:30至周四00:30时间段系统维护'));
            	exit();
			}
		}
		if($time_w == 4){
			$j=date("H:i");
			$h=strtotime($j);//获得当前小时和分钟的时间时间戳
			$z=strtotime('00:00');//获得指定分钟时间戳，00:00
			$x=strtotime('00:30');//获得指定分钟时间戳，00:29
			if($h>=$z && $h<=$x){
			 	echo json_encode(array('result'=>'error','msg'=>'周三11:30至周四00:30时间段系统维护'));
            	exit();
			}
        }
		//防止重复请求
		// if ($_SESSION['lock'] == '1') {
		// 	echo json_encode(array('result'=>'error','msg'=>'数据正在处理，请不要重复请求'));
  //           exit();
		// }
		$_SESSION['lock']=0;


		if (empty($openId)) {
			self::echo_json_encode('error','失败/请重新使用微信客户端打开');
            exit();
		}

		if (empty($amount) || $amount < 0) {
			self::echo_json_encode('error','提现金额不准确');
            exit();
		}
		if (!is_numeric($amount)) {
        	self::echo_json_encode('error','提现金额不准确');
            exit();
        }


        $shop_data=$Shop->getShopInfo(array('openid'=>$openId));
		if (empty($shop_data)) {
        	self::echo_json_encode('error','您微信公共号未被授权，请联系哈哈镜客服');
            exit();
        }
        if ($shop_data['binding_state'] != '1') {
        	self::echo_json_encode('error','失败/提现账号异常，请联系哈哈镜客服');
            exit();
        }
        if ($amount > $shop_data['shop_payment']) {
        	self::echo_json_encode('error','失败/不可大于可提现金额');
            exit();
        }
        
		//$included_files = get_included_files();
		$shop_id=$shop_data['shop_id'];
		$rand=rand(100,999);
		$partner_trade_no=self::get_order_no($rand);
		//查询订单号是否存在
		$is_pay_log=$ShopWithdrawalsPayLog->getListByWhere($partner_trade_no);
		if ($is_pay_log) {
			$partner_trade_no=self::get_order_no($rand);
		}
		$re_user_name=$shop_data['user_name'];//收款用户姓名
		$amount_fen=$amount * 100;//企业付款金额，单位为分
		$desc=$shop_data['shop_code'].'商户提现';//企业付款描述信息
		//初始化日志
        $logHandler= new \CLogFileHandler("../logs/".date('Y-m-d').'.log');
        $log = \Log::Init($logHandler, 15);
        //$tools = new \JsApiPay();
        $input = new \WxPayUnifiedWithdrawals();
        $input->SetPartnerTradeNo($partner_trade_no);
        $input->SetOpenid($openId);
        $input->SetCheckName('FORCE_CHECK');
        $input->SetReUserName($re_user_name);
        $input->SetAmount($amount_fen);
        $input->SetDesc($desc);
        $input->SetSpbillCreateIp($spbill_create_ip);
        $order = \WxPayApi::unifiedShop($input);
        if ($order['return_code'] == 'SUCCESS') {
        	if ($order['result_code'] == 'FAIL') {
        		$PayLog=array();
        		$PayLog['shop_id']=$shop_id;
        		$PayLog['fee']=$amount;
        		$PayLog['openid']=$openId;
        		$PayLog['re_user_name']=$re_user_name;
        		$PayLog['result_code']=$order['result_code'];
        		$PayLog['is_update_shop']='0';
        		$PayLog['err_code_des']=$order['err_code_des'];
        		$PayLog['add_time']=time();
        		$ShopWithdrawalsPayLog->add_data($PayLog);
        		self::echo_json_encode('error',$order['err_code_des']);
            	exit();
        	}
        	if ($order['result_code'] == 'SUCCESS') {
        		//微信打款成功
        		//插入微信支付凭证
        		$PayLog=array();
        		$PayLog['partner_trade_no']=$order['partner_trade_no'];
        		$PayLog['payment_no']=$order['payment_no'];
        		$PayLog['shop_id']=$shop_id;
        		$PayLog['fee']=$amount;
        		$PayLog['openid']=$openId;
        		$PayLog['re_user_name']=$re_user_name;
        		$PayLog['payment_time']=$order['payment_time'];
        		$PayLog['result_code']=$order['result_code'];
        		$PayLog['is_update_shop']='0';
        		$PayLog['add_time']=time();
        		$log_id=$ShopWithdrawalsPayLog->add_data($PayLog);
        		//修改商户表可提现金额
        		$up_date=array();
        		$up_date['shop_id']=$shop_data['shop_id'];
        		$up_date['shop_payment']=array('exp','shop_payment-'.$amount);
        		$is_up_shop=$Shop->edit($up_date);
        		if ($is_up_shop) {
        			$ShopWithdrawalsPayLog->edit(array('id'=>$log_id),array('is_update_shop'=>'1'));
        			$back_shop_data=$Shop->getShopInfo(array('openid'=>$openId));
	        		//添加商户余额改动记录
	        		$up_shop_log_data=array();
	        		$up_shop_log_data['shop_id']=$shop_data['shop_id'];
	        		$up_shop_log_data['openid']=$openId;
	        		$up_shop_log_data['user_name']=$re_user_name;
	        		$up_shop_log_data['fee']=$amount;
	        		$up_shop_log_data['payment_front']=$shop_data['shop_payment'];
	        		$up_shop_log_data['payment_back']=$back_shop_data['shop_payment'];
	        		$up_shop_log_data['order_id']=$log_id;
	        		$up_shop_log_data['log_type']='1';
	        		$up_shop_log_data['add_time']=time();
	        		$ShopWithdrawalsLog->add_data($up_shop_log_data);
	        		self::echo_json_encode('ok','提现成功');
            		exit();
        		}else{
        			self::echo_json_encode('error','提现失败/请联系哈哈镜客服');
            		exit();
        		}
        		
        	}
        }else{
        	self::echo_json_encode('error','数据请求失败');
            exit();
        }
                //Array ( [return_code] => SUCCESS [return_msg] => 对同一用户转账操作过于频繁,请稍候重试. [result_code] => FAIL [err_code] => FREQ_LIMIT [err_code_des] => 对同一用户转账操作过于频繁,请稍候重试. )
	}

	public function echo_json_encode($result,$msg){
		$_SESSION['lock']='0';
		echo json_encode(array('result'=>$result,'msg'=>$msg));
        exit();
	}

	public function get_code() {
    	$length=4;
    	if (isset($_GET['length']) && intval($_GET['length'])){
    		$length = intval($_GET['length']);
    	}
    	
    	//设置验证码字符库
    	$code_set="1234567890";
    	// if(isset($_GET['charset'])){
    	// 	$code_set= trim($_GET['charset']);
    	// }
    	
    	$use_noise=0;
    	// if(isset($_GET['use_noise'])){
    	// 	$use_noise= intval($_GET['use_noise']);
    	// }
    	
    	$use_curve=0;
    	// if(isset($_GET['use_curve'])){
    	// 	$use_curve= intval($_GET['use_curve']);
    	// }
    	
    	$font_size=25;
    	if (isset($_GET['font_size']) && intval($_GET['font_size'])){
    		$font_size = intval($_GET['font_size']);
    	}
    	
    	$width=0;
    	if (isset($_GET['width']) && intval($_GET['width'])){
    		$width = intval($_GET['width']);
    	}
    	
    	$height=0;
    		
    	if (isset($_GET['height']) && intval($_GET['height'])){
    		$height = intval($_GET['height']);
    	}
    	
    	/* $background="";
    	if (isset($_GET['background']) && trim(urldecode($_GET['background'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['background'])))){
    		$background=trim(urldecode($_GET['background']));
    	} */
    	//TODO ADD Backgroud param!
    	
    	$config = array(
	        'codeSet'   =>  !empty($code_set)?$code_set:"2345678abcdefhijkmnpqrstuvwxyzABCDEFGHJKLMNPQRTUVWXY",             // 验证码字符集合
	        'expire'    =>  1800,            // 验证码过期时间（s）
	        'useImgBg'  =>  false,           // 使用背景图片 
	        'fontSize'  =>  !empty($font_size)?$font_size:25,              // 验证码字体大小(px)
	        'useCurve'  =>  $use_curve===1?false:true,           // 是否画混淆曲线
	        'useNoise'  =>  $use_noise===1?false:true,            // 是否添加杂点	
	        'imageH'    =>  $height,               // 验证码图片高度
	        'imageW'    =>  $width,               // 验证码图片宽度
	        'length'    =>  !empty($length)?$length:4,               // 验证码位数
	        'bg'        =>  array(243, 251, 254),  // 背景颜色
	        'reset'     =>  true,           // 验证成功后是否重置
    	);
    	$Verify = new \Think\Verify($config);
    	$Verify->entry();
    }

    //生成订单唯一标识
    function get_order_no($rand){
		$code = $rand;
		//日期时间串 12位
		$timestr = date('ymdHis');
		$code .= $timestr;
		//时间毫秒数 3位
		$rcode = substr(microtime() * 1000000,0,3);
		$code .= $rcode;
		return $code;
	}


	//周四零点将完成订单金额划入商户可提现金额
	public function set_shop_payment(){
		$Shop = D('Home/Shop');
		$OrderConfirmLog = D('Home/OrderConfirmLog');
		$ShopWithdrawalsPayLog = D('Home/ShopWithdrawalsPayLog');
		$ShopWithdrawalsLog = D('Home/ShopWithdrawalsLog');
		//将上周一到周日的所有未处理订单找出
		$time_data=self::getSearchDate();
		$zhou_mon=$time_data['last_start'].' 00:00:00';//周一
        $zhou_sun=$time_data['last_end'].' 23:59:59';//周日
        $zhou_mon_time=strtotime($zhou_mon);
        $zhou_sun_time=strtotime($zhou_sun);
		$where=array();
		$where['is_complete']='0';
		$where['_string']="confirm_time >= $zhou_mon_time AND confirm_time <= $zhou_sun_time";
		$confirm_log_data=$OrderConfirmLog->get_data_all($where);
		foreach ($confirm_log_data as $key => $one) {
			$shop_data=$Shop->getShopInfo(array('shop_id'=>$one['shop_id']));
			//修改商户余额
			$up_date=array();
    		$up_date['shop_id']=$one['shop_id'];
    		$up_date['shop_payment']=array('exp','shop_payment+'.$one['fee']);
        	$is_up_shop=$Shop->edit($up_date);
    		if ($is_up_shop) {
    			//奖励金+1
    			// $up_date_jiangli=array();
    			// $up_date_jiangli['shop_id']=$one['shop_id'];
    			// $up_date_jiangli['shop_payment']=array('exp','shop_payment+1');
    			// $Shop->edit($up_date_jiangli);
    			$back_shop_data=$Shop->getShopInfo(array('shop_id'=>$one['shop_id']));
    			$OrderConfirmLog->edit(array('id'=>$one['id']),array('is_complete'=>'1'));
        		//添加商户余额改动记录
        		$up_shop_log_data=array();
        		$up_shop_log_data['shop_id']=$one['shop_id'];
        		$up_shop_log_data['openid']='';
        		$up_shop_log_data['user_name']='';
        		$up_shop_log_data['fee']=$one['fee'];
        		$up_shop_log_data['payment_front']=$shop_data['shop_payment'];
        		$up_shop_log_data['payment_back']=$back_shop_data['shop_payment'];
        		$up_shop_log_data['order_id']=$one['order_id'];
        		$up_shop_log_data['log_type']='3';
        		$up_shop_log_data['add_time']=time();
        		$ShopWithdrawalsLog->add_data($up_shop_log_data);
    		}
		}
	}

	public function getSearchDate(){
        $date=date('Y-m-d');  //当前日期
        $first=1; //$first =1 表示每周星期一为开始日期 0表示每周日为开始日期
        $w=date('w',strtotime($date));  //获取当前周的第几天 周日是 0 周一到周六是 1 - 6
        $now_start=date('Y-m-d',strtotime("$date -".($w ? $w - $first : 6).' days')); //获取本周开始日期，如果$w是0，则表示周日，减去 6 天
        $now_end=date('Y-m-d',strtotime("$now_start +6 days"));  //本周结束日期
        $last_start=date('Y-m-d',strtotime("$now_start - 7 days"));  //上周开始日期
        $last_end=date('Y-m-d',strtotime("$now_start - 1 days"));  //上周结束日期
        $arr=array('now_start'=>$now_start,'now_end'=>$now_end,'last_start'=>$last_start,'last_end'=>$last_end);
       	return $arr;
    }

    public function test(){
    	//$openid='o25KXjiETFnnk88L-nO9c4R429Pk';
    	$text='哈哈镜提醒您：商户提现功能升级，原先提现链接作废，本周19号（周四）开放提现功能，当天提现如有异常请联系哈哈镜客服，新商户提现链接为：http://weixin.hahajing.com/ShopBack/shop_withdrawals_html';
    	//self::wx_message_send($openid,$text);
    	// $text='哈哈镜提醒您：商户提现功能升级，原先提现链接作废，新商户提现链接为：http://weixin.hahajing.com/ShopBack/shop_withdrawals_html';
    	$Shop = D('Home/Shop');
    	$shop_list=$Shop->ShopList(array('openid'=>array('NEQ','')));
    	foreach ($shop_list as $key => $one) {
    		self::wx_message_send($one['openid'],$text);
    	}
    }

    //测试定时执行
    public function test_dingshi(){
    	$User = D('Home/User');
    	$User->edit(array('user_id'=>'15178'),array('user_phonecode'=>time()));
    }

    //每完成一单，给绑定的商户的发微信推送
    public function wx_message_send($openId,$text){
    	$_SESSION['last_access']=0;
    	if(!isset($_SESSION['last_access'])||(time()-$_SESSION['last_access'])>7200){
    			$_SESSION['last_access'] = time();
    			$wx_url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx78a74ae276f5adb5&secret=c747e99c6d0688dec43b8c522e3a0c1b';
		    	$data_json=file_get_contents($wx_url);
		    	if (!empty($data_json)) {
		    		$data_arr=json_decode($data_json,true);
		    		$_SESSION['access_token']=$data_arr['access_token'];
		    	}
    	}
    	$access_token=$_SESSION['access_token'];
    	$sms_arr=array();
    	$sms_arr['touser']=$openId;
    	$sms_arr['msgtype']='text';
    	$sms_arr['text']=array('content'=>urlencode($text));
    	$sms_json=json_encode($sms_arr);
    	$sms_json=urldecode($sms_json);
    	$url='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
    	$return_data=Up_Posts($sms_json,$url);
    	if ($return_data['errcode'] == '0' and $return_data['errmsg'] == 'ok') {
    		return 1;
    	}else{
    		return 0;
    	}
    }


        //获取短信验证码
    public function public_send_auth_code($mobile,$type_id='5',$user_ip){
    	$url=API_URL.'/rest_2/public/send_auth_code';
        $post_data = array();
        $post_data['mobile']=$mobile;//手机号
        $post_data['user_ip']=$user_ip;//ip
        $post_data['type_id']=$type_id;//类型
        $sign=create_sign($post_data);
        $post_data['sign']=$sign;
        $url_wei=url_arr($post_data);
        $json_data=Posts($url_wei,$url);
        if ($json_data) {
            //吧对象转化为数组
            $arr=ob2ar($json_data);
            $arr_statuses=$arr['result'];
            if ($arr_statuses == 'ok') {
                return array('result'=>'ok','msg'=>"短信已发送");
            }else{
                return array('result'=>'error','msg'=>$arr['data']['msg']);
            }
        }else{
            return false;
        }
    }
}
?>