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
  <style type="text/css">.hide_Divs{display: none;}.mod-Catrs .icon_cen .dis h2{.mod-Catrs .icon_cen .info_price.info_price2s{color: #000;font-weight: 500;}</style><script type="text/javascript">document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);</script>
</head>
<body >
<input type="hidden" value="0" id="ids">
  <div id="mod-container" class="mod-container clearfix">
    <div id="mod-carts" class="mod-Catrs pageview" style="display:block;">
        <header class="pub-header" id="heds">
            <a class="asd tap-action icon icon-back" id="icon-backss" href="javascript:void(0);"></a>
            <div class="header-content ui-ellipsis">购物车<!--<span>(4)</span>--></div>
        </header>
        <div class="main main-both cat_main" id="list-productss">
          <?php if($cart_data == ''): ?><div class="four_null" style="display:block;"><img src="/Public/image/cartnull.png" alt=""></div>
          <?php else: ?>
            <div class="list-product">
              <div class="mod-cart scrollers">
                  <div class="receive ui-graybg block" id="receive-ui-graybg">
                      <div class="addr tap-action" data-tap="selectAddr" id="selectAddr">
                          <div class="hide_Divs" style="display:block;"  id="" data-index="0">
                            <table class="addr-table" width="100%">
                              <tbody id="tbodys">
                                <?php if($address_default != ''): ?><input type="hidden" value="<?php echo ($address_default['userid']); ?>" id="userids">
                                  <th width="65px">收&nbsp;&nbsp;货&nbsp;&nbsp;人</th>
                                  <td class="cart_name"><?php echo ($address_default['username']); ?></td>
                                  <td rowspan="3" width="40px" class="addr-change">
                                      <a href="javascript:void(0);"><span class="group-strong"><img src="/Public/image/me_arrow_icon.png" alt=""></span>
                                      </a>
                                  </td></tr>
                                  <tr><th>电<span class="ui-hidden">中中</span>话</th><td class="cart_phone"><?php echo ($address_default['phone']); ?></td></tr>
                                  <tr><th>收货地址</th><td class="cart_adds"><?php echo ($address_default['cityname']); ?>&nbsp;<?php echo ($address_default['district']); ?></td></tr>
                                  <input type="hidden" name="addressid" value="<?php echo ($address_default['addressid']); ?>" id="addressid">
                                  <input type="hidden" name="lng" value="<?php echo ($address_default['lng']); ?>" id="tablng">
                                  <input type="hidden" name="lat" value="<?php echo ($address_default['lat']); ?>" id="tablat">

                                <?php else: ?>
                                   <tr><th class="addr-table-th">请选择收货地址</th>
                                       <td rowspan="3" width="40px" class="addr-change">
                                           <a href="javascript:void(0);">
                                               <span class="group-strong">
                                                   <img src="/Public/image/me_arrow_icon.png" alt="">
                                               </span>
                                           </a>
                                       </td>
                                   </tr><?php endif; ?>
                              </tbody>
                            </table>
                          </div>
                          <div class="hide_Divs" id="hide_Divs" data-index="1">
                            <ul class="hideDivs_list">
                                <li><span>自提点</span><p><?php echo ($cart_data['shop_data']['shop_name']); ?></p></li>
                                <li><span>营业时间</span><p><?php echo ($cart_data['shop_data']['shop_opentime']); ?><a href="tel:<?php echo ($cart_data['shop_orderphone1']); ?>"><?php echo ($cart_data['shop_data']['shop_orderphone1']); ?></a></p></li>
                                <li><span>自提地址</span><p>
                                  <?php echo ($cart_data['shop_data']['shop_address']); ?>
                                </p></li>
                            </ul>
                          </div>
                      </div>          
                  </div>
                  <input type="hidden" value="<?php echo ($shop_data["shop_open_status"]); ?>" id="shop_open_status" name="shop_open_status">
                  <input type="hidden" value="<?php echo ($shop_data["shop_delivertime_status"]); ?>" id="shop_delivertime_status" name="shop_delivertime_status">
                  <input type="hidden" name="shop_deliver_type" id="shop_deliver_type" value="<?php echo ($cart_data['shop_data']['shop_deliver_type']); ?>">
                  <input type="hidden" name="distribution" id="distribution" value="<?php echo ($distribution); ?>">
                                                                                                                                                                                                                
                    <div class="mod-cart-info">
                        <!--START-->      
                          <?php if($normal_goods_data != '' ): ?><div class="cart_buyBox" id="cart_buyBox1">
                              <div class="cart_boxs">
                                    <div class="cart_boxs_head">
                                       <p class="cart_head_store"><a href="javascript:void(0);" class="abtn" id="abtn" data-id="<?php echo ($cart_data['shop_data']['shop_id']); ?>"><img src="/Public/image/home_icon.png" alt=""><?php echo ($cart_data['shop_data']['shop_name']); ?></a></p>
                                       <p class="cart_head_close">删除</p>
                                    </div>


                                    <div class="cartBx-title" id="cartBx-title" data-song="no">
                                      <div class="distri_div" id="distri_div1">
                                        <span id="span1">选择配送方式</span>
                                        <span class="span2" id="span2">配送时间</span>
                                      </div>
                                      <p class="distri_p"><span><?php echo ($normal_goods_data['shop_txt']); ?></span></p>
                                    </div>
                                    
                                    <div class="cartBx_xian flex padds3">
                                        <span class="cartBx_ximg blocks">即时</span>
                                        <div  class="cartBx_xsize flexs">
                                            <p>即时商品</p>
                                            <p class="p2">共<?php echo ($normal_goods_data['total_num']); ?>件</p>
                                        </div>
                                    </div>

                                    <div class="cart_buymain"> 

                                      <if condition="$normal_goods_data['goods_gift_data']['goods_list'] neq '' ">
                                        <div class="have_favorable favorable_div">
                                            <div class="titleH2">
                                              <img src="/Public/image/buy.png" alt="">
                                              <p class="p1">
                                                <span class="span"><?php echo ($normal_goods_data['goods_gift_data']['act_data']['act_name']); ?></span>
                                                <b><?php echo ($normal_goods_data['goods_gift_data']['act_data']['act_desc']); ?></b>
                                              </p>
                                            </div>

                                            <div class="enjoy-box">
                                              <div class="lines"></div>
                                              <?php if(is_array($normal_goods_data['goods_gift_data']['goods_list'])): foreach($normal_goods_data['goods_gift_data']['goods_list'] as $key=>$vo): if($vo["goods_type"] == 1): ?><div class="enjoy-good-info enjoy-divs" goods-id="<?php echo ($vo['goods_id']); ?>"  cart-id="<?php echo ($vo['cart_id']); ?>">
                                                  <div class="enjoy-info-left icon_left"><span>购</span></div>
                                                  <div class="enjoy-info-cent icon_cen">
                                                      <dl class="dis">
                                                          <dt class="dt"><img src="<?php echo ($vo['goods_pic']); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></dt>
                                                          <dd class="cart_boxs_info">
                                                                 <h2 class="ui-ellipsis"><?php echo ($vo['goods_name']); ?>
                                                                  <?php if($vo["goods_pungent"] != '' ): ?>(<?php echo ($vo['goods_pungent']); ?>)<?php endif; ?>
                                                                  <?php echo ($vo['goods_weight']); ?>
                                                                  <?php if($vo["goods_unit"] != '' ): ?>/<?php endif; ?>
                                                                  <?php echo ($vo['goods_unit']); ?></h2>
                                                                  <?php if($vo["act_name"] != '' ): ?><p class="zens"><span><?php echo ($vo['act_name']); ?></span></p><?php endif; ?>
                                                                 <p class="info_price info_price2s">￥<?php echo ($vo['price']); ?></p>
                                                             </dd>
                                                      </dl>
                                                  </div>
                                                  <div class="enjoy-info-right  icon_right">
                                                      <span class="goods_del"><img src="/Public/image/delcon.png" alt=""></span>
                                                      <input type="text" value="<?php echo ($vo['count']); ?>" name="text" class="goods_vals" readonly="readonly">
                                                      <span class="goods_add"><img src="/Public/image/addcon.png" alt=""></span>
                                                   </div>
                                              </div>
                                              <?php else: ?>
                                              <div class="enjoy-good-zeng enjoy-divs">
                                                   <div class="enjoy-zeng-left icon_left"><span>赠</span></div>
                                                   <div class="enjoy-zeng-cent icon_cen">
                                                       <dl class="dis">
                                                          <dt class="dt"><img src="<?php echo ($vo['goods_pic']); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></dt>
                                                          <dd class="cart_boxs_info">
                                                              <h2 class="ui-ellipsis"><?php echo ($vo['goods_name']); ?></h2>
                                                              <p class="zens"></p>
                                                              <p class="info_price info_price2s">￥<?php echo ($vo['price']); ?></p>
                                                          </dd>
                                                       </dl>
                                                    </div>
                                                    <div class="enjoy-zeng-right icon_right">                                     
                                                      <input type="text" value="<?php echo ($vo['count']); ?>" name="text">
                                                    </div>
                                              </div><?php endif; endforeach; endif; ?>
                                            </div>                                  
                                        </div><?php endif; ?>

                                      <?php if($normal_goods_data['goods_data']['goods_list'] != '' ): ?><div class="no_favorable  favorable_div">
                                            <div class="titleH2">
                                              <img src="/Public/image/raw.png" alt="">
                                              <p class="p1">
                                                <span class="span"><?php echo ($normal_goods_data['goods_data']['act_data']['act_name']); ?></span>
                                              </p>
                                            </div>
                                            <div class="enjoy-box">
                                              <div class="lines"></div>

                                              <?php if(is_array($normal_goods_data['goods_data']['goods_list'])): foreach($normal_goods_data['goods_data']['goods_list'] as $key=>$vo): ?><div class="not-good-info enjoy-divs" goods-id="<?php echo ($vo['goods_id']); ?>"  cart-id="<?php echo ($vo['cart_id']); ?>">
                                                    <div class="icon_left">
                                                        <span>购</span>
                                                    </div>
                                                    <div class="not-info-cent icon_cen">
                                                        <dl class="dis">
                                                             <dt class="dt"><img src="<?php echo ($vo['goods_pic']); ?>" alt=""  onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></dt>
                                                             <dd class="cart_boxs_info">
                                                                 <h2 class="ui-ellipsis"><?php echo ($vo['goods_name']); ?>
                                                                  <?php if($vo["goods_pungent"] != '' ): ?>(<?php echo ($vo['goods_pungent']); ?>)<?php endif; ?>
                                                                  <?php echo ($vo['goods_weight']); ?>
                                                                  <?php if($vo["goods_unit"] != '' ): ?>/<?php endif; ?>
                                                                  <?php echo ($vo['goods_unit']); ?></h2>
                                                                  <?php if($vo["act_name"] != '' ): ?><p class="zens"><span><?php echo ($vo['act_name']); ?></span></p><?php endif; ?>
                                                                 <p class="info_price info_price2s">￥<?php echo ($vo['price']); ?></p>
                                                             </dd>
                                                         </dl> 
                                                    </div>
                                                    <div class="not-info-right icon_right">
                                                        <span class="goods_del"><img src="/Public/image/delcon.png" alt=""></span>
                                                        <input type="text" value="<?php echo ($vo['count']); ?>" name="text"  class="goods_vals" readonly="readonly">
                                                        <span class="goods_add"><img src="/Public/image/addcon.png" alt=""></span>
                                                    </div>
                                                </div><?php endforeach; endif; ?>
                                            </div>
                                        </div><?php endif; ?>
                                      
                                      <?php if($normal_goods_data['gift_data']['goods_list'] != '' ): ?><div class="with_favorable favorable_div">
                                            <div class="titleH2">
                                              <img src="/Public/image/full.png" alt="">
                                              <p class="p1">
                                                <span class="span"><?php echo ($normal_goods_data['gift_data']['act_data']['act_name']); ?></span>
                                                <b><?php echo ($normal_goods_data['gift_data']['act_data']['act_desc']); ?></b>
                                              </p>
                                            </div>
                                            <div class="enjoy-box">
                                              <div class="lines"></div>
                                               <?php if(is_array($normal_goods_data['gift_data']['goods_list'])): foreach($normal_goods_data['gift_data']['goods_list'] as $key=>$vo): ?><div class="not-good-info enjoy-divs not-goods">
                                                    <div class="icon_left">
                                                        <span>赠</span>
                                                    </div>
                                                    <div class="not-info-cent icon_cen">
                                                        <dl class="dis">
                                                             <dt class="dt"><img src="<?php echo ($vo['goods_pic']); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></dt>
                                                             <dd class="cart_boxs_info">
                                                                 <h2 class="ui-ellipsis"><?php echo ($vo['goods_name']); ?>
                                                                  <?php if($vo["goods_pungent"] != '' ): ?>(<?php echo ($vo['goods_pungent']); ?>)<?php endif; ?>
                                                                  <?php echo ($vo['goods_weight']); ?>
                                                                  <?php if($vo["goods_unit"] != '' ): ?>/<?php endif; ?>
                                                                  <?php echo ($vo['goods_unit']); ?></h2>
                                                                  <?php if($vo["act_name"] != '' ): ?><p class="zens"><span><?php echo ($vo['act_name']); ?></span></p><?php endif; ?>
                                                                 <p class="info_price info_price2s">￥<?php echo ($vo['price']); ?></p>
                                                             </dd>
                                                         </dl> 
                                                    </div>
                                                    <div class="not-info-right icon_right">
                                                        <input type="text" value="<?php echo ($vo['count']); ?>" name="text"  class="goods_vals" readonly="readonly">
                                                    </div>
                                                </div><?php endforeach; endif; ?>
                                            </div>   
                                       </div><?php endif; endif; ?>
                                      <?php if($normal_goods_data != '' ): ?><div class="cartBx_go flex">
                                          <p class="go_price flexs"><span class="go_prices_color spans">共￥<b><?php echo ($normal_goods_data['goods_amount']); ?></b></span>
                                            <?php if($normal_youhui > 0 ): ?><span class="spans">(已优惠<i><?php echo ($normal_youhui); ?></i>元)</span><?php endif; ?>
                                          </p>
                                          <input type="button" name="button" value="选好了" id="submit1" class="inputs styleinput">
                                      </div>
                                    </div>
                              </div>         
                            </div><?php endif; ?>
                          <!--END-->
                        <!--START-->
                          <?php if($book_goods_data != '' ): ?><div class="cart_buyBox" id="cart_buyBox2">
                                <div class="cart_boxs">
                                      <div class="cart_boxs_head">
                                          <p class="cart_head_store"><a href="javascript:void(0);" class="abtn" id="abtn" data-id="<?php echo ($cart_data['shop_data']['shop_id']); ?>"><img src="/Public/image/home_icon.png" alt=""><span><?php echo ($cart_data['shop_data']['shop_name']); ?></span><img src="/Public/image/ring_icon.png" class="titleIvons"><span class="yu_span">新鲜预定美食</span></a>
                                          </p>
                                          <p class="cart_head_close">删除</p>
                                      </div>     
                                      <div class="cartBx">
                                        <div class="cartBx-title" id="cartBx-title2" data-song="yes">
                                          <div class="distri_div" id="distri_div2">
                                            <span id="spans1">选择配送方式</span>
                                            <span class="scolor spans2"  id="spans2">选择时间</span>
                                          </div>
                                          <p class="distri_p"><span><?php echo ($book_goods_data['shop_txt']); ?></span></p>
                                        </div>
                                        <div class="cartBx_xian flex">
                                            <span class="cartBx_ximg cartBx_ximg2 blocks">次日</span>
                                            <div  class="cartBx_xsize flexs">
                                                <p>预定商品</p>
                                                <p class="p2">共<?php echo ($book_goods_data['total_num']); ?>件</p>
                                            </div>
                                        </div>
                                        <div class="cart_buymain"> 
                                          <?php if($book_goods_data['goods_gift_data']['goods_list'] != '' ): ?><div class="have_favorable favorable_div">
                                                <div class="titleH2">
                                                  <img src="/Public/image/buy.png" alt="">
                                                  <p class="p1">
                                                    <span class="span"><?php echo ($book_goods_data['goods_gift_data']['act_data']['act_name']); ?></span>
                                                    <b><?php echo ($book_goods_data['goods_gift_data']['act_data']['act_desc']); ?></b>
                                                  </p>
                                                </div>

                                                <div class="enjoy-box">
                                                  <div class="lines"></div>
                                                  <?php if(is_array($book_goods_data['goods_gift_data']['goods_list'])): foreach($book_goods_data['goods_gift_data']['goods_list'] as $key=>$vo): if($vo["goods_type"] == 1): ?><div class="enjoy-good-info enjoy-divs" goods-id="<?php echo ($vo['goods_id']); ?>"  cart-id="<?php echo ($vo['cart_id']); ?>">
                                                      <div class="enjoy-info-left icon_left">
                                                          <span>购</span>
                                                      </div>
                                                      <div class="enjoy-info-cent icon_cen">
                                                          <dl class="dis">
                                                              <dt class="dt"><img src="<?php echo ($vo['goods_pic']); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></dt>
                                                              <dd class="cart_boxs_info">
                                                                     <h2 class="ui-ellipsis"><?php echo ($vo['goods_name']); ?>
                                                                      <?php if($vo["goods_pungent"] != '' ): ?>(<?php echo ($vo['goods_pungent']); ?>)<?php endif; ?>
                                                                      <?php echo ($vo['goods_weight']); ?>
                                                                      <?php if($vo["goods_unit"] != '' ): ?>/<?php endif; ?>
                                                                      <?php echo ($vo['goods_unit']); ?></h2>
                                                                      <?php if($vo["act_name"] != '' ): ?><p class="zens"><span><?php echo ($vo['act_name']); ?></span></p><?php endif; ?>
                                                                     <p class="info_price info_price2s">￥<?php echo ($vo['price']); ?></p>
                                                                 </dd>
                                                          </dl>
                                                        </div>
                                                      <div class="enjoy-info-right  icon_right">
                                                          <span class="goods_del"><img src="/Public/image/delcon.png" alt=""></span>
                                                          <input type="text" value="<?php echo ($vo['count']); ?>" name="text" class="goods_vals" readonly="readonly">
                                                          <span class="goods_add"><img src="/Public/image/addcon.png" alt=""></span>
                                                       </div>
                                                  </div>

                                                  <?php else: ?>
                                                  <div class="enjoy-good-zeng enjoy-divs">
                                                       <div class="enjoy-zeng-left icon_left">
                                                           <span>赠</span>
                                                       </div>
                                                       <div class="enjoy-zeng-cent icon_cen">
                                                           <dl class="dis">
                                                              <dt class="dt"><img src="<?php echo ($vo['goods_pic']); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></dt>
                                                              <dd class="cart_boxs_info">
                                                                  <h2 class="ui-ellipsis"><?php echo ($vo['goods_name']); ?></h2>
                                                                  <p class="zens"></p>
                                                                  <p class="info_price info_price2s">￥<?php echo ($vo['price']); ?></p>
                                                              </dd>
                                                           </dl>
                                                        </div>
                                                       <div class="enjoy-zeng-right icon_right">                                     
                                                           <input type="text" value="<?php echo ($vo['count']); ?>" name="text">
                                                       </div>
                                                  </div><?php endif; endforeach; endif; ?>

                                                </div>                                  
                                            </div><?php endif; ?>
                                          <?php if($book_goods_data['goods_data']['goods_list'] != '' ): ?><div class="no_favorable  favorable_div">
                                                <div class="titleH2">
                                                  <img src="/Public/image/raw.png" alt="">
                                                  <p class="p1">
                                                    <span class="span"><?php echo ($book_goods_data['goods_data']['act_data']['act_name']); ?></span>
                                                  </p>
                                                </div>
                                                <div class="enjoy-box">
                                                  <div class="lines"></div>

                                                  <?php if(is_array($book_goods_data['goods_data']['goods_list'])): foreach($book_goods_data['goods_data']['goods_list'] as $key=>$vo): ?><div class="not-good-info enjoy-divs" goods-id="<?php echo ($vo['goods_id']); ?>"  cart-id="<?php echo ($vo['cart_id']); ?>">
                                                        <div class="icon_left">
                                                            <span>购</span>
                                                        </div>
                                                        <div class="not-info-cent icon_cen">
                                                            <dl class="dis">
                                                                 <dt class="dt"><img src="<?php echo ($vo['goods_pic']); ?>" alt=""  onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></dt>
                                                                 <dd class="cart_boxs_info">
                                                                     <h2 class="ui-ellipsis"><?php echo ($vo['goods_name']); ?>
                                                                      <?php if($vo["goods_pungent"] != '' ): ?>(<?php echo ($vo['goods_pungent']); ?>)<?php endif; ?>
                                                                      <?php echo ($vo['goods_weight']); ?>
                                                                      <?php if($vo["goods_unit"] != '' ): ?>/<?php endif; ?>
                                                                      <?php echo ($vo['goods_unit']); ?></h2>
                                                                      <?php if($vo["act_name"] != '' ): ?><p class="zens"><span><?php echo ($vo['act_name']); ?></span></p><?php endif; ?>
                                                                     <p class="info_price info_price2s">￥<?php echo ($vo['price']); ?></p>
                                                                 </dd>
                                                             </dl> 
                                                        </div>
                                                        <div class="not-info-right icon_right">
                                                            <span class="goods_del"><img src="/Public/image/delcon.png" alt=""></span>
                                                            <input type="text" value="<?php echo ($vo['count']); ?>" name="text"  class="goods_vals" readonly="readonly">
                                                            <span class="goods_add"><img src="/Public/image/addcon.png" alt=""></span>
                                                        </div>
                                                    </div><?php endforeach; endif; ?>
                                                </div>
                                           </div><?php endif; ?>
                                          <?php if($book_goods_data['gift_data']['goods_list'] != '' ): ?><div class="with_favorable favorable_div">
                                                <div class="titleH2">
                                                  <img src="/Public/image/full.png" alt="">
                                                  <p class="p1">
                                                    <span class="span"><?php echo ($book_goods_data['gift_data']['act_data']['act_name']); ?></span>
                                                    <b><?php echo ($book_goods_data['gift_data']['act_data']['act_desc']); ?></b>
                                                  </p>
                                                </div>
                                                <div class="enjoy-box">
                                                  <div class="lines"></div>
                                                   <?php if(is_array($book_goods_data['gift_data']['goods_list'])): foreach($book_goods_data['gift_data']['goods_list'] as $key=>$vo): ?><div class="not-good-info enjoy-divs not-goods">
                                                        <div class="icon_left">
                                                            <span>赠</span>
                                                        </div>
                                                        <div class="not-info-cent icon_cen">
                                                            <dl class="dis">
                                                                 <dt class="dt"><img src="<?php echo ($vo['goods_pic']); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'"></dt>
                                                                 <dd class="cart_boxs_info">
                                                                     <h2 class="ui-ellipsis"><?php echo ($vo['goods_name']); ?>
                                                                      <?php if($vo["goods_pungent"] != '' ): ?>(<?php echo ($vo['goods_pungent']); ?>)<?php endif; ?>
                                                                      <?php echo ($vo['goods_weight']); ?>
                                                                      <?php if($vo["goods_unit"] != '' ): ?>/<?php endif; ?>
                                                                      <?php echo ($vo['goods_unit']); ?></h2>
                                                                      <?php if($vo["act_name"] != '' ): ?><p class="zens"><span><?php echo ($vo['act_name']); ?></span></p><?php endif; ?>
                                                                     <p class="info_price info_price2s">￥<?php echo ($vo['price']); ?></p>
                                                                 </dd>
                                                             </dl> 
                                                        </div>
                                                        <div class="not-info-right icon_right">
                                                            <input type="text" value="<?php echo ($vo['count']); ?>" name="text"  class="goods_vals" readonly="readonly">
                                                        </div>
                                                    </div><?php endforeach; endif; ?>
                                                </div>   
                                            </div><?php endif; ?>                                   
                                          <div class="cartBx_go flex">
                                              <p class="go_price flexs"><span class="go_prices_color spans">共￥<b><?php echo ($book_goods_data['goods_amount']); ?></b> 元</span>
                                                <?php if($book_youhui > 0 ): ?><span class="spans">(已优惠<i><?php echo ($book_youhui); ?></i>元)</span><?php endif; ?>
                                              </p>
                                              <input type="button" name="button" value="选好了"  id="submit2" class="inputs styleinput">
                                          </div>
                                        </div>
                                      </div>         
                                </div>
                            </div><?php endif; ?>
                        <!--END-->
                    </div>
                      <!--****************************-->
                </div>
            </div>
          </if>
        </div>
    </div>
    <div id="adds_selections" class="adds_selection pageview" style="display:none">
      <header class="pub-header">
            <span class="tap-action icon icon-back" id="iconst"></span>
            <div class="header-content">选择地址</div>
        </header>
        <div id="adds_selection" class="main main-both mainTops" style="overflow: hidden;">
            <div id="list-product" class="list-product">
                <div class="addrlist_main">
                    <div class="main wayMins main-bottom add_main" id="adds-main-one">
                        <div class="scrollers" id="addselect_mins">
                          <?php if(is_array($address_get_data)): foreach($address_get_data as $key=>$vo): ?><dl class="addselect_boxs" >
                                  <dt class="addselect_input">
                                    <input type="checkbox" type="checkbox"  <?php if($vo["default"] == '1' ): ?>checked class="inputColor"<?php endif; ?>>
                                  </dt>
                                  <dd class="addselect_con">
                                      <a href="javascript:void(0);">
                                          <div class="addselect_names">
                                              <span class="cartname"><?php echo ($vo["username"]); ?></span>
                                              <span class="cartphone"><?php echo ($vo["phone"]); ?></span>
                                          </div>
                                          <p class="addselect_del">
                                              <span><?php echo ($vo["cityname"]); ?></span>&nbsp;<span><?php echo ($vo["district"]); ?></span>&nbsp;<span><?php echo ($vo["address"]); ?></span>
                                          </p>
                                      </a>
                                  </dd>
                                  <dd class="addselect_con2 topLocation" data-indexs="<?php echo ($vo["addressid"]); ?>|<?php echo ($vo["cityname"]); ?>|<?php echo ($vo["district"]); ?>|<?php echo ($vo["lng"]); ?>|<?php echo ($vo["lat"]); ?>|<?php echo ($vo["city_baiducode"]); ?>|<?php echo ($vo["address"]); ?>|<?php echo ($vo["username"]); ?>|<?php echo ($vo["phone"]); ?>">
                                    <!--
                                        /Address/edit?address_id=<?php echo ($vo["addressid"]); ?>&cityname=<?php echo ($vo["cityname"]); ?>&district=<?php echo ($vo["district"]); ?>&x=<?php echo ($vo["lng"]); ?>&y=<?php echo ($vo["lat"]); ?>&cityCode=<?php echo ($vo["city_baiducode"]); ?>&address=<?php echo ($vo["address"]); ?>&name=<?php echo ($vo["username"]); ?>&mobile=<?php echo ($vo["phone"]); ?>      
                                    -->
                                      <a href="/Address/edit?address_id=<?php echo ($vo["addressid"]); ?>&cityname=<?php echo ($vo["cityname"]); ?>&district=<?php echo ($vo["district"]); ?>&x=<?php echo ($vo["lng"]); ?>&y=<?php echo ($vo["lat"]); ?>&cityCode=<?php echo ($vo["city_baiducode"]); ?>&address=<?php echo ($vo["address"]); ?>&name=<?php echo ($vo["username"]); ?>&mobile=<?php echo ($vo["phone"]); ?> "><img src="/Public/image/icon-edit.png" alt=""></a>
                                  </dd>
                                  <input type="hidden" name="addressid" value="<?php echo ($vo["addressid"]); ?>">
                                  <input type="hidden" name="lng" value="<?php echo ($vo["lng"]); ?>">
                                  <input type="hidden" name="lat" value="<?php echo ($vo["lat"]); ?>">
                                </dl><?php endforeach; endif; ?>
                        </div>
                    </div>
                    <!--end-->
                    <!--start-->
                    <div  class="main wayMins main-top "  id="adds-main3">
                          <!--自提商户显示-->
                          <div class="box_near_shang">
                            <ul class="generic-list">
                              <li class="generic-Boxli">
                                  <div class="generic-item">
                                      <div class="generic-item-img" data-id="<?php echo ($shop_data["shop_id"]); ?>">
                                          <?php if(($shop_data["shop_isvip"]) == "3"): ?><a href="javascript:void(0);" onclick="getclickinfo('代售点不能购买产品');">
                                                  <?php else: ?>
                                                  <a href="javascript:void(0);"><?php endif; ?>
                                            <img class="image autos" src="<?php echo ($shop_data["shop_avatar"]); ?>" alt="" onerror="this.src='http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd'">
                                          </a>
                                      </div>
                                      <div class="generic-item_info ui-ellipsis" data-id="<?php echo ($shop_data["shop_id"]); ?>">
                                          <?php if(($shop_data["shop_isvip"]) == "3"): ?><a href="javascript:void(0);" onclick="getclickinfo('代售点不能购买产品');">
                                                  <?php else: ?>
                                                  <a href="javascript:void(0);"><?php endif; ?>
                                              <div class="lis-title ui-ellipsis">
                                                  <h2 class="ui-ellipsis"><?php echo ($shop_data["shop_name"]); ?></h2>
                                                  <?php if($shop_data["shop_isvip"] == 1): ?><img class="liimg" src="/Public/image/bq-red.png" alt="">
                                                      <?php elseif($shop_data["shop_isvip"] == 2): ?>
                                                      <img class="liimg" src="/Public/image/bq-gre.png" alt="">
                                                      <?php elseif($shop_data["shop_isvip"] == 3): ?>
                                                      <img class="liimg" src="/Public/image/bq-yell.png" alt=""><?php endif; ?>
                                              </div>
                                              <?php if($shop_data["score"] > 0): ?><div class="mens_details_x">
                                                 <div class="wrap_x" id='wrap_cartx0' data-index="<?php echo ($shop_data["score"]); ?>" data-id="0">
                                                      <div id="cur" class="cur" ></div>
                                                  </div>
                                              </div>
                                              <?php else: ?>
                                              <div class='zanwu'>暂无评价</div><?php endif; ?>
                                              <p class="generic-item-sh">已售<span><?php echo ($shop_data["shop_totalordercount"]); ?></span></p>
                                          </a>
                                      </div>
                                      <div class="generic-item_mi">
                                          <a href="/shop/navigation?user=<?php echo ($user_current['district']); ?>&shop=<?php echo ($shop_data["shop_address"]); ?>&user_x=<?php echo ($user_current['x']); ?>&user_y=<?php echo ($user_current['y']); ?>&shop_x=<?php echo ($shop_data["shop_baidux"]); ?>&shop_y=<?php echo ($shop_data["shop_baiduy"]); ?>">
                                              <img src="/Public/image/icon-d.png" alt="">
                                              <p><?php echo ($shop_data["distance"]); ?></p>
                                          </a>
                                     </div>                                  
                                  </div>
                                  <div class="generic-address">
                                      <span class="blocks ui-ellipsis"><?php echo ($shop_data["shop_address"]); ?></span>
                                  </div>
                                  <div class="generic-not-mention">
                                      <?php if($shop_data["shop_deliver_type"] == 1): ?><p class="generic-carry generic-song <?php if(($shop_data["shop_open_status"] == 2) OR ($shop_data["shop_delivertime_status"] == 2)): ?>generic-hui<?php endif; ?>">
                                              <span>送</span><b><?php echo ($shop_data["shop_updeliverfee"]); ?></b>元起送/配送费<b>￥<?php echo ($shop_data["shop_deliverfee"]); ?></b>
                                          </p><?php endif; ?>
                                      <p class="generic-carry generic-zi <?php if($shop_data["shop_open_status"] == 2): ?>generic-hui<?php endif; ?>">
                            
                                          <?php if($shop_data["shop_deliver_type"] == 1): ?><span>自</span>在线下单，到店自提</p>
                                          <?php else: ?>
                                          <span>店</span>仅支持到店购买</p><?php endif; ?>
                            
                                          <?php if($shop_data["shop_orderphone1"] != ''): ?><a href="tel:<?php echo ($shop_data["shop_orderphone1"]); ?>" class="generic-a blocks">
                                          <?php elseif($shop_data["shop_orderphone2"] != ''): ?>
                                              <a href="tel:<?php echo ($shop_data["shop_orderphone2"]); ?>" class="generic-a blocks">
                                          <?php else: ?>
                                              <a href="javascript:void(0);" class="generic-a blocks"><?php endif; ?>
                                          <img src="/Public/image/icon-phone.png" alt="">
                                          </a>
                                  </div>
                              </li>
                            </ul>
                          <!--自提商户显示结束-->
                          </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pub-cart add-put adds_hides" >
            <a href="/Address/add" class="adda">
                +新增收货地址
            </a>
        </div> 
    </div>
    <div id="mod_pay_distribution" class="modpay1 mod_pay_distribution pageview" style="display:none" data-index="0">
        <header class="pub-header">
            <span class="tap-action icon icon-back" data-tap="!back"></span>
            <div class="header-content ">配送方式和时间</div>
        </header>
        <div class="mod_pay_main">
          <div class="mod_way">
              <h2>配送方式</h2>
              <div class="hairline"></div>
              <input type="hidden" value="0" id="hide_input" name="deliver_type"> 
              <div class="mod_dir_way mod_dir_way1">
                    <div class="mod_dir_way_one wayDiv">
                      <input type="radio" name="radios" checked="checked" class="checks" data-index='0' value="即时送货">
                      <span>即时送货</span>
                      <input type="hidden" value="" name="hide-times">
                    </div>
                    <div class="mod_dir_way_two wayDiv" id="mod_dir_way_two">
                        <input type="radio" name="radios" value="到店自提"  data-index='1'>
                        <span>到店自提</span>
                    </div>
                    <div class="mod_dir_way_three wayDiv">
                       <input type="radio" name="radios" data-index='2' value="预约送货">
                        <span>预约送货</span>
                    </div>
                </div>
          </div>
        </div>
        <div class="Next_step">
            <span>下一步</span>
        </div>
        <div id="mod_pay_dist" class="main main-top" style="overflow: hidden;">
           <div class="scrollers">
                <div class="mod_pay_hide" >
                    <div>
                      <div class="mod_pay_bth">
                         <p class="pay_timeSize1">送货时间</p>
                         <div class="hairline"></div>
                         <div class="mod_pay_divs mod_pay_divs1">
                            <p class="p_green">今天</p>
                            <p>其他日期</p>
                         </div>
                         <div class="hairline"></div>
                      </div>
                      <div class="clears"></div>
                      <div class="mod_pay_data" id="mod_pay_data1">
                        <div class="mod_show mod_show1 mod_today" id="mod_today" style="display:block;" data-index='0'>
                          <div class="mod_pay_set">
                              <p class="mod_pay_ps mod_pay_ps1"><?php echo date('Y年m月d日',time());?>(今天)</p>
                              <div class="hairline"></div>
                          </div>
                          <ul class="mod_pay_uls mod_pay_uls1" data-index="0">
                            <?php if(is_array($time_arr)): foreach($time_arr as $key=>$vo): ?><li><span><?php echo ($vo); ?></span></li><?php endforeach; endif; ?>
                         </ul>
                         <div class="mpu_uBtn">
                            <span>下一步</span>
                         </div>
                        </div>
                        <div class="mod_show mod_show1 mod_otherdate" id="mod_otherdate" data-index='1'>
                          <div class="mod_pay_set">
                              <p>
                                <span>(点击选择日期)</span>
                                <select name="book_day" id="book_day1" clsss="book_day">
                                  <?php if(is_array($normal_goods_data['book_day_time'])): foreach($normal_goods_data['book_day_time'] as $key=>$vo): ?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
                                </select>
                              </p>
                              <div class="hairline"></div>
                          </div>
                          <ul class="mod_pay_uls mod_pay_uls1"  data-index="1">
                            <?php if(is_array($normal_goods_data['book_hour'])): foreach($normal_goods_data['book_hour'] as $key=>$vo): ?><li><span><?php echo ($vo); ?></span></li><?php endforeach; endif; ?>
                         </ul>
                         <div class="mpu_uBtn">
                            <span>下一步</span>
                         </div>
                        </div>
                      </div>
                    </div>
                </div>
           </div>
         </div>     
    </div>
    <div id="mod_pay_distribution2" class="modpay2 mod_pay_distribution  mod_pay_distribution2 pageview"  style="display:none"data-index="1">
        <header class="pub-header">
            <span class="tap-action icon icon-back" data-tap="!back"></span>
            <div class="header-content ">配送方式和时间</div>
        </header>
        <div class="mod_pay_main">
          <div class="mod_way">
              <h2>配送方式</h2>
              <div class="hairline"></div>
              <input type="hidden" value="0" id="hide_input" name="deliver_type"> 
              <div class="mod_dir_way mod_dir_way2">

                <div class="mod_dir_way_one wayDivs">
                  <input type="radio" name="radios" checked="checked" class="checks" data-index='0' value="预约送货">
                  <span>预约送货</span>
                  <input type="hidden" value="" name="hide-times2">
                </div>
                <!--<div class="mod_dir_way_two wayDivs" >
                    <input type="radio" name="radios" value="到店自提"  data-index='1'>
                    <span>到店自提</span>
                </div> -->
              </div>
          </div>
        </div>
        <div id="mod_pay_dist2" class="main main-top" style="overflow: hidden;">
           <div class="scrollers">
                <div class="mod_pay_hide" >
                    <div>
                      <div class="mod_pay_bth">
                         <p class="pay_timeSize2">送货时间</p>
                         <div class="hairline"></div>
                         <div class="mod_pay_divs mod_pay_divs2">
                            <p class="p_green">明天起</p>
                            <p>其他日期</p>
                         </div>
                         <div class="hairline"></div>
                      </div>
                      <div class="clears"></div>
                      <div class="mod_pay_data" id="mod_pay_data2">
                        <div class="mod_show mod_show2 mod_today" id="mod_today" style="display:block;" data-index='0'>
                          <div class="mod_pay_set">
                              <p class="mod_pay_ps mod_pay_ps2"><?php echo ($ymd); ?>(明天)</p>
                              <div class="hairline"></div>
                          </div>
                          <ul class="mod_pay_uls mod_pay_uls2" data-index="0">
                             <?php if(is_array($book_goods_data['book_hour'])): foreach($book_goods_data['book_hour'] as $key=>$vo): ?><li><span <?php if(($key) == "0"): ?>class="spans"<?php endif; ?>><?php echo ($vo); ?></span></li><?php endforeach; endif; ?> 
                         </ul>
                         <div class="mpu_uBtn">
                            <span>下一步</span>
                         </div>
                        </div>
                        <div class="mod_show mod_show2 mod_otherdate" id="mod_otherdate" data-index='1'>
                          <div class="mod_pay_set">
                              <p>
                                <span>(点击选择日期)</span>
                                <select name="book_day" id="book_day2" clsss="book_day">
                                  <?php if(is_array($book_goods_data['book_day_time'])): foreach($book_goods_data['book_day_time'] as $key=>$vo): ?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
                                </select>
                              </p>
                              <div class="hairline"></div>
                          </div>
                          <ul class="mod_pay_uls mod_pay_uls2"  data-index="1">
                            <?php if(is_array($book_goods_data['book_hour'])): foreach($book_goods_data['book_hour'] as $key=>$vo): ?><li><span><?php echo ($vo); ?></span></li><?php endforeach; endif; ?>
                         </ul>
                         <div class="mpu_uBtn">
                            <span>下一步</span>
                         </div>
                        </div>
                      </div>
                    </div>
                </div>
           </div>
         </div>     
    </div>
  </div>
<!--米-->
<input type="hidden" name="hide_m" id="hide_m" value="">
<input type="hidden" name="shop_deliverscope" id="shop_deliverscope" value="<?php echo ($cart_data['shop_data']['shop_deliverscope']); ?>">
<input type="hidden" name="shop_id" id="shop_id" value="<?php echo ($cart_data['shop_data']['shop_id']); ?>">
<input type="hidden" name="go_previous_shop_id" id="go_previous_shop_id" value="<?php echo ($shop_id); ?>">
<input type="hidden" name="normal_goods_data_art_ids" value="<?php echo ($normal_goods_data_art_ids); ?>" id="normal_goods_data_art_ids">
<input type="hidden" name="book_goods_data_art_ids" value="<?php echo ($book_goods_data_art_ids); ?>" id="book_goods_data_art_ids">
<input type="hidden" name="shop_lng" id="shop_lng" value="<?php echo ($cart_data['shop_data']['shop_lng']); ?>">
<input type="hidden" name="shop_lat" id="shop_lat" value="<?php echo ($cart_data['shop_data']['shop_lat']); ?>">
<!--现货和预定优惠券-->
<input type="hidden" name="normal_act_ticket" id="normal_act_ticket" value="<?php echo ($normal_goods_data['goods_gift_data']['ticket_info']['ticket_id']); ?>">
<input type="hidden" name="normal_goods_ticket" id="normal_goods_ticket" value="<?php echo ($normal_goods_data['gift_data']['goods_ticket']); ?>">
<!--配送方式-->
<input type="hidden" name="normal_deliver_type" id="normal_deliver_type" value="-1">
<!--预约时间-->
<input type="hidden" name="normal_time_ymd" id="normal_time_ymd" value="">
<input type="hidden" name="normal_time_hi" id="normal_time_hi" value="">

<!--现货配送方式按钮-->
<input type="hidden" name="button_id" value="-1" id="button_id">
<!--现货默认使用券ID-->
<input type="hidden" name="normal_ticket_id" id="normal_ticket_id" value="<?php echo ($normal_goods_data['normal_ticket_id']); ?>">
<!--预定券默认使用券ID-->
<input type="hidden" name="book_ticket_id" id="book_ticket_id" value="<?php echo ($book_goods_data['book_ticket_id']); ?>">
<input type="hidden" name="book_act_ticket" id="book_act_ticket" value="<?php echo ($book_goods_data['goods_gift_data']['ticket_info']['ticket_id']); ?>">
<input type="hidden" name="book_goods_ticket" id="book_goods_ticket" value="<?php echo ($book_goods_data['gift_data']['goods_ticket']); ?>">
<!--配送方式-->
<input type="hidden" name="book_deliver_type" id="book_deliver_type" value="-1">
<!--预约时间-->
<input type="hidden" name="book_time_ymd" id="book_time_ymd" value="">
<input type="hidden" name="book_time_hi" id="book_time_hi" value="">
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
<script type="text/javascript" src="/Public/js/cartIndex.js"></script>
</body>
</html>