   // $(function(){   
    //     return false;
        // function tapClick(){
        //     return "ontouchstart" in document ? "tap" : "click";
        // }

        // var fla = true,
        //     audio_btn = $('#audio_btn'),
        //     audio = $("#media")[0];

        //     audio_btn.on('click',function(){
        //         var that = $(this);
        //         if(fla == true){
        //             audio.pause();
        //             fla = false;
        //             that.addClass('off');
        //         }else if(fla == false){
        //             audio.play(); 
        //             fla = true; 
        //             that.removeClass('off');
        //         }
        //     });

            // var qic = $('.page_img2');
            // qic.on('click',function(){
            //     $('.swiper-pagination1 span').eq(1).click();
            //     setTimeout(function(){
            //         $('.sec_common2').css('opacity','1');
            //     },1000);
            // });

            // var swiperH = new Swiper('.swiper-container.swiper-container-h', {
            //     pagination: '.swiper-pagination.swiper-pagination1',
            //     paginationClickable: true,
            //     noSwiping : true,
            //     effect : 'fade',
            //     nextButton: '.swiper-button-next',
            //     prevButton: '.swiper-button-prev',
            //     onTouchStart: function(swiper,even){
            //         //console.log(swiper.activeIndex);  

            //         // if(swiper.activeIndex == 0){
            //         //     return false;
            //         // }   
            //         // a =  even.changedTouches[0].clientX;
            //         // console.log(a);
            //     },
            //     onTouchMove: function(swiper,even){
            //         // console.log(even.touches[0].clientX)
            //         // console.log(even.changedTouches[0].clientX);
            //         // console.log(even);

            //       //你的事件
            //     },onTouchEnd:function(swiper,even){
            //         setTimeout(function(){
            //             $('.sec_common2').css('opacity','1');
            //         },1000);
            //     }

            // });
      
            // var start_x,move_x,end_x,ins = 0,//ins = 0
            //     flag = true;

            // $('#page2').on('touchstart',function(e) {
            //     $('.sec_common2').css('opacity','0');
            //     var _touch = e.originalEvent.targetTouches[0]; 
            //     start_x = _touch.pageX;

            //     //console.log(_x);
            // });
            // var is = 0;
            // $('#page2').on('touchmove',function(e) {
            //     var _touch = e.originalEvent.targetTouches[0]; 
            //     move_x = _touch.pageX;
            //     if(ins == 0){
            //   is++;
            //   $('.page2_img img').css({
            //             '-webkit-transform':'rotate('+is+'deg)',
            //             '-moz-transform':'rotate('+is+'deg)',
            //             'transform':'rotate('+is+'deg)'
            //         });

            //     var moveX = move_x-200;
            //     // console.log(_x);

            //         if(start_x < 120){

            //         }
            //         $('.sec_Img').css({'-webkit-transform':'translate3d('+(move_x*1+80)+'px,0,0)','transform':'translate3d('+(move_x*1+80)+'px,0,0)'});

            //         $('.sec1_img5').css({'-webkit-transform':'translateX('+moveX+'px)','transform':'translateX('+moveX+'px)'})
            //     }


            // });

            // $('#page2').on('touchend',function(e) {
                
            //     if(flag == false){
            //         return false;
            //     }

            //     $('.sec_Img').hide();
            //     var _touch = e.originalEvent.changedTouches[0]; 
            //     end_x =  _touch.pageX;
               
            //     var Calculation_x = move_x - start_x;
                
            //     if(Calculation_x > 0){
            //        // console.log('向左');
            //         ins++;
            //         console.log(ins+'--------------------------------');
            //         var deg = ins * 72;

            //             if(ins >= 4){
            //                // $('.swiper-pagination1 span').eq(2).click();
            //                 $('.swiper-pagination1 span').eq(1).click();
            //                 $('.sec_common2').css('opacity','0');

            //                 swiperH.destroy(false);
            //                 return false;
            //             }
                        
            //         $('.page2_img img').css({
            //             '-webkit-transform':'rotate('+deg+'deg)',
            //             '-moz-transform':'rotate('+deg+'deg)',
            //             'transform':'rotate('+deg+'deg)'
            //         });



            //         flag = false;

            //         setTimeout(function(){
            //             flag = true;
            //             $('.sec_common2').css('opacity','1');
            //             if(ins == 1){

            //             }else if(ins == 2){
            //                 $('.sec1').css('opacity','0');
            //                 $('.sec2').css('opacity','1');

                           

            //             }else if(ins == 3){
            //                 $('.sec2').css('opacity','0');
            //                 $('.sec3').css('opacity','1');
            //             }             
            //         },1300);
            //     }
            // });

            // $('button').on('tap',function(){
            //     $('.swiper-pagination1 span').eq(2).click();
            // });



            // var swiperV = new Swiper('.swiper-container.swiper-container-v', {
            //     pagination: '.swiper-pagination.swiper-pagination2',
            //     paginationClickable: true,
            //     direction: 'vertical',
            //     spaceBetween: 0 ,
            //     onInit: function(swiper){ //Swiper2.x的初始化是onFirstInit
            //       swiperAnimateCache(swiper); //隐藏动画元素 
            //       swiperAnimate(swiper); //初始化完成开始动画
            //     }, 
            //     onSlideChangeEnd: function(swiper){ 
            //       swiperAnimate(swiper); //每个slide切换结束时也运行当前slide动画
            //     },
            //     onTouchStart: function(swiper,even){
            //       console.log(swiper.activeIndex)
            //         //console.log(swiper.activeIndex);  
            //         // if(swiper.activeIndex == 0){
            //         //     return false;
            //         // }   
            //         // a =  even.changedTouches[0].clientX;
            //         // console.log(a);
            //     },
            //     onTouchMove: function(swiper,even){
            //         // console.log(even.touches[0].clientX)
            //         // console.log(even.changedTouches[0].clientX);
            //         // console.log(even);
            //       //你的事件
            //     },onTouchEnd:function(swiper,even){
                    
            //     },onSlideChangeStart: function(swiper){

            //     }
            // });
        


