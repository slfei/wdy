@extends('mobile.base')

@section('p-title'){{$tplData['info']['per_show_name']}}_伟东云学堂@stop
@section('meta-description'){{$tplData['info']['per_show_name']}} 入驻伟东云学堂啦，并为学员提供了超多的精品课程，一起来学习把！@stop

@section('header') 
    @component("mobile.components.header", [ 
        'data' => [ 
            'type' => 'text', 
            'title'=> '讲师详情',
            'backward' => true
        ] ]) 
    @endcomponent 
@stop


@section('content')
<div class="content">
     <div class="main_head">
         <div class="user_img">
            <img src="{{$tplData['info']['personal_logo']}}" alt="">
         </div>
         <div class="user_name">{{$tplData['info']['per_show_name']}}</div>
         <div class="user_info">
             <img src="/static/img/details/info_icon.png" alt=""> {{$tplData['info']['ids']}}
         </div>
         <div class="user_des">{{$tplData['info']['short_des']}}</div>
     </div>
     <div class="tab">
         <ul>
             <li class="active" data-hasdata="false" data-ajax="false">讲师主页</li>
             <li data-hasdata="true" data-ajax="true">课程 ({{$tplData['info']['course_num']}})</li>
             <li data-hasdata="true" data-ajax="true">学员评价 ({{$tplData['info']['comment_num']}})</li>
         </ul>
         <div class="line"></div>
     </div>
     <div class="scroll_content">
	    	<div>
	    		<div class="list teacher_main">
                    <div class="teacher_info">
                        <div class="teacher_title">讲师信息</div>
                        <div class="teacher_row">
                            <div class="main_title">教学科目：</div><div class="main_info">{{$tplData['info']['person_type']?$tplData['info']['person_type']:'暂无'}}</div>
                        </div>
                        <div class="teacher_row">
                            <div class="main_title">实际教龄：</div><div class="main_info">{{$tplData['info']['school_age']?$tplData['info']['school_age']:'暂无'}}</div>
                        </div>
                        <div class="teacher_row">
                            <div class="main_title">教学特长：</div><div class="main_info">{{$tplData['info']['description']?$tplData['info']['description']:'暂无'}}</div>
                        </div>
                    </div>
                    @if(count($tplData['course_list'])&&count($tplData['course_list'][0]['courses']))
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
		    	</div>
		    	<ul class="list course_list hide"></ul>
		    	<ul class="list comment_list hide">
                    <li class="nd_list">
                            <div class="comment_info">
                                <div class="comment_main">
                                    <span class="comment_title">好评度</span>
                                    <span class="comment_num">{{$tplData['comment']['praise']}}</span>
                                </div>
                                <div class="comment_tab">
                                    <ul class="js_tab">
                                        <li data-rank="0" class="active">
                                            <span class="tab_title">全部评价</span>
                                            <span class="tab_num">{{$tplData['info']['comment_num']}}</span>
                                        </li>
                                        <li data-rank="3">
                                            <span class="tab_title">好评</span>
                                            <span class="tab_num">{{$tplData['comment']['good_comment_num']}}</span>
                                        </li>
                                        <li  data-rank="2">
                                            <span class="tab_title">中评</span>
                                            <span class="tab_num">{{$tplData['comment']['in_comment_num']}}</span>
                                        </li>
                                        <li data-rank="1">
                                            <span class="tab_title">差评</span>
                                            <span class="tab_num">{{$tplData['comment']['low_comment_num']}}</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                </ul>
	    	</div>
	    </div>
</div>


@section('footer')
@stop

@section('style')
<link rel="stylesheet" href="/static/css/page/details/organteacher.css"> 
@stop
@section('topscript')
<script>
    
    var share = {
        title:'{{$tplData['info']['per_show_name']."_伟东云学堂"}}',
        desc:'{{$tplData['info']['per_show_name'].'入驻伟东云学堂啦，并为学员提供了超多的精品课程，一起来学习把！'}}',
        thumbnail:'http://wdyedu-static.bj.bcebos.com/img/share_logo.png',
        url: location.href
    };
    window.blockDefaultShare = true;
</script>
@stop

@stop @section('script')
<script>
    var id = {!!json_encode($tplData['info']['teacher_id'])!!};
</script>
<script src="/static/js/page/details/organteacher.js"></script>
@stop
