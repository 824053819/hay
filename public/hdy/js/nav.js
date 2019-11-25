$(function () {
    var st = 180;
    $('#nav_all>li.my-class').mouseenter(function () {
        $(this).find('ul').stop(false, true).slideDown(st);
        $('#nav_two_bg').stop(false, true).slideDown(st);
    }).mouseleave(function () {
        $(this).find('ul').stop(false, true).slideUp(st);
        $('#nav_two_bg').stop(false, true).slideUp(st);
    });

     
});