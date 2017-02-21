$(function(){
	function post_server(url,option,callback,errorfn,asyncType){
    	var async=asyncType?asyncType:true;
	    $.ajax({
	      url:url,
	      type:"post",
	      dataType:"json",
	      data:option,
	      async:async,
	      beforeSend:function(){
	        loaging.init('加载中...');
	      },
	      success:function(rs){
	        loaging.close();
	        if($.isFunction(callback)) callback(rs);
	      },
	      error:function(){
	        loaging.close();
	        errorfn();
	      }
	    })
  }
    function judgment_landing(){
      $.ajax({
        url:'/Address/is_ajax_login',
        type:"post",
        dataType:"json",
        data:{},
        success:function(result){
          loaging.close();
          if(result.result == 'ok'){
                layer.closeAll();
            }else{
                location.href='/user/login.html';
                return false;
            }
        },
        error:function(){
          loaging.close();
          loaging.btn('登陆失败，请重试');
        }
      })


  }
  var loaging={
   //初始
    init:function(txt){
      var index=layer.open({
            content:'<p class="center">'+txt+'</p>',
            style: 'border:none;text-align:center;line-height:50px;',
            shadeClose: false,
            type:2
        });
    }, //提示
    btn:function(txt){
    var index=layer.open({
            content:'<p class="center">'+txt+'</p>',
            style: 'border:none;text-align:center;line-height:50px;margin-top:-25%;',
            shadeClose: false,
            btn: ['确认']
        });
    },
    close:function(names){
       layer.closeAll();
    }
  }
	var lens=$('.swiper1').find('div').length/2;
	if(lens>=1){
		var swiper = new Swiper('.swiper-container', {
			pagination: '.swiper-pagination',
			slidesPerView: 1,
			paginationClickable: true,
			spaceBetween: 0,
			loop: true,
			autoplay: 2500,
			autoplayDisableOnInteraction: false
		});
	}
	clicks();
	function clicks(){
		var goods_id=$('#goods_id').val();
        var cart_id=$('#shop_id').val();
        var counts = $('.goods_vals').val()*1;
        var prices = $('.prod-price b').text();
        $('.goods_add').off('click');
		$('.goods_add').on('click',function(){
            judgment_landing();
            post_server('/Cart/add',{shop_id:cart_id,goods_id:goods_id},function(data){
              loaging.close();
              if(data.result == 'ok'){
                 counts+=1;
                 var zongj = prices * counts;
                 var tos = zongj.toFixed(2);
                 $('.goods_vals').val(counts);
                 $('.carts_box span').text(counts);
                 $('.cartPrices').text(tos);
              }else{
              	loaging.btn('加入购物车失败');
              }
              },function(){
              	loaging.btn('加入失败');
            },false);
            
        })
      $('.goods_del').off('click');
      $('.goods_del').on('click',function(){
        judgment_landing();
              if(counts == 0){
                  return false;    
              }
              post_server('/Cart/del',{cart_id:cart_id,shop_id:''},function(data){
                  if(data.result == 'ok'){
                    counts-=1;
                     $('.goods_vals').val(counts);
                     $('.carts_box span').text(counts);
                     var zongj = prices * counts;
                     var tos = zongj.toFixed(2);
                     $('.goods_vals').val(counts);
                     $('.carts_box span').text(counts);
                     $('.cartPrices').text(tos);
                  }else{
                  	loaging.btn('加入购物车失败');
                  }
                  },function(){
                      loaging.btn('加入失败');
              },false);
              
      })
      $('.carts_box').on('click',function(){
        judgment_landing();
        setTimeout(function(){
          var shopId=$('#shop_id').val();
          window.location.href='/Cart/index/shop_id/'+shopId;
        },500)
        
      })
	}
})