loaging.init('加载中...');
$(function(){
    var myScrol0,myScrol1,iscroc={probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false,click:true},pullDownL,pullUpEl, pullUpL,Downcount = 0,Upcount = 0,loadingStep = 0,index=0,indexs = 0,infoH = $('.menulist-info').height(),k = $('.menulist-search').height(),
        lists={probeType: 2,scrollbars: false,mouseWheel: true,fadeScrollbars: true,bounce: true,interactiveScrollbars: true,shrinkScrollbars: 'scale',click: true,keyBindings: true,momentum: true};
        $('.list-mainBox').css({'top':infoH+k+50+'px'});
        myScrol0 = new IScroll('#mensBox-left', iscroc); 
        myScrol0.refresh();
        pullUpEl = $('#pullUp');
        pullUpL = pullUpEl.find('.pullUpLabel');
        pullUpEl['class'] = pullUpEl.attr('class');
        pullUpEl.attr('class', '').hide();
        myScrolls = new IScroll('#mensBox-right', lists),
        cartdiv = $('.pub-cart'),
        cartIcon = $('#shopping-count');
        var spanBox = $('.ls-item'),
            spans = $('.leftBox-uls span'),
            ols = $('.ols-box'),
            olis = ols.find('.ols-item'),
            amountInp = $('#amountInp'),
            spanli = $('.ls-item'),
            shopId = $('#shop_id').val(),
            Box_right = $('.mensBox-right'),
            hide_title = $('#hide-title'),
            mainBox_title = $('.mainBox-title'),
            cart_btn = $('#shopping-icons'),
            com_list = $('.mod-product-item'),
            price_cha = $('.price-cha'),
            collection = $('#collection');
            window.isArray = new Array();
        init();
        clicks();
        iscrollAll();
        add_del();
        function init(){
            spanBox.eq(0).find('span').addClass('span-select');
            spanBox.eq(0).find('ol').removeClass('hides');
            myScrol0.refresh();
            sessionStorage.setItem('keys',"0");
            sessionStorage.setItem('value',"0");
            sessionStorage.setItem('add',"");
            sessionStorage.setItem('del',"");
            sessionStorage.setItem('cart',"");
            Box_right.css({'background':'#fff'});
        }
        function iscrollAll(){
            myScrolls.on('scroll',Starts);
            myScrolls.on('scrollEnd', function () {
                if (loadingStep == 1) {
                    if (pullUpEl.attr('class').match('flip|loading')) {
                        pullUpEl.removeClass('flip').addClass('loading');
                        pullUpL.html('加载中,请稍后...');
                        loadingStep = 2;
                        gets = sessionStorage.getItem('keys');
                        if(sessionStorage.getItem('value')){
                            getvalue = sessionStorage.getItem('value');
                            if(gets){  
                                gets++;
                                index = (parseInt(gets));           
                                pullipAjax(getvalue,gets);
                            }else{
                                nullshow();
                            }
                        }
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
        }
        function nullshow(){
            $('.rightBox').html('');
           $('.rightBox').html($('.hide_box').html());
            sessionStorage.setItem('keys',"");
             loaging.close();
             pullUpEl.removeClass('loading');
             pullUpEl['class'] = pullUpEl.attr('class');
             pullUpEl.attr('class', '').hide();
             loadingStep = 1;  
             myScrolls.refresh();
             mainBox_title.html('<span>暂无商品</span>');
        }
        function clicks(){
            commoms.post_servers('/Category/get_shop_goods',{shop_id:shopId},function(data){
                if(data){
                    var html ="";
                    window.isArray = data; 
                    loaging.close();             
                }
            },function(){

            },false);
            spans.on(tapClick(),function(){
                spans.removeClass('span-select');
                ols.addClass('hides');
                $(this).siblings('.ols-box').removeClass('hides');
                $(this).addClass('span-select');
                var idx = $(this).parents('.ls-item').index();
                var lis = $(this).next('.ols-box').find('li');
                if(lis.length){
                    var res = window.isArray[idx];
                    loadView(res);
                    lis.first().addClass('ols-select');
                    sessionStorage.setItem('keys',"0");
                    index = 0;
                    sessionStorage.setItem('value',idx);
                }else{
                    nullshow();
                    sessionStorage.setItem('value',"");
                }

                myScrol0.refresh();
            })
            olis.on(tapClick(),function(){
                olis.removeClass('ols-select');
                $(this).addClass('ols-select');
                var idx = $(this).parents('.ls-item').index(),
                    lisIndex = $(this).index();
                if($(this)){
                    var res = window.isArray[idx];
                    loadView(res,lisIndex);
                    sessionStorage.setItem('keys',lisIndex);
                }else{
                    nullshow();
                }
                myScrol0.refresh();
            });
            if(layermbox0){}
        }
        function flays(divs,inx,imgs,Enddivs){
            loaging.close();
            var img = divs.eq(inx).find(imgs),
                flyElm = img.clone().css('opacity', 0.8);
                $('body').append(flyElm);
                flyElm.css({
                   'z-index': 9000,
                    'display': 'block',
                    'position': 'absolute',
                    'top': img.offset().top +'px',
                    'left': img.offset().left +'px',
                    'width': img.width() +'px',
                    'height': img.height() +'px'
                });
                flyElm.animate({
                    top:Enddivs.offset().top,
                    left:Enddivs.offset().left+40,
                    width:30,
                    height:30
                },500, function() {
                   flyElm.remove();
                });
        }
        function sessions(add,fun){
            loaging.init('加载中...');
            if(sessionStorage.getItem(add) == 1 && sessionStorage.getItem(add)){
                setTimeout(function(){
                    fun();
                },500);
            }else{
                ajaxetil(fun,'/user/login.html');
            }
        }
        function add_del(){
            var adds = $('.mod-product-item .add'),
                del = $('.mod-product-item .del');
                /*加*/
                adds.off(tapClick());
                adds.on(tapClick(),function(){
                    if($(this).hasClass('add_disabled')){
                        loaging.close();
                        loaging.prompts('商品缺货中，敬请期待');
                        return false;
                    }
                    var ins = $(this).parents('.mod-product-item').index(),
                        that = $(this),
                        parents = $(this).parents('.mod-product-item')
                        goods_id = parents.attr('data-goodid'),/*good_id*/
                        dels = that.siblings('.del'),
                        amountInp = that.siblings('.amountInp'),
                        amounsize = amountInp.text(),/*val*/
                        cartIconText = cartIcon.text(),/*价格*/
                        cur_price = parents.find('#price-yuan').text(),
                        zprice = $('.zprice');


                        sessions('add',add_fun);
                        function add_fun(){
                            sessionStorage.setItem('add',"1");
                            commoms.post_servers('/Cart/add',{shop_id:shopId,goods_id:goods_id},function(data){
                                if(data.result =="ok"){
                                    var zong = parseInt(zprice.text())+parseInt(cur_price);
                                    $('.mod-product-item').eq(ins).find('.amountInp').text(parseInt(amounsize)+1);/*中间的那个*/
                                    cartIcon.text(parseInt(cartIconText)+1);/*红色小点toFixed(2)*/

                                    zprice.text(zong.toFixed(2));/*总价*/
                                    /*邮费提醒显示*/
                                    if (zong.toFixed(2) >= 200) {
                                        price_cha.text('免运费');
                                    }else{
                                        var prices = 200 - parseInt(zong.toFixed(2));
                                        price_cha.text('还差'+prices+'元包邮');
                                    }
                                    flays($('.mod-product-item'),ins,$('.product-image img'),cartdiv);/*飞入购物车*/
                                    that.siblings().show();
                                    cartIcon.show();
                                 
                                }else{
                                    loaging.close();
                                    loaging.btn(data.msg);
                                }
                            },function(){
                                loaging.close();
                                loaging.bth('添加失败,请重新添加');
                            },false)
                           
                        }
                })


            
             /*减*/
            del.off(tapClick());
            del.on(tapClick(),function(){
                
                var ins = $(this).parents('.mod-product-item').index(),
                    that = $(this),
                    parents = $(this).parents('.mod-product-item')
                    goods_id = parents.attr('data-goodid'),/*good_id*/
                    amountInp = that.siblings('.amountInp'),
                    amounsize = amountInp.text(),/*val*/
                    cartIconText = cartIcon.text(),/*价格*/
                    cur_price = parents.find('#price-yuan').text(),
                    zprice = $('.zprice');

                    sessions('del',del_fun);
                    

                    function del_fun(){
                        
                        sessionStorage.setItem('del',"1");
                             commoms.post_server('/Cart/add',{shop_id:shopId,goods_id:goods_id,count:"-1"},function(data){
                                if(data.result =="ok"){
                                    var zong = parseInt(zprice.text())-parseInt(cur_price);
                                    $('.mod-product-item').eq(ins).find('.amountInp').text(parseInt(amounsize)-1);/*中间的那个*/
                                    cartIcon.text(parseInt(cartIconText)-1);/*红色小点toFixed(2)*/

                                    zprice.text(zong.toFixed(2));/*总价*/

                                    that.siblings().show();
                                    cartIcon.show();

                                    /*邮费提醒显示*/
                                    if (zong.toFixed(2) >= 200) {
                                        price_cha.text('免运费');
                                    }else{
                                        var prices = 200 - parseInt(zong.toFixed(2));
                                        price_cha.text('还差'+prices+'元包邮');
                                    }

                                    if((parseInt(amounsize)-1) <= 0 ){
                                        loaging.close();
                                        amountInp.text(0);
                                        that.siblings('.amountInp').hide();
                                        that.hide();
                                        return false;
                                    }

                                    
                                 
                                }else{
                                    loaging.close();
                                    loaging.btn(data.msg);
                                }
                            },function(){
                                loaging.close();
                                loaging.bth('删除失败,请重新添加');
                            },false)
                           
                        }

            })


            cart_btn.off(tapClick());
            cart_btn.on(tapClick(),function(){
                sessions('cart',cart_fun);
                function cart_fun(){
                    loaging.close();
                    sessionStorage.setItem('cart',"1");
                }
            })



        }
        /*收藏*/
        collection.on(tapClick(),function(){
            loaging.init('加载中...')
            ajaxetil(favorite,'/user/login.html');
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
           
        })
        function loadView(data,lisIndex){  
            if(data){
                var html="",liindex = 0,res ="";
                lisIndex ? liindex = lisIndex : lisIndex=0;
                if(data.list[lisIndex]){
                    res = data.list[lisIndex];
                    getJsonInfos(data.list[lisIndex]);  
                    myScrolls.refresh();
                    myScrolls.scrollTo(0,0,0); 
                    myScrolls.refresh();
                    pullUpEl.removeClass('loading');
                    pullUpL.html('上拉显示更多...');
                    pullUpEl['class'] = pullUpEl.attr('class');
                    pullUpEl.attr('class', '').hide();
                    loadingStep = 0;  
                    add_del();                 
                }
            }else{

            }
        }
       function getJsonInfos(datas){
           if(datas){
               var html="",goods_pungent ="",goods_type = "",goods_puns="",act_name="",goods_stockout="",goods_price;
               for(var k = 0;k < datas.goods_list.length;k++){
                   if(datas.goods_list[k]){
                       var data = datas.goods_list[k];
                        //console.log(data);
                           data.goods_pungent ? goods_pungent = '('+data.goods_pungent+')' : goods_pungent="",urlImgId = "",goods_count=0,nones = "";
                           data.goods_type ?goods_type = '<span class="pm-img"><img src="/Public/image/spjb.png" alt=""></span>': goods_type ="";
                           if(data.goods_pungent == "正辣"){
                               goods_puns='<span class="pm-eimg"><img src="/Public/image/pic2_icon.png" alt=""></span>'
                           }else if(data.goods_pungent == "微辣"){
                               goods_puns='<span class="pm-eimg"><img src="/Public/image/pic1_icon.png" alt=""></span>'
                           }else{
                               goods_puns="";
                           }
                           data.act_name ? act_name = '<span class="pm-intaglio">'+data.act_name+'</span>' : act_name="";
                           data.goods_price ? goods_price = '<span class="product-price-market theme-grayfont"><span class="price-yuan">¥</span>'+data.goods_original_price+'</span>' :goods_price = "";
                           if(data.goods_stockout == 1){
                               goods_stockout='<span class="grens">补货中</span>';
                               urlImgId = 'add_disabled';
                           }else{
                               goods_stockout = "";
                               urlImgId = "";
                           }
                           if(data.cart_goods_count){
                               goods_count = data.cart_goods_count;
                               nones = "";
                           }else{
                               goods_count=0;
                               nones = "hides";
                           }
                       html+='<li class="mod-product-item  mod-product-item-portrait cf product-item-had-embossed  theme-spline" data-goodId="'+data.goods_id+'">'
                               +'<div class="product-image">'
                                   +'<div class="product-image-img">'
                                       +'<img src="'+data.goods_pic+'" onerror="this.src=\'/Public/image/moren.png\'" >'
                                  +'</div>'
                               +'</div>'
                               +'<div class="product-meta-wrap">'
                                   +'<div class="product-Box">'
                                       +'<div class="product-name ui-ellipsis">'+data.goods_name+''+goods_pungent+'</div>'
                                       +'<div class="product-promotion">'
                                           +goods_type+goods_puns+act_name+goods_stockout
                                       +'</div>'
                                   +'</div>'
                                   +'<div class="product-price-wrap">'
                                       +'<span class="product-price-current">¥<span id="price-yuan" class="price-yuan">'+data.goods_price+'</span></span>'
                                       +goods_price
                                   +'</div>'
                                   +'<div class="product-operates product-operates-111629">'
                                       +'<span class="product-operates-item del tap-action '+nones+'">'
                                           +'<span class="inner theme-spline"></span>'
                                       +'</span>'
                                       +'<span class="product-operates-item amount amountInp '+nones+'">'+goods_count+'</span>'
                                       +'<span class="product-operates-item add tap-action '+urlImgId+'">'
                                           +'<span class="inner theme-spline"></span>'
                                       +'</span>'
                                   +'</div>'
                               +'</div>'
                           +'</li>' 
                   }
               }
               $('.rightBox').html(html);
               mainBox_title.html('<span>'+datas.cat_name+'<b>('+datas.goods_list.length+')</b></span>');
           }
       }
        function pullipAjax (getval,data) { 
            if(getval <= window.isArray.length){
                /*console.log(window.isArray[getval].list.length);*/
                if(data < window.isArray[getval].list.length){
                    //spanli.eq(getval).find('li').eq(data).on(tapClick());
                    loadView(window.isArray[getval],data);
                    olis.removeClass('ols-select');
                    spanli.eq(getval).find('li').eq(data).addClass('ols-select');
                    sessionStorage.setItem('keys',data)
                }else{
                  pullUpEl.removeClass('loading');
                  pullUpEl['class'] = pullUpEl.attr('class');
                  pullUpEl.attr('class', '').hide();
                  loadingStep = 2;  
                  myScrolls.refresh();  
                }
            }
        }
        
})