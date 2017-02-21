<?php
// +----------------------------------------------------------------------
// | hahajing [ 北京哈哈镜电子商务有限公司 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015 http://www.hahajing.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: zhangpp at 2015/10/23
// +----------------------------------------------------------------------

namespace Home\Model;

/**
 * 产品模型
 */
class GoodsModel{
	
	/**
	 * 产品信息
	 */
	public function getInfoById($goods_id){
		if(empty($goods_id)){
			return false;
		}
	
		$Goods = M('Goods');
		$where['goods_id'] = $goods_id;
		$data = $Goods->where($where)->find();
	
		return $data;
	}
	
	/**
	 * 添加产品信息
	 */
	public function add($data){
		if (empty($data)) {
			return false;
		}
	
		$Goods = M('Goods');
		$result = $Goods->data($data)->add();
	
		return $result;
	}
	
	/**
	 * 删除产品
	 */
	public function del($goods_id) {
		if (empty($goods_id)) {
			return false;
		}
	
		$Goods = M('Goods');
		$where['area_id'] = $goods_id;
		$result = $Goods->where($where)->delete();
	
		return $result;
	}
	
	/**
	 * 修改产品信息
	 */
	public function edit($data){
		if (empty($data)) {
			return false;
		}
	
		if(isset($data['goods_id'])){
			$goods_id = $data['goods_id'];
			unset($data['goods_id']);
	
			$Goods = M('Goods');
			$result = $Goods->where(" goods_id = %d ",$goods_id)->data($data)->save();
			return $result;
		}
		return false;
	}
	
	/**
	 * Table_promotion::goodsList()商品列表
	 *
	 * @param mixed $type 商品类型 0--哈哈镜商品 1--自营商品
	 * @param mixed $sort 商品所属分类 0--所有分类
	 * @return
	 */
	public function getList($type = 0, $sort = 0){
			
		$Goods = M('Goods');
		$map = array();
		$map['goods_type'] = $type;
		$map['goods_status'] = 0;
		$map['goods_stock'] = 1;
		if($sort){
			$map['goods_sort'] = $sort;
		}		
		
		$list = $Goods->where($map)->select();
		if($list){
			$_list = array();
			foreach ($list as $val){				
				$r[] = self::struct($val);
			}			
			return $_list;			
		}		
		return 0;
	}


	/**
	 * 查询商品信息
	 */
	public function getGoodsInfoBySearch($type='', $search){

		$Goods = M('Goods');
		$map = array();
		if($search){			
			$map['goods_name'] = array('like','%$search%');
		}
		if(in_array($type, array(0, 1)) && is_numeric($type)){
			$map['goods_type'] = $type;
		}
	
		$list = $Goods->where($map)->select();
		return $list;	
	}	
	
	/**
	 * 根据商品分类获取商品展示
	 *
	 * @param mixed $type 商品类型
	 * @param mixed $sort 商品分类
	 * @return
	 */
	public function getGoodsShowBySort($type, $sort){

		$Goods = M('Goods');
		$map = array();
		$map['goods_code'] = array('neq', '000000');
		$map['goods_status'] = 0;
		$map['goods_type'] = $type;
		
		if($sort){
			$map['goods_sort'] = $sort;
		}
		
		$list = $Goods->where($map)->group('goods_name')->order('goods_order asc')->select();
		if($list){
			$r = array();
			foreach($list as $key => $val){
				$r[$key] = self::struct($val);
			}
			return $r;
		}else{
			return 0;
		}
	}
	
	public function struct($data){
	   	$r = array();
     	
     	$r['gid']               = $data['goods_id'];
		$r['gname']             = $data['goods_name'];
		$r['gsort']             = $data['goods_sort'];
		$r['gcode']             = $data['goods_code'];
		$r['gtype']             = $data['goods_type'];
		$r['gbarcode']          = $data['goods_barcode'];
		$r['gqrcode']           = $data['goods_qrcode'];
		$r['gpic1']             = $data['goods_pic1'];
		$r['gpic2']             = $data['goods_pic2'];
		$r['gpic3']             = $data['goods_pic3'];
        $r['gprice1']           = $data['goods_price1'];
        $r['gprice2']           = $data['goods_price2'];
		$r['gprice']            = $data['goods_price'];
		$r['gspec']             = $data['goods_spec'];
		$r['gweight']           = $data['goods_weight'];
		$r['gunit']             = $data['goods_unit'];
		$r['gpackage']          = $data['goods_package'];
		$r['gstatus']           = $data['goods_status'];
		$r['gbrand']            = $data['goods_brand'];
		$r['gbrandname']        = $data['goods_brandname'];
		$r['gpungent']          = $data['goods_pungent'];
		$r['gdesc']             = $data['goods_desc'];
		$r['ginfo']             = $data['goods_info'];
		$r['gpromotionwords']   = $data['goods_promotionwords'];
		$r['gseotitle']         = $data['goods_seotitle'];
		$r['gseokeyword']       = $data['goods_seokeyword'];
		$r['gseodesc']          = $data['goods_seodesc'];
		$r['gaddtime']          = $data['goods_addtime'];
		$r['gedittime']         = $data['goods_edittime'];
		$r['glikecount']        = $data['goods_likecount'];
		$r['gorder']            = $data['goods_order'];
        
        return $r;
	}


	/**
	 * @param mixed $newname 哈哈镜商品的名称
	 * @return
	 */
	public function getGoodsPungentBySort($newname){
		
		$Goods = M('Goods');
		$map['goods_name'] = $newname;
		$list = $Goods->where($map)->order('goods_id asc')->select();
		
		$pungent = '';
		if($list){
			$pungent_arr = C('GOODS_PUNGENT');
			foreach($list as $val){
				$pungent .= $pungent_arr[$val['goods_pungent']].' ';
			}
		}
		
		return $pungent;
	}
	
	/**
	 * 查询上一个、下一个商品
	 * // TODO: 返回上一条和下一条，还是一次性返回多条？
	 * @param mixed $direct  方向：-1表示上一条 1表示下一条
	 * @param mixed $type    类型：0--哈哈镜；1--自营商品
	 * @param integer $gid   当前的商品ID，为0时查询第1个商品。
	 * @return
	 */
	public function getPreNextGoods($direct, $type = 0, $gid = 0){
	
		$Goods = M('Goods');
		//$gid=0时，查询第一个商品，限制limit 1提高效率
		if($gid == 0 && $type == 0){
			$map = array();
			$map['goods_type'] = $type;
			$map['goods_status'] = 0;
			
			$data = $Goods->where($map)->group('goods_name')->order('goods_order asc, goods_id desc')->find();	
			if($data){	
				return $data;
			}	
		}else if($gid == 0 && $type == 1){		
			$map = array();
			$map['goods_type'] = $type;
			$map['goods_status'] = 0;
				
			$data = $Goods->where($map)->order('goods_order asc, goods_id desc')->find();
			if($data){	
				return $data;
			}			 
		}else if($gid > 0 && $type == 0){
			//哈哈镜商品根据名称查询			
			$map = array();
			$map['goods_type'] = $type;
			$map['goods_status'] = 0;
			
			$list = $Goods->where($map)->group('goods_name')->order('goods_order asc, goods_id desc')->find();
			$count = count($list);
			if($list){
				foreach($list as $k => $v){
					if($v['goods_id'] == $gid){
						if($direct == -1){//上一个
							if($k > 0)
								return $list[$k-1];
							else
								return $list[$count-1];
						}elseif($direct == 1){//下一个
							if($k < $count - 1)
								return $list[$k+1];
							else
								return $list['0'];
						}
					}
				}					
			}	
		}else if($gid > 0 && $type == 1){
			//自营商品根据商品id查询
			$map = array();
			$map['goods_type'] = $type;
			$map['goods_status'] = 0;
			$list = $Goods->where($map)->order('goods_order asc, goods_id desc')->find();

			$count = count($list);
			foreach($list as $k => $v){
				if($v['goods_id'] == $gid){
					if($direct == -1){
						if($k > 0)
							return $list[$k-1];
						else
							return 0;
					}elseif($direct == 1){
						if($k < $count - 1)
							return $list[$k+1];
						else
							return 0;
					}
				}
			}
		}	
	
		return 0; //没有了
	}

	/**
	 * 查询商品总量
	 *
	 * @param integer $type
	 * @param string $sort
	 * @return
	 */
	public function getGoodsCount($type = 0, $sort = ''){
		
		$Goods = M('Goods');
		$map = array();
		$map['goods_type'] = $type;
		if($sort){
			$map['goods_sort'] = $sort;
		}
		
		$count = $Goods->where($map)->count();
		return $count;
	}
	
	/**
	 * GoodsOnAdmin::getGoodsList()get商品列表
	 *
	 * @param integer $page
	 * @param integer $pagesize
	 * @param integer $type商品类型 0--哈哈镜商品 1--自营商品
	 * @param integer $where 筛选条件，默认为空
	 * @param integer $reorder 默认按照goods_order排序
	 * @param integer $by 默认为asc 按照升序排列
	 * @return
	 */
	public function getGoodsList($type = 0, $sort = '', $page = 1, $pagesize = 20){
		
		$startrow = ($page - 1) * $pagesize;
		
		$Goods = M('Goods');
		$map['goods_type'] = $type;
		if($sort){
			$map['goods_sort'] = $sort;
		}
		
		$list = $Goods->where($map)->order('goods_order asc,goods_id desc')->limit("$startrow, $pagesize")->select();

		return $list;	
	}
	
	/**
	 * get商品信息（通过条码）
	 */
	public function getGoodsInfoByBarcode($barcode){
		if(empty($barcode)){
			return false;
		}
		
		$Goods = M('Goods');
		$map['goods_barcode'] = $barcode;
		$data = $Goods->where($map)->find();
	
		return $data;	
	}
	
	/**
	 * get商品列表
	 *
	 * @param integer $page
	 * @param integer $pagesize
	 * @param integer $where 筛选条件，默认为空
	 * @return
	 */
	public function GoodsList($where='', $sort = '', $page = 1, $pagesize = 20){
		
		$startrow = ($page - 1) * $pagesize;
		
		$Goods = M('Goods');
		
		$list = $Goods->where($where)->order('goods_order asc,goods_id desc')->limit("$startrow, $pagesize")->select();
	
		return $list;
	}
	
	/**
	 * get商品列表
	 *
	 * @param integer $page
	 * @param integer $pagesize
	 * @param integer $where 筛选条件，默认为空
	 * @return
	 */
	public function GoodCount($where=''){
		
		$Goods = M('Goods');
	
		$count = $Goods->where($where)->count();
	
		return $count;
	}
	
	/**
	 * get_Privilege_GoodsLists() 优惠的商品列表
	 * @param mixed $type 商品类型 0--哈哈镜商品 1--自营商品
	 * @param mixed $sort 商品所属分类 0--所有分类
	 * @return
	 * @return
	 */
	public function get_Privilege_GoodsLists($type = 0, $sort = 0){
		$Goods = M('Goods');
		$map = array();
		$map['goods_type'] = $type;
		$map['goods_status'] = 0;
		$map['goods_stock'] = 1;
		if($sort){
			$map['goods_sort'] = $sort;
		}
		
		$list = $Goods->where($map)->select();
		return $list;	
	}
	
	/**
	 * 获取哈哈镜商品和哈优选商品并更新到被更新的网店
	 */
	public function updateShopGoods($shop_id){
		$where = 'goods_type = 0 OR (`goods_sort` IN (15,16,17,18) AND goods_status = 0)';
		$Goods = M('Goods');
		$goodslist = $Goods->where($where)->order('goods_order')->select();
		$Shop = M('Shop');
		$map['shop_id'] = $shop_id;
		$shopInfo = $Shop->where($map)->find();
		//区域折扣
		$Region = M('Region');
		$arr['region_city'] = $shopInfo['shop_city'];
		$regionInfo = $Region->where($arr)->find();
		
		
		$Shopgoods = D('Home/ShopGoods');
		//更新网店商品
		foreach($goodslist as $val){
			//写入数据库数据
			$gprice = $val['goods_price']*$regionInfo['region_num'];
			$param = array(
					'shopgoods_shop' => $shop_id,
					'shopgoods_goods' => $val['goods_id'],
					'shopgoods_sort' => $val['goods_sort'],
					'shopgoods_type' => $val['goods_type'],
					'shopgoods_price' => $gprice,
					'shopgoods_status' => $val['goods_status'],
					'shopgoods_order' => $val['goods_order']
			);
			$brr['shopgoods_goods'] = $val['goods_id'];
			$brr['shopgoods_shop'] = $shop_id;
			$sgoods = $Shopgoods->getShopGoods($brr);
			if($sgoods){
				$param['shopgoods_id'] = $sgoods[0]['shopgoods_id'];
				$Shopgoods->edit($param);
			}else{
				$Shopgoods->add($param);
			}
		}
	}
	
	/**
	 * get商品数量
	 *
	 * @param integer $page
	 * @param integer $pagesize
	 * @param integer $where 筛选条件，默认为空
	 * @return
	 */
	public function GoodsCount($where){
		
		$Goods = M('Goods');
	
		$list = $Goods->where($where)->count();
	
		return $list;
	}
}