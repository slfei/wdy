<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=375,user-scalable=no" />
    <meta content="伟东云收银台" name="keywords" />
    <meta content="伟东云收银台" name="description" />
    <link rel="icon" href="/static/img/icon.ico" type="image/x-icon">
    <title>@if($locale == 'zh_CN') 伟东云收银台 @else Weidong Cloud Cashier @endif</title>
    <link type="text/css" rel="stylesheet" href="/build/lib/ionicons/css/ionicons.css">
    <script src="/build/lib/jquery/dist/jquery.min.js"></script>
    @section('style')
    @show
    <script>
        (function () {
            function isWeiXin(){
                var ua = window.navigator.userAgent.toLowerCase();
                return /micromessenger/.test(ua);
            };

            if(isWeiXin()){
                window.isWechat = true;
            }else{
                window.isWechat = false;
            }
        })();
    </script>
</head>
<body>


<div class="wt-root">
    
    @yield('content') 
  
</div>
    <script src="//res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script>
       $('.js_back').on('click', function(){
        var type = $(this).data('url');
        if(type){
            history.go(-3);
        }else{
            history.back();
        }
       });
    </script>
    <!-- Scripts -->
    @yield('script')
</body>
</html>

