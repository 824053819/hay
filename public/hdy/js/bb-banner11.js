$(function () {
    $('.banner').unslider({arrows: true, dots: true});
    $('.section4 .dots').eq(1).hide();
    $('.banner .dot').mouseover(function () {
        $(this).closest('.banner').find('ul').stop();
        $(this).click();
    });
 /*   $('.banner').hover(function () {
        $(this).toggleClass('hover');
    });*/
    $('.mask').hover(function(){
        $(".position").fadeToggle(1000);
    })
    // $('.listbox>.e2>li').mouseover(function(){
    //     $(this).children('span').addClass('xs');
    //     $(this).siblings().children('span').removeClass('xs');
    // },mouseout(function(){
    //      $(this).children('span').removeClass('xs');
    // }));
    
});
