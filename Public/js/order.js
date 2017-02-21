var mo_lis = $('.mo_menu .mo_lis'),
    shDiv = $('#mod_order .mods'),
    pullUpEl = $('#pullUp'),myScrol_0,
    myScrol_l,myScrol_2,myScrol_3,
    bg_yBtn = $('.mod_my_order .bg_yellow'),
    trans0 = {'bottom':'0','-webkit-transition':'all 0.3s ease'},
    trans1 = {'bottom':'-100%','-webkit-transition':'all 0.3s ease'},
    iscroc={ preventDefault:false,
            probeType: 2,
            scrollbars: false,
            mouseWheel: true,
            fadeScrollbars: false,
            bounce: true,
            interactiveScrollbars: true,
            shrinkScrollbars: 'scale',
            click: true,
            keyBindings: true,
            momentum: true
          },pullDownL,pullUpEl, pullUpL,Downcount = 0,Upcount = 0,loadingStep = 0
      pullUpL = pullUpEl.find('.pullUpLabel'),
      addsBox = $('#adds');

    pullUpEl['class'] = pullUpEl.attr('class');
    pullUpEl.attr('class', '').hide();

  $(document).ready(function() { 
        clicks(); 
        iscrocAll();
        function iscrocAll(){
          myScrol_0 = new IScroll('#mod_order1', iscroc);
          myScrol_l = new IScroll('#mod_order2', iscroc);
          myScrol_2 = new IScroll('#mod_order3', iscroc); 
          myScrol_3 = new IScroll('#mod_order4', iscroc);
          myScrol_0.refresh();
        }
        var payBor = $('.payBor .zp');
          mo_lis.on(tapClick(),function(){
            var index = $(this).index();
            mo_lis.removeClass('lis_sec');
            mo_lis.eq(index).addClass('lis_sec');
            shDiv.eq(index).show().siblings().hide();
            if(shDiv.eq(index).find('.scrollers>div').length <= 0){
              loaging.close();
              loaging.prompts('暂无更多订单');
              $(this).find('i').hide();
            }
            myScrol_0.refresh();
            myScrol_l.refresh();
            myScrol_2.refresh();
            myScrol_3.refresh();
          })
          returnBth();
         function returnBth(){
            $('.icon-back').on(tapClick(),function(){
                $('input,textarea').blur();
                var parentName=$(this).parents('div').attr('class');
                loaging.close();
                if(parentName.indexOf('mod_er') > -1){
                  loaging.init('加载中...');
                  window.location.reload();
                }
            });  
       }
        function clicks(){
          
          var mask = $('.mod-guide-mask'),
              Pay_method = $('#Pay_method'),
              closes = $('#Pay_method .pay_close'),
              refund = $('.refund');

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
            })
            mask.on(tapClick(),function(){
              mask.hide();
              Pay_method.css(trans1);
              myScrol_0.refresh();
            })
            closes.on(tapClick(),function(){
              mask.hide();
              Pay_method.css(trans1);
              myScrol_0.refresh();
            })


            /*tui*/
            refund.off(tapClick());
            refund.on(tapClick(),function(){
              var order_ids = $(this).parents('.mo_boxs').attr('data-id');
              console.log(order_ids)
              loaging.close();
              layer.open({
                  content:'<div class="box-mask-html"  style="color:#000000"><h2>温馨提示</h2><p>您是否确认退款?</p></div>',
                  style: 'width:100%;border:none;text-align:center;color:#4DB4F9;font-size:16px;',
                  shadeClose: false,
                  btn: ['确定','取消'],
                  yes: function(){
                      loaging.close();
                        commoms.post_server('/order/ajax_order_refund',{order_id:order_ids},function(result){
                            loaging.close();
                            if (result.result == 'ok') {
                                window.location.reload();
                            }else{
                                loaging.btn(result.msg);
                            }
                        },function(){
                          loaging.close();
                          loaging.btn('确认收货失败');
                        })
                  }
              })



            });
            var quesBtn = $('.mo_boxs .que');
            quesBtn.off(tapClick());
            quesBtn.on(tapClick(),function(){ 
                var Id=$(this).parents('.mo_boxs').attr('data-id');
                var order_no_id=$(this).parents('.mo_boxs').attr('data-order-no');
                var ers = $(this).attr('data');
                var psa = $(this).parents('.moBox_btns');
                var Dbook_time = psa.attr('data-book-time'),
                    Dshopname = psa.attr('data-shop-name');
                loaging.close();
                if(ers == '0'){                
                  layer.open({
                      content:'<div class="box-mask-html"  style="color:#000000"><h2>温馨提示</h2><p>您要确认收货吗?</p></div>',
                      style: 'width:100%;border:none;text-align:center;color:#4DB4F9;font-size:16px;',
                      shadeClose: false,
                      btn: ['确定','取消'],
                      yes: function(){
                          loaging.close();
                            commoms.post_server('/Order/complete',{orderid:Id,order_no:order_no_id},function(result){
                                loaging.close();
                                if (result.result == 'ok') {
                                    layer.open({
                                          content:'<p class="center">'+result.msg+'</p>',
                                          shadeClose: false,
                                          style:'text-align:center;',
                                          btn: ['确定'],
                                          yes: function(){
                                            layer.closeAll();
                                            location.reload();
                                          }
                                      });
                                }else{
                                    loaging.btn(result.msg);
                                }
                            },function(){
                              loaging.close();
                              loaging.btn('确认收货失败');
                            })
                      }
                  })
                }else if(ers == '1'){
                  loaging.close();
                  loaging.init('加载中...');

                  var mod_er_ord = $('#mod_er_ord'),
                      dataorder_nos = $(this).parents('.mo_boxs').attr('data-order-no');
                      commoms.post_servers('/Order/get_order_goods',{order_no:dataorder_nos},function(result){
                        if(result.result == 'ok'){
                            loaging.close();
                            var resultH="",resultHmlt = "";
                            if(result.msg){
                              //显示
                              resultH = $('<div class="resultHmlt"></div>');
                              for(var k=0;k<result.msg.length;k++ ){
                                resultHmlt+= '<p>商品：'+result.msg[k].goods_name+'<span>x&nbsp;'+result.msg[k].count+'</span></p>';
                              }
                              resultH.html(resultHmlt);

                            }else{
                              resultHmlt = "";
                            }
                            $('#mod_er').show().siblings().hide();
                            mod_er_ord.html('');
                            if(dataorder_nos){
                              var htms = '<div class="mod_er_Div"><div class="hmls"><p>核销店铺：<span>'+(Dshopname?Dshopname:"")+'</span></p><p>提货时间：<span>'+(Dbook_time?Dbook_time:"")+'</span></p></div><img src="/Phpqrcode/create_png?order_no='+dataorder_nos+'" alt="" /></div>';
                              mod_er_ord.html(htms);
                              mod_er_ord.find('.mod_er_Div').append(resultH);
                            }
                        }
                         
                        },function(){
                          loaging.close();
                          loaging.btn('加载失败');
                      })    
                }
                if(shDiv.eq(1).find('.scrollers>div').length > 0){
                  myScrol_l.refresh();
                }
                if(shDiv.eq(3).find('.scrollers>div').length > 0){
                  myScrol_3.refresh();
                }
            })
            var again_btn = $('.again_btn');
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
        }


        upDowns();
        function upDowns(){
          myScrol_3.on('scroll',Starts);
          myScrol_3.on('scrollEnd', Ends);

          function Starts() {
             if (loadingStep == 0 && !pullUpEl.attr('class').match('flip|loading')) {
                 if (this.y < (this.maxScrollY - 5)) {
                    pullUpEl.attr('class', pullUpEl['class'])
                    pullUpEl.show();
                    pullUpEl.addClass('flip');
                    pullUpL.html('加载中...');
                    loadingStep = 1;
                 }
             }
          }
          function Ends() {
            if (loadingStep == 1) {
              if (pullUpEl.attr('class').match('flip|loading')) {
                  pullUpEl.removeClass('flip').addClass('loading');
                  pullUpL.html('请稍后...');
                  loadingStep = 2;                
                  loaging.init('加载中...');
                          var last_id=$('.list-product-Lis .mo_boxs').last().attr('data-id');
                          commoms.post_servers('/order/meorder',{order_id:last_id},function(result){
                              if(result && result.length>0){
                            
                                  setTimeout(function(){
                                      getAjaxs(result);
                                        pullUpEl.removeClass('loading');
                                        pullUpL.html('上拉显示更多...');
                                        pullUpEl['class'] = pullUpEl.attr('class');
                                        pullUpEl.attr('class', '').hide();
                                        myScrol_3.refresh();
                                        loadingStep = 0;
                                        loaging.close();  



                                  },1000);
                              }else{
                                  setTimeout(function(){
                                      loaging.close();
                                      loaging.prompts('已无更多订单...'); 
                                      loadingStep = 1;
                                      pullUpL = pullUpEl.find('.pullUpLabel');
                                      pullUpEl['class'] = pullUpEl.attr('class');
                                      pullUpEl.attr('class', '').hide();
                                      myScrol_3.refresh(); 
                                  },500)
                              }
                            },function(){
                              loaging.close();
                              loaging.btn('加载失败');
                          })  
                      
                    }
                }
          }

        }
        function getAjaxs(result){
          var html = "";
          if(result.length){
            for(var k=0;k<result.length;k++){
              var data = result[k],
                  order_status="",
                  listAll="",
                  zong=data.gift_num+data.goods_num,
                  ping="",
                  pinfo ="",
                  fives = "",
                  fiv = "";
                    if(data.order_status == 1){
                      if(data.pay_status == 10 || data.pay_status == 20 || data.pay_status == 40){
                          order_status="待支付";
                          pinfo='<span class="qu"><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'" >再来一单</a></span><span class="bg_yellow">去支付</span>';
                      }
                    }
                    if(data.order_status == 1 && data.pay_status == 90){
                        order_status="待发货";
                        pinfo='<span><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'">再来一单</a></span>';                        
                    }

                    if(data.order_status == 10 || data.order_status == 2){
                        order_status="待发货";
                        pinfo='<span><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'">再来一单</a></span>';                            
                    }else if(data.order_status==5){
                        pinfo='<span><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'">再来一单</a></span>';
                        
                        order_status="已发货";    
                        if((data.deliver_type == 1) && ((data.pay_type == 10) || (data.pay_type == 20))){
                          fiv = "1";
                        }else{
                          fiv = "0";
                        }           
                    }else if(data.order_status==6){
                        pinfo='<span><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'">再来一单</a></span>';
                        order_status="已取消";
                    }
                    if(data.order_status== 9){
                         order_status="已受理";
                         pinfo='<span><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'">再来一单</a></span>';    
                    }
                    if(data.order_status == 8 && data.score > 0 ){
                         order_status="已完成";
                         pinfo='<span><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'">再来一单</a></span>';
                    } else if(data.order_status == 8 && data.score == 0 ){
                        order_status="待评价";
                        pinfo='<span><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'">再来一单</a></span><span>去评价</span>';
                    } 
                    if(data.order_status == 11){
                      var pinfo_s = "";
                      order_status="已过期";
                      if(data.is_displayed == 1){
                          pinfo_s = '';
                      }else{
                          pinfo_s = "";
                      }
                      pinfo='<span><a href="javascript:void(0);" class="again_btn" data-shop-id="'+data.shop_id+'" data-order-no="'+data.order_no+'">再来一单</a></span>'+pinfo_s+''; 
                    }

                    if ((data.order_status == 11 || data.order_status == 10) && data.pay_status == 30) {
                          pinfo_s = '<span  class="refund"><a href="javascript:;" >退款</span>';
                          pinfo+= pinfo_s;
                    }

                    data.order_status == 5　? fives='<span class="que" data="'+fiv+'"><a href="javascript:;">确认收货</a></span>' : fives = "";
                    html+='<div class="mo_boxs padds3" data-id="'+data.order_id+'" data-order-no="'+data.order_no+'">'
                            +'<div class="moBox-title flex flexsJusi">'
                             +'<p class="moBox-t-timer"><img src="/Public/image/me_shop.png" alt=""><span>'+data.shop_name+'</span><img src="/Public/image/me_arrow_icon.png" alt=""></p>'
                                +'<p class="moBox-t-state">'+order_status+'</p>'
                            +'</div>' 
                            +'<a href="/Order/state.html?dataid='+data.order_id+'&order_no='+data.order_no+'" style="display:block;" class="blocks">'
                              +'<ul class="moBox-menus flex">'
                                if (data.goods_list) {
                                  var listnum=data.goods_list.length;
                                  for(var i=0;i<5;i++){
                                  if(i < listnum && i!= 4){
                                     html+='<li class="moBox-mLis"><img src="'+data.goods_list[i].goods_pic+'" alt="" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></li>'
                                  }
                                  if(i == 4)
                                      {                                               
                                           html+='<li class="moBox-mLis"><img src="/Public/image/more_goods.png"></li>'
                                      }
                                      if (i == listnum && i!=4) {
                                           break ;
                                      };
                                  } 
                              }else{
                                  html+='<p><img src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></p>'
                              }
                              html+='</ul>'
                            +'</a>'
                            +'<p class="moBox_price">'
                              +'<span>共<b>'+data.total_quantity+'</b>件商品</span>&nbsp;&nbsp;<span>实付:<b class="moBox_prices">￥'+data.total_amount+'</b></span>'
                            +'</p>'
                            +'<div class="moBox_btns" data-book-time="'+data.book_time+'"  data-shop-name="'+data.shop_name+'">'+pinfo+fives+'</div>'
                          +'</div>'
                }


                addsBox.append(html); 
                 clicks();
          }else{
            console.log(1);
          }


        }
  })