<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜便捷购</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<!--<script type=text/javascript>//var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';</script>-->
<script>(function(){var calc = function(){var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';};calc();window.addEventListener('resize',calc);})();</script> <link rel="stylesheet" href="/Public/css/style.css"><script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script><script type="text/javascript" src="/Public/js/lib/fastclick.js"></script>
	<link rel="stylesheet" href="/Public/css/swiper.min.css">
	<style type="text/css">.hide_Divs{display: none;}#mod-container,#mod-box,.mod-cart,.iframes{width: 100%;height: 100%;}#container{width:100%;}.list-product-Lis .null_bgs{background:url('/Public/image/dian_empty.png') no-repeat;background-size: 100% 100%;}</style><script type="text/javascript"> document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);</script>
</head>
<body>
	<div id="mod-container" class="mod-container modO clearfix">
		<div id="mod-box" class="mod-box pageview pageviewBox" style="display:block;">
			<header class="pub-header bgss-one">
                <span class="tap-action icon icon-sweep"></span>
                <div class="header-content ui-ellipsis">
                    <a href="/Address/index">
                       <div class="head_nav">
                           <img class="nav-img" src="/Public/image/head-tlog.png" alt="">
                           <span class="nav-span ui-ellipsis"><?php echo ($district); ?></span>
                           <img class="nav-img" src="/Public/image/head-draw.png" alt="">
                       </div>
                    </a>
                </div>
                <span class="header-right boxRightTxt">
                    <a href="/System/message" class="blocks">
                        <img class="img blocks" src="/Public/image/massage_icon.png" alt="">
                        消息
                    </a>
                </span>
            </header>
	    	<div id="list-main-one" class="main mains list-main-one">
	    		<div class="scroller">
	                <div class="box_banner" id="box_banner">
	                    <div class="banner swiper-container">
	                        <div class="swiper-wrapper" id="swiper-wrapper">
	                        	<?php if(is_array($banner_list)): foreach($banner_list as $key=>$vo): ?><div class="swiper-slide">
	                            	<?php if(($vo["url"]) == ""): if(($vo["arranged"]) == "0"): ?><a href="javasript:void(0);">
                                            <?php else: ?>
                                            <a href="/Category/index/shop_id/<?php echo ($reserve_shop['shop_id']); ?>/tongji/1"><?php endif; ?>

	                            			<?php else: ?>
                                            <?php if(($vo["arranged"]) == "0"): ?><a href="/me/app_html_all?url=<?php echo ($vo["url"]); ?>&name=优惠活动">
	                            			<!--<a href="<?php echo ($vo["url"]); ?>">-->
                                            <?php else: ?>
                                            <?php if(($reserve_shop["shop_id"]) == ""): ?><a href="javasript:void(0);" onclick="getclickinfo('附近没有预定店铺');">
                                             <?php else: ?>
                                             <a href="/Category/index/shop_id/<?php echo ($reserve_shop['shop_id']); ?>/tongji/1"><?php endif; endif; endif; ?>
	                            		
	                            		<img src="<?php echo ($vo["pic"]); ?>" alt="" onerror="this.src='/Public/image/banner_moren.png'">
	                            	</a>
                                </div><?php endforeach; endif; ?>
	                        </div>
	                        <div class="swiper-pagination"></div>
	                    </div>
	                </div>
                    <div class="rolling-navigation">
                        <span class="rolling-img blocks"><img src="/Public/image/hahajing.jpg" alt=""></span>
                        <div class="rolling-size ui-ellipsis apple">
                            <ul class="apple_ul" style="margin-top: 0px;">
                                <?php if(is_array($shop_get_promotion['txt_list'])): foreach($shop_get_promotion['txt_list'] as $key=>$vo): ?><li class="ui-ellipsis">
                                        <?php if(($vo["type"]) == "1"): if(($reserve_shop["shop_id"]) == ""): ?><a href="javasript:void(0);" onclick="getclickinfo('附近没有预定店铺');">
                                             <?php else: ?>
                                             <a href="/Category/index/shop_id/<?php echo ($reserve_shop['shop_id']); ?>/tongji/1"><?php endif; ?>
                                        <?php else: ?>
                                        <?php if(($vo["url"]) == ""): ?><a href="javasript:void(0);">
                                            <?php else: ?>
                                        <a href="/me/app_html_all?url=<?php echo ($vo["url"]); ?>&name=优惠活动&sine=<?php echo ($openid); ?>"><?php endif; endif; ?>
                                        <?php echo ($vo["txt"]); ?></a>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div>
                    </div>
	                <div class="box_list">
	                    <div class="box_list_btn">

                        	<?php if(is_array($category_get_list)): foreach($category_get_list as $key=>$vo): if($vo["url_type"] == 1): ?><a <?php if(($vo["shop_id"]) == "0"): ?>href="javascript:void(0);" onclick="getclickinfo('您附近暂无网店');" <?php else: ?>href="/Category/index/cat_id/<?php echo ($vo["cat_id"]); ?>/son_cat_id/<?php echo ($vo["cat_ids_str"]); ?>/shop_id/<?php echo ($vo["shop_id"]); ?>" class="ahref"<?php endif; ?>  shop-id="<?php echo ($vo["shop_id"]); ?>">
                                <img src="<?php echo ($vo["pic"]); ?>" alt="<?php echo ($vo["cat_name"]); ?>">
                                <p><?php echo ($vo["cat_name"]); ?></p>
                            </a>
                            <?php else: ?>
                            <a href="/Coupon/index" class="ahref">
                                <img src="<?php echo ($vo["pic"]); ?>" alt="<?php echo ($vo["cat_name"]); ?>">
                                <p><?php echo ($vo["cat_name"]); ?></p>
                            </a><?php endif; endforeach; endif; ?>
                        </div>
                    </div>
                    <?php if(($offer_one_data) != ""): ?><div class="Box_sections flex clearfix">
                        <div class="secl">
                            <a href="<?php echo ($offer_one_data[0]['url']); ?>" <?php echo ($offer_one_data[0]['alert']); ?>>
                                <img src="<?php echo ($offer_one_data[0]['offer_pic']); ?>" alt="<?php echo ($offer_one_data[0]['offer_id']); ?>">
                            </a>
                        </div>
                        <div class="secr flexs">
                            <div class="secr_t flex">
                                <a class="flexs1 show" href="<?php echo ($offer_one_data[1]['url']); ?>" <?php echo ($offer_one_data[1]['alert']); ?>>
                                    <img src="<?php echo ($offer_one_data[1]['offer_pic']); ?>" alt="<?php echo ($offer_one_data[1]['offer_id']); ?>">
                                </a>
                                <a class="flexs show" href="<?php echo ($offer_one_data[2]['url']); ?>" <?php echo ($offer_one_data[2]['alert']); ?>>
                                    <img src="<?php echo ($offer_one_data[2]['offer_pic']); ?>" alt="<?php echo ($offer_one_data[2]['offer_id']); ?>">
                                </a>
                            </div>
                           <div class="secr_b flex">
                                 <a class="flexs1 show" href="<?php echo ($offer_one_data[3]['url']); ?>" <?php echo ($offer_one_data[3]['alert']); ?>>
                                    <img src="<?php echo ($offer_one_data[3]['offer_pic']); ?>" alt="<?php echo ($offer_one_data[3]['offer_id']); ?>">
                                </a>
                                <a class="flexs show" href="<?php echo ($offer_one_data[4]['url']); ?>" <?php echo ($offer_one_data[4]['alert']); ?>>
                                    <img src="<?php echo ($offer_one_data[4]['offer_pic']); ?>" alt="<?php echo ($offer_one_data[4]['offer_id']); ?>">
                                </a>
                           </div>
                        </div>
                    </div><?php endif; ?>
               <!--  <?php if(($offer_two_data) != ""): ?><div class="Box_sections_img">
                        <div class="bases swiper-container">
                            <div class="swiper-wrapper" id="swiper-wrapper">
                                <?php if(is_array($offer_two_data)): foreach($offer_two_data as $key=>$vo): ?><div class="swiper-slide">
                                    <a href="<?php echo ($vo['url']); ?>" <?php echo ($vo['alert']); ?>>
                                        <img src="<?php echo ($vo['offer_pic']); ?>" alt="<?php echo ($vo['offer_id']); ?>">
                                    </a>
                                </div><?php endforeach; endif; ?>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>


                    </div><?php endif; ?> -->
                    <div class="generic-title">
                        <i class="line line-l"></i>
                        <span class="line-size"><!-- <img src="/Public/image/icon-generic.png" alt=""> -->附近的店铺</span>
                        <i class="line line-r"></i>
                    </div>
                    <div class="box_near_shang">
                        <ul class="generic-list">
                            <?php if(is_array($shop_near_list)): foreach($shop_near_list as $key=>$vo): ?><li class="generic-Boxli" data-ids="<?php echo ($vo["shop_isvip"]); ?>|<?php echo ($vo["shop_id"]); ?>|<?php echo ($vo["shop_status"]); ?>">
                                <div class="generic-item">
                                        <div class="generic-item-img location_href">
                                            <?php if(($vo["shop_isvip"]) == "3"): ?><a href="javascript:void(0);" onclick="getclickinfo('代售点不能购买产品');">
                                                    <?php else: ?>
                                                        <?php if(($vo["shop_status"]) == "1"): ?><a href="javascript:void(0);" onclick="getclickinfo('店铺关闭');">
                                                        <?php else: ?>
                                                            <a href="javascript:void(0);"><?php endif; endif; ?>
                                                    <!--判断-->
                                                        <?php if(($vo["is_book"]) == "1"): ?><img class="icon_img" src="/Public/image/yudi.png"><?php endif; ?>
                                                    <!--判断-->
                                                    <img class="image autos" src="<?php echo ($vo["shop_avatar"]); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></a> 
                                        </div>
                                        <div class="generic-item_info location_href ui-ellipsis">
                                            <?php if(($vo["shop_isvip"]) == "3"): ?><a href="javascript:void(0);" onclick="getclickinfo('代售点不能购买产品');">
                                            <?php else: ?>
                                                <?php if(($vo["shop_status"]) == "1"): ?><a href="javascript:void(0);" onclick="getclickinfo('店铺关闭');">
                                                    <?php else: ?>
                                                        <a href="javascript:void(0);"><?php endif; endif; ?>
                                                <div class="lis-title ui-ellipsis">
                                                    <h2 class="ui-ellipsis"><?php echo ($vo["shop_name"]); ?></h2>
                                                    <?php if($vo["shop_isvip"] == 1): ?><img class="liimg" src="/Public/image/bq-red.png" alt="">
                                                        <?php elseif($vo["shop_isvip"] == 2): ?>
                                                        <img class="liimg" src="/Public/image/bq-gre.png" alt="">
                                                        <?php elseif($vo["shop_isvip"] == 3): ?>
                                                        <img class="liimg" src="/Public/image/bq-yell.png" alt="">
                                                        <?php elseif($vo["shop_isvip"] == 4): ?>
                                                        <img class="liimg" src="/Public/image/bq-vp.png" alt="">
                                                        <?php elseif($vo["shop_isvip"] == 5): ?>
                                                        <img class="liimg" src="/Public/image/bq-redXing.png" alt=""><?php endif; ?>
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
                                            <a href="/shop/navigation?user=<?php echo ($user_current['district']); ?>&shop=<?php echo ($vo["shop_address"]); ?>&user_x=<?php echo ($user_current['x']); ?>&user_y=<?php echo ($user_current['y']); ?>&shop_x=<?php echo ($vo["shop_baidux"]); ?>&shop_y=<?php echo ($vo["shop_baiduy"]); ?>">
                                                <img src="/Public/image/icon-d.png" alt="">
                                                <p><?php echo ($vo["distance"]); ?></p>
                                            </a>
                                       </div>                                  
                                </div>
                                <div class="generic-address">
                                    <span class="ui-ellipsis"><?php echo ($vo["shop_address"]); ?></span>
                                </div>

                                <div class="generic-not-mention location_href">
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
                    <div class="mbox-button">
                        <span class="mbox-bth">查看所有店铺</span>
                       <!--  <div class="mbox-guarantee">
                            <p>更好的为您提供服务</p>
                            <p>选择的店铺设置为默认店铺</p>
                        </div> -->
                    </div>
                </div> 
	    	</div>
		</div>
		<div id="mod-nearby" class="mod-nearby pageview pageviewBox">
			<header class="pub-header">
               <div class="header-content ui-ellipsis">
                   店铺列表
               </div>
               <span class="icon header-right tap-action" id="two_right">
                    <div><span class="ui-ellipsis"><b>北京</b>▼</span></div>
                </span>
               <ul class="main_list_ol" id="main_list_ol">
                    <li><a href="javascript:void(0);">星级VIP</a></li>
                    <li><a href="javascript:void(0);">vip 网店</a></li>
                    <li><a href="javascript:void(0);">普通店铺</a></li>
                    <li><a href="javascript:void(0);">代售点</a></li>
               </ul>
            </header>
            <div>
                <p class="adds_hides"><img src="/Public/image/dian_empty.png" alt="" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></p>
        	    	<div id="list-main-two" class="main main-bottom list-main-two" style="top:116px;">
        	    		<div class="scroller">
        	    		   <ul id="adds" class="list-product-Lis generic-list">
        	    		   </ul>
        	    		   <div id="pullUp" class="ub ub-pc c-gra">
        	    		       <div class="pullUpIcon"></div>
        	    		       <div class="pullUpLabel">上拉显示更多...</div>
        	    		   </div>
        	    		</div>
        	    	</div>
            </div>
		</div>
		<div id="mod-catrs" class="mod-catrs pageview pageviewBox">
		<iframe src="/Cart/index" frameborder="0" id="Myiframe" class="iframes"></iframe>
		</div>
		<div id="mod-my-shop" class="mod-my-shop pageview pageviewBox">
			<header class="pub-header">
                <div class="header-content ui-ellipsis">
                   我的收藏
                </div>
                <!-- <div class="list-main-four-html">
                    <div class="header-content ui-ellipsis">
                        <div class="head_box">
                          <p class="box_set">送货上门</p>
                          <p>到店自提</p>
                      	</div>
                    </div>
                </div> -->
            </header>
	    	<div id="list-main-four" class="main main-both list-main-four">
	    		<div class="scroller">
                    <ul class="generic-list" id="my-shop-ul">
                    </ul>
	    		</div>
                <div class="four_null"><img src="/Public/image/dia_empty.png" alt=""></div>
	    	</div>
		</div>
		<div id="mod-me" class="mod-me pageview pageviewBox">
	    	<div id="list-main-five" class="main mains list-main-five">
	    		<div class="scroller">
    		       <div class="list_me_banner">
                       <p class="as">
                           <a href="/Me/install.html">
                               <img src="/Public/image/me_config_icon.png" alt="">
                           </a>
                       </p>
                       <img src="/Public/image/me_avatar_icon.png" alt="">
                      
                       <a><?php echo ($user_mobile); ?></a>
                       <div class="Vip_integral">
                               <img src="/Public/image/vip/vip<?php echo ($user_score['user_level']); ?>.png" alt="">
                               <p>积分&nbsp;<span><?php echo ($user_score['user_score']); ?></span></p>
                       </div>
                   </div> 
    		       <div class="list_me_btn">
    		           <p>
    		            <a href="/Order/index.html">
    		                <img src="/Public/image/me_order_Icon.png" alt="">
    		                <span>订单</span>
    		            </a>
    		           </p>
    		           <p>
    		            <a href="/Coupon/index.html">
    		                <img src="/Public/image/me_coupo_Icon.png" alt="">
    		                <span>优惠券</span>
    		            </a>
    		           </p>
    		           <p>
    		            <a href="/System/message.html">
    		                <img src="/Public/image/me_message_Icon.png" alt="">
    		                <span>消息</span>
    		            </a>
    		           </p>
    		       </div>
    		       <div class="list_me_main">
    		            <a href="/Address/index.html">
    		                <img src="/Public/image/me_address_icon.png" alt="">
    		                <span>我的收货地址</span>
    		            </a>
    		            <a href="javascript:void(0);" id="My_shop">
    		                <img src="/Public/image/me_shop_icon.png" alt="">
    		                <span>我收藏的店铺</span>
    		            </a>
    		            <a href="javascript:void(0);" class="share_firends">
    		                <img src="/Public/image/me_share_icon.png" alt="">
    		                <span>分享哈哈镜好友</span>
    		            </a>
    		           <a href="/me/app_html_all?url=http://www.hahajing.com/app/join&name=招商加盟">
    		               <img src="/Public/image/me_join_icon.png" alt="">
    		               <span>招商加盟</span>
    		           </a>
                        <a href="javascript:void(0)" id="clickkefu">
    		           <!-- <a href="javascript:void(0)" onclick="_MEIQIA._SHOWPANEL()">
    		           <a href="javascript:void(0)" onclick="mechatClick()">-->
    		                <img src="/Public/image/me_onlineservice_icon.png" alt="">
    		                <span>在线客服</span>
    		            </a>
    		            <a href="/me/app_html_all?url=http://www.hahajing.com/app/join&name=招募精英">
    		                <img src="/Public/image/me_recruit.png" alt="">
    		                <span>招募精英</span>
    		            </a>
    		            <a href="/me/app_html_all?url=http://www.hahajing.com/app/announcement&name=供应商云集">
    		                <img src="/Public/image/me_supplier.png" alt="">
    		                <span>供应商云集</span>
    		            </a>
    		            <a href="/me/app_html_all?url=http://www.hahajing.com/app/help&name=帮助中心">
    		                <img src="/Public/image/me_wen_icon.png" alt="">
    		                <span>帮助中心</span>
    		            </a>
    		       </div>
    		    </div>
	    	</div>
		</div>

 		<div class="pub-cart pub-cart-box" id="pub-cart-box">
            <ul class="pub-cart_menu">
                <li>
                    <p class="positions"><img src="/Public/image/icon/a0.png" alt=""></p>
                    <span>首页</span>
                </li>
                <li>
                    <p><img src="/Public/image/icon/b0.png" alt=""></p>
                    <span>附近店铺</span>
                </li>
                <li>
                    <p><img src="/Public/image/icon/c0.png" alt=""></p>
                    <span>购物车</span>
                </li>
                <li>
                    <p><img src="/Public/image/icon/d0.png" alt=""></p>
                    <span>我的店铺</span>
                </li>
                <li>
                     <p><img src="/Public/image/icon/e0.png" alt=""></p>
                    <span>我的</span>
                </li>
            </ul>
        </div>

	    <div id="mod-selects" class="mod-select-city pageview">
	    	<header class="pub-header">
                <span class="tap-action icon icon-back">
                </span>
                <p class="header-content">
                    选择地址
                </p>
                <span class="header-right header-right-text">
                </span>
            </header>
            <div class="divs">热门城市</div>
            <div id="iscroll-select" class="main main-top" style="overflow: hidden;">
                <div class="scrollers">
                	<div class="boxsk">
                	    <div id="list-product" class="list-product">
                	        <div class="inpt">
                	            <form action="" method="get" id="fetche-voucher-form">
                	                <div class="input-wrap">
                	                    <input type="search" maxlength="11" id="user-phone" name="phone" autocomplete="off" placeholder="">
                	                    <div class="input-text">
                	                      城市/拼音
                	                    </div>
                	                </div>
                	            </form>
                	        </div>
                	        <div class="hot-city">
                	            <h2>热门城市</h2>
                	            <ul class="scrollers_Items">
		                            <?php if(is_array($city_list_dat['host_city'])): foreach($city_list_dat['host_city'] as $key=>$vo): ?><li class="item" data-city="<?php echo ($vo['city_id']); ?>" id="<?php echo ($vo['city_id']); ?>"><span><?php echo ($vo['city_name']); ?></span></li><?php endforeach; endif; ?>
		                        </ul>
                	        </div>
                	        <section id="_scroll" class="_scroll">
                	            <?php if(is_array($city_list_dat_az)): foreach($city_list_dat_az as $key=>$vo): ?><ul class="scrollers_Items">
		                                <h2><?php echo ($key); ?></h2>
		                                <?php if(is_array($vo)): foreach($vo as $key=>$val): ?><li class="item" data-city="<?php echo ($val["city_id"]); ?>"><?php echo ($val["city_name"]); ?></li><?php endforeach; endif; ?>
		                            </ul><?php endforeach; endif; ?>
                	        </section>
                	    </div>
                	</div>
                </div>
            </div>
            <div class="shu">
				<?php if(is_array($city_list_dat_az)): foreach($city_list_dat_az as $key=>$vo): ?><p><?php echo ($key); ?></p><?php endforeach; endif; ?>
			</div>
	    </div>
	    <div id="mod-city-lists" class="mod-city-lists">
            <div class="mod-citylists">
            	<p class="aa">
        			<span>取消</span>
            		<a href="javascript:void(0);" class="mod-citylists_a">确定</a>
            	</p>
            	<div id="iscroll-selec-list">
	                <div class="scrollers">
	                	<input type="hidden" value="全城" data-index="0" id="hidden-index" city-id="" area-id="">
	               		<ul class="scrollers_mens">
	               		</ul>
	                </div>
            	</div>
            </div>
	    </div>
	    <div class="adds_selection pageview" id="adds_selections">
	    	<header class="pub-header">
                <span class="tap-action icon icon-back">
                </span>
                <div class="header-content">
                    <div class="head_box">
                      <p class="box_set">送货上门</p>
                      <p>到店自提</p>
                  </div>
                </div>
                <a class="header-right header-right-text" href="/Address/add.html" style="color:#ffffff">
                	+新建
                </a>
            </header>
	    	<div id="adds_selection" class="main main-top" style="overflow: hidden;">
	    		<div id="list-product" class="list-product">
	    		    <div class="addrlist_main">
	    		        <!--首页start-->
	    		        <div class="add_main" id="adds-main-one">
	    		            <div class="scrollers" id="addselect_mins">
	    		            </div>
	    		        </div>
	    		        <!--首页end-->
	    		        <!--购物车start-->
	    		        <div  class="add_main add_main_two"  id="adds-main-three">
	    		            <div class="scroller">
	    		                <h2 class="two_title" style="padding-top:10px;">自提点</h2>
	    		                <div class="four_null"><img src="/Public/image/dia_empty.png" alt=""></div>
                                <div class="address_session">
                                </div>
	    		            </div>
	    		        </div>
	    		    </div>
	    		</div>
	    	</div>
	    </div>
        <div class="yans">
            <div class="yansBoxs">
                <p>您有未确认的订单</p><a class="alerta blocks" href="/Order/index/tal/1">立即查看</a>
            </div>
        </div>
	</div>
	<div class="Return-top"> 
	    <img src="/Public/image/top_icon.png" alt="">
	</div>
    <div id="mod-overlay-mask" class="mod-overlay-mask">
    </div>
    <div id="mod-share" class="mod-share">
    	<img src="/Public/image/share_bg.png" alt="">
    </div>
	<div id="allmap"></div>
	<input type="hidden" id="hide-lat" value="<?php echo ($user_current['y']); ?>" />
	<input type="hidden" id="hide-lng" value="<?php echo ($user_current['x']); ?>" />
    <input type="hidden" id="user_district" value="<?php echo ($user_current['district']); ?>">
	<input type="hidden" id="hide_id" val="">
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=wqBXfIN3HkpM1AHKWujjCdsi"></script> 
<script type="text/javascript" src="/min/index?f=/Public/js/lib/swiper.min.js"></script>
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
<script type="text/javascript" src="/min/index?f=/Public/js/index.js"></script>
<script type="text/javascript">
    $('.ahref').on('tap',function(){
        layer.closeAll();
        loaging.init('跳转中...');
    })
</script>
<script type='text/javascript'>
    (function(m, ei, q, i, a, j, s) {
        m[a] = m[a] || function() {
            (m[a].a = m[a].a || []).push(arguments)
        };
        j = ei.createElement(q),
            s = ei.getElementsByTagName(q)[0];
        j.async = true;
        j.charset = 'UTF-8';
        j.src = i + '?v=' + new Date().getUTCDate();
        s.parentNode.insertBefore(j, s);
    })(window, document, 'script', '//static.meiqia.com/dist/meiqia.js', '_MEIQIA');
    _MEIQIA('entId', 645);
    _MEIQIA('withoutBtn');
    _MEIQIA('init');
    _MEIQIA('metadata', {
        name: '微信商城:<?php echo ($user_mobile); ?>', 
        '店铺名称': "<?php echo ($meiqia_data['店铺名称']); ?>",
        '店铺手机号': "<?php echo ($meiqia_data['店铺手机号']); ?>",
        '订单编号': "<?php echo ($meiqia_data['订单编号']); ?>",
        '订单状态': "<?php echo ($meiqia_data['订单状态']); ?>",
        '商品总金额': "<?php echo ($meiqia_data['商品总金额']); ?>",
        '实付金额': "<?php echo ($meiqia_data['实付金额']); ?>",
        '配送费': "<?php echo ($meiqia_data['配送费']); ?>",
        '优惠费用': "<?php echo ($meiqia_data['优惠费用']); ?>",
        '下单时间': "<?php echo ($meiqia_data['下单时间']); ?>",
        '店铺名称': "<?php echo ($meiqia_data['店铺名称']); ?>",
        '配送方式': "<?php echo ($meiqia_data['配送方式']); ?>",
        '收货地址': "<?php echo ($meiqia_data['收货地址']); ?>"
    });
</script>
<script>
    $('#clickkefu').on('tap',function(){
        _MEIQIA('showPanel');
    })
</script>
</body>
</thml>