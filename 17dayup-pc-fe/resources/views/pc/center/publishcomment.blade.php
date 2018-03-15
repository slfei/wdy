@extends('pc.common')
@section('main')
<?php $hasComment = isset($tplData['comment']) && isset($tplData['comment']['text_content']); ?>

<div class="myevaluate_center">
    <div class="base_styl myevaluate clearfix">
        <div class="evalute-content white-bg">
            <div class="clearfix @if($hasComment) has-comment @endif">
                <div class="course-info pull-left">
                    <div class="course-li">
                        <div class="course-img">
                            <img src="{{$tplData['order']['course_img']}}">
                        </div>
                        <div class="course-name">
                            {{$tplData['order']['course_name']}}
                        </div>
                        <div class="other clearfix">
                            <span class="pull-left">
                              @if($tplData['order']['cur_price']==0)
                                  <span class="free_price">@lang('publishcomment.free_price')</span>
                              @else
                                  <span class="not_free">￥{{$tplData['order']['cur_price']}}</span>
                              @endif
                            </span>
                            <span class="from_name pull-right">{{$tplData['order']['from_name']}}</span>
                        </div>
                    </div>
                </div>
                <div class="pull-left evalute-main">
                    <div class="evalute-head">
                        <span>@lang('publishcomment.score')</span>
                        <span class="star-score">
                            @for ($i =0; $i < 5 ; $i++)
                                <i class="ion-android-star good-star orange-star"></i>
                            @endfor
                        </span>
                        <span class="color-blue">@lang('publishcomment.praise')</span>
                    </div>
                    <div class="evalute-form clearfix">
                        @if($hasComment)
                        <div class="comment-text comment-look">
                            <span class="text-title">@lang('publishcomment.comment')</span>
                            <span class="text-dec">{{$tplData['comment']['text_content']}}</span>
                        </div>
                        @else
                        <div class="clearfix evalute-text">
                            <textarea
                                    class="comment_text" rows="7" cols="83"
                                    placeholder="@lang('publishcomment.tips')"
                                    maxlength="200"

                                    >@if($hasComment){{$tplData['comment']['text_content']}}@endif</textarea>
                            <div class="com-lenth">
                                <span class="rest-length">0 </span>/
                                <span class="red-length">200</span>
                            </div>
                        </div>
                        <div class="release-btn clearfix">
                            <a class="w-btn-primary" href="javascript:;">@lang('publishcomment.sent_comment')</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="base_styl hide evaluate_success clearfix">
        <div class="success_main white-bg">
            <div class="success_msg">
                <p class="suc-msg hide"><i class="ion-ios-checkmark"></i> <span>@lang('publishcomment.success_comment')</span></p>
                <p class="fail_msg hide">
                    <i class="ion-ios-close"></i> <span>@lang('fail_comment')</span>
                </p>
                <div class="return">
                    <a class="w-btn-primary" href="/center/order">@lang('publishcomment.back_order')</a>
                </div>
            </div>
            <div class="recomm-cours">
                <h3>
                    @if($tplData['type']==1)
                      @lang('publishcomment.again_comment')
                    @else
                      @lang('publishcomment.course')
                    @endif
                </h3>

                <div>
                    @component('pc.components.course.course-lists',
                    [
                    'datas'=>$tplData['data'],
                    'is_hover_bg'=>true,
                    'common'=>$tplData['type']
                    ])
                    @endcomponent
                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section('style')
<link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
<link rel="stylesheet" type="text/css" href="/build/css/page/center/evaluate.css">
@endsection

@section('script')
@if($hasComment)
<script>
    window.MY_COMMENT = {!! json_encode($tplData['comment']) !!};
</script>
@endif
<script>
    window.course_info = {
        course_id:'{{$tplData["order"]["course_id"]}}',
        institute_id:'{{$tplData["order"]["institute_id"]}}'
    };
</script>
<script src="/build/lib/toast/jquery.toast.min.js"></script>
<script src="/build/js/page/center/evaluate.js"></script>
@stop
