<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="html2">
<head>
    <title>哈哈镜 </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="/Public/css/set.css">
</head>
<body>
	<div class="wrap_state">
		<header class="pub-header pub-header2">
	        <a href="javascript:history.back(-1);" class="tap-action icon icon-back icon-back2" id="returns"></a>
	        <div class="header-content ui-ellipsis">
	            待支付
	        </div>
		</header>
		<article class="state_min">
			<ul class="wrap_sment">
				<li class="lis lis2">待支付</li>
			</ul>
			<div class="smin_divs">
				<?php if(($order_detail) != ""): ?><section class="co_div">
					<div class="wrap_sp flex">	
						<div class="wrap_spL">
							<img src="" class="img" alt="" onerror="this.src='/Public/image/bg_nulls.png'">
						</div>
						<div class="wrap_spr flexs">
							<h6 class="spr_title">哈锅英雄嫩牛双人套餐</h6>
							<p class="spr_prices">新品试吃价<span>￥118.00</span></p>
							<s class="spr_s">原价￥198.00</s>
						</div>
						<div class="wrap_J flex">
							<p><b><?php echo ($count); ?></b>份</p>
						</div>
					</div>
					<div class="smin_size flex">
						<p class="smin_p">共<b><?php echo ($order_detail['total_quantity']); ?></b>件商品</p>
						<p class="smin_p smin_p2">实付：￥<span><?php echo ($order_detail['total_amount']); ?></span></p>
					</div>
					<p class="s_btn">
						<span id="s_btns" class="s_btn_span" data-order-no="<?php echo ($order_detail['order_no']); ?>">去支付</span>
					</p>
				</section><?php endif; ?>
			</div>
		</article>
	</div>
	<div class="mod-guide-mask"></div>
	<div id="Pay_method" class="Pay_method">
	    <div class="Pay_mBox payBor">
	        <h2>选择支付方式</h2>
	        <?php if(($openid) == ""): ?><p class="zp zps" id="pay_zf" data-index="20">支付宝</p>
	        <?php else: ?>
	        <p class="zp" id="pay_wx" data-index="10">微信</p><?php endif; ?>
	      </div>
	    <div class="pay_close payBor">取消</div>
	</div>
	<input type="hidden" name="pid" id="pid" value="<?php echo ($user_data['user_id']); ?>">
	<script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script>
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
		loaging.init('加载中...');
		window.onload=function(){
			loaging.close();
		}
		var payBor = $('.payBor .zp'),
			btns = $('#s_btns'),
			trans0 = {'bottom':'0','-webkit-transition':'all 0.3s ease'},
    		trans1 = {'bottom':'-100%','-webkit-transition':'all 0.3s ease'},
    		mask = $('.mod-guide-mask'),
            Pay_method = $('#Pay_method'),
            closes = $('#Pay_method .pay_close');

		btns.off('click');
		btns.on('click',function(){
			mask.show();
			Pay_method.css(trans0);
			var dataorder_no = $(this).attr('data-order-no');
			payBor.on(tapClick(),function(){
			  var dataval = $(this).attr('data-index');
			  if(dataval && dataorder_no){

			   commoms.post_server('/ActivityTwo/order_repay',{order_no:dataorder_no,pay_type:dataval},function(re){
			    if(re.result == 'ok'){
			      if (re.pay_type=='20') {
			      $('body').html(re.html);
			      }else if (re.pay_type=='10') {
			        $.ajax({
			          url: '/ActivityTwo/weixin_order_date',
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
	                                      loaging.btn('支付成功');
	                                       window.location.href="http://weixin.hahajing.com/ActivityTwo/succeed?pay_type=10&order_no="+dataorder_no;
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
			                  }
			                );
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
			      //返回错误信息
			      loaging.close();
			      loaging.btn(re.msg);
			    }
			    
			   },function(){

			   })
			  }
			})
		});
		mask.on('click',function(){
		  mask.hide();
		  Pay_method.css(trans1);
		});

		closes.on(tapClick(),function(){
		  mask.hide();
		  Pay_method.css(trans1);
		});
		

	</script>
	<script type="text/javascript">
		var url = window.location.href;
		weixins(url,"one");
	</script>
</body>
</html>