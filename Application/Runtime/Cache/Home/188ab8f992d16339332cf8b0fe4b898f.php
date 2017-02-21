<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜便捷购</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" href="/Public/css/app/detail/index.css"><style type="text/css">body,html,.wrap,.wrapBox_sec{width: 100%;height: 100%;}.wrapBox_sec{background: #ffffff;}.pub-header .header-content{top:-15px;}.wrapBox_sec{padding: 0px;padding-top: 50px;}</style>
</head>
<body>
<div class="wrap">
	<header class="pub-header bgss">
        <a class="tap-action icon icon-back" href="javascript:history.go(-1)"></a>
        <p class="header-content"></p>
        <span class="header-right header-right-text">
        </span>
    </header>
    <input type="hidden" id="city_id" name="city_id" value="<?php echo ($data['new_city_id']); ?>">
    <input type="hidden" id="province_id" name="province_id" value="<?php echo ($data['new_city_province']); ?>">
    <input type="hidden" id="assertion" name="assertion" value="<?php echo ($data['assertion']); ?>">
    <div class="wrapBox_sec">
    	<iframe name="myFrame" id="myFrame" width="100%;" height="100%"  frameborder="0" src=""></iframe>
    </div>
</div>
<script type="text/javascript" src="/Public/js/lib/zepto.min.js"></script>
<script type="text/javascript" src="/Public/js/lib/jweixin.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var jsApiList = ['checkJsApi','onMenuShareTimeline','onMenuShareAppMessage','onMenuShareQQ','onMenuShareWeibo','onMenuShareQZone'];
    	function GetQueryString(name){
		    var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
		    var r = decodeURIComponent(window.location.search).substr(1).match(reg);
		    if(r!=null)return  unescape(r[2]); return null;
		}
        function weixins(url,name){
        $.ajax({
            url: '/Sample/index',
            type: 'POST',
            data:{url:url},
            dataType: 'json',
            success:function(data){
                if(data.result == 'ok'){
                    var rs = data.data;
                    console.log(rs);
                    wx.config({
                        debug:false,
                        appId:rs.appId,
                        timestamp:rs.timestamp,
                        nonceStr:rs.nonceStr,
                        signature:rs.signature,
                        jsApiList: jsApiList
                    }); 
                }
            },error:function(){
                loaging.bth('分享错误')
            }
        })
      wx.ready(function () {
            wx.checkJsApi({
                jsApiList: [
                    'getNetworkType',
                    'previewImage'
                ],
                success: function (res) {}
            });
       if(name == "index"){
           var shareObj={
                title: '您的口袋便捷超市',
                desc: '哈哈镜美味线上优惠购，大礼送不停；更有千种商品任您挑选，方便快捷送到家',
                link: 'http://www.hahajing.com/download/',
                imgUrl: 'http://weixin.hahajing.com/Public/image/app_logo.png'
            }
       }else{
            var shareObj={
                title: '哈哈镜订单分享,红包嗨起来',
                desc: '就用app分享的内容吧',
                link: 'http://www.hahajing.com/activity/app_envelope',
                imgUrl: 'http://weixin.hahajing.com/Public/image/app_logo.png'
            }
       }
        wx.onMenuShareAppMessage(shareObj);
        wx.onMenuShareTimeline(shareObj);
        wx.onMenuShareQQ(shareObj);
        wx.onMenuShareWeibo(shareObj);
        wx.onMenuShareQZone(shareObj);
        function decryptCode(code, callback) {
            $.getJSON('/jssdk/decrypt_code.php?code=' + encodeURI(code), function (res) {
              if (res.errcode == 0) {
                codes.push(res.code);
              }
            });
          }
    });
    wx.error(function (res) {});
}
	var url = GetQueryString("url"),
		name = GetQueryString("name"),
		head_name = $('.header-content'),
		myFrame = $('#myFrame');
        if(name == '游戏抽奖'){
            weixins(url,name);
        }
    var city_id=$('#city_id').val(),
        province_id=$('#province_id').val(),
        assertion=$('#assertion').val();
        url=url+'?city_id='+city_id+'&province_id='+province_id+'&assertion='+assertion;
		head_name.html(name);
		myFrame.attr('src',url);
})
</script>
</body>
</html>