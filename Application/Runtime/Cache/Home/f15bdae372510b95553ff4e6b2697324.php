<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="htmls">
<head>
    <title>哈哈镜 </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="/Public/css/set.css">
	<link rel="stylesheet" href="/Public/css/swiper.min.css">
	<style type="text/css">.wrap_deInfo{padding: 3%;}</style>
</head>
<body>
	<div class="wrap_details wrap_de">
		<div class="wrap_deSize">
			<img class="Img" src="/Public/image/active/d_title.png" alt="">
			<div class="wrap_deMenu flex">
				<span class="d_span">配送时间：</span>
				<p class="flexs">12:00—22:00</p>
			</div>
			<div class="wrap_deMenu flex">
				<span class="d_span">配送区域：</span>
				<p class="flexs">（非配送区域暂时无法参加活动，将会逐步开启，敬请期待）<a href="/ActivityTwo/get_detailed">点击查看>></a></p>
			</div>
			<div class="wrap_deMenu flex">
				<span class="d_span">配送方式：</span>
				<p class="flexs">送货上门</p>
			</div>
		</div>
		<div class="wrap_deInfo">
			<div class="wrap_sp flex">
				<div class="wrap_spL">
					<img src="/Public/image/active/bgs.jpg" class="img" alt="" onerror="this.src='/Public/image/bg_nulls.png'">
				</div>
				<div class="wrap_spr flexs">
					<h6 class="spr_title">哈锅英雄嫩牛双人套餐</h6>
					<p class="spr_prices"><span>￥1.00</span></p>
					<s class="spr_s">原价￥198.00</s>
				</div>
				<div class="wrap_J flex">
					<span id="amount" class="product-operates-item amount amountInp"><?php echo ($cart_goods_count); ?>份</span>
				</div>
			</div>	
			<form id="autocomplete-form" class="mod-order-common login-form" onsubmit="return false;"  action="/ActivityTwo/confirm_html">
				<input type="hidden" name="ticket_list_ids" id="book_ticket_id" value="<?php echo ($book_ticket_id); ?>">
				<input type="hidden" name="cart_ids" id="cart_id" value="<?php echo ($cart_id); ?>">
			</form>

			<ul class="Ide_menus flex">
				<li class="Ide_lis Ide_lis2 flexs"><span>详情展示</span></li>
				<li class="Ide_lis flexs"><span>商品展示</span></li>
			</ul>
			<div class="wrap_Ides flex">
				<ul class="wrap_IdesDiv wrap_IdesDiv1 ">
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">电涮锅</p>
						<span class="Ides_span ">1个</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">鲜切拌制牛肉（大）</p>
						<span class="Ides_span ">1盒</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">时蔬素菜（叶菜类和根茎类）</p>
						<span class="Ides_span ">2盒</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">面条</p>
						<span class="Ides_span ">1盒</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">香辣底料（随口味酌情添加）</p>
						<span class="Ides_span ">1份</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">纯净水（锅底用）</p>
						<span class="Ides_span ">1瓶</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">小西红柿</p>
						<span class="Ides_span ">1盒</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">泡菜</p>
						<span class="Ides_span ">1盒</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">泡椒凤爪</p>
						<span class="Ides_span ">1盒</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">麻酱蘸料</p>
						<span class="Ides_span ">1袋</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">芝麻调和油</p>
						<span class="Ides_span ">1份</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">葱末、蒜末、香菜末</p>
						<span class="Ides_span ">各1盒</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">餐具（含碗、碟、杯、筷子、牙签和餐巾纸）</p>
						<span class="Ides_span ">2套</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">餐垫</p>
						<span class="Ides_span ">1张</span>
					</li>
					<li class="flex flexsJusi">
						<p class="Ides_p flexs">外包装盒</p>
						<span class="Ides_span ">1个</span>
					</li>
					
				</ul>
				<div class="wrap_IdesDiv wrap_IdesDiv2 wrap_IdesDivs hides">
					<!-- Swiper -->
					   <div class="swiper-container swiper-container1">
					       <div class="swiper-wrapper">
					           <div class="swiper-slide"><img class="imgss" src="/Public/image/dtu/Img0.jpg" alt=""></div>
					           <div class="swiper-slide"><img class="imgss" src="/Public/image/dtu/Img1.jpg" alt=""></div>
					           <div class="swiper-slide"><img class="imgss" src="/Public/image/dtu/Img2.jpg" alt=""></div>
					           <div class="swiper-slide"><img class="imgss" src="/Public/image/dtu/Img3.jpg" alt=""></div>
					           <div class="swiper-slide"><img class="imgss" src="/Public/image/dtu/Img4.jpg" alt=""></div>
					           <div class="swiper-slide"><img class="imgss" src="/Public/image/dtu/Img5.jpg" alt=""></div>
					           <div class="swiper-slide"><img class="imgss" src="/Public/image/dtu/Img6.jpg" alt=""></div>
					       </div>
					       <!-- Add Pagination -->
					       <div class="swiper-pagination swiper-pagination2"></div>
					       <!-- Add Arrows -->
					       <div class="swiper-button-next"></div>
					       <div class="swiper-button-prev"></div>
					   </div>
					   <div id="module_2" class="swiper-container swiper-container2">
					   	<div class="swiper-wrapper">
					   		<div class="one swiper-slide">
					   			<a href="javascript:;">
					   				<div class="memu_single">
					   					<img src="/Public/image/xtu/Img0.jpg" onerror="this.src='/Public/image/bg_nulls.png'"/>
					   				</div>
					   			</a>
					   		</div>
					   		
					   		<div class="one swiper-slide">
					   			<a href="javascript:;">
					   				<div class="memu_single">
					   					<img src="/Public/image/xtu/Img1.jpg" onerror="this.src='/Public/image/bg_nulls.png'"/>
					   				</div>
					   			</a>
					   		</div>

					   		<div class="one swiper-slide">
					   			<a href="javascript:;">
					   				<div class="memu_single">
					   					<img src="/Public/image/xtu/Img2.jpg" onerror="this.src='/Public/image/bg_nulls.png'"/>
					   				</div>
					   			</a>
					   		</div>

					   		<div class="one swiper-slide">
					   			<a href="javascript:;">
					   				<div class="memu_single">
					   					<img src="/Public/image/xtu/Img3.jpg" onerror="this.src='/Public/image/bg_nulls.png'"/>
					   				</div>
					   			</a>
					   		</div>

					   		<div class="one swiper-slide">
					   			<a href="javascript:;">
					   				<div class="memu_single">
					   					<img src="/Public/image/xtu/Img4.jpg" onerror="this.src='/Public/image/bg_nulls.png'"/>
					   				</div>
					   			</a>
					   		</div>

					   		<div class="one swiper-slide">
					   			<a href="javascript:;">
					   				<div class="memu_single">
					   					<img src="/Public/image/xtu/Img5.jpg" onerror="this.src='/Public/image/bg_nulls.png'"/>
					   				</div>
					   			</a>
					   		</div>

					   		<div class="one swiper-slide">
					   			<a href="javascript:;">
					   				<div class="memu_single">
					   					<img src="/Public/image/xtu/Img6.jpg" onerror="this.src='/Public/image/bg_nulls.png'"/>
					   				</div>
					   			</a>
					   		</div>
					   	</div>
					</div>
				</div>
			</div>
			<div class="wrap_IdeSize">
				<p>本次活动数量有限，预订从速。每人最多预订一份。</p>
				<p>客服电话：<a href="tel:400-0175-886">400-0175-886</a></p>
			</div>
			<img src="/Public/image/active/d_bg.png" class="Imgs" alt="">
		</div>

		<div class="wrap_de_btn">
			<p class="ps psa"><input type="button" id="btn2" class="btn2 blocks styleinput" value="" readonly=""></p>
		</div>
	</div>
	<input type="hidden" name="pid" id="pid" value="<?php echo ($user_data['user_id']); ?>">
<script type="text/javascript" src="/min/index?f=/Public/js/lib/swiper.min.js"></script>
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
		window.onload=function(){
			loaging.close();
		}
		var lis = $('.Ide_lis'),
			sAhDiv = $('.wrap_IdesDiv'),
			one = $('.one'),
			del = $('#del'),//减
			add = $('#add'),//加
			amount = $('#amount'),
			index = 0,
			book_ticket_id = $('#book_ticket_id'),
			cart_id = $('#cart_id'),
			btn = $('#btn2');
			
		$(function(){
			lis.off(tapClick());
			lis.on(tapClick(),function(){
				var index =$(this).index();
				lis.removeClass('Ide_lis2');
				$(this).addClass('Ide_lis2');
				sAhDiv.hide();
				sAhDiv.eq(index).show();
				index == 1 && tab();
			});
			btn.off('click');
			btn.on('click',function(){
				loaging.close();
				loaging.init('加载中，请稍后...');
				$('input').blur();
				setTimeout(function(){
					if(cart_id.val() == 0){
						loaging.close();
						loaging.prompts('请您先添加商品');
						return false;
					}
					document.getElementById("autocomplete-form").submit();
				},300);
			})
			function tab(num){
				var ins = 0;
				var mySwiper = new Swiper('.swiper-container1', {
				        pagination: '.swiper-pagination2',
				        nextButton: '.swiper-button-next',
				        prevButton: '.swiper-button-prev',
				        paginationClickable: true,
				        spaceBetween: 30
				   });
				var swiper2 = new Swiper('#module_2.swiper-container', {
					slidesPerView: 7,
					paginationClickable: true,
					spaceBetween: 3,
					freeMode: true
				});
				one.on(tapClick(),function(e){
					var index = $(this).index();

					e.preventDefault();
					$('.swiper-pagination span').eq(index).click();

				});
			}   
		});
		var url = window.location.href;
		weixins(url,"one");
	</script>
</body>
</html>