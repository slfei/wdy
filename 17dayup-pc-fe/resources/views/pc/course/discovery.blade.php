<?php
   $cid = $tplData['filter']['category_id'];
   $tmp = $tplData['category'];
   $titleName = $cid ? array_shift($tmp)['title']:'';

   switch($titleName){
     case '国学文化':
        $title = "国学文化_在线课程_伟东云学堂";
        $keywords = "童蒙养正,经典诵读,诗词歌赋,古文观止,文化通识,传统技艺,三字经,百家姓,国学,新国学";
        $description = "国学文化为您按年龄提供了从幼儿学习的三字经到成人学习的古文观止一系列课程，培养您的国学素养";
     break;
     case '亲子早教':
        $title = "亲子早教_在线课程_伟东云学堂";
        $keywords = "家庭教育,幼儿教学,幼儿兴趣,亲子陪伴,亲子早教,育儿知识";
        $description = "亲子早教为您提供了家庭教育，幼儿教学，幼儿兴趣，亲子陪伴，亲子早教等一系列课程，让您的孩子能够健康成长";
     break;
     case '基础教育':
        $title = "基础教育_在线课程_伟东云学堂";
        $keywords = "小学阶段,初中阶段,高中阶段,语文,数学,英语";
        $description = "基础教育为您提供了小学阶段，初中阶段，高中阶段，语文、数学、外语等一系列基础教育的课程视频，帮您提高您的学习成绩";
     break;
     case '留学语言':
        $title = "留学语言_在线课程_伟东云学堂";
        $keywords = "考研,出国留学,实用英语,日语,韩语,日常英语,旅游英语";
        $description = "留学语言为您提供了考研，出国留学，实用英语，日语韩语等系列课程，为您的留学提供帮助";
     break;
     case 'IT互联网':
        $title = "IT互联网_在线课程_伟东云学堂";
        $keywords = "编程语言,前端开发,后端开发,移动开发,人工智能与数据,系统/硬件,测试运维,软件认证，用户体验,产品策划,产品运营,平面设计,设计工具,游戏动漫";
        $description = "IT互联网为您提供了从前端开发到移动端开发的一系列互联网开发相关的视频课程，让您从入门到精通";
     break;
     case '其他类别':
        $title = "其他类别_在线课程_伟东云学堂";
        $keywords = "公职考试,医疗卫生,财会金融,建造工程,职业技能,健康运动,生活百科";
        $description = "其他类别为您提供了从公职考试到健康运动等生活百科实用类的在线视频，进一步提高您的生活品质";
     break;
     default:
        $title = "在线课程_在线视频_伟东云学堂";
        $keywords = "在线课程,在线教育,在线学习,国学文化,亲子早教,基础教育,留学语言,IT教育,人工智能,VR技术,编程技术,测试运维,平面设计,职业考试,留学考研";
        $description = "在线课程里的课程涵盖了国学文化、亲子早教、基础教育、留学语言、IT互联网、职业技能、兴趣爱好以及国际教育等多个领域，为国内外互联网用户提供了专业优质的教育视频资源，为用户提供在线学习、在线教育等全方位的教育互联网服务。";
   }
   if (isset($locale) && $locale != 'zh_CN') {
       unset($title);
       unset($description);
       unset($keywords);
   }
?>


@extends('pc.common')

@section('main')
   <div class="main-container discovery">
       <ul class="list-unstyled list-inline section-nav">
           <li class=""><a href="/course/discovery">@lang("course.discovery.section_nav_all")</a><span class="ion-ios-arrow-right ico"></span></li>
           @if($tplData['category'])
               @forEach($tplData['category'] as $category)
               <li class="dropdown lt">
                    <a class="" data-toggle="dropdown" href="javascript:void(0)">
                        {{$category['title']}} <span class="caret"></span>
                    </a>
                    <span class="ion-ios-arrow-right ico"></span>
                    <ul class="dropdown-menu">
                        @forEach($category['list'] as $childCategory)
                            <li class="@if($childCategory['is_show']) active @endif"><a href="/course/discovery/{{$childCategory['category_id']}}">{{$childCategory['name']}}</a></li>
                        @endforEach
                    </ul>
               </li>
               @endforEach
           @endif
       </ul>
       @if($tplData['cur_category'])
       <div class="content-block section-category">
           <div class="title">@if($tplData['category']) @lang("course.discovery.section_category.classify") @else @lang("course.discovery.section_category.course") @endif:</div>
           <ul class=" list-unstyle list-inline">
                @forEach($tplData['cur_category'] as $category)
                @if($category['category_id']== $tplData['filter']['category_id'])
                    <li class="active"><a href="/course/discovery/{{$category['category_id']}}">{{$category['name']}}</a></li>
                @else
                    <li><a href="/course/discovery/{{$category['category_id']}}">{{$category['name']}}</a></li>
                @endif
                @endforEach
            </ul>
       </div>
        @endif
       <div class="clearfix content-block section-filter">
           <ul class="pull-left list-unstyle list-inline left">
               <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['type']==0) active @endif" value="all">@lang("course.discovery.section_filter.all")</a></li>
               <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['type']==1) active @endif" value="free">@lang("course.discovery.section_filter.free")</a></li>
               <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['type']==2) active @endif" value="discount">@lang("course.discovery.section_filter.discount")</a></li>
               <li><a href="javascript:void(0)" class="goto listen ico @if($tplData['filter']['listen']==1) ion-checkbox-outline active @else ion-checkbox-outline-blank  @endif" value="listen"></a>@lang("course.discovery.section_filter.listen")</li>
               <li><a href="javascript:void(0)" class="goto listen ico @if($tplData['filter']['record']==1) ion-checkbox-outline active @else ion-checkbox-outline-blank  @endif" value="record"></a>@lang("course.discovery.section_filter.record")</li>
               <li><a href="javascript:void(0)" class="goto listen ico @if($tplData['filter']['live']==1) ion-checkbox-outline active @else ion-checkbox-outline-blank  @endif" value="live"></a>@lang("course.discovery.section_filter.live")</li>
           </ul>
           <ul class="pull-right list-unstyle list-inline right">
               <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==0) active @endif" value="synthesise">@lang("course.discovery.section_filter.synthesise")</a></li>
               <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==1) active @endif" value="good">@lang("course.discovery.section_filter.good")&nbsp<span class="@if($tplData['filter']['sort_type']==1)ion-arrow-downactive @else ion-arrow-down @endif"></span></a></li>
               <li><a href="javascript:void(0)" class="goto @if($tplData['filter']['sort_type']==2) active @endif" value="hot">@lang("course.discovery.section_filter.hot")&nbsp<span class="@if($tplData['filter']['sort_type']==2)ion-arrow-downactive @else ion-arrow-down @endif"></span></a></li>
               <li class="price">
                   <a href="javascript:void(0)" class="goto">
                       <div class="" >@lang("course.discovery.section_filter.price")</div>
                       <div class="triangle" style="">
                           <div class="triangle-to-top  @if($tplData['filter']['sort_type']==3 && $tplData['filter']['sort']==1) activeTop @endif" ></div>
                           <div class="triangle-to-bottom @if($tplData['filter']['sort_type']==3 && $tplData['filter']['sort']==0) activeBottom @endif"></div>
                       </div>
                   </a>
               </li>
               <li class="price-range">
                    <input type="text" @if($tplData['filter']['start']) value="{{$tplData['filter']['start']}}" @endif placeholder="@lang("public.unit")" class="start"/>
                    <span>-</span>
                    <input type="text" @if($tplData['filter']['height']) value="{{$tplData['filter']['height']}}" @endif placeholder="@lang("public.unit")" class="end"/>
                    <button type="button" class="btn btn-xs sure-goto" >@lang("course.discovery.section_filter.sure")</button>
               </li>
           </ul>
       </div>
       <div class="row content-block section-list">
           @if($tplData['data'])
           @forEach($tplData['data'] as $key=>$item)
           <div class="col-xs-3 col-padding">
           @component('pc.components.course.item', ['data' => $item])@endcomponent
           </div>
           @endforEach
           @else
           <div class="col-xs-12 text-center empty-state">
               <img src="/build/img/course/empty-state.png"/>
               <p>@lang("course.discovery.section_list_none")</p>

           </div>
           @endif
       </div>
       <div class="section-pagination">
           @component('pc.components.pagination.index', [
               'data' => [
                    'page_size' => $tplData['page_size'],
                    'current' => $tplData['page_num'],
                    'total' => $tplData['total']
               ]
           ])
           @endcomponent
       </div>
   </div>
   <script>
   window.FILTER = {!! json_encode($tplData['filter']) !!}
   </script>
@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/course/discovery.css">
@endsection
@section('script')
    <script src="/build/lib/bootstrap/bootstrap.min.js"></script>
    <script src="/build/js/page/course/discovery.js"></script>
@stop
