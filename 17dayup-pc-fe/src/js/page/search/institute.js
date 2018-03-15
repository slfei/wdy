/**
 * Created by Administrator on 2017/9/27.
 */


$('.section-filter .goto').click(
    function(){
        var filter = window.FILTER;
        if(window.FILTER != $(this).attr('sort-type')){
            var url = '/search/institute?sort_type=' +　$(this).attr('sort-type') + '&q=' + (filter.q?filter.q:'');
            location.href = url;
        }
    }
);





