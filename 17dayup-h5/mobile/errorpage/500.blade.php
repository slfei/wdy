@extends('mobile.base')
@section('style')
<link rel="stylesheet" href="/static/css/page/errorpage/errorpage.css">
@stop 

@section('header') 
@stop


@section('content')
<div class="has-error">
<div class="icon-error error-500"></div>
    <div class="error-btn">
        <a href="/" class="go-index">返回首页</a>
    </div>
</div>



@section('footer')
@stop

@stop @section('script')
<script>
    if(/is_app=1/.test(location.search)){
        $('.error-btn').hide();
    }

</script>
@stop




