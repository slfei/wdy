import rq from '../../api.js'

var clearType = false;
// var currentUrl = location.href;

// if(currentUrl.indexOf('course/discovery') > 0){
//     window.replaceUrl = currentUrl;
// }
// console.log(history);

rq.post('/api/search/hotword').then(function(res){
    var html = [];
    res.forEach(function(item,i){
        html.push('<li>'+ item +'</li>')    
    })
    $('.hot_search_list').html(html.join(''))
})

$('.js_cancel').on('click',function(){
  $('.header-search').hide();
});

$('.js_tips').on('click',function(){
        $('.weui-search-bar__label').hide();
        $('[name=search]').focus();
});

$('[name=search]').on('blur',function(event) {
    $('.weui-search-bar__label').show()
});

$('.weui-search-bar__form').on('click',function(){
   $('.header-search').show();
   if(window.filterQ && !clearType){
     $('.weui-search-bar__label').hide();
     $('[name=search]').focus().val(filterQ);
   }else{
     $('.weui-search-bar__label').hide();
     $('[name=search]').focus().val('');
   }
});

$('.search_form').on('submit',function(e){
    e.preventDefault();    

    var searchUrl = '/search/course?q='+$('[name=search]').val();
    if(location.pathname == '/search/course'){
        history.replaceState({}, '伟东云学堂', searchUrl);
        location.reload();         
    }else{
        location.href = searchUrl;
    }
    
    $('.header-search').hide();
});

$('.js_hotlist').on('click','li',function(){
    // location.href='/search/course?q='+$(this).text();
    var searchUrl = '/search/course?q='+$(this).text(); 
    if(location.pathname == '/search/course'){
        history.replaceState({}, '伟东云学堂', searchUrl);
        location.reload();         
    }else{
        location.href = searchUrl;
    }
    $('.header-search').hide();
    
});

$('.weui-icon-clear').on('click',function(e){
    e.stopPropagation();
    $('.weui-search-bar__input').val('');
    clearType = true;
})
