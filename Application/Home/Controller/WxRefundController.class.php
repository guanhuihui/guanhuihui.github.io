<?php
namespace Home\Controller;
use Think\Controller;
class WxRefundController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }
    //微信退款
    public function order_refund(){
        $order_no=$_REQUEST['order_no'];
        $out_refund_no=$_REQUEST['out_refund_no'];
        $order_total_fee=$_REQUEST['order_total_fee'];
        $order_refund_fee=$_REQUEST['order_refund_fee'];
        $refund_reason='tuikuan';
        if (!empty($order_no) && !empty($out_refund_no) && !empty($order_total_fee)  && !empty($order_refund_fee)) {
            $input = new \WxPayRefund();
            $input->SetOut_trade_no($order_no);
            $input->SetTotal_fee($order_total_fee);
            $input->SetRefund_fee($order_refund_fee);
            $input->SetOut_refund_no($out_refund_no);
            $input->SetOp_user_id(\WxPayConfig::MCHID);
            $refund_return_data= \WxPayApi::refund($input);
            echo json_encode(array('result'=>'ok','msg'=>$refund_return_data));
            exit();
        }else{
            echo json_encode(array('result'=>'error','msg'=>'缺少参数'));
            exit();
        }

    }
}
?>