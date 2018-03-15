<?php
   $title = $tplData['news_title']."_".__('common.appName');
   $keywordStr = '';

   foreach($tplData['lable'] as $value){
     $keywordStr .='，'.$value['lab_name'];
   }
   $keywords = $tplData['news_people'].$keywordStr;
   $description = $tplData['news_title'];
?>

@extends('pc.common')
@section('main')
<div class="wt_news clearfix">
    <div class="news_cantainer">
        <div class="news_content white-bg">
            <div class="news_top">
                <a class="good-top" href="/news/discovery/1">@lang('news.detail.all') <i class="ion-ios-arrow-right"></i> </a>
                @if($tplData['cat']!=[])          
                <a class="good-top" href="/news/discovery/{{$tplData['cat']['cat_id']}}">     {{$tplData['cat']['cat_name']}}
                </a>
                @else
                @lang('news.detail.recommend')
                @endif
                 <i class="ion-ios-arrow-right"></i> @lang('news.detail.content')
            </div>
            <div class="detail_content">
                <div class="detail_title text-center">
                    {{$tplData['news_title']}}
                </div>
                <div class="time-source text-center">
                    <span>{{$tplData['news_people']}}</span>
                    <span>{{$tplData['created_at']}}</span>
                    <span class="share">
                        <div class="share_area" style="margin-top: 0">
                            <div class="share_bg">
                               <div id="share" class="social-share"></div>
                            </div>
                        </div>
                        <i class="icon icon-share"></i>
                        @lang('news.detail.share')
                    </span>
                </div>
                <div class="detail_text rich-text">
                    {!!$tplData['news_text']!!}
                    <div class="news_tags">
                    @foreach ($tplData['lable'] as $new_label)
                        <a>{{$new_label['lab_name']}}</a>
                    @endforeach
                    </div>
                    <div class="page_info clearfix">
                    <?php
                        function cut_str($str,$len,$suffix="..."){
                             if(function_exists('mb_substr')){
                                 if(mb_strlen($str) > $len){
                                     $str= mb_substr($str,0,$len).$suffix;
                                 }
                                 return $str;
                             }
                        }
                    ?>
                        <section class="pre pull-left">@lang('news.detail.pre'):
                            <span>
                                @if($tplData['previous']===[]) 
                                @lang('news.detail.no')
                                @else
                                <a href="/news/{{$tplData['previous']['news_id']}}" title="{{$tplData['previous']['news_title']}}">{{cut_str($tplData['previous']['news_title'],25)}}
                                </a>
                                @endif 
                            </span>
                        </section>
                        <section class="next pull-right">@lang('news.detail.next'):
                            <span> 
                                @if($tplData['next']===[]) 
                                @lang('news.detail.no')
                                @else  
                                <a href="/news/{{$tplData['next']['news_id']}}" title="{{$tplData['next']['news_title']}}">{{cut_str($tplData['next']['news_title'],25)}}
                                </a>
                                @endif 
                            </span>
                        </section>
                    </div>
                </div>
            </div>
        </div>
        <div class="right_recommend white-bg">
            @component('pc.components.course.recommend-course',
            ['hotcourse_li'=>$tplData['hotcourse']])
            @endcomponent
        </div>
    </div>
</div>
<script>
    window.comment = {!!json_encode($tplData['news_text'])!!}
</script>
@stop
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/lib/share/css/share.min.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/news.css">
@endsection

@section('script')
    <script src="/build/js/page/newsDetail.js"></script>
    <script src="/build/js/page/news.js"></script>
    <script src="/build/lib/share/js/jquery.share.min.js"></script>
    <script type="text/javascript">
          @if(preg_match("/src=[\'|\"](.*?(?:[\.jpg|\.jpeg|\.png|\.gif|\.bmp]))[\'|\"].*?[\/]?/i",$tplData['news_text'],$matches)) var shareImg="{{$matches[1]}}" 
          @else
              var shareImg="http://test.ac.enimo.cn/build/img/logo@2x.png" 
          @endif
        $('#share').share({
            sites: ['weibo','qzone','wechat'],
            title: "{{$tplData['news_title']}}_伟东云学堂",
            description: "我正在伟东云学堂看【{{$tplData['news_title']}}】，非常不错的文章哦！",
            image: shareImg
        });
    </script>
@stop
