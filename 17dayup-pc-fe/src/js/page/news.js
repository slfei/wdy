$(function() {
    function stopPropagation(e) {
        if (e.stopPropagation)
            e.stopPropagation();
        else
            e.cancelBubble = true;
    }
    $('#drop-btn').click(function() {
        $('#news_category').fadeToggle(300);
    });

    // $(document).bind('click', function(e) {  
    //     var e = e || window.event; //浏览器兼容性   
    //     var elem = e.target || e.srcElement;  
    //     if (elem.id != 'news_category' && elem.className != 'each_cat' && elem.className != 'triangle-down') {
    //         $('#news_category').css('display', 'none'); //点击的不是div或其子元素
    //     }     
    // });
})
