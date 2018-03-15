<?php 
   $side_active = 3;
   function genUrl()
   {
       return "/center/collection" ;
   }
?>
@extends('pc.components.center.center_sidebar')
@section('center-main')
<div class="user-collection">
<div class="collect-title">
	<h3>@lang('center.collection.title')</h3>
</div>
<div class="collect-main">
	@if(empty($tplData['data']))
	    <div class="no-data-type text-center">
	    	<div class="no-data-bg no-collection">
	    	</div>
	    	<div>
	    		@lang('center.collection.no_data')
	    	</div>
	    </div>
	@else
	<div>
		@component('pc.components.course.course-lists',
        [
        'datas'=>$tplData['data'],
        'is_hover_bg'=>true,
        'is_hover_bg_black'=>true
        ])
        @endcomponent
		<div class=" my-pagination">
			@component('pc.components.pagination.index', ['data'=> [
			    'total' => $tplData['total'],
			    'page_size' => $tplData['page_size'],
			    'current' => $tplData['page_num']
			] ])
			@endcomponent
		</div>
	</div>
	@endif
</div>
</div>
@component('pc.center.cancel-modal') 
@endcomponent
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/center/collection.css">
    <!--<link rel="stylesheet" type="text/css" href="/build/css/page/center/order.css">-->

@endsection

@section('script')
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
	<script src="/build/js/page/center/course.js"></script>
@stop

