<?php
   $titleName = $tplData['news_cat']['cat_name'];
   $title = $titleName."_资讯头条_伟东云学堂";
   switch($titleName){
     case '推荐':
        $keywords = "推荐资讯,教育资讯,热门资讯,教育新闻";
        $description = "推荐为您从众多资讯中筛选出热门资讯，给您节约阅读时间，用更少的时间看到更好的资讯内容";
     break;
     case '小学':
        $keywords = "小学入学资讯,小学教育资讯,教育资讯,小学信息";
        $description = "小学资讯为您提供小学学习相关的教育资讯，帮助您的孩子更加健康快乐的成长";
     break;
     case '小升初':
        $keywords = "小升初考试资讯,择校资讯,小升初信息";
        $description = "小升初给您提供一些小升初的报考、择校等相关资讯，让您不再为孩子选学校犯愁";
     break;
     case '初中':
        $keywords = "初中教育资讯,初中考试资讯";
        $description = "初中资讯给您提供了一些初中课程，初中学习相关的资讯，让您更轻松的度过初中三年";
     break;
     case '中考':
        $keywords = "中考科目,中考考点,中考考试资讯";
        $description = "中考资讯为您提供了一些中考相关的资讯内容，让您提前了解中考需要准备的知识内容，更加从容的面对中考";
     break;
     case '高中':
        $keywords = "高中知识,高中课程,高中资讯";
        $description = "高中资讯为您提供一些高中学习，高中知识的资讯，让您充实的过好高中三年";
     break;
     case '高考':
        $keywords = "高考信息,高考资讯,大学选择,高考科目,高考头";
        $description = "高考资讯为您提供全国各地高考信息，高考资讯，报考相关信息，让您的高考选择更多样";
     break;
     case '充电':
        $keywords = "充电资讯,课外提升,职场提升";
        $description = "充电资讯让您在工作之余进行一下知识充电，让您更轻松的完成手中的工作";
     break;
     case '培训':
        $keywords = "职业培训资讯,艺术培训资讯";
        $description = "培训资讯为您提供一些职业培训，艺术培训的资讯，让您生活更丰富多彩";
     break;
     default:
        $title = "资讯头条_教育资讯_伟东云学堂";
        $keywords = "资讯头条,教育资讯,留学资讯,国学资讯,考研资讯,基础教育资讯,北京教育资讯,上海教育资讯,青岛教育资讯,教育头条";
        $description = "伟东云学堂为您呈现最前沿的教育资讯信息，为家长和学生提供最优质的资讯参考。";
   }
?>

@extends('pc.common')
<?php
    function genUrl()
    {
        return "/news/discovery" ;
    }
?>


@section('main')
<div class="wt_news clearfix">
	<div class="news_cantainer">
		<div class="news_content white-bg">
			<div class="news_top">
				<a href="/news/discovery"> @lang('news.detail.all')</a>
                <i class="ion-ios-arrow-right"></i>
                <a class="good-top" id="drop-btn">
                    <span>{{$tplData['news_cat']['cat_name']}} </span><span class="triangle-down"></span>
                </a>
				<div id="news_category" class="news_category show_none">
					@foreach ($tplData['cat_all'] as $category_li)
					<div class="each_cat @if($category_li['is_show']==1) cat_active @endif">
						<a href="/news/discovery/{{$category_li['cat_id']}}">{{$category_li['cat_name']}}</a>
					</div>
					@endforeach
				</div>
			</div>
			<div class="news_list">
				@foreach ($tplData['news_list'] as $news_list)
					<div class="each_li clearfix">
					    <div class="news_title">
					    	<a href="/news/{{$news_list['news_id']}}">{{$news_list['news_title']}}</a>
					    </div>
					    @if($news_list['img_count']===0)
						    <div class="news_desc">
						    	<a href="/news/{{$news_list['news_id']}}">{{$news_list['text']}}</a>
						    </div>
						    <div class="time-source">
						    	<span>{{$news_list['news_people']}}</span>
						    	<span>{{$news_list['created_at']}}</span>
						    </div>
					    @elseif ($news_list['img_count']===1)
					    	<div class="news_img pull-left">
					    		<a href="/news/{{$news_list['news_id']}}"><img src="{{$news_list['imgs'][0]}}"></a>
					    	</div>
					    	<div class="desc_right">
					    		<div class="news_desc count_one_desc">
					    			<a href="/news/{{$news_list['news_id']}}">{{$news_list['text']}}</a>
					    		</div>
					    		<div class="time-source">
					    			<span>{{$news_list['news_people']}}</span>
					    			<span>{{$news_list['created_at']}}</span>
					    		</div>
					    	</div>
					    @else
					    	<div class="news_img clearfix">
					    	@foreach ($news_list['imgs'] as $img_item)
					    		<div class="each_img pull-left">
					    			<a href="/news/{{$news_list['news_id']}}"><img src="{{$img_item}}"></a>
					    		</div>
					    	@endforeach
					    	</div>
					    	<div class="news_desc hide_desc">
					    			<a href="/news/{{$news_list['news_id']}}">{{$news_list['text']}}</a>
					    	</div>
					    	<div class="time-source">
					    		<span>{{$news_list['news_people']}}</span>
					    		<span>{{$news_list['created_at']}}</span>
					    	</div>
					    @endif
				    </div>
				@endforeach
			</div>
			<div class="">
				@component('pc.components.pagination.index', ['data'=> [
				    'total' => $tplData['page']['total'],
				    'page_size' => $tplData['page']['page_size'],
				    'current' => $tplData['page']['page_num']
				] ])
				@endcomponent
			</div>
		</div>
		<div class="right_recommend white-bg">
			@component('pc.components.course.recommend-course',
			['hotcourse_li'=>$tplData['hotcourse']])
			@endcomponent
		</div>
	</div>
</div>
@stop

@section('style')
	<link rel="stylesheet" type="text/css" href="/build/css/page/news.css">
@endsection

@section('script')
	<script src="/build/js/page/news.js"></script>
@stop

