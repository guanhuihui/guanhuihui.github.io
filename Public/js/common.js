function tapClick() {
    return "ontouchstart" in document ? "tap": "click"
}
function score(divs, ids) {
    var atrr = [],
    Parents = $("#" + divs + " .mens_details_x");
    for (var k = 0; k < Parents.length; k++) {
        if (Parents.eq(k).children(".wrap_x").attr("data-id")) {
            atrr.push(Parents.eq(k).children(".wrap_x").attr("data-id"))
        }
    }
    for (var k = 0; k < atrr.length; k++) {
        $("#" + ids + "" + atrr[k] + "").find(".cur").css({
            "height": "13px",
            "background-image": "url(/Public/image/star_v.png)",
            "background-repeat": "no-repeat"
        });
        var num = $("#" + ids + "" + atrr[k] + "").attr("data-index");
        var curW = num * 16 + "px";
        $("#" + ids + "" + atrr[k] + "").find(".cur").css("width", curW);
        $("#" + ids + "" + atrr[k] + "").find(".cur").css("background-position", "0px -13px")
    }
}
function scores() {
    for (var k = 0; k < $(".wrap_x").length; k++) {
        $("#wrap_x" + k + "").find(".cur").css({
            "height": "13px",
            "background-image": "url(/Public/image/star_v.png)",
            "background-repeat": "no-repeat"
        });
        var num = $("#wrap_x" + k + "").attr("data-index");
        var curW = num * 16 + "px";
        $("#wrap_x" + k + "").find(".cur").css("width", curW);
        $("#wrap_x" + k + "").find(".cur").css("background-position", "0px -13px")
    }
}
function top_roll() {
    function getId(Id) {
        return document.getElementById(Id)
    }
    var speed = 14,
    dome = getId("demo"),
    dome1 = getId("demo1"),
    dome2 = getId("demo2"),
    winWidth = $(window).width(),
    lenwidth = $(".ps").text().length * 15 + winWidth - 192;
    $(".ps,#demo").width(lenwidth);
    dome2.innerHTML = dome1.innerHTML;
    function Marquee() {
        if (dome2.offsetWidth - dome.scrollLeft <= 0) {
            dome.scrollLeft -= getId("demo1").offsetWidth
        } else {
            dome.scrollLeft++
        }
    }
    var MyMar = setInterval(Marquee, speed)
}
function updatePosition1() {
    if (this.y <= -50) {
        $(".Return-top").show()
    } else {
        $(".Return-top").hide()
    }
}
function updatePosition() {
    $("img.image").lazyload({})
}
function clicksTop(myScrol0) {
    $(".Return-top").on(tapClick(),
    function() {
        myScrol0.scrollTo(0, 0, 500)
    })
}
function Iscroll(names, Id) {
    names = new IScroll(Id, {
        probeType: 3,
        mouseWheel: true,
        click: true,
        scrollbars: false
    })
}
function GetQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
    var r = decodeURIComponent(window.location.search).substr(1).match(reg);
    if (r != null) {
        return unescape(r[2])
    }
    return null
}
function Tabs(lisName, divs, className) {
    lisName.on(tapClick(),
    function() {
        var index = $(this).index();
        divs.eq(index).show().siblings().hide();
        lisName.eq(index).addClass(className).siblings().removeClass(className);
        iscrollAll()
    })
}
var loaging = {
    init: function(txt) {
        var index = layer.open({
            content: '<div class="center">' + txt + "</p>",
            style: "border:none;text-align:center;line-height:50px;",
            shadeClose: false,
            type: 2
        })
    },
    init2: function(txt) {
        layer.open({
            type: 3,
            content: '<img src="/Public/image/jz2.gif" alt="" /><span>' + txt + "</span>"
        })
    },
    btn: function(txt) {
        var index = layer.open({
            content: '<p class="center">' + txt + "</p>",
            style: "border:none;text-align:center;line-height:70px;margin-top:-75%;width:100%;font-size:16px;",
            shadeClose: false,
            btn: ["确认"]
        })
    },
    Alert: function(txt, txt1, infos) {
        var index = layer.open({
            content: '<div class="box-mask-html"><p>' + txt + "</p><p>" + txt1 + "</p></div>",
            style: "width:100%;border:none;text-align:center;",
            shadeClose: false,
            btn: ["确定", "取消"],
            yes: function() {
                layer.close(index);
                if (infos == "#mod-box") {
                    location.href = "mod_address.html";
                    layer.closeAll()
                }
            },
            no: function() {
                layer.close(index)
            }
        })
    },
    log: function(txt, divs) {
        var index = layer.open({
            content: '<p class="center">' + txt + "</p>",
            style: "width:100%;border:none;text-align:center;",
            shadeClose: false,
            btn: ["设置", "取消"],
            yes: function() {
                layer.close(index);
                $("#mod-box").show().siblings().hide()
            },
            no: function() {
                layer.close(index)
            }
        })
    },
    prompts: function(txt) {
        layer.open({
            content: '<p class="center">' + txt + "</p>",
            shadeClose: false,
            style: "background:rgba(0,0,0,.7);color:#FFFFFF;text-align: center;margin-top:-35%;",
            time: 1.5
        })
    },
    close: function(names) {
        layer.closeAll()
    }
};
function weixins(url, name,names,imgurl,shopId) {
    var jsApiList = ["checkJsApi", "onMenuShareTimeline", "onMenuShareAppMessage", "onMenuShareQQ", "onMenuShareWeibo", "onMenuShareQZone"];
    $.ajax({
        url: "/Sample/index",
        type: "POST",
        data: {
            url: url
        },
        dataType: "json",
        success: function(data) {
            if (data.result == "ok") {
                var rs = data.data;
                wx.config({
                    debug: false,
                    appId: rs.appId,
                    timestamp: rs.timestamp,
                    nonceStr: rs.nonceStr,
                    signature: rs.signature,
                    jsApiList: jsApiList
                })
            }
        }
    });
    wx.ready(function() {
        wx.checkJsApi({
            jsApiList: ["getNetworkType", "previewImage"],
            success: function(res) {}
        });
        if (name == "index") {
            var shareObj = {
                title: "您的口袋便捷超市",
                desc: "哈哈镜美味线上优惠购，大礼送不停；更有千种商品任您挑选，方便快捷送到家",
                link: "http://www.hahajing.com/download/",
                imgUrl: "http://weixin.hahajing.com/Public/image/app_logo.png"
            }
        }else if (name == "index2") {
            var shareObj = {
                title: names,
                desc: "哈哈镜美味线上优惠购，大礼送不停；更有千种商品任您挑选，方便快捷送到家",
                link: "http://test.hahajing.com/share/index?shop_id="+shopId,
                imgUrl: imgurl
            }
        }else {
            if (name == "ones") {
                var urls = GetQueryString("url");
                urls ? urlS = urls: urlS = url;
                var shareObj = {
                    title: "6折任性吃火锅，还给送上门！",
                    desc: "别让老板知道哦！",
                    link: "http://weixin.hahajing.com/ActivityTwo/share_index/pid/" + $("#pid").val() + "",
                    imgUrl: "http://weixin.hahajing.com/Public/image/fenx1.jpg"
                }
            } else {
                if (name == "one") {
                    var urls = GetQueryString("url");
                    urls ? urlS = urls: urlS = url;
                    var shareObj = {
                        title: "6折任性吃火锅，还给送上门！",
                        desc: "别让老板知道哦！",
                        link: "http://weixin.hahajing.com/ActivityTwo/share_index/pid/" + $("#pid").val() + "",
                        imgUrl: "http://weixin.hahajing.com/Public/image/fenx1.jpg"
                    }
                } else {
                    if (name == "Activity") {
                        var urls = GetQueryString("url");
                        urls ? urlS = urls: urlS = url;
                        var shareObj = {
                            title: "您的口袋便捷超市",
                            desc: "哈哈镜美味线上优惠购，大礼送不停；更有千种商品任您挑选，方便快捷送到家",
                            link: urlS,
                            imgUrl: "http://weixin.hahajing.com/Public/image/app_logo.png"
                        }
                    } else {
                        var shareObj = {
                            title: "哈哈镜订单分享,红包嗨起来",
                            desc: "就用app分享的内容吧",
                            link: "http://www.hahajing.com/activity/app_envelope",
                            imgUrl: "http://weixin.hahajing.com/Public/image/app_logo.png"
                        }
                    }
                }
            }
        }
        wx.onMenuShareAppMessage(shareObj);
        wx.onMenuShareTimeline(shareObj);
        wx.onMenuShareQQ(shareObj);
        wx.onMenuShareWeibo(shareObj);
        wx.onMenuShareQZone(shareObj);
        function decryptCode(code, callback) {
            $.getJSON("/jssdk/decrypt_code.php?code=" + encodeURI(code),
            function(res) {
                if (res.errcode == 0) {
                    codes.push(res.code)
                }
            })
        }
    });
    wx.error(function(res) {})
}
function Common() {
    this.geolocation = function() {
        if (window.navigator.geolocation) {
            var options = {
                enableHighAccuracy: true,
                timeout: 2000,
                maximumAge: 2000
            };
            window.navigator.geolocation.getCurrentPosition(handleSuccess, handleError, options)
        } else {
            console.log("浏览器不支持html5来获取地理位置信息")
        }
        function handleSuccess(position) {
            var lng = position.coords.longitude;
            var lat = position.coords.latitude;
            var ggPoint = new BMap.Point(lng, lat);
            translateCallback = function(data) {
                if (data.status === 0) {
                    var marker = new BMap.Marker(data.points[0]);
                    var s = data.points[0].lng;
                    var k = data.points[0].lat;
                    var lists = {
                        lng: s,
                        lat: k,
                        ak: "wqBXfIN3HkpM1AHKWujjCdsi"
                    };
                    console.log(lists.lng + "," + lists.lat);
                    var JSONP = document.createElement("script");
                    JSONP.type = "text/javascript";
                    JSONP.src = "http://api.map.baidu.com/geocoder/v2/?ak=" + lists.ak + "&callback=jsonpCallbacks&location=" + lists.lat + "," + lists.lng + "&output=json&pois=1";
                    document.getElementsByTagName("head")[0].appendChild(JSONP)
                }
            };
            setTimeout(function() {
                var convertor = new BMap.Convertor();
                var pointArr = [];
                pointArr.push(ggPoint);
                convertor.translate(pointArr, 1, 5, translateCallback)
            },
            1000)
        }
        function handleError(error) {
            switch (error.code) {
            case error.PERMISSION_DENIED:
                loaging.close();
                loaging.btn("请打开您的gps定位系统");
                break;
            case error.POSITION_UNAVAILABLE:
                loaging.close();
                var map = new BMap.Map("allmap");
                var geolocation = new BMap.Geolocation();
                geolocation.getCurrentPosition(function(r) {
                    if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                        var mk = new BMap.Marker(r.point);
                        map.addOverlay(mk);
                        map.panTo(r.point);
                        var lists = {
                            lng: r.point.lng,
                            lat: r.point.lat,
                            ak: "wqBXfIN3HkpM1AHKWujjCdsi"
                        };
                        var JSONP = document.createElement("script");
                        JSONP.type = "text/javascript";
                        JSONP.src = "http://api.map.baidu.com/geocoder/v2/?ak=" + lists.ak + "&callback=jsonpCallbacks&location=" + lists.lat + "," + lists.lng + "&output=json&pois=1";
                        document.getElementsByTagName("head")[0].appendChild(JSONP)
                    } else {
                        console.log("failed" + this.getStatus())
                    }
                },
                {
                    enableHighAccuracy: true
                });
                break;
            case error.TIMEOUT:
                loaging.close();
                var map = new BMap.Map("allmap");
                var geolocation = new BMap.Geolocation();
                geolocation.getCurrentPosition(function(r) {
                    if (this.getStatus() == BMAP_STATUS_SUCCESS) {
                        var mk = new BMap.Marker(r.point);
                        map.addOverlay(mk);
                        map.panTo(r.point);
                        var lists = {
                            lng: r.point.lng,
                            lat: r.point.lat,
                            ak: "wqBXfIN3HkpM1AHKWujjCdsi"
                        };
                        var JSONP = document.createElement("script");
                        JSONP.type = "text/javascript";
                        JSONP.src = "http://api.map.baidu.com/geocoder/v2/?ak=" + lists.ak + "&callback=jsonpCallbacks&location=" + lists.lat + "," + lists.lng + "&output=json&pois=1";
                        document.getElementsByTagName("head")[0].appendChild(JSONP)
                    } else {
                        console.log("failed" + this.getStatus())
                    }
                },
                {
                    enableHighAccuracy: true
                });
                break;
            case error.TIMEOUT:
                loaging.close();
                break;
            case error.UNKNOWN_ERROR:
                loaging.close();
                loaging.btn("发生了位置错误");
                break
            }
        }
    };
    this.address_search = function() {
        function G(id) {
            return document.getElementById(id)
        }
        var map = new BMap.Map("allmap");
        map.centerAndZoom("北京", 12);
        var ac = new BMap.Autocomplete({
            "input": "suggestId",
            "location": map
        });
        ac.addEventListener("onhighlight",
        function(e) {
            var str = "";
            var _value = e.fromitem.value;
            var value = "";
            if (e.fromitem.index > -1) {
                value = _value.province + _value.city + _value.district + _value.street + _value.business
            }
            str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
            value = "";
            if (e.toitem.index > -1) {
                _value = e.toitem.value;
                value = _value.province + _value.city + _value.district + _value.street + _value.business
            }
            str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
            G("search-suggestion-dropdown").innerHTML = str
        });
        var myValue;
        ac.addEventListener("onconfirm",
        function(e) {
            var _value = e.item.value;
            myValue = _value.province + _value.city + _value.district + _value.street + _value.business;
            G("search-suggestion-dropdown").innerHTML = "onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
            var JSONP = document.createElement("script");
            JSONP.type = "text/javascript";
            JSONP.src = "http://api.map.baidu.com/geocoder/v2/?address=" + myValue + "&output=json&ak=wqBXfIN3HkpM1AHKWujjCdsi&callback=showLocation";
            document.getElementsByTagName("head")[0].appendChild(JSONP)
        })
    }
}
function showLocation(types) {
    var location = types.result.location
}
var common = new Common();
function newCommon() {
    var self = this;
    this.access_server = function(url, option, callback, errorfn, asyncType) {
        var async = asyncType ? asyncType: true;
        $.ajax({
            url: url,
            type: "get",
            dataType: "json",
            data: option,
            async: async,
            beforeSend: function() {
                loaging.init("加载中...")
            },
            success: function(rs) {
                loaging.close();
                if ($.isFunction(callback)) {
                    callback(rs)
                }
            },
            error: function() {
                loaging.close();
                errorfn()
            }
        })
    };
    this.post_server = function(url, option, callback, errorfn, asyncType) {
        var async = asyncType ? asyncType: true;
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: option,
            async: async,
            beforeSend: function() {
                loaging.init("加载中...")
            },
            success: function(rs) {
                loaging.close();
                if ($.isFunction(callback)) {
                    callback(rs)
                }
            },
            error: function() {
                loaging.close();
                errorfn()
            }
        })
    };
    this.post_servers = function(url, option, callback, errorfn, asyncType) {
        var async = asyncType ? asyncType: true;
        $.ajax({
            url: url,
            type: "post",
            dataType: "json",
            data: option,
            async: async,
            success: function(rs) {
                if ($.isFunction(callback)) {
                    callback(rs)
                }
            },
            error: function() {
                errorfn()
            }
        })
    };
    this.getDistanceOfJW = function(location1, location2) {
        function Rad(d) {
            return d * Math.PI / 180
        }
        function GetDistance(lat1, lng1, lat2, lng2) {
            var radLat1 = Rad(lat1);
            var radLat2 = Number(Rad(lat2));
            var a = Number(radLat1 - radLat2);
            var b = Rad(lng1) - Rad(lng2);
            var s = 2 * Math.asin(Math.sqrt(Math.pow(Math.sin(a / 2), 2) + Math.cos(radLat1) * Math.cos(radLat2) * Math.pow(Math.sin(b / 2), 2)));
            s = s * 6378.137;
            s = Math.round(s * 10000) / 10;
            return s
        }
        return GetDistance(location1["lat"], location1["lng"], location2["lat"], location2["lng"])
    };
    this.showLoading = function() {
        if ($("#ul-id-loading").length == 0) {
            var loadBox = $("<div>");
            loadBox.attr("id", "ul-id-loading").addClass("ul-mask").appendTo($("body"))
        } else {
            $("#ul-id-loading").show()
        }
        if ($("#ul-id-loadImg").length == 0) {
            var loadImg = $("<div><img></div>");
            loadImg.attr("id", "ul-id-loadImg").addClass("ul-load").appendTo($("body"));
            loadImg.find("img").attr("src", "/hotelpage2/img/loading.gif")
        } else {
            $("#ul-id-loadImg").show()
        }
    };
    this.hideLoading = function() {
        $("#ul-id-loading,#ul-id-loadImg").hide()
    };
    this.closeWarning = function() {
        if ($("#ui-dialog").length) {
            $("#ul-mask").remove();
            $("#ui-dialog").remove()
        }
    };
    this.warning = function(msg, callback) {
        var self = this;
        var title = "<div></div>";
        var content = '<div class="content">' + msg + "</div>";
        var foot = '<div><span id="sure">确认</span></div>';
        this.dialog(title, content, foot);
        $("#ul-mask").show(500);
        $("#ui-dialog").show(500);
        if ($("#sure").length) {
            $("#sure").click(function() {
                self.closeWarning();
                if (typeof callback == "function") {
                    callback()
                }
            })
        }
    };
    this.dialog = function(tit, con, fot) {
        if ($("#ul-mask").length == 0) {
            var mask = $("<div></div>");
            mask.attr("id", "ul-mask").addClass("ul-mask");
            mask.hide().appendTo($("body"))
        }
        if ($("#ui-dialog").length == 0) {
            var html = '<div class="tip">' + tit + con + fot + "</div>";
            var dialog = $("<div></div>");
            dialog.attr("id", "ui-dialog").addClass("ui-dialog");
            dialog.html(html).hide().appendTo($("body"))
        }
    };
    this.checkPhone = function(str) {
        var reg = /^1[34578]\d{9}$/;
        if (!reg.test(str)) {
            this.warning("你输入的手机有误");
            return false
        }
        return true
    };
    this.checkCard = function(str) {
        var reg = /^\d{17}([0-9]|x)$/;
        if (!reg.test(str)) {
            this.warning("你输入的身份证有误");
            return false
        }
        return true
    };
    this.checkPwd = function(str) {
        var reg = /^\w{6,12}$/;
        if (!reg.test(str)) {
            this.warning("你输入的密码有误");
            return false
        }
        return true
    };
    this.checkTextCode = function(str) {
        var reg = /^\d{4}$/;
        if (!reg.test(str)) {
            this.warning("你输入的验证码有误");
            return false
        }
        return true
    }
}
var commoms = new newCommon();
function ajaxetil(chufa, url, pubLis) {
    $.ajax({
        url: "/Address/is_ajax_login",
        type: "post",
        dataType: "json",
        data: {},
        success: function(result) {
            if (result.result == "ok") {
                if (chufa) {
                    chufa()
                }
            } else {
                setTimeout(function() {
                    loaging.close();
                    if (pubLis) {
                        pubLis.eq(0).on(tapClick())
                    }
                    location.href = url
                },
                500);
                return false
            }
        },
        error: function() {
            loaging.close()
        }
    })
}
function getnums(num) {
    var intNum = num * 10;
    intNum = parseInt(intNum);
    return intNum / 10
}
function judgment_landing() {
    $.ajax({
        url: "/Address/is_ajax_login",
        type: "post",
        dataType: "json",
        data: {},
        success: function(result) {
            loaging.close();
            if (result.result == "ok") {
                layer.closeAll()
            } else {
                location.href = "/user/login.html";
                return false
            }
        },
        error: function() {
            loaging.close()
        }
    })
};