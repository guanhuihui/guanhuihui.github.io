function setInter_time(){
     audioplay();
     var htmls = ' <div class="swiper-container"><div class="swiper-wrapper"><section class="swiper-slide swiper-slide1"><div class="ani img1 resize ui-autos" swiper-animate-effect="zoomIns"></div><div class="ani img2 resize ui-autos" swiper-animate-effect="zoomIns" swiper-animate-delay="1s"></div><img data-src="images/s1_pic3.png" class="swiper-lazy ani resize slide1_img3" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="0.3s"><img data-src="images/s1_pic4.png" class="swiper-lazy ani resize slide1_img4" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="0.6s"><img data-src="images/s1_pic5.png" class="swiper-lazy ani resize slide1_img5" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s" swiper-animate-delay="0.9s"><img data-src="images/s1_pic6.png" class="swiper-lazy ani resize slide1_img6" swiper-animate-effect="bounceIn" swiper-animate-duration="1s" swiper-animate-delay="1.7s"></section><section class="swiper-slide swiper-slide2"></section><section class="swiper-slide swiper-slide3"></section><section class="swiper-slide swiper-slide4"></section><section class="swiper-slide swiper-slide5"></section><section class="swiper-slide swiper-slide6"></section><section class="swiper-slide swiper-slide7"></section><section class="swiper-slide swiper-slide5 swiper-slide8"></section><section class="swiper-slide swiper-slide9"> </section><section class="swiper-slide swiper-slide10"></section><section class="swiper-slide swiper-slide11"></section><section class="swiper-slide swiper-slide5 swiper-slide8 swiper-slide12"></section><section class="swiper-slide swiper-slide13"></section><section class="swiper-slide swiper-slide14"></section><section class="swiper-slide swiper-slide15"></section><section class="swiper-slide swiper-slide16"></section><section class="swiper-slide swiper-slide17"></section><section class="swiper-slide swiper-slide19"></section><section class="swiper-slide swiper-slide18"></section></div><img src="images/arrow.png" id="array" class="resize"><div class="swiper-pagination" style="display:none;"></div></div>';
         $('body').append(htmls);
    var step_funs = 0, i=0,
        logImg = $('.logImg'),
        loaging = $('.loaging'),timer;
        timer = setInterval(function(){
            if(i>=100){
                //更该页面
                clearInterval(timer);
               /* logImg.find(".p1span img").css({"-webkit-animation":'none',"animation":'none'});*/
                loaging.hide();
                aa();
                return false;
            } 
        i+=2;
        logImg.find(".p1").css("width",i+"%");
        logImg.find(".p1span").css("left",i-8+"%");
        logImg.find(".num").html(i+"%");       
    },300);
}

document.addEventListener('DOMContentLoaded', function() {
    function audioAutoPlay() {
        var audio = document.getElementById('media');
        audio.play();
        document.addEventListener("WeixinJSBridgeReady", function() {
        audio.play();
        }, false);
    }
    audioAutoPlay();
}); 

function aa(){
    $('img').lazyload();
    //<img src="images/1.png" class="ani resize ui-autos" swiper-animate-effect="zoomIns" ><img src="images/2.png" class="ani resize ui-autos" swiper-animate-effect="zoomIns" swiper-animate-delay="1s">
    init();
}
function audioplay(){
    var is_open = 'on', audio_btn = $("#audio_btn");
    var flag = true;
    var url = audio_btn.attr("url");
    // var auto = is_open=='on' ? 'autoplay' : '';
    var html = '<audio loop="loop" id="media" class="is_open" autoplay="autoplay"  src="'+url+'" ></audio>';
    audio_btn.html(html);
    //audio_btn.show().attr("class",is_open);
    audio_btn.on('touchstart',function(){
        var type = audio_btn.attr("class");
        var media = $("#media").get(0);
        if(flag == true){
            media.pause();
            audio_btn.attr("class","off");
            flag = false;
        }else if(flag == false){
            media.play();
            audio_btn.attr("class","on");
            flag = true;
        }
    })
    if(audio_btn.attr("url").indexOf("mp3")>1){
        // var url = audio_btn.attr("url");
        // var auto = is_open=='on' ? 'autoplay' : '';
        // var html = '<audio loop  src="'+url+'" id="media" '+auto+' ></audio>';
        // setTimeout(function(){
        //     audio_btn.html(html);
        //     audio_btn.show().attr("class",is_open);
        // },500);
        // audio_btn.on('touchstart',function(){
        //     var type = audio_btn.attr("class");
        //     var media = $("#media").get(0);
        //     if(type=="on"){
        //         media.pause();
        //         audio_btn.attr("class","off");
        //     }else{
        //         media.play();
        //         audio_btn.attr("class","on");
        //     }
        // })
    }
}
window.onload=function(){
}
var index = 2;
function init(){
    var mySwiper = new Swiper('.swiper-container', {
        direction: 'vertical',
        pagination: '.swiper-pagination',
        //virtualTranslate : true,
        mousewheelControl: true,
        paginationClickable: true,
        paginationClickable: true,
        preloadImages: false,
        lazyLoading: true,
        lazyLoadingInPrevNext : true,
        updateOnImagesReady: true,
        onLazyImageLoad: function(swiper, slide, image){
          //console.log('延迟加载图片');
          swiperAnimate(swiper);
        },
        onImagesReady: function(swiper){
          //alert('事件触发了;');
        },
        onInit: function(swiper) {
            swiperAnimateCache(swiper);
            swiperAnimate(swiper);
        },
        onSlideChangeStart: function(swiper){
            // if(mySwiper.activeIndex == 2){
            //     var Nums = mySwiper.activeIndex *1 +2;
            //     // var Infos = getInfos(mySwiper.activeIndex);
            //     console.log($('.swiper-slide'+Nums));
            // }
            getInfos(mySwiper.activeIndex);
        },
        onSlideChangeEnd: function(swiper) {
            swiperAnimate(swiper);
        },
        onTransitionEnd: function(swiper) {
            swiperAnimate(swiper);
        },
        onProgress: function(swiper) {
            // for (var i = 0; i < swiper.slides.length; i++) {
            //     var slide = swiper.slides[i];
            //     var progress = slide.progress;
            //     var translate = progress * swiper.height / 4;
            //     scale = 1 - Math.min(Math.abs(progress * 0.5), 1);
            //     var opacity = 1 - Math.min(Math.abs(progress / 2), 0.5);
            //     slide.style.opacity = opacity;
            //     es = slide.style;
            //     es.webkitTransform = es.MsTransform = es.msTransform = es.MozTransform = es.OTransform = es.transform = 'translate3d(0,' + translate + 'px,-' + translate + 'px) scaleY(' + scale + ')';
            // }
        },
        onSetTransition: function(swiper, speed) {
        }

    });
    function getInfos(num){
        var html = "";
        if(num == 1){
            var html0 ='<img data-src="images/s2_pic1.jpg" class="swiper-lazy s2_img1"><div class="cans"><img data-src="images/s2_pic2.jpg" class="swiper-lazy slide2_img1"><span class="ani canspan resize" swiper-animate-effect="canspanInLeft" swiper-animate-duration="1.8s" swiper-animate-delay="0.6s"></span></div><img data-src="images/s2_pic3.jpg" class="swiper-lazy ui-auto slide2_img2">';
                $('.swiper-slide2').html(html0); 
        }else if(num === 2){
            var html ='<img data-src="images/s3_pic2.png" class="swiper-lazy s3_img1"><img data-src="images/s3_pic1.png" class="swiper-lazy ani resize s3_img2" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="0.3s"><img data-src="images/s3_pic3.jpg" class="swiper-lazy ani resize s3_img3" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="0.3s"><img data-src="images/s3_pic4.png" class="swiper-lazy ani resize s3_img4" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="1.3s"><img data-src="images/s3_pic5.png" class="swiper-lazy ani resize s3_img5" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="1.3s"><img data-src="images/s3_pic6.png" class="swiper-lazy ani resize s3_img6" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="2.3s"><img data-src="images/s3_pic7.png" class="swiper-lazy ani resize s3_img7" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="2.3s">';
                $('.swiper-slide3').html(html); 
            var html1 ='<img data-src="images/s4_pic4.jpg" class="swiper-lazy slide4_img4"><div class="s4"><img data-src="images/s4_pic1.png" class="swiper-lazy ani resize slide4_img1" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="0.2s"><img data-src="images/s4_pic2.png" class="swiper-lazy ani resize slide4_img2" swiper-animate-effect="fadeInDown" swiper-animate-duration="1s" swiper-animate-delay="1.5s"><img data-src="images/s4_pic3.png" class="swiper-lazy ani resize slide4_img3" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s" swiper-animate-delay="0.2s"></div> ';
                $('.swiper-slide4').html(html1); 
        }else if(num === 3){
            var html2 ='<img data-src="images/s5_pic3.png" class="swiper-lazy ui-auto slide5_img3"><img data-src="images/s5_pic1.png" class="swiper-lazy ani resize slide5_img1" swiper-animate-effect="zoomInS" swiper-animate-delay="0s"><div class="ani resize slide5_size2"><div class="ani resize s5_div" swiper-animate-effect="height_over"><img data-src="images/s5_pic4.png" class="swiper-lazy ani resize slide5_img4 ui-auto"></div></div><img data-src="images/s5_pic2.png" class="swiper-lazy ani resize slide5_img2" swiper-animate-effect="zoomInS" swiper-animate-delay="0s">';
                $('.swiper-slide5').html(html2);
            var html3 ='<div class="s6_div"><img data-src="images/s6_img3.png" class="swiper-lazy ui-auto s6_img1" alt=""><div class="s6_div1"><img data-src="images/s6_pic1.png" class="swiper-lazy ani resize s6_img2" swiper-animate-effect="mohu" swiper-animate-duration="2s" swiper-animate-delay="0.4s"></div><div class="s6_div2"><div class="s6_left"><img data-src="images/s6_img4.png" class="swiper-lazy ani resize s6_img3" swiper-animate-effect="mohu" swiper-animate-duration="2s" swiper-animate-delay="0.4s"><img data-src="images/s6_img5.png" class="swiper-lazy ani s6_img4"></div><div class="s6_right"><img data-src="images/s6_img6.png" class="swiper-lazy ani resize s6_img5" swiper-animate-effect="mohu" swiper-animate-duration="2s" swiper-animate-delay="0.4s"><img data-src="images/s6_img7.png" class="swiper-lazy ani s6_img6"></div></div></div>';
                $('.swiper-slide6').html(html3); 
        }else if(num === 4){
            var html4 ='<div class="s7_div"><img data-src="images/s7_pic1.png" class="swiper-lazy ui-auto s7_img1" /><div class="s7_div1"><div class="s71_left"><img data-src="images/s7_pic2.png" class="swiper-lazy ani resize s7_img2" swiper-animate-effect="mohu" swiper-animate-duration="2s" swiper-animate-delay="0.4s"><img data-src="images/s7_pic6.png" class="swiper-lazy ani s7_img3"></div><div class="s71_right"><img data-src="images/s7_pic3.png" class="swiper-lazy ani resize s7_img4" swiper-animate-effect="mohu" swiper-animate-duration="2s" swiper-animate-delay="0.4s"></div></div><div class="s7_div2"><div class="s71_left"><img data-src="images/s7_pic4.png" class="swiper-lazy ani resize s7_img5" swiper-animate-effect="mohu" swiper-animate-duration="2s" swiper-animate-delay="0.4s"><img data-src="images/s7_pic7.png" class="swiper-lazy ani s7_img6"></div><div class="s71_left"><img data-src="images/s7_pic5.png" class="swiper-lazy ani resize s7_img7" swiper-animate-effect="mohu" swiper-animate-duration="2s" swiper-animate-delay="0.4s"><img data-src="images/s7_pic8.png" class="swiper-lazy ani s7_img8"></div></div></div>';
                $('.swiper-slide7').html(html4);
            var html5 ='<img data-src="images/s8_pic6.png" class="swiper-lazy ui-auto slide5_img3"><div class="ani resize slide8_size2"><div class="ani resize s5_div" swiper-animate-effect="height_over"><img data-src="images/s8_pic5.png" class="swiper-lazy ani resize slide5_img4 ui-auto"></div></div><div class="s8"><img data-src="images/s8_pic1.png" class="swiper-lazy s8img ui-autos"><img data-src="images/s8_pic2.png" class="swiper-lazy ani resize s8img2" swiper-animate-effect="fadeInUp" swiper-animate-delay="0.3s"><img data-src="images/s8_pic3.png" class="swiper-lazy ani resize s8img3" swiper-animate-effect="fadeInUp"  swiper-animate-delay="1.3s"><img data-src="images/s8_pic4.png" class="swiper-lazy ani resizes s8img4" swiper-animate-effect="fadeInUp"  swiper-animate-delay="0.9s"></div>';
                $('.swiper-slide8').html(html5);
        }else if(num === 5){
            var html6 ='<img data-src="images/s9_pic1.png" class="swiper-lazy ui-auto s9_img1" alt=""><div class="s9_div"><div class="s9_divspan2"><span class="ani resize s9_divspan" swiper-animate-effect="fadeInRightss" swiper-animate-duration="3s" swiper-animate-delay="0s"></span></div><img data-src="images/s9_pic2.png" class="swiper-lazy ui-auto s9_img2" alt=""></div>';
                $('.swiper-slide9').html(html6);
            var html7 ='<div class="s10_div"><div class="s10_div1"><img data-src="images/s10_pic1.png" class="swiper-lazy ani resize s10_img1 s10_img11" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="0s"><img data-src="images/s10_pic2.png" class="swiper-lazy ani resize s10_img1 s10_img12" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="0.6s"><img data-src="images/s10_pic3.png" class="swiper-lazy ani resize s10_img1 s10_img13" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1.2s"><img data-src="images/s10_pic4.png" class="swiper-lazy ani resize s10_img1 s10_img14" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1.8s"><img data-src="images/s10_pic5.png" class="swiper-lazy ani resize s10_img1 s10_img15" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="2.4s"></div><img data-src="images/s10_pic11.png" class="swiper-lazy ui-auto" alt=""><div class="s10_div2"><img data-src="images/s10_pic6.png" class="swiper-lazy ani resize s10_img1 s10_img11" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="0s"><img data-src="images/s10_pic7.png" class="swiper-lazy ani resize s10_img1 s10_img12" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="0.6s"><img data-src="images/s10_pic9.png" class="swiper-lazy ani resize s10_img1 s10_img13" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1.2s"><img data-src="images/s10_pic8.png" class="swiper-lazy ani resize s10_img1 s10_img14" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="1.8s"><img data-src="images/s10_pic9.png" class="swiper-lazy ani resize s10_img1 s10_img15" swiper-animate-effect="fadeInLeft" swiper-animate-duration="1s" swiper-animate-delay="2.4s"></div><div class="s10_div3"><img data-src="images/s10_pic12.png" class="swiper-lazy ani resize ui-auto" swiper-animate-effect="fadeInUp" swiper-animate-duration="1s" swiper-animate-delay="3s"><div></div>';
                $('.swiper-slide10').html(html7);
        }else if(num === 6){
            var html8 ='<img data-src="images/s11_pic4.jpg" alt="" class="swiper-lazy s11_img3"><div class="s11_div"><img data-src="images/s11_pic1.png" class="swiper-lazy ani resize s11_img1 ui-auto" swiper-animate-effect="s11_rotate" swiper-animate-duration="35s"><img data-src="images/s11_pic2.png" class="swiper-lazy ani resize s11_img2"></div>';
                $('.swiper-slide11').html(html8);
            var html9 ='<img data-src="images/yz.gif" alt="" class="swiper-lazy ui-auto slide5_img5"><img data-src="images/s12_pic1.png" class="swiper-lazy ui-auto slide5_img3"><div class="ani resize slide8_size2"><div class="ani resize s5_div" swiper-animate-effect="height_over"><img data-src="images/s12_pic2.png" class="swiper-lazy ani resize slide5_img4 ui-auto"></div></div>';
                $('.swiper-slide12').html(html9);
        }else if(num === 7){
            var html10 ='<img data-src="images/s13_img2.jpg" class="swiper-lazy ui-autos" alt=""><img data-src="images/s13_pic1.png" class="swiper-lazy ani resize s13_img1" alt="" swiper-animate-effect="STAR-MOVE" swiper-animate-duration="10s" swiper-animate-delay="0s"><img data-src="images/s13_pic1.png" class="swiper-lazy ani resize s13_img2" alt="" swiper-animate-effect="STAR-MOVE" swiper-animate-duration="10s" swiper-animate-delay="0s"><img data-src="images/s13_pic1.png" class="swiper-lazy ani resize s13_img3" alt="" swiper-animate-effect="STAR-MOVE" swiper-animate-duration="10s" swiper-animate-delay="0s"><img data-src="images/s13_pic2.png" class="swiper-lazy ani resize s13_img4" alt="" swiper-animate-effect="STAR-MOVE" swiper-animate-duration="10s" swiper-animate-delay="0s"><img data-src="images/s13_pic2.png" class="swiper-lazy ani resize s13_img5" alt="" swiper-animate-effect="STAR-MOVE" swiper-animate-duration="10s" swiper-animate-delay="0s">';
                $('.swiper-slide13').html(html10);
            var html11 ='<img data-src="images/14_1.gif" class="swiper-lazy ui-autos" alt="">';
                $('.swiper-slide14').html(html11);
        }else if(num === 8){
            var html12 ='<img data-src="images/s15_img1.jpg" alt="" class="swiper-lazy s15_img1"><div class="sky"><div class="clouds_one"></div><div class="clouds_two"></div></div>';
                $('.swiper-slide15').html(html12);
            var html13 ='<img data-src="images/s16_img1.png" alt="" class="swiper-lazy s16_img1"><div class="s15_div1"><img data-src="images/s16_img2.png" class="swiper-lazy ui-auto s16_img2" alt=""><img data-src="images/s16_img3.png" class="swiper-lazy ani resize s16_img3" alt="" swiper-animate-effect="shakes" swiper-animate-duration="1.5s" swiper-animate-delay="0s"></div><div class="s15_div2"><img data-src="images/s16_img4.png" class="swiper-lazy ui-auto s16_img2" alt=""><img data-src="images/s16_img5.png" class="swiper-lazy ani resize s16_img4" alt="" swiper-animate-effect="shakes" swiper-animate-duration="1.5s" swiper-animate-delay="0.3s"></div>';
                $('.swiper-slide16').html(html13);
        }else if(num === 9){
            var html14 ='<ul class="listimg"><li class="liimg"><img data-src="images/s17_img1.jpg" class="swiper-lazy s17_img1 s17i1" alt=""><img data-src="images/s17_img2.jpg" class="swiper-lazy s17_img1 s17i2" alt=""><img data-src="images/s17_img3.jpg" class="swiper-lazy s17_img1 s17i3" alt=""></li><li class="liimg"><img data-src="images/s17_img4.jpg" class="swiper-lazy s17_img2 s17i4" alt=""><img data-src="images/s17_img5.jpg" class="swiper-lazy s17_img2 s17i5" alt=""><img data-src="images/s17_img6.jpg" class="swiper-lazy s17_img2 s17i6" alt=""></li><li class="liimg"><img data-src="images/s17_img4.jpg" class="swiper-lazy s17_img2 s17i7" alt=""><img data-src="images/s17_img5.jpg" class="swiper-lazy s17_img2 s17i8" alt=""><img data-src="images/s17_img6.jpg" class="swiper-lazy s17_img2 s17i9" alt=""></li><li class="liimg"><img data-src="images/s17_img4.jpg" class="swiper-lazy s17_img2 s17i10" alt=""><img data-src="images/s17_img5.jpg" class="swiper-lazy s17_img2 s17i11" alt=""><img data-src="images/s17_img6.jpg" class="swiper-lazy s17_img2 s17i12" alt=""></li><li class="liimg"><img data-src="images/s17_img4.jpg" class="swiper-lazy s17_img2 s17i13" alt=""><img data-src="images/s17_img5.jpg" class="swiper-lazy s17_img2 s17i14" alt=""><img data-src="images/s17_img6.jpg" class="swiper-lazy s17_img2 s17i15" alt=""></li></ul>';
                $('.swiper-slide17').html(html14);
            var html16 ='<img data-src="images/s19_img1.jpg" alt="" class="swiper-lazy ui-autos">';
                $('.swiper-slide19').html(html16);
            var html15 ='<img data-src="images/s18_img1.jpg" alt="" class="swiper-lazy ui-autos"><div class="s18_div"><a class="ani resize s18_span" swiper-animate-effect="shake" swiper-animate-duration="1s" swiper-animate-delay="0.6s" href="http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzI2MjYxMzg2MQ==&shelf_id=1&showwxpaytitle=1#wechat_redirect">点击购买</a></div>';
                $('.swiper-slide18').html(html15);
        }
        
    }
}
;(function(){ 
    setInter_time();
})();