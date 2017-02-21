function carts(){
    var shop_id="",
        cart_prompt = $('.cart-uncheck-prompt'),
        cart_promptp = $('.cart-uncheck-prompt p'),
        shop_head = $('#shop_head'),
        bth_input = $('#mod_coupons_dls dt input');
        shop_id=$('#shop_id').val();
    var gift_count=0;//赠品数量
    var jia=0;
    //获取地址信息
    commoms.post_servers('/Address/address_default',{},function(result){
        if(result){
            var html='<tbody user-id='+result.userid+' id="tbodys"><tr>'
                        +'<th width="65px">收&nbsp;&nbsp;货&nbsp;&nbsp;人</th>'
                        +'<td class="cart_name">'+result.username+'</td>'
                        +'<td rowspan="3" width="40px" class="addr-change">'
                            +'<a href="javascript:void(0);"><span class="group-strong"><img src="/Public/image/me_arrow_icon.png" alt=""></span>'
                            +'</a>'
                        +'</td></tr>'
                        +'<tr><th>电<span class="ui-hidden">中中</span>话</th><td class="cart_phone">'+result.phone+'</td></tr>'
                        +'<tr><th>收货地址</th><td class="cart_adds">'+result.cityname+'&nbsp;'+result.district+'&nbsp;'+result.address+'</td></tr></tbody>'
            $('.addr-table').html(html);
            $('#shop_head').attr('data-lat',result.lat);
            $('#shop_head').attr('data-lng',result.lng);
            $('#shop_head').attr('address-id',result.addressid);
            myScrol2.refresh();
        }else{
            $('.addr-table .addr-table-th').html('请选择收货地址');
        }
    },function(){
        loaging.btn('地址信息错误');
    },false);






    //获取购物车信息
    var cartid ="";
    commoms.post_servers('/Cart/cart_list',{shop_id:shop_id},function(result){
        if(result){
            $('#deliverscope').val(result.shop_deliverscope);
            for(var i=0;i<result.goods_list.length;i++){                   
                if(result.goods_list){
                    cartid=cartid+','+result.goods_list[i].cart_id;
                    $('#shop_carts').attr('cart-id',cartid);
                }else{
                    $('#shop_carts').attr('cart-id',"");
                }
            }
            if(shop_id == '' || shop_id == null){
                $('#hide_id').val(result.shop_id);
            }
            //成功之后执行ajax
            getJsonS(result);
            get_Beer(result);
            getnum(result.shop_id);
            get_add_info(result);
        }else{
            $('.cart-groups-wraper').html('<div class="cart-groups-img"><a href="/Index/index.html"><img src="/Public/image/cartnull.png" alt="" /></a></div>');
            $('.cart-groups-img').on(tapClick(),function(){
                location.href='/Index/index.html';
            })
        }
    },function(){
        loaging.btn('错误');
    });
    function getJsonS(result){
        $('.cart-price-details').show();
        var html = "";
            data=result;
            //判断是否有优惠券
            if(result.act_status != 0){
                //活动开启
                if(data.act_ticket =='' || data.act_ticket == null){
                    loadview(result);
                    cart_prompt.show();
                    cart_promptp.html(data.act_tips1);
                }else{
                    loadviews(result);
                    var k = 0;
                    for(var j=0;j<result.goods_list.length;j++){
                        if(result.goods_list[j].gift !== null){
                            k=1;
                        }
                    }
                    //优惠券代码开始
                    var fens=data.act_ticket.start_date.split(' ')[0],
                        fenstwo=data.act_ticket.end_date.split(' ')[0];
                    var arrs='<dl class="mod_coupons_dl" id="mod_coupons_dls" data-ticket='+data.act_ticket.ticket_id+'>'
                                +'<dt><input type="checkbox" checked="checked"></dt>'
                                +'<dd><div class="mod_coupons_left left_red">'
                                    +'<h2><span>￥'+data.act_ticket.start_price+'</span>'+data.act_ticket.act_name+'</h2>'
                                    +'<h3>使用区域：<span>'+data.act_ticket.notes+'</span></h3>'
                                    +'<p>使用说明：<span>'+data.act_ticket.act_desc+'</span></p></div>'
                                    +'<div class="mod_coupons_right"><p>有效期</p><div>'
                                    +'<p>'+fens+'</p><p>'+fenstwo+'</p></div>'
                                    +'<a href="javascript:void(0);">立即使用 &gt;</a></div>'
                                +'</dd>'
                            +'</dl>'
                            $('.mod_pay_coupons').html(arrs); 
                    //优惠券代码结束    
                    //判断是否可以点击
                    if (!k) {
                        $('#mod_coupons_dls dt input').removeClass('checks'); 
                        $('#mod_coupons_dls dt input').attr('disabled','disabled');
                        cart_prompt.show();
                        cart_promptp.html(data.act_tips2);
                        //loaging.prompts(data.act_tips2);
                    }else{
                        $('#mod_coupons_dls dt input').addClass('checks'); 
                    }
                    //结束判断
                    myScrol2.refresh();
                    //可以点击时状态start
                    $('.mod_pay_coupons dt input').on('change',function(){
                        if(this.checked == true){
                            $(this).addClass('checks'); 
                            cart_prompt.hide();
                            $('.can-enjoy-preferential').show();
                            /*commoms.post_servers('/Cart/cart_list',{shop_id:shop_id},function(data){
                                loaging.close();
                                if(data){
                                    loadviews(data);
                                    cart_prompt.html();
                                }
                                },function(){
                                loaging.btn('错误');
                            },false);*/
                            gift_count=0;
                            get_Beer(data);
                            loadviews(data);
                        }else{
                            gift_count=0;
                            $(this).removeClass('checks');   
                            cart_prompt.show();
                            cart_promptp.html(data.act_tips3);
                            loaging.prompts(data.act_tips3);
                            $('.can-enjoy-preferential').hide();
                            /* commoms.post_servers('/Cart/cart_list',{shop_id:shop_id},function(data){
                                    loaging.close();
                                    if(data){
                                        loaging.prompts(data.act_tips3);
                                        cart_promptp.html(data.act_tips3);
                                        gift_count=0;
                                        loadview(data);
                                    }
                                    },function(){
                                    loaging.btn('错误');
                                },false);   */
                                get_Beer(data);
                                loadview(data);

                        }
                    })
                    //可以点击时状态end
                }
            }else{  
                //活动未开启
                loadviews(result);
                //判断是否可以点击
                $('#mod_coupons_dls dt input').removeClass('checks'); 
                loaging.prompts('活动未开启，暂时不能使用优惠券');
                $('#mod_coupons_dls dt input').attr('disabled','disabled');
                cart_prompt.show();
                cart_promptp.html('活动未开启，暂时不能使用优惠券');

            }

            $('.cart_head_store a').on(tapClick(),function(){
                var shopId = $(this).attr('data-id');
                window.location.href='/Category/index/shop_id/'+shopId;
            })
    }
    //未开启时代码
    function loadview(data){
        //求正品总量
        var sum=0;
        var html = "";
            html+='<input type="hidden" id="head"  shop_lng='+data.shop_lng+' shop_lat='+data.shop_lat+'>'
                +'<input type="hidden" value="'+data.shop_deliverscope+'" id="shop_delive" />'
                +'<div class="cart_boxs_head" shop_id='+data.shop_id+'>'
                    +'<p class="cart_head_store"><a href="/Category/index/shop_id/'+data.shop_id+'" data-id='+data.shop_id+'><img src="/Public/image/home_icon.png" alt="">'+data.shop_name+'</a></p>'
                    +'<p class="cart_head_close">删除</p>'
                +'</div>'
                +'<div class="cart_boxs_main">'
                    +'<div class="can-enjoy-preferential">'
                    for(var k=0;k<data.goods_list.length;k++){
                        var ret=data.goods_list[k],goods_pungent="",goods_weight="",goods_unit="",act_name="",goods_weight="";
                            ret.goods_pungent ?goods_pungent='('+ret.goods_pungent+')':goods_pungent="";
                            if(ret.goods_unit == '' || goods_unit == null){
                                goods_unit="";
                                goods_weight="";
                            }else{
                                goods_unit='/'+ret.goods_unit;
                                goods_weight=ret.goods_weight;
                            }
                            sum= Number(sum) + Number(ret.count);
                    html+='<div class="not-enjoy-preferential">'
                            +'<div class="enjoy-goods" cart-id='+ret.cart_id+' goods_id='+ret.goods_id+'>'
                                +'<div class="not-good-info">'
                                    +'<div class="not-info-left">'
                                        +'<span>购</span>'
                                    +'</div>'
                                    +'<div class="not-info-cent">'
                                        +'<dl>'
                                            +'<dt><img src="'+ret.goods_pic+'" alt="" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></dt>'
                                            +'<dd class="cart_boxs_info">'
                                                +'<h2 class="ui-ellipsis">'+ret.goods_name+''+goods_pungent+''+goods_weight+''+goods_unit+'</h2>'
                                                +'<p class="zens">'+act_name+'</p>'
                                                +'<p class="info_price">￥'+ret.price+'</p>'
                                            +'</dd>'
                                        +'</dl> '
                                    +'</div>'
                                    +'<div class="not-info-right">'
                                        +'<span class="goods_del">-</span>'
                                        +'<input type="text" class="goods_vals" readonly="readonly" value="'+ret.count+'" name="text">'
                                        +'<span class="goods_add">+</span>'
                                    +'</div>'
                                +'</div>'
                            +'</div>'
                        +'</div>'
                    }
                html+='</div>'
                    +'<div class="not-enjoy-preferential">' 
                    +'</div>'
                +'</div>'
            $('.cartBox_info').html(html)
            myScrol2.refresh();
            catrs();

            $('.details-zen span').html(gift_count);
            
            $('.details-combined span').html(Number(sum) + gift_count );   
    }
    //开启时代码
    function loadviews(data){
        //求正品总量
        var sum=0;
        //gift_count=0;
        var html="",h2="",h3="",
            figt_goods_data=new Array(),
            no_goods_data=new Array();
            //判断 如果有无赠品
            for(var k=0;k<data.goods_list.length;k++){
                var ret=data.goods_list[k];
                if ( data.goods_list[k].gift_new != null) {
                    figt_goods_data.push(data.goods_list[k]);
                }else{
                    no_goods_data.push(data.goods_list[k]);
                }
            }
            for(var k=0;k<figt_goods_data.length;k++){
                if (figt_goods_data[k].gift_new) {
                    h2='<h2>可享优惠商品</h2>';
                    h3='<h2>'+data.act_tips4+'</h2>';
                }
            }
            if(no_goods_data.length == 0){
                h3="";
            }


        html+='<input type="hidden" id="head"  shop_lng='+data.shop_lng+' shop_lat='+data.shop_lat+'>'
                +'<input type="hidden" value="'+data.shop_deliverscope+'" id="shop_delive" />'
                +'<div class="cart_boxs_head" shop_id='+data.shop_id+'>'
                   +'<p class="cart_head_store"><a href="/Category/index/shop_id/'+data.shop_id+'" data-id='+data.shop_id+'><img src="/Public/image/home_icon.png" alt="">'+data.shop_name+'</a></p>'
                   +'<p class="cart_head_close">删除</p>'
               +'</div>'
               +'<div class="cart_boxs_main">'
                   +'<div class="can-enjoy-preferential">'
                   +h2; 
                    for(var k=0;k<figt_goods_data.length;k++){
                        var ret=figt_goods_data[k],goods_pungent="",goods_weight="",goods_unit="",act_name="",goods_weight="";
                        ret.goods_pungent ?goods_pungent='('+ret.goods_pungent+')':goods_pungent="";
                        if(ret.goods_unit == '' || goods_unit == null){
                            goods_unit="";
                            goods_weight="";
                        }else{
                            goods_unit='/'+ret.goods_unit;
                            goods_weight=ret.goods_weight;
                        }
                        sum=Number(sum) + Number(ret.count)
                        ret.act_name?act_name='<span>'+ret.act_name+'</span>':" ";
                        html+='<div class="not-enjoy-preferential">'
                            +'<div class="enjoy-goods" cart-id='+ret.cart_id+' goods_id='+ret.goods_id+'>'
                                +'<div class="not-good-info">'
                                    +'<div class="not-info-left">'
                                        +'<span>购</span>'
                                    +'</div>'
                                    +'<div class="not-info-cent">'
                                        +'<dl>'
                                             +'<dt><img src="'+ret.goods_pic+'" alt="" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></dt>'
                                             +'<dd class="cart_boxs_info">'
                                                 +'<h2 class="ui-ellipsis">'+ret.goods_name+''+goods_pungent+''+goods_weight+''+goods_unit+'</h2>'
                                                 +'<p class="zens">'+act_name+'</p>'
                                                 +'<p class="info_price">￥'+ret.price+'</p>'
                                             +'</dd>'
                                         +'</dl> '
                                    +'</div>'
                                    +'<div class="not-info-right">'
                                        +'<span class="goods_del">-</span>'
                                        +'<input type="text" class="goods_vals" readonly="readonly" value="'+ret.count+'" name="text">'
                                        +'<span class="goods_add">+</span>'
                                    +'</div>'
                                +'</div>'
                            +'</div>'
                       +'</div>';
                            if (figt_goods_data[k].gift_new) {
                                var gift_data=figt_goods_data[k].gift_new;
                                gift_count+=gift_data.count;

                                html+='<div class="enjoy-good-zeng">'
                                       +'<div class="enjoy-zeng-left">'
                                           +'<span>赠</span>'
                                       +'</div>'
                                       +'<div class="enjoy-zeng-cent">'
                                           +'<dl>'
                                                +'<dt><img src="'+gift_data.goods_pic+'" alt="" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></dt>'
                                                +'<dd class="cart_boxs_info">'
                                                    +'<h2 class="ui-ellipsis">'+gift_data.goods_name+'</h2>'
                                                    +'<p class="zens"></p>'
                                                +'</dd>'
                                           +'</dl>'
                                        +'</div>'
                                       +'<div class="enjoy-zeng-right">'                                    
                                           +'<input type="text" value="'+gift_data.count+'" name="text">'
                                       +'</div>'
                                   +'</div>'
                               +'</div>'
                            };
                        };
                html+='</div>'
                        +'<div class="not-enjoy-preferential">' 
                        +h3;
                        for(var k=0;k<no_goods_data.length;k++){
                            var ret=no_goods_data[k],goods_pungent="",goods_weight="",goods_unit="",act_name="",goods_weight="";
                                ret.goods_pungent ?goods_pungent='('+ret.goods_pungent+')':goods_pungent="";
                                if(ret.goods_unit == '' || goods_unit == null){
                                    goods_unit="";
                                    goods_weight="";
                                }else{
                                    goods_unit='/'+ret.goods_unit;
                                    goods_weight=ret.goods_weight;
                                }
                                html+='<div class="enjoy-goods" cart-id='+ret.cart_id+' goods_id='+ret.goods_id+'>'
                                        +'<div class="not-good-info">'
                                            +'<div class="not-info-left">'
                                                +'<span>购</span>'
                                            +'</div>'
                                            +'<div class="not-info-cent">'
                                                +'<dl>'
                                                     +'<dt><img src="'+ret.goods_pic+'" alt="" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></dt>'
                                                     +'<dd class="cart_boxs_info">'
                                                         +'<h2 class="ui-ellipsis">'+ret.goods_name+''+goods_pungent+''+goods_weight+''+goods_unit+'</h2>'
                                                         +'<p class="zens"></p>'
                                                         +'<p class="info_price">￥'+ret.price+'</p>'
                                                     +'</dd>'
                                                 +'</dl>'
                                            +'</div>'
                                            +'<div class="not-info-right">'
                                                +'<span class="goods_del">-</span>'
                                                +'<input type="text" class="goods_vals" readonly="readonly" value="'+ret.count+'" name="text">'
                                                +'<span class="goods_add">+</span>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                        }
        html+='</div>'
            +'</div>'
        $('.cartBox_info').html(html);
        $('.details-zen span').html(gift_count);
        $('.details-combined span').html(sum + gift_count);
        myScrol2.refresh();
        catrs();
    }
         


    function get_Beer(data){
        if(data.goods_gift){
            if(data.goods_gift.money>0){
                $('.vip_beer').show();
                var s=data.goods_gift.tips;
                var reg=/\d+(\.\d+)?/g;
                var num=s.match(reg);
                var as=s.replace(reg,'<b>'+num+'</b>') 
                $('.vip_beer p').html(as);
                $('.hide_beer_box').html('');
                 myScrol2.refresh();
            }else{
                 $('.vip_beer').hide();
                var html='',re = data.goods_gift;
                    for(var k=0;k<re.list.length;k++){
                        var datare = re.list[k];  
                        //赠品数量加啤酒
                        gift_count=gift_count + datare.count;                     
                        html+='<div class="can-enjoy-preferential" data-id='+datare.goods_id+' id="beers">'
                                +'<h2>'+re.tip+'</h2>'
                                +'<div class="enjoy-good-zeng">'
                                    +'<div class="enjoy-zeng-left">'
                                        +'<span>赠</span>'
                                    +'</div>'
                                    +'<div class="enjoy-zeng-cent">'
                                        +'<dl>'
                                            +'<dt><img src="'+datare.goods_pic+'" alt="" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></dt>'
                                            +'<dd class="cart_boxs_info">'
                                                +'<h2 class="ui-ellipsis">'+datare.goods_name+'</h2>'
                                                +'<p class="zens"></p>'
                                            +'</dd>'
                                       +'</dl>'
                                    +'</div>'
                                   +'<div class="enjoy-zeng-right">'                                    
                                       +'<input type="text" value="'+datare.count+'" name="text">'
                                   +'</div>'
                               +'</div>'
                            +'</div>'       
                        }

                $('.hide_beer_box').html(html);
                 myScrol2.refresh();
            }
        }
    }

    
    function get_add_info(data){
       var shop_id =data.shop_id;
        commoms.post_servers('/shop/get_shop_json',{shop_id:shop_id},function(result){
            var html="",rehtml="";
            if(result){
                html+='<li><span>自提点</span><p>'+result.shop_name+'</p></li>'
                     +'<li><span>营业时间</span><p>'+result.shop_opentime+'<a href="tel:'+result.shop_orderphone1+'">'+result.shop_orderphone1+'</a></p></li>'
                     +'<li><span>自提地址</span><p>'+result.shop_address+'</p></li>'
                $('.hideDivs_list').html(html); 

                 var shop_isvip = "",colors="";
                    if(result.shop_isvip==1){
                        shop_isvip="VIP店铺";
                        colors='red';
                    }else if(result.shop_isvip==2){
                        shop_isvip="普通店铺";
                        colors='greens';
                    }else if(result.shop_isvip==3){
                        shop_isvip="代售点";
                        colors='greens_s';
                    }


                rehtml+='<dl class="address_dl">'
                        +'<dt class="address_dt">'
                            +'<a href="/Category/index/shop_id/908">'
                                +'<img class="image" src="'+result.shop_avatar+'" alt="" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'">'
                            +'</a>'
                        +'</dt>'
                        +'<dd class="address_dd_left">'
                            +'<a href="/Category/index"><b class="'+colors+'">'+shop_isvip+'</b>'+result.shop_name+'</a>'
                            +'<div class="dd_left_info">'
                                +'<p class="ipnone">联系电话&nbsp;<a href="tel:'+result.shop_orderphone1+'">'+result.shop_orderphone1+'</a><a href="tel:'+result.shop_orderphone2+'">'+result.shop_orderphone2+'</a></p>'
                                +'<p><span>正常营业&nbsp;'+result.shop_opentime+'</span><span>正常营业&nbsp;'+result.shop_delivertime+'</span></p>'
                                +'<p>地址：'+result.shop_address+'</p>'
                            +'</div>'
                        +'</dd>'
                        +'<dd class="address_dd_right">'
                            +'<p><img src="/Public/image/location_icon_b.png" alt=""><span>'+result.distance+'</span></p>'
                        +'</dd>'
                    +'</dl>'

                    $('.address_session').html(rehtml);
            }else{
                $('.hideDivs_list').html('<p class="reds">请选择收货地址</p>'); 
                $('.address_session').html('');
                $('#adds-main-three .four_null').show();
            }
            myScrol2.refresh();
        },function(){
           // loaging.btn('地址信息错误');
        },false);
    }
        
    //获取总价
    function getnum(shop_ids){
        commoms.post_servers('/Cart/get_num',{shop_id:shop_ids},function(re){
            var data = re.data;
                    loaging.close();
        if(data){
            var prices=data.price.toFixed(2),beer_price=$('.hide_beer_box .enjoy-zeng-right input').val();
                if(!beer_price){
                    beer_price=0;
                }
                jia=Number(gift_count) + Number(data.num);
                //jia=Number(gift_count) + Number(data.num);

            $('.details-num span').html(data.num);
            $('.total-amount span').html(prices);
            $('.details-combined span').html(jia);
            $('.details-zen span').html(gift_count);
        }
        },function(){
            loaging.btn('错误');
        },false);

    }

    function catrs(){
        if(!shop_id){
            shop_id=$('#hide_id').val();
        }
        //点击加ajax
        $('.goods_add').on(tapClick(),function(){
            var goods_id=$(this).parents('.enjoy-goods').attr('goods_id');
            var counts = $(this).siblings('.goods_vals').val()*1;
                counts+=1;
                commoms.post_server('/Cart/add',{shop_id:shop_id,goods_id:goods_id},function(data){
                    loaging.close();
                    if(data.result == 'ok'){
                       
                       carts();
                    }
                    },function(){
                    loaging.btn('加入失败');
                },false);
        })
        //点击减ajax
        $('.goods_del').on(tapClick(),function(){ 
            var goods_id=$(this).parents('.enjoy-goods').attr('goods_id');
            var counts = $(this).siblings('.goods_vals').val()*1;
                 commoms.post_server('/Cart/add',{shop_id:shop_id,goods_id:goods_id,count:"-1"},function(data){
                    loaging.close();
                    if(data.result == 'ok'){
                       carts();
                    }
                    },function(){
                    loaging.btn('加入失败');
                },false);
        })
        //点击删除ajax
        $('.cart_head_close').on(tapClick(),function(){
                layer.open({
                    content:'<div class="box-mask-html"  style="color:#000000"><h2>提示</h2><p>确认删除这家店铺</p></div>',
                    style: 'width:100%;border:none;text-align:center;color:#4DB4F9;font-size:16px;',
                    shadeClose: false,
                    btn: ['确定','取消'],
                    yes: function(){
                        loaging.close();
                        setTimeout(function(){
                           commoms.post_server('/Cart/del',{cart_id:'',shop_id:shop_id},function(data){
                            if(data.result == 'ok'){
                                
                               carts(); 
                            }
                            },function(){
                                loaging.btn('删除失败');
                                carts();
                        },false);
                        },100)
                    }
                })
        })
    }
}







if($('#deliverscope').val() == 0){
    $('.buttons p').off(tapClick());
    $('.buttons p').eq(1).addClass('box_set').siblings().removeClass('box_set');
    $('.hide_Divs').eq(1).show().siblings().hide();
    $('.buttons p').eq(0).css('background','#999999');
}else{
    $('.buttons p').on(tapClick(),function(){
        var index = $(this).index();
        $(this).addClass('box_set').siblings().removeClass('box_set');
        $('.hide_Divs').eq(index).show().siblings().hide();
        myScrol2.refresh();
    
    })
}







//点击地址ajax
$('#selectAddr').off(tapClick());
$('#selectAddr').on(tapClick(),function(){
    var txt = $('.buttons .box_set').html();
    if($('#deliverscope').val() == 0){
        loaging.prompts('本店仅支持到店自提');
        return false;
    }
    if(txt == '送货上门'){
        $('.adds_selection .head_box p').eq(0).addClass('box_set').siblings().removeClass('box_set');
        $('.adds_selection .addrlist_main>div').eq(0).show().siblings().hide();
       
    }else{
       $('.adds_selection .head_box p').eq(1).addClass('box_set').siblings().removeClass('box_set');
       $('.adds_selection .addrlist_main>div').eq(1).show().siblings().hide();
    } 
    commoms.post_server('/Address/ajax_get_address',{},function(result){
            loaging.close();
            $('#adds_selections').show();
            if(result.result == 'ok'){
                    var data=eval(result.data),
                        html="",
                        checkinp="";
                if(data){    
                    for(var k=0;k<data.length;k++){
                        data[k].default == 1?checkinp = '<input type="radio" name="radio" checked="checked" class="inputColor">':checkinp = '<input type="radio" name="radio">';
                        html+='<dl class="addselect_boxs" city-id='+data[k].cityid+' data-lat='+data[k].lat+' data-lng='+data[k].lng+'>'
                            +'<dt class="addselect_input">'+checkinp+'</dt>'
                            +'<dd class="addselect_con">'
                                +'<a href="javascript:void(0);">'
                                    +'<div class="addselect_names">'
                                        +'<span class="cartname">'+data[k].username+'</span>'
                                        +'<span class="cartphone">'+data[k].phone+'</span>'
                                    +'</div>'
                                    +'<p class="addselect_del">'
                                        +'<span>'+data[k].cityname+'</span>&nbsp;<span>'+data[k].district+'</span>&nbsp;<span>'+data[k].address+'</span>'
                                    +'</p>'
                                +'</a>'
                            +'</dd>'
                        +'</dl>'
                    } 
                    $('#addselect_mins').html(html);
                    myScrol9.refresh();
                    $('.addselect_boxs').on(tapClick(),function(){
                        var inp=$('.addselect_boxs').find('input');
                        var index=$(this).index();
                        inp.removeClass('inputColor');
                        $(this).find('input').addClass('inputColor');
                        $('.cart_name').html($(this).find('.cartname').html());
                        $('.tbodys').attr('user-id',$(this).attr('user-id'));
                        $('.cart_phone').html($(this).find('.cartphone').html());
                        $('.cart_adds').html($(this).find('.addselect_del').html());
                        $('#shop_head').attr('data-lat',$(this).attr('data-lat'));
                        $('#shop_head').attr('data-lng',$(this).attr('data-lng'));
                        $('.buttons p').eq(0).addClass('box_set').siblings().removeClass('box_set');
                        $('.hide_Divs').eq(0).show().siblings().hide();
                        $('#adds_selections').hide();  
                    })
                }else{
                    $('#addselect_mins').html('<div class="add_mins"><img src="/Public/image/add_null.png" alt="" /></div>');
                }
            }
        },function(){
        loaging.btn('错误');
    },false);
      
})
                 
//点击提交ajax
$('.price-details-sub').off(tapClick());
$('.price-details-sub').on(tapClick(),function(){  
    var txt =$('.buttons .box_set').html(),
        dataIndex = $('.buttons .box_set').index();
         var deliver_type=0;//是否是送货上门
         var addressid=0;
         var shopid=$('.cart_boxs_head').attr('shop_id');
        if(txt == '送货上门' && dataIndex == 0){
            deliver_type=0;
             if($('#tbodys').attr('user-id')){
            var data_lat=$('#shop_head').attr('data-lat'),
                data_lng=$('#shop_head').attr('data-lng'),
                shop_lat=$('#head').attr('shop_lat'),
                shop_delive=$('#shop_delive').val(),
                shop_lng=$('#head').attr('shop_lng');
                if(data_lat && data_lng && shop_lat && shop_lng){
                    addressid=$('#shop_head').attr('address-id');
                    var getM=commoms.getDistanceOfJW({"lat":data_lat,"lng":data_lng},{"lat":shop_lat,"lng":shop_lng}),
                    getMS=getnums(getM/1000);
                    if(getMS > shop_delive){
                       loaging.prompts('超出配送范围');
                       return false;
                    }
                }
            }else{
                loaging.prompts('请选择地址');
                return false;
            }
        }else{
            deliver_type=1;
            addressid=0;
        }

        cartid="";
        beers="";
        


        if($('#beers').attr('data-id')){
            beers = $('#beers').attr('data-id');
            cartid=$('#shop_carts').attr('cart-id').substr(1)+','+beers;
        }else{
            beers="";
            $('#shop_carts').attr('cart-id').substr(1)?cartid=$('#shop_carts').attr('cart-id').substr(1):cartid="";
        }
        if($('.mod_coupons_dl input[type=checkbox]').attr('checked') && $('.mod_coupons_dl input[type=checkbox]').hasClass('checks')){
            act_ticket=$('#mod_coupons_dls').attr('data-ticket');
        }else{
            act_ticket=0;
        }
        location.href='/Order/confirm?address_id='+addressid+'&shop_id='+shopid+'&cart_ids='+cartid+'&deliver_type='+deliver_type+'&act_ticket='+act_ticket;







    // if(txt == '送货上门' && dataIndex == 0){
    //     if($('#tbodys').attr('user-id')){
    //         var data_lat=$('#shop_head').attr('data-lat'),
    //             data_lng=$('#shop_head').attr('data-lng'),
    //             shop_lat=$('#head').attr('shop_lat'),
    //             shop_lng=$('#head').attr('shop_lng'),
    //             shop_delive=$('#shop_delive').val(),
    //             prices = $('.total-amount span').text();
    //             if(data_lat && data_lng && shop_lat && shop_lng){
    //                 var addressid=$('#shop_head').attr('address-id'),
    //                     shopid=$('.cart_boxs_head').attr('shop_id'),
    //                     deliver_type=0;
    //                     cartid="";
    //                     $('#shop_carts').attr('cart-id').substr(1)?cartid=$('#shop_carts').attr('cart-id').substr(1):cartid="";
    //                     if($('.mod_coupons_dl input[type=checkbox]').attr('checked') && $('.mod_coupons_dl input[type=checkbox]').hasClass('checks')){
    //                         act_ticket=$('#mod_coupons_dls').attr('data-ticket');
    //                     }else{
    //                         act_ticket=0;
    //                     }
    //                 var getM=commoms.getDistanceOfJW({"lat":data_lat,"lng":data_lng},{"lat":shop_lat,"lng":shop_lng}),
    //                 getMS=getnums(getM/1000);
    //                 if(getMS > shop_delive){
    //                    loaging.prompts('超出配送范围');
    //                    return false;
    //                 }else if(getMS <= shop_delive){ 
    //                     if(addressid && shopid && act_ticket && cartid || act_ticket==0){
    //                         location.href='/Order/confirm?address_id='+addressid+'&shop_id='+shopid+'&cart_ids='+cartid+'&deliver_type=0&act_ticket='+act_ticket+'';
    //                     }
    //                 }
    //             }
    //     }else{
    //         loaging.prompts('请选择地址');
    //     }
    // }else{
    //     var data_lat=$('#shop_head').attr('data-lat'),
    //         data_lng=$('#shop_head').attr('data-lng'),
    //         shop_lat=$('#head').attr('shop_lat'),
    //         shop_lng=$('#head').attr('shop_lng'),
    //         shop_delive=$('#shop_delive').val(),
    //         prices = $('.total-amount span').text();
    //         if(data_lat && data_lng && shop_lat && shop_lng){
    //             var addressid=$('#shop_head').attr('address-id'),
    //                 shopid=$('.cart_boxs_head').attr('shop_id'),
    //                 deliver_type=0;
    //                 cartid="";
    //                 $('#shop_carts').attr('cart-id').substr(1)?cartid=$('#shop_carts').attr('cart-id').substr(1):cartid="";
    //                 if($('.mod_coupons_dl input[type=checkbox]').attr('checked') && $('.mod_coupons_dl input[type=checkbox]').hasClass('checks')){
    //                     act_ticket=$('#mod_coupons_dls').attr('data-ticket');
    //                 }else{
    //                     act_ticket=0;
    //                 }
    //     location.href='/Order/confirm?address_id='+addressid+'&shop_id='+shopid+'&cart_ids='+cartid+'&deliver_type=0&act_ticket='+act_ticket+'';
                  
    //             }



    // }
    
    
})