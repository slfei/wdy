
import '../components/dropload';
import common from '../../common'

var page_num_o = 0;
var page_num_t = 0;
var page_size = 10;
var num = 0;
var rank = 0;

function fnAjax(_this,index){
    var url = ['','/api/institute/course?institute_id='+ id +'&is_html=1&page_num='+ page_num_o,'/api/institute/comment?institute_id=' + id +'&is_html=1&page_num='+ page_num_t+'&rank='+ rank];
    if(url[index]){
        $.ajax({
            url: url[index],
            type: 'GET',
            success: function(res){
                if(res.status == 200 && res.data){
                    $('.list').eq(index).append(res.data);
                    _this.reload(_this);
                }else{
                   
                   if(index == 1 && $('.list').eq(index).children().length == 0){
                    $('.list').eq(index).append('<li class="no_comment"><img src="/static/img/icon/empty.png"><span>暂无课程</span></li>')
                   }

                   if(index == 2 && $('.list').eq(index).children().length == 1){
                    $('.list').eq(index).append('<li class="no_comment"><img src="/static/img/icon/empty.png"><span>暂无评价</span></li>')
                   }
                    _this.noData(index);
                }

                
            },
            error: function(){
            }
        })
    }else{
        _this.hide();
    }
};

$('.tab li').on('click',function(){
    num = $(this).index();
    $(this).addClass('active').siblings().removeClass('active');
    $('.list').eq(num).show().siblings('.list').hide();
});

var scrollload=$('.scroll_content').scrollload({
    loadDownFn: function(_this){
        if(num==1){
            page_num_o ++;
        }

        if(num==2){
            page_num_t ++;
        }
        fnAjax(_this,num); 
    },
    autoLoad: true,
    threshold: 50,
    checkoutTab: '.tab li'
});


$('.js_tab li').on('click',function(){
    rank = $(this).data('rank');
    page_num_t = 0;
    $(this).addClass('active').siblings().removeClass('active');
    $(this).closest('.nd_list').siblings().remove();
    scrollload.isData = true;
    scrollload.reload();
});

$('.js_course').on('click', function(){
    $('.tab li').eq(1).trigger('click');
})

common.initWechatShare(share)


