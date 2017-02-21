<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/11/18
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/**
 * 店铺控制器
 */
class ShopController extends UserFilterController {
	
	public function index(){
		echo '';
    }
    
    /**
     * 根据坐标位置获取周边的店铺（按距离由近到远）
     * 116.442087,39.945532 lng=116.442087&lat=39.945532&num=10
     */
    public function near_list(){
    	$lng = I('post.lng', 39.915156); //经度
    	$lat = I('post.lat', 116.403981); //纬度    	
    	$num = I('post.num', 1); //返回数量     	   	
    	$city_id = I('post.city_id', 0); //城市id    	
    	
    	//经度不存在
    	if(empty($lng)){
    		json_error('20401', array('msg'=>C('ERR_CODE.20401')));
    	}
    	
    	//纬度不存在
    	if(empty($lat)){
    		json_error('20402', array('msg'=>C('ERR_CODE.20402')));
    	}
    	
    	    	
    	$Shop = D('Home/Shop');
    	$City = D('Home/City');
    	$list = $Shop->getListByDistince($lng, $lat, $num);   	
    	if($list){
    		//对信息重组
    		$_vip_list = array(); //vip店
    		$_list = array(); //非vip店
    		$city = null;
    		foreach ($list as $val){
    			$data = array();
    			$data['shop_id'] = $val['shop_id'];
    			$data['shop_name'] = $val['shop_name'];
     			$data['shop_avatar'] = C('IMG_HTTP_URL').$val['shop_avatar'];
    			$data['shop_avatar'] = str_replace('_default.png','_default3.png?ddd', $data['shop_avatar']);    			
    			//$data['shop_avatar'] = C('IMG_HTTP_URL').'shop_avatar/_default3.png';//店铺图标  (替换后的店铺默认图片)
    			$data['shop_orderphone1'] = $val['shop_orderphone1'];
    			$data['shop_orderphone2'] = $val['shop_orderphone2'];
    			$data['shop_deliverscope'] = $val['shop_deliverscope'];
    			$start = get_passtime_str($val['shop_opentime1']); //店铺营业时间开始
    			$end =  get_passtime_str($val['shop_opentime2']); //店铺营业时间结束
    			$data['shop_opentime'] = $start.'-'.$end;  //营业时间端
    			$delivertime_start = get_passtime_str($val['shop_delivertime1']); //配送时间开始
    			$delivertime_end = get_passtime_str($val['shop_delivertime2']); //配送时间结束
    			$data['shop_delivertime'] = $delivertime_start.'-'.$delivertime_end;
    			$data['shop_deliverfee'] = $val['shop_deliverfee'];
    			$data['shop_updeliverfee'] = $val['shop_updeliverfee'];
    			if($val['shop_isvip'] == 1 && $val['shop_type'] == 0){
    				$data['shop_isvip'] = 1; //vip网店
    			}else if($val['shop_isvip'] == 0 && $val['shop_type'] == 0){
    				$data['shop_isvip'] = 2; //普通网店
    			}else if($val['shop_type'] == 1){
    				$data['shop_isvip'] = 3; //代售点
    			}	
    			$data['shop_totalordercount'] = $val['shop_totalordercount']; 
    			$data['shop_address'] = $val['shop_address']; //店铺地址
    			$data['shop_baidux'] = $val['shop_baidux']; //百度地图坐标（经度）
    			$data['shop_baiduy'] = $val['shop_baiduy']; //百度地图坐标（纬度）
    			$data['distance'] = $val['distance']; //距离
    			//获取店铺所在的城市名
    			if(!$city || ($city['city_id'] != $val['shop_city'])){
    				$city = $City->getInfoById($val['shop_city']);
    			}    			
    			
    			if($city){
    				$data['city_name'] = $city['city_name']; //城市名
    			}else{
    				$data['city_name'] = ''; //城市名
    			}
    			$data['score'] = $val['score'];//店铺评分
				
    			if($val['distance'] <= 10000 && $val['shop_isvip'] == 1 && $val['shop_type'] == 0){//10千米之内vip店
    				$_vip_list[] = $data;
    			}else if($val['distance'] <= 10000 && $val['shop_isvip'] != 1){
    				$_list[] = $data;
    			}
    		}

			//合并数组
			$list = array_merge($_vip_list, $_list);
    	}
    	
    	if($list === false){ //数据库查询失败
			json_error(10201, array('msg'=>C('ERR_CODE.10201')));
		}else{
			json_success($list);
		}
    }
    
    /**
     * 获取店铺信息 赵波
     */
    public function get_info(){
    	$shop_id = I('post.shop_id', 0);//店铺ID
  
    	if(empty($shop_id)) json_error(20601, array('msg'=>C('ERR_CODE.20601')));//店铺ID不能为空
    
    	$Shop = D('Home/shop');
    	$City = D('Home/City');
    	$shopinfo = $Shop->getInfoById($shop_id); //获取店铺信息
    	if($shopinfo === false) json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
    	
    	if($shopinfo){
    		$data = array();
    		$data['shop_id'] = $shopinfo['shop_id'];   //店铺ID
    		$data['shop_account'] = $shopinfo['shop_account']; //店铺用户名
    		$data['shop_addtime'] = $shopinfo['shop_addtime']; //店铺添加时间
    		$data['shop_name'] = $shopinfo['shop_name']; //店铺名称
    		$data['shop_type'] = $shopinfo['shop_type']; //店铺类型  0--网点；1--代售点
    		$data['shop_info'] = $shopinfo['shop_info']; //店铺备注
    		$data['shop_avatar'] = C('IMG_HTTP_URL').$shopinfo['shop_avatar']; //店铺图标
    		$data['shop_avatar'] = str_replace('_default.png','_default3.png?ddd', $data['shop_avatar']);
			//$data['shop_avatar'] = C('IMG_HTTP_URL').'shop_avatar/_default3.png'; //店铺图标  (替换后的店铺默认图片)
    		$start = get_passtime_str($shopinfo['shop_opentime1']); //店铺营业时间开始
    		$end =  get_passtime_str($shopinfo['shop_opentime2']); //店铺营业时间结束
    		$data['shop_opentime'] = $start.'-'.$end;
    		$delivertime_start = get_passtime_str($shopinfo['shop_delivertime1']); //配送时间开始
    		$delivertime_end = get_passtime_str($shopinfo['shop_delivertime2']); //配送时间结束
    		$data['shop_delivertime'] = $delivertime_start.'-'.$delivertime_end;
    		$data['shop_isopen'] = $shopinfo['shop_isopen']; //是否营业  0--是；1--否。
    		if($shopinfo['shop_isvip'] == 1 && $shopinfo['shop_type'] == 0){
    			$data['shop_isvip'] = 1; //vip网店
    		}else if($shopinfo['shop_isvip'] == 0 && $shopinfo['shop_type'] == 0){
    			$data['shop_isvip'] = 2; //普通网店
    		}else if($shopinfo['shop_type'] == 1){
    			$data['shop_isvip'] = 3; //代售点
    		}
    		$data['shop_deliverscope'] = $shopinfo['shop_deliverscope']; //送货范围
    		$data['shop_updeliverfee'] = $shopinfo['shop_updeliverfee']; //送货价
    		$data['shop_post_fee'] = $shopinfo['shop_deliverfee']; //配送费
    		$data['shop_ordercount'] = $shopinfo['shop_totalordercount']; //订单总数
    		//外阜不能显示哈优选   北京,上海VIP店可以显示哈优选
    		if(in_array($shopinfo['shop_city'],array(104,133)) && $shopinfo['shop_isvip'] == 1){
    			$data['shop_hyx_button'] = 1;//可点哈优选
    			$data['shop_hyx_desc'] = '';
    		}else{
    			$data['shop_hyx_button'] = 0;//不可点哈优选
    			$data['shop_hyx_desc'] = '暂无哈优选商品';
    		}
    		$data['shop_orderphone1'] = $shopinfo['shop_orderphone1']; //订购/客服电话(手机)
    		$data['shop_orderphone2'] = $shopinfo['shop_orderphone2']; //订购/客服电话(固话)
    		$data['shop_address'] = $shopinfo['shop_address']; //店铺地址
    		$data['shop_baidux'] = $shopinfo['shop_baidux']; //百度地图坐标（经度）
    		$data['shop_baiduy'] = $shopinfo['shop_baiduy']; //百度地图坐标（纬度）
    		//获取店铺所在的城市名
    		$city = $City->getInfoById($shopinfo['shop_city']);
    		if($city){
    			$data['city_name'] = $city['city_name']; //城市名
    		}else{
    			$data['city_name'] = ''; //城市名
    		}
    		$data['is_fav'] = 0; //店铺是否被收藏 0为未收藏 1为已收藏
    		
    		//检测用户登陆状态店铺是否被收藏
    		$user = $this->uid;
    		if($user){
    			$Shopuser = D('Home/ShopUser');
    			$result = $Shopuser->checkUserFav($shop_id, $this->uid);
    			if($result){
    				$data['is_fav'] = 1; //店铺是否被收藏 0为未收藏 1为已收藏
    			}
    		}
    		//店铺评分
    		$data['score'] = $shopinfo['score']; //店铺评分
    		//运费提醒
    		$data['post_tip'] = array('min_money'=>120,'max_money'=>200,'tip'=>'全场满200元免运费');
    		    		
    		$shopinfo = $data;
    	}
    	   	
    	json_success($shopinfo);
    }
    
    /**
     * 用户添加收藏店铺 赵波
     */
    public function favorite_add(){
    	//验证登陆
    	$this->checkLogin();
    	$shop_id = I('post.shop_id', 0); //店铺ID    	
    	if(empty($shop_id)) json_error(20601, array('msg'=>C('ERR_CODE.20601')));//店铺ID不能为空
    		
    	$Shopuser = D('Home/ShopUser');    	
    	$result = $Shopuser->checkUserFav($shop_id, $this->uid);
    	//店铺已经收藏
    	if($result) json_error(20603, array('msg'=>C('ERR_CODE.20603')));
    		
    	//收藏店铺
    	$result_id = $Shopuser->fav($this->uid, $shop_id);
    	if(!$result_id){
    		json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
    	}else{
			json_success(array('shopuser_id'=>$result_id));
		}
    }    
    
  
    /**
     * 用户取消收藏店铺 赵波
     */
    public function favorite_del(){
    	//验证登陆
    	$this->checkLogin();
    	$shop_id = I('post.shop_id', 0); //店铺ID    	
    	if(empty($shop_id))	json_error(20601, array('msg'=>C('ERR_CODE.20601')));//店铺ID不能为空
    	
    	$Shopuser = D('Home/ShopUser');
    	$result = $Shopuser->deleteShopFav($shop_id, $this->uid);//删除收藏
    	if($result === false){
    		json_error(10202, array('msg'=>C('ERR_CODE.10202')));//数据库更新失败
    	}else{
    		json_success(array('msg'=>'ok'));
    	}    	
    }
    
    /**
     * 获取用户收藏店铺列表 赵波
     */
    public function favorite_shops(){
    	//验证登陆
     	$this->checkLogin();
    	$Shopuser = D('Home/ShopUser');
    	$list = $Shopuser->getShopFavList($this->uid);
    	if($list){
    		$data = array();
    		foreach ($list as $key=>$val){
    			$data[$key]['shop_id'] = $val['shop_id'];   //店铺ID
    			$data[$key]['shop_name'] = $val['shop_name']; //店铺名称
     			$data[$key]['shop_avatar'] = C('IMG_HTTP_URL').$val['shop_avatar']; //店铺图标
     			$data[$key]['shop_avatar'] = str_replace('_default.png','_default3.png?ddd', $data[$key]['shop_avatar']);
     			
    			$data[$key]['shop_orderphone1'] = $val['shop_orderphone1']; //订购/客服电话(手机)
    			$data[$key]['shop_orderphone2'] = $val['shop_orderphone2']; //订购/客服电话(固话)
    			$data[$key]['shop_deliverscope'] = $val['shop_deliverscope']; //送货范围
    			$start = get_passtime_str($val['shop_opentime1']); //店铺营业时间开始
    			$end =  get_passtime_str($val['shop_opentime2']); //店铺营业时间结束
    			$data[$key]['shop_opentime'] = $start.'-'.$end;
    			$delivertime_start = get_passtime_str($val['shop_delivertime1']); //配送时间开始
    			$delivertime_end = get_passtime_str($val['shop_delivertime2']); //配送时间结束
    			$data[$key]['shop_delivertime'] = $delivertime_start.'-'.$delivertime_end;
    			$data[$key]['shop_deliverfee'] = $val['shop_deliverfee']; //运费
    			$data[$key]['shop_updeliverfee'] = $val['shop_updeliverfee']; //起送费
    			$data[$key]['shop_ordercount'] = $val['shop_ordercount']; //订单总数
    			$data[$key]['shop_isopen'] = $val['shop_isopen']; //是否营业  0--是；1--否。
    			$data[$key]['shop_address'] = $val['shop_address']; //店铺地址
    			$data[$key]['shop_baidux'] = $val['shop_baidux']; //百度地图坐标（经度）
    			$data[$key]['shop_baiduy'] = $val['shop_baiduy']; //百度地图坐标（纬度）
    			$data[$key]['shopuser_free'] = $val['shopuser_free']; //是否免运费的状态  0--普通（默认）；1--免运费；    			
    			if($val['shop_isvip'] == 1 && $val['shop_type'] == 0){
    				$data[$key]['shop_isvip'] = 1; //vip网店
    			}else if($val['shop_isvip'] == 0 && $val['shop_type'] == 0){
    				$data[$key]['shop_isvip'] = 2; //普通网店
    			}else if($val['shop_type'] == 1){
    				$data[$key]['shop_isvip'] = 3; //代售点
    			}
    			$data[$key]['shopuser_status'] = $val['shopuser_status']; //状态 0普通 1黑名单 2免运费用户  				
    		}    			
    		$list = $data;
    	}
    	if($list === false){
    		json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
    	}else{
			json_success($list);
		} 
    }
    
    /**
     * 店铺获取用户粉丝列表 赵波
     */
    public function favorite_users(){
    	//验证登陆
    	$this->checkLogin();
    	$Shopuser = D('Home/ShopUser');
    	$list = $Shopuser->getUserListByShop($this->uid); //获取粉丝列表
    	if($list){
    		$data = array();
    		foreach($list as $val){
    			$data['user_id'] = $val['user_id'];   //用户ID
    			$data['user_account'] = $val['user_account'];   //用户账号
    			$data['user_avatar'] = C('IMG_HTTP_URL').$val['user_avatar'];   //用户头像
    			$data['user_score'] = $val['user_score'];   //用户积分
    			$data['user_isvip'] = $val['user_isvip'];   //用户 0--不是（默认值） 1--是
    			$data['shopuser_status'] = $val['shopuser_status'];   //状态 0普通 1黑名单 2免运费用户 
    			$data['shopuser_free'] = $val['shopuser_free'];   //运费
    		}
    		$list = $data;
    	}
    		
    	if($list === false){
    		json_error(10201, array('msg'=>C('ERR_CODE.10201')));//数据库查询失败
    	}else{
			json_success($list);
		}
    		
    }
    
    /**
     * 获取用户下过订单的店铺列表 赵波
     */
    public function love_shop(){
    	 
    	$lng = I('post.lng', 0); //经度
    	$lat = I('post.lat', 0); //纬度
    	
    	//经度不存在
    	if(empty($lng)) json_error('20401', array('msg'=>C('ERR_CODE.20401')));
    	
    	//纬度不存在
    	if(empty($lat))	json_error('20402', array('msg'=>C('ERR_CODE.20402')));
    	
    	$listorder = array(); //声明一个储存用户下过订单店铺列表的变量
    	
    	//用户信息存在的话 获取用户下过单的店铺列表
     	if($this->uid){
    		$Order = D('Home/Order');
    		$listorder = $Order->getOrderShop($this->uid);
    	}
    	
    	//获取由近至远的店铺列表
    	$Shop = D('Home/Shop');
    	$list = $Shop->getNetShopListByDistince($lng, $lat, 3);  //获取附近3个店铺信息  (首页最少显示3个)
    	
    	//获取 $list 列表中所有的店铺ID
    	$ids = array();
    	if($list){
    		foreach($list as $key=>$val){
    			$ids[] = $val['shop_id'];
    		}
    	}
    	
    	//清除两组数据中重复的店铺信息
    	$listcount = array();  //声明一个储存显示所有店铺列表的变量
    	if($listorder){
    		foreach($listorder as $key=>$val){
    			if(in_array($val['shop_id'],$ids)){
    				unset($listorder[$key]); //删除重复的店铺信息
    			}
    		}
    	}
    	
    	//将两组数据合并(下过订单的店铺在前面显示)
    	if($listorder){
    		$listcount = array_merge($listorder, $list);
    	}else{
    		$listcount = $list;
    	}
    	
    	if($listcount){
    		//对附近的店铺列表信息进行数据重组s
    		$data = array();
    		foreach($listcount as $k=>$val){					

    			$data[$k]['shop_id'] = $val['shop_id'];
    			$data[$k]['shop_name'] = $val['shop_name'];
    			$data[$k]['shop_avatar'] = C('IMG_HTTP_URL').$val['shop_avatar'];
    			$data[$k]['shop_avatar'] = str_replace('_default.png','_default3.png?ddd', $data[$k]['shop_avatar']);
//     			$data[$k]['shop_avatar'] = C('IMG_HTTP_URL').'shop_avatar/_default3.png'; //店铺图标  (替换后的店铺默认图片)
    			$data[$k]['shop_orderphone1'] = $val['shop_orderphone1'];
    			$data[$k]['shop_orderphone2'] = $val['shop_orderphone2'];
    			$data[$k]['shop_deliverscope'] = $val['shop_deliverscope'];
    			$start = get_passtime_str($val['shop_opentime1']); //店铺营业时间开始
    			$end =  get_passtime_str($val['shop_opentime2']); //店铺营业时间结束
    			$data[$k]['shop_opentime'] = $start.'-'.$end;
    			$delivertime_start = get_passtime_str($val['shop_delivertime1']); //配送时间开始
    			$delivertime_end = get_passtime_str($val['shop_delivertime2']); //配送时间结束
    			$data[$k]['shop_delivertime'] = $delivertime_start.'-'.$delivertime_end;
    			$data[$k]['shop_deliverfee'] = $val['shop_deliverfee'];
    			$data[$k]['shop_updeliverfee'] = $val['shop_updeliverfee'];
    			
    			if($val['shop_isvip'] == 1 && $val['shop_type'] == 0){
    				$data[$k]['shop_isvip'] = 1; //vip网店
    			}else if($val['shop_isvip'] == 0 && $val['shop_type'] == 0){
    				$data[$k]['shop_isvip'] = 2; //普通网店
    			}else if($val['shop_type'] == 1){
    				$data[$k]['shop_isvip'] = 3; //代售点
    			}
    			
    			$data[$k]['shop_totalordercount'] = $val['shop_totalordercount'];
    			$data[$k]['shop_address'] = $val['shop_address']; //店铺地址
    			$data[$k]['shop_baidux'] = $val['shop_baidux']; //百度地图坐标（经度）
    			$data[$k]['shop_baiduy'] = $val['shop_baiduy']; //百度地图坐标（纬度）
                $data[$k]['distance'] = $val['distance']; //距离
	
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
     * 通过首页分类获取最近的一家网店店铺
     * @param 定位经度  $lng
     * @param 定位纬度  $lat
     * @param 子类信息  $son_cat_id
     */
	public function category_shop(){
    	/*接收参数*/
    	$lng = I('post.lng', 0); //经度
    	$lat = I('post.lat', 0); //纬度
    	$son_cat_id = I('post.son_cat_id', 0); //二级分类id(1,2,3);
    	
    	//经度不存在
    	if(empty($lng))	json_error('20401', array('msg'=>C('ERR_CODE.20401')));    	 
    	//纬度不存在
    	if(empty($lat))	json_error('20402', array('msg'=>C('ERR_CODE.20402')));
    	
    	//获取店铺列表  优先VIP店铺
    	$Shop = D('Home/Shop');
    	$list = $Shop->getNetShopListByDistince($lng, $lat, 100);    	
    	if($list === false){ //数据库查询失败
    		json_error(10201, array('msg'=>C('ERR_CODE.10201')));
    	}
    	
    	//获取VIP网店
    	$_vip_list = array();
    	//过滤后的店铺列表
    	$_list = array(); 
    	foreach($list as $val){
    		if($val['shop_isvip'] == 1 && $val['shop_type'] == 0 && $val['distance'] < 10000){
    			$_vip_list[] = $val;
    		}else if($val['distance'] < 10000){//网店过滤5公里内的
    			$_list[] = $val;
    		}
    	}

    	$shop_list = array_merge($_vip_list, $_list);
    	// 返回空数据
    	if(count($shop_list)==0){
    		json_error(20602, array('msg'=>C('ERR_CODE.20602')));
    	}
    	
    	$shop_id = 0;
    	$result = $this->get_near_shop($son_cat_id, $shop_list); //过滤店铺  查找最近的且含有二级分类的店铺    	
    	if($result){
    		$shop_id = $result['shopgoods_shop'];
    	}      	

    	$data = array();
    	$data['shop_id'] = $shop_id;
    	if($shop_id == 0 && $this->os=='iOS'){
    		$data['shop_id'] = $shop_list[0]['shop_id'];
    	}
    	
    	json_success($data);
    }
    
    /**
     * get_near_shop 获取相关分类最近的店铺
     * @param 分类信息  $cat_id
     * @param 店铺列表  $data
     */
    private function get_near_shop($cat_id, $shop_list){
    	$Shopgoods = D('Home/ShopGoods');
    	$data = false;
    	if($shop_list){
    		foreach($shop_list as $val){
    			$result = $Shopgoods->getShopByCategorty($cat_id, $val['shop_id']);
    			if($result){
    				$data = $result;
    				break;
    			}
    		}
    	}
    	
    	return $data;
    }
    
    /**
     * goodsname_shop 首页搜索商品名获取店铺商品列表
     * @param 定位经度  $lng
     * @param 定位纬度  $lat
     * @param 商品名称  $goodsname
     */
    public function search_goods(){
    	/*接收参数*/
    	$lng = I('post.lng', 0); //经度
    	$lat = I('post.lat', 0); //纬度
    	$goodsname = I('post.goodsname', ''); //搜索的商品名称

    	//经度不存在
    	if(empty($lng)) json_error('20401', array('msg'=>C('ERR_CODE.20401')));
    	
    	//纬度不存在
    	if(empty($lat)) json_error('20402', array('msg'=>C('ERR_CODE.20402')));
    	
    	//搜索内容为空
    	if(empty($goodsname)) json_error('21002', array('msg'=>C('ERR_CODE.21002')));
    	

    	
    	//加%%号
    	$goodsname = "%{$goodsname}%";
    	
    	$Shop = D('Home/Shop');
    	$shoplist = $Shop->getNetShopListByDistince($lng, $lat, 5); //100家网店店铺商品
    	 
    	if($shoplist === false){ //数据库查询失败
    		json_error(10201, array('msg'=>C('ERR_CODE.10201')));
    	}
    	
    	//筛选10公里的店铺
    	if($shoplist){
    		$lists = array();
    		foreach($shoplist as $val){
    			if($val['distance'] <= 10000){
    				$lists[] = $val;
    			}
    		}
    		$shoplist = $lists;
    	}
    	
    	//买赠活动列表
    	$activitylist = array();
    	$Activity = D('Home/activity');
    	$Shop = D('Home/shop');
    	$time = date('Y-m-d H:i:s',time());  //初始化当前时间
    	//拼接搜索条件
    	$map = array();
    	$map['act_type'] = 1;  //活动为买赠活动
    	$map['status'] = 1;    //活动为开启
    	$map['begin_time'] = array('lt', $time); //活动开始时间小于当前时间
    	$map['end_time'] = array('gt', $time);  //活动结束时间大于当前时间
    	$activitylist = $Activity->getActivityList($map);
    	
    	//查询商品
    	$goodlist = array();
    	if($shoplist){
    		 foreach($shoplist as $val){//店铺商品查询
    		 	$list = $this->get_goodslist($val['shop_id'], $goodsname ,$val['shop_name'], $activitylist);
     		 	if($list){
     		 		foreach($list as $v){
     		 			$goodlist[] = $v;
     		 		}
    		 	}
    		}
    	}
    	
    	json_success($goodlist);
       
    }
    
    /**
     * get_goodslist 获取商品列表
     * @param 店铺ID  $shop_id
     * @param 商品名称  $goodsname
     * @param 店铺名称  $shopname
     * @param 买赠活动列表  $activitylist
     */
    private function get_goodslist($shop_id, $goodsname, $shopname, $activitylist){
    	//根据店铺ID获取店铺城市ID和省市ID
    	$Shop = D('Home/shop');
    	$Shopinfo = $Shop->getInfoById($shop_id);
    	if($activitylist && $Shopinfo){//按照获取区域类型过滤活动列表
    		foreach($activitylist as $k=>$v){
    			$ext = json_decode($v['range_ext'], true);
    			if($ext){
    				//检测省份类型
    				if(($v['range_type'] == 2 && !in_array($Shopinfo['shop_province'],$ext)) || ($v['range_type'] == 3 && !in_array($Shopinfo['shop_city'],$ext))){
    					unset($activitylist[$k]); //过滤该活动
    				}
    			}
    		}
    	}
    	$Shopgoods = D('Home/ShopGoods');
    	$list = $Shopgoods->getGoodsByGoodsName($shop_id, $goodsname);
    	if($list){
    		$data = array();
    		foreach($list as $key=>$val){
    			$data[$key]['goods_id'] = $val['goods_id'];
    			$data[$key]['goods_name'] = $val['goods_name'];
    			$data[$key]['goods_type'] = $val['goods_type']; //商品类型 0 哈哈镜商品 1自营商品
    			$data[$key]['act_name'] = '';
    			
    			if($activitylist){
    				foreach($activitylist as $value){
    					$goods_ext = json_decode($value['goods_ext']);//限制数据
    					if($value['goods_type'] == 2){//限制品类
    						if(in_array($val['shopgoods_sort'], $goods_ext->ids) && !in_array($val['goods_id'], $goods_ext->exclude_goods)){    							
    							$data[$key]['act_name'] = $value['act_name'];
    						}
    					}else if($value['goods_type'] == 3){//限制商品
    						if(in_array($val['goods_id'], $goods_ext->ids)){
    							$data[$key]['act_name'] = $value['act_name'];
    						}
    					}
    				}
    			}
    			
    			if($val['goods_type']){
    				$data[$key]['goods_weight'] = $val['goods_spec']; //重量。自营商品规格(ml)
    				$data[$key]['goods_unit'] = ''; //HHJ商品  规格单位(盒)
    				$data[$key]['goods_pungent'] = $val['goods_brandname']; //HHJ商品  规格口味
    			}else{
    				$data[$key]['goods_weight'] = $val['goods_weight']; //重量。HHJ商品
    				$data[$key]['goods_unit'] = $val['goods_unit']; //HHJ商品  规格单位(盒)
    				$data[$key]['goods_pungent'] = get_goods_pungent($val['goods_pungent']); //HHJ商品  规格口味
    			}
    			$data[$key]['goods_price'] = $val['shopgoods_price'];
    			$data[$key]['goods_original_price'] = $val['shopgoods_price'];
    			if($val['shopgoods_price']>0){
    				$data[$key]['goods_original_price'] = $val['shopgoods_oprice'];
    			}
    			$data[$key]['shop_id'] = $val['shopgoods_shop'];
    			$data[$key]['goods_status'] = $val['shopgoods_status'];
    			$data[$key]['goods_stockout'] = $val['shopgoods_stockout'];
    			$data[$key]['shop_name'] = $shopname;
    			$data[$key]['goods_pic'] = C('IMG_HTTP_URL').$val['goods_pic3'];
    		}
    		
    		$list = $data;
    	}	
    	return $list;
    }    
    
    /**
     * 根据区域ID返回店铺信息
     * area_id=15&num=10
     */
    public function area_shop(){
    
    	$num = I('post.num', 300); //返回数量
    	$city_id = I('post.city_id', 0); //城市id
    	$area_id = I('post.area_id', 0); //区域id
    	
    	//城市信息不存在
    	if(empty($city_id))json_error('20506', array('msg'=>C('ERR_CODE.20506')));
    	 
    	
    	$Shop = D('Home/Shop');
    	$City = D('Home/City');
    	$list = $Shop->getShopListByArea($city_id, $area_id, $num);
    	if($list){
    		//对信息重组
    		$_vip_list = array(); //vip店
    		$_list = array(); //非vip店
    		$city = null;
    		$city = $City->getInfoById($city_id);
    		foreach ($list as $val){
    			$data = array();
    			$data['shop_id'] = $val['shop_id'];
    			$data['shop_name'] = $val['shop_name'];
    			$data['shop_avatar'] = C('IMG_HTTP_URL').$val['shop_avatar'];
    			$data['shop_avatar'] = str_replace('_default.png','_default3.png?ddd', $data['shop_avatar']);
    			//$data['shop_avatar'] = C('IMG_HTTP_URL').'shop_avatar/_default3.png';//店铺图标  (替换后的店铺默认图片)
    			$data['shop_orderphone1'] = $val['shop_orderphone1'];
    			$data['shop_orderphone2'] = $val['shop_orderphone2'];
    			$data['shop_deliverscope'] = $val['shop_deliverscope'];
    			$start = get_passtime_str($val['shop_opentime1']); //店铺营业时间开始
    			$end =  get_passtime_str($val['shop_opentime2']); //店铺营业时间结束
    			$data['shop_opentime'] = $start.'-'.$end;  //营业时间端
    			$delivertime_start = get_passtime_str($val['shop_delivertime1']); //配送时间开始
    			$delivertime_end = get_passtime_str($val['shop_delivertime2']); //配送时间结束
    			$data['shop_delivertime'] = $delivertime_start.'-'.$delivertime_end;
    			$data['shop_deliverfee'] = $val['shop_deliverfee'];
    			$data['shop_updeliverfee'] = $val['shop_updeliverfee'];
    			if($val['shop_isvip'] == 1 && $val['shop_type'] == 0){
    				$data['shop_isvip'] = 1; //vip网店
    			}else if($val['shop_isvip'] == 0 && $val['shop_type'] == 0){
    				$data['shop_isvip'] = 2; //普通网店
    			}else if($val['shop_type'] == 1){
    				$data['shop_isvip'] = 3; //代售点
    			}
    			$data['shop_totalordercount'] = $val['shop_totalordercount'];
    			$data['shop_address'] = $val['shop_address']; //店铺地址
    			$data['shop_baidux'] = $val['shop_baidux']; //百度地图坐标（经度）
    			$data['shop_baiduy'] = $val['shop_baiduy']; //百度地图坐标（纬度）
    			//获取店铺所在的城市名
    			if($city){
    				$data['city_name'] = $city['city_name']; //城市名
    			}else{
    				$data['city_name'] = ''; //城市名
    			}
    			$data['score'] = $val['score'];//店铺评分
    
    			if( $val['shop_isvip'] == 1 && $val['shop_type'] == 0){ //vip店
    				$_vip_list[] = $data;
    			}else if($val['shop_isvip'] != 1){
    				$_list[] = $data;
    			}
    		}
    
    		//合并数组
    		$list = array_merge($_vip_list, $_list);
    	}
    	 
    	if($list === false){ //数据库查询失败
    		json_error(10201, array('msg'=>C('ERR_CODE.10201')));
    	}else{
    		json_success($list);
    	}
    }
    
    /**
     * 店铺促销消息
     */
    public function get_promotion(){
    	$shop_id = I('post.shop_id', 0);//店铺ID    	
    	if(empty($shop_id)) json_error(20601, array('msg'=>C('ERR_CODE.20601')));//店铺ID不能为空
    	
    	$data = array();
    	$Promotion = D('Home/Promotion');
    	$promotion_data = $Promotion->getLastInfo($shop_id);
    	if($promotion_data){
    		$data['img'] = C('IMG_HTTP_URL').$promotion_data['promotion_pic'];
    		$data['txt'] = $promotion_data['promotion_content'];    		
    	}else{
    		$Banner = D('Home/banner');
    		$banner_list = $Banner->getAdList('1', '3');
    		if(is_array($banner_list) && count($banner_list)>0){
    			$data['img'] = $banner_list[0]['pic'];
    			$data['txt'] = '';
    		}
    	}	
    	
    	json_success($data);
    } 
    
}