import utils from '../../utils';
import empty from "../features/empty"

var page_num = 1;
var sort_type = 0;
var sort = 1;
var start = ''; 
var height = '';
var listen= 0;
var Type= '';
var CategoryId = '';
var now_page =1;
var scrollType = true;
var page_size = 10;

function fnAjax(fun){
    $.ajax({
        url: '../../api/center/course',
        type: 'post',
        dataType: 'json',
        data: {
            page_size: page_size,
            page_num:page_num,
            sort:sort,
            start:start,
            type:Type},
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
    var html =[];
    var data = res.data.list;

    if(data.length == 0){
        // empty data
        $('.discovery_scroll_area').html(empty.normal('还没有报名课程，赶紧选课吧~'));
    }else{
        data.forEach(function(item,i){
            html.push(`<li>
                <a href="/course/${item.course_id}?tab=1&autoPlay=true">
                    <div class="discovery_list_img">
                        <img src="${item.course_img}">
                        <div class="progress">学习进度${item.speed}/${item.class_num}</div>
                    </div>
                    <div class="discovery_list_info">
                        <div class="discovery_list_info_title">
                            ${item.course_name}
                        </div>
                        <div class="discovery_list_info_name">
                            ${item.end_time}
                        </div>
                    ${item.speed>0? '<div class="discovery_list_info_free">继续学习</div>'
                        :'<div class="discovery_list_info_start">开始学习</div>'
                    }
                    </div>
                </a>
            </li>`)
         });
         
         html.push('<li id="loading" class="load"><img src="/static/img/load/loading.gif"></li>');

         $('.discovery_scroll_area').html(html.join(''));
         if(data.length==page_size){
            $('#loading').show();
         }else{
            $('#loading').html('<span>我是有底线的</span>').show();
         }
         page_num ++
         scrollType = true;
    }


    // now_page ++
};

function pullList(res){
    var html =[];
    var data = res.data.list;
    
    if(!data.length){
          $('#loading').html('<span>我是有底线的</span>')
    }

    data.forEach(function(item,i){
        html.push(`
        <li>
            <a href="/course/${item.course_id}?tab=1&autoPlay=true">
                <div class="discovery_list_img">
                    <img src="${item.course_img}">
                    <div class="progress">学习进度${item.speed}/${item.class_num}</div>
                </div>
                <div class="discovery_list_info">
                    <div class="discovery_list_info_title">
                        ${item.course_name}
                    </div>
                    <div class="discovery_list_info_name">
                        ${item.end_time}
                    </div>
                ${item.speed>0? '<div class="discovery_list_info_free">继续学习</div>'
                    :'<div class="discovery_list_info_start">开始学习</div>'
                }
                </div>
            </a>
        </li>
        `)
    });

    $('#loading').before(html.join(''));
    if(data.length){
         page_num ++
         scrollType = true;
         // now_page ++
    }

};

function hide(){
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
        hide();
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
        $('.js-active li').eq(1).find('span').text(text);
        CategoryId = getcenter;
        page_num = 1;
        now_page = 1;
        hide();
        fnAjax(list);
    }
});

$('.js-right').on('click', 'li',function(){
    $('.discovery_scroll').scrollTop(0)
    var  text = $(this).text();
    $('.js-active li').eq(1).find('span').text(text);
    CategoryId = $(this).data('request');
    page_num = 1;
    now_page = 1;
    hide();
    fnAjax(list);
});

$('.discovery_scroll').on('scroll', utils.debounce(function(e){
    e.preventDefault()
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
    if (canLoadMore && scrollType) {

       $('#loading').show();
        scrollType = false
        now_page ++
        if(now_page == page_num){
           fnAjax(pullList)
        }
    }
}, 100, true));

$('.js-sort').on('click', 'li',function(){
    $('.discovery_scroll').scrollTop(0)
    var  dataSrot=$(this).data('sort')
    var  text = $(this).text();
    $('.js-active li').eq(0).find('span').text(text);
    // var data ={page_size: 20,page_num:page_num,sort_type:0,sort:1,start:0,height:1,listen:1,Type:1,CategoryId:1}
    // if(dataSrot[1]==0){
    //    sort_type = dataSrot[1];
    //    sort = '';
    // }else{
    //    sort_type = dataSrot[1];
       sort = dataSrot;
    // };

    page_num = 1;
    now_page = 1;

    hide();
    fnAjax(list);
});

$('.js-select1').on('click','li',function(){
    var num =$(this).index();
    $('.area1').find('li').removeClass('select');
    $(this).addClass('select');
    $(this).closest('ul').prev().find('input').eq(num).prop("checked",true)
});

$('.js-select2').on('click','li',function(){
    var num =$(this).index();
    $('.area2').find('li').removeClass('select');
    $(this).addClass('select');
    $(this).closest('ul').prev().find('input').eq(num).prop("checked",true)
});

$('.js-reset').on('click',function(){
    $('input').prop('checked',false);
    $('.discovery_filter_screen_area').find('li').removeClass('select');
});

$('.js-sure').on('click',function(){
    $('.discovery_scroll').scrollTop(0);
    var range=$('[name=range]:checked').val();
    //  listen = $('[name=listen]:checked').val()?1:0;

    if(range){
        if(range=='0-0'){
            Type = range=='0-0'?1:'';
        }else{
            Type = range;
            // start = range.split('-')[0];
            // height = range!='1000-0'?range.split('-')[1]:'';
        }
        page_num = 1;
        now_page = 1;
        fnAjax(list);
    }else if(listen){
        page_num = 1;
        now_page = 1;
        fnAjax(list);
    }else if(range==undefined){
        Type=''
        page_num = 1;
        now_page = 1;
        fnAjax(list);
    }

    hide();
   
});

fnAjax(list)
