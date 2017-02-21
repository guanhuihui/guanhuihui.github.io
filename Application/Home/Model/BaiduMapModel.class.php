<?php

namespace Home\Model;

class BaiduMapModel {
	


	public function __construct() {
	
	}
	
	static private function lw($a, $b, $c){
		$r = max($a, $b);
		$r = min($a, $c);
		return $r;
	}
	
	static private function ew($a, $b, $c){
		while($a > $c){
			$a -= $c - $b;
		}
		while($a < $b){
			$a += $c - $b;
		}
		return $a;
	}
	
	static private function oi($a){
		return pi() * $a / 180;
	}
	
	
	static private function Td($a, $b, $c, $d){
		return 6370996.81 * acos(sin($c) * sin($d) + cos($c) * cos($d) * cos($b - $a));
	}
	
	//参数说明
	//$pa ~位置A的百度坐标
	//$pb ~位置B的百度坐标
	//返回距离（米）
	public function getDistance($pa, $pb){
		$a_lng = $pa[0];
		$a_lat = $pa[1];
		$b_lng = $pb[0];
		$b_lat = $pb[1];
	
		if(empty($pa) || empty($pb)) return 0;
	
		$a_lng = self::ew($a_lng, -180, 180);
		$a_lat = self::lw($a_lat, -74, 74);
		$b_lng = self::ew($b_lng, -180, 180);
		$b_lat = self::lw($b_lat, -74, 74);
	
		return self::Td(self::oi($a_lng), self::oi($b_lng), self::oi($a_lat), self::oi($b_lat));
	}
	
	//通过百度坐标，返回地址
	//http://api.map.baidu.com/geocoder?location=39.990912172420714,116.32715863448607&coord_type=gcj02&output=html&src=yourCompanyName|yourAppName
	public function getAddressByXY($x, $y){
	
		$loc = $y.','.$x;
		$src = 'Hahajing';
	
		$url = 'http://api.map.baidu.com/geocoder?location='.$loc.'&coord_type=gcj02&src='.$src;
	
		$r = curl_get($url);
		$r = simplexml_load_string($r, 'SimpleXMLElement', LIBXML_NOCDATA);
	
		if($r){
			$addr     = $r->result->addressComponent;
			$citycode = (string)$r->result->cityCode;
				
			if(!empty($citycode)){
				$province = (string)$addr->province;
				$city     = (string)$addr->city;
				$area     = (string)$addr->district;
	
				$address  = array($province, $city, $area);
				return $address;
			}else{
				return -1;//没有解析出地址
			}
		}else{
			return -2;//没有返回值
		}
	
	}
	
	
}

?>