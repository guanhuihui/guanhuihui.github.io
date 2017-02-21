var myScrol,myScrol9;
    myScrol=new IScroll('#list-productss', {probeType: 3,mouseWheel: true,scrollbars: false});
    var selectAddr = $('#selectAddr'),
        bthp = $('#Btns p'),
        addsec = $('#adds_selections'),
        onedivs = $('#adds-main-one'),
        twodivs = $('#adds-main3'),
        head_box = $('#adds_selections .head_box p'),
        pubcart = $('#adds_selections .pub-cart'),
        detldiv = $('.addselect_boxs'),
        detldivs = $('.addselect_boxs .addselect_con'),
        deldt = $('.addselect_input'),
        subBth = $('.price-details-sub'),
        distribution = GetQueryString('distribution'),
        $pubcart_box = $('#pub-cart-box'),
        four_null = $('.four_null');
    $(document).ready(function() {
        init();
        score('mod-carts','wrap_cartx');
        iscrollAll();
        returnBth();
        carts();
        function init(){
            $('.list-main>div').eq(0).show();   
            $('.pub-header>div').eq(0).show();
            $('#abtn,#adds-main3 .generic-item-img,#adds-main3 .generic-item_info').on(tapClick(),function(){
                var dataId = $(this).attr('data-id');
                top.location.href='/Category/index/shop_id/'+dataId+'';
            })
            $('#abotton').on('click',function(){
                top.location.href='/Address/add.html';
            })
            $('#nulls').on('click',function(){
                top.location.href='/index/index';
            })
            if(top.location!==self.location){ 
                $('#heds .asd').hide();
            } 
            if(distribution == 1){
                $('.buttons p').eq(1).addClass('box_set').siblings().removeClass('box_set');
                $('.hide_Divs').eq(1).show().siblings().hide();
                pubcart.hide();
            }else{
                $('.buttons p').eq(0).addClass('box_set').siblings().removeClass('box_set');
                $('.hide_Divs').eq(0).show().siblings().hide();
                pubcart.show();
            }
        }
        four_null.on(tapClick(),function(){
            if($('.pub-cart_menu li')){
                parent.window.$('.pub-cart_menu li').eq(0).click();
            }else{
                loaging.init('加载中...');
                top.location.href='/index/index';
            }
            
        })
         function returnBth(){
            $('.icon-back').on(tapClick(),function(){
                if($pubcart_box){
                    parent.window.$('#pub-cart-box').show();
                }
                $('input,textarea').blur();
                var parentName=$(this).parents('div').attr('class');
                if(parentName.indexOf('adds_selection')>-1){
                    var txt = $('.adds_selection .head_box .box_set').html();
                        if(txt == '送货上门'){
                            $('.buttons p').eq(0).addClass('box_set').siblings().removeClass('box_set');
                            $('.hide_Divs').eq(0).show().siblings().hide();
                            pubcart.show();
                            iscrollAll();
                        }else{
                            $('.buttons p').eq(1).addClass('box_set').siblings().removeClass('box_set');
                            $('.hide_Divs').eq(1).show().siblings().hide();
                            pubcart.hide();
                            iscrollAll();
                        } 
                    addsec.hide();
                    iscrollAll();
            }  
        })
        head_box.on(tapClick(),function(){
            var index=$(this).index();
            $(this).addClass('box_set').siblings().removeClass('box_set');
            $('.adds_selection .addrlist_main>div').eq(index).show().siblings().hide();
            pubcart.hide();
            if(index == 0){
                pubcart.show();
            }
            iscrollAll();
        });
        $('.list-main-four-html .head_box p').on(tapClick(),function(){
            var index=$(this).index();
            $(this).addClass('box_set').siblings().removeClass('box_set');
            iscrollAll();
        });
        }
        function iscrollAll(){
            myScrol2=new IScroll('#list-productss', {probeType: 3,mouseWheel: true,scrollbars: false});
            myScrol9 = new IScroll('#adds-main-one', { probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false })
        }
        function carts(){
            var Ids = $('#shop_deliverscope').val()
           if(Ids == 0){
                bthp.off(tapClick());
                bthp.eq(1).addClass('box_set').siblings().removeClass('box_set');
                $('.hide_Divs').eq(1).show().siblings().hide();
                bthp.eq(0).css('background','#999999');
            }else{
                bthp.on(tapClick(),function(){
                    var index=$(this).index();
                    $('.hide_Divs').eq(index).show().siblings().hide();
                    $(this).addClass('box_set').siblings().removeClass('box_set');
                    myScrol2.refresh();
                })
            }
            selectAddr.off(tapClick());
            selectAddr.on(tapClick(),function(){
              var txt =$('#Btns .box_set').text();
                if($('#shop_deliverscope').val() == 0){
                    loaging.prompts('本店仅支持到店自提');
                    return false;
                }
                if($pubcart_box){
                    parent.window.$('#pub-cart-box').hide();
                }
                addsec.show();
                if(txt == '送货上门'){
                  head_box.eq(0).addClass('box_set').siblings().removeClass('box_set');
                  onedivs.show().siblings().hide();
                  pubcart.show();
                }else{
                   head_box.eq(1).addClass('box_set').siblings().removeClass('box_set');
                   twodivs.show().siblings().hide();
                   pubcart.hide();
                } 
                iscrollAll();
            })
        var table = $('#tbodys'),
            tabname = $('.cart_name'),
            tabphone = $('.cart_phone'),
            tabdel = $('.cart_adds'),
            tabhideid = $('#addressid'),
            tablng = $('#tablng'),
            tablat = $('#tablat');
        detldivs.on(tapClick(),function(){
            var  detldivBox= $(this).parents('.addselect_boxs');
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
            iscrollAll();

        })

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
                               location.reload(); 
                            }else{
                                loaging.btn('删除失败，请重试');
                            }
                            },function(){
                                loaging.btn('删除失败');
                                location.reload();
                        },false);
                        },100)
                    }
                })
        })



        subBth.off(tapClick());
        subBth.on(tapClick(),function(){  
            var txt =$('#Btns .box_set').html(),
                dataIndex = $('#Btns .box_set').index();
                 var deliver_type=0,
                    addressid=0,
                    shopid=$('#shop_id').val(),
                    act_ticket,
                    goods_ticket;
                if(txt == '送货上门' && dataIndex == 0){
                    deliver_type=0;
                     if($('#userids').val()){
                        var data_lat=$('#tablat').val(),
                            data_lng=$('#tablng').val(),
                            shop_lat=$('#shop_lat').val(),
                            shop_delive=$('#shop_deliverscope').val(),
                            shop_lng=$('#shop_lng').val();
                            if(data_lat && data_lng && shop_lat && shop_lng){
                                addressid=$('#addressid').val();
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
                    $('#act_ticket').val()?act_ticket=$('#act_ticket').val():act_ticket=0;
                    $('#goods_ticket').val()?goods_ticket=$('#goods_ticket').val():goods_ticket=0;
                    cartid = $('#cart_ids').val();
                    if(cartid && shop_id){
                        top.location.href='/Order/confirm?address_id='+addressid+'&shop_id='+shopid+'&cart_ids='+cartid+'&deliver_type='+deliver_type+'&act_ticket='+act_ticket+'&goods_ticket='+goods_ticket;
                    }
            
        })


    }
});