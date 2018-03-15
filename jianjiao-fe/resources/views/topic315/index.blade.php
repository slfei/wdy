<?php
    $tplData['page_title'] = '一起看资讯，赚积分赢大奖';
    $tplData['topic315'] = 'index';
    $tplData['record'] = $tplData['record'] ? $tplData['record'] : [];
?>


@extends('base.app')

@section('style')
<link rel="stylesheet" href="/build/css/page/topic315/index.css">
<link rel="stylesheet" href="/build/css/315index.css">
@stop

@section('content')
<div class="index pageIndex">
    <div class="head-bg">
        <div class="title">阅读犀利看点，曝光黑心机构，利己又利他何乐而不为？</div>
        <a href="/activity/prizelist" class="action js_isLogin">我要兑换</a>
        <div class="banner-user">
            <ul class="prize-user js_prize_user background">
                @forEach($tplData['record'] as $user)
                <li class="@if($loop->first) first active @endif @if($loop->last) last @endif" @if($loop->last) "last"
                    @endif>
                    {{$user['nick_name']}} 兑换了 {{$user['prize_name']}}
                </li>
                @endforEach
            </ul>
        </div>
    </div>
    <div class="main">
        <div class="title">
            <span class="number">01</span>
            <span class="">积分获取：阅读点评资讯</span>
        </div>
        <div class="content clearfix">
            <div class="content-title">看资讯 兑豪礼</div>
            <p class="content-text">
                2017 <br>某机构老板跑路了，某机构负责人摔狗了，某机构虐童了
            </p>
            <b class="content-text">2018 <br>愿教育更纯粹，尖椒教育在行动</b>
            <div class="line"></div>
            <img class="img" src="/build/img/topic315/index/img2@2x.png" alt="">
            <p class="content-disc">看尖椒辛辣点评资讯 <br>点赞、收藏、分享赚取积分兑豪礼</p>
            <a href="/activity/newslist" class="get-score js_isLogin">我要赚取积分</a>
        </div>
        <div class="title exposure-title">
            <span class="number">02</span>
            <span class="">积分获取：曝光不良机构</span>
        </div>
        <div class="content exposure-content clearfix">
            <div class="content-title">你曝光 我赠礼</div>
            <p class="content-text">
                天价学费、虚假宣传、退费无门 <br>教育培训乱像不绝于耳
            </p>
            <b class="content-text">守护兰芷之室，尖椒教育在行动</b>
            <div class="line"></div>
            <img class="img" src="/build/img/topic315/index/img@2x.png" alt="">
            <p class="content-disc">曝光不良培训机构，赚取积分兑豪礼</p>
            <a href="/activity/exposurelist" class="get-score js_isLogin">我要赚取积分</a>
        </div>
    </div>
    <div class="rules">
        <a href="javascript:void(0)" class="toggle-rules js_rules">积分规则</a>
    </div>
    <!--吸顶-->
    <ul class="prize-user fixtop js_prize_user js_prize_user_fix">
        @forEach($tplData['record'] as $user)
        <li class="@if($loop->first) first active @endif @if($loop->last) last @endif" @if($loop->last) "last" @endif>
            {{$user['nick_name']}} 兑换了 {{$user['prize_name']}}
        </li>
        @endforEach
    </ul>
    <a href="javascript:void(0)" class="invite js_invite"></a>
    <div class="jq-modal jq_modal_invite">
        <div class="modal-content">
            <div class="modal-content-main">
                <div class="modal-title">分享链接邀请好友</div>
                <div class="modal-desc">
                    <div class="share-href js_share_href"></div>
                    <div class="share-desc">分享给您的微博或微信好友，成功邀请一位好友您将获得<span>20</span>积分，您好友会获得<span>1</span>积分</div>
                    <a href="javascript:void(0)" class="copy js_copy" data-clipboard-text="">复制链接</a>
                </div>
            </div>
            <a href="javascript:void(0)" class="close ion-close-round js_close"></a>
        </div>
    </div>
    <div class="jq-modal jq_modal_rules rules-detail" >
        <div class="modal-content">
            <div class="modal-content-main">
                <div class="modal-title rules-title">积分规则</div>
                <div class="text">
                    1.赚取积分前需要填写手机号，以便后期我们为您派发奖品。 <br>
                    2.积分赚取规则 <br>
                    <table class="table">
                        <tr>
                            <td>积分获取方式</td>
                            <td>对应积分</td>
                        </tr>
                        <tr>
                            <td>资讯点赞</td>
                            <td>+1</td>
                        </tr>
                        <tr>
                            <td>资讯收藏</td>
                            <td>+1</td>
                        </tr>
                        <tr>
                            <td>资讯转发</td>
                            <td>+3</td>
                        </tr>
                        <tr>
                            <td>邀请好友</td>
                            <td class="text-color-red">+20</td>
                        </tr>
                        <tr>
                            <td>曝光机构</td>
                            <td class="text-color-red">+100</td>
                        </tr>
                    </table>
                    注： <br>
                    （1）每日可点赞、收藏多条资讯，最多只能获取10积分 <br>
                    （2）每日可分享多条资讯，最多只能获得30积分 <br>
                    （3）活动期间每个账号只能曝光1次 <br>
                    （4）每日邀请好友无上限。 <br>
                    3.涉及以下行为的用户，我们将取消其参与资格。 <br>
                    （1）涉及作弊、广告、黄反、灌水、不文明、 抄袭等行为的账号 <br>
                    （2）模仿或盗用他人ID 个人签名包含有严重影响网友浏览的内容或格式 <br>
                    （3）其他扰乱尖椒教育平台秩序行为的情况 <br>
                </div>
            </div>
            <a href="javascript:void(0)" class="close ion-close-round js_close" ></a>
        </div>
    </div>
</div>
<div id="app">
    <div id="main">
        <Topic315-login v-model="showLogin"></Topic315-login>
    </div>
</div>
@stop
@section('script')
<script src="/build/lib/jquery.min.js"></script>
<script src="/build/lib/clipboard.min.js"></script>
<script src="http://tjs.sjs.sinajs.cn/open/thirdpart/js/jsapi/mobile.js" charset="utf-8"></script>

<script type="text/javascript" src="/build/js/vendor.js"></script>
<script type="text/javascript" src="/build/js/315index.js"></script>
<script>
    (function rotate() {
        var orientation = window.orientation;
        if (orientation == 90 || orientation == -90) {
            document.body.style.display = 'none';
            alert("请使用竖屏访问！");
        }
        window.onorientationchange = function () {
            document.body.style.display = "block";
            rotate();
        };
    })()
</script>
<script>
    $(function () {
        $('.js_invite').click(function (e) {
            if (!checkLogin()) {
                e.preventDefault();
                addLogin()
                app.login()
            } else {
                $('.jq_modal_invite').fadeIn();
            }
        });
        $('.js_rules').click(function (e) {
            /*if (!checkLogin()) {
                e.preventDefault();
                addLogin()
                app.login()
            } else {*/
                $('.jq_modal_rules').fadeIn();
            // }
        });


        $('.js_close').click(function () {
            $('.jq_modal_invite').fadeOut();
            $('.jq_modal_rules').fadeOut();
        });

        // 定时器
        var scroller = $('.js_prize_user');

        function startTimer() {
            return $('.js_prize_user').find('.active.last').length
        }

        if (!startTimer()) {
            setInterval(function () {
                var last = $('.js_prize_user').find('.active.last').length;
                var elmActive = scroller.find('.active');
                elmActive.removeClass('active');
                if (last) {
                    scroller.animate({
                        'scrollTop': 0
                    });
                    scroller.find('.first').addClass('active')
                } else {
                    var top = elmActive.next()[0].offsetTop - scroller[0].offsetTop;
                    scroller.animate({
                        'scrollTop': top//scroller[0].scrollTop + (height)
                    }, 400);
                    elmActive.next().addClass('active');
                }
            }, 2000)
        }

        // 吸顶
        window.onscroll = function () {
            var t = document.documentElement.scrollTop || document.body.scrollTop;
            var top = $('.banner-user').offset().top;
            if (t > top) {
                $('.js_prize_user_fix').css({display: 'block'})
            } else {
                $('.js_prize_user_fix').css({display: 'none'})
            }
        };

        function checkLogin() {
            return $tplData['user_info']['is_login']
        }

        $('.js_isLogin').click(function (e) {
            if (!checkLogin()) {
                e.preventDefault();
                addLogin()
                app.login()
                setTimeout(function () {
                    document.scrollingElement.scrollTop += 100
                }, 5000)
            }
        });

        var shareHref = location.protocol + '//' + location.host + '/activity/index' + $tplData['url'];
        $('.js_share_href').html(shareHref);
        $('.js_copy').attr('data-clipboard-text', shareHref);
        $('.js_copy').click(function () {
            app.toast()
        });
        // 复制
        var clipboard = new Clipboard($('.js_copy')[0])
    });
</script>
@stop
