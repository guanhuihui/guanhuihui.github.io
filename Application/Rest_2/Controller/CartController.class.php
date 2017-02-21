<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/11/19
// +----------------------------------------------------------------------

namespace Rest_2\Controller;
use Think\Log;

/**
 * 我的购物车控制器
 */
class CartController extends UserFilterController {
	
	public function _initialize() {
		parent::_initialize();
	}
	
	public function index(){
		echo '';
    }
    
    /**
     * 获取购物车商品数量
     */
    public function get_num(){
    	//登陆验证
    	$this->checklogin();
    	
    	$shop_id = I('post.shop_id', 0); //店铺id
    	$goods_id = I('post.goods_id', 0); //商品id
    	if(empty($shop_id)) json_error(20601, array('msg'=>C('ERR_CODE.20601'))); //店铺id不能为空
    	 
    	$Cart = D('Home/Cart');
    	$num = $Cart->getGoodsNum($this->uid, $shop_id, $goods_id);
    	$list = $Cart->getCartGoodsList($this->uid, $shop_id, $goods_id);
    	
    	$pricecount = 0;
    	if($list){
    		$data = array(); //数据重组
    		foreach($list as $key=>$val){
    			$pricecount += $val['count'] * $val['shopgoods_price'];
    		}
    		if($goods_id){
    			$data['num'] = $num;
    			$data['price'] = $pricecount;
    			$data['cart_id'] = $list[0]['cart_id'];
    		}else{
    			$data['num'] = $num;
    			$data['price'] = $pricecount;
    			$data['cart_id'] = '';
    		}
    		
    		$list = $data;
    	}
    	
    	json_success($list);
    }
    
    /**
     * 获取我的购物车列表
     */
    public function get_list(){
    	//登陆验证
		$this->checklogin();
		
		/********获取消息列表********/
		$Cart = D('Home/Cart');
		$list = $Cart->getList($this->uid);		
		if($list){
			//对信息重组
			$data = array();
			$ShopGoods = D('Home/ShopGoods');
			$Shop = D('Home/shop');
			foreach ($list as $val){		
				//获取店铺城市信息
				$shopinfo = $Shop->getInfoById($val['shop_id']);				 
				//根据店铺地理未知获取可用的活动列表信息
				$activity_list = array();
				if($shopinfo){
					$Activity = D('Home/activity');
					$_list = $Activity->getList(1,1);
					if(empty($_list)){
						$_list = $Activity->getList(3,1);
					}
					//根据店铺地址信息过滤活动
					if($_list){
						foreach($_list as $v){
							$ext = json_decode($v['range_ext']);
							if($ext){
								//检测省份类型
								if($v['range_type'] == 2 && in_array($shopinfo['shop_province'],$ext)){									
									$activity_list[] = $v;
								}else if($v['range_type'] == 3 && in_array($shopinfo['shop_city'],$ext)){
									$activity_list[] = $v;
								}
							}
						}
					}				
				}
				
				$cart_data = array();				
				$cart_data['act_name'] = '';
				//根据商品ID获取活动名称
				if($activity_list){
					foreach($activity_list as $v){
						$goods_ext = json_decode($v['goods_ext']);//限制数据
						/*
						Log::write('$goods_ext = '. $v['goods_ext']);
						Log::write('$goods_id = '. $val['goods_id']);
						Log::write('$goods_sort = '. $val['goods_sort']);
						*/
						if($v['goods_type'] == 2){//限制品类
							if(in_array($val['goods_sort'], $goods_ext->ids) && !in_array($val['goods_id'], $goods_ext->exclude_goods)){
								if($v['act_type'] == 3){
									$cart_data['act_name'] = $v['secondary_names'];
								}else{
									$cart_data['act_name'] = $v['act_name'];
								}
								
								$cart_data['secondary_names'] = '';
							}
						}else if($v['goods_type'] == 3){//限制商品
							if(in_array($val['goods_id'], $goods_ext->ids)){
								if($v['act_type'] == 3){
									$cart_data['act_name'] = $v['secondary_names'];
								}else{
									$cart_data['act_name'] = $v['act_name'];
								}
								
								$cart_data['secondary_names'] = '';
							}
						}
					}
				}
				
				$cart_data['cart_id'] = $val['cart_id'];				
				$cart_data['user_id'] = $val['user_id'];				
				$cart_data['count'] = $val['count'];
				$cart_data['type'] = $val['type'];	
				$cart_data['goods_id'] = $val['goods_id'];
				$cart_data['goods_name'] = $val['goods_name'];
				$cart_data['goods_pic'] = C('IMG_HTTP_URL').$val['goods_pic3'];		
				$cart_data['add_time'] = $val['add_time'];
				$cart_data['goods_type'] = $val['goods_type'];
				if($val['goods_sort']>5){//哈哈镜商品
					$cart_data['goods_unit'] = '';  //单位
					$cart_data['goods_weight'] = $val['goods_spec'];  //重量
					$cart_data['goods_pungent'] = $val['goods_brandname']; //口味
				}else{//自营商品
					$cart_data['goods_weight'] = $val['goods_weight'];
					$cart_data['goods_unit'] = $val['goods_unit'];					
					$cart_data['goods_pungent'] = get_goods_pungent($val['goods_pungent']);
				}
				
				$shop_goods_data = $ShopGoods->getShopGoodsInfo($val['shop_id'], $val['goods_id']);
				if($shop_goods_data){
					$cart_data['price'] = $shop_goods_data['shopgoods_price'];
				}else{
					$cart_data['price'] = '';//系统错误
				}
				
				$flag = false;
				foreach ($data as $k=>$v){
					if($val['shop_id'] == $v['shop_id']){
						$flag = true;
						$data[$k]['cart_list'][] = $cart_data;
						break;
					}					
				}
				
				if($flag == false){
					$data[] = array('shop_id'=>$val['shop_id'], 'shop_name'=>$val['shop_name'], 'lng'=>$val['shop_baidux'], 'lat'=>$val['shop_baiduy'], 'shop_deliverscope'=>$val['shop_deliverscope'], 'cart_list'=>array($cart_data));
				}	
			}
			$list = $data;
		}
		
		if($list === false){ //数据库查询失败
			json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		}else{
			json_success($list);
		}
    }
    
    /**
     * 添加购物车
     */
    public function add(){    
    	//登陆验证
    	$this->checkLogin();
  	
    	$shop_id = I('post.shop_id', 0); //店铺id
    	$goods_id = I('post.goods_id', 0); //商品id
    	$count = I('post.count', 1); //商品数量
    	$type = 0; //商品类型 0默认 1赠品
    	
    	if(empty($shop_id)) json_error(20601, array('msg'=>C('ERR_CODE.20601'))); //店铺id不能为空
    	if(empty($goods_id)) json_error(20804, array('msg'=>C('ERR_CODE.20804'))); //商品id不能为空
    	if(empty($count)) json_error(20805, array('msg'=>C('ERR_CODE.20805'))); //商品数量不能为空
    	    	
    	/********添加地址信息********/
    	$Cart = D('Home/Cart');
    	
    	$cart_id = $Cart->add($this->uid, $shop_id, $goods_id, $count, $type); //添加购物车
    	if(!$cart_id) json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
    	json_success(array('cart_id'=>$cart_id));    	
    }
    
    /**
     * 修改购物车
     */
    public function edit(){
    	//登陆验证
    	$this->checkLogin();
    	 
    	$cart_id = I('post.cart_id', 0); //购物车ID
    	$count = I('post.count', 1); //商品数量
    	 
    	if($count > 99) json_error(20807, array('msg'=>C('ERR_CODE.20807'))); //商品数量不能超过99个
    	if(empty($cart_id)) json_error(20806, array('msg'=>C('ERR_CODE.20806'))); //购物车ID不能为空
    	if(empty($count)) json_error(20805, array('msg'=>C('ERR_CODE.20805'))); //商品数量不能为空
    	 
    	/********添加地址信息********/
    	$Cart = D('Home/Cart');
    	$result = $Cart->edit($this->uid, $cart_id, $count); //添加购物车
    	if($result === false) json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
    	json_success(array('msg'=>'ok'));	
    }
    
    /**
     * 删除购物车
     */
    public function del(){
    	//登陆验证
    	$this->checkLogin();
    	
    	$cart_id = I('post.cart_id', ''); //购物车ID不能为空
    	$shop_id = I('post.shop_id', 0);  //店铺ID   	
    	/********删除购物车********/
    	$Cart = D('Home/Cart');
    	if($shop_id){
    		if(empty($shop_id)) json_error(20705, array('msg'=>C('ERR_CODE.20705'))); //店铺信息ID不能为空
    		$result = $Cart->delCartByShopId($this->uid, $shop_id); //删除购物车
    	}else{
    		if(empty($cart_id)) json_error(20806, array('msg'=>C('ERR_CODE.20806'))); //购物车ID不能为空
    		$result = $Cart->del($this->uid, $cart_id); //删除购物车
    	}
    	
    	if($result === false) json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
    	json_success(array('msg'=>'ok'));	
    }
    
    /**
     * 购物车信息整理
     * @param 购物车列表 $cart_list
     * @param 活动列表 $activity_list
     * @return multitype:multitype:string unknown
     */
    private function set_goods_info($cart_list,$activity_list){
    	$ShopGoods = D('Home/ShopGoods');
    	
    	$goods_list = array();
    	foreach ($cart_list as $val){
    		$cart_data = array();
    		$cart_data['act_name'] = '';
    		//根据商品ID获取活动名称（符合条件的首个）
    		if($activity_list){
    			foreach($activity_list as $v){
    				$goods_ext = json_decode($v['goods_ext']);//限制数据
					if(($v['goods_type'] == 2 && in_array($val['goods_sort'], $goods_ext->ids) && !in_array($val['goods_id'], $goods_ext->exclude_goods)) || ($v['act_type'] == 3 && in_array($val['goods_id'], $goods_ext->ids) && !in_array($val['goods_id'], $goods_ext->exclude_goods))){
						if($v['act_type'] == 3){
							if($val['goods_price']>= 30){
							     $cart_data['act_name'] = $v['secondary_names'].'啤酒一听';
							}else{
							    $cart_data['act_name'] = $v['secondary_names'].'非卖品一盒';
							}
						}else{
							$cart_data['act_name'] = $v['act_name'];
						}
						continue;
					}
    			}
    		}
    	
    		$cart_data['cart_id'] = $val['cart_id'];
    		$cart_data['user_id'] = $val['user_id'];
    		$cart_data['count'] = $val['count'];
    		$cart_data['type'] = $val['type'];
    		$cart_data['goods_id'] = $val['goods_id'];
    		$cart_data['goods_name'] = $val['goods_name'];
    		$cart_data['goods_pic'] = C('IMG_HTTP_URL').$val['goods_pic3'];
    		$cart_data['add_time'] = $val['add_time'];
    		$cart_data['goods_type'] = $val['goods_type'];
    		$cart_data['goods_sort'] = $val['goods_sort'];
    		if($val['goods_sort']>5){//哈哈镜商品
    			$cart_data['goods_unit'] = '';  //单位
    			$cart_data['goods_weight'] = $val['goods_spec'];  //重量
    			$cart_data['goods_pungent'] = $val['goods_brandname']; //口味
    		}else{//自营商品
    			$cart_data['goods_weight'] = $val['goods_weight'];
    			$cart_data['goods_unit'] = $val['goods_unit'];
    			$cart_data['goods_pungent'] = get_goods_pungent($val['goods_pungent']);
    		}
    	
    		$shop_goods_data = $ShopGoods->getShopGoodsInfo($val['shop_id'], $val['goods_id']);
    		if($shop_goods_data){
    			$cart_data['price'] = $shop_goods_data['shopgoods_price'];
    		}else{
    			$cart_data['price'] = '';//系统错误
    		}
    		
    		$cart_data['gift_new'] = null;
    		
    		$goods_list[] = $cart_data;
    	}    	
    	return $goods_list;
    }
    
    private function set_gifts($cart_list, $activity_data){
    	$data = array();

    	$data1 = array();
    	
    	$ShopGoods = D('Home/ShopGoods');
    	$Goods = D('Home/Goods');
    	
    	$_gift_arr = array();    	
    	//买x赠x 赠品添加 ----------------begin------------------------
    	foreach ($activity_data as $gift){
    		$goods_ext = json_decode($gift['goods_ext']);//商品限制
    		$_goods_gift_num = 0;
    		foreach ($cart_list as $val){
    			if($gift['gift_ext']){
    				//赠品判断
    				$is_gift = false;
    				if($gift['goods_type']==2){//根据分类
    					$_goods_data = $Goods->getInfoById($val['goods_id']);
    					if($_goods_data && in_array($_goods_data['goods_sort'], $goods_ext->ids) && !in_array($val['goods_id'], $goods_ext->exclude_goods)){
    						$is_gift = true;
    					}
    				}else if($gift['goods_type']==3){ //根据买赠活动中的商品id数组，对商品类别进行过滤
    					if(in_array($val['goods_id'], $goods_ext->ids)){
    						$is_gift = true;
    					}
    				}
    					
    				//如果有赠品
    				if($is_gift) {
    					$_goods_gift_num = $_goods_gift_num + $val['count'];
    					
    					$gift_data = array();
    					$gift_data['goods_id'] = 0;
    					$gift_data['goods_name'] = '';
    					$gift_data['goods_pic'] = '';
    					$gift_data['count'] = 0;
    					$gift_data['price'] = '0.00';    					 
    					$val['gift_new'] = $gift_data;
    					$val['gift'] = null;
    					$data1[] = $val;
    				}else{
    					$val['gift'] = null;
    					$val['gift_new'] = null;
    					$data[] = $val;
    				}
    			}else{
    				$val['gift'] = null;
    				$val['gift_new'] = null;
    				$data[] = $val;
    			}
    		}
    	
    		//买赠配置信息
    		$ext = json_decode($gift['gift_ext']);
    		//Log::write('$ext->buy_num = '.$ext->buy_num);
    		$gift_goods = $Goods->getInfoById($ext->goods_id);
    		$gift_data = array();
    		$gift_data['goods_id'] = $ext->goods_id;
    		$gift_data['goods_name'] = '[赠]'.$gift_goods['goods_name'];
    		$gift_data['goods_pic'] = C('IMG_HTTP_URL').$gift_goods['goods_pic3'];
    		//赠品数量
    		//Log::write('$ext->bud_num = '.$ext->buy_num);
    		//Log::write('count/bud_num = '.intval($val['count'] / $ext->buy_num));
    		//Log::write('$_goods_gift_num = '.$_goods_gift_num);
    		$gift_data['count'] = intval($_goods_gift_num / $ext->buy_num) * $ext->gift_num;
    		$gift_data['price'] = '0.00';
    		
    		if($gift_data['count']){    			
    			$_i = count($data1)-1;
    			if($_i>=0){    			
    				$data1[$_i]['gift_new'] = $gift_data;
    			}
    		}
    		
    		$data = array_merge($data1,$data);
    	}
    	//买x赠x 赠品添加 ----------------end------------------------
    	
    	return $data;
    }
    
    /**
     * 仅限新版买赠计算
     */
    private function set_gift_info($goods_list, $activity_data, $ticket_data) {
    	$data = array();
    
    	$ShopGoods = D('Home/ShopGoods');
    	$Goods = D('Home/Goods');
    	//限制数据
    	$goods_ext = json_decode($activity_data['goods_ext'],true);
    	$gift_ext = json_decode($activity_data['gift_ext'],true);
    	$ticket_amount = floatval($ticket_data['price']);//优惠价格区间
    	//Log::write('$ticket_amount = '. $ticket_amount);
    	foreach ($goods_list as $val){
    		//赠品判断
    		$is_gift = false;
    		if($activity_data['goods_type']==2){//根据分类
    			if(in_array($val['goods_sort'], $goods_ext['ids']) && !in_array($val['goods_id'], $goods_ext['exclude_goods'])){
    				$is_gift = true;
    			}
    		}else if($activity_data['goods_type']==3){ //根据买赠活动中的商品id数组，对商品类别进行过滤
    			if(in_array($val['goods_id'], $goods_ext['ids'])){
    				$is_gift = true;
    			}
    		}    		
    		
    		if($is_gift){    			
    			//商品数量
    			$_gift_num = 0;
    			for ($i=0; $i<$val['count']; $i++) {
    				$ticket_amount -= floatval($val['price']);
    				if($ticket_amount >= 0) {
    					$_gift_num += 1;
    				}
    			}
    			
    			$_gift_id = $gift_ext['gift_id'];
    			//特殊赠品处理
    			$_exclude_gift_list = $gift_ext['exclude_gift'];		
    			if($_exclude_gift_list){
    				foreach ($_exclude_gift_list as $_gift){
    					if($_gift['goods_id'] == $val['goods_id']){
    						$_gift_id = $_gift['gift_id'];
    						break;
    					}
    				}
    			}
    			
    			$gift_data = null;
    			//购物车拆分
    			if($_gift_num == $val['count'] && $_gift_num){
    
    				$gift_goods = $Goods->getInfoById($_gift_id);
    				$gift_data = array();
    				$gift_data['goods_id'] = $_gift_id;
    				$gift_data['goods_name'] = '[赠]'.$gift_goods['goods_name'];
    				$gift_data['goods_pic'] = C('IMG_HTTP_URL').$gift_goods['goods_pic3'];
    				$gift_data['count'] = $_gift_num;
    				$gift_data['price'] = '0.00';
    			    				
    				$val['gift'] = $gift_data;
    				$val['gift_new'] = $gift_data;
    				$data[] = $val;
    			}else{  
    				if($_gift_num){		
	    				$_count = $val['count'];
	    				
	    				$gift_goods = $Goods->getInfoById($_gift_id);
	    				$gift_data = array();
	    				$gift_data['goods_id'] = $_gift_id;
	    				$gift_data['goods_name'] = '[赠]'.$gift_goods['goods_name'];
	    				$gift_data['goods_pic'] = C('IMG_HTTP_URL').$gift_goods['goods_pic3'];
	    				$gift_data['count'] = $_gift_num;
	    				$gift_data['price'] = '0.00';    				
	    				$val['gift'] = $gift_data;
	    				$val['gift_new'] = $gift_data;
	    				$val['count'] = $_gift_num;
	    				$data[] = $val;
	
	    				$val['gift'] = null;
	    				$val['gift_new'] = null;
	    				$val['count'] = $_count - $_gift_num;    				
	    				$data[] = $val;
    				}else{
    					$val['gift_new'] = null;
    					$val['gift'] = null;
    					$data[] = $val;
    				}
    			}   			
    		}else{
    			$val['gift'] = null;
    			$data[] = $val;
    		}
    	}
    	
    	return $data;
    }    
    
    /**
     * 新买赠活动 购物车列表
     */
    public function get_info(){
    	//登陆验证
    	$this->checklogin();    	
    	$shop_id = I('post.shop_id', 0); //店铺ID
    	//$cart_ids = I('post.cart_ids', ''); //购物车id
    	
    	/********获取消息列表********/
    	$Cart = D('Home/Cart');
    	$cart_list = $Cart->getListForShop($this->uid, $shop_id);
    	////数据库查询失败
    	if($cart_list === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));
    	
    	$data = array();
    	if(count($cart_list)>0){
    		$ShopGoods = D('Home/ShopGoods');
    		$Shop = D('Home/shop');
    		
    		$shopinfo = $Shop->getInfoById($cart_list[0]['shop_id']);
    		if($shopinfo){
    			$data['shop_id'] = $shopinfo['shop_id'];
    			$data['shop_name'] = $shopinfo['shop_name'];
    			$data['shop_deliverscope'] = $shopinfo['shop_deliverscope'];
    			$data['shop_lng'] = $shopinfo['shop_baidux'];
    			$data['shop_lat'] = $shopinfo['shop_baiduy'];
    		}else{
    			json_success($data);//返回空
    		}
    		 		
    		$Activity = D('Home/Activity');
    		$act_type = 1;
    		//买二赠一活动
    		$_act_list = $Activity->getList($act_type,1);
    		//根据店铺地址信息过滤活动
    		$activity_list = filter_activity($_act_list, $shopinfo['shop_province'], $shopinfo['shop_city']);
    		if(empty($activity_list)){
    			$act_type = 3;
    			$_act_list = $Activity->getList($act_type,1);
    			$activity_list = filter_activity($_act_list, $shopinfo['shop_province'], $shopinfo['shop_city']);
    		}		

    		$data['goods_list'] = $this->set_goods_info($cart_list, $activity_list);    		
    		if($act_type==1 && count($activity_list)>0){ //买一赠一  
    			$data['goods_list'] = $this->set_gifts($data['goods_list'], $activity_list);
    		}
    		
    		$data['act_status'] = 0;
    		$data['act_tips1'] = '亲，首页领取{ 100元赠品兑换券 }可享订单金额100元以内商品买1赠1优惠';
    		$data['act_tips2'] = '订单中不含哈哈镜卤味，不可使用本优惠';
    		$data['act_tips3'] = '取消勾选，视为自动放弃使用100元赠品兑换券，本次订单将无任何赠品';
    		$data['act_tips4'] = '订单金额超出100元以上哈哈镜商品不享受本买赠活动';
    		$data['act_tips5'] = '100元赠品兑换券限定一次使用，确定完成购物了吗?';
    		$data['act_ticket'] = null;
    		$data['act_desc'] = '';
    		
    		//满足买赠条件
    		if($act_type==3 && count($activity_list)>0){
    			$Ticket = D('Home/Ticket');
    			$map = array();
    			$map['act_id'] = $activity_list[0]['act_id'];
    			$map['user_id'] = $this->uid;
    			$map['status'] = 0;
    			$now = date('Y-m-d H:i:s');
    			$map['begin_time'] = array('lt', $now);
    			$map['end_time'] = array('gt', $now);
    			
    			//获取买赠券列表
    			$ticket_data = $Ticket->getTicketListByWhere($map);
    			$ticket_info = array();
    			if($ticket_data){
    				$data['goods_list'] = $this->set_gift_info($data['goods_list'], $activity_list[0], $ticket_data);
    				$data['act_status'] = 1;
 
    				//重组优惠券信息
    				$ticket_info['ticket_id'] = $ticket_data['ticket_id']; //优惠券ID
    				$ticket_info['act_id'] =  $activity_list[0]['act_id']; //活动ID
    				$ticket_info['user_id'] = $ticket_data['user_id']; //用户ID
    				$ticket_info['act_name'] = $activity_list[0]['act_name']; //活动名称
    				$ticket_info['act_desc'] = $activity_list[0]['act_desc']; //活动简介
    				$ticket_info['notes'] = $activity_list[0]['notes']; //优惠券ID
    				$ticket_info['ticket_price'] = $ticket_data['discount_price']; //优惠券面值
    				$ticket_info['start_price'] = $ticket_data['price']; //起步金额
    				$ticket_info['discount_price'] = $ticket_data['discount_price']; //优惠金额
    				$ticket_info['code'] = $ticket_data['ticket_code']; //优惠券码
    				$ticket_info['start_date'] = $ticket_data['begin_time']; //优惠券开始日期
    				$ticket_info['end_date'] = $ticket_data['end_time']; //优惠券结束日期
    				$ticket_info['status'] = 0; //优惠券状态    				
    				
    				$data['act_ticket'] = $ticket_info;
    				$data['act_desc'] = '';
    			}else{
    				$data['act_status'] = 1;
    				$data['act_ticket'] = null;
    				$data['act_desc'] = '';
    			}
    			
    		}
    	}
    	json_success($data);		
    }
}