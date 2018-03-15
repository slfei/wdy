<!DOCTYPE html>
<html class="locale-{{isset($locale) ? $locale : 'zh_CN'}}">
  <head>
    <meta charset="utf-8">
    <title>@lang('common.bizName')</title>
    <link rel="icon" href="//wdyedu-static.bj.bcebos.com/fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//{{$www_host}}/build/css/bos/header_footer.css">
    <link rel="stylesheet" type="text/css" href="//17dayup-passport-dev.bj.bcebos.com/passport.css">
  </head>
  <body>
      @include('layout.header')
      <div id="app"></div>
      @include('layout.footer')

      <script>
          window.WWW_HOST = "{{ $www_host }}";
          window.PASSPORT_HOST = "{{ $passport_host}}";
          window.USER_INFO = {!! json_encode($tplData['user_info']) !!};
          window.LOCALE = "{{ $locale }}";
      </script>
      <script src="//17dayup-passport-dev.bj.bcebos.com/passport.js"></script>
      <script src="//{{$www_host}}/build/js/page/header_footer.js"></script>
    <!-- built files will be auto injected -->
  </body>
</html>
