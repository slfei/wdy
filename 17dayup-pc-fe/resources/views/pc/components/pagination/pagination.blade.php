<?php 
	$page_size = 20;
	$cur_url = $data['url'];
    $page_index = $data['page_num'];
    $page_amount = ceil($data['total'] / $page_size);     
    $params_string = '?';
    if(!empty($data['params'])) {
        foreach($data['params'] as $key => $value) {
            $params_string .= $key.'='.$value.'&';
        }
    }   
?>

<div class="w-pagination clearfix text-center">
	<a class="page-init-sty" href="{{ $cur_url.$params_string }}page_num=1">@lang('public.page_first')</a>
	<a class="page-init-sty w-next-page @if($page_index == 1) w-page-disabled @endif" @if($page_index >1) href="{{ $cur_url.$params_string }}page_num={{$page_index - 1}}" @endif ><i class="ion-ios-arrow-left"></i></a>

	@if($page_amount <= 5 && $page_index<=$page_amount)
	@for ($k = 1; $k <= $page_amount; $k++)
	<a class="each-page @if($data['page_num']==$k) w-active-page @else page-init-sty @endif" href="{{ $cur_url.$params_string }}page_num={{ $k }}">{{ $k }}</a>
	@endfor

	@elseif($page_amount>5 && $page_index<=5)

	@for ($k = 1; $k <= 5; $k++)
	<a class="each-page @if($data['page_num']==$k) w-active-page @else page-init-sty @endif" href="{{ $cur_url.$params_string }}page_num={{ $k }}">{{ $k }}</a>
	@endfor

	@else
	@for ($k = $page_index-4; $k <= $page_index; $k++)
	<a class="each-page @if($data['page_num']==$k) w-active-page @else page-init-sty @endif" href="{{ $cur_url.$params_string }}page_num={{ $k }}">{{ $k }}</a>
	@endfor
	@endif

	<a class="page-init-sty w-next-page @if($page_amount==$page_index) w-page-disabled @endif" @if($page_index < $page_amount) href="{{ $cur_url.$params_string }}page_num={{$page_index + 1}}" @endif ><i class="ion-ios-arrow-right"></i></a>
	<a class="page-init-sty" href="{{ $cur_url.$params_string }}page_num={{$page_amount}}">@lang('public.page_last')</a>
</div>
