<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>@lang('common.bizName')</title>
    <link rel="icon" href="//wdyedu-static.bj.bcebos.com/fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//{{$www_host}}/build/lib/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="//{{$www_host}}/build/css/bos/header_footer.css">
    <link rel="stylesheet" type="text/css" href="//17dayup-passport-dev.bj.bcebos.com/passport.css">
    <style>
        .error-msg {
            min-height: 300px;
            margin-top: 160px;
            font-size: 28px;
            text-align: center;
        }
    </style>
  </head>
  <body>
      @include('layout.header')
      <div class="error-msg">
          <div class="msg">{{ $tplData['msg'] }}</div>
      </div>
      @include('layout.footer')
      <script>
          window.WWW_HOST = "{{ $www_host }}";
          window.PASSPORT_HOST = "{{ $passport_host}}";
      </script>
      <script src="//17dayup-passport-dev.bj.bcebos.com/passport.js"></script>
      <script src="//{{$www_host}}/build/js/page/header_footer.js"></script>
  </body>
</html>
