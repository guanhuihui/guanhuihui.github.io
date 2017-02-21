var myScroll,myScrol2,
    lists={probeType: 3,mouseWheel: true,scrollbars: false},
    mod_show = $('.mod_pay_data .mod_show'),
    goods_size = $('.confrim_goods_size'),
    pay_p = $('.mod_pay_divs p'),
    divs = $('#mod_confirm_order'),
    address_id = GetQueryString('address_id'),
    shop_id = GetQueryString('shop_id'),
    cart_ids = GetQueryString('cart_ids'),
    deliver_type = GetQueryString('deliver_type'),
    couponClick = $('.confrim_goods_coupons'),
    quanDiv = $('#mod_pay_coupons'),
    titleBtn = $('.bot-left-title'),
    ulsbox = $('.botleft-uls')
$(document).ready(function() {

  var ins = {
      init:function(){
        myScroll = new IScroll('#mod_confirm-container',lists);
        myScrol2 = new IScroll('#mod_coupons', lists);
        this.clicks();
        this.checkLength();
      },clicks:function(){
        var dmode_lis = $('.dmode_lis'),
            hidexuan = $('#hidexuan');
        //点击 切换支付方式
        dmode_lis.on(tapClick(),function(){
            var index = $(this).index();
            var dataIndex = $(this).attr('data-index');
            hidexuan.val(dataIndex);
            dmode_lis.find('.imgs').attr('src','/Public/image/selectno.png');
            $(this).find('.imgs').attr('src','/Public/image/selectok.png');
            var Inps = $('#goods_submit input');
            dataIndex == 40 ? Inps.val('提交订单') : Inps.val('提交订单');
        });
        //点击显示券页面
        couponClick.on(tapClick(),function(){
            quanDiv.show().siblings().hide();
            myScrol2.refresh();
        });
        var flgs = true;
        titleBtn.on(tapClick(),function(){
            $('.bot-icon').find('img').toggleClass('trans');
            if(flgs){
              ulsbox.show();
              $('.bot-left-h2').hide();
              flgs = false;
            }else if(flgs == false){
              var txt = $('#stockout_type').attr('data-vals');
              ulsbox.hide();
              $('.bot-left-h2').show().html(txt);
              flgs= true;
            }
        });
        var lis = $('.botleft-items');
        lis.on(tapClick(),function(){
           lis.find('img').attr('src','/Public/image/select_icon.png');
           $(this).find('img').attr('src','/Public/image/select_icons.png');
           var ints = $(this).attr('data-stockout'),
              intstxt = $(this).text();
           $('#stockout_type').val(ints).attr('data-vals',intstxt);
        });

      },checkLength:function(){
        $('#textarea').on('propertychange input', function() {  
            var counter = $.trim($(this).val()).length;
            $(this).val($(this).val().substring(0,30)); 
        });
    }
  }
  ins.init();
  mod_cart();
  returnBth(); 
  function fiveCheck_val(){
    var five_checks = $('#coupon_five').find('.checks'),
        ass = [];

    for(var k = 0,sts = [];k < five_checks.length ;k++){
      
      ass.push(five_checks.eq(k).parents('.mod_coupons_dl').attr('ticket-id'));

    }
    return ass;
  }
  function mod_cart(){
      var waydiv=$('.mod_dir_way>div'),
          wayinput=$('.mod_dir_way>div').find('input'),
          pay_dist=$('#mod_pay_dist'),
          coupons_dl=$('.mod_coupons_dl'),
          five = $('#coupon_five'),
          fiveInp = $('#coupon_five').find('input'),
          threeInp = $('#coupon_three').find('input'),
          three = $('#coupon_three'),
          beerInp = $('#coupon_beer').find('input'),
          beer = $('#coupon_beer'),
          fivedivs = $('#coupon_five .mod_coupons_dl'),
          dl_test = $('.dl_test');


       
          five.find('input').on('change',function(){
              var voucher_check = $('input[name=is_voucher_check]'),
                  idx = $(this).parents('.mod_coupons_dl').index(),
                  index = $(this).parents('.mod_coupons_dl').find('.ticket_id').data('dump-gift'),
                  txts = $(this).data('alert'),
                  pindex = $(this).parents('.mod_coupons_dl').index(),
                  fives = parseInt($('#coupon_five .mod_coupons_dl').eq(pindex).find('.sprice').text()),
                  Parents = $(this).parents('.mod_coupons_dl'),
                  youhu_iticket_id = $('#youhu_iticket_id'), // 1   
                  act_ticket = $('#act_ticket'),  //2
                  goods_ticket = $('#goods_ticket'),//3
                  quanId = $(this).parents('.mod_coupons_dl').attr('ticket-id'),
                  Dls = five.find('.mod_coupons_dl');
                  var that = $(this);


                  if(that.attr('data-state') == '0'){
                    Parents.find('.mod_coupons_left').attr('class','mod_coupons_left left_gray');
                    that.prop('checked',false);
                    return false;
                  }
                  
                  //选中
                  if($(this).prop('checked') == true){
                    if(index == 1){
                      var indexs=layer.open({
                          content:'<div class="text-cen" style="color:#000;font-weight:normal;"><p>'+txts+'</p></div>',
                          style: 'width:100%;border:none;text-align:center;color:#0099CC;font-weight:bold;font-size:16px;',
                          shadeClose: false,
                          btn: ['确定','取消'],
                          yes: function(){
                            layer.close(indexs);

                            five.find('input').removeClass('checks');
                            five.find('input').prop('checked',false);

                            that.addClass('checks');
                            that.prop('checked',true);

                            //300
                            three.find('input').removeClass('checks');
                            three.find('input').prop('checked',false);
                            three.attr('data',0);
                            act_ticket.val('');

                            //啤酒
                            beer.find('input').removeClass('checks');
                            beer.find('input').prop('checked',false);
                            beer.attr('data',0);
                            goods_ticket.val('');

                            //five.attr('data',1);

                            youhu_iticket_id.val(quanId);
                            styleColorAjax();
                          },no: function(){
                            layer.close(indexs);
                            that.prop('checked',false);
                            //five.attr('data',0);

                          }
                      });
                    }else{
                      //100
                      dl_test.find('input').removeClass('checks');
                      dl_test.find('input').prop('checked',false);

                      //选中并添加颜色
                      that.addClass('checks');
                      that.prop('checked',true);

                      //five.attr('data',1);

                      //赋值
                      var fiveCheck_vals = fiveCheck_val();

                      youhu_iticket_id.val(fiveCheck_vals);
                    }
                    styleColorAjax();
                  //未选中
                  }else if($(this).prop('checked') == false){
                    if(index == 1){

                      five.find('input').removeClass('checks');
                      five.find('input').prop('checked',false);

                      //five.attr('data',0);
                      youhu_iticket_id.val('');

                    }else{

                      dl_test.find('input').removeClass('checks');
                      dl_test.find('input').prop('checked',false);

                      $(this).removeClass('checks');
                      $(this).prop('checked',false);

                      //five.attr('data',0);

                      //赋值
                      var fiveCheck_vals = fiveCheck_val();
                      youhu_iticket_id.val(fiveCheck_vals);

                    }
                    styleColorAjax();

                  }

                  function styleColorAjax(){
                    var Cart_ids = $('#cart_ids'),
                        Shop_id = $('#shop_id'),
                        Is_book_goods = $('#is_book_goods'),
                        youhu__id = $('#youhu_iticket_id');


                      var potion = {ticket_list_ids:youhu__id.val(),cart_ids:Cart_ids.val(),shop_id:Shop_id.val(),is_book_goods:Is_book_goods.val()};
                      var arrss = [];
                      commoms.post_servers('/order/ajax_ticket_check',potion,function(re){
                        if(re.code == '200'){
                          var data_can = re.data.can_use_ticket;
                          if(data_can){
                            Dls.find('.mod_coupons_left').attr('class','mod_coupons_left left_gray');
                            Dls.find('.mod_coupons_input input').attr('data-state','0');
                            for(var i = 0;i<Dls.length;i++){
                              for(var k = 0,len = data_can.length;k < len; k++){
                                if(data_can[k] == Dls.eq(i).attr('ticket-id')){
                                    arrss.push(i);
                                }
                              }
                            }
                          }
                        };

                        var StyleColor = "";
                        for(var k = 0,len = arrss.length;k < len; k++){
                          var priceColor = Dls.eq(arrss[k]).find('.sprice').text() * 1;

                              if(priceColor < 100){
                                StyleColor = 'left_yellow';
                              }else if(priceColor == 0){
                                StyleColor = 'left_skyblue';
                              }else{
                                StyleColor = 'left_red';
                              }
                              
                              Dls.eq(arrss[k]).find('.mod_coupons_input input').attr('data-state','1');
                              Dls.eq(arrss[k]).find('.mod_coupons_left').attr('class','mod_coupons_left '+StyleColor+'');
                          }
                      },function(){
                        loaging.close();
                        loaging.btn('请重新，刷新当前页面');
                    
                    })
                  }
          });




          function judgechecked(){
            if(dl_test){
                as = five.find('.checks').parents('.mod_coupons_dl').find('.ticket_id').attr('data-dump-gift');
                if(as == '1'){
                  dl_test.find('input').removeClass('checks');
                  dl_test.attr('data',0);
                  $('#youhu_iticket_id').val('');
                }
            }else{

            }
          }
          var as = "";
          three.find('input').on('change',function(){
            var act_ticket = $('#act_ticket'),
                quanId2 = $(this).parents('.mod_coupons_dl').attr('ticket-id');

            judgechecked();
            if($(this).prop('checked') == true){
              three.find('input').removeClass('checks');
              $(this).addClass('checks');
              $(this).prop('checked',true);
              three.attr('data',1);
              var as = fivedivs.find('.ticket_id').data('dump-gift');
              act_ticket.val(quanId2);
            }else if($(this).prop('checked') == false){
              if($(this).hasClass('checks')){
                ds = $(this).parents('.mod_coupons_dl').index();
                var tst = $('#coupon_three .mod_coupons_input').eq(0).find('input').attr('alet');
                var index=layer.open({
                        content:'<div class="text-cen" style="color:#000;font-weight:normal;"><p>'+tst+'</p></div>',
                        style: 'width:100%;border:none;text-align:center;color:#0099CC;font-weight:bold;font-size:16px;',
                        shadeClose: false,
                        btn: ['确定','取消'],
                        yes: function(){
                          layer.close(index);
                          three.find('input').removeClass('checks');
                          $(this).prop('checked',false);
                          three.attr('data',0);
                          act_ticket.val('');
                        },no: function(){
                          layer.close(index);
                          three.find('.mod_coupons_input').eq(ds).find('input').prop('checked',true);
                          three.attr('data',1);
                          act_ticket.val(quanId2);
                        }
                    });
              }else{
                act_ticket.val(quanId2);
                three.find('input').removeClass('checks');
                $(this).addClass('checks');
                $(this).prop('checked',true);
                three.attr('data',1);
              }

              
            }
          })
          beer.find('input').on('change',function(){
            var goods_ticket = $('#goods_ticket'),
                quanId3 = $(this).parents('.mod_coupons_dl').attr('ticket-id');
              //100美团券
              judgechecked();
              if($(this).prop('checked') == true){
                  beer.find('input').removeClass('checks');
                  $(this).addClass('checks');
                  $(this).prop('checked',true);
                  beer.attr('data',1);
                  goods_ticket.val(quanId3);
              }else if($(this).prop('checked') == false){
                  if($(this).hasClass('checks')){
                      ds = $(this).parents('.mod_coupons_dl').index();
                      var tst = $('#coupon_beer .mod_coupons_input').eq(0).find('input').attr('alet');
                      var index=layer.open({
                          content:'<div class="text-cen" style="color:#000;font-weight:normal;"><p>'+tst+'</p></div>',
                          style: 'width:100%;border:none;text-align:center;color:#0099CC;font-weight:bold;font-size:16px;',
                          shadeClose: false,
                          btn: ['确定','取消'],
                          yes: function(){
                            layer.close(index);
                            beer.find('input').removeClass('checks');
                            $(this).prop('checked',false);
                            beer.attr('data',0);
                            goods_ticket.val('');
                          },no: function(){
                            layer.close(index);
                            beer.find('.mod_coupons_input').eq(ds).find('input').prop('checked',true);
                            beer.attr('data',1);
                            goods_ticket.val(quanId3);
                          }
                      });
                
                  }else{
                      beer.find('input').removeClass('checks');
                      $(this).addClass('checks');
                      $(this).prop('checked',true);
                      beer.attr('data',1);
                      goods_ticket.val(quanId3);
                  }
              }
          })
  }
 
  function returnBth(){
      $('.icon-back,.icon-me').on(tapClick(),function(){
          var parentName=$(this).parents('div').attr('class');
          if(parentName.indexOf('mod_confirm_order')>-1){
              var shopId = $("input[name='shop_id']").val(),
                  actticket = 0,goodsticket,
                  act_ticket = $('#coupon_three .checks').attr('name');
                  goods_ticket = $('#coupon_beer .checks').attr('name');
                  act_ticket?actticket = 1:actticket = 0;
                  goods_ticket?goodsticket = 1:goodsticket = 0,
                  deliver_type2 = GetQueryString('deliver_type');
                  location.href='/Cart/index?shop_id='+shopId+'&act_ticket='+actticket+'&goods_ticket='+goodsticket+'&distribution='+deliver_type2
          }else if(parentName.indexOf('mod_pay_coupon')>-1){

            var val1 = $('#address_id').val(),
                val2 = $('#shop_id').val(),
                val3 = $('#cart_ids').val(),
                val4 = $('#deliver_type').val(),
                val5 = $('#goods_ticket').val(),
                val6 = $('#time_ymd').val(),
                val7 = $('#is_book_goods').val();
                val8 = $('#act_ticket').val();
                val9 = $('#youhu_iticket_id').val();


              commoms.post_server('/order/get_confirm_goods_list',{address_id:val1,shop_id:val2,cart_ids:val3,deliver_type:val4,goods_ticket:val5,time_ymd:val6,is_book_goods:val7,act_ticket:val8,ticket_list_ids:val9},function(re){
                //成功
                if(re.code == '200' && re.data){
                  var html="";
                  if(re.data.new_goods_list){
                    for(var k = 0;k<re.data.new_goods_list.length;k++){
                      var res = re.data.new_goods_list[k];
                      html+=' <li class="clist_lis flex"><p class="cy_name flexs ui-ellipsis">'+res.goods_name+'</p><span class="cy_num blocks">x'+res.count+'</span><span class="cy_price blocks">￥'+res.price+'</span></li>'
                    }
                    $('.clist_menu').html(html);
                    $('.Total_price').html(re.data.goods_amount);
                    $('#d-Price').html(re.data.goods_amount);
                    $('#ps-Price').html(re.data.post_fee);//配送费
                    $('#yo-Price').html(re.data.discount);//优惠
                    $('#cz_num').html(re.data.total_quantity);
                    $('#size_price b').html(re.data.total_amount);
                    $('.goods_ps .goods_ps1').html(re.data.ticket_str);
                    // $('.goods_ps .goods_ps2').html(re.data.ticket_str_buttom);
                  }

                  divs.show().siblings().hide();
                  myScroll.refresh();
                }else{
                  loaging.close();
                  loaging.btn(re.data);

                } 
              },function(){
                  loaging.close();
                  loaging.btn('请重新，刷新当前页面');
                  divs.show().siblings().hide();
                  myScroll.refresh();
              })
              return false;
          }  
      })
  }
/*******************新订单提交************************/
  checksubmit();
  function checksubmit(){
    var goods_submits = $('#goods_submit');
    goods_submits.off(tapClick());
    var is_ticket_s = $('#is_ticket');
    goods_submits.on(tapClick(),function(){
            loaging.close();
            loaging.init('订单提交中，请稍后...');
            var val1 = $('#address_id').val(),
                val2 = $('#shop_id').val(),
                val3 = $('#cart_ids').val(),
                val4 = $('#deliver_type').val(),
                val5 = $('#goods_ticket').val(),
                val6 = $('#time_ymd').val(),
                val7 = $('#is_book_goods').val();
                val8 = $('#act_ticket').val();
                val9 = $('#youhu_iticket_id').val(),
                val0 = $('#hidexuan').val(),
                message = $('#textarea').val(),
                user_name = $("#user_name").val(),
                telphone = $("#telphone").val(),
                is_ticket = $('#is_ticket').val();
                deliver_distance_mi = $('#deliver_distance').val(),
                stockout_typeV = $('#stockout_type').val();
                  var option = {
                    address_id:val1,
                    shop_id:val2,
                    cart_ids:val3,
                    deliver_type:val4,
                    ticket_id:val9,
                    act_ticket:val8,
                    goods_ticket:val5,
                    pay_type:val0,
                    book_time:val6,
                    message:message,
                    user_name:user_name,
                    telphone:telphone,
                    is_book_goods:val7,
                    deliver_distance:deliver_distance_mi,
                    stockout_type:stockout_typeV
                  };

                  var val8s = Number(option.act_ticket);
                  var val5s = Number(option.goods_ticket);
                  if(is_ticket > 0){
                    if(!option.ticket_id && !val8s && !val5s){
                      if(is_ticket_s.attr('data') == 0){
                         loaging.close();
                          is_ticket_s.attr('data','1');
                           var index=layer.open({
                              content:'<div class="box-mask-html">您有优惠券是否使用？</div>',
                              style: 'width:100%;border:none;text-align:center;',
                              shadeClose: false,
                              btn: ['确定','取消'],
                              yes: function(){
                                layer.close(index);
                                quanDiv.show().siblings().hide();
                                myScrol2.refresh();
                              },no: function(){
                                layer.close(index);
                                subs();
                                loaging.init('加载中，请稍后...');
                              }
                          });
                      }else{
                        subs();
                      }
                    }else{
                      subs();
                    }
                  }else{
                    subs();
                  }
                function subs(){
                  var fs_info = $('.fs_info').html(),
                      fs_timer = $('.fs_timer').html();
                      loaging.close();
                      var fs_html = "",fs_html2 = "";
                      fs_info ? fs_html = '<h2 style="text-align:left;font-size:14px;">您选择的配送方式是：<span style="color:red;">'+fs_info+'</span></h2>':fs_html="";
                      if(fs_timer){
                        var fs1 = "",fs2 = "";
                        var split_fs_timer = fs_timer.split(' ');
                        split_fs_timer[0] ? fs1 = '<h2 style="text-align:left;font-size:14px;">送货日期：<span style="color:red;">'+split_fs_timer[0]+'</span></h2>' : fs1 = "";
                        split_fs_timer[1] ? fs2 = '<h2 style="text-align:left;font-size:14px;">送货时间：<span style="color:red;">'+split_fs_timer[1]+'</span></h2>' : fs2 = "";

                        fs_html2 = fs1+fs2;
                      }else{
                        fs_html2 = "";
                      }
                    var index=layer.open({
                       content:'<div class="box-mask-html">'+fs_html+fs_html2+'<h2 style="padding-top:10px;">是否继续？</h2></div>',
                       style: 'width:100%;border:none;text-align:center;',
                       colors:1,
                       shadeClose: false,
                       btn: ['确 认','再等等'],
                       yes: function(){
                          layer.close(index);
                          sub_commit();
                       },no: function(){
                        layer.close(index);
                       }

                     })
                      function sub_commit(){
                          commoms.post_servers('/Order/add',option,function(re){
                              if(re.result=='ok') {
                                var get_order_no=re.msg.order_no;
                                if (re.pay_type=='40') {
                                  if($('.center')){
                                    $('.center').html('跳转中,请稍后...');
                                  }
                                  window.location.href="/order/succeed?pay_type="+re.pay_type+"&order_no="+re.msg.order_no;
                                };
                                if (re.pay_type=='20') {
                                  $('body').html(re.html);
                                };
                                if (re.pay_type=='10') {
                                  $.ajax({
                                    url: '/order/weixin_order_date',
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
                                                 window.location.href="http://weixin.hahajing.com/order/succeed?pay_type=10&order_no="+get_order_no;
                                              }else{
                                                loaging.close();
                                                loaging.btn('支付失败');
                                                window.location.href="http://weixin.hahajing.com/Order/state.html?order_no="+get_order_no+"&name=order";
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
                      }
                   
              }

    });
  }
/*******************新订单提交end************************/
});