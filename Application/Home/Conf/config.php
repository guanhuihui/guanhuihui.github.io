<?php
return array(
	//'配置项'=>'配置值'
	'DEFAULT_CONTROLLER'=>'Load',
	//获取根路径
	'WWW_ROOT'=>dirname(dirname(dirname(dirname(__FILE__)))),
	//'配置项'=>'配置值'
	'SESSION_AUTO_START' => true, //是否开启session	
	//商品辣度
	'GOODS_PUNGENT' => array(
			0 => '不辣',
			1 => '微辣',
			2 => '正辣',
			3 => '辣'
	),
	
	//商品分类
	'GOODS_CATEGORY' => array(
			
			/**自定义商品分类**/
			'1'=> '鸭系',
			'2'=> '素食',
			'3'=> '海鲜',
			'4'=> '泡菜',
			'5'=> '其他',
			
	),
		
	//订单状态
	'ARRAY_ORDER_STATUS' => array(
		'1' => '新订单',
		'2' => '商户拒单',
		'3' => '已转单',
		'4' => '转单确认',
		'5' => '已发货',
		'6' => '用户取消',
		'7' => '后台取消',
		'8' => '已完成'
	),
	
	//支付类型
	'ORDER_PAY_TYPE' => array(
			'10' => '微信支付',
			'20' => '支付宝支付',
			'30' => '银行卡支付',
			'40' => '货到付款',
			'50' => '转账汇款',
			'90' => '其他'
	),
	
	//配送方式
	'ORDER_DELIVER_TYPE' => array(
			'0' => '送货上门',
			'1' => '到店自提'
	),
	//消息发送方式
	'ARRAY_SENDMSG_TYPE' => array(
			1   => '单独对用户发',
			2   => '单独对商户发',
			3   => '按省对用户群发',
			4   => '按省对商户群发',
			5   => '按市对用户群发',
			6   => '按市对商户群发',
			7   => '全部对用户群发',
			8   => '全部对商户群发'
		
		),
	//支付状态
	'PAYMENT_STATUS' => array(
		'10' => '等待支付',
		'20' => '支付进行中',
		'30' => '支付成功',
		'40' => '支付失败 ',
		'50' => '退款',
		'90' => '其他'
	),

	
	//极光推送JPush参数 用户
	'JPush_IOS_appKey' => '567ac4363cbb31db26e67618',
	'JPush_IOS_masterSecret' => 'c7449010d4416c2b8ec46584',
		
	'JPush_ANDROID_appKey'       => 'e78dcf0bcb7994f3b6c8a9ee',
	'JPush_ANDROID_masterSecret' => '3bf43ad32fba6ec72d328d1e',
		
	'JPush_url' => 'https://api.jpush.cn/v3/push',
	//极光推送JPush参数 商户
	'JPush_SHOP_appKey' => 'a6af0cbe3623c50153542f20',
	'JPush_SHOP_masterSecret' => 'ac92721deb21f2c4d3f474cd',
);