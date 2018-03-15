<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@if($locale == 'zh_CN') 伟东云收银台 @else Weidong Cloud Cashier @endif</title>
    <link rel="icon" href="/build/img/ico/fav.ico" type="image/x-icon">
    <meta name="keywords" content="伟东云收银台">
    <meta name="description" itemprop="description" content="伟东云收银台">
    <meta name="baidu-site-verification" content="TymQpjkZxF" />
    <meta name="360-site-verification" content="3124f7ed75e9fccb07e458cfc5ac8f31" />
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
    <link rel="stylesheet" type="text/css" href="/build/lib/ionicons/css/ionicons.min.css">
    @section('lib')
    @show
    @section('style')
    @show
</head>
<body @section('bodyClass')@show>

<div class="content" id="content">
    @include('layout.header_pc')
    @yield('content')
    @include('layout.footer_pc')
</div>

<script src="/build/lib/jquery/dist/jquery.min.js"></script>
<script src="/build/lib/toast/jquery.toast.min.js"></script>
<script>
    $('.js_selectLan').on('click','li', function(){
        var location = window.location.href;
        var lan = 'locale=' + $(this).data('lan');
        if(/locale/.test(location)){
            window.location.href = location.replace(/locale=([^&]*)(\\s|&|$)/, lan)
        }else if(/\?/.test(location)){
            window.location.href = location + '&' + lan
        }else{
            window.location.href = location + '?' + lan
        }
    });
</script>
@yield('script')
</body>
</html>
