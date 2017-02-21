$(document).ready(function() {
   var myScroll,myScrol2,myScrol3;
    init();
    scores();
    top_roll();
    getajx();
    upDown();
    clicks();
    iscrollAll();
function init(){
    $('.pageview').eq(0).show();
    $('.Boxs>div').eq(0).show();
    $('.uls li').eq(0).addClass("colors").siblings().removeClass("colors");
    $('.mens_details_list a').eq(0).addClass('red');
    var distribution = GetQueryString('distribution');
    distribution?$('#distribution').val(distribution):$('#distribution').val('0');
}
function iscrollAll(){
    myScrol2 = new IScroll('#mens_details_nav', { eventPassthrough: true,scrollX: true, scrollY: false, preventDefault: false });
    myScrol3 = new IScroll('#mens_details_nav2', { eventPassthrough: true,scrollX: true, scrollY: false, preventDefault: false });
}
function clicks(){
    //收藏
    $('.mens_details_img').on(tapClick(),function(){
        judgment_landing();
        var is_fav=$('#is_fav').val();
        var shop_id=$('#shop_id').val();
        if(is_fav == 0){
            commoms.post_server('/Shop/favorite_add',{shop_id:shop_id},function(re){
                loaging.close();
                if(re.result == 'ok'){
                    $('.mens_details_img span').html(re.msg);
                    $('#is_fav').val(1);
                }else{
                    loaging.btn('收藏失败');
                }
            },function(){
                loaging.btn('错误');
            },false);
        }else if(is_fav == 1){
            commoms.post_server('/Shop/favorite_del',{shop_id:shop_id},function(re){
                loaging.close();
                if(re.result == 'ok'){
                    $('.mens_details_img span').html(re.msg);
                    $('#is_fav').val(0);
                }else{
                    loaging.btn('收藏失败');
                }
            },function(){
                loaging.btn('错误');
            },false);
        }
       
    })
function subfun(){
     $.ajax({
          url:'/Address/is_ajax_login',
          type:"post",
          dataType:"json",
          data:{},
          success:function(result){
            loaging.close();
            if(result.result == 'ok'){
                var shop_id=$('#submits').find('a').attr('data-id'),
                    distribution=GetQueryString('distribution');
                if($('.zprice').text() !=0 ){
                    if(distribution == 1){
                        location.href='/Cart/index/shop_id/'+shop_id+'?distribution=1';
                    }else{
                        location.href='/Cart/index/shop_id/'+shop_id+'?distribution=0';
                    }                    
                }else{
                    loaging.prompts('请选择商品');
                }
              }else{
                  location.href='/user/login.html';
                  return false;
              }
          },
          error:function(){
            loaging.close();
          }
        })
}
    $('#submits').on(tapClick(),function(){
        subfun();
    })
    $('#shopping-icons').on(tapClick(),function(){
        subfun();
    })
}
function getajx(){
    var shop_id=$('#shop_id').val();
    commoms.post_servers('/Cart/get_num',{shop_id:shop_id},function(re){
        if(re.result == 'ok'){
            var price = re.data.price;
            $('.shopping-count').show();
            $('.shopping-count').text(re.data.num);
            $('.zprice').text(price.toFixed(2));
        }
    },function(){
        
    },false);
}

function upDown(){ 
    var pullDownEl, pullDownL,
        pullUpEl, pullUpL,
        Downcount = 0, Upcount = 0,
        loadingStep = 0,
        indexs=0,
        shop_id=$('#shop_id').val(),
        navone=$('#mens_details_nav'),
        navtwo=$('#mens_details_nav2'),
        pullUpEl = $('#pullUp');
        pullUpL = pullUpEl.find('.pullUpLabel');
        pullUpEl['class'] = pullUpEl.attr('class');
        pullUpEl.attr('class', '').hide(),
        lists={
            preventDefault:false,
            probeType: 2,
            scrollbars: false,
            mouseWheel: true,
            fadeScrollbars: false,
            bounce: true,
            interactiveScrollbars: true,
            shrinkScrollbars: 'scale',
            click: true,
            keyBindings: true,
            momentum: true
        }
    myScroll = new IScroll('#list-product', lists);
    commoms.post_server('/Category/get_shop_goods',{shop_id:shop_id},function(result){
        loaging.close();
        if(result){
            window.data1=result; 
            lodview(0);
            if(window.sessionstorage){
              sessionStorage.setItem("key", "0");
            }else{
              sessionStorage.setItem("key", "0");
            }
        }
        },function(){

    },false);

var bthA=$('.mens_details_list a'),arr=[];
    bthA.off(tapClick());
    bthA.on(tapClick(),function(){
        loaging.init('加载中，请稍后...');
        $(this).toggleClass('red').siblings().removeClass('red'); 
        var catid=$(this).find('span').attr('cat-id'),
            indexs = $(this).index();
            if(catid-1 == indexs){
                setTimeout(function(){
                    lodview(indexs);
                    sessionStorage.setItem("key", indexs);
            },1000);
        }
        iscrollAll();
    })
function lodview(index){
    var html = "",html2 = "",arr=[],
        obj = window.data1[index];
        shop_id=$('#shop_id').val();
        if(obj.list.length!=0){             
            for(var k=0;k<obj.list.length;k++){
                var soncat = obj.list[k];
                html+='<div class="contents_mains">'
                            +'<h2 class="h'+k+'" data-index="'+k+'">'+soncat.cat_name+'</h2>'
                            +'<div class="contents" id="con'+k+'">' 
                                +'<div id="pageCon" class="match_page masonry">'
                                    +'<ul class="list_box masonry clearfix" id="list_box">'
                for(var i = 0;i < soncat.goods_list.length; i++){
                    var datas=soncat.goods_list[i],pnImg,goods_stockout,act_name,goods_unit,Imgs,Spicy="",goods_pungent="",price_s=0;
                    datas.goods_type == 0?pnImg='<img src="/Public/image/spjb.png" alt="" />':pnImg='';
                    datas.act_name?act_name='<span>'+datas.act_name+'</span>':act_name=datas.act_name='';
                    datas.goods_unit?goods_unit='<p class="goods_unit">'+datas.goods_weight+'/'+datas.goods_unit+'</p>':goods_unit='<p class="goods_unit">'+datas.goods_weight+'</p>';

                    if(datas.goods_original_price == datas.goods_price){
                        price_s = '';
                    }else{
                        price_s = '<s class="price_s">￥<span>'+datas.goods_original_price+'</span></s>';
                    }
                    if( datas.goods_stockout == 1){
                        goods_stockout='<span class="grens">补货中</span>';
                        Imgs='<a href="javascript:void(0);"  class="vote_green">'
                                 +'<img src="/Public/image/JIA.png" alt="">'
                             +'</a>'
                    }else{
                        goods_stockout='';
                        Imgs='<a href="javascript:void(0);"  class="vote">'
                                 +'<img src="/Public/image/addGood.png" alt="">'
                             +'</a>'
                    }
                    if(datas.goods_pungent == '正辣'){
                        Spicy='<img src="/Public/image/pic2_icon.png" alt="" />'
                    }else if (datas.goods_pungent == '微辣') {
                        Spicy='<img src="/Public/image/pic1_icon.png" alt="" />'
                    }else{
                        Spicy="";
                    }
                    datas.goods_pungent?goods_pungent='('+datas.goods_pungent+')':goods_pungent="";
                    html+='<li class="picCon masonry-brick" data-index="'+i+'" goods_id='+datas.goods_id+'>'
                                +'<p class="p1">'+pnImg+'</p>'
                               +'<div class="shops_div">'
                                  +'<a href="/App/detail/shop_id/'+shop_id+'/goods_id/'+datas.goods_id+'" class="img">'
                                     +'<img class="image" src="'+datas.goods_pic+'" onerror="this.src=\'http://www.hahajing.com/userfiles/shop_avatar/_default3.png?ddd\'"/>'
                                     +'<p class="Imgs">'+Spicy+'</p>'
                                  +'</a>'
                                 +'<div class="tou">'
                                     +'<div class="divP">'
                                        +'<h3 class="goods_info">'+datas.goods_name+goods_pungent+'</h3>'
                                        +'<p class="goods_pre">'+act_name+''
                                            +'<eq name="'+datas.goods_stockout+'" value="1">'
                                                +goods_stockout
                                            +'</eq></p>'
                                            +goods_unit
                                        +'<p class="goods_price">￥<span>'+datas.goods_price+'</span></p>'
                                        +price_s
                                     +'</div>'
                                     +Imgs
                                   +'</div>'
                               +'</div>'
                            +'</li>'
                        }
                        html+='</ul>'
                        +'</div> '
                    +'</div>'
                +'</div>'
                html2+='<li><a href="javascript:void(0);" cat-id="'+soncat.son_cat_id+'">'+soncat.cat_name+'</a></li>'
            }
        }else{
            html2+='<li><a href="javascript:void(0);" cat-id="">暂无商品</a></li>'
        }
        $('#centent_box').html(html);
        $('.uls').html(html2);
        myScroll.refresh();
        myScrol2.refresh();
        myScrol3.refresh();
        loaging.close();
      


      var W=$('#mens_details_nav #scroller li').length*95;
            navone.find('#scroller').css({'width':W+'px'});
            navtwo.find('#scroller').css({'width':W+'px'});
           $('#mens_details_nav').find('li').eq(0).addClass('colors');
           $('#mens_details_nav2').find('li').eq(0).addClass('colors');
        
        for(var k=0;k<$('#centent_box .contents_mains').length;k++){
            arr.push($('#centent_box .contents_mains')[k].offsetTop);
        }
        var as = arr.join(',');
        $('#hide_arr').val(as);
        window.heightarr = arr;

        $('.uls li').on('click',function(){
            var index=$(this).index();
            $('#mens_details_nav2').show();
            var scrtop= arr[$(this).index()];
            $('.uls li').eq(index).addClass("colors").siblings().removeClass("colors");
            myScroll.scrollTo(0,-scrtop+50,100);
            myScrol2.refresh();
            myScrol3.refresh();
        })
        $('.list_box li .vote_green').off(tapClick());
        $('.list_box li .vote_green').on(tapClick(),function(){
            loaging.prompts('补货中，敬请期待');
        });
        
        $('.list_box li .vote').off(tapClick());
        $('.list_box li .vote').on(tapClick(),function(){
            judgment_landing();
            var img=$(this).parents('li').find('.img');
            var flyElm = img.clone().css('opacity', 0.8),
                goods_id=$(this).parents('li').attr('goods_id')
            $('body').append(flyElm);
            $('.Imgss').find('img').css({'width':'80px'})
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
                top:$('.pub-cart').offset().top,
                left:$('.pub-cart').offset().left+40,
                width:30,
                height:30
            },500, function() {
               flyElm.remove();
            });
            var num=$('.shopping-count').text(),zong= $('.zprice').text();
            var price=$(this).parents('li').find('.goods_price').find('span').text();
            $.ajax({
                url: '/Cart/add',
                type: 'POST',
                dataType: 'json',
                data: {shop_id:shop_id,goods_id:goods_id},
                success:function(data){
                    if(data.result == 'ok'){
                        $('.shopping-count').show();
                        num++;
                        zong=Number(price)+Number(zong);
                        $('#shopping-count').html(num);
                        $('.zprice').html(zong.toFixed(2));
                    }   
                },error:function(){
                    loaging.bth('添加失败')
                }
            })
        });   
    myScroll.on('scrollStart', function () {
        if(this.y <= -(arr[0])){
            $('#mens_details_nav2').show();
          
        }else{
            $('#mens_details_nav2').hide();
          
        }
    })
    myScroll.on('scroll',Starts);
    myScroll.on('scrollEnd', Ends);
    function Starts() {
        if(this.y <= -(arr[0])){
            $('#mens_details_nav2').show();
          
        }else{
            $('#mens_details_nav2').hide(); 
        }
        for(var j=0; j<arr.length; j++){
            var k=-(arr[j]);
             if(this.y <= k){
                  $('.mens_details_nav li').eq(j).addClass("colors").siblings().removeClass("colors");
            };                
         };
         if (loadingStep == 0 && !pullUpEl.attr('class').match('flip|loading')) {
             if (this.y < (this.maxScrollY - 5)) {
                pullUpEl.attr('class', pullUpEl['class'])
                pullUpEl.show();
                pullUpEl.addClass('flip');
                pullUpL.html('加载中...');
                loadingStep = 1;
             }
         }
    }
    function Ends(){
        if(this.y <= -(arr[0])){
            $('#mens_details_nav2').show();
        }else{
            $('#mens_details_nav2').hide();
        }
        if (loadingStep == 1) {
            if (pullUpEl.attr('class').match('flip|loading')) {
                pullUpEl.removeClass('flip').addClass('loading');
                pullUpL.html('请稍后...');
                loadingStep = 2;                
                pullipAjax();
            }
        }
    }
}
    function pullipAjax(){
        loaging.init('加载中，请稍后...');
       var idx = sessionStorage.getItem('key');
        idx++;
        sessionStorage.setItem("key",idx);
        if(idx>7){
            idx=0;
            sessionStorage.setItem("key",'0');
        }
        setTimeout(function(){
            lodview(idx);
            $('.mens_details_list a').eq(idx).toggleClass('red').siblings().removeClass('red'); 
        },1000);
        pullUpEl.removeClass('loading');
        pullUpL.html('上拉显示更多...');
        pullUpEl['class'] = pullUpEl.attr('class');
        pullUpEl.attr('class', '').hide();
        myScroll.refresh();
        myScroll.scrollTo(0,-550,0)
        loadingStep = 0;  
    }    
}

});