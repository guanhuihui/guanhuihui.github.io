var myScrol,myScrol9,myScrol2,lists = {probeType: 3,mouseWheel: true,scrollbars: false},myScrol3,myScrol4,
    trans0 = {'-webkit-transform':'translate3d(0,0,0)','transform':'translate3d(0,0,0)'},
    trans1 ={'-webkit-transform':'translate3d(0,200%,0)','transform':'translate3d(0,200%,0)'},
    listss = { probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false };
    if($('#list-productss') || $('#mod_pay_dist') || $('#mod_pay_dist2') || $('#adds-main-one')){
        myScrol2=new IScroll('#list-productss',listss);
        myScrol3 = new IScroll('#mod_pay_dist', lists);
        myScrol4 = new IScroll('#mod_pay_dist2', lists);
        myScrol9 = new IScroll('#adds-main-one',listss);
    }
    var pay_dist=$('#mod_pay_dist'),dBox = $('#mod_pay_distribution'),dBox2 = $('#mod_pay_distribution2'),mod_show = $('#mod_pay_data1 .mod_show'),mod_show2 = $('#mod_pay_data2 .mod_show'),wayinput=$('.mod_dir_way1>div').find('input'),wayinput2=$('.mod_dir_way2>div').find('input'),head_box = $('#adds_selections .head_box p'),cartBx_tle = $('#cartBx-title'),cartBx_tle2 = $('#cartBx-title2'),detldivs = $('.addselect_boxs .addselect_con'),bthp = $('#Btns p'),selectAddr = $('#selectAddr'),addsec = $('#adds_selections'),onedivs = $('#adds-main-one'),twodivs = $('#adds-main3'),pubcart = $('#adds_selections .pub-cart'),detldiv = $('.addselect_boxs'),waydiv=$('.mod_dir_way1 .wayDiv'),waydivs=$('.mod_dir_way2 .wayDivs'),wayTimerSec = $('.mod_pay_divs1 p'),wayTimerSec2 = $('.mod_pay_divs2 p'),$pubcart_box = $('#pub-cart-box'),four_null = $('.four_null'),mod_paydist2 = $('#mod_pay_dist2'),subBth = $('.price-details-sub'),deldt = $('.addselect_input'),indexIds = $('#ids'),pay_timeSize1 = $('.pay_timeSize1'),pay_timeSize2 = $('.pay_timeSize2'),$ui_graybg = $('#receive-ui-graybg'),shop_deliver_type = $('#shop_deliver_type'),typeval = $('#book_deliver_type').val(), distribution = $('#distribution'),Next_step = $('.Next_step');
  var table = $('#tbodys'),
        tabname = $('.cart_name'),
        tabphone = $('.cart_phone'),
        tabdel = $('.cart_adds'),
        tabhideid = $('#addressid'),
        tablng = $('#tablng'),
        tablat = $('#tablat');
        four_null.on(tapClick(),function(){
            loaging.close();
            loaging.init('加载中...');
            top.location.href='/index/index';
        })
    $(document).ready(function() {
        init();
        clicks();
        score('adds_selections','wrap_cartx');
        returnBth();
        carts();
        Istypes();
        function Istypes(){
            if(shop_deliver_type.val() == 2 || distribution.val() == 1){
                waydiv.eq(1).click();
                waydivs.eq(1).click();
                $ui_graybg.hide();
                myScrol2.refresh();
            }
        }   
        function init(){
            $('.abtn,#adds-main3 .generic-item-img,#adds-main3 .generic-item_info').on(tapClick(),function(){
               var dataId = $(this).attr('data-id');
                loaging.close();
                loaging.init('加载中...');
                top.location.href='/Category/index/shop_id/'+dataId+'';
            })
            $('#nulls').on('click',function(){
                top.location.href='/index/index';
            })
            if(top.location!==self.location){ 
                $('#heds .asd').hide();
            } 
            if(top.location!==self.location){ 
                $('#heds .asd').hide();
            } 
        }
        function clicks(){
            var MinBox = $('.adds_selection .wayMins'),
                waythreeDiv = $('.mod_dir_way_three'),
                lis = $('#mod_pay_data1 .mod_pay_uls li');
                lis2 = $('#mod_pay_data2 .mod_pay_uls li');
            /*cart首页  选择地址   点击*/
            selectAddr.off('click');
            selectAddr.on('click',function(){
                if($pubcart_box){
                    parent.window.$('#pub-cart-box').hide();
                }
                if(indexIds.val() == '0'){
                  head_box.eq(0).addClass('box_set').siblings().removeClass('box_set');
                  onedivs.show().siblings().hide();
                  pubcart.show();
                }else{
                   head_box.eq(1).addClass('box_set').siblings().removeClass('box_set');
                   twodivs.show().siblings().hide();
                   pubcart.hide();
                } 
                addsec.show().siblings().hide();
                pubcart.show();
                myScrol9.refresh();

            });
             /*选择地址  地址列表 选择  点击*/
            detldivs.on('click',function(){
                var  detldivBox = $(this).parents('.addselect_boxs');
                bthp.off(tapClick());
                bthp.eq(0).addClass('box_set').siblings().removeClass('box_set');

                $('.hide_Divs').eq(0).show().siblings().hide();

                deldt.find('input[type=checkbox]').removeClass('inputColor');
                deldt.find('input[type=checkbox]').attr('checked',false);
                detldivBox.find('.addselect_input input').addClass('inputColor');
                detldivBox.find('input[type=checkbox]').attr('checked',true);


                tabname.html(detldivBox.find('.cartname').html());
                tabphone.html(detldivBox.find('.cartphone').html());
                tabdel.html(detldivBox.find('.addselect_del').html());
                tabhideid.val(detldivBox.find('input[name=addressid]').val());
                tablng.val(detldivBox.find('input[name=lng]').val());
                tablat.val(detldivBox.find('input[name=lat]').val());


                if($pubcart_box){
                    parent.window.$('#pub-cart-box').show();
                }
                addsec.hide();
                $('#mod-carts').show();
                myScrol2.refresh();

            })
            /*-------------------------------------1---------------------------------------*/
            /*预约送货  点击选择日期  点击*/
            cartBx_tle.on('click',function(){
                if($pubcart_box){
                    parent.window.$('#pub-cart-box').hide();
                }
                dBox.show();
               /* waydiv.eq(0).click();*/
                myScrol3.refresh();
                myScrol4.refresh();
            })
            /*配送方式选择*/
            waydiv.off('click');
            waydiv.on('click',function(){
                var index=$(this).index();
                    wayinput.removeClass('checks');
                    $(this).find('input').addClass('checks');
                    wayinput.attr('checked',false);
                    $(this).find('input').attr('checked','checked');
                    if(index == 2 || index == 1){
                        pay_dist.css(trans0);
                        Next_step.hide();
                    }else{
                        pay_dist.css(trans1);
                        Next_step.show();
                    }
                    pay_timeSize1.html($(this).text());
            })

            //时间选择  添加样式
            lis.on(tapClick(),function(){
                var index = $(this).index();
                lis.find('span').removeClass('spans')
                $(this).find('span').addClass('spans');
            })
            lis2.on(tapClick(),function(){
                var index = $(this).index();
                lis2.find('span').removeClass('spans')
                $(this).find('span').addClass('spans');
            })

             /*预约送货   选择时间 今天明天 点击*/
            wayTimerSec.on(tapClick(),function(){
              var index=$(this).index();
              $('.book_day').blur();
              $(this).addClass('p_green').siblings().removeClass('p_green');
              mod_show.eq(index).show().siblings().hide();
              myScrol3.refresh();
            })
           /*-------------------------------------2---------------------------------------*/
           //预定产品头部点击
           cartBx_tle2.on('click',function(){
                //判断底部存不存在
                if($pubcart_box){
                    parent.window.$('#pub-cart-box').hide();
                }
                dBox2.show();
                myScrol3.refresh();
                myScrol4.refresh();
            })
            /*配送方式选择*/
            waydivs.off('click');
            waydivs.on('click',function(){
                var index=$(this).index();
                    wayinput2.removeClass('checks');
                    $(this).find('input').addClass('checks');
                    wayinput2.attr('checked',false);
                    $(this).find('input').attr('checked','checked');
                    mod_paydist2.css(trans0);
                    myScrol4.refresh();
                    pay_timeSize2.html($(this).text());
            })
            //送货时间点击
            wayTimerSec2.on(tapClick(),function(){
              var index=$(this).index();
              $('.book_day').blur();
              $(this).addClass('p_green').siblings().removeClass('p_green');
              mod_show2.eq(index).show().siblings().hide();
              myScrol4.refresh();
            })
            //日期点击
            $('.mod_pay_set .mod_pay_ps1').on(tapClick(),function(){
                $('.book_day').blur();
                $('.mod_pay_divs1 p').eq(1).addClass('p_green').siblings().removeClass('p_green');
                $('#mod_pay_data1 .mod_show').eq(1).show().siblings().hide();
                myScrol3.refresh();
            })
            //日期点击
            $('.mod_pay_set .mod_pay_ps2').on(tapClick(),function(){
                $('.book_day').blur();
                $('.mod_pay_divs2 p').eq(1).addClass('p_green').siblings().removeClass('p_green');
                $('#mod_pay_data2 .mod_show').eq(1).show().siblings().hide();
                myScrol4.refresh();
            })
        }
        function returnBth(){
            $('#icon-backss').on('tap',function(){
                var go_previous_shop_id = $('#go_previous_shop_id').val();
                loaging.close();
                loaging.init('加载中...');
                if(go_previous_shop_id){
                    window.location.href='/Category/index/shop_id/'+go_previous_shop_id+'';
                }else{
                    window.history.go(-1);
                }
            })
            var icon_back = $('.icon-back'),
                div1span1 = $('#distri_div1 #span1'),
                div2span2 = $('#distri_div1 #span2'),
                div12span1 = $('#distri_div2 #spans1'),
                div22span2 = $('#distri_div2 #spans2');

            function modpay1(){
                var dayBox1 = $('.mod_dir_way1'),
                    idx = dayBox1.find('.checks').attr('data-index'),
                    txt= "",
                    time_ymd='';
                    txt = dayBox1.find('.checks').val();
                    txtcs = dayBox1.find('.checks'),
                    hideType = $('#normal_deliver_type'),
                    button_id = $('#button_id');
                    $("input[name='hide-times']").val("");

                    var hasSpan = $('.mod_pay_uls1 li span').hasClass('spans'),
                    ymd = $('#normal_time_ymd');
                        if (idx == 2 && !hasSpan  || idx == 1 && !hasSpan) {
                            loaging.close();
                            loaging.prompts('请选择配送时间');
                            if($pubcart_box){
                                parent.window.$('#pub-cart-box').hide();
                            }
                            return false;
                        };
                        if(idx){
                            if(idx == 2 && !hasSpan  || idx == 1 && !hasSpan || idx == 0 ){
                                txt = '即时送货';
                                time_ymd = "即时送货";
                                hideType.val(0);
                                ymd.val('0');
                                button_id.val(0);//现货配送方式hidden
                                $ui_graybg.show();
                            }else{
                                if(idx == 1 && hasSpan ){
                                    var ind = $('.spans').parents('.mod_show1').attr('data-index');
                                    if(ind == 1){
                                        var split_text = $('#book_day1 option:checked').text().split('(');
                                        time_ymd = split_text[0] +' '+ $('.mod_show1').eq(1).find('.spans').text();
                                    }else{
                                        var split_text2 = $('.mod_pay_ps1').text().split('(');
                                        time_ymd = split_text2[0] +' '+ $('.mod_show1').eq(0).find('.spans').text();
                                    }
                                    ymd.val(time_ymd);
                                    hideType.val(1);
                                    button_id.val(1);//现货配送方式hidden
                                    $ui_graybg.hide();
                                }else if(idx == 2 && hasSpan){                                     
                                    var ind = $('.spans').parents('.mod_show1').attr('data-index');
                                    if(ind == 1){
                                        var split_text = $('#book_day1 option:checked').text().split('(');
                                        time_ymd = split_text[0] +' '+ $('.mod_show1').eq(1).find('.spans').text();
                                    }else{
                                        var split_text2 = $('.mod_pay_ps1').text().split('(');
                                        time_ymd = split_text2[0] +' '+ $('.mod_show1').eq(0).find('.spans').text();
                                    }
                                    ymd.val(time_ymd);
                                    hideType.val(0);
                                    button_id.val(2);//现货配送方式hidden
                                    $ui_graybg.show();

                                }else{
                                    txt = '即时送货';
                                    time_ymd = "即时送货";
                                    ymd.val('0');
                                    hideType.val(0);
                                    button_id.val(0);//现货配送方式hidden
                                    $ui_graybg.show();
                                }
                                txt = txtcs.val();
                            }

                        }else{
                          txt = '即时送货';
                          hideType.val(0);
                          time_ymd = "即时送货";
                          ymd.val('0');
                          button_id.val(0);//现货配送方式hidden
                          $ui_graybg.show();
                        }    
                    //如果只支持到店自提
                    if(shop_deliver_type.val() == 2){
                        if(idx != 1){
                            loaging.close();
                            loaging.btn('本店仅支持到店自提');
                            if($pubcart_box){
                                parent.window.$('#pub-cart-box').hide();
                            }
                            return false;
                        }
                    }
                    div1span1.html(txt);
                    div2span2.html(time_ymd);

                    dBox.hide(); 
                    if($pubcart_box){
                        parent.window.$('#pub-cart-box').show();
                    }
                    myScrol2.refresh();
            }
            function modpay2(){
                var dayBox2 = $('.mod_dir_way2'),
                    idx = dayBox2.find('.checks').attr('data-index'),
                    txt= "",
                    time_ymd='';
                    txt = dayBox2.find('.checks').val();
                    txtcs = dayBox2.find('.checks'),
                    hideType2 = $('#book_deliver_type');

                    $("input[name='hide-times2']").val("");
                    var ymd = $('#book_time_ymd');

                    var hasSpan = $('.mod_pay_uls2 li span').hasClass('spans'),
                        onetxt = $('.mod_pay_ps2').text() +' '+ $('.mod_show2').eq(0).find('.spans').text();
                        if (idx == 2 && !hasSpan  || idx == 1 && !hasSpan) {
                            loaging.close();
                            loaging.prompts('请选择配送时间');
                            if($pubcart_box){
                                parent.window.$('#pub-cart-box').hide();
                            }
                            return false;
                        };
                        if(idx){
                            if(idx == 0 && !hasSpan  || idx == 1 && !hasSpan){
                                txt = '预约送货';
                                time_ymd = onetxt;
                                hideType2.val(0);
                                ymd.val(time_ymd);
                                $ui_graybg.show();
                            }else{
                                if(idx == 0 && hasSpan ){
                                    $ui_graybg.show();

                                    var ind = $('.spans').parents('.mod_show2').attr('data-index');
                                    if(ind == 1){
                                        var split_text = $('#book_day2 option:checked').text().split('(');
                                        time_ymd = split_text[0] +' '+ $('.mod_show2').eq(1).find('.spans').text();
                                    }else{
                                        var split_text2 = $('.mod_pay_ps2').text().split('(');
                                        time_ymd = split_text2[0] +' '+ $('.mod_show2').eq(0).find('.spans').text();
                                    }
                                    hideType2.val(0);
                                    ymd.val(time_ymd);
                                }else if(idx == 1 && hasSpan){  


                                    $ui_graybg.hide();

                                    var ind = $('.spans').parents('.mod_show2').attr('data-index');
                                    if(ind == 1){
                                        var split_text = $('#book_day2 option:checked').text().split('(');
                                        time_ymd = split_text[0] +' '+ $('.mod_show2').eq(1).find('.spans').text();
                                    }else{
                                        var split_text2 = $('.mod_pay_ps2').text().split('(');
                                        time_ymd = split_text2[0] +' '+ $('.mod_show2').eq(0).find('.spans').text();
                                    }
                                    ymd.val(time_ymd);
                                    hideType2.val(1);
                                }else{
                                    txt = '预约送货';
                                    time_ymd = onetxt;
                                    hideType2.val(0);
                                    ymd.val(time_ymd);
                                    $ui_graybg.show();
                                }
                            }
                        }else{
                          txt = '预约送货';
                          hideType2.val(0);
                          time_ymd = onetxt;
                          ymd.val(time_ymd);
                          $ui_graybg.show();
                        }  

                     //如果只支持到店自提
                    if(shop_deliver_type.val() == 2){
                       if(idx != 1){
                            loaging.close();
                            loaging.btn('本店仅支持到店自提');
                            if($pubcart_box){
                                parent.window.$('#pub-cart-box').hide();
                            }
                            return false;
                        }
                        
                    }

                    $('#distri_div2 #spans1').html(txt);
                    $('#distri_div2 #spans2').html(time_ymd);
                    if($pubcart_box){
                        parent.window.$('#pub-cart-box').show();
                    }
                    dBox2.hide(); 
                    myScrol2.refresh();
            }
            icon_back.on('click',function(){
                if($pubcart_box){
                    parent.window.$('#pub-cart-box').show();
                }
                $('input,textarea').blur();
                var parentName=$(this).parents('div').attr('class');
                if(parentName.indexOf('adds_selection') > -1){
                    addsec.hide();
                    $('#mod-carts').show();
                }else if(parentName.indexOf('modpay1')>-1){
                    modpay1();
                }else if(parentName.indexOf('modpay2')>-1){
                    modpay2();
                }  
                myScrol2.refresh();
            })
            $('#mod_pay_distribution .mpu_uBtn').on('tap',function(){
                modpay1();
            });
            $('.Next_step').on('tap',function(){
                modpay1();
            })
            $('#mod_pay_distribution2 .mpu_uBtn').on('tap',function(){
                modpay2();
            })
            
        }
        function carts(){
                var shop_id=$('#shop_id').val();
                $('.goods_add').off(tapClick());
                $('.goods_add').on(tapClick(),function(){
                    loaging.init('加载中..');
                    var goods_id=$(this).parents('.enjoy-divs').attr('goods-id');
                    var counts = $(this).siblings('.goods_vals').val()*1;
                        counts+=1;
                        commoms.post_servers('/Cart/add',{shop_id:shop_id,goods_id:goods_id},function(data){
                            if(data.result == 'ok'){
                                location.reload();
                            }else{
                                loaging.close();
                                loaging.btn('加入失败，请重试');
                            }
                            },function(){
                                loaging.close();
                                loaging.btn('加入失败');
                        },false);
                })
                $('.goods_del').off(tapClick());
                $('.goods_del').on(tapClick(),function(){ 
                    loaging.init('加载中..');
                    var goods_id=$(this).parents('.enjoy-divs').attr('goods-id');
                    var counts = $(this).siblings('.goods_vals').val()*1;
                         commoms.post_servers('/Cart/add',{shop_id:shop_id,goods_id:goods_id,count:"-1"},function(data){
                            if(data.result == 'ok'){
                               location.reload();
                            }else{
                                 loaging.close();
                                 loaging.btn('删除失败，请重试');
                            }
                            },function(){
                                loaging.close();
                                loaging.btn('加入失败');
                        },false);
                })
                $('.cart_head_close').off(tapClick());
                $('.cart_head_close').on(tapClick(),function(){
                    var that = $(this),
                        inx = that.parents('.cart_buyBox').index(),
                        parent = that.parents('.cart_buyBox').attr('id');
                        cart_ids = "";
                        if(parent == 'cart_buyBox1'){
                            cart_ids = $('#normal_goods_data_art_ids').val();
                        }else{
                            cart_ids = $('#book_goods_data_art_ids').val();
                        }
                        layer.open({
                            content:'<div class="box-mask-html"  style="color:#000000"><h2>提示</h2><p>确认删除这家店铺</p></div>',
                            style: 'width:100%;border:none;text-align:center;color:#4DB4F9;font-size:16px;',
                            shadeClose: false,
                            btn: ['确定','取消'],
                            yes: function(){
                                loaging.close();
                                setTimeout(function(){
                                   commoms.post_server('/Cart/del',{cart_id:cart_ids,shop_id:''},function(data){
                                    if(data.result == 'ok'){
                                       location.reload(); 
                                    }else{
                                        loaging.btn('删除失败，请重试');
                                    }
                                    },function(){
                                        loaging.btn('删除失败');
                                        location.reload();
                                },false);
                                },100);
                            }
                        })
                })


                var subBth = $('.cartBx_go');
                $('#submit1').off(tapClick());
                $('#submit1').on(tapClick(),function(){ 
                    shopid=$('#shop_id').val();
                    var deliver_type=0,
                        addressid=0,
                        act_ticket,
                        goods_ticket,
                        typeval = $('#normal_deliver_type').val(),
                        time_ymd=0,
                        button_id = $('#button_id');
                        normal_ticket_id = $('#normal_ticket_id').val();

                        if (typeval == '-1') {
                            setTimeout(function(){
                                if($pubcart_box){
                                parent.window.$('#pub-cart-box').hide();
                                }
                                dBox.show();
                                myScrol3.refresh();
                                myScrol4.refresh();
                            },0);

                            loaging.prompts('请选择配送方式');
                            return false;
                        }
                        if(button_id.val() == 0){
                           if($('#shop_open_status').val() == 2 || $('#shop_delivertime_status').val() == 2){
                                loaging.close();
                                loaging.btn('超过营业时间，请选择其他方式');
                                return false;
                            }
                        }
                        //如果只支持到店自提
                        if(shop_deliver_type.val() == 2){
                            if(typeval == 0){
                                loaging.close();
                                loaging.btn('本店仅支持到店自提');
                                return false;
                            }
                            
                        }
                    if(typeval == 0){
                        deliver_type=0;
                         if($('#userids').val()){
                            var data_lat=$('#tablat').val(),
                                data_lng=$('#tablng').val(),
                                shop_lat=$('#shop_lat').val(),
                                shop_delive=$('#shop_deliverscope').val(),
                                shop_lng=$('#shop_lng').val();
                                if(data_lat && data_lng && shop_lat && shop_lng){

                                    addressid=$('#addressid').val();

                                    var ls = data_lat+','+data_lng,
                                        lt = shop_lat+','+shop_lng;
                                        var getMS = "";
                                    $.ajax({
                                        url: "http://api.map.baidu.com/direction/v1?",
                                        data: {
                                            ak: "Y0ob2VcNB4X6wSamoz8eyACG",
                                            output: "json",
                                            mode:'walking',
                                            origin:ls,
                                            destination:lt,
                                            region:'北京'
                                        },
                                        dataType: "jsonp",
                                        success: function(res) {
                                            if(res.status == 0){
                                                ajax_res(res);
                                            }else{
                                                var getM ="0";
                                            }
                                        },
                                        error: function() {
                                            loaging.prompts('请删除地址，重新新建地址');
                                        }
                                    })
                                    
                                    function ajax_res(res){
                                        var getM = res.result.routes[0].distance *1;
                                        //console.log(getM);

                                        getMS= getM/1000;

                                        $('#hide_m').val(getM*1);

                                         //console.log(getMS);
                                        if(getMS > shop_delive){
                                           loaging.prompts('超出配送范围');
                                           return false;
                                        }
                                        getInfos(getM);
                                    }
                                }
                            }else{
                                loaging.prompts('请选择地址');
                                return false;
                            }
                        }else{
                            deliver_type=1;
                            addressid=0;
                             var getM = "0";
                             getInfos(getM);
                        }


                        function getInfos(getM){

                            //判断即时送货是否超出配送时间
                            cartid="";
                            beers="";
                            $('#normal_act_ticket').val()?act_ticket=$('#normal_act_ticket').val():act_ticket=0;
                            $('#normal_goods_ticket').val()?goods_ticket=$('#normal_goods_ticket').val():goods_ticket=0;
                            cartid = $('#normal_goods_data_art_ids').val();
                            time_ymd=$('#normal_time_ymd').val();
                            $ui_graybg ? getMSS = getM :  getMSS = "0";
                            if(cartid && shop_id){
                                top.location.href='/Order/confirm?address_id='+addressid+'&shop_id='+shopid+'&cart_ids='+cartid+'&deliver_type='+deliver_type+'&act_ticket='+act_ticket+'&goods_ticket='+goods_ticket+'&time_ymd='+time_ymd+'&is_book_goods=0&ticket_list_ids='+normal_ticket_id+'&deliver_distance='+getMSS;
                            }
                        }
                });
                $('#submit2').off(tapClick());
                $('#submit2').on(tapClick(),function(){ 
                    shopid=$('#shop_id').val();
                        var deliver_type=0,
                            addressid=0,
                            act_ticket,
                            goods_ticket,
                            typeval = $('#book_deliver_type').val(),
                            book_ticket_id = $('#book_ticket_id').val();

                            if (typeval == '-1') {
                                setTimeout(function(){
                                    //判断底部存不存在
                                    if($pubcart_box){
                                        parent.window.$('#pub-cart-box').hide();
                                    }
                                    dBox2.show();
                                    myScrol3.refresh();
                                    myScrol4.refresh();

                                },0);

                                loaging.prompts('请选择配送方式');

                                return false;
                            }

                        //如果只支持到店自提
                        if(shop_deliver_type.val() == 2){
                            if(typeval == 0){
                                loaging.close();
                                loaging.btn('本店仅支持到店自提');
                                return false;
                            }
                        }

                        if(typeval == 0){
                            deliver_type=0;
                            if($('#userids').val()){
                                var data_lat=$('#tablat').val(),
                                    data_lng=$('#tablng').val(),
                                    shop_lat=$('#shop_lat').val(),
                                    shop_delive=$('#shop_deliverscope').val(),
                                    shop_lng=$('#shop_lng').val();
                                    if(data_lat && data_lng && shop_lat && shop_lng){
                                        addressid=$('#addressid').val();

                                        var ls = data_lat+','+data_lng,
                                            lt = shop_lat+','+shop_lng;
                                            var getMS = "";
                                        $.ajax({
                                            url: "http://api.map.baidu.com/direction/v1?",
                                            data: {
                                                ak: "Y0ob2VcNB4X6wSamoz8eyACG",
                                                output: "json",
                                                mode:'walking',
                                                origin:ls,
                                                destination:lt,
                                                region:'北京'
                                            },
                                            dataType: "jsonp",
                                            success: function(res) {
                                                if(res.status == 0){
                                                    ajax_res(res);
                                                }else{
                                                    var getM ="0";
                                                }
                                            },
                                            error: function() {
                                                loaging.prompts('请删除地址，重新新建地址');
                                            }
                                        })
                                        
                                        function ajax_res(res){
                                            var getM = res.result.routes[0].distance *1;
                                            //console.log(getM);

                                            getMS= getM/1000;

                                            $('#hide_m').val(getM*1);

                                             //console.log(getMS);
                                            if(getMS > shop_delive){
                                               loaging.prompts('超出配送范围');
                                               return false;
                                            }
                                            getInfos(getM);
                                        }
                                    }
                                }else{
                                    loaging.prompts('请选择地址');
                                    return false;
                                }
                            }else{
                                deliver_type=1;
                                addressid=0;
                                var getM = "0";
                                getInfos(getM);
                            }

                            function getInfos(getM){
                                 cartid="";
                                 beers="";
                                 $('#book_act_ticket').val()?act_ticket=$('#book_act_ticket').val():act_ticket=0;
                                 $('#book_goods_ticket').val()?goods_ticket=$('#book_goods_ticket').val():goods_ticket=0;
                                 cartid = $('#book_goods_data_art_ids').val();
                                  time_ymd=$('#book_time_ymd').val();
                                 $ui_graybg ? getMSS = getM : getMSS = "0";
                                
                                 if(cartid && shop_id){
                                     top.location.href='/Order/confirm?address_id='+addressid+'&shop_id='+shopid+'&cart_ids='+cartid+'&deliver_type='+deliver_type+'&act_ticket='+act_ticket+'&goods_ticket='+goods_ticket+'&time_ymd='+time_ymd+'&is_book_goods=1&ticket_list_ids='+book_ticket_id+'&deliver_distance='+getMSS;
                                 }
                            }
                });
                
        }
});