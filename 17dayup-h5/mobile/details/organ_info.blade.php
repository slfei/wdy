@extends('mobile.base')
<?php $is_have=0;?>
<?php $Desc = '“累加学院”是互联网求职者和从业者的在线直播学习社群，为学员提供职业技能培训，并且打造就业服务支撑。开设互联网思维、互联网产品、互联网运营、互联网营销实战课程。';?>
@section('meta-keywords')产品，运营，学习平台，互联网，互联网营销，产品总监，运营总监，品牌营销，事件营销，新媒体@stop
@section('p-title')
 @if($tplData['institute_info']['id']==200109)
 {{$tplData['institute_info']['name']}}
 @else
 {{$tplData['institute_info']['name']}}_伟东云学堂
 @endif
@stop
@section('meta-description')
 @if($tplData['institute_info']['id']==200109)
 {{$Desc}}
 @else
 {{$tplData['institute_info']['name']}} 入驻伟东云学堂啦，并为学员提供了超多的精品课程，一起来学习把！
 @endif
@stop

@section('header') 
    @component("mobile.components.header", [ 
        'data' => [ 
            'type' => 'text', 
            'title'=> '机构详情',
            'backward' => true
        ] ]) 
    @endcomponent 
@stop


@section('content')
<div class="content">
     <div class="main_head">
         <div class="user_img">
            <img src="{{$tplData['institute_info']['img']}}" alt="">
         </div>
         <div class="user_info">
             <div class="user_name">
                 {{$tplData['institute_info']['name']}}
             </div>
             <div class="user_desc">
                 {{$tplData['institute_info']['desc']}}
             </div>
             <div class="user_comment">
                 <span>好评度：{{$tplData['institute_info']['good']}}</span>
                 <span class="right">学生数：{{$tplData['institute_info']['student']}}</span>
             </div>
         </div>
         <div class="user_about">
            <a href="/institute/aboutus/{{$tplData['institute_info']['id']}}"></a>
         </div>
     </div>
     <div class="tab">
         <ul>
             <li class="active" data-hasdata="false" data-ajax="false">机构主页</li>
             <li data-hasdata="true" data-ajax="true">课程 ({{$tplData['institute_info']['course']}})</li>
             <li data-hasdata="true" data-ajax="true">老师 ({{$tplData['institute_info']['teacher']}})</li>
         </ul>
         <div class="line"></div>
     </div>
     <div class="scroll_content">
	    	<div>
	    		<div class="list">
                    @if(count($tplData['index_banner_list'])&&$tplData['index_banner_list'][0]['image'])
                    <?php $is_have=1;?>
                    <div class="banner">
                        <div class="swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach($tplData['index_banner_list'] as $item)
                                    <a class="swiper-slide" href="{{ $item['url'] }}">
                                        <img src="{{ $item['image'] }}" alt="{{$item['text']}}">                
                                    </a>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                        </div>
                    </div>
                    @endif
                    @if(count($tplData['course_list'])&&count($tplData['course_list'][0]['courses']))
                    <?php $is_have=1;?>
                    <div class="course">
                        @foreach($tplData['course_list'] as $item)
                        @if(count($item['courses']))
                        <div class="course_area">
                            <div class="title">{{$item['title']}}<span class="more js_course">更多</span></div>
                            <ul class="course_list">
                            @foreach($item['courses'] as $items)
                            <li>
                                <a href="/course/{{$items['course_id']}}">
                                    <div class="course_left">
                                        <img src="{{$items['course_img']}}" alt="">
                                    </div>
                                    <div class="course_right">
                                        <div class="course_name">{{$items['course_name']}}</div>
                                        <div class="price_area">
                                            @if($items['type'] == 1)
                                            <span class="price_free">免费</span>
                                            @else
                                            <span class="curprice">￥{{$items['cur_price']}}</span>
                                            @if($items['cur_price']!=$items['price'])
                                                <span class="nowprice">￥{{$items['price']}}</span>
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                </a>
                             </li>
                            @endforeach
                            </ul>
                        </div>
                        @endif
                        @endforeach
                    </div>
                    @endif
                    @if(isset($tplData['teacher_list'])&&count($tplData['teacher_list']))
                    <?php $is_have=1;?>
                    <div class="line"></div>
                    <div class="teacher">
                        <div class="title">明星讲师<span class="more js_teacher">更多</span></div>
                        <div class="teacher_area">
                            <ul class="teacher_list">
                            @foreach($tplData['teacher_list'] as $item)
                                <li>
                                        <a href="/teacher/courselist/{{$item['teacher_id']}}">
                                            <div class="teacher_left">
                                                    <img src="{{$item['image']}}" alt="">
                                            </div>
                                            <div class="teacher_right">
                                                <div class="teacher_name">{{$item['teacher_name']}}</div>
                                                <div class="teacher_desc">{{$item['teacher_desc']}}</div>
                                            </div>
                                        </a>
                                </li>
                            @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="line"></div>
                    @endif
                    @if(!$is_have)
                    <div class="empty">
                       <img src="/static/img/icon/empty.png">
                       <span>TA太懒了，没有留下任何痕迹</span>
                    </div>
                    @endif
		    	</div>
		    	<ul class="list course_list hide"></ul>
		    	<ul class="list teacher_list teacher_styl hide"></ul>
	    	</div>
	    </div>
</div>


@section('footer')
@stop

@section('style')
<link rel="stylesheet" href="/static/lib/swiper/dist/css/swiper.css">
<link rel="stylesheet" href="/static/css/page/details/organinfo.css"> 
@stop

@section('topscript')
<script>
    
    var share = {
        title:'{{$tplData['institute_info']['id']==200109?$tplData['institute_info']['name']:$tplData['institute_info']['name']."_伟东云学堂"}}',
        desc:'{{$tplData['institute_info']['id']==200109?$Desc:$tplData['institute_info']['name'].'入驻伟东云学堂啦，并为学员提供了超多的精品课程，一起来学习把！'}}',
        thumbnail:'http://wdyedu-static.bj.bcebos.com/img/share_logo.png',
        url: location.href
    };
    window.blockDefaultShare = true;
</script>
@stop

@stop @section('script')
<script>
    var id = {!!json_encode($tplData['institute_info']['id'])!!};
</script>
<script src="/static/js/page/details/organinfo.js"></script>
@stop
