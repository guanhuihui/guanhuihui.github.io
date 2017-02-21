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
    <script type="text/javascript">document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);</script>
    <style type="text/css">
    .mod_er{width: 100%;height: 100%;background: #fff;}
    .mod_er_Div{width: 100%;padding-top: 20%;line-height:24px;font-size: 15px;text-align: center;color: red;}
    .mod_er img{display: block;}
    .mod_er_ord img{width: 70%;margin: 10px auto 10px;}
    .resultHmlt span{margin-left: 15px;}#mod_er_ord{top:5px;}
    </style>
<body>
<div id="mod-container" class="mod-container clearfix">
    <div id="mod_my_order" class="mod_my_order myorder pageview" style="display:block;">
          <header class="pub-header">
              <a class="tap-action icon icon-back" href="/Index/index"></a>
              <div class="header-content ">我的订单</div>
          </header>
          <ul class="mo_menu flex">
              <li class="mo_lis flexs <?php if($tal == ''): ?>lis_sec<?php endif; ?>"><span>待付款<?php if($order_data_1 != ''): ?><i></i><?php endif; ?></span></li>
              <li class="mo_lis flexs <?php if($tal != ''): ?>lis_sec<?php endif; ?>"><span>待收货<?php if($order_data_2 != ''): ?><i></i><?php endif; ?></span></li>
              <li class="mo_lis flexs"><span>待评价<?php if($order_data_3 != ''): ?><i></i><?php endif; ?></span></li>
              <li class="mo_lis flexs"><span>全部订单</span></li>
          </ul>
          <div class="four_null"><img src="/Public/image/order_null.png" alt=""></div>
          <div id="mod_order" class="main main-both" style="top:94px;">
            <div class="mod_order1 mods" id="mod_order1" <?php if($tal == ''): ?>style="display:block;"<?php endif; ?>>
                <div id="scrollers" class="scrollers">
                  <?php if(is_array($order_data_1)): foreach($order_data_1 as $key=>$vo): ?><div class="mo_boxs padds3" data-id="<?php echo ($vo["order_id"]); ?>" data-order-no="<?php echo ($vo["order_no"]); ?>">
                    <div class="moBox-title flex flexsJusi">
                        <p class="moBox-t-timer"><img src="/Public/image/me_shop.png" alt=""><span><?php echo ($vo["shop_name"]); ?></span><img src="/Public/image/me_arrow_icon.png" alt=""></p>
                        <p class="moBox-t-state">
                          <?php if($vo["order_status"] == 1): if(($vo["pay_status"] == 10) or ($vo["pay_status"] == 20) or ($vo["pay_status"] == 40)): ?>待支付<?php endif; endif; ?>
                          <?php if(($vo["order_status"] == 1) and ($vo["pay_status"] == 90)): ?>待发货<?php endif; ?>
                          <?php if(($vo["order_status"] == 10) or ($vo["order_status"] == 2)): ?>待发货
                            <?php elseif($vo["order_status"] == 5): ?>
                            已发货
                            <?php elseif($vo["order_status"] == 6): ?>
                            已取消<?php endif; ?>
                          <?php if($vo["order_status"] == 9): ?>等待受理<?php endif; ?>
                          <?php if($vo["order_status"] == 12): ?>已受理<?php endif; ?>
                          <?php if(($vo["order_status"] == 8) and ($vo["score"] > 0)): ?>已完成
                            <?php elseif(($vo["order_status"] == 8) and ($vo["score"] == 0)): ?>
                            待评价<?php endif; ?>

                        </p>
                    </div>  
                    <a href="/Order/state.html?dataid=<?php echo ($vo["order_id"]); ?>&order_no=<?php echo ($vo["order_no"]); ?>" style="display:block;" class="blocks">
                      <ul class="moBox-menus flex">
                        <?php if(is_array($vo['goods_list'])): foreach($vo['goods_list'] as $key=>$goods_data): if($key < 4): ?><li class="moBox-mLis">
                              <img src="<?php echo ($goods_data["goods_pic"]); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                            </li>
                          <?php elseif($key == 4): ?>
                          <li class="moBox-mLis">
                            <img src="/Public/image/more_goods.png" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                          </li><?php endif; endforeach; endif; ?>
                      </ul>
                    </a>
                    <p class="moBox_price">
                      <span>共<b><?php echo ($vo["total_quantity"]); ?></b>件商品</span>&nbsp;&nbsp;<span>实付:<b class="moBox_prices">￥<?php echo ($vo["total_amount"]); ?></b></span>
                    </p>

                    <div class="moBox_btns">
                        <span><a href="javascript:void(0);" class="again_btn" data-shop-id="<?php echo ($vo["shop_id"]); ?>" data-order-no="<?php echo ($vo["order_no"]); ?>" >再来一单</a></span>
                        <span class="bg_yellow" data-order-no="<?php echo ($vo["order_no"]); ?>">去支付</span>
                    </div>
                  </div><?php endforeach; endif; ?>

                </div>
            </div>
            <div class="mod_order2 mods" id="mod_order2" <?php if($tal != ''): ?>style="display:block;"<?php endif; ?>>
              <div class="scrollers">
                  <?php if(is_array($order_data_2)): foreach($order_data_2 as $key=>$vo): ?><div class="mo_boxs padds3" data-id="<?php echo ($vo["order_id"]); ?>" data-order-no="<?php echo ($vo["order_no"]); ?>">
                    <div class="moBox-title flex flexsJusi">
                       <p class="moBox-t-timer"><img src="/Public/image/me_shop.png" alt=""><span><?php echo ($vo["shop_name"]); ?></span><img src="/Public/image/me_arrow_icon.png" alt=""></p>
                        <p class="moBox-t-state">
                          <?php if($vo["order_status"] == 1): if(($vo["pay_status"] == 10) or ($vo["pay_status"] == 20) or ($vo["pay_status"] == 40)): ?>待支付<?php endif; endif; ?>
                          <?php if(($vo["order_status"] == 1) and ($vo["pay_status"] == 90)): ?>待发货<?php endif; ?>
                          <?php if(($vo["order_status"] == 10) or ($vo["order_status"] == 2)): ?>待发货
                            <?php elseif($vo["order_status"] == 5): ?>
                            已发货
                            <?php elseif($vo["order_status"] == 6): ?>
                            已取消<?php endif; ?>
                          <?php if($vo["order_status"] == 9): ?>已受理<?php endif; ?>
                          <?php if(($vo["order_status"] == 8) and ($vo["score"] > 0)): ?>已完成
                            <?php elseif(($vo["order_status"] == 8) and ($vo["score"] == 0)): ?>
                            待评价<?php endif; ?>

                        </p>
                    </div>  
                    <a href="/Order/state.html?dataid=<?php echo ($vo["order_id"]); ?>&order_no=<?php echo ($vo["order_no"]); ?>" style="display:block;" class="blocks">
                      <ul class="moBox-menus flex">
                        <?php if(is_array($vo['goods_list'])): foreach($vo['goods_list'] as $key=>$goods_data): if($key < 4): ?><li class="moBox-mLis">
                              <img src="<?php echo ($goods_data["goods_pic"]); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                            </li>
                          <?php elseif($key == 4): ?>
                          <li class="moBox-mLis">
                            <img src="/Public/image/more_goods.png" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                          </li><?php endif; endforeach; endif; ?>
                      </ul>
                    </a>
                    <p class="moBox_price">
                      <span>共<b><?php echo ($vo["total_quantity"]); ?></b>件商品</span>&nbsp;&nbsp;<span>实付:<b class="moBox_prices">￥<?php echo ($vo["total_amount"]); ?></b></span>
                    </p>
                    
                    <div class="moBox_btns" data-book-time="<?php echo ($vo["book_time"]); ?>" data-shop-name="<?php echo ($vo["shop_name"]); ?>">
                        <span><a href="javascript:void(0);" class="again_btn" data-shop-id="<?php echo ($vo["shop_id"]); ?>" data-order-no="<?php echo ($vo["order_no"]); ?>" >再来一单</a></span>
                        <?php if(($vo["order_status"] == 10 or $vo["order_status"] == 11) and ($vo["pay_status"] == 30)): ?><span  class="refund"><a href="javascript:;">退款</a></span><?php endif; ?>
                        <?php if($vo["order_status"] == 5): ?><span class="que" data='<?php if(($vo["deliver_type"] == 1) and (($vo["pay_type"] == 10) or ($vo["pay_type"] == 20))): ?>1<?php else: ?>0<?php endif; ?>'><a href="javascript:;">确认收货</a></span><?php endif; ?>
                        
                    </div>
                  </div><?php endforeach; endif; ?>
              </div>
            </div>

            <div class="mod_order3 mods" id="mod_order3">
              <div class="scrollers">
                <?php if(is_array($order_data_3)): foreach($order_data_3 as $key=>$vo): ?><div class="mo_boxs padds3" data-id="<?php echo ($vo["order_id"]); ?>" data-order-no="<?php echo ($vo["order_no"]); ?>">
                    <div class="moBox-title flex flexsJusi">
                        <p class="moBox-t-timer"><img src="/Public/image/me_shop.png" alt=""><span><?php echo ($vo["shop_name"]); ?></span><img src="/Public/image/me_arrow_icon.png" alt=""></p>
                        <p class="moBox-t-state">
                          <?php if($vo["order_status"] == 1): if(($vo["pay_status"] == 10) or ($vo["pay_status"] == 20) or ($vo["pay_status"] == 40)): ?>待支付<?php endif; endif; ?>
                         <?php if(($vo["order_status"] == 1) and ($vo["pay_status"] == 90)): ?>待发货<?php endif; ?>
                          <?php if($vo["order_status"] == 10): ?>待发货
                            <?php elseif($vo["order_status"] == 5): ?>
                            已发货
                            <?php elseif($vo["order_status"] == 6): ?>
                            已取消<?php endif; ?>
                          <?php if($vo["order_status"] == 9): ?>已受理<?php endif; ?>
                          <?php if(($vo["order_status"] == 8) and ($vo["score"] > 0)): ?>已完成
                            <?php elseif(($vo["order_status"] == 8) and ($vo["score"] == 0)): ?>
                            待评价<?php endif; ?>

                        </p>
                    </div>  
                    <a href="/Order/state.html?dataid=<?php echo ($vo["order_id"]); ?>&order_no=<?php echo ($vo["order_no"]); ?>" style="display:block;" class="blocks">
                      <ul class="moBox-menus flex">
                        <?php if(is_array($vo['goods_list'])): foreach($vo['goods_list'] as $key=>$goods_data): if($key < 4): ?><li class="moBox-mLis">
                              <img src="<?php echo ($goods_data["goods_pic"]); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                            </li>
                          <?php elseif($key == 4): ?>
                          <li class="moBox-mLis">
                            <img src="/Public/image/more_goods.png" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                          </li><?php endif; endforeach; endif; ?>
                      </ul>
                    </a>
                    <p class="moBox_price">
                      <span>共<b><?php echo ($vo["total_quantity"]); ?></b>件商品</span>&nbsp;&nbsp;<span>实付:<b class="moBox_prices">￥<?php echo ($vo["total_amount"]); ?></b></span>
                    </p>
                  <div class="moBox_btns">
                      <span><a href="javascript:void(0);" class="again_btn" data-shop-id="<?php echo ($vo["shop_id"]); ?>" data-order-no="<?php echo ($vo["order_no"]); ?>" >再来一单</a></span>
                      <span><a href="/Order/evaluate?order_no=<?php echo ($vo["order_no"]); ?>">去评价</a></span>
                  </div>
                </div><?php endforeach; endif; ?>
              </div>
            </div>

            <div class="mod_order4 mods" id="mod_order4">
              <div class="scrollers">
                   <div id="adds" class="list-product-Lis">
                      <?php if(is_array($order_data_0)): foreach($order_data_0 as $key=>$vo): ?><div class="mo_boxs padds3" data-id="<?php echo ($vo["order_id"]); ?>" data-order-no="<?php echo ($vo["order_no"]); ?>">
                        <div class="moBox-title flex flexsJusi">
                            <p class="moBox-t-timer"><img src="/Public/image/me_shop.png" alt=""><span><?php echo ($vo["shop_name"]); ?></span><img src="/Public/image/me_arrow_icon.png" alt=""></p>
                            <p class="moBox-t-state">
                          <?php if($vo["order_status"] == 1): if(($vo["pay_status"] == 10) or ($vo["pay_status"] == 20) or ($vo["pay_status"] == 40)): ?>待支付<?php endif; endif; ?>
                          <?php if(($vo["order_status"] == 1) and ($vo["pay_status"] == 90)): ?>待发货<?php endif; ?>
                          <?php if(($vo["order_status"] == 10) or ($vo["order_status"] == 2)): ?>待发货
                            <?php elseif($vo["order_status"] == 5): ?>
                            已发货
                            <?php elseif($vo["order_status"] == 6): ?>
                            已取消<?php endif; ?>
                          <?php if($vo["order_status"] == 9): ?>已受理<?php endif; ?>
                          <?php if(($vo["order_status"] == 8) and ($vo["score"] > 0)): ?>已完成
                            <?php elseif(($vo["order_status"] == 8) and ($vo["score"] == 0)): ?>
                            待评价<?php endif; ?>
                          <?php if($vo["order_status"] == 11): ?>已过期<?php endif; ?>

                        </p>
                        </div>  
                        <a href="/Order/state.html?dataid=<?php echo ($vo["order_id"]); ?>&order_no=<?php echo ($vo["order_no"]); ?>" style="display:block;" class="blocks">
                          <ul class="moBox-menus flex">
                            <?php if(is_array($vo['goods_list'])): foreach($vo['goods_list'] as $key=>$goods_data): if($key < 4): ?><li class="moBox-mLis">
                                <img src="<?php echo ($goods_data["goods_pic"]); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                              </li>
                            <?php elseif($key == 4): ?>
                              <li class="moBox-mLis">
                                <img src="/Public/image/more_goods.png" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                              </li><?php endif; endforeach; endif; ?>
                          </ul>
                        </a>
                        <p class="moBox_price">
                          <span>共<b><?php echo ($vo["total_quantity"]); ?></b>件商品</span>&nbsp;&nbsp;<span>实付:<b class="moBox_prices">￥<?php echo ($vo["total_amount"]); ?></b></span>
                        </p>
                        <div class="moBox_btns" data-book-time="<?php echo ($vo["book_time"]); ?>" data-shop-name="<?php echo ($vo["shop_name"]); ?>">
                          <span><a href="javascript:void(0);" class="again_btn" data-shop-id="<?php echo ($vo["shop_id"]); ?>" data-order-no="<?php echo ($vo["order_no"]); ?>" >再来一单</a></span>

                          <?php if($vo["order_status"] == 1): if(($vo["pay_status"] == 10) or ($vo["pay_status"] == 20) or ($vo["pay_status"] == 40)): ?><span class="bg_yellow">去支付</span><?php endif; endif; ?>

                          <?php if($vo["order_status"] == 5): ?><span class="que" data='<?php if(($vo["deliver_type"] == 1) and (($vo["pay_type"] == 10) or ($vo["pay_type"] == 20))): ?>1<?php else: ?>0<?php endif; ?>'><a href="javascript:;">确认收货</a></span><?php endif; ?>

                          <?php if(($vo["order_status"] == 8) and ($vo["score"] == 0)): ?><span><a href="/Order/evaluate?order_no=<?php echo ($vo["order_no"]); ?>">去评价</a></span><?php endif; ?>

                          <?php if(($vo["order_status"] == 10 or $vo["order_status"] == 11) and ($vo["pay_status"] == 30)): ?><span  class="refund"><a href="javascript:;">退款</a></span><?php endif; ?>
                        </div>
                      </div><?php endforeach; endif; ?>
                    </div>

                    <div id="pullUp" class="ub ub-pc c-gra">
                        <div class="pullUpIcon"></div>
                        <div class="pullUpLabel">上拉显示更多...</div>
                    </div>
              </div>
            </div>
            
          </div>
    </div>
    <div id="mod_er" class="mod_er pageview">
      <header class="pub-header">
          <a class="tap-action icon icon-back" href="javascript:void(0);"></a>
          <div class="header-content ">二维码</div>  
      </header>
      <div id="mod_er_ord" class="main main-top mod_er_ord">
      </div>
    </div>
</div>
<div class="mod-guide-mask"></div>
<div id="Pay_method" class="Pay_method">
    <div class="Pay_mBox payBor">
        <h2>选择支付方式</h2>
        <?php if($openid == '' ): ?><p class="zp zps" id="pay_zf" data-index="20">支付宝</p><?php endif; ?>
        <?php if($openid != '' ): ?><p class="zp" id="pay_wx" data-index="10">微信</p><?php endif; ?>
      </div>
    <div class="pay_close payBor">取消</div>
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
<script type="text/javascript" src="/Public/js/order.js"></script>
</body>
</html>