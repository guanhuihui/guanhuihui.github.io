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
<script>(function(){var calc = function(){var docElement = document.documentElement;var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';};calc();window.addEventListener('resize',calc);})();</script> <link rel="stylesheet" href="/Public/css/style.css"><script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script><script type="text/javascript" src="/Public/js/lib/fastclick.js"></script><style type="text/css">.mod-trumpet{width: 100%;background: #EEFBE7;color: #9DD37B ;position: relative;height: 30px;line-height: 30px;}
        .mod-trumpet img{position: absolute;width: 23px;height: 23px;left: 15px;top:3.5px;}
        .message_s a{color: red;}</style>
</head>
<body onload="loaded()">
    <div id="mod-container" class="mod-container clearfix">
        <div id="mod-menu" class="mod-menu pageview" >
        <header class="pub-header">
            <a class="tap-action icon icon-back" href="/Index/index.html"></a>
            <div class="header-content ui-ellipsis" id="ui-ellipsis">
               
            </div>
            <div class="mens_details_nav" id="mens_details_nav2">
            </div>
        </header>
        <div class="main main-both">
            <div id="list-product" class="list-product iscroll-container" >
                <div id="scrollers" class="scrollers" style="padding-top:10px;border-bottom:0px;">
                    <ul class="scrollers_uls masonry clearfix" >
                        <?php if(is_array($goods_data)): foreach($goods_data as $key=>$vo): ?><li class="picCon masonry-brick">
                           <div>
                              <a href="/App/detail/shop_id/<?php echo ($vo["shop_id"]); ?>/goods_id/<?php echo ($vo["goods_id"]); ?>" class="img">
                                 <img class="image" src="<?php echo ($vo["goods_pic"]); ?>"  />
                               </a>
                             <div class="tou">
                                 <div class="divP">
                                    <h3 class="goods_info ui-ellipsis"><?php echo ($vo["goods_name"]); if(($val["goods_pungent"]) != ""): ?>(<?php echo ($val["goods_pungent"]); ?>)<?php endif; ?></h3>
                                    <p class="goods_pre">
                                        <?php if(($vo["goods_stockout"]) == "1"): ?><span>补货中</span><?php endif; ?></p>
                                    <p class="goods_he"><?php echo ($vo["goods_weight"]); ?>
                                        <?php if(($vo["goods_unit"]) != ""): ?>/<?php echo ($vo["goods_unit"]); endif; ?>
                                    </p>
                                    <p class="goods_price">￥<?php echo ($vo["goods_price"]); ?></p>
                                 </div>
                                 <div class="divname">
                                     <p>
                                        <img src="/Public/image/aname.png" alt="">
                                        <span><a href="/Category/index/shop_id/<?php echo ($vo["shop_id"]); ?>"><?php echo ($vo["shop_name"]); ?></a></span>
                                     </p>
                                 </div>
                               </div>
                            </div>
                        </li><?php endforeach; endif; ?>
                    </ul>
                </div> 
            </div>
        </div>
    </div>
    </div>
    <div class="Return-top">
        <img src="/Public/image/top_icon.png" alt="">
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
function loaded(){}
    var myScrol0;
        init();
        iscrollAll();
        clicks();
        function init(){
            $('.pageview').eq(0).show();
            $('.Boxs>div').eq(0).show();
            var W=$('#scroller li').length*95;
            $('#scroller').css({'width':W+'px'});
        }
        function iscrollAll(){
            myScrol0 = new IScroll('#list-product', {preventDefault: false,probeType: 3,mouseWheel: true,click: true,scrollbars: false});
        }
        function clicks(){
            $('.Return-top').on(tapClick(),function(){
                myScroll.scrollTo(0,0,500);
            })
        }         
</script>
</body>

</html>