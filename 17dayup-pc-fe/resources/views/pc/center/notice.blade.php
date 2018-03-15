
@extends('pc.components.center.center_sidebar')
@section('center-main')
<?php 
   $side_active = 4;
   $notice_active = 1;
?>
<div class="user-notice">
	<div class="notice-tab clearfix">
		<a href="/center/notice" class="center-titleo @if($notice_active==1) center-active border-active @endif">
			@lang('center.notice.system')
			<span class="number-message" id="number-message"></span>
		</a>
		<a href="/center/comment" class="center-titleo @if($notice_active==2) center-active border-active @endif">
			@lang('center.notice.comment')
		</a>
		<div class="btn-sign" id="btn-sign"><a>@lang('center.notice.have_read')</a></div>
	</div>
	@if(empty($tplData['data']))
	    <div class="no-data-type text-center">
	    	<div class="no-data-bg no-notice">
	    	</div>
	    	<div>
	    		@lang('center.notice.no_data')
	    	</div>
	    </div>
	@else
	<div class="my-comment-reply">
		@foreach ($tplData['data'] as $stystem_notice)
		<div class="each-notice @if($stystem_notice['status']==0) msg-noreaded @endif" data-msg-id="{{$stystem_notice['msg_id']}}">
			{!!$stystem_notice['content']!!}
			<p class="creat-time">
				{{$stystem_notice['create_time']}}
			</p>
		</div>
		@endforeach
	</div>
	
	<div class="my-pagination">
		@component('pc.components.pagination.index', ['data'=> [
		    'total' => $tplData['total'],
		    'page_size' => $tplData['page_size'],
		    'current' => $tplData['page_num']
		] ])
		@endcomponent
	</div>
	@endif
</div>
@stop

@section('style')
	<link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/center/notice.css">
@endsection
@section('script')
	<script src="/build/lib/toast/jquery.toast.min.js"></script>
	<script src="/build/js/page/center/notice.js"></script>
@stop
