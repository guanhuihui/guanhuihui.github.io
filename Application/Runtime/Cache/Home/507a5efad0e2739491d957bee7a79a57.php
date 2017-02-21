<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="htmls">
<head>
    <title>哈哈镜 </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="/Public/css/set.css">
	<style type="text/css">body,html{height: 100%;}#ps{width: 100%;}</style>
</head>
<body>
	<div class="wrap_log">
		<form id="autocomplete-form" class="mod-order-common login-form" onsubmit="return false;"  action="/ActivityTwo/phone_login">
			<div class="wrap_img"><img src="/Public/image/active/i_yd.png" class="Img" alt=""></div>
			<div class="wrap_logInfo">
				<span class="spans"><input name="phone" id="phones" class="phone styleinput" type="tel" placeholder="请输入手机号码" maxlength="11" value=""></span>
				<span class="log_btn spans" id="log_btn">
					<!-- <img src="/Public/image/active/i_btn.png" alt="">-->
					<p class="ps" id="ps"><input type="button" id="btn2" class="btn2 blocks styleinput" value="" readonly=""></p>
					<a class="log_a" href="/ActivityTwo/get_xieyi?url=http://www.hahajing.com/home/agreement/hhj_agreement&name=哈哈镜服务协议">点击登录即视为同意《哈哈镜服务协议》</a>
				</span>
				<span class="spans spans_last">
					<img src="/Public/image/active/i_size.png" alt="">
				</span>
			</div>
		</form>
	</div>
	<script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script>
	<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?c2d2766f7586737e9c94a580840a7bfd";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<script src="/Public/js/lib/all.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript">
		var btn = $('#btn2');
			btn.off('click');
			btn.on('click',function(){
				loaging.close();
				loaging.init('加载中，请稍后...');
				setTimeout(function(){
					$('input').blur();
				    var phones = $('#phones').val(),
				        myreg = /^1[3|4|5|7|8]\d{9}$/;
				    if(!myreg.test(phones)){ 
				        loaging.close();
				        loaging.prompts('请输入有效的手机号码！');
				        return false; 
				    }
				    loaging.close();
					document.getElementById("autocomplete-form").submit();
				},300);
			})
	</script>
</body>
</html>