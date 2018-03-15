<?php 
$nav_index = 3; 
?>
@extends('mobile.base') 


@if(!isset($is_app)&&$is_app != 1)
@section('header') 
	@component("mobile.components.header", [ 
		'data' => [ 
			'type' => 'text', 
			'title'=> '关于我们',
			'backward' => true
		] ]) 
	@endcomponent 
@stop
@endif


@section('content')
<div class="@if(!isset($is_app)&&$is_app != 1) my-about @endif">
    <div class="logo"></div>
    @if(isset($is_app)&&$tplData['version']!='')
    <div class="version">{{$tplData['version']}}</div>
    @endif
    <div class="about_area">
        <p>伟东云学堂（wdyedu.com），是伟东云教育集团推出的全球领先的互联网教育云平台，总部位于有“中国硅谷”之称的北京中关村科技园核心区域，于2017年11月底正式上线。</p>
        <p>伟东云学堂以“让人们平等便捷的获取全球优质教育资源”为使命，与众多教育培训机构建立合作，汇聚全球优质的教学资源，课程涵盖国学文化、亲子早教、基础教育、留学语言、IT互联网、职业技能、兴趣爱好以及国际教育等多个领域。</p>
        <p>伟东云学堂致力于通过技术创新，为家庭、个人及机构、企业用户提供专业而全方位的教育产品与服务，借助互联网的优势让不同地域范围内教育的“供”和“需”之间建立连接，实现资源的最优分配，为用户提供便捷、实惠、专业的教育服务，不断为用户创造价值，推动行业发展。</p>
        <div class="title">业务模式：</div>
        <p>伟东云学堂为基于线上线下互动结合的B2B2C（Business to Business to Customer）模式，即链接教育内容供需双方，为教学过程各环节提供技术、功能和服务，并实现教育内容变现的互联网第三方教育平台。家庭个人及企业机构可直接在线上进行教育课程及服务自助交易，用户可以通过在线学习和线下课程等方式体验到伟东云学堂的一站式教育服务。 </p>
        <div class="title">核心用户：</div>
        <p>由于体制内教育资源总量不足、分配不均，人往往通过额外的教育培训来投资自己和家人，希望未来能获得更好的学习、工作和生活。伟东云学堂覆盖学龄前、K12、大学、工作、退休等各阶段用户群，贯穿人一生的学习。</p>
        <p>目前，伟东云学堂的核心用户有：K12学生/家长、在校大学生、职场白领、国学爱好者</p>
    </div>
    <div class="ft">
        <div class="desc">
        ©2018 All Rights Reserved 伟东云教育 版权所有
        </div>
        <div class="desc">
        京ICP证161318号
        </div>
    </div>
</div>

@stop 

@section('footer')
@show  

@section('style')
<link rel="stylesheet" href="/static/css/page/user/about.css">
@if(isset($is_app)&&$is_app==1)
<style>
 .fixed-header{
     display: none;
 }
</style>
@endif
@stop

@section('script')
<!-- <script src="/static/js/page/user/feedback.js"></script> -->
@stop
