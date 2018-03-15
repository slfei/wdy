<header>
    <div class="header_goback @if($data['backType'] != 0) js_back @endif" data-url="@if(isset($data['url'])) {{$data['url']}} @endif">
       @if($data['backType'] != 0)
       <span class="icon header_back"></span>
       @endif
    </div>
    <div class="header_title">
       {{$data['title']}}
    </div>
</header>
