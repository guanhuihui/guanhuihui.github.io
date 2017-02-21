<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>领取成功</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="/Public/css/link.css">
</head>
<body>
	<div class="wrap_order wrap_ordero">
		<div class="order_suc" id="order_suc">
			<img src="/Public/image/xiao.png" class="blocks" alt="">
			<p class="order_p1o" id="order_p1">领取成功</p>
			<p class="order_p2o" id="order_p2" style="">恭喜您领取到2元购买哈哈镜凉面优惠券</p>
		</div>
		<div class="order_info">
			<div class="orderInf_drw">
				<a href="http://a.app.qq.com/o/simple.jsp?pkgname=com.new_hahajing.android">
					<img src="/Public/image/drw_icon.png" alt="">
				</a>
			</div>
			<div class="orderInf_s">
				<div class="orderInf_si">
					<p>长按关注公众号</p>
					<p>使用App或公众号下单享优惠</p>
				</div>
				<div class="orderInf_Img disBox">
					<div class="Imgs1 Imgs">
						<span class="blocks">
							<img src="/Public/image/er_icon.png" alt="">
						</span>
						<p>哈哈镜 官方微信</p>
					</div>
					<div class="Imgs2 Imgs">
						<span class="blocks">
							<img src="/Public/image/er_icon2.png" alt="">
						</span>
						<p>长按指纹 识别二维码</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script>
	<script src="/Public/js/lib/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/Public/js/lib/jweixin.js"></script>
	<script type="text/javascript" src="/Public/js/common.js"></script>
	<script type="text/javascript">
		var url = window.location.href;
		weixins(url,"Activity");
	</script>
	<script>
		function onBridgeReady(){
			WeixinJSBridge.call('hideOptionMenu');
		}
		if (typeof WeixinJSBridge == "undefined"){
			if( document.addEventListener ){
				document.addEventListener('WeixinJSBridgeReady', onBridgeReady, false);
			}else if (document.attachEvent){
				document.attachEvent('WeixinJSBridgeReady', onBridgeReady);
				document.attachEvent('onWeixinJSBridgeReady', onBridgeReady);
			}
		}else{
			onBridgeReady();
		}
</script>
</body>
</html>