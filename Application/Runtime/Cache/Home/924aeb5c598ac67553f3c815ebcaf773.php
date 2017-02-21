<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
  	<script type=text/javascript>
	var docElement = document.documentElement;
	var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;
	docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';
</script>
<link rel="stylesheet" href="/Public/css/style.css">
<script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script>
<script type="text/javascript" src="/Public/js/lib/fastclick.js"></script>
  	<link rel="stylesheet" href="/Public/css/swiper.min.css">
<body onload="loaded()"> 
	<div id="mod-container" class="mod-container clearfix">
	    <div id="mod-evaluate" class="mod-evaluate pageview">
	        <header class="pub-header">
	            <a class="tap-action icon icon-back" href="/Index/index.html"></a>
	            <div class="header-content ">评价</div>
	            <span class="header-right header-right-text"></span>
	        </header>
	        <div id="iscroll-evaluate" class="main main-top" style="overflow: hidden;">
	            <div class="scrollers">
					<div class="order_info">
						<span>订单号</span>
						<p><?php echo ($data["order_no"]); ?></p>
						<input type="hidden" name="order_no" id="order_no" value="<?php echo ($data["order_no"]); ?>">
					</div>
					<div class="order_info">
						<span>下单时间</span>
						<p><?php echo date('Y-m-d H:i:s',$data['add_time']);?></p>
					</div>
					<div id="module_2" class="swiper-container">
						<ul class="swiper-wrapper">
							<?php if(is_array($data['goods_list'])): foreach($data['goods_list'] as $key=>$vo): ?><li class="one swiper-slide">
								<a href="javascript:void(0);">
									<img src="<?php echo ($vo["goods_pic"]); ?>" />
								</a>
							</li><?php endforeach; endif; ?>
						</ul>
					</div>
					<div class="starsInfo">
						<div class="stars_one clearfix">
							<span>请您评价</span>
							
						</div>
						<div class="stars_two">
							<?php if(is_array($data['tag'])): foreach($data['tag'] as $key=>$vo): ?><p>
								<span><?php echo ($vo); ?></span>
								</p><?php endforeach; endif; ?>
						</div>
						<div class="xingbox">
							<div class="starscore sstar" data-score="0">
							    <i data-index="0" ></i>
							    <i data-index="1"></i>
							    <i data-index="2"></i>
							    <i data-index="3"></i>
							    <i data-index="4"></i>
							</div>
							<p class="text"></p>
						</div>
						<div class="clear" style="height:30px;"></div>
						<div class="stars_three">
							<a href="javascript:void(0);">提交评价</a>
						</div>
					</div>
	            </div>
	        </div>
	    </div>
	</div>
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
<script type="text/javascript" src="/Public/js/lib/swiper.min.js"></script>
<script type="text/javascript" src="/Public/js/stars.js"></script>
<script type="text/javascript">
    function loaded(){
        var myScroll,listss = { probeType: 3,mouseWheel: true,preventDefault:false};
        init();
        function init(){
        	$('.mod-evaluate').show(); 
        	$(".sstar").BindStars();
        	var myScrol=new IScroll('#iscroll-evaluate', listss);
        }
        var swiper = new Swiper('#module_2.swiper-container', {
				slidesPerView: 5.8,
				paginationClickable: true,
				spaceBetween: 8,
				freeMode: true
		});

		$('.mod-evaluate .stars_two p span').on(tapClick(),function(){
			if($(this).hasClass('spanbg')){
				$(this).removeClass('spanbg');
			}else{
				$(this).addClass('spanbg');
			}
		})
		$('.stars_three').on(tapClick(),function(){
			var order_no=$('#order_no').val(),
				data_score=$('.starscore').attr('data-score'),
				s="";
				for(var k=0;k<$(".mod-evaluate .stars_two p span[class='spanbg']").length;k++){
					 s+=$(".mod-evaluate .stars_two p span[class='spanbg']")[k].innerHTML+',';
				}
			commoms.post_server('/order/evaluate',{order_no:order_no,data_score:data_score,s:s},function(re){
				loaging.close();
				if (re.result=='ok') {
					window.location.href="/order/index";
				};
	    	},function(){
    			loaging.btn('提交失败，请重试')
    		},false);

 		})
 } 

</script>
</body>
</html>