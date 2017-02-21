









loaging.init('加载中...');
var Data_id = GetQueryString('data_id');
function autoScroll(obj){  
  $(obj).find("ul").animate({  
          marginTop : "-25px"  
      },500,function(){  
          $(this).css({marginTop : "0px"}).find("li:first").appendTo(this);  
      })  
}



$(function(){

    $('.section').css({'background-color':'rgba(0,0,0,.4)'});
    function getT(){
        if($('#shop_open_status').val() == 2 || $('#shop_delivertime_status').val() == 2){
            loaging.close();
            loaging.btn('店铺不在营业时间内');
        }else{
            
            loaging.close();
        }
    }

var myScrol0,myScrol1,myScrol2,iscroc={probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false,click:true},pullDownL,pullUpEl, pullUpL,Downcount = 0,Upcount = 0,loadingStep = 0,index=0,indexs = 0,infoH = $('.menulist-info').height(),k = $('.menulist-search').height(),
        lists={probeType: 2,scrollbars: false,mouseWheel: true,fadeScrollbars: true,bounce: true,interactiveScrollbars: true,shrinkScrollbars: 'scale',click: true,keyBindings: true,momentum: true};

        myScrol0 = new IScroll('#mensBox-left', iscroc); 
        myScrol2 = new IScroll('#menulist-sec',lists);



        pullUpEl = $('#pullUp');
        pullUpL = pullUpEl.find('.pullUpLabel');
        pullUpEl['class'] = pullUpEl.attr('class');
        pullUpEl.attr('class', '').hide();


        pullDownEl = $('#pullDown');
        pullDownL = pullDownEl.find('.pullDownLabel');
        pullDownEl['class'] = pullDownEl.attr('class');
        pullDownEl.attr('class', '').hide();




        myScrol1 = new IScroll('#mensBox-right', lists),
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
            collection = $('#collection'),
            inputs = $('input'),
            distriDiv = $('#distribution'),
            keyscart = $('#category_key'),
            detailsInfor = $('#detailsInfo-r'),
            topBox = $('#top-box');
            

            var closeBtn = $('.notice-close'),
                listmainBox = $('#list-mainBox'),
                hide_boxs = $('.bigbox'),//隐藏的div
                hide_box0 = $('.bigbox0'),//隐藏的div0
                hide_box1 = $('.bigbox1'), // 隐藏的div 1
                Big_mainBox = $('#list-mainBox'), // 大的div
                l_boxScroll = $('#mensBox-left .scroller'),//左
                r_boxScroll = $('.rightBox'),//右
                showAndhide = $('#showAndhide');

                window.isArray0_yes = new Array();
                window.isArray1_no = new Array();

                var shBtn = $('.shBtn'),
                hideDiv = $('#mod_coupnss');
                shBtn.on(tapClick(),function(){
                    if(hideDiv.hasClass('hide')){
                        hideDiv.removeClass('hide');
                    }else{
                        hideDiv.addClass('hide');
                    }
                    myScrol2.refresh();
                })
        init();
        iscrollAll();



        var timer ;
        clearInterval(timer);
        timer = setInterval('autoScroll(".apple")',3500);

        function init(){

            //初始化数据
            sessionStorage.clear();
            sessionStorage.setItem('newIndex','');
            sessionStorage.setItem('newKeys','');
            sessionStorage.setItem('newValue','');
            //购物车加减
            sessionStorage.setItem('add',"");
            sessionStorage.setItem('del',"");
            sessionStorage.setItem('cart',"");

             //请求数据
            commoms.post_servers('/Category/get_shop_goods',{shop_id:shopId},function(data){
     
                var newobj = [],newobj2 = [],hs = "";;
                if(data){
                    if(data && data[0].cat_id == 9){
                        for(var k = 1;k<data.length;k++){
                            newobj.push(data[k]);
                        }
                        newobj2.push(data[0]);
                        window.isArray1_no= newobj2;
                        window.isArray0_yes = newobj; 
                        showAndhide.val(0);
                        
                    }else{
                        window.isArray1_no= "";
                        window.isArray0_yes = data;
                        showAndhide.val(1);
                        
                    }

                    console.log(isArray1_no);   //id = 9   预定
                    console.log(isArray0_yes);  //没有预定的   



                    listmainBox.show();
                    
                        $('.mens_lis').find('span').removeClass('menLi_spans');

                        if(data && data[0].cat_id == 9){
                           
                           if(Data_id){
                                // 
                                // two_loadView(window.isArray1_no[Data_ids],1,Data_id);
                                var Data_ids = (Data_id * 1);
                                one_loadView(window.isArray0_yes[Data_ids],0,Data_id);
                                $('.mens_lis').eq(0).find('span').addClass('menLi_spans');
                                Big_mainBox.removeClass('mn');

                            }else{
                         
                                if(window.isArray0_yes[0].list.length <= 0){

                                    one_loadView(window.isArray0_yes[0],0,0);

                                    $('.mens_lis').eq(0).find('span').addClass('menLi_spans');
                                    Big_mainBox.removeClass('mn');

                                    
                                }else{
                                    two_loadView(window.isArray1_no[0],1);

                                    $('.mens_lis').eq(1).find('span').addClass('menLi_spans');
                                    Big_mainBox.addClass('mn');
                                }
                                
                            }

                            /*if(Data_id){
                                var Data_ids = (Data_id * 1) -1;
                                two_loadView(window.isArray1_no[Data_ids],1,Data_id);
                                $('.mens_lis').find('span').removeClass('menLi_spans');
                                $('.mens_lis').eq(1).find('span').addClass('menLi_spans');
                                Big_mainBox.removeClass('mn');

                            }else{
                         
                                if(window.isArray0_yes[0].list.length <= 0){

                                    
                                    two_loadView(window.isArray1_no[0],1,null);
                                    $('.mens_lis').find('span').removeClass('menLi_spans');
                                    $('.mens_lis').eq(1).find('span').addClass('menLi_spans');
                                    Big_mainBox.removeClass('mn');

                                }else{
                                    one_loadView(window.isArray0_yes[0],0);
                                }
                                
                            }*/

                        }else{
                            Big_mainBox.removeClass('mn');
                            $('.mens_lis').eq(0).find('span').addClass('menLi_spans');
                            if(Data_id){
                                var Data_ids = (Data_id * 1) -1;
                                one_loadView(window.isArray0_yes[0],0,Data_ids);
                            }else{
                                one_loadView(window.isArray0_yes[0],0,null);
                            }
                            // if(Data_id){
                            //     var Data_ids = (Data_id * 1) -1;
                            //     two_loadView(window.isArray1_no[Data_ids],1,Data_id);
                            // }else{
                            //     two_loadView(window.isArray1_no[0],1);
                            // }

                        }
                    
                    getT();

                }else{
                loaging.close();
                getT();
                }
            },function(){
                loaging.close();
                getT();
            },false);

        }
        var flg = false;
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

            setTimeout(function(){

            })
        });
        function one_loadView(data,nums,DataId){    
            
            // loadView(data,null,0);
            // l_getJsonInfos(0);
            myScrol0.refresh();
            sessionStorage.setItem('newIndex',0);
            // sessionStorage.setItem('newKeys',0);
            sessionStorage.setItem('newValue',0);
   
            if(DataId){
                sessionStorage.setItem('newKeys',(DataId * 1));

               // function loadView(data,lisIndex,ins,DataId){}

                loadView(data,null,0,0);

                l_getJsonInfos(0,DataId);
            }else{
                sessionStorage.setItem('newKeys',0);
                loadView(data,null,0);
                l_getJsonInfos(0);
            }
            tabs(0);
        }
        function two_loadView(data,nums,DataId){
            sessionStorage.setItem('newIndex',1);
            sessionStorage.setItem('newValue',0);
            sessionStorage.setItem('newKeys',0);

            loadView(data,null,1,null);
            l_getJsonInfos(1,null);
            // if(DataId){
            //     sessionStorage.setItem('newKeys',(DataId * 1) -1);
            //     loadView(data,null,1,DataId);
            //     l_getJsonInfos(1,DataId);
            // }else{
            //     sessionStorage.setItem('newKeys',0);
            //     loadView(data,null,1);
            //     l_getJsonInfos(1);
            // }
            tabs(1);
            myScrol0.refresh();
            
            

        }

       function nullshow(){
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
        }







        function iscrollAll(){
            myScrol2.on('scroll',Starts2);
            function Starts2(){
                // console.log(this.y+'****************'+(this.maxScrollY-5));
                if (this.y <= (this.maxScrollY-55)) {
                        topBox.css({
                            '-webkit-transform':'translateY(0%)',
                            'transform':'translateY(0%)'
                        });
                        flg = false;
                        detailsInfor.find('img').toggleClass('trans');
                    }
                   myScrol2 = new IScroll('#menulist-sec',lists);

            }



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
                                
                            
                              
                                pullipAjax(NumIndex,Numkeys,NumValue);
                            }else{
                                nullshow();
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


                            // detailsInfor.click();

                            topBox.css({
                                '-webkit-transform':'translateY(100%)',
                                'transform':'translateY(100%)'
                            }); 
                            flg = true;
                            detailsInfor.find('img').toggleClass('trans');
                            myScrol2.refresh();
                            myScrol2.scrollTo(0,0);
                            // var w = $(window).height()*1 - 116;
                      
                            // topBox.css('height',w+'px');

                        },100); //1秒


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
                    // console.log(this.y);
                    if(this.y > 50){

                        pullDownEl.attr('class', pullUpEl['class'])
                        pullDownEl.show();
                        pullDownEl.addClass('flip');
                        pullDownL.html('准备刷新...');
                        loadingStep = 1;
  

                    }if(this.y > 1){

                        // var w = $(window).height()*1 - 116;
                        // topBox.css({
                        //     '-webkit-transform':'translateY(0px)',
                        //     'transform':'translateY(0px)'
                        // }); 

                        // topBox.css('height',w+'px');
               
                        // myScrol1.refresh();

                        topBox.css('top','140px');
                        // myScrol1.refresh();
                        // myScrol0.refresh();

                    }else if (this.y < (this.maxScrollY - 5)) {
                        console.log(this.maxScrollY + 50);
                        pullUpEl.attr('class', pullUpEl['class'])
                        pullUpEl.show();
                        pullUpEl.addClass('flip');
                        pullUpL.html('全力加载中...');
                        loadingStep = 1;
                       

                        // var w = $(window).height()*1 - 50;
                        // topBox.css({
                        //     '-webkit-transform':'translateY(-66px)',
                        //     'transform':'translateY(-66px)'
                        // }); 

                        // topBox.css('height',w+'px');
                        
                    }else if(this.y <-20){
                        topBox.css('top','50px');
                    }
                }
            }
        }
        

       
        function tabs(nums){
           var toptabLi = $('.mens_lis');//顶层的lis切换
           var ins = 0;
            //顶层点击切换
            toptabLi.off('click');
            toptabLi.on('click',function(e){
                e.preventDefault();
                var LisInx = $(this).data('index');
                   
        
                   loaging.close();
                   loaging.init('加载中...');

                    var ins = $(this).index() * 1;//index
                    toptabLi.find('span').removeClass('menLi_spans');
                    $(this).find('span').addClass('menLi_spans');
                    Big_mainBox.removeClass('mn');
                    hide_boxs.hide();
                                       
                    
                    switch(LisInx)
                    {
                    case 0:
                        //加载右数据
                      
                        loadView(window.isArray0_yes[0],null,0);
                        //加载左数据
                        l_getJsonInfos(0);


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
                   
                        loadView(window.isArray1_no[0],null,1);
                        //加载左数据
                        l_getJsonInfos(1);


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
        }

        function loadView(data,lisIndex,ins,DataId){
         
            


                if(data){
                    var html="",liindex = 0,res ="",inst="";
                    lisIndex ? liindex = lisIndex : lisIndex = 0;

                    ins == 0 ? inst = 0 : inst = 1;

                    console.log(data.list[lisIndex]);
                    if(data.list[lisIndex] && data.list.length > 0){
                        res = data.list[lisIndex];
                        getJsonInfos(data.list[lisIndex],inst,(DataId ? DataId :0));

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
                        nullshow();
                    }
                }else{

                }
        }




        function l_getJsonInfos(datas,DataId){


            var lis = "",dataHtml="",uls="",Is = "",inx = "";
                uls = $('<ul class="leftBox-uls">');

                

                if(datas == 0){
                    dataHtml = window.isArray0_yes;
                    // l_boxScroll.css('padding-top','36px');
                    // Is = '<i></i>';
                    Is="";
                   
                    if(DataId){
                        inx = DataId * 1;
                    }else{
                        inx = 0;
                    }
                }else{
                    dataHtml = window.isArray1_no;
                    // l_boxScroll.css('padding-top','0px');
                    Is = "";

                    inx = 0;

                }
                

                $.each(dataHtml,function(index, el) {
 
                        lis+='<li class="ls-item '+(index == 0 ? 'ls-item2':'')+'"><span class="span-label '+(index == inx ? 'span-select':'')+'">'+el.cat_name+'</span><ol class="ols-box '+(index == inx ? '':'hides')+'">'
                            for(var k = 0;k < el.list.length;k++){
                                lis+='<li class="ols-item '+(k == 0 ? 'ols-select':'')+'" cat-id="'+el.cat_id+'" son-cat-id="'+el.list[k].son_cat_id+'"><s>'+el.list[k].cat_name+'</s>'+Is+'</li>'
                            }
                        lis+='</ol></li>';



                    if(datas == 1 && el.list.length <= 0){
                        lis = "";
                        lis = "<li class='ls-item ls-item3'>暂无</li>"
                    }
                });

                uls.html(lis);
                l_boxScroll.html('');
                l_boxScroll.html(uls);
               
                datas == 0 ? Clis(dataHtml) : Clis2(dataHtml); 
                myScrol0.refresh();  



        }



        function Clis(re){
            // if(re.length == 1){
            //     $('.ls-item .span-label').css({'font-size':'0px','background':'none','margin-top':'-45px'});
            // }

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
                        loadView(res,null,0)

                        if($(this).hasClass('span-select')){
                            lis.removeClass('ols-select'); 
                        }

                        lis.first().addClass('ols-select');


                        sessionStorage.setItem('newIndex',0);
                        sessionStorage.setItem('newKeys',idx);
                        sessionStorage.setItem('newValue',0);
                        

   

                    }else{
                        nullshow();

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
                            loadView(res,lisIndex,0);

                            sessionStorage.setItem('newKeys',idx);
                            sessionStorage.setItem('newValue',lisIndex);
                            sessionStorage.setItem('newIndex',0);

                        }else{
                            nullshow();
                        }
                        myScrol0.refresh();
                    });
        }




        function Clis2(re){
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
                        loadView(res,null,1);

                        if($(this).hasClass('span-select')){
                            lis.removeClass('ols-select'); 
                        }
                        lis.first().addClass('ols-select');

                        sessionStorage.setItem('newIndex',1);
                        sessionStorage.setItem('newKeys',idx);
                        sessionStorage.setItem('newValue',0);
                              

                    }else{
                        nullshow();
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
                            loadView(res,lisIndex,1);

                            sessionStorage.setItem('newIndex',1);
                            sessionStorage.setItem('newKeys',idx);
                            sessionStorage.setItem('newValue',lisIndex);
                            

                        }else{
                            nullshow();

                        }
                        myScrol0.refresh();
                });
        }
        function getJsonInfos(datas,nums,DataId){
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

                                data.act_name ? act_name = '<span class="pm-intaglio">'+data.act_name+'</span>' : act_name="";
                                data.goods_price ? goods_price = '<span class="product-price-market theme-grayfont"><span class="price-yuan">¥</span>'+data.goods_original_price+'</span>' :goods_price = "";
                                if(data.goods_stockout == 1){
                                    goods_stockout='<span class="grens">补货中</span>';
                                    urlImgId = 'add_disabled';
                                    imgsd = "addhui_icon";
                                }else{
                                    goods_stockout = "";
                                    urlImgId = "";
                                    imgsd="add_icon";
                                }
                                // if(!nums){
                                //     numsUrl1 = 'new/jian';
                                //     numsUrl2 = 'new/jia';
                                // }else{
                                //     numsUrl1 = 'del_icon';
                                //     if(data.goods_stockout == 1){
                                //         numsUrl2 = 'addhui_icon';
                                //     }else{
                                        
                                //         numsUrl2 = 'add_icon';
                                //     }
                                    
                                // }
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
                                if(data.goods_is_book == 1){
                                     is_books = '<span class="pm-img"><img src="/Public/image/yus.png" alt=""></span>'
                                }else{
                                  is_books='';
                                }

                       

                                // if(DataId){
                                //     var ky =data.large_key * 1 - 1;
                                // }else{
                                //     if(window.isArray0_yes){
                                //         if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 0){
                                //             var ky =data.large_key ;
                                //         }else{  
                                //             var ky =data.large_key * 1 - 1;
                                //         }
                                //      }else{
                                //         var ky = data.large_key;
                                //     }

                                // }


                                // if(DataId){
                                //     if(window.isArray0_yes){
                                //         if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 1){
                                //             var ky =data.large_key ;
                                //         }else{  
                                //             var ky =data.large_key * 1 - 1;
                                //         }
                                //      }else{
                                //         var ky = data.large_key;
                                //     }
                                    
                                // }else{
                                //     var ky =data.large_key * 1 + 1;
                                // }

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
                                                +'<div class="product-name ui-ellipsis">'+data.goods_name+''+goods_pungent+'</div>'
                                                +'<div class="product-promotion">'
                                                    +goods_type+goods_puns+act_name+goods_stockout+is_books
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
                    nullshow();
                }
             


                mainBox_title.show();
                mainBox_title.html('<p class="ui-ellipsis"><span class="'+(nums == 0 ? 'Span' : '')+'">'+datas.cat_name+'<b>（'+(datas.goods_list ? datas.goods_list.length : '0')+'）</b></span><s>'+ptsHtml+'</s></p>');
                // if(nums == 0){$('.Span') && $('.Span').css('background-image','url('+Imgbg+')')};
            }else{
               
                nullshow();
            }

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
            
        })

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
                                     if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 0){
                                        var arr = window.isArray0_yes[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                    }else{
                                        var arr = window.isArray1_no[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
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
                                    if($('.menLi_spans').parents('.mens_lis').attr('data-index') == 0){
                                        var arr = window.isArray0_yes[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
                                    }else{
                                        var arr = window.isArray1_no[Keys[0]].list[Keys[1]].goods_list[Keys[2]];
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
        })
        function pullipAjax (getIndex,getkeys,getValue) {
            var ols = $('.ols-box'),
                olis = ols.find('.ols-item'),
                spanli = $('.ls-item');    
                var numsData = "";
                if(getIndex == 0){
                    numsData = window.isArray0_yes;
                }else{
                    numsData = window.isArray1_no;
                }
            if(getkeys <= numsData.length){               
                if(getValue < numsData[getkeys].list.length ){         
                    loadView(numsData[getkeys],getValue,getIndex);

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
        }
    myScrol0.refresh();
    myScrol1.refresh();  
    
})
