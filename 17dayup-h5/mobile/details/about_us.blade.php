@extends('mobile.base')

@section('header') 
    @component("mobile.components.header", [ 
        'data' => [ 
            'type' => 'text', 
            'title'=> '关于我们',
            'backward' => true
        ] ]) 
    @endcomponent 
@stop


@section('content')
<div class="about_area">
     <div class="about_title">机构简介</div>
     <div class="about_info">
         {!!$tplData['data']['description']!!}
     </div>
     <div class="time_line">
        <div class="about_title">发展历程</div>
        <ul class="time_list @if(count($tplData['data']['history']) == 1) bdnone @endif">
            @foreach($tplData['data']['history'] as $item)
            <li><div class="time_des">{{$item['time']}} {{$item['desc']}}</div></li>
            @endforeach
        </ul>
     </div>
</div>

@section('footer')
@stop

@section('style')

<link rel="stylesheet" href="/static/css/page/details/aboutus.css"> 
@stop 

@stop @section('script')

@stop
