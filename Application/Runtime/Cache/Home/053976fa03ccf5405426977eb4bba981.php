<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en" class="htmls">
<head>
    <title>哈哈镜</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
	<link rel="stylesheet" href="/Public/css/set.css">
	<style type="text/css">.flex_span1{margin-right: 5px;}.co_hideDiv .co_hib span{margin:0px;text-align: center;font-size: 14px;width: 32.4%;padding: 0px;}.co_hideDiv .co_divs2{font-size: 16px;}.co_hideDiv .co_hib span:nth-child(3n){border:none;}</style>
</head>
<body>
	<div class="wrap_confirm">
		<header class="pub-header">
	        <a href="javascript:history.back(-1);" class="tap-action icon icon-back"></a>
	        <div class="header-content ui-ellipsis">
	            支付订单
	        </div>
		</header>
		<div class="wrap_co">
			<article class="wrap_co_div wrap_coDel">
				<section class="co_div">
					<div class="coDiv_dis flex flexsJusi" id="co_del">
						<p class="dis_l dis_p">选择地址</p>
						<p class="dis_r">
							<a href="/ActivityTwo/set_address_add_yiyuan?ticket_list_ids=<?php echo ($ticket_list_ids); ?>&cart_ids=<?php echo ($cart_ids); ?>">
							<img src="/Public/image/active/d_size.png" alt="">
							</a>
						</p>
					</div>
					<div class="coDiv_del">
						<?php if(($address_default["addressid"]) == ""): ?><p class="del_l dis_p">哈哈镜火锅需要您的配送地址</p>
						<?php else: ?>
						 <div class="del_r del_ls">
							<div class="flex flex1">
								<span class="flex_span flex_span1"><?php echo ($address_default['username']); ?></span>
								<p class="flex_p flexs"><?php echo ($address_default['phone']); ?></p>
							</div>
							<div class="flex">
								<span class="flex_span">配送地址：</span>
								<p class="flex_p flexs"><?php echo ($address_default['district']); ?></p>
							</div>
						</div><?php endif; ?>
					</div>
				</section>
				<section class="co_div co_divs2">
					<div class="coDiv_dis coDiv_times flex flexsJusi" id="coDiv_times">
						<p class="dis_l dis_p">配送时间</p>
						<p class="dis_r dis_p" id="timer_right"><img src="/Public/image/active/d_size.png" alt=""></p>
					</div>
					<div class="coDiv_del">
						<p class="del_l dis_p">12:00-22:00配送</p>
					</div>
				</section>
			</article>
			<article class="wrap_co_div wrap_co_div2">
				<section class="co_div wrap_sp flex">
					<div class="wrap_spL">
						<img src="/Public/image/active/bgs.jpg" class="img" alt="" onerror="this.src='/Public/image/bg_nulls.png'">
					</div>
					<div class="wrap_spr flexs">
						<h6 class="spr_title">哈锅英雄嫩牛双人套餐</h6>
						<p class="spr_prices"><span>￥1.00</span></p>
						<s class="spr_s">原价￥198.00</s>
					</div>
					<div class="wrap_J flex">
						<p><b><?php echo ($count); ?></b>份</p>
					</div>
				</section>
				<section class="co_div co_div2 dmode_lis flex">
					<?php if($openid != '' ): ?><p class="dp flexs"><img src="/Public/image/wmode.png" class="dimg" alt="">微信支付</p>
					<?php else: ?>
					<p class="dp flexs"><img src="/Public/image/wmode.png" class="dimg" alt="">支付宝支付</p><?php endif; ?>
					<span class="dspan blocks"><img src="/Public/image/selectok.png" class="imgs dimg" alt=""></span>
				</section>
				<section class="co_div generals">
			        <h2 class="g-h2 dis_p">费用明细</h2>
			        <ul class="generals_menu">
			            <li class="clist_lis flex">
			                <p class="cy_name flexs flexsJusi">商品总额</p>
			                <span class="cy_price blocks">￥<?php echo ($data['goods_amount']); ?></span>
			            </li>
			            <li class="clist_lis flex">
			                <p class="cy_name flexs flexsJusi">优惠金额</p>
			                <span class="cy_price blocks">-<b>￥<?php echo ($data['discount']); ?></b></span>
			            </li>
			        </ul>
				</section>
				<section class="co_div details_nums">
					<div class="flex flexsJusi">
						<p class="dis_l dis_p">商品总数</p>
						<p class="dis_r">共<span><?php echo ($data['total_quantity']); ?></span>份</p>
					</div>
					<p class="dis_p dis_ps">
						应付金额：<span class="z_prices">￥<b><?php echo ($data['total_amount']); ?></b></span>
					</p>
				</section>
				<img src="/Public/image/active/d_bg.png" class="Imgs" alt="">
			</article>
			<div class="wrap_de_btn" id="goods_submit">
				<img src="/Public/image/active/c_btn.png" alt="">
			</div>
		</div>
	</div>
	<div class="co_hideDiv" id="co_hideDiv">
		<div>
			<header class="pub-header pub-header2">
		        <a href="javascript:void(0);" class="tap-action hides icon icon-back icon-back2" id="returns"></a>
		        <div class="header-content ui-ellipsis">
		            选择配送时间
		        </div>
			</header>
			<section class="co_hdiv" id="co_hideSec">
				<div class="co_hideSec2">
					<div class="co_divs">
		                <div class="co_divs1 co_hib">
		                	<a href="javascript:;">
		                		<?php if(is_array($xianshi_data)): foreach($xianshi_data as $key=>$vo): ?><span <?php if(($key) == "0"): ?>class="p_green"<?php endif; ?>><?php echo ($vo); ?></span><?php endforeach; endif; ?>
		                	</a>
		                </div>
		               <p class="co_divs2 co_hib p_green"><?php echo ($xianshi_data[0]); ?></p>
		            </div>
		            <ul class="co_menus">
		            	<?php if(is_array($data_day['book_hour'])): foreach($data_day['book_hour'] as $key=>$vo): ?><li class="co_lis"><span><?php echo ($vo); ?></span></li><?php endforeach; endif; ?>
		            </ul>
		            <div class="clears"></div>
		            <div class="Btnsubs"><div class="Btnsub"><span>返回</span></div></div>
				</div>
			</section>
		</div>
	</div>
	<input type="hidden" name="address_id" id="address_id" value="<?php echo ($address_default['addressid']); ?>">
    <input type="hidden" name="cart_ids" id="cart_ids" value="<?php echo ($cart_ids); ?>">
    <input type="hidden" name="book_time" id="book_time" value="">
    <input type="hidden" name="ticket_list_ids" id="ticket_list_ids" value="<?php echo ($ticket_list_ids); ?>">
	<input type="hidden" name="pay_type" id="pay_type" value='<?php if($openid != '' ): ?>10<?php else: ?>20<?php endif; ?>'>
	<input type="hidden" name="user_name" id="user_name" value="<?php echo ($address_default['username']); ?>">
	<input type="hidden" name="telphone" id="telphone" value="<?php echo ($address_default['phone']); ?>">
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


  			var bodyScroll = function (e) { e.preventDefault(); }
  		

  	      //     returnBtns = $('returns'),
  	      //      hideBox = $('hideBox-main');
  	      //      returnBtns.onclick=function(){

  	      //      	alert(1);

	        //     hideBox.style.display="block";
	            
	        //     hide_mask.onclick=function(){
	        //         this.style.display="none";
	        //         hideBox.style.display="none";

	        //     }
	        // }
	





		window.onload=function(){
			loaging.close();
		}
		var co_del = $('#co_del'),
			hideDiv = $('#co_hideDiv'),
			returnBtn = $('#returns'),
			div1Span = $('.co_divs1 span'),
			div1 = hideDiv.find('.co_divs1'),
			div2 = hideDiv.find('.co_divs2'),
			lis = $('.co_menus .co_lis'),
			return_Btn = $('.Btnsub'),
			coDiv_times = $('#coDiv_times'),
			wrap_confirm = $('.wrap_confirm'),
			timer_right = $('#timer_right'),
			goods_submit = $('#goods_submit'),
			book_times = $('#book_time'),
			iscroc={probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false,click:true};
			coDiv_times.off('click');
			coDiv_times.on('click',function(){	
				hideDiv.css('right','0');
				myScrol0.refresh();
				setTimeout(function(){
					wrap_confirm.hide();
				},300);
					 document.addEventListener('touchmove',bodyScroll,false);
	      
			});
			var myScrol0 = new IScroll('#co_hideDiv', iscroc);


			returnBtn.on('click',function(){		
				var txt1 = div1.find('.p_green').text(),
					txt2 = $('.co_menus .spans').text();
					if(!txt2){
						loaging.close();
						loaging.prompts('请您选择时间');
						return false;
					}
					wrap_confirm.show();
					txt1 && txt2 ? book_times.val(txt1+' '+txt2) : book_times.val('');
					txt1 && txt2 ? timer_right.html('<span class="dis_rspan">'+txt1+' '+txt2+'</span>') : "";
				
					setTimeout(function(){
						hideDiv.css({'right':'-200%','-webkit-transition':'right all 0.3s'});
					},300);
					    document.removeEventListener('touchmove',bodyScroll,false);
			})
			div1Span.off('click');
			div1Span.on('click',function(){
				var divsize = $(this).text();
				div1Span.removeClass('p_green');
				$(this).addClass('p_green');
				div2.text(divsize);
			})
			lis.on('click',function(){
				lis.removeClass('spans');
				$(this).addClass('spans');
			});
			return_Btn.on('click',function(){
				returnBtn.click();
			})

	/*******************新订单提交************************/
	  checksubmit();
	  function checksubmit(){
	    goods_submit.off(tapClick());
	    goods_submit.on(tapClick(),function(){
	            loaging.close();
	            loaging.init('订单提交中，请稍后...');
	            var address_id = $('#address_id').val(),
	            	cart_ids = $('#cart_ids').val(),
	            	book_time = $('#book_time').val(),
	            	ticket_list_ids = $('#ticket_list_ids').val(),
	            	pay_type = $('#pay_type').val(),
	            	user_name = $('#user_name').val(),
	            	telphone = $('#telphone').val();
                  var option = {
                  		address_id:address_id,
                  		cart_ids:cart_ids,
                  		book_time:book_time,
                  		ticket_list_ids:ticket_list_ids,
                  		pay_type:pay_type,
                  		user_name:user_name,
                  		telphone:telphone

	                 };
	                 if(!address_id){
	                 	loaging.close();
	                 	loaging.prompts('请您选择地址');
	                 	return false;
	                 }
	                 if(!book_time){
	                 	loaging.close();
	                  	loaging.prompts('请选择时间');
	                  	return false;
	                 }
	                commoms.post_servers('/ActivityTwo/yiyuan_add',option,function(re){
	                	console.log(re);
	                    if(re.result=='ok') {

	                      var get_order_no=re.msg.order_no;
	                      if (re.pay_type=='20') {
	                        $('body').html(re.html);
	                      };
	                      if (re.pay_type=='10') {
	                        $.ajax({
	                          url: '/ActivityTwo/weixin_order_date',
	                          type: 'POST',
	                          dataType: 'json',
	                          data:{order_no:re.msg.order_no},
	                          success:function(re){
	                              function jsApiCall()
	                              {
	                                WeixinJSBridge.invoke(
	                                  'getBrandWCPayRequest',
	                                  re,
	                                  function(res){
	                                    WeixinJSBridge.log(res.err_msg);
	                                    // alert(res.err_code,res.err_desc,res.err_msg);
	                                    if (res.err_msg == 'get_brand_wcpay_request:ok') {
	                                      loaging.close();
	                                      loaging.btn('支付成功');
	                                       window.location.href="http://weixin.hahajing.com/ActivityTwo/succeed?pay_type=10&order_no="+get_order_no;
	                                    }else{
	                                      loaging.close();
	                                      loaging.btn('支付失败');
	                                      window.location.href="http://weixin.hahajing.com/ActivityTwo/state.html?order_on="+get_order_no+"&name=order";
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
	                            loaging.close();
	                          }
	                        })
	                      };
	                    }else{
	                      loaging.close();
	                      loaging.btn(re.msg);
	                    }
	                },function(){
	                  loaging.close();
	                  loaging.btn('订单提交失败');
	                },false);

	                

	    });
	  }
	/*******************新订单提交end************************/
		var url = window.location.href;
		weixins(url,"one");
	</script>
</body>
</html>