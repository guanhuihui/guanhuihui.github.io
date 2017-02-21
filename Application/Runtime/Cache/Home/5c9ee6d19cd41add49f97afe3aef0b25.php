<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <title>哈哈镜便捷购</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="format-detection" content="telephone=no">
    <style type="text/css">
    .yans{
        background: rgba(0,0,0,0.3);
        width: 100%;
        height: 100%;
        position: fixed;
        left: 0;
        top: 0;
        display: none;
    }
    .flex{
        display: -webkit-box;
        display: box;
        font-size: 16px;
    }
    .flexs{
        -webkit-box-flex:1;
        box-flex:1;
        text-align: center;
        line-height: 48px;
        border-top: 1px solid #Ededed;     
    }
    .flexs:first-child{
        border-right: 1px solid #Ededed;
    }
    .yansBoxs{
        padding: 0 3%;
        width: 90%;
        margin: 0 auto;
        background: #fff;
        height: auto;
        margin-top: 50%;
        border-radius: 6px;
    }
    .yans h2{
        text-align: center;
        color: #000;
        font-size: 17px;
        line-height: 50px;
         border-bottom: 1px solid #Ededed;
    }
    .yans .yans_box{
        display: -webkit-box;
        display: box;
        padding: 15px 0;
        height: 80px;
    }
    .yans .yans_box input{
       border:1px solid #Ededed;
       -webkit-box-flex:1;
       box-flex:1;
       margin-right: 5px;
       height: 45px;
       font-size: 18px;
       padding-left: 5px;
    }
    .yans .yans_box span{
        width: 150px;
        height: 45px;
    }
     .yans .yans_box span img{
        display: block;
        width: 100%;
     }
    </style>
  <script type=text/javascript>
	var docElement = document.documentElement;
	var clientWidthValue = docElement.clientWidth > 480 ? 480 : docElement.clientWidth;
	docElement.style.fontSize = 10*(clientWidthValue/320) + 'px';
</script>
<link rel="stylesheet" href="/Public/css/style.css">
<script type="text/javascript" src="/Public/js/layer.m/layer.m.js"></script>
<script type="text/javascript" src="/Public/js/lib/fastclick.js"></script>
<body>
    <div id="mod-container" class="mod-container clearfix">
        <div id="mod-verify" class="mod-verify">
            <header class="pub-header">
                <!--<a class="tap-action icon icon-back" href="/Index/index"></a>-->
                </span>
                <div class="header-content ">
                    验证手机
                </div>
                <span class="header-right header-right-text">
                </span>
            </header>
            <div class="main main-top" data-bind-login="1">
                <form id="autocomplete-form" class="mod-order-common login-form" onsubmit="return false;">
                    <div class="pic">
                        <img src="/Public/image/me_header_bg.png" alt="">
                        <p><img src="/Public/image/me_avatar.png" alt=""></p>
                    </div>
                    <div class="block">
                        <input name="phone" id="autocomplete-phone" class="phone login-input-phone login-input fix-undo"
                        type="tel" placeholder="请输入手机号码" maxlength="11" value="<?php echo ($mobile); ?>">
                        <input class="submit login-send" type="button"  value="获取验证码">    
                    </div>
                    <div class="blocko">
                        <input type="tel" class="code login-input-code login-input fix-undo"
                        placeholder="请输入短信验证码" maxlength="6">
                    </div>
                    <div type="button" class="bigbtn bigbtn-one login-submit">
                        确定
                    </div>
                    <p class="tiao"><a href="/me/app_html_all?url=http://www.hahajing.com/home/agreement/hhj_agreement&name=哈哈镜服务协议">点击确定即视为同意《哈哈镜服务协议》</a></p>
                </form>
            </div>
        </div>
    </div>



    <div class="yans">
        <div class="yansBoxs">
            <h2>请填写图形验证码</h2><div class="yans_box"><input type="tel" maxlength="4" id="openSize" class="styleinput blocks" value="" /><span class="styleinput blocks"><img src="/Checkcode/index?font_size=20&width=150&height=40" id="yansImg" onclick="this.src='/Checkcode/index?font_size=20&width=150&height=40'" alt="" style="cursor: pointer;padding:0;border:0;margin:0;display:block;" title="点击获取" /></span></div>
                <div class="flex"><p class="flexs oneflex">取消</p><p class="flexs twoflex">确认</p></div>
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
  var myScroll,myScrol2,myScrol3,myScrol4,$Menups=$('.head_box p'),
      send_btn = $('.login-send'),sub_btn = $('.login-submit'),
      phones = $('#autocomplete-phone'),
      inp = $('input'),
      yans = $('.yans'),
      yansImg = $('#yansImg'),
      openSize = $('#openSize'),
      s = 60, t;
      
   $(document).ready(function() { 
        $('.mod-verify').show();
        //returnbtn();
        clicks();
/*        function returnbtn(){
            $('.icon-back').on(tapClick(),function(){
                $('input,textarea').blur();
                var parentName=$(this).parents('div').attr('class');
                if(parentName.indexOf('mod_my_order')>-1){
                   location.href="/Index/index.html";
                }  
            })
        } */
        function clicks(){
            send_btn.on('click',function(){
                openSize.val('');
                inp.blur();
                var phone=phones.val();
                if(phone){
                    yans.show();
                    $('.oneflex').off('click');
                    $('.oneflex').on('click',function(){
                        yansImg.click();
                        yans.hide(); 
                    })
                    $('.twoflex').off(tapClick());
                    $('.twoflex').on(tapClick(),function(){
                       var vals = $('#openSize').val();
                       if(vals){
                            $('input').blur();
                            loaging.close();
                            commoms.post_server('/User/getmobile_code',{mobile: phone,verify:vals},function(result){
                               if(result.result == 'ok'){
                                    yans.hide();
                                    loaging.prompts(result.data.msg);
                                    function times(){
                                        s--;
                                        send_btn.val('重新获取('+s+')');
                                        send_btn.attr({'disabled':true}).addClass('submitCol');
                                        t = setTimeout(times, 1000);
                                            if ( s <= 0 ){
                                             s = 60;
                                             clearTimeout(t);
                                             send_btn.val('获取验证码');
                                             send_btn.attr('disabled',false).removeClass('submitCol');
                                            }
                                        }
                                       times();
                               }else{
                                    yansImg.click();
                                    openSize.val('');
                                    loaging.btn(result.data.msg);
                               }
                               
                            },function(){ 
                                yansImg.click();
                                openSize.val('');
                                loaging.btn('短信发送失败,请重试');
                            },false);
                       }else{
                            $('input').blur();
                            loaging.close();
                        /*yans.hide();*/ 
                            yansImg.click();
                            openSize.val('');
                            loaging.btn('验证码不能为空');
                       }
                    })
                }else{
                    loaging.prompts('请输入手机号码');
                }
            })



            sub_btn.on(tapClick(),function(){
                inp.blur();
                var phone=phones.val();
                var Vcode=$('.code').val();
                if (Vcode) {
                    commoms.post_server('/user/loginuser',{mobile: phone,code:Vcode},function(result){
                        if (result.data.result == 'ok') {
                            loaging.close();
                            loaging.init('跳转中，请稍后...');
                            window.location.href='/index/index';
                        }else{
                            loaging.btn(result.data.msg);
                        }
                    },function(){
                        loaging.btn('用户登录失败');
                    },false);
                }else{
                    loaging.btn('请输入短信验证码');
                }
            })
        }
    })
    
</script>
</body>
</html>