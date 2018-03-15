import empty from "../features/empty";

var page_num = 1;
var sort_type = 0;
var sort = 0;
var start = ''; 
var height = '';
var listen= 0;
var live=0;
var record=0;
var Type= '';
var CategoryId = '';
var now_page =1;
var scrollType = true;
var q = filterQ ||'';
function fnAjax(fun){
    q = $('input[type=search]').val()||'';       
    $.ajax({
        url: '../../search/course',
        type: 'GET',
        dataType: 'json',
        data: {page_size: 10,page_num:page_num,sort_type:sort_type,sort:sort,start:start,height:height,listen:listen,record:record,live:live,type:Type,category_id:CategoryId,q:q,is_json:1},
        success:function(res){
            if(res.status == 200 ){
                fun(res)
            }
        },
        error:function(){

        }
    })
};

function list(res){
    var data = res.data;
    if(!data){
        return $(".discovery_scroll_area").html(empty.normal())
    }
    $('.discovery_scroll_area').html(data);
    page_num ++;
    scrollType = true;
};

function pullList(res){
    var data = res.data;
    $('.discovery_scroll_area').append(data);
    if(data.length){
        page_num ++
        scrollType = true;
    }
};
function hideMask(){
    $('.js-active').find('li').removeClass('open');
    $('.discovery_filter').children().removeClass('active');
    $('.mask').hide();
};

$('.js-active li').on('click', function(){
    var index = $(this).index() + 1;
    $(this).siblings().removeClass('open');
    $(this).toggleClass('open').hasClass('open') ? $('.mask').show() : $('.mask').hide()
    $('.discovery_filter').children().eq(index).siblings().removeClass('active');
    $('.discovery_filter').children().eq(index).toggleClass('active');
});

$('.js-left').on('click','li',function(){
    var num = $(this).data('left');
    var level = $(this).data('level');
    $(this).addClass('active_left').siblings().removeClass('active_left');
    if(num != null){
        var html = ['<li data-getcenter="'+ level +'">全部</li>'];
        var data = courseData[num]?courseData[num]._child:[];
        data.forEach(function(item,i){
           html.push('<li data-center="'+ num +'-'+ i +'" data-getcenter="'+ (!item._child?item.category_id:"") +'">'+ item.name +'</li>');
        });
    }else{
        var  text = $(this).text();
        console.log(text)
        $('.js-active li').eq(1).find('span').text(text);
        $('.discovery_scroll').scrollTop(0)
        var html = [];
        CategoryId = '';
        page_num = 1;
        now_page = 1;
        hideMask();
        fnAjax(list);
    }
    $('.js-center').html(html.join(''))
    $('.js-right').html('');
});

$('.js-center').on('click', 'li',function(){
    var getcenter = $(this).data('getcenter');
    $(this).addClass('active_center').siblings().removeClass('active_center');
    var num = $(this).data('center')?$(this).data('center').split('-'):null;
    var html = ['<li data-request="'+ (num?courseData[num[0]]._child[num[1]]['category_id']:'') +'">全部</li>'];
    var data = num?courseData[num[0]]._child[num[1]]._child:[];
    if(getcenter==''){
        data.forEach(function(item,i){
            html.push('<li data-request="'+ item.category_id +'">'+ item.name +'</li>');
        });
        $('.js-right').html(html.join(''))
    }else{
        $('.discovery_scroll').scrollTop(0)
        var  text = $(this).text();
        if($(this).html()=='全部'){
            text=$('.js-left li.active_left').text()
        }
        $('.js-active li').eq(1).find('span').text(text);
        CategoryId = getcenter;
        page_num = 1;
        now_page = 1;
        hideMask();
        fnAjax(list);
    }
});


$('.js-right').on('click', 'li',function(){
    $(this).addClass('active_right').siblings().removeClass('active_right');
    $('.discovery_scroll').scrollTop(0)
    var  text = $(this).text(); 
    if($(this).html()=='全部'){
        text=$('.js-center li.active_center').text()
    } 
    if($(this).html()=='全部' && $('.js-center li.active_center').html()=='全部'){
        text=$('.js-left li.active_left').text()
    }    
    $('.js-active li').eq(1).find('span').text(text);
    CategoryId = $(this).data('request');
    page_num = 1;
    now_page = 1;
    hideMask();
    fnAjax(list);
});


$('.discovery_scroll').on('scroll',function(e){
    e.preventDefault();
    if(Number($(this).scrollTop())-Number($('.discovery_scroll_area').height()/2)>0 && scrollType){
        scrollType = false
        now_page ++
        if(now_page == page_num){
            fnAjax(pullList)
        }
    }
});
$('.js-sort').on('click', 'li',function(){
    $('.discovery_scroll').scrollTop(0)
    var dataSrot=$(this).data('sort').split('-');
    var text = $(this).text();
    $('.js-active li').eq(0).find('span').text(text);
    if(dataSrot[1]==0){
        sort_type = dataSrot[1];
        sort = '';
    }else{
        sort_type = dataSrot[1];
        sort = dataSrot[0];
    };
    page_num = 1;
    now_page = 1;
    hideMask();
    fnAjax(list);
});

$('.js-select1').on('click','li',function(){
    var $this=$(this);
    $this.toggleClass('select');
})
$('.js-select2').on('click','li',function(){
    var num =$(this).index();
    if($(this).hasClass('select')){
        $(this).removeClass('select');
        $(this).closest('ul').prev().find('input').eq(num).prop("checked",false);
    }else{
     $('.area2').find('li').removeClass('select');
     $(this).addClass('select');
     $(this).closest('ul').prev().find('input').eq(num).prop("checked",true);        
    }
});


$('.js-reset').on('click',function(){
    $('input').prop('checked',false);
    $('.discovery_filter_screen_area').find('li').removeClass('select');
});
$('.js-sure').on('click',function(){
    $('.discovery_scroll').scrollTop(0);
    var range=$('[name=range]:checked').val();
    var listenArr=[];
    $('.js-select1').find('li').each(function(){
        if($(this).hasClass('select')){
            listenArr.push(1)
        }else{
            listenArr.push(0)
        }
    });
    listen=listenArr[0];
    record = listenArr[1];
    live=listenArr[2];
    page_num = 1;
    now_page = 1;
    if(range){
        if(range=='0-0'){
            Type = 1;
            start = '';
            height = '';
        }else{
            Type = 2;
            start = range.split('-')[0];
            height = range!='1000-0'?range.split('-')[1]:'';
        }  
    }else{
        Type = "";
        start = '';
        height = '';
    }
    hideMask();
    fnAjax(list);
});
fnAjax(list);
    
