<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜便捷购</title>
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
    <!--<script type=text/javascript>//var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';</script>-->
<script>(function(){var calc = function(){var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';};calc();window.addEventListener('resize',calc);})();</script> <link rel="stylesheet" href="/Public/css/style.css"><script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script><script type="text/javascript" src="/Public/js/lib/fastclick.js"></script>
    <link rel="stylesheet" href="/Public/css/mobiscroll.css">
    <script type="text/javascript">
        document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
    </script>
</head>
<body> 
    <div id="mod-container" class="mod-container clearfix">
        <div id="mod_order_state" class="mod_order_state mostate pageview" style="display:block;">
            <header class="pub-header">
                <span class="tap-action icon icon-back" data-tap="!back"></span>
                <div class="header-content ">
                    <div class="head_box">
                        <p class="box_set">订单状态</p>
                        <p>订单详情</p>
                    </div>
                </div>
                <span class="header-right header-right-text" onclick="_MEIQIA('showPanel')">在线客服</span>
            </header>
            <div class="main main-both mainTops">
                <div id="list-product-state" class="list-product-state">
                    <div class="list-main scrollers">
                        <div class="list-state-one" id="list-state-one">
                            <div class="state-one-main">
                               <div class="about4">
                                    <div class="about4_main">
                                        <div class="line"></div>
                                        <ul class="state_menus">
                                            
                                           
                                        <?php if(is_array($order_log)): foreach($order_log as $key=>$vo): ?><li class="state_lis flex">
                                                <div class="bgs divs divR"></div>
                                                <div class="divs divsInfo">
                                                    <div class="slis_state flex flexsJusi ">
                                                      <p class="slis_se"><?php echo ($vo["log_info"]); ?></p>
                                                      <p class="slis_times"><span><?php echo date('Y-m-d H:i',$vo['add_time']);?></span></p>
                                                    </div>
                                                    <div class="slis_size">
                                                      <p><?php echo ($vo["log_desc"]); ?></p>
                                                    </div>
                                                </div>
                                            </li><?php endforeach; endif; ?>
                                            
                                        </ul>
                                    </div>
                               </div>
                            </div>
                        </div>
                        <div class="list-state-two" id="list-state-two">
                            <div>
                                <ul class="order-state-ul padds3">
                                    <li class="state-li">
                                    <input type="hidden" name="order_no" id="order_no" value="<?php echo ($order_detail["order_no"]); ?>">
                                    <input type="hidden" id="order_id" name="order_id" value="<?php echo ($order_detail["order_id"]); ?>">
                                        <span>订单编号:</span>
                                        <p><?php echo ($order_detail["order_no"]); ?></p>
                                    </li>
                                    <li class="state-li">
                                        <span>下单时间:</span>
                                        <p><?php echo date('Y年m月d日 H:i:s',$order_detail['add_time']);?></p>
                                    </li>
                                    <li class="state-li">
                                        <span>预计送达:</span>
                                        <p><?php echo ($order_detail["book_time"]); ?></p>
                                    </li>
                                    <li class="state-li">
                                        <span>配送店铺:</span>
                                        <p><?php echo ($order_detail["shop_name"]); ?></p>
                                    </li>
                                    <li class="state-li">
                                        <span>配送方式:</span>
                                        <p><?php if($order_detail["deliver_type"] == 0): ?>送货上门<?php elseif($order_detail["deliver_type"] == 1): ?>到店自提<?php endif; ?></p>
                                    </li>
                                    <li class="state-li">
                                        <span>支付方式:</span>
                                        <p><?php if($order_detail["pay_type"] == 10): ?>微信支付<?php elseif($order_detail["pay_type"] == 1): ?>支付宝支付<?php elseif($order_detail["pay_type"] == 40): ?>货到付款<?php endif; ?></p>
                                    </li>
                                    <li class="state-li">
                                        <span>订单类型:</span>
                                        <p><?php if($order_detail["order_type"] == 1): ?>现货订单<?php elseif($order_detail["order_type"] == 2): ?>预定订单<?php endif; ?></p>
                                    </li>

                                    <li class="state-li">
                                        <span>备注说明:</span>
                                        <p><?php if(($order_detail['user_messge']) == ""): ?>无
                                        <?php else: ?>
                                            <?php echo ($order_detail["user_messge"]); endif; ?></p>
                                    </li>
                                    <li class="state-li">    
                                        <span>店铺电话:</span>
                                        <p><?php echo ($order_detail["shop_phone"]); ?></p>
                                    </li>
                                    <input type="hidden" name="shop_id" value="<?php echo ($order_detail["shop_id"]); ?>" id="shop_id">
                                </ul>
                                <ol class="order-state-ol padds3">
                                    <li class="state-oli">
                                        <span>收&nbsp;货&nbsp;人:</span>
                                        <p><?php echo ($order_detail["user_name"]); ?></p>
                                    </li>
                                    <li class="state-oli">
                                        <span>电<b>&nbsp;种种</b>&nbsp;话:</span>
                                        <p><?php echo ($order_detail["mobile"]); ?></p>
                                    </li>
                                     <li class="state-oli">
                                        <span>收货地址:</span>
                                        <p><?php echo ($order_detail["city"]); ?> <?php echo ($order_detail["district"]); ?> <?php echo ($order_detail["address"]); ?></p>
                                    </li>
                                    <li class="state-oli state-olis">
                                        <span>配送店铺:</span>
                                        <div class="olis_dian">
                                          <p><?php echo ($order_detail["shop_name"]); ?></p>
                                            
                                          <i class="olis_b blocks" id="olis_b" data-isfav="<?php echo ($order_detail["is_fav"]); ?>"><?php if($order_detail["is_fav"] == 0): ?>+ 收藏<?php else: ?>已收藏<?php endif; ?></i>
                                          
                       
                                        
                                        </div>
                                    </li>
                                </ol>

                                <div class="order-state-detail">
                                    <h2>费用明细</h2>
                                        <ul class="clist_menu padds3">
                                            <?php if(is_array($goods_list)): foreach($goods_list as $key=>$vo): ?><li class="clist_lis flex">
                                                <p class="cy_name flexs ui-ellipsis"><?php echo ($vo['goods_name']); ?></p>
                                                <span class="cy_num blocks">x<?php echo ($vo['count']); ?></span>
                                                <span class="cy_price blocks">￥<?php echo ($vo['price']); ?></span>
                                            </li><?php endforeach; endif; ?>
                                            <?php if(is_array($other_list)): foreach($other_list as $key=>$vo): ?><li class="clist_lis flex">
                                                <p class="cy_name flexs ui-ellipsis"><?php echo ($vo['goods_name']); ?></p>
                                                <span class="cy_num blocks">x<?php echo ($vo['count']); ?></span>
                                                <span class="cy_price blocks">￥<?php echo ($vo['price']); ?></span>
                                            </li><?php endforeach; endif; ?>
                                            <?php if(is_array($other_gift)): foreach($other_gift as $key=>$vo): ?><li class="clist_lis flex">
                                                <p class="cy_name flexs ui-ellipsis"><?php echo ($vo['goods_name']); ?></p>
                                                <span class="cy_num blocks">x<?php echo ($vo['count']); ?></span>
                                                <span class="cy_price blocks">￥<?php echo ($vo['price']); ?></span>
                                            </li><?php endforeach; endif; ?>
                                        </ul>
                                    <div class="order-state-s">
                                        <div>
                                            <span>商品数量：</span>
                                            <p><?php echo ($gift_goods_count["size"]); ?>件</p>
                                        </div>
                                         <div>
                                            <span>赠品数量：</span>
                                            <p><?php echo ($gift_goods_count["gift_size"]); ?>件</p>
                                        </div>
                                         <div>
                                            <span>合计数量：</span>
                                            <p><?php echo ($order_detail["goods_count"]); ?>件</p>
                                        </div>
                                    </div>
                                    <div class="order-state-s">
                                        <div>
                                            <span>商品金额</span>
                                            <p>￥<?php echo ($order_detail["goods_amount"]); ?></p>
                                        </div>
                                         <div>
                                            <span>配送金额</span>
                                            <p>￥<?php echo ($order_detail["post_fee"]); ?></p>
                                        </div>
                                         <div>
                                            <span>优惠金额</span>
                                            <p class="reds" style="color:red;">- <b>￥<?php echo ($order_detail["discount"]); ?></b></p>
                                        </div>
                                         <div>
                                            <span>实付金额</span>
                                            <p>￥<?php echo ($order_detail["total_amount"]); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pub-cart flex flexsJusi">
                <div class="pub_del">
                    <?php if(($order_detail["order_status"] == 8) or ($order_detail["order_status"] == 6)): ?><span class="pub_sp" id="pub_sp">删除订单</span><?php endif; ?>
                </div>
                <div class="pub_btn flexs">
                  <span class="pub_span"><a style="color:#fff;" href="javascript:void(0);" class="again_btn" data-shop-id="<?php echo ($order_detail["shop_id"]); ?>" data-order-no="<?php echo ($order_detail["order_no"]); ?>" >再来一单</a></span>
                  <?php if(($order_detail["order_status"] == 1) or ($order_detail["order_status"] == 10 and $order_detail["pay_status"] != '30') or ($order_detail["order_status"] == 2 and $order_detail["pay_status"] != '30')): ?><span class="pub_span" id="pub_span">取消订单</span>
                  <?php if($order_detail["pay_status"] == 10): ?><span class="pub_span bg_yellow" id="bg_yellows" data-order-no="<?php echo ($order_detail["order_no"]); ?>">去支付
                  </span><?php endif; endif; ?>
                  
                </div>
            </div>
        </div>
    </div>
    <select id="selectPrevent" style="display:none;" name="province">
    <?php if(is_array($cancel_text)): foreach($cancel_text as $key=>$vo): ?><option value="<?php echo ($vo); ?>"><?php echo ($vo); ?></option><?php endforeach; endif; ?>
    </select>
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
<script type="text/javascript" src="/Public/js/lib/mobiscroll.custom-2.15.1.min.js"></script>
<!--新版美恰代码-->
<script type='text/javascript'>


/*
  <div><a href="javascript:void(0)" onclick=" _MEIQIA('showPanel')"><img src="/Public/image/zxkf.png" alt=""></a></div>
   <p>
            <?php
 if ($order_detail['order_status'] != '1' and $order_detail['order_status'] != '5') { echo '<span>删除订单</span>'; } ?>
            
        </p>


*/
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
    // 传递顾客信息
    _MEIQIA('metadata', {
        name: '微信商城:<?php echo ($mobile); ?>', // 美洽默认字段
        '用户账号': '<?php echo ($mobile); ?>',
        '订单编号': '<?php echo ($order_detail["order_no"]); ?>',
        '商品总金额': '￥<?php echo ($order_detail["total_amount"]); ?>',
        '实付金额': '￥<?php echo ($order_detail["total_amount"]); ?>',
        '下单时间': "<?php echo date('Y-m-d H:i:s',$order_detail['add_time']);?>",
        '店铺名称': '<?php echo ($order_detail["shop_name"]); ?>',
        '收货地址': '<?php echo ($order_detail["city"]); ?> <?php echo ($order_detail["district"]); ?> <?php echo ($order_detail["address"]); ?>',
        '配送费':'<?php echo ($order_detail["post_fee"]); ?>',
    });
</script>
<script type="text/javascript">
    var myScrol0,myScrol1,$Menups=$('.head_box p'),
        again_btn = $('.again_btn'),
        divs = $('.list-main>div'),
        bg_yBtn = $('.mod_order_state .bg_yellow'),
        trans0 = {'bottom':'0','-webkit-transition':'all 0.3s ease'},
        trans1 = {'bottom':'-100%','-webkit-transition':'all 0.3s ease'},
        mask = $('.mod-guide-mask'),
        Pay_method = $('#Pay_method'),
        closes = $('#Pay_method .pay_close'),
        lists = {probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false,click:true},
        payBor = $('.payBor .zp');
    $(document).ready(function() {
        init();
        iscrollAll();
        clicks();
        returnBth();
        function init(){
      /*      var names = GetQueryString('name');
            if(names){
                $('.list-main>div').eq(1).show();   
                $Menups.eq(1).addClass('box_set');
            }else{
                $('.list-main>div').eq(0).show();   
                $Menups.eq(0).addClass('box_set');
            }*/
            divs.eq(0).show();   
                $Menups.eq(0).addClass('box_set');
            var h = $(".about4_main ul li:first-child").height();
            var h1 = $(".about4_main ul li:last-child").height()/2;
            $(".line").height($(".about4_main").height()-h1-h/2);
        }  
        function iscrollAll(){
                myScrol0 = new IScroll('#list-state-one',lists);
                myScrol1 = new IScroll('#list-state-two',lists);
        }
        function clicks(){
            $Menups.on(tapClick(),function(){
                var index=$(this).index();
                divs.eq(index).show().siblings().hide();
                $Menups.eq(index).addClass('box_set').siblings().removeClass('box_set');
                iscrollAll();
            }) 
            $('.pub-cart #pub_sp').on(tapClick(),function(){
                var Id = $("#order_id").val();
                var order_no_id = $("#order_no").val();
                layer.open({
                    content:'<div class="box-mask-html"  style="color:#000000"><h2>温馨提示</h2><p>您要确认删除订单吗?</p></div>',
                    style: 'width:100%;border:none;text-align:center;color:#4DB4F9;font-size:16px;',
                    shadeClose: false,
                    btn: ['确定','取消'],
                    yes: function(){
                        loaging.close();
                        commoms.post_server('/Order/delete',{orderid:Id,order_no:order_no_id},function(result){
                            loaging.close();
                            if (result.result == 'ok') {
                                loaging.close();
                                loaging.prompts('删除成功，请稍后...');
                                window.location.href="/Order/index.html";
                            }else{
                                loaging.btn(result.msg);
                            }
                          },function(){
                            loaging.close();
                            loaging.btn('删除订单失败');
                        })

                    }
                })  
            })

            again_btn.off(tapClick());
            again_btn.on(tapClick(),function(){
              var ds_id = $(this).attr('data-shop-id'),
                  do_id = $(this).attr('data-order-no');
                  if(ds_id && do_id){
                    commoms.post_server('/order/order_again',{shop_id:ds_id,order_no:do_id},function(re){
                      if(re && re.result == 'ok'){
                        window.location.href='/Cart/index/shop_id/'+ds_id+'/order_no/'+do_id;
                      }else{
                        loaging.prompts(re.msg);
                      }
                    },function(){

                    },false);
                  }else{
                    loaging.close();
                    loaging.btn('添加购物车失败');
                  }
            });

            
            bg_yBtn.on(tapClick(),function(){
                mask.show();
                Pay_method.css(trans0);

                var dataorder_no = $(this).attr('data-order-no');
                                
                payBor.on(tapClick(),function(){
                    var dataval = $(this).attr('data-index');
                    if(dataval && dataorder_no){
                        commoms.post_server('/Order/order_repay',{order_no:dataorder_no,pay_type:dataval},function(re){
                            if(re.result == 'ok'){
                                if (re.pay_type=='20') {
                                    $('body').html(re.html);
                                }else if (re.pay_type=='10') {
                                    $.ajax({
                                        url: '/order/weixin_order_date',
                                        type: 'POST',
                                        dataType: 'json',
                                        data:{order_no:re.msg},
                                        success:function(re){
                                            function jsApiCall()
                                            {
                                                WeixinJSBridge.invoke(
                                                    'getBrandWCPayRequest',
                                                    re,
                                                    function(res){
                                                        WeixinJSBridge.log(res.err_msg);
                                                    // alert(res.err_code);
                                                    // alert(res.err_desc);
                                                    // alert(res.err_msg);
                                                    if (res.err_msg == 'get_brand_wcpay_request:ok') {
                                                      loaging.close();
                                                      var ins = layer.open({
                                                          content:'<div class="box-mask-html">支付成功</div>',
                                                          style: 'width:100%;border:none;text-align:center;',
                                                          shadeClose: false,
                                                          btn: ['确定'],
                                                          yes: function(){
                                                            window.location.reload();
                                                          }
                                                      });
                                                      //loaging.btn('支付成功');
                                                      //location.reload();
                                                    }else{
                                                        loaging.close();
                                                        var ins = layer.open({
                                                            content:'<div class="box-mask-html">支付失败</div>',
                                                            style: 'width:100%;border:none;text-align:center;',
                                                            shadeClose: false,
                                                            btn: ['确定'],
                                                            yes: function(){
                                                                window.location.reload();
                                                            }
                                                        });
                                                        //loaging.prompts('支付失败');
                                                    }
                                                });
                                            }
                                            callpay();
                                            function callpay()
                                            {
                                              if (typeof WeixinJSBridge == "undefined"){
                                                  if( document.addEventListener ){
                                                      document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                                                  }else if (document.attachEvent){
                                                      document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
                                                      document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                                                  }
                                              }else{
                                                  jsApiCall();
                                              }
                                            }
                                        },error:function(){

                                        }
                                    })
                                };
                            }else{
                            }
                        },function(){
                        });
                    }
                })
            })
            mask.on(tapClick(),function(){
              mask.hide();
              Pay_method.css(trans1);
              myScrol0.refresh();
              myScrol1.refresh();
            })
            closes.on(tapClick(),function(){
              mask.hide();
              Pay_method.css(trans1);
              myScrol0.refresh();
              myScrol1.refresh();
            })


        }
        function returnBth(){
          $('.icon-back').on(tapClick(),function(){
              $('input,textarea').blur();
              var parentName=$(this).parents('div').attr('class');
              if(parentName.indexOf('mod_order_state')>-1){
                 location.href="index.html"
              }else{
                 return;  
              }   
          })
        } 
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


        $('#pub_span').on('click',function() {
          $('#selectPrevent').mobiscroll().select({
            theme: 'mobiscroll',
            display: 'bottom',
            minWidth: 200,
            onSelect: function(value, inst) {
              var key = inst._tempValue;
              $('.content-city-wrap').text(key);
              commoms.post_server('/order/cancel_new',{order_no:$('#order_no').val(),reason:key},function(re){
                if(re.result == 'ok'){
                    loaging.close();
                    var index=layer.open({
                        content:'<p class="center">'+re.msg+'</p>',
                        style: 'border:none;text-align:center;line-height:70px;margin-top:-75%;width:100%;font-size:16px;',
                        shadeClose: false,
                        btn: ['确认'],
                        yes:function(){
                            location.reload();
                        }
                    });
                }
              },function(){

              });


            }
          }).mobiscroll('show');
        });




    });
</script>
</body>

</html>