<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/10/19
// +----------------------------------------------------------------------

namespace Rest_2\Controller;
use Think\Controller;

/**
 * 用户店铺控制器
 */
class IndexController extends Controller {
	
	public function index() {
		
		echo '';
		// {"buy_num":"2","gift_num":"1","goods_id":"143"}
		// {"buy_num":2,"gift_num":1,"goods_id":165}
		//=json_encode(arry(''bud_num''=>1,''gift_num=1'',goods_id)...) 
		//$var = json_encode(array('bud_num'=>2,'gift_num'=>1,'goods_id'=>165));
		//推送通知+短信
		
		/*
		vendor('Jpush.jpush'); //商品总金额
		$jpush = new \Jpush(C('JPUSH_SHOP_APPKEY'), C('JPush_SHOP_masterSecret'), C('JPush_url'));
		$send  = array('alias'=>array('010099009'));
		$res = $jpush->shopPush($send,'老板:您有一个新订单,点击处理-> ->',1,1,'','86400','speech.caf');
		echo $res;
		*/
		
    }
    
}