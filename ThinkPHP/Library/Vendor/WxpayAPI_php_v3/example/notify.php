<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);

require_once "../lib/WxPay.Api.php";
require_once '../lib/WxPay.Notify.php';
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			return true;
		}
		return false;
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
}

		Log::DEBUG("begin notify");
		$notify = new PayNotifyCallBack();
		$notify->Handle(false);
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
		$result = WxPayResults::Init($xml);
		Log::DEBUG('return:'.$result);
		//业务结果
			$result_code = $result['result_code'];
			//支付成功
			if ($result_code == 'SUCCESS') {
				$url='http://www.hahajing.com/WXPay/weixin_alipay_notify_zhifu';
				//$url='http://210.14.157.252/www/WXPay/weixin_alipay_notify_zhifu';
				$url_wei=url_arr($result);
				Posts($url_wei,$url);
				$return_data=array('return_code'=>'SUCCESS');
				echo json_encode($return_data);
			}else{
			//支付失败
			$return_data=array('return_code'=>'FAIL','return_msg'=>'支付失败');
			echo json_encode($return_data);
		}

	function Posts($curlPost, $url) {
	//设置结束
        $curl = curl_init ();
        curl_setopt ( $curl, CURLOPT_URL, $url );
        curl_setopt ( $curl, CURLOPT_HEADER, false );
        curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $curl, CURLOPT_NOBODY, true );
        curl_setopt ( $curl, CURLOPT_POST, true );
        curl_setopt ( $curl, CURLOPT_POSTFIELDS, $curlPost );
        $return_str = curl_exec ( $curl );
        curl_close ( $curl );
        $result = json_decode($return_str);
         return $result;
}
//将数组转化为字符串
function url_arr($arr){
    $str='';
    foreach($arr as $k=>$r){
     $str.="{$k}={$r}&";
    }
    return substr_replace($str, '', -1);
}