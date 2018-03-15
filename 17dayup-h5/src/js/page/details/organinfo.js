import Swiper from "swiper";
import '../components/dropload';
import common from '../../common'

var swiper = new Swiper('.swiper-container', {
    pagination: {
        el: '.swiper-pagination'
    },
    loop: false,
    autoplay: {
        delay: 5000,//5秒切换一次
      }
});

var page_num_o = 0;
var page_num_t = 0;
var page_size = 10;
var num = 0;

function fnAjax(_this,index){
    var url = ['','/api/institute/course?institute_id='+ id +'&is_html=1&page_num='+ page_num_o,'/api/institute/teacher?institute_id='+ id +'&is_html=1&page_num='+ page_num_t];
    if(url[index]){
        $.ajax({
            url: url[index],
            // url: 'json/data.json',
            type: 'GET',
            success: function(res){
                if(res.status == 200 && res.data){
                    $('.list').eq(index).append(res.data);
                    _this.reload(_this);
                }else{
                    if(index == 1 && $('.list').eq(index).children().length == 0){
                      $('.list').eq(index).append('<li class="no_comment"><img src="/static/img/icon/empty.png"><span>暂无课程</span></li>')
                    }

                    if(index == 2 && $('.list').eq(index).children().length == 0){
                       $('.list').eq(index).append('<li class="no_comment"><img src="/static/img/icon/empty.png"><span>暂无老师</span></li>')
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


$('.js_course').on('click', function(){
    $('.tab li').eq(1).trigger('click');
})

$('.js_teacher').on('click', function(){
    $('.tab li').eq(2).trigger('click');
})

console.log(share)
common.initWechatShare(share)
