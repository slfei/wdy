<?php
    isset($data['backward']) ? '' : $data['backward'] = false;
    isset($data['type']) ? '' : $data['type'] = 'search';
    isset($data['backUrl']) ? '': $data['backUrl'] = '/';
?>


<header class="navbar fixed-header">
    <!-- <nav class="navbar">
        <input type="search" placeholder="搜索你想要的课程或机构">
    </nav> -->

    @if($data['type'] == 'search')
    <div class="weui-search-bar" id="searchBar">
        @if($data['backward'] == true)
        <div class="nav-icon-left js-backward">
            <span class="ion  go-back"></span>
        </div>  
        @else
        <a href="/" class="nav-icon-left">
            <span class="icon icon-logo"></span>
        </a>
        @endif

        <form class="weui-search-bar__form">
            <div class="weui-search-bar__box">
                <i class="weui-icon-search"></i>
                @if(isset($data['q']))
                 <input type="search" class="weui-search-bar__input" placeholder="搜索" required="" value="{{$data['q']}}">
                @else
                 <input type="search" class="weui-search-bar__input" placeholder="搜索" required="" value="">
                @endif
                <a href="javascript:" class="weui-icon-clear"></a>
            </div>
            @if(!isset($data['tips']) || $data['tips'] == 'true')
              <label class="weui-search-bar__label">
                <i class="weui-icon-search"></i>
                <span>搜索你想要的课程</span>
              </label>
            @endif
        </form>
        <a href="javascript:" class="weui-search-bar__cancel-btn">取消</a>
    </div>

    @elseif($data['type'] == 'text')
    <div class="navbar-text row">
        @if($data['backward'] == true)
            @if($data['backUrl'] == '/')
            <div class="nav-icon-left js-backward">
                <span class="ion  go-back"></span>
            </div>
            @else
            <a class="nav-icon-left" href="{{$data['backUrl']}}">
                <span class="ion  go-back"></span>
            </a>
            @endif
        @else 
        <div class="nav-icon-left"></div>
        @endif

        <div class="nav-title col">
            {{ $data['title'] }}
        </div>
        <div class="nav-icon-right">
            @if(isset($data['right_html']))
                {!! $data['right_html'] !!}
            @endif
        </div>
    </div>

    @endif
</header>

@include('mobile.components.header_search')
