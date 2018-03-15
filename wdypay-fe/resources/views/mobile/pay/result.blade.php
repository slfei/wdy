@extends('mobile.base')

@section('content')

@component("layout.header_mobile", [ 
    'data' => [ 
        'backType' => '1', 
        'title'=> __('pay.title'),
        'url'=> $tplData['data']['repeatUrl']              
    ]])
@endcomponent 

<div class="pay_err">
    <div class='pay_errArea'>
        <div class="cont">
            @if($tplData['data']['status']==0)
             <img src="/build/img/pay/pay-fall.png">
            @else
             <img src="/build/img/pay/pay-success.png">
            @endif
            <p class="pay_errTitle">{{$tplData['data']['title']}}</p>
            <p class="pay_errInfo">{{$tplData['data']['info']}}</p>
        </div>
        @if($tplData['data']['backUrl'] !='' && $tplData['data']['repeatUrl'] !='')
            <div class="btn_area">
                <a class="btn_back" href="{{$tplData['data']['backUrl']}}">@lang('pay.btn.btn1')</a>
                <a class="btn_repeat" href="{{$tplData['data']['repeatUrl']}}">@lang('pay.btn.btn2')</a>
            </div>
        @elseif($tplData['data']['backUrl'] !='')
            <div class="btn_area">
                <a class="btn_back btn_width" href="{{$tplData['data']['backUrl']}}">@lang('pay.btn.btn1')</a>
            </div>
        @elseif($tplData['data']['repeatUrl'] !='')
            <div class="btn_area">
                <a class="btn_repeat btn_width" href="{{$tplData['data']['repeatUrl']}}">@lang('pay.btn.btn2')</a>
            </div>
        @else
        
        @endif
    </div>
</div>

@section('style')
<link rel="stylesheet" href="/build/css/mobile/pay/result.css"> 
@stop 

@stop @section('script')

@stop
