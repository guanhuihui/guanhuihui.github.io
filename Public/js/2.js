var myScroll,myScrol2,
    lists={probeType: 3,mouseWheel: true,scrollbars: false},
    mod_show = $('.mod_pay_data .mod_show'),
    goods_size = $('.confrim_goods_size'),
    pay_p = $('.mod_pay_divs p'),
    divs = $('#mod_confirm_order'),
    address_id = GetQueryString('address_id'),
    shop_id = GetQueryString('shop_id'),
    cart_ids = GetQueryString('cart_ids'),
    deliver_type = GetQueryString('deliver_type');
$(document).ready(function() {
    iscrollAll();
    mod_cart();
    clicks();
    returnBth();
    function iscrollAll(){
      myScroll = new IScroll('#mod_confirm-container',lists);
      myScrol2 = new IScroll('#mod_coupons', lists);
    }



    function clicks(){
        var dmode_lis = $('.dmode_lis'),
            hidexuan = $('#hidexuan'),
            couponClick = $('.confrim_goods_coupons'),
            quanDiv = $('#mod_pay_coupons');
        //点击 切换支付方式
        dmode_lis.on(tapClick(),function(){
            var index = $(this).index();
            hidexuan.val(index);
            dmode_lis.find('.imgs').attr('src','/Public/image/selectno.png');
            $(this).find('.imgs').attr('src','/Public/image/selectok.png');
        });
        //点击显示券页面
        couponClick.on(tapClick(),function(){
            quanDiv.show().siblings().hide();
            myScrol2.refresh();
        })
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
/*        function Show(Mask_ids,ids){
          $(Mask_ids).show();
          $(ids).css({'-webkit-transform':'translate3d(0,0,0)','transform':'translate3d(0,0,0)'});
        }
        function Hide(Mask_ids,ids){
          $(ids).css({'-webkit-transform':'translate3d(100%,0,0)','transform':'translate3d(100%,0,0)'});
           $(Mask_ids).hide();
        }*/
        /*$('.confrim_goods_Img,.confrim_goods_z').on(tapClick(),function(){
            $('.mod_sidebars').show().siblings().hide();
            iscrollAll();
        })
        $('.confrim_goods_size').on(tapClick(),function(){
            $('.mod_pay_distribution').show().siblings().hide();
            mod_show.eq(0).show().siblings().hide();
             iscrollAll();   
        })*/
     /*   $('.mod_pay_divs p').on(tapClick(),function(){
          var index=$(this).index();
          $('.book_day').blur();
          $(this).addClass('p_green').siblings().removeClass('p_green');
          mod_show.eq(index).show().siblings().hide();
        })*/
       /* $('.mod_pay_set .mod_pay_ps').on(tapClick(),function(){
            $('.book_day').blur();
            $('.mod_pay_divs p').eq(1).addClass('p_green').siblings().removeClass('p_green');
            $('.mod_pay_data .mod_show').eq(1).show().siblings().hide();
           
        })*/
       
     /*   waydiv.off(tapClick());
        waydiv.on(tapClick(),function(){
          var index=$(this).index();
              wayinput.removeClass('checks');
              $(this).find('input').addClass('checks');
              wayinput.attr('checked',false);
              $(this).find('input').attr('checked','checked');
              if(index==2){
                pay_dist.css({'-webkit-transform':'translate3d(0,0,0)','transform':'translate3d(0,0,0)'});
              }else{
               pay_dist.css({'-webkit-transform':'translate3d(0,200%,0)','transform':'translate3d(0,200%,0)'});
              }
        })*/
      five.find('input').on('change',function(){
            var voucher_check = $('input[name=is_voucher_check]'),
                idx = $(this).parents('.mod_coupons_dl').index(),
                index = $(this).parents('.mod_coupons_dl').find('.ticket_id').data('dump-gift'),
                txts = $(this).data('alert'),
                pindex = $(this).parents('.mod_coupons_dl').index(),
                fives = parseInt($('#coupon_five .mod_coupons_dl').eq(pindex).find('.sprice').text());

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
                              fivedivs.eq(idx).find('input').addClass('checks');
                              fivedivs.eq(idx).find('input').prop('checked',true);

                              //300
                              three.find('input').removeClass('checks');
                              $(this).prop('checked',false);
                              three.attr('data',0);

                              //啤酒
                              beer.find('input').removeClass('checks');
                              $(this).prop('checked',false);
                              beer.attr('data',0);


                              five.attr('data',1);
                              voucher_check.val('1');
                              voucher_check.attr('money',fives);

                            },no: function(){
                              layer.close(indexs);
                              fivedivs.eq(idx).find('input').prop('checked',false);
                              five.attr('data',0);
                           
                        
                            }
                        });
                    }else{
                      
                        five.find('input').removeClass('checks');
                        $(this).addClass('checks');
                        $(this).prop('checked',true);
                        five.attr('data',1);
                        voucher_check.val('1');
                        voucher_check.attr('money',fives);
                    }
                //未选中
                }else if($(this).prop('checked') == false){
                    if($(this).hasClass('checks')){
                        five.find('input').removeClass('checks');
                        $(this).prop('checked',false);
                        five.attr('data',0);
                        voucher_check.val('0');
                        voucher_check.attr('money','0');
                    }else{
                        if(index == 1){
                            var indexs=layer.open({
                                content:'<div class="text-cen" style="color:#000;font-weight:normal;"><p>'+txts+'</p></div>',
                                style: 'width:100%;border:none;text-align:center;color:#0099CC;font-weight:bold;font-size:16px;',
                                shadeClose: false,
                                btn: ['确定','取消'],
                                yes: function(){
                                  layer.close(indexs);
                                  five.find('input').removeClass('checks');
                                  fivedivs.eq(idx).find('input').addClass('checks');
                                  fivedivs.eq(idx).find('input').prop('checked',true);



                                  //300
                                  three.find('input').removeClass('checks');
                                  $(this).prop('checked',false);
                                  three.attr('data',0);

                                  //啤酒
                                  beer.find('input').removeClass('checks');
                                  $(this).prop('checked',false);
                                  beer.attr('data',0);


                                  five.attr('data',1);
                                  voucher_check.val('1');
                                  voucher_check.attr('money',fives);

                                },no: function(){
                                  layer.close(indexs);
                                  fivedivs.eq(idx).find('input').prop('checked',false);
                                  five.attr('data',0);
                                  
                            
                                }
                            });
                        }else{
                 
                            five.find('input').removeClass('checks');
                            $(this).addClass('checks');
                            $(this).prop('checked',true);
                            five.attr('data',1);
                            voucher_check.val('1');
                            voucher_check.attr('money',fives);
                        }
                    }
                }

               /* var voucher_check = $('input[name=is_voucher_check]'),
                fives = parseInt($('#coupon_five .mod_coupons_dl').eq(0).find('.sprice').text());
                if($(this).prop('checked') == true){
                  five.find('input').removeClass('checks');
                  $(this).addClass('checks');
                  $(this).prop('checked',true);
                  five.attr('data',1);
                  voucher_check.val('1');
                  voucher_check.attr('money',fives);
                }else if($(this).prop('checked') == false){
                  if($(this).hasClass('checks')){
                    five.find('input').removeClass('checks');
                    $(this).prop('checked',false);
                    five.attr('data',0);
                    voucher_check.val('0');
                    voucher_check.attr('money','0');
                  }else{
                    five.find('input').removeClass('checks');
                    $(this).addClass('checks');
                    $(this).prop('checked',true);
                    five.attr('data',1);
                    voucher_check.val('1');
                    voucher_check.attr('money',fives);
                  }
                }*/
      })
        function judgechecked(){
              if(dl_test){
                for(var k = 0;k < dl_test.length;k++){
                    as += String(dl_test.eq(k).find('.ticket_id').data('dump-gift'));
                }
                if(as.indexOf('1') > -1){
                    dl_test.find('input').removeClass('checks');
                    dl_test.attr('data',0);
                    if($('.checks').parents('.dl_test')){
                        $('input[name=is_voucher_check]').val('0');
                        $('input[name=is_voucher_check]').attr('money','0');
                    }
                }
              }
        }
        var as = "";
        three.find('input').on('change',function(){
          judgechecked();
          if($(this).prop('checked') == true){
            three.find('input').removeClass('checks');
            $(this).addClass('checks');
            $(this).prop('checked',true);
            three.attr('data',1);
            var as = fivedivs.find('.ticket_id').data('dump-gift');
      
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
                      },no: function(){
                        layer.close(index);
                        three.find('.mod_coupons_input').eq(ds).find('input').prop('checked',true);
                        three.attr('data',1);
                      }
                  });
            }else{
              three.find('input').removeClass('checks');
              $(this).addClass('checks');
              $(this).prop('checked',true);
              three.attr('data',1);
            }

            
          }
        })

 
        beer.find('input').on('change',function(){
            //100美团券
            judgechecked();
            if($(this).prop('checked') == true){
                beer.find('input').removeClass('checks');
                $(this).addClass('checks');
                $(this).prop('checked',true);
                beer.attr('data',1);
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
                        },no: function(){
                          layer.close(index);
                          beer.find('.mod_coupons_input').eq(ds).find('input').prop('checked',true);
                          beer.attr('data',1);
                        }
                    });
              
                }else{
                    beer.find('input').removeClass('checks');
                    $(this).addClass('checks');
                    $(this).prop('checked',true);
                    beer.attr('data',1);
                }
            }
        })
        //添加样式
         /*$('.mod_pay_uls li').on(tapClick(),function(){
            var index = $(this).index();
            $('.mod_pay_uls li').find('span').removeClass('spans')
            $(this).find('span').addClass('spans');
         })*/
    }
    checkLength();
    function checkLength(){
        $('#textarea').on('propertychange input', function() {  
            var counter = $.trim($(this).val()).length;
            $(this).val($(this).val().substring(0,30)); 
        });
    }
    function calculation(){
        var voucher_check = $('input[name=is_voucher_check]');
        var goods_amounts = parseInt($('#goods_amounts').val()),
            post_fees = parseInt($('#post_fees').val()),
            is_voucher_check=Number(voucher_check.val()),
            goods_amounts = Number($('#goods_amounts').val()),
            post_fees = Number($('#post_fees').val()),
            money = Number(voucher_check.attr('money')),
            peisong = Number($('.peisong b').text());
            if (peisong !=0) {
                var goods_sum=goods_amounts+post_fees-money;
                if (goods_sum < 0) {
                    goods_sum=0;
                }
                $('.amount_price b').text(goods_sum);
                $('#size_price b').text(goods_sum);
            }else{
                var goods_sum=goods_amounts-money;
                if (goods_sum < 0) {
                    goods_sum=0;
                }
                $('.amount_price b').text(goods_sum);
                $('#size_price b').text(goods_sum);
            }
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

            }else if(parentName.indexOf('mod_sidebars')>-1){
               $('.mod_confirm_order').show().siblings().hide();
               iscrollAll();
            }else if(parentName.indexOf('mod_pay_coupon')>-1){
               var url = window.location.href,
                   urlsub = url.split('?')[0],
                   urlsec = window.location.search,
                   str = url.substring(0,url.lastIndexOf('act_ticket')), 
                   fiveInpId = 0,threeInpId = 0,beerInpId = 0,
                   fivecheckId = $('#coupon_five .checks').parents('.mod_coupons_dl').attr('ticket-id'),
                   threecheckId = $('#coupon_three .checks').parents('.mod_coupons_dl').attr('ticket-id'),
                   beercheckId = $('#coupon_beer .checks').parents('.mod_coupons_dl').attr('ticket-id'),
                   fiveche = $('#coupon_five .checks'),
                   pricetxt = $('.amount_price b'),
                   size_price = $('#size_price b'),
                   Discount_price = $('.Discount_price b'),
                   hidePrivce = $('#hide-amount').val(),
                   tstPrice = Number(pricetxt.text());
                   fivecheckId?fiveInpId=fivecheckId:fiveInpId=0;
                   threecheckId?threeInpId=threecheckId:threeInpId=0;
                   beercheckId?beerInpId=beercheckId:beerInpId=0;
                   commoms.post_servers('/order/ajax_goods_count',{address_id:address_id,shop_id:shop_id,cart_ids:cart_ids,deliver_type:deliver_type,ticket_id:fivecheckId,act_ticket:threecheckId,goods_ticket:beercheckId},function(data){
                      //返回的
                      var re =data.data;
                          if(data.result == 'ok'){
                              if(fiveche.attr('name') && fiveche){
                              var ling = fiveche.parents('.mod_coupons_dl').find('.sprice').text(),
                                  bs = parseFloat(Number(ling));
                                  Discount_price.text(ling);
                              }else{
                                   Discount_price.text('0.00');
                              }

                              calculation();
                              $('#privez b').text(re.goods_count);
                              $('.mod_confirm_order').show().siblings().hide();
                              $('.goods_ps p').text(re.ticket_str);
                              $('.goods_ps span b').text(re.ticket_str_buttom);
                              iscrollAll();
                          }else{
                              loaging.btn('获取失败，请重试');
                          }
                          },function(){
                              location.reload();
                      },false);
            }  
        })
    }
  


  function timers(){
    var oDate = new Date(),//实例一个时间对象；
      years = oDate.getFullYear(),   //获取系统的年；
      Months = oDate.getMonth()+1,   //获取系统月份，由于月份是从0开始计算，所以要加1
      Dates = oDate.getDate(), // 获取系统日，
      Hours = oDate.getHours(), //获取系统时，
      Minutes = oDate.getMinutes(), //分
      Seconds = oDate.getSeconds(), //秒
      timer = $('#shop_delivertime').val()
      arrs = timer.split('-'),
      arrs1 = arrs[0],
      arrs2 = arrs[1],
      fen=Hours+':'+Minutes;
    if(arrs1 > fen || arrs2 < fen){
      return true;
    }

}

    checksubmit();
    function checksubmit(){
        $('#goods_submit').on(tapClick(),function(){
          loaging.close();
          loaging.init('订单提交中，请稍后...');
          //判断商户配送时间是否符合当前时间
          if(GetQueryString('deliver_type') == 0){
            if($('.mod_dir_way .checks').val() == '即时送货' && $('.mod_dir_way .checks').attr('data-index') == 0){
             if (timers()) {
                    loaging.prompts('超出当前配送时间');
                    return false;
             }
            }
          }
          var addId=$("input[name='address_id']").val(),
              shopId = $("input[name='shop_id']").val(),
              cart_ids = $("input[name='cart_ids']").val(),
              fiveInpId = 0,threeInpId = 0,beerInpId = 0,
              fivecheckId = $('#coupon_five .checks').parents('.mod_coupons_dl').attr('ticket-id'),
              threecheckId = $('#coupon_three .checks').parents('.mod_coupons_dl').attr('ticket-id'),
              beercheckId = $('#coupon_beer .checks').parents('.mod_coupons_dl').attr('ticket-id'),
              user_name = $("input[name='user_name']").val(),
              telphone = $("input[name='telphone']").val(),
              hidetimes = $("input[name='hide-times']").val(),
              message = $('#textarea').val(),
              prices = $('#size_price b').text();
              fivecheckId?fiveInpId=fivecheckId:fiveInpId=0;
              threecheckId?threeInpId=threecheckId:threeInpId=0;
              beercheckId?beerInpId=beercheckId:beerInpId=0;
              hidetimes?hidetimes = $("input[name='hide-times']").val() : hidetimes = "";
              if(GetQueryString('deliver_type') == 1){
                  deliver_type = 1;
              }else{
                  deliver_type = $("#hide_input").val();
              }


              $("input[name='address_id']").val(addId);
              $("input[name='shop_id']").val(shopId);
              $("input[name='cart_ids']").val(cart_ids);
               $("#hide_input").val(deliver_type);

              $('#ticket_idss').val(fiveInpId);
              $('#act_ticketss').val(threeInpId);
              $('#goods_ticketss').val(beerInpId);


              $("input[name='book_time']").val(hidetimes);
               $('#textarea').val(message);

              $("input[name='user_name']").val(user_name);
              $("input[name='telphone']").val(telphone);
              
              
              $('#formid').submit();



/*
          var option = {
                address_id:addId,
                shop_id:shopId,
                cart_ids:cart_ids,
                deliver_type:deliver_type,
                ticket_id:fiveInpId,
                act_ticket:threeInpId,
                goods_ticket:beerInpId,
                pay_type:40,
                book_time:hidetimes,
                message:message,
                user_name:user_name,
                telphone:telphone
              };



          commoms.post_server('/Order/add',option,function(re){
              loaging.close();
              function locas(){
                window.location.href="/order/succeed?yuji="+re.return_data.yuji+"&fukuan="+re.return_data.fukuan+"&jine="+re.return_data.jine+"&order_no="+re.return_data.order_no+'&jine='+prices+'';
              }
              if(re.data=='ok') {
                if(re.return_data.vshop_id != 0){
                    var index=layer.open({
                        content:'<div class="box-mask-html"><p style="color:#000000;font-weight:normal;">建议收藏店铺，方便您下次继续下单</p></div>',
                        style: 'width:100%;border:none;text-align:center;color:#4DB4F9;',
                        shadeClose: false,
                        btn: ['立即收藏','暂不收藏'],
                        yes: function(){
                          layer.close(index);
                          commoms.post_servers('/Shop/favorite_add',{shop_id:shopId},function(res){
                            loaging.close();
                            if(res.result == 'ok'){
                                locas();
                            }else{
                                loaging.btn('收藏失败');
                                locas();
                            }
                        },function(){
                            loaging.btn('错误');
                        },false);
                        },no: function(){
                            layer.close(index);
                            locas();
                        }
                    });
                }else{
                   locas();
                }
                return false;
              }else{
                loaging.btn(re.msg);
              }
          },function(){
            loaging.btn('订单提交失败');
          },false); */
        })
    }

});