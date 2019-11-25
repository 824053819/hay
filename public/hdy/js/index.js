if (document.documentElement) {
    var docWidth = document.documentElement.scrollWidth;
    var docHeight = document.documentElement.scrollHeight;
} else {
    var docWidth = document.body.scrollWidth;
    var docHeight = document.documentElement.scrollHeight;
}
// 动态兼容移动
if (docWidth > 750) {
    $(".New-index-item .pnone").css("display","block");
    console.log($(".New-index-item .pnone"))
    $(".index-banner .banner-ul .fl div").css("display","block");
   // 科研文献右边的高度问题
    var bg = $(".bg");
    var s_con = $(".s-con");
    for(var i = 0; i < bg.length; i ++){
        bg.eq(i).css("height", s_con.eq(i).outerHeight() + "px");
    };

    $(window).resize(function () {
        $(".Experts-wrap-row").css({
            "width": $(".cont-left").width() + 10 + "px",
            "margin-left": "-5px"
        });
    });
    // 轮播图样式
    var banner_ul = $(".banner-ul");
    var banner_dot = $(".banner-dot");

    if (banner_ul.children("li").length == 1) {
        banner_dot.css("display", "none");
        $(".banner-prev").css("display", "none");
        $(".banner-next").css("display", "none");
    } else {

        var addli = banner_ul.children("li").first().clone(true);
        var addli1 = banner_ul.children("li").last().clone(true);
        var liWidth = banner_ul.children("li").outerWidth();
        //在最后追加一个图片
        banner_ul.append(addli);
        banner_ul.prepend(addli1);
        var li_length = banner_ul.children("li").length;
        banner_ul.css("left", -liWidth + "px");
        for (var i = 0; i < li_length - 2; i++) {
            var li = $("<li></li>");
            banner_dot.append(li);
        }

        banner_dot.children("li").eq(0).addClass("dot-active");

        var ulWidth = (li_length + 2) * liWidth;

        $(".banner-ul").css("width", ulWidth);

        var li_index = 1;
        var dot_index = 0;
        $(".banner-prev").click(function () {
            clearTimeout(Timer);
            li_index--;
            if (li_index == 0) {
                banner_ul.animate({
                    "left": 0
                }, 200, function () {
                    banner_ul.css("left", -(liWidth * (li_length - 2)));
                });
                li_index = li_length - 2;
                dot_index--;
                bannerDot();
                Timer = setTimeout(nextBanner, 3000);
            } else {
                dot_index--;
                bannerDot();
                banner_ul.animate({
                    "left": -(liWidth * li_index)
                }, 200);
                Timer = setTimeout(nextBanner, 3000);
            }
        });
        $(".banner-next").click(function () {
            clearTimeout(Timer);
            li_index++;
            if (li_index == li_length - 2) {
                banner_ul.animate({
                    "left": -(liWidth * li_index)
                }, 200, function () {
                    banner_ul.css("left", 0);
                });
                li_index = 0;
                dot_index++;
                bannerDot();
                Timer = setTimeout(nextBanner, 3000);
            } else {
                dot_index++;
                bannerDot();
                banner_ul.animate({
                    "left": -(liWidth * li_index)
                }, 200);
                Timer = setTimeout(nextBanner, 3000);
            }
        });
        //小点的函数
        function bannerDot() {
            if (dot_index >= li_length - 2) {
                dot_index = 0;
            }
            if (dot_index <= -1) {
                dot_index = li_length - 3;
            }
            banner_dot.children("li").removeClass("dot-active");
            banner_dot.children("li").eq(dot_index).addClass("dot-active");
        }
        // 自动往下
        var Timer = null;
        Timer = setTimeout(nextBanner, 3000);
        // 往下
        function nextBanner() {
            clearTimeout(Timer);
            li_index++;
            if (li_index == li_length - 2) {
                banner_ul.animate({
                    "left": -(liWidth * li_index)
                }, 300, function () {
                    banner_ul.css("left", 0);
                });
                li_index = 0;
                dot_index++;
                bannerDot();
                Timer = setTimeout(nextBanner, 3000);
            } else {
                dot_index++;
                bannerDot();
                banner_ul.animate({
                    "left": -(liWidth * li_index)
                }, 500);
                Timer = setTimeout(nextBanner, 3000);
            }
        };

        mouseClear(banner_ul);
        mouseClear($(".banner-prev img"));
        mouseClear($(".banner-next img"));
        mouseSet(banner_ul);
        mouseSet($(".banner-prev img"));
        mouseSet($(".banner-next img"));

        function mouseClear(el) {
            el.mouseover(function () {
                clearTimeout(Timer)
            });
        }

        function mouseSet(el) {
            el.mouseout(function () {
                Timer = setTimeout(nextBanner, 3000);
            });
        }
    }


    // 头部样式
    var nav_two_bg = $("#nav_two_bg");
    var Links = $(".Links");
    var link_li = $(".link-li");

    function setnav(num) {
        nav_two_bg.animate({
            "height": num
        }, 200);
    }
    // 显示隐藏下边的那个条
    $(".Links").mouseenter(function (e) {
        var target = $(e.target);
        if (target.is("li") && target.hasClass("bg-blank")) {
            nav_two_bg.height("0");
        } else {
            setnav("50px");
        }
    });
    $(".Links").mouseleave(function () {
        setnav("0");
    });
    $(".Links .bg-blank").mouseenter(function () {
        setnav("0");
    })

    //显示隐藏链接
    link_li.mouseenter(function () {
        if (nav_two_bg.height() <= "50" && !($(this).hasClass("bg-blank"))) {
            setnav("50px");
        }
        if (!($(this).hasClass("nav-form"))) {
            $(this).addClass("link-line");
            $(this).children(".link-none").css("display", "block").animate({
                "opacity": "1"
            }, 200);
        }
    });

    link_li.mouseleave(function () {
        $(this).removeClass("link-line");
        $(this).children(".link-none").css("display", "none").animate({
            "opacity": "0"
        }, 200);
    });
} else {
    //去除首页的文字

    //点击的时候移动 以及显示
    var nav_two_bg = $("#nav_two_bg");
    var Links = $(".Links");
    var link_li = $(".link-li");
    var Links_wrap = $(".Links-wrap");
    var logo_wrap = $(".logo-wrap");
    var logo_wrap2 = logo_wrap.clone(true);
    // 克隆一个，添加到整个盒子外边
    if (index) {
        logo_wrap2.children(".logo").children("img").attr("src", "/hdy/img/logo2.png");
    } else {
        logo_wrap2.children(".logo").children("img").attr("src", "/hdy/img/logo2.png");
    }
    Links_wrap.prepend(logo_wrap2);
    Links.children(link_li).removeClass("fl");
    link_li.children(".link-none").children("li").removeClass("fl");


    $(".line-close").on("click", function (e) {
        e.preventDefault();
        var num = Links_wrap.css("left").replace("px", "");
        if (Math.ceil(num) == -docWidth) {
            Links_wrap.animate({
                "left": "0"
            }, 300);
        } else {
            Links_wrap.animate({
                "left": "-100vw"
            }, 300);
            $(".nav .Links-add").animate({
                "left": "-100%"
            }, 300, function () {
                $(".nav .Links-add").remove();
            });

        }
    });

    link_li.children(".link-title").on("click", function (e) {
        if (!($(e.target).is("a"))) {
            e.preventDefault();
        }
        var topNum = logo_wrap2.outerHeight(true);
        var heightNum = docHeight - logo_wrap2.outerHeight(true);

        var li = $("<li></li>");
        var ul = $(this).parent().children(".link-none").clone(true);
        var title = $(this).text();
        li.text(title).css("border-bottom", "1px solid #ddd");
        ul.prepend(li);
        ul.addClass("Links-add");
        $(".nav").append(ul);
        ul.css({
            "top": topNum + "px",
            "height": heightNum + "px"
        }).animate({
            "left": "0"
        }, 300);

        li.on("click", function (e) {
            e.preventDefault();
            ul.animate({
                "left": "100%"
            }, 300, function () {
                ul.remove();
            })
        });

    })
    //克隆一个搜索框 然后删除原来的
    var nav_form = $(".nav .nav-form").clone(true);
    if (index) {
        nav_form.removeClass("link-li").find(".searchaction").attr("src", "/hdy/img/search.png");
    } else {
        nav_form.removeClass("link-li").find(".searchaction").attr("src", "/hdy/img/search.png");
    }
    $(".nav .nav-form").remove();
    Links.prepend(nav_form);

}
