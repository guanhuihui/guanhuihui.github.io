<?php
namespace Home\Controller;
use Think\Controller;
class ActHtmlController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }

    //商品列表页面
    public function act_hmlt1(){
    	$this->display();
    }

    //获取附近预定店铺
    public function get_yuding_shop(){
    	$reserve_shop=A('Index')->get_reserve_shop($_SESSION["user_x"],$_SESSION["user_y"]);
    	if (empty($reserve_shop['shop_id'])) {
    		 echo json_encode(array('result'=>'error','data'=>'您附近没有预定店铺'));
    		 exit();
    	}else{
    		echo json_encode(array('result'=>'ok','data'=>$reserve_shop['shop_id']));
    	}
    }

}
?>