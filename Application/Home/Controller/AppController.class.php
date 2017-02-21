<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/12/25
// +----------------------------------------------------------------------

namespace Home\Controller;
use Think\Controller;

/**
 *	首页控制器
 */
class AppController extends CommonController {
    function _initialize() {
        parent::_initialize();
    }    
    /**
     * 帮助页面
     */
    public function help() {
    	$this->display();
    }
    
    public function detail() {
    	$shop_id = I('get.shop_id', 0);
    	$goods_id = I('get.goods_id', 0);
    	if(empty($shop_id)){
    		A('Empty')->index();
            exit();

    	}    	
    	if(empty($goods_id)){
    		A('Empty')->index();
            exit();
    	}

    	$Shop = D('Home/shop');
    	$shopinfo = $Shop->getInfoById($shop_id);//获取店铺城市信息 	
    	//根据店铺地理未知获取可用的活动列表信息
    	if($shopinfo){
    		$Activity = D('Home/Activity');
    		$activitylist = $Activity->getList(1,1);
    		//根据店铺地址信息过滤活动
    		if($activitylist){
    			foreach($activitylist as $k=>$v){
    				$ext = json_decode($v['range_ext'], true);
    				if($ext){
    					//检测省份类型
    					if(($v['range_type'] == 2 && !in_array($shopinfo['shop_province'],$ext)) || ($v['range_type'] == 3 && !in_array($shopinfo['shop_city'],$ext))){
    						unset($activitylist[$k]); //过滤该活动
    					}
    				}
    			}
    		} 

    		if(empty($activitylist)){
    			$activitylist = $activitylist = $Activity->getList(3,1);
    			//根据店铺地址信息过滤活动
    			if($activitylist){
    				foreach($activitylist as $k=>$v){
    					$ext = json_decode($v['range_ext'], true);
    					if($ext){
    						//检测省份类型
    						if(($v['range_type'] == 2 && !in_array($shopinfo['shop_province'],$ext)) || ($v['range_type'] == 3 && !in_array($shopinfo['shop_city'],$ext))){
    							unset($activitylist[$k]); //过滤该活动
    						}
    					}
    				}
    			}
    		}
    		
    	}else{
    		A('Empty')->index();
            exit();
    	}
    	
    	$Goods = D('Home/Goods');
    	$goods_data = $Goods->getInfoById($goods_id);
    	//商品活动
    	$goods_data['act_name'] = '';
    	if($goods_data){
    		if(empty($activitylist)){
    			$act_type = 3;
    			$_act_list = $Activity->getList($act_type,1);
    			$activitylist = filter_activity($_act_list, $shopinfo['shop_province'], $shopinfo['shop_city']);
    		}	    	
	    	//根据商品ID获取活动名称
	    	if($activitylist){
	    		foreach($activitylist as $value){
	    			$goods_ext = json_decode($value['goods_ext']);//限制数据
	    			
	    			if(($value['goods_type'] == 2 && in_array($goods_data['goods_sort'], $goods_ext->ids) && !in_array($goods_data['goods_id'], $goods_ext->exclude_goods)) || ($value['goods_type'] == 3 && in_array($goods_data['goods_id'], $goods_ext->ids) && !in_array($goods_data['goods_id'], $goods_ext->exclude_goods))){
	    				if($value['act_type'] == 3){
	    					if($goods_data['goods_price']>= 30){
	    						$goods_data['act_name'] = $value['secondary_names'].'啤酒一听';
	    					}else{
	    						$goods_data['act_name'] = $value['secondary_names'].'非卖品一盒';
	    					}
	    				}else{
	    					$goods_data['act_name'] = $value['act_name'];
	    				}
	   
	    			}
	    			
	    		}
	    	}
    	}else {
    		A('Empty')->index();
            exit();
    	}

    	//商品价格
    	$goods_data['price'] = '0.00';  
    	$goods_data['oprice'] = '0.00';
    	$Shopgoods = D('Home/ShopGoods');
    	$shop_goods_data = $Shopgoods->getInfoById($shop_id, $goods_id);
    	if($shop_goods_data){
    		$goods_data['price'] = $shop_goods_data['shopgoods_price'];
    		$goods_data['oprice'] = $goods_data['price'];
    		if($shop_goods_data['shopgoods_oprice']>0){
    			$goods_data['oprice'] = $shop_goods_data['shopgoods_oprice'];
    		}
    	}else {
    		A('Empty')->index();
            exit();
    	}
    	
    	if($goods_data['goods_sort']>5){
    		$goods_data['goods_weight'] = $goods_data['goods_spec']; //重量。自营商品规格(ml)
    		$goods_data['goods_unit'] = ''; //HHJ商品  规格单位(盒)
    		$goods_data['goods_pungent'] = $goods_data['goods_brandname']; //HHJ商品  规格口味
    	}else{
    		$goods_data['goods_weight'] = $goods_data['goods_weight']; //重量。HHJ商品
    		$goods_data['goods_unit'] = $goods_data['goods_unit']; //HHJ商品  规格单位(盒)
    		$goods_data['goods_pungent'] = get_goods_pungent($goods_data['goods_pungent']); //HHJ商品  规格口味
    	}    		
    	$goods_data['goods_pic'] = C('IMG_HTTP_URL').$goods_data['goods_pic3'];
    	$goods_data['goods_brand'] = $goods_data['goods_brand']; //商品品牌
    	$this->assign('goods_data', $goods_data);
        $this->assign('shop_id', $shop_id);
        $this->assign('goods_id', $goods_id);
    	$this->display();
    }

}