<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜凉面加鸭锁骨购买</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="/Public/css/link.css">
	<style type="text/css">#wrap_order .order_suc img{width: 16%;}#wrap_order .order_sizes{color: #EF7C21;text-align: center;line-height: 34px;}.wrap_order .order_p1.order_p12{line-height: 32px;color: red;}.wrap_order .order_p1.order_p12 a{color: red;}</style>
</head>
<body>
	<div class="wrap_order" id="wrap_order">
		<div class="order_suc">
			<img src="/Public/image/success_icon.png" class="blocks" alt="">
			<p class="order_p1">您已经购买过该商品</p>
			<p class="order_p1 order_p12"><a href="javascript:;">请在商城中查看订单</a></p>
			<p class="order_sizes"><a href="/ActivityTwo/share_index/pid/<?php echo ($pid); ?>">查看分享文章</a></p>
		</div>
		<div class="order_info">
			<div class="orderInf_size disBox flexsJusi">
				<p>收款</p>
				<p>哈哈镜</p>
			</div>
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
	<input type="hidden" name="pid" id="pid" value="<?php echo ($pid); ?>">
	<script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script>
	<script src="/Public/js/lib/jquery-1.9.1.min.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" src="/Public/js/lib/jweixin.js"></script>
	<script type="text/javascript" src="/Public/js/common.js"></script>
	<script type="text/javascript">
		var url = window.location.href;
		weixins(url,"one");
	</script>
</body>
</html>