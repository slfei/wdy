
    <?php
    $IS_ZH = !isset($locale) || $locale == 'zh_CN';
    $curPrice = !$IS_ZH && isset($tplData['en_cur_price']) ? '$'.$tplData['en_cur_price'] : '￥'.$tplData['cur_price'];
    ?>
    @if(!$tplData['is_sign'])
        <div class="no-sign-tip">
            <div class="pull-left">
            @lang('video.text.text1')<br>@lang('video.text.text2')
            </div>
            <div class="pull-right">
                <a href="/course/{{$tplData['course_id']}}" target="_blank" class="btn">@lang('video.text.text3')</a>
                <a class="close-btn"><i class="ion-android-close"></i></a>
            </div>
        </div>
    @endif

    @if ($tplData['course_status'] == 3)
        <div class="pay-tip">
            <div class="title">@lang('video.text.text4')</div>
            <div class="course-name">
                《{{ $tplData['course_name'] }}》
            </div>
            <div class="price">
                {{ $curPrice }}
            </div>
            <a class="w-btn-primary" target="_blank" href="/course/{{$tplData['course_id']}}">@lang('video.text.text3')</a>
        </div>
    @else
        @if ($tplData['type'] == 2)
            <div class="pay-tip">
                <div class="title">@lang('video.text.text5')</div>
                <div class="course-name">
                    《{{ $tplData['course_name'] }}》
                </div>
                <div class="price">
                    {{ $curPrice }}
                </div>
                <a class="w-btn-primary" target="_blank" href="/course/{{$tplData['course_id']}}">@lang('video.text.text3')</a>
            </div>
        @endif

        @if ($tplData['type'] == 1 && !$tplData['is_sign'])
            <div class="pay-tip">
                <div class="title">@lang('video.text.text6')</div>
                <a class="w-btn-primary" target="_blank" href="/course/{{$tplData['course_id']}}">@lang('video.text.text3')</a>
            </div>
        @endif
    @endif

    @if($isLive)
        <div id="live-start-time" 
            data-time="{{ $curSection['start_time'] }}"
            data-end-time="{{ $curSection['end_time'] }}"></div>

        <div class="not-start-tip">
            <div class="title">@lang('video.text.text13')</div>
            <div class="title remain-time"></div>
            <div class="title">@lang('video.text.text14')</div>
        </div>

        <div class="main-tip">
            <div class="title"></div>
        </div>
    @endif
