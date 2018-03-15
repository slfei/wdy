<?php 
   $insti = 4;
?>
@extends('pc.institute.common-header')
@section('institute-main')
<div class="about-us-page white-bg">
    @if(!isset($tplData['data']['description'])
     && (!isset($tplData['data']['history'])
        || empty($tplData['data']['history'])))

        <div class="no-data-type text-center">
            <div class="no-data-bg no-course">
            </div>
            <div>
                @lang('institute.about_us.no-data')
            </div>
        </div>
    @else
        @if($tplData['data']['description'])
        <div class="institute-descri">
            <h3 class="">@lang('institute.about_us.summary')</h3>
            <p>{!!$tplData['data']['description']!!}</p>
        </div>
        @endif
        @if(!empty($tplData['data']['history']))
        <div class="insti-history">
            <h3>@lang('institute.about_us.history')</h3>
            <div class="all-history-foot">
                <div class="history-li">
                    @forEach($tplData['data']['history'] as $history_li)
                    <div class="each-history padding">
                        <div class="time-line">
                        </div>
                        <div class="history-date">
                            {{$history_li['time']}}
                        </div>
                        <div class="history-desc">
                            {{$history_li['desc']}}
                        </div>
                    </div>
                    @endforEach
                </div>
            </div>
        </div>
        @endif
    @endif
</div>
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/page/institute/history.css">
@endsection
