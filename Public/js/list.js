var Data_id=GetQueryString("data_id");var myScrol0,myScrol1,myScrol2,iscroc={probeType:3,mouseWheel:true,preventDefault:false,scrollbars:false,click:true},pullDownL,pullUpEl,pullUpL,Downcount=0,Upcount=0,loadingStep=0,index=0,indexs=0,infoH=$(".menulist-info").height(),k=$(".menulist-search").height(),lists={probeType:2,scrollbars:false,mouseWheel:true,fadeScrollbars:true,bounce:true,interactiveScrollbars:true,shrinkScrollbars:"scale",click:true,keyBindings:true,momentum:true},cartIcon=$("#shopping-count"),spanBox=$(".ls-item"),spans=$(".leftBox-uls span"),ols=$(".ols-box"),olis=ols.find(".ols-item"),amountInp=$("#amountInp"),spanli=$(".ls-item"),shopId=$("#shop_id").val(),Box_right=$(".mensBox-right"),hide_title=$("#hide-title"),mainBox_title=$(".mainBox-title"),cart_btn=$("#shopping-icons"),com_list=$(".mod-product-item"),price_cha=$(".price-cha"),collection=$("#collection"),inputs=$("input"),distriDiv=$("#distribution"),keyscart=$("#category_key"),detailsInfor=$("#detailsInfo-r"),topBox=$("#top-box"),shBtn=$(".shBtn"),hideDiv=$("#mod_coupnss");var closeBtn=$(".notice-close"),listmainBox=$("#list-mainBox"),hide_boxs=$(".bigbox"),hide_box0=$(".bigbox0"),hide_box1=$(".bigbox1"),Big_mainBox=$("#list-mainBox"),l_boxScroll=$("#mensBox-left .scroller"),r_boxScroll=$(".rightBox"),showAndhide=$("#showAndhide"),share=$('#mod-share'),a2=$('.a2'),shop_name=$('#shop_name'),shop_avatar=$('#shop_avatar');pullUpEl=$("#pullUp");pullUpL=pullUpEl.find(".pullUpLabel");pullUpEl["class"]=pullUpEl.attr("class");pullUpEl.attr("class","").hide();pullDownEl=$("#pullDown");pullDownL=pullDownEl.find(".pullDownLabel");pullDownEl["class"]=pullDownEl.attr("class");pullDownEl.attr("class","").hide();myScrol0=new IScroll("#mensBox-left",lists);myScrol2=new IScroll("#menulist-sec",lists);myScrol1=new IScroll("#mensBox-right",lists);
    window.isArray0_yes = new Array();window.isArray1_no = new Array();

$(function(){
    var flg = false,
    ins ={
        init:function(){
            /*初始化数据*/sessionStorage.clear();sessionStorage.setItem('newIndex','');sessionStorage.setItem('newKeys','');sessionStorage.setItem('newValue','');/*购物车加减*/sessionStorage.setItem('add',"");sessionStorage.setItem('del',"");sessionStorage.setItem('cart',"");
            var name=shop_name.val(),imgurl=shop_avatar.val();
            var url=window.location.href;
            weixins(url,"index2",name,imgurl,shopId);
            loaging.init('加载中...');
            $('.section').css({'background-color':'rgba(0,0,0,.4)'});
            this.autoScroll('.apple');
            this.clicks();
            score('menulist-sec','wrap_x');
            this.getAjaxs();
            this.iscrollAll();
        },autoScroll:function(obj){
            var that = this,timer;
            clearInterval(timer);
            timer = setInterval(function(){
                $(obj).find("ul").animate({  
                  marginTop : "-25px"  
                },500,function(){  
                  $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);  
                }) 
            },3500);        
        },getT:function(){
            loaging.close();
            if($('#shop_open_status').val() == 2 || $('#shop_delivertime_status').val() == 2){
                loaging.btn('店铺不在营业时间内');
            }
        },clicks:function(){
            a2.on('tap',function(){
                share.show();
            });
            share.on('click',function(){
                $(this).hide();
            });
            shBtn.on(tapClick(),function(){
                if(hideDiv.hasClass('hide')){
                    hideDiv.removeClass('hide');
                }else{
                    hideDiv.addClass('hide');
                }
                myScrol2.refresh();
            });
            /*收藏*/
            collection.on(tapClick(),function(){
                inputs.blur();
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
            });
            detailsInfor.on('click',function(){
                var fg = $(this).find('img').toggleClass('trans');
                if(flg == false){
                    topBox.css({
                        '-webkit-transform':'translateY(100%)',
                        'transform':'translateY(100%)'
                    }); 
                    flg =true;
                }else if(flg == true){
                    topBox.css({
                        '-webkit-transform':'translateY(0%)',
                        'transform':'translateY(0%)'
                    });
                    flg = false;
                    myScrol2.scrollTo(0,0);
                }
                myScrol2.refresh();

            });
        },getAjaxs:function(){
            var that = this,
                MLis = $('.mens_lis'),
                Data_ids = (Data_id * 1),
                dataNum = 0,
                dataNum1=null,dataNum2=null;
                Data_ids?dataNum=Data_ids:dataNum = 0;
                if(Data_id){
                    var splits = Data_id.split('|');
                    dataNum1=splits[0];dataNum2=splits[1];
                }
            commoms.post_servers('/Category/get_shop_goods',{shop_id:shopId},function(data){

                listmainBox.show();
                MLis.find('span').removeClass('menLi_spans');
                var newobj_0 = [],newobj_1 = [],hs = "";
                if(data && data.length){

                    var datas1 = $('#get_cat_id').val();
                    var datas2 = $('#get_son_cat_id').val();
                    var num = 0,num2 = 0,setNum=0,setNum1 = 0,arr0=[],arr1=[];
                    $.each(data,function(index, el) {
                        //0是普通商品    isArray1_no    
                        //1是预约商品    isArray0_yes
                    
                        if(el.is_book == 0){
                            newobj_0.push(el);
                            showAndhide.val(0);  //0是普通商品
                            arr0.push(el.cat_id);

                        }else if(el.is_book == 1){
                            newobj_1.push(el);
                            showAndhide.val(1);  //1是预约商品
                            arr1.push(el.cat_id);
                        }
                        if(el.cat_id == datas1){
                            setNum = el.is_book*1;
                            setNum1 = el.is_book*1+1;
                        }
                    });



                

                    window.isArray1_no = newobj_0; //0是普通商品
                    window.isArray0_yes = newobj_1; //1是预约商品

                    console.log(arr0);
                    console.log(arr1);

                    // console.log(window.isArray1_no)
                    // console.log(window.isArray0_yes)

                    // if(setNum == null){
                    //     window.isArray0_yes.length ? setNum = 1 :setNum =0;
                    // }
                    var getNums = function(arr){
                        var getNumsArr = [0,0];
                        $.each(arr,function(index, el) {
                            if(el.cat_id == datas1){
                                getNumsArr[0] = index;
                                for(var k = 0;k<el.list.length;k++){
                                    if(datas2 > 0){
                                        if(el.list[k].son_cat_id == datas2){
                                            getNumsArr[1] = k;
                                        }
                                    }
                                }
                            }
                        });
                        return getNumsArr;
                    }
                    if(setNum1 >0){
                        if(setNum == 0){
                            var getArrs = getNums(newobj_0);
                            num = getArrs[0];
                            num2 = getArrs[1];
                        }else if(setNum == 1){
                            var getArrs = getNums(newobj_1);
                            num = getArrs[0];
                            num2 = getArrs[1];
                        }
                    }else{
                        if(newobj_1.length>0){
                            setNum = 1;
                        }else{
                            setNum = 0;
                        }
                    }
                    
                     console.log(setNum+'---------'+num+'---------'+num2);
                     if(setNum == 0){
                        MLis.eq(0).find('span').addClass('menLi_spans');
                        Big_mainBox.removeClass('mn');
                        that.one_loadView(window.isArray1_no[num],0,num,num2);
                    }else if(setNum == 1){
                        MLis.eq(1).find('span').addClass('menLi_spans');
                        Big_mainBox.addClass('mn');
                        that.two_loadView(window.isArray0_yes[num],1,num,num2);
                    } 
                    
                   // if(isArray0_yes.length){
                   //      MLis.eq(1).find('span').addClass('menLi_spans');
                   //      Big_mainBox.addClass('mn');
                   //      that.two_loadView(window.isArray0_yes[dataNum],1,dataNum);
                   //  }else{
                   //      MLis.eq(0).find('span').addClass('menLi_spans');
                   //      Big_mainBox.removeClass('mn');
                   //      that.one_loadView(window.isArray1_no[dataNum],0,dataNum);
                   //  }
                    // if(Data_id){
                    //     if(dataNum1 == 0){
                    //         MLis.eq(0).find('span').addClass('menLi_spans');
                    //         Big_mainBox.removeClass('mn');
                    //         if(dataNum2!=null){
                    //             that.one_loadView(window.isArray1_no[dataNum2],0,dataNum2);
                    //         }else{
                    //             that.one_loadView(window.isArray1_no[0],0,0);
                    //         }
                    //     }else if(dataNum1 == 1){
                    //         MLis.eq(1).find('span').addClass('menLi_spans');
                    //         Big_mainBox.addClass('mn');
                    //         if(dataNum2!=null){
                    //             that.two_loadView(window.isArray0_yes[dataNum2],1,dataNum2);
                    //         }else{
                    //             that.one_loadView(window.isArray0_yes[0],0,0);
                    //         }
                            
                    //     }
                    // }else{
                    //     if(isArray0_yes.length){
                    //         MLis.eq(1).find('span').addClass('menLi_spans');
                    //         Big_mainBox.addClass('mn');
                    //         that.two_loadView(window.isArray0_yes[0],1,0);
                    //     }else{
                    //         MLis.eq(0).find('span').addClass('menLi_spans');
                    //         Big_mainBox.removeClass('mn');
                    //         that.one_loadView(window.isArray1_no[0],0,0);
                    //     }  
                    // }

                }else{
                  
                }

                that.getT();
                
            },function(){
                loaging.close();
                that.getT();
            },false);
        },one_loadView:function(data,nums,DataId,num2){    
            var that = this;
            var ids = DataId * 1,
                ids2 =num2*1;
            sessionStorage.setItem('newIndex',0);
            sessionStorage.setItem('newKeys',ids);
            sessionStorage.setItem('newValue',ids2);
            that.l_getJsonInfos(0,DataId,ids2);
            that.loadView(data,ids2,0,0);
            that.tabs(0,DataId,ids2);

        },two_loadView:function(data,nums,DataId,num2){
            var that = this;
            var ids = DataId * 1,
                ids2 =num2*1;
            sessionStorage.setItem('newIndex',1);
            sessionStorage.setItem('newKeys',ids);
            sessionStorage.setItem('newValue',ids2);
            that.l_getJsonInfos(1,DataId,ids2);
            that.loadView(data,ids2,1,0);
            that.tabs(1,DataId,ids2);
        },l_getJsonInfos:function(datas,DataId,num2){
            var lis = "",dataHtml="",uls="",Is = "",inx = 0,that = this;
                uls = $('<ul class="leftBox-uls">');
                datas==0?dataHtml = window.isArray1_no:dataHtml = window.isArray0_yes;
                if(DataId){inx = DataId * 1;}
                $.each(dataHtml,function(index, el) {
                        //'+(index == inx ? '':'hides')+'    (datas == 0 ?'hides':'')
                        lis+='<li class="ls-item '+(index == 0 ? 'ls-item2':'')+'"><span class="span-label '+(index == inx ? 'span-select':'')+'">'+el.cat_name+'</span><ol class="ols-box '+(index == inx ? '':'hides')+'">'
                            for(var k = 0;k < el.list.length;k++){
                                lis+='<li class="ols-item '+(k == num2 ? 'ols-select':'')+'" cat-id="'+el.cat_id+'" son-cat-id="'+el.list[k].son_cat_id+'"><s>'+el.list[k].cat_name+'</s></li>'
                            }
                        lis+='</ol></li>';
                });
                uls.html(lis);
                l_boxScroll.html('');
                l_boxScroll.html(uls);
                datas == 0 ? that.Clis(dataHtml):that.Clis2(dataHtml); 
                myScrol0.refresh();  
        },loadView:function(data,lisIndex,ins,DataId){
            var that = this;
                if(data){
                    var html="",liindex = 0,res ="",inst="";
                    lisIndex ? liindex = lisIndex : lisIndex = 0;

                    ins == 0 ? inst = 0 : inst = 1;
                    if(data.list[lisIndex] && data.list.length > 0){
                        res = data.list[lisIndex];
                        that.getJsonInfos(data.list[lisIndex],inst,(DataId ? DataId :0));

                        myScrol1.scrollTo(0,0,0);

                        myScrol0.refresh();
                        myScrol1.refresh();

                        pullUpEl.removeClass('loading');
                        pullUpL.html('上拉显示更多...');
                        pullUpEl['class'] = pullUpEl.attr('class');
                        pullUpEl.attr('class', '').hide();
                        loadingStep = 0;  
                        add_del(ins);   
                    }else{
                        loaging.close();
                        that.nullshow();
                    }
                }else{

                }
        },getJsonInfos:function(datas,nums,DataId){
            var that = this;
            console.log(datas);
            var dat = "",ptsHtml = "",ptsClass="",Imgbg = "";
            if(datas){
                var shop_ids = $('#shop_id').val();
                var html="",goods_pungent ="",goods_type = "",goods_puns="",act_name="",goods_stockout="",goods_price,imgsd="",numsUrl1="",numsUrl2="";
                if(datas.goods_list){
                    for(var k = 0;k < datas.goods_list.length;k++){
                        if(datas.goods_list[k]){
                            var data = datas.goods_list[k];
                                data.goods_pungent ? goods_pungent = '('+data.goods_pungent+')' : goods_pungent="",urlImgId = "",goods_count=0,nones = "",is_books="";
                                data.goods_type ?goods_type = '<span class="pm-img"><img src="/Public/image/spjb.png" alt=""></span>': goods_type ="";
                                if(data.goods_pungent == "正辣"){
                                    goods_puns='<span class="pm-eimg"><img src="/Public/image/pic2_icon.png" alt=""></span>'
                                }else if(data.goods_pungent == "微辣"){
                                    goods_puns='<span class="pm-eimg"><img src="/Public/image/pic1_icon.png" alt=""></span>'
                                }else{
                                    goods_puns="";
                                }
                                if(data.act_name){
                                    act_name="";
                                    if(data.goods_stockout != 1){
                                        act_name = '<span class="pm-intaglio">'+data.act_name+'</span>'
                                    }
                                }
                                //data.act_name ? act_name = '<span class="pm-intaglio">'+data.act_name+'</span>' : act_name="";
                                data.goods_price ? goods_price = '<span class="product-price-market theme-grayfont"><span class="price-yuan">¥</span>'+data.goods_original_price+'</span>' :goods_price = "";
                                if(data.goods_stockout == 1){
                                    goods_stockout='<span class="grens">无现货，请到次日达预订</span>';
                                    urlImgId = 'add_disabled';
                                    imgsd = "addhui_icon";
                                }else{
                                    goods_stockout = "";
                                    urlImgId = "";
                                    imgsd="add_icon";
                                }
                                    numsUrl1 = 'del_icon';
                                    if(data.goods_stockout == 1){
                                        numsUrl2 = 'addhui_icon';
                                    }else{
                                        numsUrl2 = 'add_icon';
                                    }

                                if(data.cart_goods_count){
                                    goods_count = data.cart_goods_count;
                                    nones = "";
                                }else{
                                    goods_count=0;
                                    nones = "hides";
                                }
                                if(data.goods_book_tip){
                                     // is_books = '<span class="pm-img"><img src="/Public/image/yus.png" alt=""></span>'
                                     is_books = '<span class="pm-img-text">次日达</span>'
                                }
                                var ky =data.large_key * 1;
                            html+='<li class="mod-product-item  mod-product-item-portrait cf product-item-had-embossed  theme-spline" data-goodId="'+data.goods_id+'" data-key='+ky+'|'+data.in_key+'|'+data.small_key+' data-biao-refresh="'+data.biao_refresh+'" data-is-refresh="'+data.is_refresh+'">'
                                    +'<div class="product-image">'
                                        +'<div class="product-image-img">'
                                             +'<a href="/app/detail?shop_id='+shop_ids+'&goods_id='+data.goods_id+'" class="blocks">'
                                                 +'<img src="'+data.goods_pic+'" onerror="this.src=\'/Public/image/moren.png\'" >'
                                             +'</a>'
                                       +'</div>'
                                    +'</div>'
                                    +'<div class="product-meta-wrap">'
                                        +'<div class="product-Box">'
                                             +'<a href="/app/detail?shop_id='+shop_ids+'&goods_id='+data.goods_id+'" class="blocks">'
                                                +'<div class="product-name ui-ellipsis">'+is_books+data.goods_name+''+goods_pungent+'</div>'
                                                +'<div class="product-promotion">'
                                                    +goods_type+goods_puns+act_name+goods_stockout
                                                +'</div>'
                                             +'</a>'
                                        +'</div>'
                                        +'<div class="product-price-wrap">'
                                             +'<a href="/app/detail?shop_id='+shop_ids+'&goods_id='+data.goods_id+'" class="blocks">'
                                                 +'<span class="product-price-current">¥<span id="price-yuan" class="price-yuan">'+data.goods_price+'</span></span>'
                                                 +goods_price
                                             +'</a>'
                                        +'</div>'
                                        +'<div class="product-operates product-operates-111629">'
                                            +'<span class="product-operates-item del tap-action '+nones+'">'
                                                +'<span class="inner theme-spline"><img src="/Public/image/'+numsUrl1+'.png" alt=""></span>'
                                            +'</span>'
                                            +'<span class="product-operates-item amount amountInp '+nones+'">'+goods_count+'</span>'
                                            +'<span class="product-operates-item add tap-action '+urlImgId+'">'
                                                +'<span class="inner theme-spline"><img src="/Public/image/'+numsUrl2+'.png" alt=""></span>'
                                            +'</span>'
                                        +'</div>'
                                    +'</div>'
                                +'</li>' 
                        }
                    }  
                    r_boxScroll.html('');
                    r_boxScroll.html(html);
                    datas.cat_txt ? ptsHtml = datas.cat_txt : ptsHtml="";
   
                    datas.cat_image ? Imgbg = datas.cat_image: Imgbg ="";
                }else{
                    loaging.close();
                    that.nullshow();
                }
                mainBox_title.show();
                mainBox_title.html('<p class="ui-ellipsis"><span">'+datas.cat_name+'<b>（'+(datas.goods_list ? datas.goods_list.length : '0')+'）</b></span><s>'+ptsHtml+'</s></p>');
            }else{
                that.nullshow();
            }
        },iscrollAll:function(){
            var that = this;
            myScrol2.on('scroll',Starts2);
            function Starts2(){
                // console.log(this.y+'****************'+(this.maxScrollY-5));
                if (this.y <= (this.maxScrollY-55)) {
                        topBox.css({
                            '-webkit-transform':'translateY(0%)',
                            'transform':'translateY(0%)'
                        });
                        flg = false;
                        detailsInfor.find('img').removeClass('trans');
                    }
                   myScrol2 = new IScroll('#menulist-sec',lists);

            }
           /* myScrol0.on('scroll',Starts0);
            function Starts0(){
                console.log(this.y);
                console.log(this.maxScrollY);
                if(this.y >= 0){
                        topBox.css('top','140px');

                }else if(this.y <-20){
                    topBox.css('top','50px');
                }
                   myScrol0.refresh();

            }*/
            myScrol1.on('scroll',Starts);
            myScrol1.on('scrollEnd', function () {
                if (loadingStep == 1) {
                    if (pullUpEl.attr('class').match('flip|loading')) {
                        pullUpEl.removeClass('flip').addClass('loading');
                        pullUpL.html('全力加载中...');
                        loadingStep = 2;
                
                        if(sessionStorage.getItem('newValue')){
                            var NumIndex = sessionStorage.getItem('newIndex') * 1,
                                NumValue = sessionStorage.getItem('newValue') * 1,
                                Numkeys = sessionStorage.getItem('newKeys') * 1;

                            if(NumValue != null || NumValue != "" ){  
                                NumValue++;
                                
                                that.pullipAjax(NumIndex,Numkeys,NumValue);
                            }else{
                                that.nullshow();
                            }
                        }
                    }else if (pullDownEl.attr('class').match('flip|loading')) {
                        setTimeout(function () {
                            
                            pullDownEl.removeClass('loading');
                            pullDownL.html('下拉显示更多...');
                            pullDownEl['class'] = pullDownEl.attr('class');
                            pullDownEl.attr('class', '').hide();
                            myScrol1.refresh();
                            loadingStep = 0;
                            topBox.css({
                                '-webkit-transform':'translateY(100%)',
                                'transform':'translateY(100%)'
                            }); 
                            flg = true;
                            detailsInfor.find('img').toggleClass('trans');
                            myScrol2.refresh();
                            myScrol2.scrollTo(0,0);
                        },100);
                    }
                }
            });
            $('.shopd-bottom').on('tap',function(){
                    detailsInfor.find('img').removeClass('trans');
                    topBox.css({
                        '-webkit-transform':'translateY(0%)',
                        'transform':'translateY(0%)'
                    });
                    flg = false;
                    myScrol2.scrollTo(0,0);
                    myScrol2.refresh();
            })
            function Starts() {
                if (loadingStep == 0 && !pullUpEl.attr('class').match('flip|loading')) {
                    if(this.y > 50){
                        pullDownEl.attr('class', pullUpEl['class'])
                        pullDownEl.show();
                        pullDownEl.addClass('flip');
                        pullDownL.html('下拉中，请稍后...');
                        loadingStep = 1;
                    }
                    if(this.y > 0){

                        topBox.css('top','140px');

                    }else if (this.y < (this.maxScrollY - 5)) {

                        pullUpEl.attr('class', pullUpEl['class'])
                        pullUpEl.show();
                        pullUpEl.addClass('flip');
                        pullUpL.html('全力加载中...');
                        loadingStep = 1;

                    }else if(this.y <-20){
                        topBox.css('top','50px');
                    }
                }
            }
        },pullipAjax:function(getIndex,getkeys,getValue) {
            var that = this;
            var ols = $('.ols-box'),
                olis = ols.find('.ols-item'),
                spanli = $('.ls-item');    
                var numsData = "";
                if(getIndex == 0){
                    numsData = window.isArray1_no;
                }else{
                    numsData = window.isArray0_yes;
                }
            if(getkeys <= numsData.length){               
                if(getValue < numsData[getkeys].list.length ){         
                    that.loadView(numsData[getkeys],getValue,getIndex);

                    olis.removeClass('ols-select');

                    spanli.eq(getkeys).find('li').eq(getValue).addClass('ols-select');
                    
                    sessionStorage.setItem('newValue',getValue);
            
                }else{

                    pullUpEl.removeClass('loading');
                    pullUpEl['class'] = pullUpEl.attr('class');
                    pullUpEl.attr('class', '').hide();
                    loadingStep = 2;  
                    myScrol0.refresh();
                    myScrol1.refresh();  
                    myScrol2.refresh(); 

                }
            }
        },nullshow:function(){
            r_boxScroll.html('');
            r_boxScroll.html($('.hide_box').html());
            // sessionStorage.setItem('keys',"");
            sessionStorage.setItem('newValue','');
            // loaging.close();
            pullUpEl.removeClass('loading');
            pullUpEl['class'] = pullUpEl.attr('class');
            pullUpEl.attr('class', '').hide();

            loadingStep = 1;  
            myScrol1.refresh();
            myScrol0.refresh();
            mainBox_title.html('<span>暂无商品</span>');
        },tabs:function(nums,DataId,ids2){
            var that = this;
           var toptabLi = $('.mens_lis');//顶层的lis切换
           var insIndex = 0;
            //顶层点击切换
            toptabLi.off('click');
            toptabLi.on('click',function(e){
                e.preventDefault();
                var LisInx = $(this).data('index');
                   
        
                   loaging.close();
                   loaging.init('加载中...');

                    var insIndex = $(this).index() * 1;//index
                    toptabLi.find('span').removeClass('menLi_spans');
                    $(this).find('span').addClass('menLi_spans');
                    Big_mainBox.removeClass('mn');
                    hide_boxs.hide();
                                       
                    
                    switch(LisInx)
                    {
                    case 0:
                        //加载右数据
                      
                        that.loadView(window.isArray1_no[0],null,0);
                        //加载左数据
                        that.l_getJsonInfos(0,0,0);


                        Big_mainBox.removeClass('mn2');
                        Big_mainBox.removeClass('mn');
                        //顶层显示
                        mainBox_title.show();
                        //页面显示
                        hide_box0.show();


                        myScrol0.refresh();
                        myScrol1.refresh();

                        sessionStorage.setItem('newIndex',0);
                        break;
                    case 1:
                        //加载右数据
                   
                        that.loadView(window.isArray0_yes[0],null,1);
                        //加载左数据
                        that.l_getJsonInfos(1,0,0);


                        Big_mainBox.removeClass('mn2');
                        Big_mainBox.addClass('mn');
                        //顶层显示
                        mainBox_title.show();
                        //页面显示
                        hide_box0.show();


                        myScrol0.refresh();
                        myScrol1.refresh();

                        sessionStorage.setItem('newIndex',1);
                        break;
                    case 2:
                        mainBox_title.hide();
                        hide_box1.show();
                        myScrol2.refresh();

                        sessionStorage.setItem('newIndex',null);  
                        Big_mainBox.removeClass('mn');
                        Big_mainBox.addClass('mn2');
                        break;
                    }

                    setTimeout(function(){
                        loaging.close();
                    },1000);
                    sessionStorage.setItem('newKeys',0);
                    sessionStorage.setItem('newValue',0);
                    
            });
        },Clis:function(re){
            var spanBox = $('.ls-item'),
                spans = $('.leftBox-uls .span-label'),
                ols = $('.ols-box'),
                olis = ols.find('.ols-item');
                //span点击
                spans.on(tapClick(),function(){
                    inputs.blur();
                    spans.removeClass('span-select');
                    ols.addClass('hides');
                    $(this).siblings('.ols-box').removeClass('hides');
                    $(this).addClass('span-select');
                    var idx = $(this).parents('.ls-item').index();
                    var lis = $(this).next('.ols-box').find('li');


                    if(lis.length){
                        var res = re[idx];
                        ins.loadView(res,null,0)

                        if($(this).hasClass('span-select')){
                            lis.removeClass('ols-select'); 
                        }

                        lis.first().addClass('ols-select');

                        sessionStorage.setItem('newIndex',0);
                        sessionStorage.setItem('newKeys',idx);
                        sessionStorage.setItem('newValue',0);
                        
                    }else{
                        ins.nullshow();
                    }
                    myScrol0.refresh();
                });

                //li点击
                olis.on(tapClick(),function(){
                    inputs.blur();
                    olis.removeClass('ols-select');
                    $(this).addClass('ols-select');
                    var idx = $(this).parents('.ls-item').index(),
                        lisIndex = $(this).index();
                        if($(this)){

                            var res = re[idx];
                            ins.loadView(res,lisIndex,0);

                            sessionStorage.setItem('newKeys',idx);
                            sessionStorage.setItem('newValue',lisIndex);
                            sessionStorage.setItem('newIndex',0);

                        }else{
                            ins.nullshow();
                        }
                        myScrol0.refresh();
                    });
        },Clis2:function(re){
            var  spanBox = $('.ls-item'),
                spans = $('.leftBox-uls .span-label'),
                ols = $('.ols-box'),
                olis = ols.find('.ols-item');

                //span点击
                spans.on(tapClick(),function(){
                    inputs.blur();

                    spans.removeClass('span-select');
                    ols.addClass('hides');
                    $(this).siblings('.ols-box').removeClass('hides');
                    $(this).addClass('span-select');
                    var idx = $(this).parents('.ls-item').index();
                    var lis = $(this).next('.ols-box').find('li');
                    if(lis.length){
                        var res = re[idx];
                        ins.loadView(res,null,1);

                        if($(this).hasClass('span-select')){
                            lis.removeClass('ols-select'); 
                        }
                        lis.first().addClass('ols-select');

                        sessionStorage.setItem('newIndex',1);
                        sessionStorage.setItem('newKeys',idx);
                        sessionStorage.setItem('newValue',0);
                              

                    }else{
                        ins.nullshow();
                    }

                    myScrol0.refresh();

                });

                //li点击
                olis.on(tapClick(),function(){
                    inputs.blur();
                    olis.removeClass('ols-select');
                    $(this).addClass('ols-select');

                    var idx = $(this).parents('.ls-item').index(),
                        lisIndex = $(this).index();

                        if($(this)){
                            var res = re[idx];
                            ins.loadView(res,lisIndex,1);

                            sessionStorage.setItem('newIndex',1);
                            sessionStorage.setItem('newKeys',idx);
                            sessionStorage.setItem('newValue',lisIndex);
                            

                        }else{
                            ins.nullshow();

                        }
                        myScrol0.refresh();
                });}
    }
    ins.init(); 
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
    var mod_coupons_right = $('.mod_coupons_right');
    mod_coupons_right.off(tapClick());
    mod_coupons_right.on(tapClick(),function(){
        var datIsbook = mod_coupons_right.find('a').attr('data-act-is-book'),
            mens_liss = $('.mens_lis');
            if(datIsbook == 0){
                if(window.isArray0_yes[0]){
                    if(window.isArray0_yes[0].list.length <= 0){
                        mens_liss.eq(1).click();
                    }else{
                        mens_liss.eq(0).click();
                    }
                }else{
                    mens_liss.eq(0).click();
                }
            }else if(datIsbook == 1){
                mens_liss.eq(1).click();
            }     
    });
    function add_del(nums){
        inputs.blur();
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
                    parents = $(this).parents('.mod-product-item'),
                    goods_id = parents.attr('data-goodid'),/*good_id*/
                    dels = that.siblings('.del'),
                    amountInp = that.siblings('.amountInp'),
                    amounsize = amountInp.text(),/*val*/
                    cartIconText = cartIcon.text(),/*价格*/
                    cur_price = parents.find('#price-yuan').text(),
                    zprice = $('.zprice'),
                    datakey = parents.attr('data-key'),
                    Keys = datakey.split('|'),
                    Dbiao_re = parents.attr('data-biao-refresh'),
                    DIs_re = parents.attr('data-is-refresh'),
                    cartdiv = $('.pub-cart');


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
                                // if (zong.toFixed(2) >= 200) {
                                //     price_cha.text('免运费');
                                // }else{
                                //     var prices = 200 - parseInt(zong.toFixed(2));
                                //     price_cha.text('还差'+prices+'元包邮');
                                // }
                                flays($('.mod-product-item'),ins,$('.product-image img'),cartdiv);/*飞入购物车*/
                                that.siblings().show();
                                cartIcon.show();

                                if(Dbiao_re == 1 && DIs_re == 1){
                                    loaging.close();
                                    loaging.init('刷新中...');
                                    window.location.reload();
                                    return false;
                                }
                                /*重新赋值*/
                                // if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 0){
                                //     var arr = window.isArray0_yes[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                // }else{
                                //     var arr = window.isArray1_no[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                // }
                                //  if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 0){
                                //     var arr = window.isArray0_yes[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                // }else{
                                //     var arr = window.isArray1_no[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                // }
                                if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 0){
                                    var arr = window.isArray1_no[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                }else{
                                    var arr = window.isArray0_yes[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                }
                                console.log(arr); 
                                if(arr.cart_goods_count){
                                  arr.cart_goods_count = parseInt(arr.cart_goods_count)+1;

                                }else{
                                    arr.cart_goods_count = 0;
                                    arr.cart_goods_count = parseInt(arr.cart_goods_count)+1;
                                }
                                    
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
                parents = $(this).parents('.mod-product-item'),
                goods_id = parents.attr('data-goodid'),/*good_id*/
                amountInp = that.siblings('.amountInp'),
                amounsize = amountInp.text(),/*val*/
                cartIconText = cartIcon.text(),/*价格*/
                cur_price = parents.find('#price-yuan').text(),
                zprice = $('.zprice'),
                datakey = parents.attr('data-key'),
                Keys = datakey.split('|'),
                Dbiao_re = parents.attr('data-biao-refresh'),
                DIs_re = parents.attr('data-is-refresh');
                sessions('del',del_fun);
                function del_fun(){                       
                    sessionStorage.setItem('del',"1");
                         commoms.post_server('/Cart/add',{shop_id:shopId,goods_id:goods_id,count:"-1"},function(data){
                            if(data.result =="ok"){
                                if(Dbiao_re == 1){
                                    loaging.close();
                                    loaging.init('刷新中...');
                                    window.location.reload();
                                    return false;
                                }                                  
                                var zong = parseInt(zprice.text())-parseInt(cur_price);
                                $('.mod-product-item').eq(ins).find('.amountInp').text(parseInt(amounsize)-1);/*中间的那个*/
                                cartIcon.text(parseInt(cartIconText)-1);/*红色小点toFixed(2)*/
                                zprice.text(zong.toFixed(2));/*总价*/
                                that.siblings().show();                          
                                /*邮费提醒显示*/
                                // if (zong.toFixed(2) >= 200) {
                                //     price_cha.text('免运费');
                                // }else{
                                //     var prices = 200 - parseInt(zong.toFixed(2));
                                //     price_cha.text('还差'+prices+'元包邮');
                                // }                               
                                /*重新赋值*/                            
                                // if(window.isArray2){
                                //     if($('.menLi_spans').parents('.mens_lis').index() == 0){
                                //         var arr = window.isArray2[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                //     }else{
                                //         var arr = window.isArray[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                //     }
                                    
                                // }else{
                                //     var arr = window.isArray[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                // }
                                // if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 0){
                                //     var arr = window.isArray0_yes[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                // }else{
                                //     var arr = window.isArray1_no[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                // } 
                                if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 0){
                                    var arr = window.isArray1_no[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                }else{
                                    var arr = window.isArray0_yes[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                }
                                console.log(arr);                                   
                                if(arr.cart_goods_count){
                                  arr.cart_goods_count = parseInt(arr.cart_goods_count) - 1;

                                }else{
                                    arr.cart_goods_count = 0;
                                    arr.cart_goods_count = parseInt(arr.cart_goods_count) - 1;
                                }                         
                                if(parseInt(cartIcon.text()) <= 0 ){
                                    cartIcon.hide();
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
        cart_btn.off('click');
        cart_btn.on('click',function(){
            // if($('.pub-btn').hasClass('pub-btn-dis')){
            //     loaging.close();
            //     return false;
            // }
            sessions('cart',cart_fun);
            function cart_fun(){ 
                sessionStorage.setItem('cart',"1");
                if(cartIcon.text()!=0){
                    location.href="/Cart/index/shop_id/"+shopId+"?distribution="+distriDiv.val();
                }else{
                    loaging.close();
                    loaging.prompts('请选择商品');
                }
                
            }
        })

        $('.pub-btn').click(function() {
            cart_btn.click();
        });
    }
    myScrol0.refresh();
    myScrol1.refresh();  
    
})
