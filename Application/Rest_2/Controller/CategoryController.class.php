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
 * 分类控制器
 */
class CategoryController extends UserFilterController {
	
	public function index(){
		echo '';
    }
    
    /**
     * 获取分类信息接口
     */
   	public function get_list(){
   		/**接收参数***/
   		$cate_one = I('post.cate_one', 0);  //哈哈镜卤味
   		$cate_two = I('post.cate_two', 0);  //哈哈镜优选
   		$cate_three = I('post.cate_three', 0);  //休闲食品
   		$cate_four = I('post.cate_four', 0);  //酒水烟饮 
   		$cate_five = I('post.cate_five', 0);  //蛋肉冷饮
   		$cate_six = I('post.cate_six', 0);  //日常用品 
   		$cate_seven = I('post.cate_seven', 0);  //果蔬奶品 
   		$cate_eight = I('post.cate_eight', 0);  //方便速食 
   		
   		/* 自定义一级分类 */
   		$cat_list = array();
   		if($cate_one == 1) $cat_list[] = C('GOODS_CATEGORY.1');
   		if($cate_two == 2) $cat_list[] = C('GOODS_CATEGORY.2');
   		if($cate_three == 3) $cat_list[] = C('GOODS_CATEGORY.3');
   		if($cate_four == 4) $cat_list[] = C('GOODS_CATEGORY.4');
   		if($cate_five == 5) $cat_list[] = C('GOODS_CATEGORY.5');
   		if($cate_six == 6) $cat_list[] = C('GOODS_CATEGORY.6');
   		if($cate_seven == 7) $cat_list[] = C('GOODS_CATEGORY.7');
   		if($cate_eight == 8) $cat_list[] = C('GOODS_CATEGORY.8');
   		
		if(empty($cat_list)){ //没有传参 返回所有分类
			$data = array();
			 $data[] = C('GOODS_CATEGORY.1');
		     $data[] = C('GOODS_CATEGORY.2');
			 $data[] = C('GOODS_CATEGORY.3');
			 $data[] = C('GOODS_CATEGORY.4');
			 $data[] = C('GOODS_CATEGORY.5');
			 $data[] = C('GOODS_CATEGORY.6');
			 $data[] = C('GOODS_CATEGORY.7');
			 $data[] = C('GOODS_CATEGORY.8');
			$cat_list = $data; 
		}
   		
   		return_success($cat_list);
   	}
   	
   
    
}