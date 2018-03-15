@extends('mobile.base')

@section('p-title'){{$tplData['info']['per_show_name']}}_伟东云学堂@stop

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
             <img src="/static/img/details/organ_icon.png" alt=""> {{$tplData['info']['institute_name']}}
         </div>
         <div class="user_des">{{$tplData['info']['short_des']}}</div>
     </div>
     <div class="tab">
         <ul>
             <li class="active" data-hasdata="true" data-ajax="true">课程 ({{$tplData['info']['course_num']}})</li>
             <li data-hasdata="true" data-ajax="true">学员评价 ({{$tplData['info']['comment_num']}})</li>
         </ul>
         <div class="line"></div>
     </div>
     <div class="scroll_content">
	    	<div>
		    	<ul class="list course_list"></ul>
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
<script src="/static/js/page/details/personteacher.js"></script>
@stop
