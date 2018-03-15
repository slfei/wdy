<?php 
   $insti = 3;
?>
@extends('pc.institute.common-header')
@section('institute-main')
<div class="clearfix">
    @if(isset($tplData['data']) && !empty($tplData['data']))
        @component('pc.institute.teacher-list',
        [
        'teacher_data'=>$tplData['data']
        ])
        @endcomponent
    @else
        <div class="no-data-type text-center">
            <div class="no-data-bg no-course">
            </div>
            <div>
                @lang('institute.common.no_teacher')
            </div>
        </div>
    @endif
</div>
<div class="my-pagination">
@component('pc.components.pagination.index', ['data'=> [
    'total' => $tplData['total'],
    'page_size' => $tplData['page_size'],
    'current' => $tplData['page_num']
] ])
@endcomponent
</div>

@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/page/institute/teacher.css">
@endsection
