@extends('pc.common')
@section('main')
    <div class="main-container clearfix help-contact">
        <div class="pull-left left">
            @include('pc.components.help.sidebar')
        </div>
        <div class="pull-left right">
            <div class="title">@lang('help.help_contact.title')</div>
            <div class="content">
                <div class="serve_left">
                    <div class="serve-content">
                        <div><span class="concat_address"></span>@lang('help.help_contact.text.one')</div>
                        <div><span class="concat_phone"></span>@lang('help.help_contact.text.two')</div>
                        <div><span class="concat_email"></span>@lang('help.help_contact.text.three')</div>
                        <div><span class="concat_wx"></span>@lang('help.help_contact.text.four')</div>
                        <div>
                        <img src="/build/img/wt-code.png" />
                        </div>
                    </div>
                </div>
                <div class="serve_right">
                   <div id="amap"></div>
                </div>
            </div>
        </div>
    </div>

@stop
@section('lib')
    <link rel="stylesheet" type="text/css" href="/build/lib/bootstrap/bootstrap.min.css">
@endsection
@section('style')
    <link rel="stylesheet" type="text/css" href="/build/css/pc.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/help/contact.css">
@endsection

@section('script')
    <script src="https://webapi.amap.com/maps?v=1.3&key=14a2f6065fe8c4768d9cb921c791b4ef"></script>
    <script type="text/javascript">
        var map = new AMap.Map('amap', {
          scrollWheel: false,
          zoom: 16,
          center: [116.3064300000, 39.9818200000]
        });
        var marker = new AMap.Marker({
          icon: "http://webapi.amap.com/theme/v1.3/markers/n/mark_b.png",
          position: [116.3064300000, 39.9818200000]
        });
        marker.setMap(map);
        marker.setLabel({
          offset: new AMap.Pixel(20, 20),
          content: "我们在这儿"
        });

        AMap.plugin(['AMap.ToolBar','AMap.Scale'],
            function(){
                map.addControl(new AMap.ToolBar());

                map.addControl(new AMap.Scale());
        });
    </script>
@endsection
