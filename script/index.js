function audioplay(){
    var is_open = 'on', audio_btn = $("#audio_btn");
    if(audio_btn.attr("url").indexOf("mp3")>1){
        var url = audio_btn.attr("url");
        var auto = is_open=='on' ? 'autoplay' : '';
        var html = '<audio loop  src="'+url+'" id="media" '+auto+' ></audio>';
        setTimeout(function(){
            audio_btn.html(html);
            audio_btn.show().attr("class",is_open);
        },500);

        audio_btn.on('touchstart',function(){
            var type = audio_btn.attr("class");
            var media = $("#media").get(0);
            if(type=="on"){
                media.pause();
                audio_btn.attr("class","off");
            }else{
                media.play();
                audio_btn.attr("class","on");
            }
        })
    }
}
window.onload=function(){
    audioplay();
}
function init(){
    var mySwiper = new Swiper('.swiper-container', {
        direction: 'vertical',
        pagination: '.swiper-pagination',
        //virtualTranslate : true,
        mousewheelControl: true,
        onLazyImageLoad: function(swiper, slide, image){
          console.log('延迟加载图片');
        },
        lazyLoading : true,
        onInit: function(swiper) {
            swiperAnimateCache(swiper);
            swiperAnimate(swiper);
        },
        onSlideChangeEnd: function(swiper) {
            swiperAnimate(swiper);
        },
        onTransitionEnd: function(swiper) {
            swiperAnimate(swiper);
        },
        paginationClickable: true,
        paginationClickable: true,
        preloadImages: false,
        lazyLoading: true,
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

}
;(function(){ 
    $('img').lazyload();
    init();
})();