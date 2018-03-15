// $(".focus-slider").unslider();


import Swiper from "swiper";

var swiper = new Swiper('.swiper-container', {
    pagination: {
        el: '.swiper-pagination'
    },
    loop: true,
    autoplay: {
        delay: 5000,//5秒切换一次
      }
});
console.log($("img.lazy"));

if ($.fn.lazyload) {
    $("img.lazy").lazyload({
        threshold: 1000,
        failurelimit:0,
        skip_invisible : false,
        event : "scroll",
        container:$('.wdy-scroll-wrapper')
    });
}

// $("img.lazy").lazyload({
//     threshold: 1,
//     failurelimit:0,
//     skip_invisible : false,
//     event : "scroll",
//     container:$('.x-swiper-wrapper')
// });

$(".x-swiper-wrapper").each(function (i, elem) {
    // console.log(elem);
    var root = $(elem);
    var covers = root.find(".cover");
    var cWidth = covers.width();
    var num = covers.length;
    //root.width(num * wtw.dpr * (5+160));
    root.width(elem.scrollWidth);
    root.css('overflow', 'hidden');

    // new IScroll(elem, {
    // scrollX: true,
    // scrollY: false
    // })



})


$(".x-swiper-container").each(function (i, elem) {
    if(i == 0 ){
        var scroll = new IScroll(elem, {
            scrollX: true,
            eventPassthrough: true,
            probeType: 3,
            preventDefault:false,
            vScroll:false
            
        })

        var scrollElem = $(elem).find(".x-swiper-wrapper");
        var items = scrollElem.find(".cover");
        var itemWidth = scrollElem.width() / items.length;
        
        function updateTab(e){
            var scrollLeft = -1 * scrollElem.css('transform').split(",")[4]
            // console.log(scrollLeft, itemWidth);
            var currentItemIndex = Math.floor(scrollLeft/itemWidth + 0.5);
            // var currentItemIndex = 2;
            // scrollLeft/itemWidth
            var currentItem = items.eq(currentItemIndex);
            $(".title-desc").html(currentItem.data('cate'));
            var indicators = $(".x-swiper-indicator").children();
            indicators.removeClass("active");
            indicators.eq(currentItem.data('cate-id'))
                .addClass('active'); 
        }
       
        
        scroll.on('scroll', updateTab)
        scroll.on('scrollEnd', updateTab)
       
        
       
    }else{
        var elseScroll = new IScroll(elem, {
            // scrollX: true,
            // eventPassthrough: false
            scrollX: true,
            eventPassthrough: true,
            preventDefault:false,
            vScroll:false
        });
        function test(e){
            $('.wdy-scroll-wrapper').trigger('scroll');
        }
        elseScroll.on('scrollEnd', test)
    }
})

console.log("index page")


// var scroll = new IScroll(".x-swiper-container", {
//     scrollX: true,
//     scrollY: false,
//     scrollbars: true
// });
