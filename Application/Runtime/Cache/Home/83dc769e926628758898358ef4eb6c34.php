<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜便捷购</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <script type=text/javascript>
	var docElement = document.documentElement;
	var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;
	docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';
</script>
<link rel="stylesheet" href="/Public/css/style.css">
<script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script>
<script type="text/javascript" src="/Public/js/lib/fastclick.js"></script>
</head>
<body>
  <div class="mod-mask" id="mod-mask" style="display:block;">
     <div class="logoarea">
         <div class="logo"></div>
         <div class="location">
             <div class="location-blink"></div>
         </div>
         <div class="location-text">正在定位···</div>
     </div>
  </div>
  <div id="allmap"></div>
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=wqBXfIN3HkpM1AHKWujjCdsi"></script> 
<!--加载header公共底部导航-->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?c2d2766f7586737e9c94a580840a7bfd";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<script src="/Public/js/lib/all.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
    $(document).ready(function() {
      common.geolocation(); 
    });
    
     /* var city='北京',
          district='东城区',
          street='东直门内大街',
          streetNumber='6-5号',
          cityCode=131,
          s=39.946525076484,
          k=116.43688920825;
        $.ajax({  
            url:'/Index/getXY', 
            type: 'GET',   
            data: {x:k,y:s,district:city+district+street+streetNumber,city_id:cityCode},
            success:function(result) {
               loaging.close();
               location.href='/Index/index.html';
            },error:function(XMLHttpRequest, textStatus, errorThrown){
              loaging.close();
              loaging.btn('定位失败，请刷新重试'); 
            }   
        });*/
    function jsonpCallbacks(data){
        if(data){
            var addComp = data.result,
                city=addComp.addressComponent.city,
                district=addComp.addressComponent.district,
                street=addComp.addressComponent.street,
                streetNumber=addComp.addressComponent.street_number,
                cityCode=addComp.cityCode,
                s=addComp.location.lat,
                k=addComp.location.lng;
              $.ajax({  
                  url:'/Index/getXY', 
                  type: 'GET',   
                  data: {x:k,y:s,district:city+district+street+streetNumber,city_id:cityCode},
                  success:function(result) {
                    $('.layermcont .center').html('跳转中，请稍后...');
                    //如果有优惠券跳转优惠券页面
                    $.ajax({
                      url: '/Load/get_can_use',
                      type: 'POST',
                      success:function(resultss){
                        var re = JSON.parse(resultss);
                        if(re.result == 'ok'){
                          window.location.href='/Coupon/index';
                        }else{
                          window.location.href='/Index/index';
                        }
                      },error:function(){

                      }
                    });                     
                  },error:function(XMLHttpRequest, textStatus, errorThrown){
                    loaging.close();
                    loaging.btn('定位失败，请刷新重试');
                  }   
              });
        }    
    }
</script>
</body>
</html>