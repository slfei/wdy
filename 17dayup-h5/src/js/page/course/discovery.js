    import utils from '../../utils';
    import empty from "../features/empty"

    var page_num = 1;
    var sort_type = 0;
    var sort = 0;
    var start = ''; 
    var height = '';
    var listen= 0;
    var live=0;
    var record=0;
    var Type= '';
    var CategoryId = treeData.length?treeData[treeData.length-1]:'';
    var now_page =1;
    var scrollType = true;
    var Tree = ($tplData.category_tree?$tplData.category_tree.join('-'):null);
    var page_size = 10;
    function fnAjax(fun){
      
        $.ajax({
            url: '../../api/course/getlist',
            type: 'post',
            dataType: 'json',
            data: {page_size: page_size,page_num:page_num,sort_type:sort_type,sort:sort,start:start,height:height,listen:listen,record:record,live:live,type:Type,category_id:CategoryId},
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
        var data = res.data;

        if(data.length == 0){
            // empty data
            $('.discovery_scroll_area').html(empty.normal());
        }else{


            data.forEach(function(item,i){
                // item.is_coupon = false;
                html.push('<li><a href="/course/'+ item.course_id +'"><div class="discovery_list_img"><img src="'+ item.course_img +'"> '+(item.is_coupon?'<span class="coupon-sign">支持优惠券</span>':'')+'</div><div class="discovery_list_info"><div class="discovery_list_info_title">'+ item.course_name +'</div><div class="discovery_list_info_name">'+ item.from_name +'</div>'+(item.type==1?'<div class="discovery_list_info_free">免费</div>':'<div class="discovery_list_info_price">¥ '+ (item.cur_price!=item.price? item.cur_price:item.price) +'</div>')+'</div></a></li>')
             });
            html.push('<li id="loading" class="load"><img src="/static/img/load/loading.gif"></li>');
             // html.push();

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
        var data = res.data;
        
        if(!data.length){
          $('#loading').html('<span>我是有底线的</span>')
        }

        data.forEach(function(item,i){
            // item.is_coupon = false;
           html.push('<li><a href="/course/'+ item.course_id +'"><div class="discovery_list_img"><img src="'+ item.course_img +'">'+(item.is_coupon?'<span class="coupon-sign">支持优惠券</span>':'')+'</div><div class="discovery_list_info"><div class="discovery_list_info_title">'+ item.course_name +'</div><div class="discovery_list_info_name">'+ item.from_name +'</div>'+(item.type==1?'<div class="discovery_list_info_free">免费</div>':'<div class="discovery_list_info_price">¥ '+ (item.cur_price!=item.price? item.cur_price:item.price) +'</div>')+'</div></a></li>')
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
            if($(this).html()=='全部'){
                text="全部课程"
                history.replaceState({}, '伟东云学堂', "?type=");
            }
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
        Tree = num?courseData[num[0]]._child[num[1]]['cat_tree'] + courseData[num[0]]._child[num[1]]['category_id']:[];

        if(getcenter==''){
           data.forEach(function(item,i){
               html.push('<li data-request="'+ item.category_id +'">'+ item.name +'</li>');
           });
           $('.js-right').html(html.join(''))
        }else{
            $('.discovery_scroll').scrollTop(0)
            var  text = $(this).text();
            //console.log(this,$('.js-left li').hasClass('active_center'))
            if($(this).html()=='全部'){
                text=$('.js-left li.active_left').text()
            }
            $('.js-active li').eq(1).find('span').text(text);
            CategoryId = getcenter;
            page_num = 1;
            now_page = 1;
            hide();
            history.replaceState({}, '伟东云学堂', "?type=" + Tree);
            $('.js-right').html('')
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
        console.log(Tree)
        var TreeArr = Tree.split('-');
        if(TreeArr.length == 3){
            TreeArr[2] = $(this).data('request');
            Tree = TreeArr.join('-');
        }else{
            Tree = Tree + '-' + $(this).data('request');
        }
        
        page_num = 1;
        now_page = 1;
        history.replaceState({}, '伟东云学堂', "?type=" + Tree);
        hide();
        fnAjax(list);
    });

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
        var  dataSrot=$(this).data('sort').split('-');
        var  text = $(this).text();
        $('.js-active li').eq(0).find('span').text(text);
        $(this).addClass('cur').siblings().removeClass('cur')
        // var data ={page_size: 20,page_num:page_num,sort_type:0,sort:1,start:0,height:1,listen:1,Type:1,CategoryId:1}
        if(dataSrot[1]==0){
           sort_type = dataSrot[1];
           sort = '';
        }else{
           sort_type = dataSrot[1];
           sort = dataSrot[0];
        };

        page_num = 1;
        now_page = 1;
        hide();
        fnAjax(list);
    });
    $('.js-select1').on('click','li',function(){
        var $this=$(this);
        $this.toggleClass('select');
    });

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
        })
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
        };
        hide();
        fnAjax(list);
       
    });

    // 控制筛选显隐
    $('.js_cancel').on('click',function(){
        $('.header-search').hide();
    });
      
    $('.icon-search').on('click',function(){
        $('.header-search').show();
    });

    function setName(){
        if($('.js-center li.active_center').html()=='全部'){
            var text=$('.js-left li.active_left').text();
            $('.js-active li').eq(1).find('span').text(text);
        } 
        

    }
    function getTypeStr(){

    }

fnAjax(list);
//从首页更多进入后，设置显示名
setName();
