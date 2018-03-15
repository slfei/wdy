<?php
//    $title = "伟东云学堂下载_APP下载_伟东云学堂";
   	$title = __('common.title.download').'_'.__('common.appName');
    $keywords = "APP下载,iPhone下载,Android下载,伟东云学堂应用下载";

    $description = "伟东云学堂推出包含iPhone和Android版本的专业在线教育平台APP下载。".
    "伟东云学堂涵盖了国学文化、亲子早教、基础教育、留学语言、IT互联网、职业技能、兴趣爱好以及国际教育等多个领域教育产品，".
    "为国内外互联网用户提供了专业优质的教育资源搜索、在线学习、教育资讯以及在线交易等全方位的教育互联网服务。";
?>

@extends('pc.common')
@section('style')
      <link rel="stylesheet" type="text/css" href="/build/css/page/activity/pc_appload.css">
@endsection
@section('main')
<div class="content">

	<div class="page_one cont">
		<div class="box">
			<div class="title">
				<span>@lang('appload.text.text1')</span><span>@lang('appload.text.text2')</span>	
			</div>
			<div class="btns">
				<a target="_blank" href="https://itunes.apple.com/cn/app/%E4%BC%9F%E4%B8%9C%E4%BA%91%E5%AD%A6%E5%A0%82/id1352182829?l=en&mt=8">
					<span class="ios"><i></i>App Store</span>
				</a>
				<a href="/app/download?type=android">
					<span class="android"><i></i>Android</span>
				</a>
			</div>
			<p class="hide">@lang('appload.text.text3')</p>
			<span class="state">@lang('appload.text.text4')&nbsp;&nbsp;&nbsp;&nbsp;@lang('appload.text.text5')</span>
			<img class="phone" src="/build/img/pcAppload/phone1.png" alt="">
			<img class="Qr" src="/build/img/pcAppload/Qr.png">
		</div>
	</div>

    <div class="page_two h cont">
    	<div class="box h">
			<div class="title">
				 <h3>@lang('appload.text.text6')</h3>
				 <p>@lang('appload.text.text7')</p>
				 <p>@lang('appload.text.text8')</p>
			</div>
		</div>
	</div>	

    <div class="page_three h cont">
    	<div class="box">
	    	<img class="left" src="/build/img/pcAppload/phone33.png"/>
			<div class="title right">
				 <h3>@lang('appload.text.text9')</h3>
				 <p>@lang('appload.text.text10')</p>
			</div>
		</div>
	</div>

    <div class="page_four h cont">
        <div class="box">
			<div class="title">
				 <h3>@lang('appload.text.text11')</h3>
				 <p>@lang('appload.text.text12') </p>
				 <p>@lang('appload.text.text13')</p>
			</div>
		</div>
	</div>

    <div class="page_five h cont">
    	<div class="box">
			<img class="right" src="/build/img/pcAppload/phone5.png"/>
			<div class="title left">
				 <h3>@lang('appload.text.text14')</h3>
				 <p>@lang('appload.text.text15')</p>
			</div>
		</div>
	</div>

    <div class="page_six h cont">
        <div class="box h">
			<div class="title">
				 <h3>@lang('appload.text.text16')</h3>
				 <p>@lang('appload.text.text17') </p>
				 <p>@lang('appload.text.text18')</p>
			</div>
        </div>
	</div>

    <div class="page_seven h cont">
    	<div class="box">
    		<div class="left">
                <img src="/build/img/pcAppload/seven_QR1.png"/>
			      <span>@lang('appload.text.text19')</span>  			
    		</div>
    		<!-- <span>扫一扫 关注微信服务号</span>  -->
			
			<div class="title right">
				 <h3>@lang('appload.text.text20')</h3>
				 <p>@lang('appload.text.text21')</p>
				<!--  扫码下载APP， -->
			</div>
	    </div>
	</div> 																										
</div>
 <!-- content -->

@stop





