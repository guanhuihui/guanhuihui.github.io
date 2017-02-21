  loaging.init('加载中...');
 var myScroll,
    $Menups=$('.head_box p'),
    list_item = $('.shipping-adds_list .list_item'),
    addressDiv = $('#mod-shipping_address'),
    list_div = $('.list-main>div'),
    orderDiv = $('.mod_my_order'),
    iscroc={probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false,click:true},pullDownL,pullUpEl, pullUpL,Downcount = 0,Upcount = 0,loadingStep = 0
/*    lists={
        probeType: 2,
        scrollbars: false,
        mouseWheel: true,
        fadeScrollbars: true,
        bounce: true,
        interactiveScrollbars: true,
        shrinkScrollbars: 'scale',
        click: true,
        keyBindings: true,
        momentum: true
    }*/

 /*   pullUpEl = $('#pullUp');
    pullUpL = pullUpEl.find('.pullUpLabel');
    pullUpEl['class'] = pullUpEl.attr('class');
    pullUpEl.attr('class', '').hide();
    myScroll = new IScroll('#mod_order', lists);*/
   

    pullUpEl = $('#pullUp');
    pullUpL = pullUpEl.find('.pullUpLabel');
    pullUpEl['class'] = pullUpEl.attr('class');
    pullUpEl.attr('class', '').hide();
    myScroll = new IScroll('#mod_order', iscroc); 




   $(document).ready(function() { 
        init();  
        returnBth();
        function init(){
            orderDiv.show(); 
            list_div.eq(0).show();   
            $Menups.eq(0).addClass('box_set');  
            
        }
        function returnBth(){
            $('.icon-back').on(tapClick(),function(){
                $('input,textarea').blur();
                var parentName=$(this).parents('div').attr('class');
                if(parentName.indexOf('mod_my_order')>-1){
                   location.href="/Index/index.html"
                }  
            })
        } 
        function loginBths(txt,parentss){
            var index=layer.open({
                    content:'<p class="center">'+txt+'</p>',
                    style: 'border:none;text-align:center;line-height:50px;margin-top:-25%;',
                    shadeClose: false,
                    btn: ['确认'],
                    yes: function(){
                      layer.closeAll();
                      parentss.remove();
                    }
                });
        }
        function Alts(txt){
            var index=layer.open({
                    content:'<p class="center">'+txt+'</p>',
                    style: 'border:none;text-align:center;line-height:50px;margin-top:-25%;',
                    shadeClose: false,
                    btn: ['确认'],
                    yes: function(){
                        window.location.reload();
                    }
                });
        }
        myScroll.on('scroll',Starts);
        myScroll.on('scrollEnd', function () {
            if (loadingStep == 1) {
                if (pullUpEl.attr('class').match('flip|loading')) {
                    pullUpEl.removeClass('flip').addClass('loading');
                    pullUpL.html('正在加载更多数据...');
                    loadingStep = 2;
                    loaging.init('加载中,请稍后');
                    pullipAjax();
                }
            }
        });
        function Starts() {
            if (loadingStep == 0 && !pullUpEl.attr('class').match('flip|loading')) {
                if (this.y < (this.maxScrollY - 5)) {
                    pullUpEl.attr('class', pullUpEl['class'])
                    pullUpEl.show();
                    pullUpEl.addClass('flip');
                    pullUpL.html('全力加载中...');
                    loadingStep = 1;
                }
            }
        }
   

            commoms.post_servers('/order/meorder',{},function(result){
             getjsons(result);
            },function(){
             loaging.close();
            })
            function pullipAjax(){
                var last_id=$('.list-product-Lis>div').last().attr('data-id');
                    commoms.post_servers('/order/meorder',{order_id:last_id},function(result){
                        if(result){
                            setTimeout(function(){
                                getjsons(result);
                            },1000);
                        }else{
                            setTimeout(function(){
                                loaging.close();
                                loaging.prompts('已无更多订单...'); 
                                loadingStep = 1;
                                pullUpL = pullUpEl.find('.pullUpLabel');
                                pullUpEl['class'] = pullUpEl.attr('class');
                                pullUpEl.attr('class', '').hide();
                                myScroll.refresh(); 
                            },500)
                        }
                      },function(){
                        loaging.close();
                        loaging.btn('加载失败');
                    })      
            }
            function getjsons(result){
                    var html="";
                    if(result){
                        for(var k=0;k<result.length;k++){
                             var data=result[k],
                                 order_status="",
                                 listAll="",
                                 zong=data.gift_num+data.goods_num,
                                 ping="",
                                 pinfo;
                                 if(result[k].order_status==1){
                                     order_status="新订单";
                                     pinfo="<p class='qu'>取消订单</p>";
                                 }else if(result[k].order_status==2){
                                     order_status="待发货";
                                     pinfo="<p class='qu'>取消订单</p>";
                                 }else if(result[k].order_status==5){
                                     order_status="已发货";
                                     pinfo="<p class='re'>确认收货</p>";
                                 }else if(result[k].order_status==6){
                                     order_status="已取消";
                                     ping="";
                                     pinfo="<p class='sh'>删除</p>";
                                 }else if(result[k].order_status==8){
                                     order_status="已完成";
                                     if (!result[k].score) {
                                        ping="<a href='/order/evaluate/order_no/"+data.order_no+"'>去评价</a>";
                                     };
                                     pinfo="<p class='sh'>删除</p>"; 
                                 }         
                             html+='<div class="order_box" data-id="'+data.order_id+'" order-no="'+data.order_no+'">'
                                   +'<a href="/Order/state.html?dataid='+data.order_id+'&order_no='+data.order_no+'">'
                                       +'<div class="order_box_title">'
                                           +'<p><img src="/Public/image/me_shop.png" alt=""><span>'+data.shop_name+'</span><img src="/Public/image/me_arrow_icon.png" alt=""></p>'
                                           +'<p>'+order_status+'</p>'
                                       +'</div>'
                                       +'<div class="order_box_goods">'
                                           +'<div class="order_box_left">'
                                                +'<div class="order_img_left">'
                                                var zongpice =Number(data.goods_num) + Number(data.gift_num);
                                                if (data.goods_list) {
                                                    var listnum=data.goods_list.length;
                                                    for(var i=0;i<5;i++){
                                                    if(i < listnum && i!= 4){
                                                        html+='<p><img src="'+data.goods_list[i].goods_pic+'" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></p>'
                                                    }
                                                    if(i == 4)
                                                        {                                               
                                                             html+='<p><img src="/Public/image/more_goods.png"></p>'
                                                        }
                                                        if (i == listnum && i!=4) {
                                                             break ;
                                                        };
                                                    } 
                                                }else{
                                                    html+='<p><img src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></p>'
                                                }
                                                html+='</div>'
                                           +'</div>'
                                       +'</div>'
                                   +'</a>'
                                   +'<div class="order_box_num">'
                                      +'<div><span>商品数量：</span><p>'+data.goods_num+'件</p></div>'
                                      +'<div><span>赠品数量：</span><p>'+data.gift_num+'件</p></div>'
                                      +'<div><span>合计数量：</span><p>'+zongpice+'件</p></div>'
                                   +'</div>'
                                   +'<div class="order_box_bth">'
                                     +'<p>订单金额：<span>'+data.total_amount+'</span>元</p>'
                                     +'<div class="bths" data-id="'+data.order_id+'"  order-no="'+data.order_no+'"><a style="color:#666" href="javascript:void(0)">'+ping+'</a>'+pinfo+'</div>'
                                   +'</div>'  
                               +'</div>'
                        }
                        $('.list-product-Lis').append(html); 
                         loaging.close();
                    }else{
                        $('.four_null').show();
                    }
                    pullUpEl.removeClass('loading');
                    pullUpL.html('上拉显示更多...');
                    pullUpEl['class'] = pullUpEl.attr('class');
                    pullUpEl.attr('class', '').hide();
                     myScroll.refresh(); 
                    loadingStep = 0;
                    loaging.close();
                   
                    $('.list-product-Lis .bths .qu').off(tapClick());
                    $('.list-product-Lis .bths .qu').on(tapClick(),function(){
                        var Id=$(this).parent('.bths').attr('data-id');
                        var order_no_id=$(this).parent('.bths').attr('order-no');
                        var parentss=$(this).parents('div.order_box');
                        commoms.post_server('/Order/cancel',{orderid:Id,order_no:order_no_id},function(result){
                            loaging.close();
                            if (result.result == 'ok') {
                                Alts(result.msg,parentss);
                            }else{
                                loaging.btn(result.msg);
                            }
                          },function(){
                            loaging.close();
                            loaging.btn('取消订单失败');
                        })

                    })
                    $('.list-product-Lis .bths .sh').off(tapClick());
                    $('.list-product-Lis .bths .sh').on(tapClick(),function(){
                        var Id=$(this).parent('.bths').attr('data-id');
                        var order_no_id=$(this).parent('.bths').attr('order-no');
                        var parentss=$(this).parents('div.order_box');
                        commoms.post_server('/Order/delete',{orderid:Id,order_no:order_no_id},function(result){
                            loaging.close();
                            if (result.result == 'ok') {
                                myScroll.refresh();
                                Alts(result.msg,parentss);
                            }else{
                                loaging.btn(result.msg);
                            }
                          },function(){
                            loaging.close();
                            loaging.btn('删除订单失败');
                        })
                    })
                    $('.list-product-Lis .bths .re').off(tapClick());
                    $('.list-product-Lis .bths .re').on(tapClick(),function(){
                        var Id=$(this).parent('.bths').attr('data-id');
                        var order_no_id=$(this).parent('.bths').attr('order-no');
                        var parentss=$(this).parents('div.order_box');
                        commoms.post_server('/Order/complete/',{orderid:Id,order_no:order_no_id},function(result){
                            loaging.close();
                            if (result.result == 'ok') {
                                Alts(result.msg,parentss);
                            }else{
                                loaging.btn(result.msg);
                            }
                            myScroll.refresh(); 
                          },function(){
                            loaging.close();
                            loaging.btn('确认收货失败');
                        })
                        
                    })
            }
})