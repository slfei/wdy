
<div class="tab-switch clearfix">
	<a class="center-titleo  @if(isset($_GET['type'])&&$_GET['type']!='tab3'||!isset($_GET['type'])) tab_active center-active @endif" id="tab1" href="javascript:void(0)">
		{{$data['tab-one']}}
	</a>
	<a class="center-titleo" id="tab2" href="javascript:void(0)">
		{{$data['tab-two']}}
	</a>
	<a class="center-titleo  @if(isset($_GET['type'])&&$_GET['type']=='tab3') tab_active center-active @endif" id="tab3" href="javascript:void(0)">
	@if($data['tab-three'])
		@lang('center.password.update')
	@else
		@lang('center.password.setting')
	@endif
	</a>
</div>
