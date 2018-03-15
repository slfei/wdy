<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="/build/img/bg/icon.png" type="image/x-icon">
	<title>
	@section('p-title')
	    @if(isset($tplData['page_title']))
	        {{ $tplData['page_title'] }}
	    @else
	        尖椒教育点评
	    @endif
	@show
	</title>
    <link type="text/css" rel="stylesheet" href="/build/lib/ionicons.min.css">
	<link type="text/css" rel="stylesheet" href="/build/css/all.css">
	@section('style')
	@show

    <script>
        (function () {
            function isWeiXin(){
                var ua = window.navigator.userAgent.toLowerCase();
                if (ua.match(/MicroMessenger/i) == 'micromessenger') {
                    return true;
                } else {
                    return false;
                }
            }

            function getCookie(name) {
                var arr,reg=new RegExp("(^|\\s+)"+name+"=([^;]*)(;|$)");
                if(arr=document.cookie.match(reg))
                    return unescape(arr[2]);
                else {
                    return null;
                }
            }

            function setCookie(name,value, expires) {
                var expires = expires || 30;
                var exp = new Date();
                exp.setTime(exp.getTime() + expires*24*60*60*1000);
                document.cookie = name + "="+ escape (value) + "; path=/; expires=" + exp.toGMTString();
            }
            if(isWeiXin()){
                document.documentElement.classList.add('is-wechat');
                window.isWechat = true;
            } else if (window.isReactNative || getCookie('isRN')) {
                window.isReactNative = true;
                if (window.ReactNativeData) {
                    window.ReactNativeVersion = window.ReactNativeData.version;
                } else {
                     window.ReactNativeVersion = getCookie('isRN') || '1.0';
                }
                document.documentElement.classList.add('is-react-native');
                if (!getCookie('isRN')) {
                    setCookie('isRN', window.ReactNativeVersion || '1.0', 1);
                }
            }
        })();
        @if(isset($tplData['open_web']) && $tplData['open_web'])
            window.isOpenWeb = true;
        @endif
    </script>
</head>
<body @if(isset($tplData['open_web']) && $tplData['open_web']) class="is-open-web" @endif>

    @include('base.flexible')

	@yield('content')


	@section('footer')

	@show

    @section('tplData')
    <script>
        var $tplData;
        try{
            $tplData = {!! isset($tplData) ? json_encode($tplData) : "{}" !!}
        }catch (e){
            $tplData = {};
        }
    </script>
    @show

    <script src="//res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
    <script src="http://tjs.sjs.sinajs.cn/open/thirdpart/js/jsapi/mobile.js" charset="utf-8"></script>
	<!-- Scripts -->
	@yield('script')

    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?7079980cb52615bca952911bc873879d";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <script>
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
    </script>
</body>
</html>
