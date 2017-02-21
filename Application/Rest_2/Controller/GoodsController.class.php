<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liukw at 2015/11/19
// +----------------------------------------------------------------------

namespace Rest_2\Controller;

/**
 * 商品控制器
 */
class GoodsController extends UserFilterController {
	
	public function index(){
		echo '';
    }
    
    /**
     * 获取商户商品列表
     */
    public function shop_goods(){
    	$shop_id = I('post.shop_id', 0); //店铺id
    	$cat_id = I('post.cat_id', 0); //类别id
    	$son_cat_id = I('post.son_cat_id', 0); //二级分类id
    	$hidden_goods = I('post.hidden_goods', 0); //仅含分类
    	
    	//$key = C('CACHE_SHOP_GOODS').'_'.$shop_id;
    	//$goods_list = S($key);
    	//if($goods_list === false){ //缓存不存在
    	//写入缓存(缓存30分钟)
    	//S($key, $goods_list, 60*30);
    	//}

    	/* 自定义一级分类 */
    	$cat_list = array();
    	$cat_list[] = C('GOODS_CATEGORY.1');
		$cat_list[] = C('GOODS_CATEGORY.2');
	    $cat_list[] = C('GOODS_CATEGORY.3');
		$cat_list[] = C('GOODS_CATEGORY.4');
	    $cat_list[] = C('GOODS_CATEGORY.5');
		$cat_list[] = C('GOODS_CATEGORY.6');
		$cat_list[] = C('GOODS_CATEGORY.7');
		$cat_list[] = C('GOODS_CATEGORY.8');
    	
	    $Shopgoods = D('Home/ShopGoods');
	    $goods_list = $Shopgoods->getShopGoodsList($shop_id);
	    
	    if($goods_list === false){ //数据库查询失败
	    	json_error(10201, array('msg'=>C('ERR_CODE.10201')));
	    }
    	
	    $Shop = D('Home/shop'); 
	    $shopinfo = $Shop->getInfoById($shop_id);//获取店铺城市信息
	    
	    //根据店铺地理未知获取可用的活动列表信息
	    $activity_list = array();
	    if($shopinfo){
	    	
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
	    }
	   	
    	$list = array();
    	foreach ($cat_list as $key=>$val){
    		if($cat_id){ //一级类别过滤
    			if($val['cat_id'] != $cat_id) continue;
    		}
			
    		$_list = array(); //二级列表
    		if($goods_list){
    			$last_cat_id = 0;
    			$goods_key = -1;
    			foreach ($goods_list as $k=>$v){   
    				
    				if(!in_array($shopinfo['shop_city'],array(133,104))){//非北京,上海VIP店的 哈优选中的商品不显示
    					 if(in_array($v['shopgoods_sort'],array(15,16,17,18,36))){
    					 	continue;
    					 }	
    				}else{//北京,上海普通网店的 哈优选中的商品不显示
    					if($shopinfo['shop_isvip'] == 0  && in_array($v['shopgoods_sort'],array(15,16,17,18,36))){
    						continue;
    					}
    				} 	
    							
    				if(in_array($v['shopgoods_sort'], $val['cat_ids'])){    					   
    					//生成子类项 ---------------- begin
    					if($son_cat_id){ //二级类别过滤
    						if($v['shopgoods_sort'] != $son_cat_id) continue;
    					}    					
    					
    					if($last_cat_id != $v['shopgoods_sort']){
    						$goods_key += 1;
    						$last_cat_id = $v['shopgoods_sort'];    						    						
    						$_list[$goods_key]['son_cat_id'] = $v['shopgoods_sort'];
    						$_list[$goods_key]['cat_name'] = $v['sort_name']; 
    					}
    					
    					if($hidden_goods) continue; //隐藏商品
    							
    					$_goods = array();
    					$_goods['act_name'] = '';   //活动名称
    					$_goods['secondary_names'] = ''; //活动次名
    					//根据商品ID获取活动名称
    					if($activity_list){
    						foreach($activity_list as $value){
    							$goods_ext = json_decode($value['goods_ext']);//限制数据   	
								if(($value['goods_type'] == 2 && in_array($v['shopgoods_sort'], $goods_ext->ids) && !in_array($v['shopgoods_goods'], $goods_ext->exclude_goods)) || ($value['goods_type'] == 3 && in_array($v['shopgoods_goods'], $goods_ext->ids))){
									if($value['act_type'] == 3){
										   if($v['shopgoods_price']>= 30){
										    	$_goods['act_name'] = $value['secondary_names'].'啤酒一听';
										   }else{
										    	$_goods['act_name'] = $value['secondary_names'].'非卖品一盒';
										   }
									
									}else{
										   $_goods['act_name'] = $value['act_name'];
									}
									$_goods['secondary_names'] = '';
									
	    						}
    						}
    					}
    					$_goods['goods_id'] = $v['shopgoods_goods']; //商品id
    					$_goods['goods_name'] = $v['goods_name']; //商品名称
    					$_goods['goods_price'] = $v['shopgoods_price']; //商品现价
    					
    					$_goods['goods_original_price'] = $v['shopgoods_price']; //折前价
    					if($v['shopgoods_oprice']>0){
    						$_goods['goods_original_price'] = $v['shopgoods_oprice']; //折前价
    					}    					

						if($v['shopgoods_sort']>5){
							$_goods['goods_weight'] = $v['goods_spec']; //重量。自营商品规格(ml)
							$_goods['goods_unit'] = ''; //HHJ商品  规格单位(盒)
							$_goods['goods_pungent'] = $v['goods_brandname']; //HHJ商品  规格口味
						}else{
							$_goods['goods_weight'] = $v['goods_weight']; //重量。HHJ商品
							$_goods['goods_unit'] = $v['goods_unit']; //HHJ商品  规格单位(盒)
							$_goods['goods_pungent'] = get_goods_pungent($v['goods_pungent']); //HHJ商品  规格口味
						}
    					
    					$_goods['goods_pic'] = C('IMG_HTTP_URL').$v['goods_pic3'];
    					$_goods['goods_status'] = $v['shopgoods_status']; //商品状态
    					$_goods['goods_type'] = $v['goods_type']; // 商品类型  1 自营  0 哈哈镜产品
    					$_goods['goods_stockout'] = $v['shopgoods_stockout']; //是否缺货
    					//暂时过滤香烟产品
    					/*
    					if(!strpos($_goods['goods_name'],'烟')){
    						$_list[$goods_key]['goods_list'][] = $_goods;    
    					}*/	
    					$_list[$goods_key]['goods_list'][] = $_goods;
    					//生成子类项 ---------------- end
    				}
    			}    			  			
    		}
    		
    		$list[] = array('cat_id' => $val['cat_id'],'cat_name' => $val['cat_name'], 'cat_type' => $val['cat_type'], 'pic'=>$val['pic'], 'list' => $_list);
    	}    
	
    	//写入缓存(缓存30分钟)
    	//S($key, $goods_list, 60*30);
    	json_success($list);
    }
    
}