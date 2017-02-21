loaging.init('加载中...');
function getclickinfo(size){
    loaging.prompts(size);
}
window.onload=function(){
    var yans = $('.yans'),
        yansImg = $('#yansImg')
    commoms.post_server('/index/get_untreated',{},function(re){
        if(re.code == '200' ){
            if(re.date != 0){
                loaging.close();
                yans.show();
                yans.on('click',function(){
                    $(this).hide();
                })
            }
        }
    });
}
var myScrol0,myScrol1,myScrol2,myScrol3,myScrol4,myScrol5,myScrol6,myScrol7,myScrol8,myScrol9,myScrol10,lats="",lngs="",myScrolls;
    iscroc={probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false,click:true},ks="",
    lists={preventDefault:false,probeType: 2,scrollbars: false,mouseWheel: true,fadeScrollbars: true,bounce: false,interactiveScrollbars: true,shrinkScrollbars: 'scale',click: true,momentum: true},mod_shopDiv = $('#mod-my-shop'),
    swiperlist = {
            pagination: '.swiper-pagination',
            autoplayDisableOnInteraction : false,
            loop: true,
            autoplay: 5000
            }
    returnTop =$('.Return-top'),
    pubLis = $('.pub-cart_menu li'),
    menuLs = $('.main_list_ol li'),
    mbox_button = $('.mbox-button'),
    one_bgs = $('.pub-header.bgss-one');
function autoScroll(obj){  
      $(obj).find("ul").animate({  
          marginTop : "-32px"  
      },500,function(){  
          $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);  
      })  
}
var Iwidth = 640/300,
    screenW = $(window).width(),
    IH = screenW/Iwidth;
    var Iwidth2 = 640/300,
    screenW2 = $(window).width(),
    IH2 = screenW/Iwidth;
// $('.banner .swiper-slide img').height(IH);
// $('.banner .swiper-slide img').css('max-height','320px');
$('.swiper-slide img').height(IH);
$('.swiper-slide img').css('max-height','320px');
$(document).ready(function() {
    var ins = {
        init:function(){
            var oneBox =$('#mod-box'),
            scroLis = $('#scroller li');
            oneBox.show();
            pubLis.eq(0).find('img').attr('src','/Public/image/icon/a1.png');
            pubLis.eq(0).addClass('cos');
            menuLs.eq(0).addClass('Borders');
            sessionStorage.setItem("fourkeys", "no");
            sessionStorage.setItem("data", "");
            this.iscrollAll();
            this.swipers();
            this.init_href();
            this.tabs();
            score('list-main-one','wrap_x');
            var url=window.location.href;
            weixins(url,"index");
        },init_href:function(){
            var location_href = $('.location_href');
            location_href.on(tapClick(),function(){
                var par = $(this).parents('.generic-Boxli'),
                    par_Id = par.attr('data-ids').split('|'),
                    par_index0 = par_Id[0],par_index1 = par_Id[1],par_index2=par_Id[2];
                    if(par_index0 && par_index0 != 3 && par_index1 && par_index2==0){
                        loaging.close();
                        loaging.init('加载中,请稍后...');
                        location.href='/Category/index/shop_id/'+par_index1;
                    }
            })
        },iscrollAll:function(){
            myScrol0 = new IScroll('#list-main-one', iscroc);
            myScrol3 = new IScroll('#list-main-four', iscroc);
            myScrol4 = new IScroll('#list-main-five', iscroc);
            myScrol6 = new IScroll('#iscroll-select', lists);
            myScrol7 = new IScroll('#iscroll-selec-list',lists);
            myScrol9 = new IScroll('#adds-main-one', { probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false });
            myScrol10 = new IScroll('#adds-main-three', { probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false });
            function updatePosition1(){
                if(this.y<=-50){
                    returnTop.show();  
                }else{
                    returnTop.hide();
                }
            }
            function iscros(ys){
                if(ys <= 10){
                    ks= '0.'+ ys;
                    if(ys <=2 ){
                        ks= '0.2';
                    }else if(ys == 10){
                        ks = '1';
                    }
                }
                one_bgs.css('background','rgba(85,182,125,'+ks+')');//49,147,81  89,177,90
            }
            myScrol0.on('scroll',function(){
                ys = parseInt(this.y*(-100)/1000);
                iscros(ys);
            });
            myScrol0.on('scrollEnd',function(){
                iscros(ys);
            });
        },swipers:function(){
            var lens=$('.banner').find('.swiper-slide').length;
            var lens2=$('.bases').find('.swiper-slide').length;
            if(lens>1){
                setInterval('autoScroll(".apple")',2000);
                var swiper = new Swiper('.banner.swiper-container', swiperlist);
            } 
            if(lens2>1){
                 var swiper = new Swiper('.bases.swiper-container',swiperlist);
            }       
        },tabs:function(){
            var $Menulis=pubLis,
                atrr=['a','b','c','d','e'],
                top=$('.Return-top'),
                ptie = $('.pub-cart_menu li p'),
                divs = $('.pageview');
                $Menulis.on('click',function(){
                    var index=$(this).index();
                        returnTop.hide();
                        divs.hide();
                    ptie.removeClass('positions');
                    $(this).find('p').addClass('positions cos');
                    $Menulis.eq(index).addClass('cos').siblings().removeClass('cos');
                     $Menulis.each(function(inx, el) {
                        $Menulis.eq(inx).find('img').attr('src','/Public/image/icon/'+atrr[inx]+'0.png');
                     });
                      $Menulis.eq(index).find('img').attr('src','/Public/image/icon/'+atrr[index]+'1.png');
                      $('.pageviewBox').eq(index).show();
                      switch(index){
                        case 1:
                          up.getTwoList();
                          break;   
                        case 2:
                          ajaxetil(carts,'/user/login.html');
                          break;
                        case 3:
                          ajaxetil(getAjaxsK,'/user/login.html');
                          break;
                        case 4:
                          ajaxetil(as,'/user/login.html');
                          function as(){layer.closeAll();myScrol4.refresh();}
                          break;
                        default:
                          $('.pageviewBox').eq(0).show();
                        }
                    myScrol0.refresh();
                })
        }
    }
    ins.init();
    returnBth();
    clicks();
    commoms.post_server('/index/get_user_xy',{},function(re){
        if(re.result == 'ok'){
            lats=re.data.x;
            lngs=re.data.y;
        }   },function(){
    },false);
    function returnBth(){
        var bthp = $('.buttons p');
        $('.icon-back').on(tapClick(),function(){
            $('input,textarea').blur();
            var parentName=$(this).parents('div').attr('class');
            if(parentName.indexOf('adds_selection')>-1){
                var txt = $('.adds_selection .head_box .box_set').html();
                    if(txt == '送货上门'){
                        bthp.eq(0).addClass('box_set').siblings().removeClass('box_set');
                        $('.hide_Divs').eq(0).show().siblings().hide();
                        ins.iscrollAll();
                    }else{
                        bthp.eq(1).addClass('box_set').siblings().removeClass('box_set');
                        $('.hide_Divs').eq(1).show().siblings().hide();
                        ins.iscrollAll();
                    } 
               $('#adds_selections').hide();
                ins.iscrollAll();
            }else if(parentName.indexOf('mod-select-city')>-1){
                $('#mod-selects').hide();
                $('#pub-cart-box').show();
                $('#pub-cart-box li').eq(1).trigger('click');
            }
        })
    }  
    function clicks(){
        $('.share_firends').on(tapClick(),function(){
            $('.mod-share').show();
            $('.mod-share').on(tapClick(),function(){
                $(this).hide();
            })
        })
        var addssec_p = $('.adds_selection .head_box p');
        addssec_p.on(tapClick(),function(){
            var index=$(this).index();
            $(this).addClass('box_set').siblings().removeClass('box_set');
            $('.adds_selection .addrlist_main>div').eq(index).show().siblings().hide();
            ins.iscrollAll();
        });
        $('.list-main-four-html .head_box p').on(tapClick(),function(){
            var index=$(this).index();
            $(this).addClass('box_set').siblings().removeClass('box_set');
        });
    }
    function hides(){
        $('.mod-city-lists').hide();
        $('.mod-overlay-mask').hide();
         ins.iscrollAll(); 
    }
    function carts(){}
    
var pullDownEl, pullDownL,
    pullUpEl, pullUpL,
    Downcount = 0, Upcount = 0,
    loadingStep = 0,
    index=0,
    lists={
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
    },
    two_rBtn = $('#two_right'),
    select_add = $('#mod-selects'),
    ols_li = $('#main_list_ol li'),
    adds_hides = $('.adds_hides');

    pullUpEl = $('#pullUp');
    pullUpL = pullUpEl.find('.pullUpLabel');
    pullUpEl['class'] = pullUpEl.attr('class');
    pullUpEl.attr('class', '').hide();

    $('.all_shop,.mbox-button').on(tapClick(),function(){
        pubLis.eq(1).trigger('click');
    })
    $('#My_shop').on(tapClick(),function(){
        pubLis.eq(3).trigger('click');
    })
     
    var up = {
        init:function(){
            this.clicks();
            this.iscrollA();
        },getTwoList:function(){
            var _this_ = this;
            if(sessionStorage.getItem("data")){
                var getdatas = sessionStorage.getItem("data");
                var getarr = JSON.parse(getdatas);
                loaging.init('加载中...');
                setTimeout(function(){
                    _this_.getLoadDate(getarr,'rs');
                },500);  
            }else{
                sessionStorage.setItem("key", "0");    
                myScrolls = new IScroll('#list-main-two', lists);
                myScrolls.on('scroll',Starts);
                myScrolls.on('scrollEnd', function () {
                    if (loadingStep == 1) {
                        if (pullUpEl.attr('class').match('flip|loading')) {
                            pullUpEl.removeClass('flip').addClass('loading');
                            pullUpL.html('请稍后...');
                            loadingStep = 2;                
                            _this_.pullipAjax();
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
           
                var hidelat=$('#hide-lat').val();
                var hidelng=$('#hide-lng').val();
                if(hidelat && hidelng){
                    var option = {lng:hidelng,lat:hidelat};
                    //upDown(hidelat,hidelng,'/Shop/shop_list',option);
                    _this_.upDown(hidelat,hidelng,'/Shop/shop_list',option);
                } else{
                    _this_.showD_empty();
                }   
            }      
        },upDown:function(lat,lng,url,option,rs){
            var _this_ = this;
            commoms.post_server(url,option,function(data){
                index = 0;
                var string_data="";
                sessionStorage.setItem("key", index);
                ols_li.eq(0).addClass('Borders').siblings().removeClass('Borders');
                _this_.getLoadDate(data,rs);
            },function(data,rs){
                
            },false);
        },getLoadDate:function(data,rs){
            var _this_ = this;
            if(rs){
                window.isVipArray1.splice(0,window.isVipArray1.length);
                window.isVipArray2.splice(0,window.isVipArray2.length);
                window.isVipArray3.splice(0,window.isVipArray3.length);
                window.isVipArray4.splice(0,window.isVipArray4.length); 
            }else{
                window.isVipArray1 = new Array();
                window.isVipArray2 = new Array();
                window.isVipArray3 = new Array(); 
                window.isVipArray4 = new Array(); 
                if(data){
                    string_data = JSON.stringify(data);
                    sessionStorage.setItem("data", string_data);
                }
            }
            if(data){
                for(var k=0;k<data.length;k++){
                    var shop_isvip="";
                    if(data[k].shop_isvip==5){
                        shop_isvip="星级VIP";
                        window.isVipArray1.push(data[k]) ;
                    }else if(data[k].shop_isvip==1 || data[k].shop_isvip==4 ){
                        shop_isvip="VIP店铺";
                        window.isVipArray2.push(data[k]) ;
                    }else if(data[k].shop_isvip==2){
                        shop_isvip="普通店铺";
                         window.isVipArray3.push(data[k]) ;
                    }else if(data[k].shop_isvip==3){
                        shop_isvip="代售点";
                         window.isVipArray4.push(data[k]) ;
                    }
                }
                if(rs){
                    if(window.isVipArray1.length != 0){

                        ols_li.eq(0).click(); 
                    }else if(window.isVipArray2.length != 0)
                    {
                        ols_li.eq(1).click(); 
                        
                    }else if(window.isVipArray3.length != 0)
                    {
                        ols_li.eq(2).click();
                    }else if(window.isVipArray4.length != 0)
                    {
                        ols_li.eq(3).click();
                    }else {
                        sessionStorage.setItem("key",'0');
                        loading.btn('该区域没有店铺，请重新选择城市');
                    }                   
                }else{
                    _this_.loadView(window.isVipArray1);
                }
            }else{
                _this_.showD_empty();
            }
        },showD_empty:function (){
                adds_hides.show();
                loaging.close();
                pullUpEl.removeClass('loading');
                pullUpEl['class'] = pullUpEl.attr('class');
                pullUpEl.attr('class', '').hide();
                loadingStep = 1;  
                myScrolls.refresh();
        },loadView:function(data){
            var hidelat=$('#hide-lat').val(),
                hidelng=$('#hide-lng').val();
            var _this_ = this;
                if(data.length){
                    _this_.getJsonInfos(data,$('.list-product-Lis'),'wrap_onex');
                    pullUpEl.removeClass('loading');
                    pullUpL.html('上拉显示更多...');
                    pullUpEl['class'] = pullUpEl.attr('class');
                    pullUpEl.attr('class', '').hide();
                    loadingStep = 0;  
                }else{
                    _this_.showD_empty();
                }
                score('list-main-two','wrap_onex');   
                myScrolls.refresh();         
        },getJsonInfos:function(data,Divs,xing,tabIndex){
            var html="",shop_isvip = "",iconImg="",telphone = "",htmlInfo = "",htmlColor="",htmlColor2="",ishide = "",ahref="",ahr = "",is_bookImg="",hrefs = "",
                storeHTML = "";
            if(data[0].shop_isvip==1){
                shop_isvip="VIP店铺";
                iconImg='bq-red';
            }else if(data[0].shop_isvip==2){
                shop_isvip="普通店铺";
                iconImg='bq-gre';
            }else if(data[0].shop_isvip==3){
                shop_isvip="代售点";
                iconImg='bq-yell';
            }else if(data[0].shop_isvip==4){
                shop_isvip="VP店铺";
                iconImg='bq-vp';
            }else if(data[0].shop_isvip==5){
                shop_isvip="星级VIP";
                iconImg='bq-redXing';
            }
            var hide_lat = $('#hide-lat').val();
            var hide_lng = $('#hide-lng').val();
            var user_district = $('#user_district').val();
            
            for (var k = 0; k <data.length; k++) {
                if(data[k].shop_orderphone1){
                    telphone = data[k].shop_orderphone1;
                }else if(data[k].shop_orderphone2){
                    telphone = data[k].shop_orderphone2;
                }else{
                    telphone="javascript:void(0);";
                    ishide = "hide";
                }
                if(tabIndex == 0 || data[k].shop_status == 1){
                    ahr = 'javascript:void(0);'
                }else{
                    ahr='/Category/index/shop_id/'+data[k].shop_id;
                }  
                if(hide_lat && hide_lng && user_district){
                    hrefs = '/shop/navigation?user='+user_district+'&shop='+data[k].shop_address+'&user_x='+hide_lng+'&user_y='+hide_lat+'&shop_x='+data[k].shop_baidux+'&shop_y='+data[k].shop_baiduy;
                }else{
                    hrefs = 'javascript:void(0);';
                } 
                if(data[k].shop_isvip==3){
                    ahref = '<a href="javascript:void(0);" onclick=\'getclickinfo("代售点不能购买产品")\'>';
                }else if(data[k].shop_status == 1){
                    ahref = '<a href="javascript:void(0);" onclick=\'getclickinfo("店铺关闭")\'>'
                }else{
                    ahref = '<a href="'+ahr+'">';
                }
                // data[k].shop_isvip==3?ahref = '<a href="javascript:void(0);" onclick=\'getclickinfo("代售点不能购买产品")\'>':ahref = '<a href="'+ahr+'">';
                data[k].shop_open_status != 1?htmlColor = 'generic-hui':htmlColor = '';
                data[k].shop_delivertime_status != 1?htmlColor2 = 'generic-hui':htmlColor2 = '';
                if(data[k].shop_deliver_type == '1'){
                    htmlInfo = '<p class="generic-carry generic-song '+htmlColor+'"><span>送</span><b>'+data[k].shop_updeliverfee+'</b>元起送/配送费<b>￥'+data[k].shop_deliverfee+'</b></p><p class="generic-carry generic-zi '+htmlColor2+'"><span>自</span>在线下单，到店自提</p>'
                }else if(data[k].shop_deliver_type == '2'){
                    htmlInfo = '<p class="generic-carry generic-dian '+htmlColor+'"><span>店</span>仅支持到店自提</p>'
                }
                if(data[k].score <= 0){
                    storeHTML="<div class='zanwu'>暂无评价</div>";
                }else{
                    storeHTML='<div class="mens_details_x"><div class="wrap_x" id="'+xing+''+k+'" data-index="'+data[k].score+'" data-id="'+k+'"><div id="cur" class="cur"></div></div></div>'
                }
                data[k].is_book === 1 ? is_bookImg='<img class="icon_img" src="/Public/image/yudi.png">':is_bookImg = "";
                html+='<li class="generic-Boxli" data-id='+data[k].shop_id+'><div class="generic-item"><div class="generic-item-img">'+ahref+''+is_bookImg+'<img class="image autos" src="'+data[k].shop_avatar+'" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"></a></div><div class="generic-item_info ui-ellipsis">'+ahref+'<div class="lis-title ui-ellipsis"><h2 class="ui-ellipsis">'+data[k].shop_name+'</h2><img class="liimg" src="/Public/image/'+iconImg+'.png" alt="pic" ></div>'+storeHTML+'<p class="generic-item-sh">已售<span>'+data[k].shop_totalordercount+'</span></p></a></div><div class="generic-item_mi"><a href="'+hrefs+'"><img src="/Public/image/icon-d.png" alt=""><p>'+data[k].distance+'</p></a></div></div><div class="generic-address ui-ellipsis"><span class="">'+data[k].shop_address+'</span></div><div class="generic-not-mention">'+htmlInfo+'<a href="tel:'+telphone+'" class="generic-a blocks"><img src="/Public/image/icon-phone.png" alt=""></a></div></li>';

            } 
            Divs.html(html);
            loaging.close();

            var shopDiv_img = mod_shopDiv.find('.generic-item-img'),
                shopDiv_Info = mod_shopDiv.find('.generic-item_info');
            
            shopDiv_img.on(tapClick(),function(){
                var boxSet = mod_shopDiv.find('.box_set').index(),
                    boxIndex = $(this).parents('.generic-Boxli').attr('data-id');
                    boxId = $('.generic-Boxli');
                location.href='/Category/index/shop_id/'+boxIndex+'/distribution/'+boxSet;
            })
            shopDiv_Info.on(tapClick(),function(){
                var boxSet = mod_shopDiv.find('.box_set').index(),
                    boxIndex = $(this).parents('.generic-Boxli').attr('data-id');
                    boxId = $('.generic-Boxli');
                location.href='/Category/index/shop_id/'+boxIndex+'/distribution/'+boxSet;
            })
        },clicks:function(){
            var _this_ = this;
            ols_li.on('click',function(){
                adds_hides.hide();
                myScrolls.refresh();
                $('.list-product-Lis').html('');
                index = $(this).index();
                sessionStorage.setItem("key", index);
                $(this).addClass('Borders').siblings().removeClass('Borders');
                var arr ;

                if(index == 0){
                    if(window.isVipArray1.length){
                        up.loadView(window.isVipArray1);   
                    }else{
                        loaging.close();
                        _this_.showD_empty();
                    }
                }else if(index == 1){
                     if(window.isVipArray2.length){
                            up.loadView(window.isVipArray2);
                        }else{
                            loaging.close();
                            _this_.showD_empty();
                        }         
                }else if(index==2){
                    if(window.isVipArray3.length){
                            up.loadView(window.isVipArray3);
                        }else{
                            loaging.close();
                            _this_.showD_empty();
                    } 
                }else if(index==3){
                    if(window.isVipArray4.length){
                            up.loadView(window.isVipArray4);
                    }else{
                            loaging.close();
                            _this_.showD_empty();
                    } 
                }
                myScrolls.scrollTo(0,0,0);
                myScrolls.refresh();
            })
            two_rBtn.on(tapClick(),function(){
                select_add.show();
                _this_.iscrollA();
                _this_.selects();
            });
        },selects:function(){
            var that = this,
                mod_selects=$('#mod-selects'),
                liItem=$('.scrollers_Items li.item'),
                mod_citylists_a=$('.mod-citylists .mod-citylists_a'),
                hidden_index=$('#hidden-index');
                liItem.off(tapClick());
                liItem.on(tapClick(),function(){
                    var datacity=$(this).attr('data-city');
                    if(datacity){
                        that.datacityAjax(datacity);
                    }else{
                        loaging.btn('请重新选择');
                    }
                    myScrol7 = new IScroll('#iscroll-selec-list',lists);
                    $('.mod-citylists>p span').on(tapClick(),function(){
                        hides();
                    })
                    mod_citylists_a.off(tapClick());
                    mod_citylists_a.on(tapClick(),function(){
                        hides();
                    var tst=hidden_index.val(),
                        hide_cityid=hidden_index.attr('city_id'),
                        hide_areaid=hidden_index.attr('area_id');
                        $('#mod-nearby').show().siblings().hide();
                        $('#pub-cart-box').show();
                        $('#two_right span b').html(tst);   
                        var option = {city_id:hide_cityid,area_id:hide_areaid};
                        $('.list-product-Lis').html('');
                        that.upDown(hide_cityid,hide_areaid,'/Shop/shop_list',option,'rs');
                })
            })
        },iscrollA:function(){
            myScrol6 = new IScroll('#iscroll-select', lists);
            myScrol7 = new IScroll('#iscroll-selec-list',lists);
            var atrr=[],
            $divs = $('.divs'),
            floor=$(".shu p"),
            layout=$("._scroll ul");
            for(var i=0; i<layout.length; i++){
             var  Top=layout.eq(i).offset().top;
             atrr.push(Top); 
            };
            var ones=atrr[0];
            myScrol6.on('scroll',Starts);
            myScrol6.on('scrollEnd',function () {
                if(this.y <= -ones){
                    $divs.show();
                 }else{
                    $divs.hide();
                 };
            });
            function Starts() {
                 if(this.y <= -ones){
                    $divs.show();
                 }else{
                    $divs.hide();
                 };
                for(var j=0; j<atrr.length; j++){
                    var k=-(atrr[j]-50);
                     if( this.y <= k){                        
                        $divs.html(floor.eq(j).text());
                     };
                 };                        
            }
            $(".shu p").bind('click',function(){
                var index=$(this).index();
                 var num2=-((atrr[index])-50);
                 $divs.html(floor.eq(index).text());
                 myScrol6.scrollTo(0,num2,0);
            });  
        },datacityAjax:function(datacity){
            if(datacity){
                var $hidden_index=$('#hidden-index'),
                    url='/City/area_list',
                    option={city_id:datacity};
                    commoms.post_server(url,option,function(result){
                        $('.mod-city-lists').show();
                                $('.mod-overlay-mask').show();
                                if(result){
                                    var html="";
                                    if(result){
                                        for(var k=0;k<result.length;k++){
                                            html+='<li class="item-name" city_id="'+result[k].area_city+'" area_id="'+result[k].area_id+'"><span>'+result[k].area_name+'</span></li>';
                                            $hidden_index.val(result[0].area_name);
                                            $hidden_index.attr('city_id',result[0].area_city),
                                            $hidden_index.attr('area_id',result[0].area_id);
                                        }
                                        $('.scrollers_mens').html(html);
                                        $('.scrollers_mens li:first').find('span').addClass('colos_y');
                                        myScrol7.refresh();
                                        $('.scrollers_mens li').on(tapClick(),function(){
                                            var index=$(this).index(),
                                                cityid=$(this).attr('city_id'),
                                                areaid=$(this).attr('area_id');
                                            $('.scrollers_mens li').find('span').removeClass('colos_y');
                                            $('.scrollers_mens li').eq(index).find('span').addClass('colos_y');
                                            var txt=$('.scrollers_mens li').eq(index).find('span').text();
                                            $hidden_index.val(txt);
                                            $hidden_index.attr('city_id',cityid);
                                            $hidden_index.attr('area_id',areaid);
                                        })
                                    }
                                }
                    },function(){
                        loaging.btn('获取失败');
                    },false);
            }
        },pullipAjax:function(){
            index = sessionStorage.getItem('key');
            index++;
            sessionStorage.setItem("key",index);
            var len = ols_li.length;
            if(index == len)
            {
                index = 0 ;
                sessionStorage.setItem("key",index);
            }
            for (var i = 0; i < len; i++) {
                var arr ;
                if(index == 0){
                    arr = window.isVipArray1;

                }else if(index == 1){
                    arr = window.isVipArray2;
                   
                }else if(index==2){
                    arr = window.isVipArray3;
                  
                }else if(index==3){
                    arr = window.isVipArray4;
                  
                }
                if(arr.length){
                    up.loadView(arr);
                    break;
                }else{
                    index ++ ;
                    if(index == len || index > (len+1))
                    {
                        index = 0;
                        sessionStorage.setItem("key",0);
                    }
               }
            };
            ols_li.eq(index).click();
            adds_hides.hide();
            myScrolls.refresh();  
        }
    }
    up.init();
    
   
    /*获取收藏店铺列表*/
    function getAjaxsK(){
       /*if(sessionStorage.getItem('fourkeys') == 'yes'){return false;}*/
        loaging.init('加载中...');
        var url='/Collection/index';
        commoms.post_server(url,{},function(result){
            if(result.result == 'ok'){  
                var html="",
                    json_data=eval(result.data);
                    shop_isvip="",
                    as="javascript:void(0);";
                    if(json_data){
                        layer.closeAll();
                        up.getJsonInfos(json_data,$('.list-main-four #my-shop-ul'),'wrap_twox','0');
                        score('list-main-four','wrap_twox');  
                        $('#mod-my-shop .liItems').on(tapClick(),function(){
                            var Ind = $('.head_box .box_set').index(),
                                dataId = $(this).attr('data-id');
                                location.href='/Category/index/shop_id/'+dataId+'?distribution='+Ind;
                        })
                        sessionStorage.setItem("fourkeys", "yes");
                    }else{
                        layer.closeAll();
                        $('.list-main-four .four_null').show();
                    }
                    myScrol3.refresh();
                }else{
                    layer.closeAll();
                    location.href='/user/login.html'
                }
                score('list-main-one','wrap_x4');
        },function(){
        });
    };    
 });
