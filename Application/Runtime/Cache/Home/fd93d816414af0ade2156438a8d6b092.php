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
    <script type="text/javascript">document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);</script><style type="text/css">.hides{display:none}.ub{display:none}.top-box{background-color:#eee;-webkit-transform:translateY(0%);transform:translateY(0%);-webkit-transition:all linear .3s;transition:all linear .3s}.pub-btn{width:100px;background-color:#49b351;text-align:center;color:#fff;line-height:50px;font-size:16px;letter-spacing:1px}.pub-btn a{color:#fff}.pub-btn.pub-btn-dis{background-color: #999;}</style>
</head>
<body>
    <div id="mod-container" class="mod-container clearfix">
        <div id="mod-menulist" class="mod-menulist pageview" style="display:block;">
            <header class="pub-header">
                <a class="tap-action icon icon-back" href="/Index/index"></a>
                <div class="header-content"><?php echo ($shop_data["shop_name"]); ?></div>
                <input type="hidden" id="shop_name" name="shop_name" value="<?php echo ($shop_data["shop_name"]); ?>">
                <input type="hidden" id="shop_avatar" name="shop_avatar" value="<?php echo ($shop_data["shop_avatar"]); ?>">
                <span class="blocks icon header-right tap-action">
                    <a class="a1" href="/shop/navigation?user=<?php echo ($user_current['district']); ?>&shop=<?php echo ($shop_data["shop_address"]); ?>&user_x=<?php echo ($user_current['x']); ?>&user_y=<?php echo ($user_current['y']); ?>&shop_x=<?php echo ($shop_data["shop_baidux"]); ?>&shop_y=<?php echo ($shop_data["shop_baiduy"]); ?>">
                        <img src="/Public/image/Category/position-icon.png" alt="">
                    </a> 
                     <a class="a2" href="javascript:;"><!--/Category/store_switch-->
                        <img src="/Public/image/Category/share-icon.png" alt="">                        
                    </a> 
                </span>
            </header>
            <div class="menulist-info">
                <div class="menuinfo-title">
                    <div class="menuInfo-img">
                        <a href="javascript:void(0);" class="blocks imga">
                            <!--判断-->
                                <?php if(($shop_data["is_book"]) == "1"): ?><img class="icon_img" src="/Public/image/yudi.png"><?php endif; ?>
                            <!--判断-->
                            <img class="autos autosImg" src="<?php echo ($shop_data["shop_avatar"]); ?>" alt=""></a>  
                    </div>
                    <div class="menuInfo-r">
                        <div class="lis-title ui-ellipsis">
                            <!--<h2 class="ui-ellipsis" style="color:#fff;"></h2>-->
                            <input type="hidden" name="shop_id" id="shop_id" value="<?php echo ($shop_data["shop_id"]); ?>">
                        </div>
                        <!-- <div class="loc_img">
                            <a href="/shop/navigation?user=<?php echo ($user_current['district']); ?>&shop=<?php echo ($shop_data["shop_address"]); ?>&user_x=<?php echo ($user_current['x']); ?>&user_y=<?php echo ($user_current['y']); ?>&shop_x=<?php echo ($shop_data["shop_baidux"]); ?>&shop_y=<?php echo ($shop_data["shop_baiduy"]); ?>">
                                <img src="/Public/image/loc3.png" alt="">
                                <span>定位导航</span>
                            </a>
                        </div> -->
                        <?php if($shop_data["shop_deliver_type"] == 1): ?><if condition="$shop_data.shop_deliver_type eq 1">
                                <p class="info-fw">配送范围：<span><?php echo ($shop_data["shop_deliverscope"]); ?></span>公里
                                    <span><?php echo ($shop_data["shop_updeliverfee"]); ?>元起送</span></p>
                                <p class="info-price">配送费：<span><?php echo ($shop_data["shop_post_fee"]); ?>元</span></p><?php endif; ?>
                            <input type="hidden" value="<?php echo ($shop_data["shop_open_status"]); ?>" id="shop_open_status" name="shop_open_status">
                            <input type="hidden" value="<?php echo ($shop_data["shop_delivertime_status"]); ?>" id="shop_delivertime_status" name="shop_delivertime_status">
                    
                        <div class="menuInfo-ju flex flexsJusi">
                            <span class="collection blocks" id="collection" data-isfav="<?php echo ($shop_data["is_fav"]); ?>"><?php if(($shop_data["is_fav"]) == "1"): ?>已收藏<?php else: ?>立即收藏<?php endif; ?></span>
                            <span class="detailsInfo-r blocks" id="detailsInfo-r">店铺信息<img src="/Public/image/Category/drow.png" alt=""></span>
                        </div>
                    </div>
                </div>
                <div class="hide-Notice rolling-navigation">
                        <div class="rolling-size ui-ellipsis apple">
                            <ul class="apple_ul" style="margin-top: 0px;">
                                <?php if(is_array($shop_data['shop_notice1'])): foreach($shop_data['shop_notice1'] as $key=>$vo): ?><li class="ui-ellipsis">
                                       <a href="javascript:;"><?php echo ($vo); ?></a>
                                    </li><?php endforeach; endif; ?>
                            </ul>
                        </div>
          

                </div>
                <div id="menulist-sec" class="main main-top menulist-sec" style="top:140px;">
                    
                    <div class="secBoxScroll Shop_details mod_pay_coupons mod_pay_couponk">
                        <div class="shopd_mains">

                            <div class="shd_x">
                                <?php if($shop_date_yunfei['ticket_list']): ?><h2 class="shd_title">可用优惠</h2><?php endif; ?>
                                <div class="shd_coupon">
                                    <div class="mod_coupnss">
                                            <?php if(is_array($shop_date_yunfei['ticket_list'])): foreach($shop_date_yunfei['ticket_list'] as $key=>$vo): if(($vo["status"] == 1) OR ($vo["status"] == 0)): ?><dl class="mod_coupons_dl modCoupons_rs">
                                               <span>
                                                <?php if($vo["status"] == 1): ?><img src="/Public/image/coupon_using.png" alt="使用中">
                                                    <?php elseif($vo["status"] == 2): ?>
                                                    <img alt="已使用" src="/Public/image/coupon_used.png">
                                                    <?php elseif($vo["status"] == 3): ?>
                                                    <img alt="已作废" src="/Public/image/coupon_expired.png"><?php endif; ?>                      
                                            </span>
                                               <?php if(($vo['status']) == "0"): if($vo["surplus"] < 4): ?><b>还剩<?php echo ($vo["surplus"]); ?>天过期</b><?php endif; endif; ?>
                                                <dd>
                                                    <div class="mod_coupons_left <?php if($vo['ticket_price'] < '100'): ?>left_yellow <?php elseif($vo['discount_price'] == '0'): ?>left_skyblue<?php else: ?>left_red<?php endif; ?>">
                                                         <h2>
                                                            <?php if($vo['discount_price'] > '0'): ?><span>￥<?php echo ($vo["ticket_price"]); ?></span><?php endif; ?>
                                                            <?php echo ($vo["act_name"]); ?></h2>
                                                         <h3>使用区域：<span><?php echo ($vo["notes"]); ?></span></h3>
                                                         <p>使用说明：<?php echo ($vo["act_desc"]); ?></p>
                                                    </div>
                                                    <div class="mod_coupons_right">
                                                        <p>有效期</p>
                                                        <div>
                                                            <p><?php echo date('Y/m/d',strtotime($vo['start_date']));?></p>
                                                            <p><?php echo date('Y/m/d',strtotime($vo['end_date']));?></p>
                                                        </div>
                                                        <a href="javascript:void(0);" ticket-id="<?php echo ($vo['ticket_id']); ?>" data-act-is-book="<?php echo ($vo['act_is_book']); ?>" class="ticket_ida">立即使用 &gt;</a>
                                                    </div>
                                                </dd>
                                            </dl><?php endif; endforeach; endif; ?>
                                        </div>
                                   
                                </div>
                            </div>


                            <div class="shd_x">
                                <h2 class="shd_title">店铺信息</h2>
                                <div class="shd_info">
                                    <div class="shdInfo_divs flex">
                                        <span class="d_span">店铺评分：</span>
                                        <div class="d_p flexs">
                                            <div class="mens_details_x">
                                               <div class="wrap_x" id='wrap_x0' data-index="<?php echo ($shop_date_yunfei['score']); ?>" data-id="0">
                                                    <div id="cur" class="cur" ></div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
                                    <div class="shdInfo_divs flex">
                                        <span class="d_span">关注人数：</span>
                                        <p class="d_p flexs"><i><?php echo ($shop_date_yunfei['shopuser_count']); ?></i>人</p>    
                                    </div>
                                    <div class="shdInfo_divs flex">
                                        <span class="d_span">全部商品：</span>
                                        <p class="d_p flexs"><i><?php echo ($shop_date_yunfei['goods_count']); ?></i>件</p>    
                                    </div>
                                    <div class="shdInfo_divs flex">
                                        <span class="d_span">月销订单：</span>
                                        <p class="d_p flexs"><i><?php echo ($shop_date_yunfei['shop_totalordercount']); ?></i>单</p>   
                                    </div>
                                    <div class="shdInfo_divs flex shdInfo_divs2">
                                        <span class="d_span">营业时间：</span>
                                        <p class="d_p flexs"><?php echo ($shop_date_yunfei['shop_opentime']); ?></p>    
                                    </div>
                                    <div class="shdInfo_divs flex">
                                        <span class="d_span">配送时间：</span>
                                        <p class="d_p flexs"><?php echo ($shop_date_yunfei['shop_delivertime']); ?></p>    
                                    </div>
                                    <?php if(($shop_date_yunfei['post_fee_tip']) != ""): ?><div class="shdInfo_divs flex">
                                        <span class="d_span">配送服务：</span>
                                        <div class="d_p flexs">
                                            <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 1): ?><p class="p1"><b>免费</b><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                            <div class="d_pDiv">
                                                <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 0): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                            </div>
                                            <div class="d_pDiv">
                                                <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 2): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                            </div>
                                            <div class="d_pDiv">
                                                <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 3): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                            </div>
                                            <div class="d_pDiv">
                                                <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 4): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                            </div>
                                            <div class="d_pDiv">
                                                <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 5): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                            </div>
                                        </div>   
                                    </div><?php endif; ?>
                                    <div class="shdInfo_divs flex">
                                        <span class="d_span">门店地址：</span>
                                        <p class="d_p flexs"><?php echo ($shop_date_yunfei['shop_address']); ?></p>  
                                    </div>
                                    <div class="shdInfo_divs flex"> 
                                        <span class="d_span">商家电话：</span>
                                        <p class="d_p flexs"><a href="tel:4000175886" class="blocks"><?php echo ($shop_date_yunfei['shop_orderphone1']); ?></a><!-- <a href="tel:<?php echo ($shop_date_yunfei['shop_orderphone1']); ?>"><img class="Imgs" src="/Public/image/new/dianhua.png" alt=""></a> --></p> 
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="shBtn">
                                查看所有
                            </div> -->
                        </div>
                    </div>

                    <div class="shopd-bottom">
                        <img class="shopd-bImg" src="/Public/image/Category/bottom-icon.png" alt="">
                        <span class="blocks shopd-btxt">上滑动或点击继续购物</span>
                    </div>
        </div>
        </div>
    

            <div id="top-box" class="top-box main main-top" style="top:140px;">
                    <div class="menulist-search">
                        <form action="/Category/like_goods" method="get" name="FrmSearch" >
                                <p class="head-Inp">
                                <input type="search"  id="searchs" name="goods_name" class="styleinput" placeholder="搜索店内商品"></p>
                                <input type="hidden" name="shop_id" value="<?php echo ($shop_id); ?>">
                                <?php if($shop_data["shop_delivertime_status"] == 1): ?><input type="hidden" name="distribution" value="<?php echo ($distribution); ?>" id="distribution">
                                <?php else: ?>
                                <input type="hidden" name="distribution" value="1" id="distribution"><?php endif; ?>
                        </form>
                         <input type="hidden" id="hideType" value="<?php if(($is_yuding) == "1"): ?>0<?php else: ?>1<?php endif; ?>">
                        <div class="mainBox-boxM">
                            <ul class="mainBox-mens flex">
                              <!--   <?php if(($is_yuding) == "1"): ?><li class="mens_lis " data-index="0">
                                        <span class="menLi_span menLi_spans">预订特惠</span>
                                    </li><?php endif; ?>
                                    <li class="mens_lis" data-index="1">
                                        <span class="menLi_span <?php if(($is_yuding) == "0"): ?>menLi_spans<?php endif; ?>">即时美食</span>
                                    </li>
                                    <li class="mens_lis" data-index="2">
                                        <span class="menLi_span">店铺详情</span>
                                    </li> -->
                                    <li class="mens_lis " data-index="0">
                                        <span class="menLi_span menLi_spans">即时送</span>
                                    </li>
                                    <?php if(($is_yuding) == "1"): ?><li class="mens_lis mens_lis1" data-index="1">
                                            <span class="menLi_span <?php if(($is_yuding) == "0"): ?>menLi_spans<?php endif; ?>">次日达</span>
                                            <b class="menLi_b"><?php echo ($shop_data['shop_notice2']); ?></b>
                                        </li><?php endif; ?>
                            </ul>               
                        </div>
                    </div>
                    <div id="list-mainBox" class="main main-bottom list-mainBox" style="top:89px;"><!--display:none; mn -->
                        <div class="mainBox-title "><!--hides-->
                        </div>
                        <div class="bigbox bigbox0">
                            <div class="mensBox-left" id="mensBox-left">
                                <div class="scroller">
                                </div>
                                <?php if(is_array($category_second)): foreach($category_second as $key=>$vo): if(($vo["cat_id"]) == $defule_cat_id): ?><input type="hidden" name="category_key" value="<?php echo ($key); ?>" id="category_key"><?php endif; endforeach; endif; ?>
                            </div>                                       
                            <div class="mensBox-right" id="mensBox-right">
                                <div class="scroller" style="padding-top:28px;">
                                    <div id="pullDown" class="up ub-pc c-gra">
                                       <div class="pullDownIcon"></div>
                                       <div class="pullDownLabel">上拉显示更多...</div>
                                   </div>
                                   <ul id="adds" class="rightBox">
                                   </ul>
                                   <div id="pullUp" class="ub ub-pc c-gra">
                                       <div class="pullUpIcon"></div>
                                       <div class="pullUpLabel">上拉显示更多...</div>
                                   </div>
                                </div>
                            </div>
                        </div>
                        <div class="bigbox bigbox1" id="bigbox1">
                            <!--start-->
                            <div class="Shop_details mod_pay_coupons mod_pay_couponk" id="Shop_details">
                                <!-- <div class="shopd_mains">
                                    <div class="shd_x">
                                        <h2 class="shd_title">店铺信息</h2>
                                        <div class="shd_info">
                                            <div class="shdInfo_divs flex">
                                                <span class="d_span">店铺评分：</span>
                                                <div class="d_p flexs">
                                                    <div class="mens_details_x">
                                                       <div class="wrap_x" id='wrap_x0' data-index="<?php echo ($shop_date_yunfei['score']); ?>" data-id="0">
                                                            <div id="cur" class="cur" ></div>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>
                                            <div class="shdInfo_divs flex">
                                                <span class="d_span">关注人数：</span>
                                                <p class="d_p flexs"><i><?php echo ($shop_date_yunfei['shopuser_count']); ?></i>人</p>    
                                            </div>
                                            <div class="shdInfo_divs flex">
                                                <span class="d_span">全部商品：</span>
                                                <p class="d_p flexs"><i><?php echo ($shop_date_yunfei['goods_count']); ?></i>件</p>    
                                            </div>
                                            <div class="shdInfo_divs flex">
                                                <span class="d_span">月销订单：</span>
                                                <p class="d_p flexs"><i><?php echo ($shop_date_yunfei['shop_totalordercount']); ?></i>单</p>   
                                            </div>
                                            <div class="shdInfo_divs flex">
                                                <span class="d_span">营业时间：</span>
                                                <p class="d_p flexs"><?php echo ($shop_date_yunfei['shop_opentime']); ?></p>    
                                            </div>
                                            <div class="shdInfo_divs flex">
                                                <span class="d_span">配送时间：</span>
                                                <p class="d_p flexs"><?php echo ($shop_date_yunfei['shop_delivertime']); ?></p>    
                                            </div>
                                            <?php if(($shop_date_yunfei['post_fee_tip']) != ""): ?><div class="shdInfo_divs flex">
                                                <span class="d_span">配送服务：</span>
                                                <div class="d_p flexs">
                                                    <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 1): ?><p class="p1"><b>免费</b><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                                    <div class="d_pDiv">
                                                        <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 0): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                                    </div>
                                                    <div class="d_pDiv">
                                                        <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 2): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                                    </div>
                                                    <div class="d_pDiv">
                                                        <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 3): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                                    </div>
                                                    <div class="d_pDiv">
                                                        <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 4): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                                    </div>
                                                    <div class="d_pDiv">
                                                        <?php if(is_array($shop_date_yunfei['post_fee_tip'])): foreach($shop_date_yunfei['post_fee_tip'] as $key=>$vo): if($vo["fee_type"] == 5): ?><p class="p2"><?php echo ($vo["tip"]); ?></p><?php endif; endforeach; endif; ?>
                                                    </div>
                                                </div>   
                                            </div><?php endif; ?>
                                            <div class="shdInfo_divs flex">
                                                <span class="d_span">门店地址：</span>
                                                <p class="d_p flexs"><?php echo ($shop_date_yunfei['shop_address']); ?></p>  
                                            </div>
                                            <div class="shdInfo_divs flex"> 
                                                <span class="d_span">商家电话：</span>
                                                <p class="d_p flexs"><a href="tel:4000175886" class="blocks"><?php echo ($shop_date_yunfei['shop_orderphone1']); ?></a><a href="tel:<?php echo ($shop_date_yunfei['shop_orderphone1']); ?>"><img class="Imgs" src="/Public/image/new/dianhua.png" alt=""></a></p> 
                                            </div>
                                        </div>
                                    </div>
                                    <div class="shd_notice flex">
                                        <p class="flex_nol">
                                            公告
                                        </p>
                                        <p class="flex_nor flexs">如果下单的时间超过我们的营业时间，我们将在下个营业时间开始处理的订单。</p>
                                    </div>
                    
                                    <div class="shd_x">
                                        <h2 class="shd_title">店铺优惠券</h2>
                                        <div class="shd_coupon">
                                            <div class="mod_coupnss">
                                                    <?php if(is_array($shop_date_yunfei['ticket_list'])): foreach($shop_date_yunfei['ticket_list'] as $key=>$vo): if(($vo["status"] == 1) OR ($vo["status"] == 0)): ?><dl class="mod_coupons_dl modCoupons_rs">
                                                       <span>
                                                        <?php if($vo["status"] == 1): ?><img src="/Public/image/coupon_using.png" alt="使用中">
                                                            <?php elseif($vo["status"] == 2): ?>
                                                            <img alt="已使用" src="/Public/image/coupon_used.png">
                                                            <?php elseif($vo["status"] == 3): ?>
                                                            <img alt="已作废" src="/Public/image/coupon_expired.png"><?php endif; ?>                      
                                                    </span>
                                                       <?php if(($vo['status']) == "0"): if($vo["surplus"] < 4): ?><b>还剩<?php echo ($vo["surplus"]); ?>天过期</b><?php endif; endif; ?>
                                                        <dd>
                                                            <div class="mod_coupons_left <?php if($vo['ticket_price'] < '100'): ?>left_yellow <?php elseif($vo['discount_price'] == '0'): ?>left_skyblue<?php else: ?>left_red<?php endif; ?>">
                                                                 <h2>
                                                                    <?php if($vo['discount_price'] > '0'): ?><span>￥<?php echo ($vo["ticket_price"]); ?></span><?php endif; ?>
                                                                    <?php echo ($vo["act_name"]); ?></h2>
                                                                 <h3>使用区域：<span><?php echo ($vo["notes"]); ?></span></h3>
                                                                 <p>使用说明：<?php echo ($vo["act_desc"]); ?></p>
                                                            </div>
                                                            <div class="mod_coupons_right">
                                                                <p>有效期</p>
                                                                <div>
                                                                    <p><?php echo date('Y/m/d',strtotime($vo['start_date']));?></p>
                                                                    <p><?php echo date('Y/m/d',strtotime($vo['end_date']));?></p>
                                                                </div>
                                                                <a href="javascript:void(0);" ticket-id="<?php echo ($vo['ticket_id']); ?>" data-act-is-book="<?php echo ($vo['act_is_book']); ?>" class="ticket_ida">立即使用 &gt;</a>
                                                            </div>
                                                        </dd>
                                                    </dl><?php endif; endforeach; endif; ?>
                                                </div>
                                           
                                        </div>
                                    </div>
                                    <div class="shBtn">
                                        查看所有
                                    </div>
                                </div>-->
                            </div>
                            <!--end-->
                        </div>
                    </div>
                    <div class="pub-cart add-put flex flexsJusi">
                        <span class="shopping-icon icon icon-cart-inner expand" id="shopping-icons"><!--style="display:none"-->
                            <span class="shopping-count" id="shopping-count" <?php if(($sum_data["num"]) != ""): ?>style="display:block"<?php endif; ?>><?php if(($sum_data["num"]) == ""): ?>0<?php else: echo ($sum_data['num']); endif; ?></span>
                        </span>
                        <p class="shopping-price">
                            <span class="price-jia">￥<b class="zprice"><?php if(($sum_data["price"]) == ""): ?>0.00<?php else: echo (sprintf('%.2f',$sum_data['price'])); endif; ?></b></span>
                        </p>
                        <div class="pub-btn"><!--pub-btn-dis-->
                            <a href="javascript:;">去结算</a>
                        </div>
                    </div> 
        </div>
    </div>
    <div class="hide_box" style="display:none;">
        <div class="rightBox_null"><img src="/Public/image/bg_nulls.png" alt="" /><p>未找到您要的商品</p></div>
    </div>
    <div id="mod-share" class="mod-share">
        <img src="/Public/image/share_bg.png" alt="">
    </div>
    <input type="hidden" name="types" id="showAndhide"  value="0">

    <input type="hidden" name="get_cat_id" id="get_cat_id" value="<?php echo ($get_cat_id); ?>">
    <input type="hidden" name="get_son_cat_id" id="get_son_cat_id" value="<?php echo ($get_son_cat_id); ?>">
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
<script type="text/javascript" src="/Public/js/list.js"></script>
</body>
</html>