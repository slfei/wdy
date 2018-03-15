<div class="avator-modal bg-modal hide">
	<div class="modal-content">
		<div class="clearfix">
		<i class="ion-ios-close close-avator pull-right "></i>
		</div>
		<div class="modal-head">
			@lang('center.avator.change_avator')
		</div>
		<div class="modal-body clearfix">
			<div class="upload-desc clearfix">
				<a class="upload-img w-btn-primary">@lang('center.avator.up_avator')</a>
				<input type="file" id="upload-avatar-input" accept="image/jpg, image/jpeg, image/png" style="display: none" />
				<p class="only-limit">@lang('center.avator.img_tips')</p>
			</div>
			<div class="crop-avator clearfix">
				<div class="init-avator ">
					<img class="avator-img" id="image" src="{{$custom_avator}}">
				</div>
				<div class="creat-avator">
					<p class="avator-rule">@lang('center.avator.info_tips')</p>
					<div class="avator-type">
						<div class="type-li clearfix">
							<li>
								<img class="avator-img avator1" src="{{$custom_avator}}">
								<p class="avator1p">120*120px</p>
							</li>
							<li>
								<img class="avator-img avator2" src="{{$custom_avator}}">
								<p class="avator2p">80*80px</p>
							</li>
						</div>
						<div class="type-li clearfix">
							<li>
								<img class="avator-img avator3" src="{{$custom_avator}}">
								<p class="avator3p">60*60px</p>
							</li>
							<li>
								<img class="avator-img avator4" src="{{$custom_avator}}">
								<p class="avator4p">40*40px</p>
							</li>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
