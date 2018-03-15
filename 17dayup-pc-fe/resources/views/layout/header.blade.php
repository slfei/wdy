<?php
   $type = 'course';
   if (isset($searchType) && $searchType == 'institute') {
       $type = 'institute';
   }
?>
<header class="g-header">
    <input type="hidden" name="loginType" value="{{isset($tplData['user_info'])}}">
    <div class="header_top">
        <div class="header_topArea">
            <div class="header_left" id="J-header-login">
                <div id="nd-loginFalse" class="header_loginFalse @if(!isset($tplData['user_info'])) hide @elseif($tplData['user_info']['is_login']) hide @else  @endif">
                    <span class="header_login login">@lang('common.login.login_tips.tips1')</span>
                    <span class="header_line">|</span>
                    @if($locale == 'zh_CN')
                      <span class="header_register register">@lang('common.login.register')</span>
                    @else
                      <a href="/account/emailregister" target="_blank">@lang('common.login.register')</a>
                    @endif
                </div>
                <div id="nd-loginTrue" class="header_loginTrue @if(isset($tplData['user_info']) && $tplData['user_info']['is_login'])  @else hide @endif">
                    <span class="header_nickname">@lang('common.login.login_tips.tips2')@if(isset($tplData['user_info']) && $tplData['user_info']['is_login']) {{$tplData['user_info']['nick_name']}} @endif</span>
                    <span class="header_logout logout" id="g-header-logout">@lang('common.login.exit')</span>
                </div>
            </div>

            <div class="header_right">
               <span class="header_center header_space @if(isset($tplData['user_info']) && $tplData['user_info']['is_login'])  @else js_login @endif" id="nd_center">@lang('common.menu.center')<i class="ion-ios-arrow-down"></i>
                    <ul id="center_menu" class="@if(isset($tplData['user_info']) && $tplData['user_info']['is_login']) t @else hide @endif dropdown_menu">
                        <li id="nd-institute" class="@if(isset($tplData['user_info']['is_enter']) && $tplData['user_info']['is_enter']) @else hide @endif">
                            <a class="" href="//{{$biz_host}}/institute/index">@lang('common.center_menu.manage')</a>
                        </li>
                        <li>
                            <a class="" href="//{{$www_host}}/center/course">@lang('common.center_menu.class')</a>
                        </li>
                        <li>
                            <a class="" href="//{{$www_host}}/center/order">@lang('common.center_menu.order')</a>
                        </li>
                        <li>
                            <a class="" href="//{{$www_host}}/center/collection">@lang('common.center_menu.collect')</a>
                        </li>
                        <li>
                            <a class="" href="//{{$www_host}}/center/edit">@lang('common.center_menu.set')</a>
                        </li>
                    </ul>
               </span>
               <span class="header_line hide">|</span>
               <a class="header_space hide" href="//{{ $www_host }}/activity/appload">@lang('common.menu.download')</a>
               <span class="header_line">|</span>
               <a class="header_space" href="//{{$www_host}}/help/about">@lang('common.menu.help')</a>

               <span class="header_line">|</span>
               <a class="header_space" href="//{{$www_host}}/help/feedback">@lang('common.footer.col3.item3')</a>
               <span class="header_line">|</span>
               <div class="selectLan">
                  <div class="lan_info @if(isset($locale) && $locale == 'en') en @else cn @endif js_hover">
                    <i class="ion-ios-arrow-down"></i>
                  </div>
                  <ul class="lan_list js_selectLan">
                    <li class="cn" data-lan="zh_CN"></li>
                    <li class="en" data-lan="en"></li>
                  </ul>
               </div>
            </div>
        </div>
    </div>
    <div class="main-container clearfix">
        <div class="header-nav pull-left">
            <a class="logo" href="//{{ $www_host }}"></a>
            <a class="header-nav-item header-active-index" href="//{{ $www_host }}">@lang('common.menu.index')</a>
            <a class="header-nav-item header-active-course" href="//{{ $www_host }}/course/discovery">@lang('common.menu.course')</a>
            <a class="header-nav-item header-active-organ hide" href="//{{ $www_host }}/institute/list">@lang('common.menu.lecturer')</a>
            <a class="header-nav-item header-active-news en-hide" href="//{{ $www_host }}/news/discovery">@lang('common.menu.news')</a>
            <a class="header-nav-item header-active-institute" href="//{{ $www_host }}/activity/join">@lang('common.menu.platform')</a>
            <a class="header-nav-item header-active-appload" href="//{{ $www_host }}/app">@lang('common.menu.download')</a>
        </div>
        <div class="pull-right">
            <form class="c-search pull-left" id="J-search-form">
                <div class="search-box">
                    <div class="left search-type-select" id="J-search-type-select">
                        <span class="search-type selected" data-type="{{ $type }}">
                            @if($type == 'course')
                              @lang('common.search.course')
                            @else
                              @lang('common.search.institution')
                            @endif
                            <i class="ion-ios-arrow-down"></i>
                        </span>
                        <span class="search-type" data-type="{{ $type == 'course' ? 'institute' : 'course' }}">
                            @if($type != 'course')
                              @lang('common.search.course')
                            @else
                              @lang('common.search.institution')
                            @endif
                            <i class="ion-ios-arrow-down"></i>
                        </span>
                    </div>
                    <div class="right js-search">
                        <i class="icon ion-ios-search ico"></i>
                    </div>
                    <div class="search-wrap">
                        <input type="text" class="search-input" placeholder="@lang('common.search.tips')"
                        @if(isset($_GET['q'])) value="{{ $_GET['q'] }}" @endif/>
                    </div>
                </div>
                <div class="dropdown-menu sug-dropdown-menu">
                </div>
            </form>
            <div class="hide header-login pull-right @if(isset($tplData['user_info']) && $tplData['user_info']['is_login'])  @else hide @endif">
                <div class="user-info pull-right">
                    <a class="notice" href="//{{$www_host}}/center/notice">
                        <i class="ion-android-textsms"></i>
                        <span class="num js_msgNum"></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
