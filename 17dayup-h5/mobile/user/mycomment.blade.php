<?php 
$nav_index = 3; 
?>
<?php  
	$title='我要评价';
	$right_html='<span class="comment_btn">发表</span>';
	if($tplData['comment']){
		$title='我的评价';
		$right_html='';
	}
?>

@extends('mobile.base') 
@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> $title,
			'backward' => true,
			'right_html'=>$right_html
		] ]) 
	@endcomponent 
@stop

@section('content')
<div class="my-comment white_bg has-header">
	<div class="comment-main">
		<div class="score">
			<label>课程评分 </label> 
			<span <?php if($tplData['comment']) echo 'class="cur"'; ?>>
				@for ($i =1; $i <= 5 ; $i++)
					@if($tplData['comment'])
				    <i class="ion-android-star good-star <?php if($i<=$tplData['comment']['star']){ echo 'active'; }else{ echo 'gray'; } ?>"></i>
				    @else
				    <i class="ion-android-star good-star active"></i>
				    @endif
				@endfor
			</span>
			@if(!$tplData['comment'])
			<span class="star_text">好评</span>
			@else
			<span class="star_text">
				@if($tplData['comment']['star_rank']==1)
				差评
				@elseif($tplData['comment']['star_rank']==2)
				中评
				@else
				好评
				@endif
			</span>
			@endif
		</div>
		<div class="comment-text white_bg">
			@if(!$tplData['comment'])
			<textarea rows="9" placeholder="请说一说你对所学课程的学习感受吧！" maxlength="200"></textarea>
			<div class="com-lenth">
			    <span class="rest-length">0 </span> / 
			    <span class="red-length"> 200</span>
			</div>
			@else
			<div class="score">
				<label>课程评价 </label> 
				<span>
					{{$tplData['comment']['text_content']}}
				</span>
			</div>
			@endif

		</div>
	</div>
	<script>
	    const course_info = {
	        course_id:'{{$tplData["order"]["course_id"]}}',
	        institute_id:'{{$tplData["order"]["institute_id"]}}'
	    }
	</script>
</div>

@stop 

@section('footer')
@show 

@section('style')
<link rel="stylesheet" href="/static/css/page/user/comment.css">

@stop

@section('script')
<script src="/static/js/page/user/comment.js"></script>
@stop
