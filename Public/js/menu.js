function upDown(){
    var myScroll;
    var pullDownEl, pullDownL;
    var pullUpEl, pullUpL;
    var Downcount = 0, Upcount = 0;
    var loadingStep = 0;//加载状态0默认，1显示加载状态，2执行加载数据，只有当为0时才能再次加载，这是防止过快拉动刷新
    var index=0;
    $(function () {loaded();})

    function pullDownAction() {//下拉事件
        setTimeout(function () {
            var el, li, i;
            el = $('#centent_box');
            for (i = 0; i < 3; i++) {
                li = $("<li></li>");
                Downcount++;
                li.text('new Add ' + Downcount + " ！");
                el.prepend(li);
            }
            pullDownEl.removeClass('loading');
            pullDownL.html('下拉显示更多...');
            pullDownEl['class'] = pullDownEl.attr('class');
            pullDownEl.attr('class', '').hide();
            myScroll.refresh();
            loadingStep = 0;
        }, 200); //1秒
    }




    function pullUpAction() {//上拉事件
        setTimeout(function () {
            var el, li, i;
            el = $('#centent_box');
            for (i = 0; i < 3; i++) {
                li = $("<li></li>");
                Upcount++;
                li.text('new Add ' + Upcount + " ！");
                el.append(li);
            }
            pullUpEl.removeClass('loading');
            pullUpL.html('上拉显示更多...');
            pullUpEl['class'] = pullUpEl.attr('class');
            pullUpEl.attr('class', '').hide();
            myScroll.refresh();
            loadingStep = 0;
        }, 200);
    }

    //ajax
    function pullipAjax(){
        setTimeout(function () { 
            var el, li, i;
            el = document.getElementById('centent_box'),
            lis=document.getElementById('main_list_ol').getElementsByTagName('li');
            
            for(var s=0;s<lis.length;s++){
                lis[s].className="";
                
            }
            if(index>2){
                index=0;
            }
            lis[index].className="Borders";
            
            
            //==========================================
            $.ajax({
             type: "GET",
             url: "data/data.json",
             //data: { page: generatedCount },
             dataType: "json",
             success: function (data) {
              var json = data;
                    html="";
              $(json).each(function (index,val) {
                for(var k=0;k<10;k++){
                     html+='<li>'
                        +'<div class="product-item product-item-p">'
                            +'<div class="product-item-img">'
                                +'<a href="mod_menu.html"><img class="image" data-original="__PUBLIC__/image/z.png" src="__PUBLIC__/image/grey.gif" alt=""></a>'
                            +'</div>'
                            +'<div class="product-item_infos ui-ellipsis">'
                                        +'<span><a href="mod_menu.html"><b class="red">VIP网店</b>惠尔佳超市</a></span>'
                                        +'<div class="infos">'
                                            +'<div>'
                                                +'<p>联系电话&nbsp;<a href="tel:18911491054">'+val.fenlei[0].dianhua+'</a></p>'
                                                +'<p>正常营业&nbsp;'+val.fenlei[0].time+'</p>'
                                                +'<p>已售&nbsp;'+val.fenlei[0].yishou+'</p>'
                                            +'</div>'
                                            +'<div style="">'
                                                +'<p><a href="tel:010-847655651">'+val.fenlei[0].dianhua+'</a></p>'
                                                +'<p>配送时间&nbsp;'+val.fenlei[0].time+'</p>'
                                                +'<p>配送费&nbsp;10元</p>'
                                            +'</div>'
                                        +'</div>'
                                    +'</div>'
                                    +'<div class="product-item_mis">'
                                        +'<p><img src="__PUBLIC__/image/location_icon_b.png" alt="">807m</p>'
                                        +'<p>50元起送</p>'
                                    +'</div>'
                                +'</div>'
                      +'</li>'       
                }
                     

               el.innerHTML=html
              
                pullUpEl.removeClass('loading');
                pullUpL.html('上拉显示更多...');
                pullUpEl['class'] = pullUpEl.attr('class');
                pullUpEl.attr('class', '').hide();
                myScroll.refresh();
                loadingStep = 0;


                myScroll.refresh();
                myScroll.scrollTo(0,0,0)
              })
             }
            });
            myScroll.refresh(); 
           }, 1000);  
    }












    function loaded() {
        pullDownEl = $('#pullDown');
        pullDownL = pullDownEl.find('.pullDownLabel');
        pullDownEl['class'] = pullDownEl.attr('class');
        pullDownEl.attr('class', '').hide();

        pullUpEl = $('#pullUp');
        pullUpL = pullUpEl.find('.pullUpLabel');
        pullUpEl['class'] = pullUpEl.attr('class');
        pullUpEl.attr('class', '').hide();
        var lists={
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
        }
        //开始拉动效果
        function Starts() {
               if (loadingStep == 0 && !pullDownEl.attr('class').match('flip|loading') && !pullUpEl.attr('class').match('flip|loading')) {
                    if (this.y < (this.maxScrollY - 5)) {
                       //上拉刷新效果
                       pullUpEl.attr('class', pullUpEl['class'])
                       pullUpEl.show();
                       myScroll.refresh();
                       pullUpEl.addClass('flip');
                       pullUpL.html('正在刷新...');
                       loadingStep = 1;
                   }
               }
           }
        myScroll = new IScroll('#list-product', lists);
        //滚动时
        myScroll.on('scroll',Starts);
        //滚动完毕
        myScroll.on('scrollEnd', function () {
            if (loadingStep == 1) {
                if (pullUpEl.attr('class').match('flip|loading')) {
                    pullUpEl.removeClass('flip').addClass('loading');
                    pullUpL.html('Loading...');
                    loadingStep = 2;
                    pullUpAction();
                    
                  
                }
            }
        });

    }
}