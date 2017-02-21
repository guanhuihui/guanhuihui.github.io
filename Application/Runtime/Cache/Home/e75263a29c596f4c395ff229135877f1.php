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
<script>(function(){var calc = function(){var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';};calc();window.addEventListener('resize',calc);})();</script> <link rel="stylesheet" href="/Public/css/style.css"><script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script><script type="text/javascript" src="/Public/js/lib/fastclick.js"></script><style type="text/css">.mod_cor .confrim_goods_coupons .goods_ps{line-height:30px; }.congoos-title{border-bottom:1px solid #ebebeb;line-height:45px;color:#121212;padding-right:3%}.congoos-title .goodstitle-span2{border:1px solid #16a9ff;display:block;line-height:24px;color:#16a9ff;margin:11px 3% 0 0;height:24px;border-radius:3px;padding:0 4px}.goods-infos{padding:1rem 0;width:100%;background-size:24px}.goods-infos .goodsInfo-item{text-align:center;margin-right:1.5%;width:15%;border-radius:5px;border:1px solid #ccc;overflow:hidden}.goodsInfo-item img{display:block;width:100%}.goods-infos .goodsInfo-item.goodsInfo-item2{border:0;color:#121212;padding-top:1.4rem;text-align:left}.commodity_bot{position:absolute;left:0;right:0;bottom:53px;border-top:#ddd solid 1px;background-color:#fff7e8;padding:0 4%}.bot-left-title{height:50px;display:block;padding-top:5px;width:100%;display:-webkit-box;display:box}.commodity_bot .bot-left-p{color:#666;font-size:12px}.commodity_bot .bot-left-h2{color:#121212;font-size:15px}.commodity_bot .bot-icon{display:inline-block;width:26px;height:26px;text-align:center;margin-top:6px}.bot-icon img{display:block;width:100%;vertical-align:center;border-radius:50%;-webkit-transition:all linear .3s;transition:all linear .3s}.botleft-uls{display:none;-webkit-transition:all linear .3s;transition:all linear .3s}.botleft-uls .botleft-items{height:30px;color: #121212;}.botleft-uls .botleft-items .img{width:18px;margin-right:2px}</style>
<body>
    <form action="/Order/add" id="formid" method="post" >
    <div id="mod-container" class="mod-container clearfix">
        <div id="mod_confirm_order" class="mod_confirm_order mod_cor pageview" style="display:block;">
            <header class="pub-header">
                <span class="tap-action icon icon-back" data-tap="!back"></span>
                <div class="header-content ">确认订单</div>
            </header>

            <div id="mod_confirm-container" class="main main-both" style="bottom:120px;">
                <div class="scrollers">

            

                    <div class="distribution_mode generals">
                        <h2 class="g-h2">选择支付方式</h2>

                        <?php if(($data['pay_status'] == '1') and ($data['shop_pay_status'] == '1')): if($openid == '' ): ?><input type="hidden" name="pay_type" id="hidexuan" value="20">
                        <?php else: ?>
                        <input type="hidden" name="pay_type" id="hidexuan" value="10"><?php endif; ?>
                        <?php else: ?>
                        <input type="hidden" name="pay_type" id="hidexuan" value="40"><?php endif; ?>

                        <ul class="dmode_menu">
                            <?php if(($data['pay_status']) == "1"): if(($data['shop_pay_status']) == "1"): if($openid == '' ): ?><li class="dmode_lis flex" data-index="20">
                                                <p class="dp flexs"><img src="/Public/image/zmode.png" class="dimg" alt="">支付宝支付<span class="dp_span"><?php echo ($data["discount_txt"]); ?></span></p>
                                                <span class="dspan blocks">
                                                    <?php if($openid == '' ): ?><img src="/Public/image/selectok.png" class="imgs dimg" alt="">
                                                    <?php else: ?>
                                                    <img src="/Public/image/selectno.png" class="imgs dimg"  alt=""><?php endif; ?>
                                                </span>
                                            </li><?php endif; ?>
                                        <?php if($openid != '' ): ?><li class="dmode_lis flex"  data-index="10">
                                                <p class="dp flexs"><img src="/Public/image/wmode.png"  class="dimg" alt="">微信支付<span class="dp_span"><?php echo ($data["discount_txt"]); ?></span></p>
                                                <span class="dspan blocks">
                                                    <?php if($openid != '' ): ?><img src="/Public/image/selectok.png" class="imgs dimg" alt="">
                                                    <?php else: ?>
                                                    <img src="/Public/image/selectno.png" class="imgs dimg"  alt=""><?php endif; ?>
                                                </span>
                                            </li><?php endif; endif; endif; ?>
                            <?php if(($request_data['is_book_goods'] == '0') and ($data['shop_deliver_merchant'] == '0')): ?><li class="dmode_lis flex"  data-index="40">
                                <p class="dp flexs"><img src="/Public/image/dmode.png" class="dimg" alt="">货到付款</p>
                                <span class="dspan blocks">
                                <?php if(($data['pay_status'] == '0') or ($data['shop_pay_status'] == '0')): ?><img src="/Public/image/selectok.png" class="imgs dimg" alt="">
                                    <?php else: ?>
                                    <img src="/Public/image/selectno.png" class="imgs dimg" alt=""><?php endif; ?>
                            

                                </span>
                            </li><?php endif; ?>
                        </ul>
                    </div>
    






                    <div class="confrim_Leave flex marTop rightbg">
                      <span class="blocks">备注</span>
                      <div class="confrim_Leave_right flexs">
                          <textarea name="message" id="textarea" class="styleinput" maxlength="30"  placeholder="其他要求（如带一个红塔山）"></textarea>
                      </div>
                    </div>




                    <div class="confrim_goods_coupons generals marTop flex" id="cong_coupons">
                        <span class="coupons_title">优惠券</span>
                        <div class="goods_ps flexs">
                            <p class="goods_ps1"><?php echo ($ticket_str); ?></p>
                            <!-- <span><b class="goods_ps2"><?php echo ($ticket_str_buttom); ?></b></span> -->
                        </div>

                    </div>


    
                    
                    <input type="hidden" name="goods_amount" id="goods_amounts" value="<?php echo ($data['goods_amount']); ?>">
                    <input type="hidden" name="post_fee" id="post_fees" value="<?php echo ($data['post_fee']); ?>">


                    <div class="Details_Charges generals marTop">
                        <div class="confirm-goods">
                            <p class="flex congoos-title flexsJusi">
                                <span class="blocks"><?php echo ($data['shop_name']); ?></span>
                                <?php if($data['shop_deliver_merchant'] == '2' ): ?><span class="blocks goodstitle-span2">达达专送</span><?php endif; ?>
                            </p>
                            <ul class="goods-infos flex">
                                <?php if(is_array($data['new_goods_list'])): foreach($data['new_goods_list'] as $key=>$vo): if($key < '4' ): ?><li class="goodsInfo-item"><img src="<?php echo ($vo['goods_pic']); ?>" alt=""></li><?php endif; endforeach; endif; ?>
                                <?php if(count($data['new_goods_list']) > '4' ): ?><li class="goodsInfo-item"><img src="/Public/image/more_goods2.png" alt=""></li><?php endif; ?>
                                <li class="goodsInfo-item goodsInfo-item2">共<span id="cz_num"><?php echo ($data['total_quantity']); ?></span>件</li>
                            </ul>
                        </div>
                    <!-- <h2 class="g-h2">费用明细</h2> -->
                        <ul class="dCharges_menu">
                            <li class="dCharges_lis flex flexsJusi">
                                <p class="dc_title">商品总额</p>
                                <p class="dc_price blocks">￥<span id="d-Price"><?php echo ($data['goods_amount']); ?></span></p>
                            </li>
                            <li class="dCharges_lis flex flexsJusi">
                                <p class="dc_title">配送费</p>
                                <p class="dc_price blocks">￥<span id="ps-Price"><?php echo ($data['post_fee']); ?></span></p>
                            </li>
                            <li class="dCharges_lis flex flexsJusi">
                                <p class="dc_title">优惠金额</p>
                                <p class="dc_price blocks">-￥<span id="yo-Price"><?php echo ($data['discount']); ?></span></p>
                            </li>
                            <li class="dCharges_lis flex flexsJusi">
                                <p class="dc_title">应付金额：</p>
                                <p class="dc_price blocks">￥<span id="size_price"><?php echo ($data['total_amount']); ?></span></p>
                            </li>
                        </ul>
                    </div>


                    


                     <div class="commodity_fs generals marTop">
                        <h2 class="g-h2">配送方式</h2>
                        <div class="fs_divs">
                            <p class="fs_info"><?php if(($deliver_type) == "0"): if(($time_ymd) == "0"): ?>即时送货<?php else: ?>送货上门<?php endif; else: ?>到店自提<?php endif; ?></p>
                            <p class="fs_timer"><?php if(($time_ymd) != "0"): echo ($time_ymd); endif; ?></p>
                            <p class="fs_dels">配送地址：<?php echo ($data['address_info']['area']); ?>&nbsp;<?php echo ($data['address_info']['address']); ?></p>
                            <p class="fs_dels">配送距离:<?php echo ($gongli); ?>&nbsp;公里</p>
                        </div>
                    </div> 




                </div>
            </div>
           <!--  <div class="commodity_zong  generals marTop flex flexsJusi" style="position:absolute;left:0;right:0;bottom:53px;border-top:#ddd solid 1px;">
                <p>商品总数</p><p class="blocks">共：<span id="cz_num"><?php echo ($goods_count); ?></span>件</p>
            </div> -->
            <!-- <div class="commodity_zong  generals marTop flex" style="position:absolute;left:0;right:0;bottom:44px;border-top:#ddd solid 1px;line-height:30px;">
                <p>提示：</p><p class="blocks" style="color:red;font-size:12px;">（预定商品支付后暂不支持取消及退款）</p>
            </div> -->
            <div class="commodity_bot">
                <div class="bot-left">
                    <div class="bot-left-title flex">
                        <div class="flexs">
                            <p class="bot-left-p">所购商品如遇缺货，您需要：</p>
                            <h2 class="bot-left-h2"><?php echo ($data['stockout_type'][1]); ?></h2>
                        </div>
                        <p class="bot-icon">
                            <img src="/Public/image/Category/bot-icon.png" alt="">
                        </p>
                    </div>
                    <ul class="botleft-uls">
                        <?php if(is_array($data['stockout_type'])): foreach($data['stockout_type'] as $key=>$vo): ?><li class="botleft-items" data-stockout="<?php echo ($key); ?>">
                            <img class="img" 
                            <?php if(($key) == "1"): ?>src="/Public/image/select_icons.png" alt="">
                            <?php else: ?>
                             src="/Public/image/select_icon.png" alt=""><?php endif; ?>
                            <span><?php echo ($vo); ?></span>
                        </li><?php endforeach; endif; ?>
                    </ul>
                    <input type="hidden" name='stockout_type' id="stockout_type" value='1'>
                    
                </div>
            </div>
            <div class="pub-cart shopping-empty">
                <span class="shopping-icon shopping-icon-size">
                    应付款：<span>￥<b><?php echo ($data['total_amount']); ?></b> 元</span>
                </span>

                <div class="submits" id="goods_submit">
                      <input type="button" value="提交订单" class="styleinput buttons submit-text shopping-submit-text">                  
                </div>
            </div>
        </div>











        <div id="mod_pay_coupons" class="mod_pay_coupons paycoupons pageview">
            <header class="pub-header">
                <span class="tap-action icon icon-back" data-tap="!back"></span>
                <div class="header-content ">优惠券</div>
            </header>
            <div id="mod_coupons" class="main main-top mod_coupons">
              <div class="coupon_iscroll">
                <!--five-->
                <div class="coupon_div coupon_five" id="coupon_five" data="0">
                  <?php if(is_array($ticket_data['daijin'])): foreach($ticket_data['daijin'] as $key=>$vo): ?><dl class="mod_coupons_dl <?php if(($vo["dump_gift"]) == "1"): ?>dl_test<?php endif; ?>" ticket-id="<?php echo ($vo["ticket_id"]); ?>">
                        <dt class="mod_coupons_input">
                           <input type="checkbox" name="checkboxone" <?php if($vo['is_check'] == '1'): ?>class="checks" checked<?php endif; ?> data-alert="<?php echo ($vo['ticket_tip']); ?>" data-state="<?php echo ($vo['state']); ?>" >
                        </dt>
                        <dd>
                            <div class="mod_coupons_left <?php if($vo['state'] == '0'): ?>left_gray <?php else: ?> <?php if($vo['ticket_price'] < '100'): ?>left_yellow <?php elseif($vo['discount_price'] == '0'): ?>left_skyblue<?php else: ?>left_red<?php endif; endif; ?>">
                                <h2>￥<span class="sprice"><?php echo ($vo["ticket_price"]); ?></span><b><?php echo ($vo["act_name"]); ?></b></h2>
                                <h3>使用区域：<span><?php echo ($vo["notes"]); ?></span></h3>
                                <p>使用说明：<?php echo ($vo["act_desc"]); ?></p>
                                <input type="hidden" name="ticket_id" value="<?php echo ($vo["ticket_id"]); ?>" class="ticket_id" ticket-id="<?php echo ($vo["ticket_id"]); ?>" data-dump-gift="<?php echo ($vo["dump_gift"]); ?>">
                            </div>
                            <div class="mod_coupons_right">
                              <br/>
                                <p>有效期</p>
                                <p><?php echo date('Y/m/d',strtotime($vo['start_date']));?></p>
                                <p><?php echo date('Y/m/d',strtotime($vo['end_date']));?></p>
                                
                            </div>
                        </dd>
                    </dl><?php endforeach; endif; ?>
                </div>
                <!--three-->
                <div class="coupon_div coupon_three" id="coupon_three" data="0">
                  <?php if(is_array($ticket_data['duihuan'])): foreach($ticket_data['duihuan'] as $key=>$vo): ?><dl class="mod_coupons_dl" ticket-id="<?php echo ($vo["ticket_id"]); ?>">
                        <dt class="mod_coupons_input">
                           <input type="checkbox" name="checkboxtwo" <?php if($vo['is_check'] == '1'): ?>class="checks" checked<?php endif; ?>  alet="<?php echo ($vo['ticket_tip']); ?>">
                        </dt>
                        <dd>
                            <div class="mod_coupons_left left_red">
                                <h2>￥<span class="sprice"><?php echo ($vo["ticket_price"]); ?></span><b><?php echo ($vo["act_name"]); ?></b></h2>
                                <h3>使用区域：<span><?php echo ($vo["notes"]); ?></span></h3>
                                <p>使用说明：<?php echo ($vo["act_desc"]); ?></p>
                                <input type="hidden" name="ticket_id" value="<?php echo ($vo["ticket_id"]); ?>" class="ticket_id" ticket-id="<?php echo ($vo["ticket_id"]); ?>" data-dump-gift="<?php echo ($vo["dump_gift"]); ?>">
                            </div>
                            <div class="mod_coupons_right">
                              <br/>
                                <p>有效期</p>
                                <p><?php echo date('Y/m/d',strtotime($vo['start_date']));?></p>
                                <p><?php echo date('Y/m/d',strtotime($vo['end_date']));?></p>
                                
                            </div>
                        </dd>
                    </dl><?php endforeach; endif; ?>

                </div>
                <!--beer-->
                <div class="coupon_div coupon_beer" id="coupon_beer" data="0">
                  <?php if(is_array($ticket_data['shiwu'])): foreach($ticket_data['shiwu'] as $key=>$vo): ?><dl class="mod_coupons_dl" ticket-id="<?php echo ($vo["ticket_id"]); ?>">
                        <dt class="mod_coupons_input">
                           <input type="checkbox" name="checkboxthree" <?php if($vo['is_check'] == '1'): ?>class="checks" checked<?php endif; ?> alet="<?php echo ($vo['ticket_tip']); ?>">
                        </dt>
                        <dd>
                            <div class="mod_coupons_left left_skyblue">
                                <h2><span class="sprice"></span><b><?php echo ($vo["act_name"]); ?></b></h2>
                                <h3>使用区域：<span><?php echo ($vo["notes"]); ?></span></h3>
                                <p>使用说明：<?php echo ($vo["act_desc"]); ?></p>
                                <input type="hidden" name="ticket_id" value="<?php echo ($vo["ticket_id"]); ?>" class="ticket_id" ticket-id="<?php echo ($vo["ticket_id"]); ?>" data-dump-gift="<?php echo ($vo["dump_gift"]); ?>">
                            </div>
                            <div class="mod_coupons_right">
                              <br/>
                                <p>有效期</p>
                                <p><?php echo date('Y/m/d',strtotime($vo['start_date']));?></p>
                                <p><?php echo date('Y/m/d',strtotime($vo['end_date']));?></p>
                            </div>
                        </dd>
                    </dl><?php endforeach; endif; ?>
                </div>
              </div>              
             </div>
        </div>
    </div>

    <input type="hidden" name="address_id" id="address_id" value="<?php echo ($request_data['address_id']); ?>">
    <input type="hidden" name="shop_id" id="shop_id" value="<?php echo ($request_data['shop_id']); ?>">
    <input type="hidden" name="cart_ids" id="cart_ids" value="<?php echo ($request_data['cart_ids']); ?>">
    <input type="hidden" name="deliver_type" id="deliver_type" value="<?php echo ($request_data['deliver_type']); ?>">
    <input type="hidden" name="time_ymd" id="time_ymd" value="<?php echo ($_time); ?>">
    <input type="hidden" name="is_book_goods" id="is_book_goods" value="<?php echo ($request_data['is_book_goods']); ?>">
    <input type="hidden" name="youhui_ticket_id" id="youhu_iticket_id" value="<?php echo ($request_data['ticket_list_ids']); ?>"><!--优惠券id--> 
    <input type="hidden" name="act_ticket" id="act_ticket" value="<?php echo ($request_data['act_ticket']); ?>"><!--活动券id-->
    <input type="hidden" name="goods_ticket" id="goods_ticket" value="<?php echo ($request_data['goods_ticket']); ?>"><!--实物券id-->

    <input type="hidden" name="user_name" id="user_name" value="<?php echo ($data['address_info']['username']); ?>">
    <input type="hidden" name="telphone" id="telphone" value="<?php echo ($data['address_info']['phone']); ?>">

    <!--判断是否有未使用的优惠券-->
    <input type="hidden" name="is_ticket" id="is_ticket" value="<?php echo ($ticket_count); ?>" data="0">

    <input type="hidden" name="deliver_distance" id="deliver_distance" value="<?php echo ($deliver_distance); ?>">
</form>
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
<script type="text/javascript" src="/Public/js/confirm.js"></script>
</body>
</html>