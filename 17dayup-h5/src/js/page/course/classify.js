/**
 * Created by Administrator on 2017/11/6.
 */
$('.left li').click(function(){
    $('.wdy-scroll-wrapper').scrollTop(0);
    $('.left li').removeClass('active');
    $(this).addClass('active');
    var dataToggle = $(this).attr('data-toggle');
    $('.section-item').removeClass('show')
    $('.section-item').each(function(i, ele){
        if($(ele).attr('value')==dataToggle){
            // $(ele).addClass('show');            
            setTimeout(function(){
                // important used to trigger height recalculate
                console.log($('.list-unstyled.right').height());
            }, 100)
            $('.menu-content').html($(ele).html())
            // var myScroll = new IScroll('.menu-container', {
            //     scrollbars: true
            // });
            myScroll.refresh();
        }
    })
});



var myScroll = new IScroll('.menu-container', {
    click: true
});

console.log("xxx");
