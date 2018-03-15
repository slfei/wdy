
import '../components/slider/slider.js';
import '../ads/guoxuechunwan.js';

$(".section-course-block .cate-name").click(function(){
    var $root = $(this).closest('.section-course-block');
    $(this).siblings('.cate-name').removeClass('active');
    $(this).addClass('active');

    var id = $(this).data("category-id");
    $root.find('.right').addClass('hide').filter('[data-category-id=' + id + ']').removeClass('hide');
    $root.find('.bd').addClass('hide').filter('[data-category-id=' + id + ']').removeClass('hide');

});

var $childList = $('#J-child-cat-list');
$('#J-category-list li').hover(function() {
    var id = $(this).data('category-id');
    var list = $childList.find('.sub-category-list').hide();
    list.filter('[data-category-id="' + id + '"]').show();
    $('.section-banner .main-container').on('mouseleave', function bind()  {
        list.hide();
        $(this).off('mouseleave', bind);
    });
});


var scroller = $('.section-relative-products .scroller');
$('.section-relative-products .prev').on('click', function() {
    scroller.animate({
        'scrollLeft': scroller[0].scrollLeft - 150
    });
    clearInterval(window.timerProducts);
    window.timerProducts = setInterval(products ,5000);
});
$('.section-relative-products .next').on('click', function() {
    scroller.animate({
        'scrollLeft': scroller[0].scrollLeft + 150
    });
    clearInterval(window.timerProducts);
    window.timerProducts = setInterval(products ,5000);
});

$('.main-category-list .category-item').click(function(){
    var num = $(this).attr('data-i');
    $('.main-category-content').each(function(i, ele){
        if(!$(ele).hasClass('hide')){
            $(ele).addClass('hide');
        }
        if($(ele).attr('value')==num){
            $(ele).removeClass('hide');
        }
    });
    $('.main-category-list .active').removeClass('active');
    $(this).addClass('active');
    $('.main-category-content.show').removeClass('show').addClass('hide');
    $('.main-category-content[value="'+ num +'"]').removeClass('hide').addClass('show');
    clearInterval(window.timerFreeCategory);
    window.timerFreeCategory = setInterval(freeCategory, 5000);
});
var dataI = 0;
var freeCategory = function(){
    var activeELm = $('.main-category-list .active');
    dataI = activeELm.attr('data-i');
    if(dataI==5){
        activeELm.removeClass('active')  ;
        $('.main-category-content.show').removeClass('show').addClass('hide');
        $('.main-category-list [data-i="0"]').addClass('active');
        $('.main-category-content[value="0"]').removeClass('hide').addClass('show');
    }else{
        activeELm.removeClass('active').next().addClass('active');
        $('.main-category-content.show').removeClass('show').addClass('hide').next().removeClass('hide').addClass('show');

    }
};
var products = function(){
    if(scroller[0].scrollLeft>=(productsCount-8)*150-10){
        scroller.animate({
            'scrollLeft': 0
        });
    }else{
        scroller.animate({
            'scrollLeft': scroller[0].scrollLeft + 150
        });
    }
};
window.timerFreeCategory = setInterval(freeCategory, 5000);
if(productsCount>8){
    window.timerProducts = setInterval(products ,5000);
}


