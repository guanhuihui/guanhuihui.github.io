<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="act-html">
<head>
    <title>哈哈镜便捷购</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<!--<link rel="apple-touch-icon-precomposed" href="/static/bee/img/app_icon-bae075e7.png" /><meta name="keywords" content="" /><meta name="description" content="" /><meta name="x5-fullscreen" content="true" /><meta name="full-screen" content="yes" />--><link rel="stylesheet" href="/Public/css/common.css" /><link rel="stylesheet" href="/Public/css/act.css" /><script>(function(){var calc = function(){var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';};calc();window.addEventListener('resize',calc);})();</script><style type="text/css">html{position:relative;height:100%;margin:auto; }body{width:100%;height:100%;}@media screen and (-webkit-device-pixel-ratio: 1){ html{max-width:800px;} }@media screen and (-webkit-min-device-pixel-ratio: 2){ html{max-width:480px;} }.index_pic{margin-top: 1.2rem;}.index_pic img{width: 100%;}.index_pic .h2s{position: relative; width: 100%;padding: 0.2rem 0;background: #F6A300;text-align: center;color: #fff;font-size: 1.9rem;font-weight: 600;}.index_pic .h2s2{font-size: 1.2rem;font-weight: normal;padding: 0.6rem 0;position: relative;}.index_pic .h2s img{position: absolute;left: 0;bottom: -0.5rem;}.index_pic .h2s2 img{top: -0.5rem;}.index_pic .Img{padding: 1rem 0;}
		</style>
 </head>
 <body class=""> 
		<div id="mod-container" class="mod-container mod-home clearfix">
			<div id="mod-box" class="mod-box home-cat pageview" style="display:block;">
		    	<section id="home-act" class="main main0 block home-act block">
		    		<div class="scroller clearfix">
	    				<a href="javascript:;" class="ui-blocks">
	    					<img src="/Public/image/act/x_banner.jpg" class="ui-autos" alt="">
	    				</a>
	    				<h2 class="act_title"><img class="Imgs" src="/Public/image/act/act_tiImg.png" alt=""></h2>
						<ul class="act_menu clearfix">
							<li class="act_lis">
								<div class="actLis_div">
									<a href="javascript:;">
										<img src="/Public/image/act/a_pic1.jpg" class="Imgs" alt="">
									</a>
									<div class="product-meta-wrap">
										<h2 class="product-name ui-ellipsis">麻辣牛油火锅双人套餐（含锅）(正辣)</h2>
										<!-- <s class="product-yuan cat_s ui-blocks">产品原价<b>198</b>元</s> -->
										<p class="product-price">特惠：<span>198.00</span>元</p>
										<span class="product-span ui-blocks">抢购</span>
									</div>
								</div>
							</li>
							<li class="act_lis">
								<div class="actLis_div">
									<a href="javascript:;">
										<img src="/Public/image/act/a_pic2.jpg" class="Imgs" alt="">
									</a>
									<div class="product-meta-wrap">
										<h2 class="product-name ui-ellipsis">麻辣牛油火锅双人套餐（不含锅）(正辣)</h2>
										<!-- <s class="product-yuan cat_s ui-blocks">产品原价<b>148</b>元</s> -->
										<p class="product-price">特惠：<span>148.00</span>元</p>
										<span class="product-span ui-blocks">抢购</span>
									</div>
								</div>
							</li>
						</ul>
						<div class="index_pic">
							<h2 class="h2s"><span class="blocks">套餐组合</span><img class="block" src="/Public/image/act/bg_t.png" alt=""></h2>
							<img class="block Img" src="/Public/image/act/pic.jpg" alt="">
							<h2 class="h2s h2s2">
							<img class="block" src="/Public/image/act/bg_b.png" alt="">
								<span class="blocks">精品搭配，这么多料，看着都特别满足~</span>
								<span class="blocks">经济实惠，自己做火锅，简单还健康呦~</span>
							</h2>
						</div>
	                </div> 
		    	</section>
			</div>
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
	loaging.init('加载中...');
	var myScrol0,btns = $('.product-span');
	var ua = navigator.userAgent.toLowerCase();
		if(ua.match(/MicroMessenger/i)=="micromessenger"){
			document.head.setAttribute('data-Is','wx');
			//$('.mod-container').css('overflow','hidden');
			//document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
			//myScrol0 = new IScroll('#home-act', iscroc);
			// $('.pub-header').show();
			//document.querySelector('.main').style.top = "50px";
			// myScrol0.refresh();
		}else if (/iphone|ipad|ipod/.test(ua)) {
			document.head.setAttribute('data-Is','ios');
		} else if (/android/.test(ua)) {
			document.head.setAttribute('data-Is','android');
		}
	 function connectWebViewJavascriptBridge(callback) {
		if (window.WebViewJavascriptBridge) {
		callback(WebViewJavascriptBridge)
		} else {
		document.addEventListener('WebViewJavascriptBridgeReady', function() {
		callback(WebViewJavascriptBridge)
		}, false)
		}
	}
	var ua = navigator.userAgent.toLowerCase();	
	btns.on('tap',function(){
		if(ua.match(/MicroMessenger/i)=="micromessenger"){
			$.ajax({
				url: '/ActHtml/get_yuding_shop',
				type: 'POST',
				success:function(re){
					var res = JSON.parse(re);
					if(res.result == 'ok'){
						loaging.close();
						loaging.init('加载中...');
	        			top.location.href = "/Category/index/cat_id/9/son_cat_id/45/shop_id/"+res.data+"";			
					}else{
						loaging.close();
						loaging.btn(res.data);
					}
				},error:function(){
					loaging.close();
				}
			})
		}else if (/iphone|ipad|ipod/.test(ua)) {
			connectWebViewJavascriptBridge(function(bridge) {
				var mycars={'type':'7','offer_sort':'45','cat_id':'9','is_book':'1'};
				bridge.send(mycars);
			});
		} else if (/android/.test(ua)) {
			window.mWebView.is_pop("45","9","1");
		}
	})
	window.onload=function(){loaging.close();}
		
</script>
 </body>
</html>