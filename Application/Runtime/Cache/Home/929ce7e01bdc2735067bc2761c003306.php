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
    <style type="text/css">.show{display: block;}.hidden{display: none;}.hide_null,.hide_null img{width: 100%;height: 100%;}</style>
    <script type="text/javascript">
        document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
    </script>
</head>
<body>
    <div id="mod-container" class="mod-container clearfix">
        <div id="mod-addrlist" class="mod-addrlist pageview">
            <header class="pub-header bgss">
                <a class="tap-action icon icon-back" href="/index/index"></a>
                <div class="header-content">
                    <div class="head_box">
                      <p <?php if(($hiden) == "1"): ?>class=""<?php else: ?> class="box_set"<?php endif; ?>>送货上门</p>
                      <p <?php if(($hiden) == "1"): ?>class="box_set"<?php else: ?>class=""<?php endif; ?>>到店自提</p>
                    </div>
                </div>
            </header>
            <div class="main addBox main-bottom ">
                <div id="list-product" class="list-product">
                    <div class="addrlist_main">
                        <div class="add_main" id="list-main-one" <?php if(($hiden) == "1"): ?>style="display:none;"<?php else: ?> style="display:block;"<?php endif; ?>>
                            <div class="scrollers">
                               <div class="blank-item">
                                    <a href="/Address/new_location.html">
                                        <span>
                                            <img src="/Public/image/icon-ding.png" alt="">
                                            定位到当前位置
                                        </span>
                                    </a>
                                </div>
                                <div class="list-addr">
                                    <ul class="list-addr-content">
                                        <?php if(is_array($address_get_data)): foreach($address_get_data as $key=>$vo): ?><li class="addr-item">
                                                <div class="addBox-l">
                                                    <a href='/Address/setsession_data.html?x=<?php echo ($vo["lng"]); ?>&y=<?php echo ($vo["lat"]); ?>&district=<?php echo ($vo["district"]); ?>&city_id=<?php echo ($vo["cityid"]); ?>&address_id=<?php echo ($vo["addressid"]); ?>' class="blocks">
                                                        <div class="list-addr-del">
                                                            <input type="radio" <?php if($vo["default"] == '1' ): ?>checked class="inputColor"<?php endif; ?> name="Date" id="Date">
                                                        </div>
                                                        <div class="list-addr-phone">
                                                            <div class="list-addr-info">
                                                                <span><?php echo ($vo["username"]); ?></span>
                                                                <span><?php echo ($vo["phone"]); ?></span>
                                                            </div>
                                                            <p class="list-addr-p"><?php echo ($vo["cityname"]); ?> <?php echo ($vo["district"]); ?> <?php echo ($vo["address"]); ?></p>
                                                        </div>
                                                    </a>
                                                </div>
                                                <a href="/Address/edit?address_id=<?php echo ($vo["addressid"]); ?>&cityname=<?php echo ($vo["cityname"]); ?>&district=<?php echo ($vo["district"]); ?>&x=<?php echo ($vo["lng"]); ?>&y=<?php echo ($vo["lat"]); ?>&cityCode=<?php echo ($vo["city_baiducode"]); ?>&address=<?php echo ($vo["address"]); ?>&name=<?php echo ($vo["username"]); ?>&mobile=<?php echo ($vo["phone"]); ?>" class="blocks addBox-r">
                                                    <img src="/Public/image/icon-edit.png" alt="<?php echo ($vo["addressid"]); ?>">
                                                </a>
                                            </li>
                                            <input type="hidden" name="lng" value="<?php echo ($vo["lng"]); ?>">
                                            <input type="hidden" name="lat" value="<?php echo ($vo["lat"]); ?>"><?php endforeach; endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="add_main add_main_two"  id="list-main-three"  <?php if(($hiden) == "1"): ?>style="display:block;"<?php else: ?> style="display:none;"<?php endif; ?>>
                            <div class="scrollers">
                                <div class="blank-item blank-item2">
                                     <a href="/Since/city_list.html?cityName=<?php echo ($city_name); ?>&x=<?php echo ($x); ?>&y=<?php echo ($y); ?>">
                                         <span class="ui-ellipsis"><img src="/Public/image/icon-ding.png" alt=""><?php echo ($district); ?></span>
                                     </a>
                                 </div>
                                <div class="generic-title">
                                    <i class="line line-l"></i>
                                    <span class="line-size"><img src="/Public/image/icon-generic.png" alt="">附近的店铺</span>
                                    <i class="line line-r"></i>
                                </div>
                                <?php if(count($shop_near_list) > 0): ?><div class="box_near_shang">
                                    <ul class="generic-list">
                                        <?php if(is_array($shop_near_list)): foreach($shop_near_list as $key=>$vo): ?><li class="generic-Boxli">
                                <div class="generic-item">
                                        <div class="generic-item-img">
                                            <?php if(($vo["shop_isvip"]) == "3"): ?><a href="javascript:void(0);" onclick="getclickinfo('代售点不能购买产品');">
                                                    <?php else: ?>
                                                    <a href="/Category/index/shop_id/<?php echo ($vo["shop_id"]); ?>"><?php endif; ?>
                                                    <!--判断-->
                                                        <?php if(($vo["is_book"]) == "1"): ?><img class="icon_img" src="/Public/image/yudi.png"><?php endif; ?>
                                                    <!--判断-->
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
                                    <span class="ui-ellipsis blocks"><?php echo ($vo["shop_address"]); ?></span>
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
                                <?php else: ?>
                                    <div class="hide_null">
                                        <img src="/Public/image/dia_empty.png" alt="">
                                    </div><?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pub-cart add-put" >
                <a href="javascript:void(0);" class="adda">
                    +新增收货地址
                </a>
            </div>   
        </div>
        <div id="mod-shipping_address" class="mod-shipping_address pageview"> 
            <header class="pub-header">
                <span class="tap-action icon icon-back">
                </span>
                <div class="header-content">
                    我的收货地址
                </div>
                <span class="header-right">
                <a href="/Address/add.html"  style="color:#ffffff;">+新建</a>
                </span>
            </header>
            <div id="shipping-adds" class="main main-top" style="overflow: hidden;">
            <?php if(count($address_get_data) > 0): ?><ul class="shipping-adds_list scrollers">
                    <?php if(is_array($address_get_data)): foreach($address_get_data as $key=>$vo): ?><li class="list_item">
                        <div class="shipping-adds-iphone">
                            <p><?php echo ($vo["username"]); ?></p>
                            <p><?php echo ($vo["phone"]); ?></p>
                        </div>
                        <p class="shipping-adds-del"><?php echo ($vo["cityname"]); ?> <?php echo ($vo["district"]); ?> <?php echo ($vo["address"]); ?></p>
                        <div class="hairline"></div>
                        <div class="shipping-adds-input">
                            <div class="shipping-adds-editor">
                                <a href="/Address/edit?address_id=<?php echo ($vo["addressid"]); ?>&cityname=<?php echo ($vo["cityname"]); ?>&district=<?php echo ($vo["district"]); ?>&x=<?php echo ($vo["lng"]); ?>&y=<?php echo ($vo["lat"]); ?>&cityCode=<?php echo ($vo["city_baiducode"]); ?>&address=<?php echo ($vo["address"]); ?>&name=<?php echo ($vo["username"]); ?>&mobile=<?php echo ($vo["phone"]); ?>"><span><img src="/Public/image/edit_icon.png" alt="<?php echo ($vo["addressid"]); ?>">编辑</span></a>
                                <span class="Del" data-id="<?php echo ($vo["addressid"]); ?>"><img src="/Public/image/remove_icon.png" alt="" >删除</span>
                            </div>
                        </div>
                    </li><?php endforeach; endif; ?>
                </ul>
                <?php else: ?>
                <div class="add_mins"><img src="/Public/image/add_null.png" alt="" /></div><?php endif; ?>
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
<script type="text/javascript" src="/Public/js/address.js"></script>
</body>
</html>