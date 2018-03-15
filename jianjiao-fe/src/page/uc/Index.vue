<template>
    <div class="page-uc">
        <!--<a href="" class="pull-left">-->
        <!--<i class="ion-ios-gear-outline"></i>-->
        <!--</a>-->

        <!--<a href="" class="pull-right">-->
        <!--<i class="ion-ios-bell-outline"></i>-->
        <!--</a>-->
        <div class="page-bd has-footer">
            <div class="info-panel">
                <div class="user-info-wrapper clearfix">
                    <a href="/account/login" class="thumbnail" v-if="tplData.is_login === 0">
                        <img :src="tplData.avatar_url"
                             alt="">
                    </a>
                    <a href="/account/edit" class="thumbnail" v-else>
                        <img :src="tplData.avatar_url" alt="">
                    </a>
                    <div class="logined-user-info" v-if="tplData.is_login === 0">
                        <!--<div class="welcome">-->
                        <!--Hello，您好-->
                        <!--</div>-->
                        <div class="action">
                            <a href="/account/login">登录/注册</a>
                        </div>
                    </div>
                    <a href="/account/edit" class="logined-user-info" v-else-if="tplData.is_login === 1">
                        {{ tplData.nick_name }}
                    </a>
                </div>
            </div>

            <div class="personal">
                <mt-cell title="标签管理" is-link to="/account/mytag">
                    <i class="icon icon-tag" slot="icon"></i>
                </mt-cell>
                <mt-cell title="我的收藏" is-link to="/favorite/collection">
                    <i class="icon icon-star" slot="icon"></i>
                </mt-cell>
                <mt-cell title="我的点评" is-link to="/account/mycomment">
                    <i class="icon icon-comment" slot="icon"></i>
                </mt-cell>
                <mt-cell title="我的测试" is-link to="/quiz/resultlist">
                    <i class="icon icon-test" slot="icon"></i>
                </mt-cell>
                <mt-cell title="APP下载" is-link to="/download">
                    <i class="icon icon-app_download" slot="icon"></i>
                </mt-cell>
                <mt-cell title="关于我们" is-link to="/aboutus">
                    <i class="icon icon-smile" slot="icon"></i>
                </mt-cell>
                <mt-cell title="意见反馈" is-link to="/feedback/writefeedback">
                    <i class="icon icon-mail" slot="icon"></i>
                </mt-cell>
                <mt-cell title="退出登录" v-if="!isWechat && tplData.is_login == true" @click.native="logout()">
                    <i class="icon icon-logout" slot="icon"></i>
                </mt-cell>
            </div>
        </div>
        <jui-footer></jui-footer>
    </div>
</template>
<script>
    import JuiFooter from '@/components/Footer.vue';
    import {Cell, Toast} from 'mint-ui';
    import api from '@/js/api';

    export default {
        components: {
            JuiFooter
        },
        data: function () {
            return {
                tplData: $tplData,
                isWechat: window.isWechat
            }
        },
        methods: {
            logout: function () {
                api.post('/api/account/userlogout').then(function () {
                    location.href = location.href;
                    localStorage.removeItem('test_paramas')
                    console.log(localStorage.test_paramas)
                }, function (err) {
                    Toast(err)
                })
            }
        }
    }
</script>

<style lang="stylus">
    .mint-cell-title i
        padding 2px

    .info-panel
        font-size 32px
        color #fff
        background #e9324b
        padding 90px 0 70px
        margin-bottom 20px

        a
            color #fff

        .mint-cell
            height 112px

        .thumbnail
            img
                margin auto
                display block
                width 150px
                height 150px
                border-radius 75px

        .welcome
            line-height 70px

        .action
            font-size 40px
            line-height 70px

        .goto
            height 130px
            line-height 130px

    /*.user-info-wrapper*/
    /*height 130px*/

    .logined-user-info
        display block
        margin-top 20px
        font-size 40px
        text-align center

    .info-row
        display block
        color #666
        background #fff
        text-align center
        margin-top 20px
        height 124px
        line-height 124px
        font-size 32px

        i
            font-size 48px
            position relative
            top 7px

    .page-uc
        .mint-cell-title
            height 112px
            line-height 112px
            font-size 32px
            color #333

        .personal .mint-cell-wrapper
            background-image none
            border-bottom 1px solid #f0f0f0
            padding 0 20px 0 30px
            .icon
                /*position relative*/
                /*top 14px*/
                margin-right 20px

        .mint-cell-allow-right::after
            width 20px
            height 20px

            .icon-mail
                top 12px
</style>
