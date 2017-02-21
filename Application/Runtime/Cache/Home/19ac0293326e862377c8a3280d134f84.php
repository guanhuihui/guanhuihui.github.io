<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no"><meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"><meta name="format-detection" content="telephone=no">
	<title>提现</title>
	<link rel="stylesheet" href="/Public/css/ShopBack/common.css">
  	<script>
		(function(){var calc = function(){var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';};calc();window.addEventListener('resize',calc);})();
	</script><style type="text/css">.sec1{margin-top:1rem}.p_div{padding:0 3%;background:#fff;line-height:4rem;font-size:1.4rem;border-top:1px solid #dcdcdc}.p_div .p1{width:34%;color:#121212;font-size:1.5rem}.main_index .p_input{width:94%;margin-top:2rem;background:#fff;height:4rem;padding:.5rem 3%}.main_index .p_input input{display:block;height:4rem;font-size:1.6rem;border-color:#ccc}.p_3{color:red;padding:.5rem 3%}</style>
</head>
<body>
	<div class="main main_index">
		<!-- <header class="header">
			<span class="blocks head_left">
				<img src="img/logo.png" alt="">
			</span>
			<p class="centent">哈哈镜</p>
		</header> -->
		<header class="header2"><img src="/Public/image/logo.png" alt="">哈哈镜</header>
		<section class="sec1">
			<div class="flex p_div">
				<p class="p1">绑定店铺：</p>
				<p class="fp2 lexs"><?php echo ($shop_data['shop_name']); ?></p>
			</div>
			<div class="flex p_div">
				<p class="p1">账户金额：</p>
				<p class="fp2 lexs">￥ <span><?php echo ($sum_amount); ?></span></p>
			</div>
			<div class="flex p_div">
				<p class="p1">可提现金额：</p>
				<p class="p2 flexs">￥ <span><?php echo ($shop_data['shop_payment']); ?></span></p>
			</div>
			<div class="inputs p_input flex">
			    <input name="phone" id="prices" class="styleinput flexs styleinput2" type="tel" placeholder="请输入提现金额" maxlength="11" value="">
			    <input class="styleinput submit login-send" id="login-send" readonly="readonly" type="button"  value="确认体现">    
			</div>
			<p class="p_3">体现金额单笔单日限额20000</p>
		</section>
	</div>
	<script type="text/javascript" src="/Public/js/lib/jquery-1.9.1.min.js"></script><script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script><script type="text/javascript" src="/Public/js/common.js"></script>
	<script type="text/javascript">
		var login_send = $('#login-send'),reg = new RegExp("^[0-9]*$");  
			login_send.on('click',function(){
				var amounts = $('#prices');
				if(!amounts.val()){
					amounts.val('');
					loaging.close();
					loaging.prompts('请输入提现金额');
					return false;
				}
				if(!reg.test(amounts.val())){
					amounts.val('');
					loaging.close();
					loaging.prompts('请重新输入提现金额');
					return false;
				}
				if(amounts.val() > 20000){
					amounts.val('');
					loaging.close();
					loaging.prompts('提现金额不能超过20000元');
					return false;
				}
				loaging.close();
				commoms.post_server('/ShopBack/Withdrawals',{amount:amounts.val()},function(re){
				    if (re.result == 'ok') {
				        loaging.btn(re.msg);
				        window.location.reload();
				    }else{
				    	amounts.val('');
				        loaging.btn(re.msg);
				    }
				},function(){
					loaging.close();
				    loaging.btn('请重试');
				},false);
				
			})
	</script>
</body>
</html>