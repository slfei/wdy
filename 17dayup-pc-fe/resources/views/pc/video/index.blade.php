<!DOCTYPE html>
<html lang="en" class="locale-{{isset($locale) ? $locale : 'zh_CN'}}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $tplData['course_name'] }} - Ω</title>
    <link rel="icon" href="/build/img/fav.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="/build/css/base.css">
    <link rel="stylesheet" type="text/css" href="/build/lib/ionicons/css/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="//17dayup-passport-dev.bj.bcebos.com/passport.css">
    <link rel="stylesheet" type="text/css" href="/build/css/page/video/index.css">
    <link rel="stylesheet" type="text/css" href="/build/lib/toast/jquery.toast.min.css">
</head>
<body>
<?php
    function timeChange($timeStr) {
        $arr = explode(':', $timeStr);
        if (count($arr) == 3) {
            $hours = intval($arr[0]);
            $minutes = intval($arr[1]);
            $minutes = $hours * 60 + $minutes;
            $minutes = $minutes < 10 ? '0'.$minutes : $minutes;
            return implode(':', [$minutes, $arr[2]]);
        }
        return $timeStr;
    }
    function findLivingCourse($catalog) {
        foreach($catalog as $c) {
            foreach($c['_child'] as $section) {
                if (isLivingCourse($section)) {
                    return $section;
                }
            }
        }
        return null;
    }
    function isLivingCourse($section) {
        return isset($section) && $section['class_type'] == 2 && $section['media_id'] == 0;
    }
    $curSection = isset($tplData['cur_section']) ? $tplData['cur_section'] : findLivingCourse($tplData['course_catalog']);
    $isLive = isLivingCourse($curSection);
?>
<div class="content" id="content">
    <div class="topbar">
        <a class="back pull-left" title="@lang('video.back')" href="/course/{{ $tplData['course_id'] }}">
            <i class="ion-android-arrow-back"></i>
        </a>
        <span class="course-title">
            {{ $tplData['course_name'] }}
        </span>
        <div class="pull-right">
            <a class="link m-r-60" href="/center/publishcomment/?course_id={{$tplData['course_id']}}&enter_type=play" target="_blank">@lang('video.evaluate_course')</a>
            <a class="link m-r-60" href="/help/feedback" target="_blank">@lang('video.feedback')</a>
            @if($tplData['user_info']['is_login'])
                <div class="pull-right user-info clearfix">
                <a class="notice m-r-60 pull-left" href="/center/notice" target="_blank">
                    <i class="ion-android-textsms"></i>
                    <span class="num js_msgNum"></span>
                </a>
                <div class="user-center">
                    <a href="/center/course">
                        <span class="avatar">
                            @if(isset($tplData['user_info']['avatar_url']))
                                <img src="{{$tplData['user_info']['avatar_url']}}">
                            @else
                                <i class="ion-person"></i>
                            @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu ucenter-dropdown-menu">
                        @if(isset($tplData['user_info']['is_enter']) && $tplData['user_info']['is_enter'])
                        <li>
                            <a class="" href="//{{$biz_host}}/institute/index" target="_blank">@lang('common.center_menu.manage')</a>
                        </li>
                        @endif
                        <li>
                            <a class="" href="/center/course" target="_blank">@lang('common.center_menu.class')</a>
                        </li>
                        <li>
                            <a class="" href="/center/order" target="_blank">@lang('common.center_menu.order')</a>
                        </li>
                        <li>
                            <a class="" href="/center/collection" target="_blank">@lang('common.center_menu.collect')</a>
                        </li>
                        <li>
                            <a class="" href="/center/edit" target="_blank">@lang('common.center_menu.set')</a>
                        </li>
                        <li>
                            <a class="logout" href="javascript:;">@lang('common.center_menu.exit')</a>
                        </li>
                    </ul>
                </div>
            </div>
            @else
                <div class="user-info pull-right">
                    <div href="javascript:;" id="J-header-login" class="login-wrap">
                        <a class="login">@lang('common.login.login_tips.tips3')</a>
                        <span class="padding">|</span>
                        <a class="register  @if($locale == 'en') hide @endif">@lang('common.login.login_tips.tips4')</a>
                        @if($locale != 'zh_CN')
                        <a href="/account/emailregister" target="_blank">@lang('common.login.register')</a>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="@if($isLive) side-panel-wrapper @endif">
    
    <?php
        function normalize_title($title){
            
            if(mb_strlen($title) > 15){
                return mb_substr($title, 0, 15, 'utf-8') . '...';
            }else{
                return $title;
            }
        }
        function isLive($item){
            if($item['class_type'] == 2){
                // 直播
                if($item['media_id'] > 0){
                    // 直播回放
                    return false;
                }else{
                    return true;
                }
            }else{
                return false;
            }
        }
        function isReplay($item){
            return $item['class_type'] == 2 && $item['media_id'] > 0;
        }
    ?>
    <div class="course-catalog">
        <div class="catalog-btn">
            <i class="icon-cate"></i>
            <br>
            <span class="en-hide">@lang('video.text.text7')</span>
        </div>
        <div class="chapter-wrap">
            <div class="course-title">
            </div>
        @foreach($tplData['course_catalog'] as $i => $section)
            <div class="chapter-list">
                <div class="chapter-list-titler nowrap">{{ $i + 1 }}.{{ $section['title'] }}</div>
                @foreach($section['_child'] as $item)
                    @if( !isLive($item) )  
                    <a href="/course/player/{{ $item['course_id'] }}/{{$item['id']}}"
                        class="chapter-item clearfix" data-id="{{ $item['id'] }}">   
                        <span class="@if(isReplay($item)) icon-replay @else icon-play @endif"></span>                              
                        <span class="nowrap -left" style="max-width: 180px">{{ $item['title'] }}</span>
                        <span class="duration -left">({{ isReplay($item) ? $item['timelong'] : timeChange($item['media']['timelong']) }})</span>
                    </a>
                    @else
                    <a href="/course/player/{{ $item['course_id'] }}/{{ $item['id'] }}" 
                        title="{{ $item['title'] }}" 
                        class="chapter-item clearfix" data-id="{{ $item['id'] }}">
                        <span class="icon-live"></span>
                        <span class="nowrap -left" style="max-width: 180px">{{ normalize_title($item['title']) }}</span>
                        <span>({{$item['timelong']}})</span>
                    </a>
                    @endif                    
                @endforeach
            </div>
        @endforeach
        </div>
    </div>
    @if($isLive == true)
    <div class="chat-room-wrapper">
            <div class="chat-room-header clearfix">
                <div class="pull-left tab-header js-chat-room active">
                    <i class="icon icon-msg"></i>
                    <span>
                        @lang('video.text.text8')                
                    </span>
                </div>
                <div class="pull-right tab-header js-user-list">
                    <i class="icon-uc"></i>
                    <span class="rel-2">
                    @lang('video.text.text9')    <span class="user-num"></span>                                
                    </span>
                </div>
            </div>
            <div class="chat-room-content">
                <div class="content content-chat-list">
                    <div id="video_sms_list">
                    </div>
                    <div class="chat-input-wrapper">
                        <div class="disabled-text">@lang('video.text.text10')</div>
                        <textarea class="chat-input" placeholder="@lang('video.text.text11')......"></textarea>
                        <div class="sent-btn">@lang('video.text.text12')</div>
                    </div>
                </div>
                <div class="content content-user-list hide">
                </div>
            </div>
    </div>
    @endif
    </div>
    @if($isLive == true)
        <div class="live-player-wrapper" style="background:#000">
            @include('pc.video.tips')
            <div class="live-player" id="live-player">
            </div>
            <div class="flash-container" style="position:absolute;width:100%;height: 100%;display: none">
                <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="" id="obj_vcplayer_28" width="100%" height="100%">
                    <param name="movie" value="/build/lib/txCloud/QCPlayer.swf">
                    <param name="quality" value="autohigh">
                    <param name="swliveconnect" value="true">
                    <param name="allowScriptAccess" value="always">
                    <param name="bgcolor" value="#000">
                    <param name="allowFullScreen" value="true">
                    <param name="wmode" value="opaque">
                    <param name="FlashVars" value="cbName=vcpFlashCB_31">
                    <!--
                    src="//imgcache.qq.com/open/qcloud/video/player/release/QCPlayer.swf"
                    -->
                    <embed 
                            src="/build/lib/txCloud/QCPlayer.swf"
                           width="100%" height="100%" name="obj_vcplayer_28" quality="autohigh"
                           bgcolor="#000" align="middle" allowfullscreen="true" allowscriptaccess="always"
                           type="application/x-shockwave-flash" swliveconnect="true" wmode="opaque"
                           flashvars="cbName=vcpFlashCB_31" pluginspage="http://www.macromedia.com/go/getflashplayer">
                </object>
                <div style="color:#fff;text-align:center;margin-top:40px">
                    <h2>您还未安装flash播放器，点击下面按钮下载安装</h2>
                    <p>
                        <a href="http://www.adobe.com/go/getflashplayer" target="_blank">
                            <img src="/build/img/course/get_flash_player.png" alt="Get Adobe Flash Player"/>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    @else
    <div id="player">
        @include('pc.video.tips')
        <div class="player-container"></div>
        <div class="player-control">
        </div>
    </div>
    @endif
</div>
    <script>
        window.PASSPORT_HOST = "{{ $passport_host }}";
        window.BIZ_HOST = "{{ $biz_host }}";
        window.WWW_HOST = "{{ $www_host }}";
        window.LOCALE = "{{ $locale }}";
        window.COURSEId = {!!json_encode($tplData['course_id'])!!};
        @if($isLive)
            window.CUR_SECTION = {!! json_encode($curSection) !!};
            window.isLive = true;
        @else
            window.isLive = false;
        @endif
    </script>
    <script src="/build/lib/jquery/dist/jquery.min.js"></script>
    <script src="//17dayup-passport-dev.bj.bcebos.com/passport.js"></script>
<!--[if !IE]><!-->
    <script src="/build/lib/baidu-t5player/player/videojs/video.min.js"></script>
    <script src="/build/lib/baidu-t5player/player/videojs/videojs-contrib-hls.min.js"></script>
    {{--<script src="//cdnjs.cloudflare.com/ajax/libs/videojs-contrib-hls/5.11.1/videojs-contrib-hls.js"></script>--}}
    <script src="/build/lib/baidu-t5player/player/videojs/videojs-contrib-quality-levels.min.js"></script>
<!--<![endif]-->
    <script src="/build/lib/baidu-t5player/player/cyberplayer.js"></script>
    <script>
        window.COURSE_INFO = {!!
           json_encode($tplData)
        !!};
    </script>
    @if($isLive)
    <script src="/build/lib/txCloud/webim.js"></script>
    <script src="/build/lib/txCloud/json2.js"></script>
    <script src="//imgcache.qq.com/open/qcloud/video/vcplayer/TcPlayer-2.2.1.js" charset="utf-8"></script>
    @endif
    <script src="/build/lib/toast/jquery.toast.min.js"></script>
    <script src="/build/js/page/video/index.js"></script>
</body>
</html>
