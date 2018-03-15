
<?php $nav_index = 1 ?>
@extends('mobile.base')

<?php
    $str = '';
    foreach ($tplData['category_chip'] as $key=>$item){
        $str .= ',' . $item['name'];
    };
?>



@section('p-title'){{$tplData['course_name']}}_伟东云学堂@stop
@section('meta-keywords'){{$tplData['course_name']}}{{$str}}@stop
@section('meta-description')伟东云学堂涵盖了国学文化、亲子早教、基础教育、留学语言、IT互联网、职业技能、兴趣爱好以及国际教育等多个领域教育产品，为国内外互联网用户提供了专业优质的教育资源搜索、在线学习、教育资讯以及在线交易等全方位的教育互联网服务。@stop

@section('style')
<link rel="stylesheet" href="/static/lib/videojs/video-js.min.css">
<link rel="stylesheet" href="/static/css/page/course/detail.css">
<link rel="stylesheet" href="/static/lib/share/css/share.min.css">
@stop

@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '课程详情',
			'backward' => true,
			'right_html'=>'<span class="share">
				             <p></p>
				             <p></p>
				             <p></p>
			               </span>'                       
		]])
	@endcomponent 
@stop
             
@section('content')

   @component("mobile.course.share",['data'=>$tplData])
   @endcomponent
<div class="clearfix detail">
	<div class="section-img" style="background-image:url({{$tplData['course_img']}})">
		<?php
			$auditionId = isset($tplData['audition']) ? $tplData['audition'] : (count($tplData['course_catelog'])?$tplData['course_catelog'][0]['_child'][0]['id']:0);
            $show_coupon = isset($tplData['is_coupon']) ?$tplData['is_coupon'] :false;
        ?>
		@if($tplData['is_listen']==1)
        <div class="audition clearfix">
            <a id="header-play" data-section-id="{{$auditionId}}">
                <img src="/static/img/course/play.png" alt=""/>
            </a>
        </div>
        @endif
        <div class="live-recent-cont clearfix">
            @if($tplData['live_info'])
            <div class="live-recent-text">
                @if($tplData['live_info']['live_status']==0)
                    <p>最近直播：{{$tplData['live_info']['title']}}</p>
                @else
                    <p>正在直播：{{$tplData['live_info']['title']}}</p>
                @endif
                <p>直播时间：{{$tplData['live_info']['longtime']}}</p>
            </div>
            @endif
        </div>
        <div id="player" class="player" style="display:none;width:100%;margin: 0 auto">
            <video id="video"
                   class="video-js vjs-wdy-skin"
                   webkit-playsinline playsinline="true"
                   x5-video-player-type='h5'
                   preload autoplay></video>
        </div>
        <div id="id_test_video" style="width:100%; height:auto; margin: 0 auto">
            
        </div>
        <div class="live-tips"><p>休息一下，马上回来！</p></div>
    </div>
    <div class="action" id="statusBtn">
        <a href="javascript:void(0)" class="apply">报名学习</a >
    </div>
    <div class="clearfix content-block section-presentation">
        <ul id="tab" class="">
            <li id="tab1" class="active">详情</li>
            <li id="tab2">目录</li>
            <li id="tab3">评价<span></span></li>
        </ul>
        <div id="container">
            <div id="content1" class="tab-content">
                <div class="course-title">{{$tplData['course_name']}}</div>
                <p class="course-description">{{$tplData['sentence']}}</p>
                <div class="course-price">
                    @if($tplData['cur_price']==0)
                    <span class="cur-free color-dimgray">免费</span>
                    @else
                    <span class="cur-price">￥{{$tplData['cur_price']}}</span>
                    @endif
                    @if($tplData['cur_price']<$tplData['price'])
                    <span class="original-price">￥{{$tplData['price']}}</span>
                    <p class="tag">
                        <span class="tag-text">惠</span>
                        <span class="discounts">优惠活动：限时打折
                        @if($show_coupon)
                        支持优惠券使用
                        @endif
                        </span>
                    </p>
                    @endif
                    @if($tplData['cur_price']>=$tplData['price'] && $show_coupon)
                    <p class="tag">
                        <span class="tag-text">惠</span>
                        <span class="discounts">优惠活动：支持优惠券使用</span>
                    </p>
                    @endif

                    <div class="promise">
                        服务承诺：
                        @if($tplData['is_refund']==1)
                        <span class="refund-t">退</span>
                        <span class="refund">开课前随时退</span>
                        @else
                        无
                        @endif
                    </div>
                    
                </div>
                <div class="intro rich-text">
                    <div class="intro-title">课程概况</div>
                    {!! $tplData['intro'] !!}
                </div>
                @if(isset($tplData['teacher']))
                <div class="teacher">
                    <div class="title">课程讲师</div>
                    @foreach($tplData['teacher'] as $teacher)
                    <div class="clearfix wt-media media-padding"  data-id="{{$teacher['id']}}">
                        <div class="media-left pull-left">
                            <a href="/teacher/courselist/{{$teacher['id']}}"><img class="img-circle" src="{{$teacher['avatar']}}"></a>
                        </div>
                        <div class="media-body pull-left">
                            <div class="modal-title">
                                <a href="/teacher/courselist/{{$teacher['id']}}">{{$teacher['name']}}</a>
                            </div>
                            <p class="text-justify">
                             @if($teacher['sentence'])
                             {{$teacher['sentence']}}
                             @else
                             老师暂时没想到一鸣惊人的签名
                             @endif
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                @if($tplData['institute'])
                <div class="institute">
                    <div class="title">所属机构</div>
                    <div class="clearfix wt-media media-padding"  data-id="{{$tplData['institute']['institute_id']}}">
                        <div class="pull-left media-left">
                                @if($tplData['institute']['from_type']=='institute')
                                <a href="/institute/homepage/{{$tplData['institute']['institute_id']}}"><img class="img-circle" src="{{$tplData['institute']['logo']}}"></a>
                                @else
                                <a href="/personal/homepage/{{$tplData['institute']['institute_id']}}"><img class="img-circle" src="{{$tplData['institute']['logo']}}"></a>
                                @endif
                        </div>
                        <div class="pull-left media-body">
                            <div class="modal-title">
                                @if($tplData['institute']['from_type']=='institute')
                                <a href="/institute/homepage/{{$tplData['institute']['institute_id']}}">{{$tplData['institute']['ins_show_name']}}</a>
                                @else
                                <a href="/personal/homepage/{{$tplData['institute']['institute_id']}}">{{$tplData['institute']['ins_show_name']}}</a>
                                @endif
                            </div>
                            <div class="data">
                                <div class="institute-data data-good">
                                    <div class="text-center">
                                        <div class="">好评度</div>
                                        <div class="percent">{{$tplData['institute']['praise']}}</div>
                                    </div>
                                </div>
                                <div class="institute-data data-count">
                                    <div class="">
                                        <div class="">课程数</div>
                                        <div class="percent">{{$tplData['institute']['course_num']}}</div>
                                    </div>
                                </div>
                                <div class="institute-data data-student">
                                    <div class="text-center">
                                        <div class="">学生数</div>
                                        <div class="percent">{{$tplData['institute']['student_num']}}</div>
                                    </div>
                                </div>
                            </div>
                            <p class="text-justify short-des">
                                {{$tplData['institute']['short_des']}}
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                @if($tplData['relevant'])
                <div class="relevant">
                    <div class="title">推荐课程</div>
                    @forEach($tplData['relevant'] as $key=>$item)
                    <div class="clearfix wt-media media-padding"  data-id="{{$item['course_id']}}" >
                        <div class="pull-left media-left">
                            <img src="{{$item['image']}}">
                        </div>
                        <div class="pull-left media-body">
                            <div class="modal-title">
                                {{$item['course_name']}}
                            </div>

                            @if($item['price']==0)
                            <p class="modal-description noprice">
                               免费
                            </p>
                            @else
                            <p class="modal-description">
                                ￥{{$item['price']}}
                            </p> 
                            @endif                           
                        </div>
                    </div>
                    @endforEach
                </div>
                @endif
            </div>
            <div id="content2" class="tab-content">
            
                @foreach($tplData['course_catelog'] as $i=>$catalog)
                <div class="chapter @if($i==0) expand @endif">
                    <div class="title clearfix">
                        <span class="pull-left cont-text">{{$catalog['title']}}</span>
                        <i class="ion-ios-arrow-down pull-right"></i>
                    </div>
                    <ul class="list-unstyle catalog" data-height="{{count($catalog['_child'])*81}}">
                        @foreach($catalog['_child'] as $j=>$child)
                        <?php
                            $liveType = '';
                            if($child['class_type']==1){
                                $liveType='video';
                            }else{
                                if($child['live_status']==0){
                                    $liveType='live-start';
                                }elseif($child['live_status']==1||$child['live_status']==2){
                                    $liveType='live';
                                }else{
                                    $liveType='live-end';
                                    if($child['media_id']>0){
                                        $liveType='lived';
                                    }
                                }
                            }
                        ?>
                        <li class="section" data-live-type="{{$liveType}}">
                            <a data-section-id="{{$child['id']}}" class="course-section-item">
                                <div class="section-title">
	                                <span class="second-title">{{$child['title']}}</span>
                                </div>
                                <div class="section-text">            
									@if($child['class_type']==1)
                                        <span class="ico"></span>
                                        <span>
                                            [ 录播 ]
                                        </span>
                                        <span class="time">( {{$child['media']['timelong']}} )</span>
                                        @if($i==0&&$tplData['is_listen']==1&&$j==0)
                                            <div class="pull-right">
                                                <span class="icon-try-listen"></span>
                                            </div>
                                        @endif
                                    @else
                                        @if($child['live_status']==0)
                                            <div class="live-start-cont">
                                                <span class="ico live"></span>
                                                <span>
                                                    [ 直播 ]
                                                </span> 
                                                <span class="time">{{$child['timelong']}}</span>
                                                <div class="pull-right">
                                                    <span class="live-start-text">直播未开始</span>
                                                </div>
                                            </div>
                                        @elseif($child['live_status']==1||$child['live_status']==2)
                                            <div class="live-cont">
                                                <span class="ico live"></span>
                                                <span>
                                                    [ 直播 ]
                                                </span> 
                                                <span class="time">{{$child['timelong']}}</span>
                                                <div class="pull-right">
                                                    <span class="live-text">直播进行中</span>
                                                </div>
                                            </div>
                                        @else     
                                            @if($child['media_id']>0)
                                            <div class="live-end-cont">
                                                <span class="ico lived"></span>
                                                <span>
                                                    [ 回放 ]
                                                </span> 
                                                <span class="time">{{$child['timelong']}}</span>
                                                <div class="pull-right">
                                                    <span class="live-end-text">直播已结束</span>
                                                </div>
                                            </div>
                                            @else
                                            <div class="live-end-cont dis">
                                                <span class="ico live-end"></span>
                                                <span>
                                                    [ 直播 ]
                                                </span> 
                                                <span class="time">{{$child['timelong']}}</span>
                                                <div class="pull-right">
                                                    <span class="live-end-text">直播已结束</span>
                                                </div>
                                            </div>

                                            @endif
                                        @endif
                                    @endif
	                                
                                </div>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endforeach
            </div>
            <div id="content3" class="tab-content">
                <div class="praise">
                    <p class="character">好评度 </p>
                    <div class="value">{{$tplData['comment']['praise']}}</div>
                </div>
                <div class="tab-container">
                    <ul class="list-unstyle list-inline clearfix tab">
                        <li class="witchComment active" value="0">
                            <span class="">全部评价</span>
                            <span>{{$tplData['comment']['all_comment_num']}}</span>
                        </li>
                        <li class="witchComment" value="3">
                            <span class="">好评</span>
                            <span>{{$tplData['comment']['good_comment_num']}}</span>
                        </li>
                        <li class="witchComment" value="2">
                            <span class="">中评</span>
                            <span>{{$tplData['comment']['in_comment_num']}}</span>
                        </li>
                        <li class="witchComment" value="1">
                            <span class="">差评</span>
                            <span>{{$tplData['comment']['low_comment_num']}}</span>
                        </li>
                    </ul>
                </div>
                
                <div class="comment-content">
                    <ul class="list-unstyle list-comment infinite-scroll"
                        data-url="/api/comment/list?is_html=1"
                        data-params="{{json_encode([
                                'object_id' => $tplData['course_id'],
                                'type' => 1,
                                'rank' => 0 
                            ])}}">
                        @component('mobile.tmpl.course_comment_list', [
                            'data' => $tplData['comment']['comment_list']
                        ])
                        @endcomponent  

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    window.courseId = {!!json_encode($tplData['course_id'])!!};
    window.comment = {!!json_encode($tplData['comment'])!!};
    window.collection = {!!json_encode($tplData['collection'])!!};       
</script>
@stop

@section('footer')
@stop

@section('script')
<script src="/static/lib/videojs/video.min.js"></script>
<script src="/static/lib/videojs/videojs-contrib-hls.min.js"></script>
<script src="/static/lib/tc-player/webim.js" charset="utf-8"></script>
<script src="/static/lib/tc-player/json2.js" charset="utf-8"></script>
<script src="/static/lib/tc-player/TcPlayer-2.2.1.js" charset="utf-8"></script>
<script src="/static/js/page/course/detail.js"></script>
<script src="/static/lib/share/js/jquery.share.min.js"></script>
@stop
