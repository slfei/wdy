<!DOCTYPE html>
<html lang="en" class="locale-{{isset($locale) ? $locale : 'zh_CN'}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="@if(isset($viewport)){{$viewport}}@else{{'width=device-width, initial-scale=1.0'}}@endif">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@if(isset($title)) {{$title}} @else @lang('common.appName') @endif</title>
    <link rel="icon" href="/build/img/fav.ico" type="image/x-icon">
    <meta name="keywords" content="@if(isset($keywords)) {{$keywords}} @else伟东云学堂@endif"/>
    <meta name="description" itemprop="description" content="@if(isset($description)) {{$description}} @else @lang('common.description') @endif"/>
    <meta name="baidu-site-verification" content="TymQpjkZxF" />
    <meta name="360-site-verification" content="3124f7ed75e9fccb07e458cfc5ac8f31" />
    @section('lib')
    @show
    <link rel="stylesheet" type="text/css" href="/build/css/base.css">
    <link rel="stylesheet" type="text/css" href="/build/lib/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="//wdyedu-static-dev.bj.bcebos.com/passport.css">
    @section('style')
    @show
</head>
<body @section('bodyClass')@show>

<div class="content" id="content">
    @yield('content')
</div>

<script>
    window.PASSPORT_HOST = "{{ $passport_host }}";
    window.BIZ_HOST = "{{ $biz_host }}";
    window.WWW_HOST = "{{ $www_host }}";
    window.LOCALE = "{{ $locale }}";
</script>
<script src="/build/lib/jquery/dist/jquery.min.js"></script>
<script src="//wdyedu-static-dev.bj.bcebos.com/passport.js"></script>
<script src="/build/js/page/base.js"></script>
@yield('script')
<script type="text/javascript">
    var _hmt = _hmt || [];
    (function() {
        var hm = document.createElement("script");
        hm.src = "https://hm.baidu.com/hm.js?cfc99c618211ef6d7feb13fe17499f2c";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(hm, s);
    })();
    @if (isset($is_debug) && $is_debug == false)
    (function(){
        var bp = document.createElement('script');
        var curProtocol = window.location.protocol.split(':')[0];
        if (curProtocol === 'https') {
            bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';
        }
        else {
            bp.src = 'http://push.zhanzhang.baidu.com/push.js';
        }
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(bp, s);
    })();
    @endif
</script>
</body>
</html>
