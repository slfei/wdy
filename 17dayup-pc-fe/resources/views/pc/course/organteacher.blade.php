@extends('pc.common')

@section('main')
  <div class="classify">
      <div>
         <span class="classify_all"><a href="/institute/list">@lang('public.all_course')</a><span class="ion-ios-arrow-right icon"></span></span>
      </div>
      <div class="classify_other">
        <div class="classify_title">@lang('public.classify') :</div>
        <ul class="classify_nav">
            @foreach($tplData['category'] as $tablist)
            <li><a href="/institute/list/{{$tablist['category_id']}}" class="@if($tplData['data']['filter']['category_id'] == $tablist['category_id']) active @endif">{{$tablist['name']}}</a></li>
            @endforeach
        </ul>
      </div>
      <div class="classify_sort">
         <ul class="js_sort">
             <li class="@if($tplData['data']['filter']['sort_type']==0) active @endif" data-sort="0">@lang('public.sort')</li>
             <li class="classify_sortIcon @if($tplData['data']['filter']['sort_type']==1) active @endif" data-sort="1">@lang('public.praise')</li>
             <li class="classify_sortIcon @if($tplData['data']['filter']['sort_type']==3) active @endif" data-sort="3">@lang('public.course_num')</li>
             <li class="classify_sortIcon @if($tplData['data']['filter']['sort_type']==2) active @endif" data-sort="2">@lang('public.student_num')</li>
         </ul>
      </div>
      <div class="classify_list">
          @if(count($tplData['data']['list']))
          <ul class="">
            @foreach($tplData['data']['list'] as $list)
            <li>
                <a href="/{{$list['from_type']}}/homepage/{{$list['institute_id']}}" target="_blank">
                    <div class="organ_img">
                        <img src="{{$list['logo']}}" alt="">
                    </div>
                    <div class="organ_title">{{$list['ins_show_name']}}</div>
                    <div class="organ_main">@lang('public.main')：{{$list['ins_type_str']}}</div>
                    <div class="organ_info">{{$list['short_des']}}</div>
                    <div class="organ_area">
                        <div class="organ_comment">
                            <span class="organ_label">@lang('public.praise')</span>
                            <span class="organ_num">{{$list['praise']}}</span>
                        </div>
                        <div class="organ_course organ_line">
                            <span class="organ_label">@lang('public.course_num')</span>
                            <span class="organ_num">{{$list['course_num']}}</span>
                        </div>
                        <div class="organ_student">
                            <span class="organ_label">@lang('public.student_num')</span>
                            <span class="organ_num">{{$list['student_num']}}</span>
                        </div>
                    </div>
                </a>
            </li>
            @endforeach
          </ul>
          @else
          <div class="empty-state">
               <img src="/build/img/course/empty-state.png"/>
               <p>@lang('public.no')</p>
           </div>
          @endif
      </div>
      <div class="section-pagination">
            @component('pc.components.pagination.index', [
                'data' => [
                    'page_size' => $tplData['data']['page_size'],
                    'current' => $tplData['data']['page_num'],
                    'total' => $tplData['data']['total']
                ]
            ])
            @endcomponent
      </div>
  </div>
@stop


@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/course/organteacher.css">
@endsection
@section('script')
    <script>
       window.FILTER = {!! json_encode($tplData['data']['filter']) !!}
    </script>
    <script src="/build/js/page/course/organteacher.js"></script>
@stop
