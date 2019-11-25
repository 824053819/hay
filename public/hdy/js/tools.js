// author lianghongna 20170919
var tools = {
    swiperbanner:function(bansel,mobsel,obj){
        var banner = obj.bannerpic;
        var urllink = obj.urllink; //这里引出url的数组
        var mobile = obj.mobilepic;
        var bannermax = new Array();
        var mobilemax = new Array();
        var urlmax = new Array(); //存放处理后的url数组
        for(var i in banner){
            bannermax.push(banner[i]);
        }
        for(var x in mobile){
            mobilemax.push(mobile[x])
        }
        //循环数组到urlmax
        for(var z in urllink){
            urlmax.push(urllink[z])
        }
        var bannerAll = bannermax.concat(bannermax);
        var mobileAll = mobilemax.concat(mobilemax);
        //这里形成两倍原始数组长度的新数组
        var urlAll = urlmax.concat(urlmax);
        //alert(urlAll);
        var bannerWidth = $(bansel).width();
        var mobileWidth = $(mobsel).width();
        var pos = bannermax.length;

        // 结构渲染
        var mobilehtml ='<div class="mobile-wrap" style=margin-left:-'+mobileWidth*pos+'px><ul class="mobile-pic">';
            for(var mob in mobileAll){
                mobilehtml += '<li><a href="'+ urlAll[mob] +'"><img src="'+mobileAll[mob]+'"/></a></li>'
            }
            mobilehtml +='</ul></div>'
        
        var swiperhtml = '<div class="banner-wrap" style=margin-left:-'+bannerWidth*pos+'px><ul class="banner-list">';
            for(var num in bannerAll){
                swiperhtml += '<li style="background:url('+bannerAll[num]+') no-repeat center center;background-size:cover"><a href="'+ urlAll[num] +'" style="display:block"></a></li>'
            }
            swiperhtml +="</ul></div>";
            swiperhtml +='<ul class="navlist">';
            for(var nav in bannermax){
                if(nav==0){
                    swiperhtml += '<li class="navactive"></li>'
                }else{
                    swiperhtml += '<li></li>'
                }
            }
            swiperhtml +="</ul>"
            swiperhtml +='<a href="javascript:void(0);" class="btn-page btn-prve">上一页</a><a href="javascript:void(0);" class="btn-page btn-next">下一页</a> '

        $(bansel).append(swiperhtml);
        $(mobsel).append(mobilehtml);

        // 轮播布局
        var liLength = $(bansel).find(".banner-list li").length;

        $(bansel).find(".banner-list li").width(bannerWidth);
        $(bansel).find(".banner-list").width(bannerWidth * liLength);
        $(bansel).find(".banner-wrap").width(bannerWidth * liLength);

        $(mobsel).find(".mobile-wrap").width(mobileWidth * liLength);
        $(mobsel).find(".mobile-pic").width(mobileWidth * liLength);

        var clock = true;

        function prve(){
            if(!clock){
                return;
            }
            clock = false;
            // 轮播图
            $(bansel).find(".banner-list").animate({"marginLeft":"+="+bannerWidth},500,function(){
                var changeLi = $(bansel).find(".banner-list li").eq(liLength-1).remove();
                $(bansel).find(".banner-list").prepend(changeLi);
                $(bansel).find(".banner-list").css({"margin-left":"0"});

                // nav
                var changeNav = $(bansel).find(".navlist li").eq(0).remove();
                $(bansel).find(".navlist").append(changeNav);

                // mobile
                $(mobsel).find(".mobile-pic").animate({"marginLeft":"+="+mobileWidth},100,function(){
                    var changeLim = $(mobsel).find(".mobile-pic li").eq(liLength-1).remove();
                    $(mobsel).find(".mobile-pic").prepend(changeLim);
                    $(mobsel).find(".mobile-pic").css({"margin-left":"0"});
                    clock = true;
                })
            });
            
        }
        // 上一个
        $(".btn-prve").on("click",function(){
            prve();
        })

        function next(){
            if(!clock){
                return;
            }
            clock = false;
            // 轮播图
            $(bansel).find(".banner-list").animate({"marginLeft":"-="+bannerWidth},500,function(){
                var changeLi = $(bansel).find(".banner-list li").eq(0).remove();
                $(bansel).find(".banner-list").append(changeLi);
                $(bansel).find(".banner-list").css({"margin-left":"0"})

                // nav
                var changeNav = $(bansel).find(".navlist li").eq(bannermax.length-1).remove();
                $(bansel).find(".navlist").prepend(changeNav);

                // mobile
                $(mobsel).find(".mobile-pic").animate({"marginLeft":"-="+mobileWidth},100,function(){
                    var changeLim = $(mobsel).find(".mobile-pic li").eq(0).remove();
                    $(mobsel).find(".mobile-pic").append(changeLim);
                    $(mobsel).find(".mobile-pic").css({"margin-left":"0"});
                    clock = true;
                })
            });
            
        }
        // 下一个 
        $(".btn-next").on("click",function(){
            next();
        })

        var picTimer = "";
        var picTimer = setInterval(next,999900000);
        $(".btn-page").hover(function(){
            clearInterval(picTimer)
        },function(){
            picTimer = setInterval(next,9999900000);
        })
    }
}
