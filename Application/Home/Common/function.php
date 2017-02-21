<?php
/**
 * 根据id获取哈哈镜自有产品口味
 */
function get_goods_pungent($pungent_id){
	$goods_pungent_array = C('GOODS_PUNGENT');
	$pungent_name = $goods_pungent_array[$pungent_id];
	if(empty($pungent_name)){
		$pungent_name = '';
	}

	return $pungent_name;
}
function filter_activity($activity_list, $province_id, $city_id){
	$list = array();

	if($activity_list){
		foreach($activity_list as $v){
			$ext = json_decode($v['range_ext']);
			if($ext){
				//检测省份类型
				if($v['range_type'] == 1){//全国
					$list[] = $v;
				}else if($v['range_type'] == 2 && in_array($province_id,$ext)){
					$list[] = $v;
				}else if($v['range_type'] == 3 && in_array($city_id,$ext)){
					$list[] = $v;
				}
			}
		}
	}

	return $list;
}
?>