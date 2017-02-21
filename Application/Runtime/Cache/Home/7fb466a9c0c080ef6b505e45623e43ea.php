<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜便捷购</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
  <!--<script type=text/javascript>//var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';</script>-->
<script>(function(){var calc = function(){var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';};calc();window.addEventListener('resize',calc);})();</script> <link rel="stylesheet" href="/Public/css/style.css"><script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script><script type="text/javascript" src="/Public/js/lib/fastclick.js"></script>
<body>
	<div id="mod-container" class="mod-container clearfix">
	    <div id="mod-success" class="mod-success pageview">
	        <header class="pub-header">
	            <a class="tap-action icon icon-back" href="/Index/index.html"></a>
	            <div class="header-content ">我的订单</div>
	            <span class="header-right header-right-text"></span>
	        </header>
	        <div id="iscroll-success" class="main main-top" style="overflow: hidden;">
	            <div class="scrollers">
	                <div class="success_top">
	                	<!-- <dl class="success_info">
	                		<dt><img src="/Public/image/ren.png" alt=""></dt>
	                		<dd>
	                			<h2>订单提交成功</h2>
	                			<p class="p1">预计送达：<span><?php echo ($order_detail["book_time"]); ?></span></p>
	                			<p>付款方式：<span><?php if($order_detail["pay_type"] == '10'): ?>微信<?php elseif($order_detail["pay_type"] == '20'): ?>支付宝<?php elseif(($order_detail["pay_type"] == 90) or ($order_detail["pay_type"] == '40')): ?>货到付款<?php endif; ?></span></p>
	                			<p>应付金额：￥<?php echo ($order_detail['total_amount']); ?></p>
	                			<p>订单编号：<?php echo ($order_detail['order_no']); ?></p>
	                		</dd>
	                	</dl> -->
                        <div class="success_info">
                            <img class="success_info_img blocks" src="/Public/image/Category/success-icon2.png" alt="">
                            <!--<img class="success_info_img blocks" src="/Public/image/Category/success-icon2.png" alt="">-->
                            <div class="success_infos">
                                <p class="p1">预计送达：<span><?php echo ($order_detail["book_time"]); ?></span></p>
                                <p>付款方式：<span><?php if($order_detail["pay_type"] == '10'): ?>微信<?php elseif($order_detail["pay_type"] == '20'): ?>支付宝<?php elseif(($order_detail["pay_type"] == 90) or ($order_detail["pay_type"] == '40')): ?>货到付款<?php endif; ?></span></p>
                                <p>应付金额：￥<?php echo ($order_detail['total_amount']); ?></p>
                                <?php if(($shop_data["is_fav"]) == "0"): ?><div class="success_collection" id="success_check" data-val="<?php echo ($shop_data["is_fav"]); ?>" >
                                        <?php if(($shop_data["is_fav"]) == "1"): ?><img src="/Public/image/Category/dg_icon.png" alt=""><!--xunzhong.png-->
                                            <span id="success_checktxt">已收藏</span><!--已收藏-->
                                        <?php else: ?>
                                            <img src="/Public/image/Category/dk_icon.png" alt=""><!--xunzhong.png-->
                                            <span id="success_checktxt">收藏</span><!--已收藏--><?php endif; ?>
                                        <input type="hidden" id="shop_id" name="shop_id" value="<?php echo ($shop_data["shop_id"]); ?>">
                                        <span>哈哈镜</span>
                                    </div><?php endif; ?>
                            </div>
                        </div>
	                	<div class="success_menus">
	                		<a href="/Index/index.html">逛逛首页</a>
	                		<a href="/Order/state.html?order_no=<?php echo ($order_detail['order_no']); ?>&name=order">查看订单</a>
	                	</div>
	                </div>
                    <!-- <div class="success_share">
	                	<img src="/Public/image/fxyl.png" alt="">
	                	<p>分享有礼</p>
	                </div> -->
					<div class="success_main">
						<!-- <h2>去看看附近的好店</h2> -->
                        <p class="success_mainP">为您推荐</p>
						<div class="box_near_shang_list">
							<ul class="generic-list">
                            <?php if(is_array($shop_near_list)): foreach($shop_near_list as $key=>$vo): ?><li class="generic-Boxli">
                                <div class="generic-item">
                                        <div class="generic-item-img">
                                            <?php if(($vo["shop_isvip"]) == "3"): ?><a href="javascript:void(0);" onclick="getclickinfo('代售点不能购买产品');">
                                                    <?php else: ?>
                                                    <a href="/Category/index/shop_id/<?php echo ($vo["shop_id"]); ?>"><?php endif; ?>
                                                    <img class="image autos" src="<?php echo ($vo["shop_avatar"]); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></a> 
                                        </div>
                                        <div class="generic-item_info ui-ellipsis">
                                            <?php if(($vo["shop_isvip"]) == "3"): ?><a href="javascript:void(0);" onclick="getclickinfo('代售点不能购买产品');">
                                                    <?php else: ?>
                                                    <a href="/Category/index/shop_id/<?php echo ($vo["shop_id"]); ?>"><?php endif; ?>
                                                <div class="lis-title ui-ellipsis">
                                                    <h2 class="ui-ellipsis"><?php echo ($vo["shop_name"]); ?></h2>
                                                    <?php if($vo["shop_isvip"] == 1): ?><img class="liimg" src="/Public/image/bq-red.png" alt="">
                                                        <?php elseif($vo["shop_isvip"] == 2): ?>
                                                        <img class="liimg" src="/Public/image/bq-gre.png" alt="">
                                                        <?php elseif($vo["shop_isvip"] == 3): ?>
                                                        <img class="liimg" src="/Public/image/bq-yell.png" alt=""><?php endif; ?>
                                                </div>
                                                <?php if($vo["score"] > 0): ?><!--显示-->
                                                <div class="mens_details_x">
                                                   <div class="wrap_x" id='wrap_x<?php echo ($key); ?>' data-index="<?php echo ($vo["score"]); ?>" data-id="<?php echo ($key); ?>">
                                                        <div id="cur" class="cur" ></div>
                                                    </div>
                                                </div>
                                                <?php else: ?>
                                                <div class='zanwu'>暂无评价</div><?php endif; ?>
                                                <p class="generic-item-sh">已售<span><?php echo ($vo["shop_totalordercount"]); ?></span></p>
                                            </a>
                                        </div>
                                        <div class="generic-item_mi">
                                            <a href="javascript:void(0);">
                                                <img src="/Public/image/icon-d.png" alt="">
                                                <p><?php echo ($vo["distance"]); ?></p>
                                            </a>
                                       </div>                                  
                                </div>
                                <div class="generic-address">
                                    <span class="ui-ellipsis"><?php echo ($vo["shop_address"]); ?></span>
                                </div>

                                <div class="generic-not-mention">
                                    <?php if($vo["shop_deliver_type"] == 1): ?><p class="generic-carry generic-song 
                                        <?php if(($vo["shop_open_status"] == 2) OR ($vo["shop_delivertime_status"] == 2)): ?>generic-hui<?php endif; ?>">
                                            <span>送</span><b><?php echo ($vo["shop_updeliverfee"]); ?></b>元起送/配送费<b>￥<?php echo ($vo["shop_deliverfee"]); ?></b>
                                        </p><?php endif; ?>
                                    <p class="generic-carry generic-zi <?php if($vo["shop_open_status"] == 2): ?>generic-hui<?php endif; ?>">

                                        <?php if($vo["shop_deliver_type"] == 1): ?><span>自</span>在线下单，到店自提</p>
                                        <?php else: ?>
                                        <span>店</span>仅支持到店购买</p><?php endif; ?>

                                        <?php if($vo["shop_orderphone1"] != ''): ?><a href="tel:<?php echo ($vo["shop_orderphone1"]); ?>" class="generic-a blocks">
                                        <?php elseif($vo["shop_orderphone2"] != ''): ?>
                                            <a href="tel:<?php echo ($vo["shop_orderphone2"]); ?>" class="generic-a blocks">
                                            <?php else: ?>
                                            <a href="javascript:void(0);" class="generic-a blocks"><?php endif; ?>
                                        <img src="/Public/image/icon-phone.png" alt="">
                                        </a>
                                </div>
                            </li><?php endforeach; endif; ?>
                        </ul>
						</div>
					</div>



	            </div>
	        </div>
	    </div>
	</div>
    <div id="mod-share" class="mod-share">
    	<img src="/Public/image/share_bg.png" alt="">
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
<script type="text/javascript">
 var success_check = $('#success_check');
 var val = success_check.attr('data-val');
 var success_checktxt = $('#success_checktxt');
        success_check.on(tapClick(),function(){
            loaging.init('加载中...')
            var is_fav = $(this).attr('data-val'),shopId=$('#shop_id').val(),that=$(this);
            if(is_fav == 0){
                commoms.post_server('/Shop/favorite_add',{shop_id:shopId},function(re){
                    loaging.close();
                    if(re.result == 'ok'){
                        success_checktxt.text(re.msg);
                        success_check.attr('data-val',1);
                        that.find('img').attr('src','/Public/image/Category/dg_icon.png');
                    }else{
                        loaging.btn('收藏失败');
                    }
                },function(){
                    loaging.btn('错误');
                },false);
            }else if(is_fav == 1){
                commoms.post_server('/Shop/favorite_del',{shop_id:shopId},function(re){
                    loaging.close();
                    if(re.result == 'ok'){
                        success_checktxt.text(re.msg);
                        success_check.attr('data-val',0);
                        that.find('img').attr('src','/Public/image/Category/dk_icon.png');
                    }else{
                        loaging.btn('收藏失败');
                    }
                },function(){
                    loaging.close();
                },false);
            }
        })

     var collection = $('#olis_b'),
            shopId = $('#shop_id').val();

        /*收藏*/
        collection.on(tapClick(),function(){
            loaging.init('加载中...')
            function favorite () {
                var is_fav=collection.attr('data-isfav');
                if(is_fav == 0){
                    commoms.post_server('/Shop/favorite_add',{shop_id:shopId},function(re){
                        loaging.close();
                        if(re.result == 'ok'){
                            collection.text(re.msg);
                            collection.attr('data-isfav',1);
                        }else{
                            loaging.btn('收藏失败');
                        }
                    },function(){
                        loaging.btn('错误');
                    },false);
                }else if(is_fav == 1){
                    commoms.post_server('/Shop/favorite_del',{shop_id:shopId},function(re){
                        loaging.close();
                        if(re.result == 'ok'){
                            collection.text(re.msg);
                            collection.attr('data-isfav',0);
                        }else{
                            loaging.btn('收藏失败');
                        }
                    },function(){
                        loaging.close();
                    },false);
                }
            }
            favorite();
           
        })
    $(document).ready(function($) {
    	var myScroll;
        init();
       
        function init(){
        	$('.mod-success').show(); 
        	myScroll = new IScroll('#iscroll-success', {probeType: 3,mouseWheel: true,click: true,scrollbars: false}); 
        	var url=window.location.href;
    		weixins(url,"success");
        }
        $('.success_share').on(tapClick(),function(){
        	$('.mod-share').show();
        	$('.mod-share').on(tapClick(),function(){
        		$(this).hide();
        	})
        })
        score('mod-success','wrap_x');	
    });
</script>
</body>
</html>