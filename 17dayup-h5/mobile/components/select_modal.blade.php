<div class="select-modal bg-modal hide">
    <div class="canscroll">
		<div class="modal-content">
			<div class="cancel-btn clearfix">
				<a class="sure-btn pull-left">确定</a>
				<a class="close-modal pull-right">取消</a>
			</div>
			<div class="reason_li">
				@foreach ($reason as $item)
				<div class="item-res" id="reason_{{$item['id']}}">
					{{$item['name']}}
				</div>
				@endforeach
			</div>
		</div>
	</div>
</div>
