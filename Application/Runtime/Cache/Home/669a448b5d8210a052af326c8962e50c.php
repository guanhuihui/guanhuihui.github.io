<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>领取哈哈镜优惠券</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="/Public/css/link.css">
</head>
<body>
	<div class="wrap">
		<form id="autocomplete-form" method="post" action="">
			<div class="wrap_size" id="wrap_size">
				<p class="sizep1">请输入手机号</p>
				<p class="size_p">（作为登录哈哈镜商城账号）</p>
				<span class="size_spans">立即领取2元购买哈哈镜凉面优惠券</span>
				<input type="tel" style="font-size:16px;" class="size_input styleinput" placeholder="请输入手机号"> 
			</div>
			<div class="buttons_div">
				<p class="buttons" id="btn"><img src="/Public/image/anniu.png" alt=""></p>
			</div>
			<div class="wrap_ts"><img src="/Public/image/tu.png" alt=""></div>
		</form>
	</div>
	<script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script>
	<script src="/Public/js/lib/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/Public/js/lib/jweixin.js"></script>
	<script type="text/javascript" src="/Public/js/common.js"></script>
	<script type="text/javascript">
	var error_code = $('#error_code'),
		error_msg = $('#error_msg'),
		btn = $('#btn');
		var url=window.location.href;
		btn.off('click');
			btn.on('click',function(){
				$('input').blur();
				setTimeout(function(){
					loaging.close();
					loaging.init('加载中，请稍后...');
				    var phones = $('.size_input').val(),
				        myreg = /^1[3|4|5|7|8]\d{9}$/;
				    if(!myreg.test(phones)){ 
				        loaging.close();
				        loaging.prompts('请输入有效的手机号码！');
				        return false; 
				    }
				  	$.ajax({
				  		url: '/ActivityTwo/get_ticket_2',
				  		type: 'POST',
				  		dataType: 'json',
				  		data: {phone:phones},
				  		success:function(re){
				  			if(re.result == 'ok') {
				  				window.location.href="/ActivityTwo/index_ok";
					  		}else{
					  			loaging.close();
			                	loaging.btn(re.msg);
			              	}
				  		},error:function(){
				  			loaging.close();
				  		}
				  	})
				},300);
			})
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