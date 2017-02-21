<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜便捷购</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
  <!--<script type=text/javascript>//var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';</script>-->
<script>(function(){var calc = function(){var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';};calc();window.addEventListener('resize',calc);})();</script> <link rel="stylesheet" href="/Public/css/style.css"><script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script><script type="text/javascript" src="/Public/js/lib/fastclick.js"></script>
</head>
<body>
  <div id="mod-container" class="mod-container clearfix">
      <div id="mod-message" class="mod-message" >
          <header class="pub-header">
              <a class="tap-action icon icon-back" data-tap="!back" href="/Index/index"></a>
              <div class="header-content ">
                  <div class="head_box">
                      <p>系统消息</p>
                      <p>用户消息</p>
                  </div>
              </div>
          </header>
          <div class="main main-top" style="overflow: hidden;bottom:0px;">
              <div id="list-product-state" class="list-product-state">
                  <div class="list-main">
                      <div class="list-state-one" id="list-state-one">
                          <div class="scrollers">
                            <?php if(is_array($message_data)): foreach($message_data as $key=>$vo): ?><div class="message_s">
                                 <h2><?php echo ($vo["title"]); ?></h2>
                                 <p><?php echo ($vo["sendtime"]); ?></p>
                                 <div>
                                     <?php echo ($vo["content"]); ?>
                                 </div>
                             </div><?php endforeach; endif; ?>
                          </div>
                      </div>
                      <div class="list-state-two" id="list-state-two">
                          <div class="scrollers">
                            <?php if(is_array($MeMessage_data)): foreach($MeMessage_data as $key=>$vo): ?><div class="message_s">
                                 <h2><?php echo ($vo["title"]); ?></h2>
                                 <p><?php echo ($vo["sendtime"]); ?></p>
                                 <div>
                                     <?php echo ($vo["content"]); ?>
                                 </div>
                             </div><?php endforeach; endif; ?>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
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
    var myScrol0,myScrol1,$Menups=$('.head_box p'),name=GetQueryString('name'),Nan=window.location.search;
    function Iscroll(names,Id){
        names = new IScroll(Id, {probeType: 3,mouseWheel: true,click: true,scrollbars: false});
    }
    $(document).ready(function() {  
        init();
        iscrollAll();
        tabs();
        function init(){
            if(Nan.indexOf('index')){
              $('.list-main>div').eq(1).show();  
              $Menups.eq(1).addClass('box_set'); 
            }else{
               $('.list-main>div').eq(0).show();
               $Menups.eq(0).addClass('box_set');
            }
        }
        function iscrollAll(){
            myScrol0 = new IScroll('#list-state-one', {probeType: 3,mouseWheel: true,click: true,scrollbars: false});
            myScrol1 = new IScroll('#list-state-two', {probeType: 3,mouseWheel: true,click: true,scrollbars: false});
        }
        function tabs(){
            $Menups.on(tapClick(),function(){
                var index=$(this).index();
                $('.list-main>div').eq(index).show().siblings().hide();
                $Menups.eq(index).addClass('box_set').siblings().removeClass('box_set');
                iscrollAll();
            }) 
        }  
    });
</script>
</body>

</html>