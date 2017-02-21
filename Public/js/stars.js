(function ($) {   
    $.fn.BindStars = function () {

        var starElement = $(this);
        $('.text').text('请您评价');
        starElement.children("i").on('tap',function () {
            var curIndex = starElement.find("i").index(this);
            if(curIndex==0){
                $('.text').text('很差');
            }else if(curIndex == 1){
                $('.text').text('不满意');
            }else if(curIndex == 2){
                $('.text').text('一般');
            }else if(curIndex == 3){
                $('.text').text('满意');
            }else if(curIndex == 4){
                $('.text').text('很满意');
            }
            starElement.find("i").each(function (index) {
                if (index <= curIndex) {
                    $(this).addClass("onred");
                }
                else {
                    $(this).removeClass("onred");
                }
            }); 
            starElement.attr("data-score", curIndex + 1);
        });
    };
    $.fn.SetStars = function (score) {
        var scoreStr = "";
        for (var i = 0; i < 5; i++) {
            if (i < score) {
                scoreStr += "<i class='onred'></i>";
            } else {
                scoreStr += "<i></i>";
            }
        } 
        $(this).html(scoreStr); 
    };
})(window.jQuery);
/*(function ($) {   
    $.fn.BindStars = function () {
        var starElement = $(this);
        starElement.children("i").addClass('onred');
        $('.text').text('很满意');
        starElement.children("i").on('tap',function () {
            var curIndex = starElement.find("i").index(this);
            if(curIndex==0){
                $('.text').text('很差');
            }else if(curIndex == 1){
                $('.text').text('不满意');
            }else if(curIndex == 2){
                $('.text').text('一般');
            }else if(curIndex == 3){
                $('.text').text('满意');
            }else if(curIndex == 4){
                $('.text').text('很满意');
            }
            starElement.find("i").each(function (index) {
                if (index <= curIndex) {
                    $(this).addClass("onred");
                }
                else {
                    $(this).removeClass("onred");
                }
            }); 
            starElement.attr("data-score", curIndex + 1);
        });
    };
    $.fn.SetStars = function (score) {
        var scoreStr = "";
        for (var i = 0; i < 5; i++) {
            if (i < score) {
                scoreStr += "<i class='onred'></i>";
            } else {
                scoreStr += "<i></i>";
            }
        } 
        $(this).html(scoreStr); 
    };
})(window.jQuery);*/