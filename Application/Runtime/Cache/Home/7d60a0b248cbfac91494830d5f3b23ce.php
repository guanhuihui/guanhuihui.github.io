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
    <style type="text/css">#header-right-text{width:70px;font-size:15px;right:0px;text-align:center;}</style>
<body>
    <div id="mod-container" class="mod-container clearfix">
        <div id="mod_pay_coupons" class="mod_pay_coupons mod_pay_couponk pageview">
            <header class="pub-header bgss">
                <a class="tap-action icon icon-back" href="/Index/index.html"></a>
                <div class="header-content ">优惠券</div>
                <span class="header-right header-right-text" id="header-right-text">我的订单</span>
            </header>
            <?php if(count($coupon_data) > 0): ?><div id="mod_coupons" class="main main-top mod_coupons" style="overflow: hidden;top:50px;">
                <div class="mod_coupons_main scrollers">
                    <div class="mod_coupons_input">
                       <input type="text" id="coupon" placeholder="请输入需绑定的第三方购买优惠券编码">
                       <span class="binds">绑&nbsp;定</span>
                    </div>
                    <div class="mod_coupons_t"> 
                        <a href="/me/app_html_all?url=http://www.hahajing.com/ticket/help&name=优惠券使用说明">
                          <img src="/Public/image/coupson_icon.png" alt="">
                          优惠券使用说明
                        </a>
                    </div>
                    <div class="mod_coupnss">
                        <?php if(is_array($coupon_data)): foreach($coupon_data as $key=>$vo): if(($vo["status"] == 1) OR ($vo["status"] == 0)): ?><dl class="mod_coupons_dl modCoupons_rs">
                           <span>
                            <?php if($vo["status"] == 1): ?><img src="/Public/image/coupon_using.png" alt="使用中">
                                <?php elseif($vo["status"] == 2): ?>
                                <img alt="已使用" src="/Public/image/coupon_used.png">
                                <?php elseif($vo["status"] == 3): ?>
                                <img alt="已作废" src="/Public/image/coupon_expired.png"><?php endif; ?>                      
                        </span>
                           <?php if(($vo['status']) == "0"): if($vo["surplus"] < 4): ?><b>还剩<?php echo ($vo["surplus"]); ?>天过期</b><?php endif; endif; ?>
                            <dd>
                                <div class="mod_coupons_left <?php if($vo["status"] == '0'): if($vo['ticket_price'] < '100'): ?>left_yellow <?php elseif($vo['discount_price'] == '0'): ?>left_skyblue<?php else: ?>left_red<?php endif; ?>
                                    <?php elseif($vo["status"] == 1): if($vo['ticket_price'] < '100'): ?>left_yellow <?php else: ?>left_red<?php endif; ?> <?php elseif($vo["status"] == 2): ?>left_gray <?php elseif($vo["status"] == 3): ?>left_gray<?php endif; ?>">
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
                                    <?php if(($vo['status']) == "0"): ?><a href="javascript:void(0);" ticket-id="<?php echo ($vo['ticket_id']); ?>" class="ticket_ida">立即使用 &gt;</a>
                                    <?php else: ?>
                                    <a href="javascript:void(0);" ticket-id="<?php echo ($vo['ticket_id']); ?>">立即使用 &gt;</a><?php endif; ?>
                                </div>
                            </dd>
                        </dl><?php endif; endforeach; endif; ?>
                    </div>
                    <!--查看所有开始-->
                    <div class="mod_coupnss hide" id="mod_coupnss">
                        <?php if(is_array($coupon_data)): foreach($coupon_data as $key=>$vo): if(($vo["status"] == 2) OR ($vo["status"] == 3)): ?><dl class="mod_coupons_dl">
                           <span>
                            <?php if($vo["status"] == 1): ?><img src="/Public/image/coupon_using.png" alt="使用中">
                                <?php elseif($vo["status"] == 2): ?>
                                <img alt="已使用" src="/Public/image/coupon_used.png">
                                <?php elseif($vo["status"] == 3): ?>
                                <img alt="已作废" src="/Public/image/coupon_expired.png"><?php endif; ?>                      
                        </span>
                           <?php if(($vo['status']) == "0"): if($vo["surplus"] < 4): ?><b>还剩<?php echo ($vo["surplus"]); ?>天过期</b><?php endif; endif; ?>
                            <dd>
                                <div class="mod_coupons_left <?php if($vo["status"] == '0'): if($vo['ticket_price'] < '100'): ?>left_yellow <?php elseif($vo['discount_price'] == '0'): ?>left_skyblue<?php else: ?>left_red<?php endif; ?>
                                    <?php elseif($vo["status"] == 1): if($vo['ticket_price'] < '100'): ?>left_yellow <?php else: ?>left_red<?php endif; ?> <?php elseif($vo["status"] == 2): ?>left_gray <?php elseif($vo["status"] == 3): ?>left_gray<?php endif; ?>">
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
                                    <?php if(($vo['status']) == "0"): ?><a href="javascript:void(0);">立即使用 &gt;</a>
                                    <?php else: ?>
                                    <a href="javascript:void(0);">立即使用 &gt;</a><?php endif; ?>
                                </div>
                            </dd>
                        </dl><?php endif; endforeach; endif; ?>
                    </div>
                    <!--查看所有结束-->
                    <div class="shBtn">
                        查看所有
                    </div>
                </div>
             </div>
             <?php else: ?>
                <div style="display:block;" class="four_null"><img src="/Public/image/conpous_null.png" alt=""></div><?php endif; ?>
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
<script type="text/javascript">
    var myScroll,
        list = {probeType: 3,mouseWheel: true,click: true,scrollbars: false},
        shBtn = $('.shBtn'),
        hideDiv = $('#mod_coupnss'),
        modCoupons_rs = $('.modCoupons_rs');
    $(document).ready(function() {  
        $('#mod_pay_coupons').show();
        myScrol1 = new IScroll('#mod_coupons',list );
        clicks();
        function clicks(){
            $('.header-right-text').on(tapClick(),function(){
                loaging.close();
                loaging.init('加载中...');
                window.location.href="/Order/index.html";
            })
            $('.binds').on(tapClick(),function(){
                var coupon=$("#coupon").val();
                 $.ajax({
                        url: '/Coupon/coupon_bind',
                        type: 'POST',
                        dataType: 'json',
                        data: {ticket_code:coupon},
                        beforeSend:function(){
                          loaging.init('加载中...');
                        }, 
                        success:function(result) {
                          layer.closeAll();
                          if (result.result=='ok'){
                            loaging.btn(result.msg);
                            window.location.href='/coupon/index';
                          }else{
                            loaging.btn(result.msg);
                          }
                        },error:function(){
                          layer.closeAll();
                        } 
                    })
            })
            shBtn.on(tapClick(),function(){
                if(hideDiv.hasClass('hide')){
                    hideDiv.removeClass('hide');
                }else{
                    hideDiv.addClass('hide');
                }
                myScrol1.refresh();
            })
            modCoupons_rs.off(tapClick());
            modCoupons_rs.on(tapClick(),function(){
                var ticket_id = $(this).find('.ticket_ida').attr('ticket-id');
                if(ticket_id){
                    commoms.post_server('/Coupon/get_ticket_shop',{ticket_id:ticket_id},function(re){
                        if(re.result == 'ok'){
                            window.location.href='/Category/index/shop_id/'+re.msg;
                        }else{
                            loaging.close();
                            loaging.btn(re.msg);
                        }
                    },function(){
                        loaging.close();
                    },false);
                }
                
    })
        }
    });
</script>
</body>
</html>