import utils from '../../utils';

var scrollInit = function(){
    $('.discovery_scroll').on('scroll', utils.debounce(function(e){
        e.preventDefault();
        var scrollTop = $(this).scrollTop();
        var wrapHeight = $(this).height();
        var contentHeight = $(this).find('.discovery_scroll_area').height();
        var loadMoreThreshold = 50;
        var paddingBottom = 50;
        var canLoadMore = contentHeight - wrapHeight - scrollTop < (loadMoreThreshold - paddingBottom);
        if (canLoadMore) {
            console.log('loadmore', contentHeight - wrapHeight - scrollTop);
        }
        //if(Number($(this).scrollTop()) - Number($('.discovery_scroll_area').height()/2)>0 && scrollType){
        if (canLoadMore) {
           // console.log(page_num)
           // console.log(now_page)
           $('#loading').show();
            // scrollType = false
            now_page ++
            if(now_page == page_num){
               fnAjax(pullList)
            }
        }
    }, 100, true));
}


export { scrollInit }
