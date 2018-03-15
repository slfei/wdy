<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width={{isset($viewport_width) ? $viewport_width : 375}},user-scalable=no" />
    <meta content="@section('meta-keywords')在线课程,在线教育,在线学习,国学文化,亲子早教,家庭教育,幼儿教学,幼儿兴趣,基础教育,小学阶段,初中阶段,高中阶段,考研,出国留学,实用英语,日语,韩语,前端开发,后端开发,产品运营,平面设计,公职考试,财会金融,健康运动,瑜伽课程@show" name="keywords" />
    <meta content="@section('meta-description')伟东云学堂涵盖了国学文化、亲子早教、基础教育、留学语言、IT互联网、职业技能、兴趣爱好以及国际教育等多个领域教育产品，为国内外互联网用户提供了专业优质的教育资源搜索、在线学习、教育资讯以及在线交易等全方位的教育互联网服务。@show" name="description" />

    <link rel="icon" href="/static/img/icon.ico" type="image/x-icon">
    <title>@section('p-title')伟东云学堂-带梦想远航@show</title>
    <link type="text/css" rel="stylesheet" href="/static/lib/ionicons/css/ionicons.css">
    <link type="text/css" rel="stylesheet" href="/static/css/page/base.css">
    @section('style')@show
    <script>
        (function () {
            function isWeiXin(){
                var ua = window.navigator.userAgent.toLowerCase();
                return /micromessenger/.test(ua);
            }

            if(isWeiXin()){
                document.documentElement.classList.add('is-wechat');
                window.isWechat = true;
            }else{
                window.isWechat = false;
            }
        })();
    </script>
</head>
<body>


<div class="wt-root">
    @section('header')
        @component("mobile.components.header", [
            'data' => []
            ])
        @endcomponent
    @show

    @yield('content')

    @section('footer')
        @include('mobile.layout.footer')
    @show
</div>

@section('tplData')
    <script>
        var $tplData;
        try{
            $tplData = {!! isset($tplData) ? json_encode($tplData) : "{}" !!}
        }catch (e){
            $tplData = {};
        }
        window.PASSPORT_HOST = "{{ $passport_host }}";
    </script>
@show

<script src="//res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
<script src="/static/lib/jquery/dist/jquery.js"></script>
<!-- Scripts -->
@yield('script')

<script>
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?ef234da3b182c8da113d71fb947085ce";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
</script>

</body>
</html>
