
/**
 * 排序
 */
$('.js_sort li').on('click', function(){
   var data = $(this).data('sort');
   if(!FILTER.category_id){
    location.href =  '/institute/list/?sort=1&sort_type=' + data;
   }else{
    location.href =  '/institute/list/'+ FILTER.category_id +'/?sort=1&sort_type=' + data;
   }
});

