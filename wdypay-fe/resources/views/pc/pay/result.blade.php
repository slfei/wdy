@extends('pc.common')
@section('main')
   <div class="result_area">
       <div class="err_area">
                <!-- <span class="ion-checkmark-circled ico"> -->
            <div class="err_title">
              @if($tplData['data']['status']==0)
                 <span class="ion-close-circled error"></span>
                 <span class="text">{{$tplData['data']['title']}}</span>
              @else
                <span class="ion-checkmark-circled success"></span>
                <span class="text">{{$tplData['data']['title']}}</span>
              @endif
            </div>
            <div class="err_info">
               {{$tplData['data']['info']}}
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
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc/pay/result.css">
@endsection
