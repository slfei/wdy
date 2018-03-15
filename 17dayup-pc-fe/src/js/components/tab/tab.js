$(function(){
    $('.tab-switch a').click(function(e){
        $(this).siblings().removeClass('tab_active center-active');
        $(this).addClass('tab_active center-active');
        $("#tab-main li").eq($(this).index()).show().siblings().hide();
    })

})
