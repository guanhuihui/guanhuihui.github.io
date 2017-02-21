 var myScroll,myScrol2,showName=GetQueryString('name'),
    list ={probeType: 3,mouseWheel: true,preventDefault:false,scrollbars: false},
    listass_btn = $('.adda'),
    modadd_divs = $('.mod-shipping_address'),
    dal_btn = $('.shipping-adds-editor .Del'),
    del_input = $('.list-addr-del input'),
    head_boxp = $('.head_box p');
function loaded(){}
$(document).ready(function() { 
    $('.mod-addrlist').show();
    iscrollAll();
    returnBth();
    clicks();
    score('mod-addrlist','wrap_x');
    function iscrollAll(){
        myScroll = new IScroll('#list-main-one',list);  
        myScroll = new IScroll('#list-main-three',list);  
        myScrol2 = new IScroll('#shipping-adds',list);
    }     
    function clicks(){
        //点击管理按钮
        listass_btn.on(tapClick(),function(){
                commoms.post_server('/Address/is_ajax_login',{},function(result){
                    if(result.result == 'ok'){
                        location.href="/Address/add.html";
                    }else{
                        location.href='/user/login.html'
                    }
                },function(){
                    layer.closeAll();
                },false);
            });
            del_input.on('change',function(){
                del_input.removeClass('inputColor');
                $(this).addClass('inputColor');
            })
            head_boxp.on(tapClick(),function(){
                var index = $(this).index();
                commoms.post_server('/Address/is_ajax_login',{},function(result){
                    if(result.result == 'ok'){  
                        head_boxp.removeClass('box_set');
                        head_boxp.eq(index).addClass('box_set');
                        $('.addrlist_main .add_main').eq(index).show().siblings().hide();
                        iscrollAll();
                    }else{
                        location.href='/user/login.html'
                    }
                },function(){
                    layer.closeAll();
                },false);
                
            })
        }
        //返回按钮
        function returnBth(){
            $('.icon-back').on(tapClick(),function(){
                $('input,textarea').blur();
                var parentName=$(this).parents('div').attr('class');
                if(parentName.indexOf('mod-addrlist')>-1){
                   location.href="/Index/index";
                }else if(parentName.indexOf('mod-shipping_address')>-1){
                    location.reload();
                  
                }else{
                   return;  
                }   
            })
        }
        
    })