<template>
    <div class="login" v-show="value">
        <div class="jq-modal">
            <div class="modal-content">
                <div class="modal-content-main">
                    <div class="modal-title">此手机号作为领奖使用哦~</div>
                    <div class="login-input-wrapper">
                        <span class="btn btn-primary send-captcha btn-plain"
                              :class="{'btn-disabled': !reg_mobile.test(mobile)}"
                              @click="sendVerifyCode" v-if="captcha_status === 0"> 获取验证码
                        </span>
                        <span class="btn send-captcha btn-disabled btn-plain"
                                     v-else>
                         {{ captcha_refresh_time }}s 后重新发送
                        </span>
                        <field label="" placeholder="请输入手机号" v-model="mobile"></field>
                        <field label="" placeholder="请输入验证码" v-model="verify_code"></field>
                        <div>
                            <span class="btn btn-primary btn-block btn-large loginBtn" :class="{'pointer-events-none': !reg_verify_code.test(verify_code)}" @click="login">
                                确定
                            </span>
                        </div>
                    </div>
                </div>
                <a href="javascript:void(0)" class="close ion-close-round" @click="close()"></a>
            </div>
        </div>
    </div>
</template>


<style lang="stylus" type="text/stylus">

    /*html, body
        height 100%
        width 100%
        overflow hidden
        .index
            height 100%
            overflow auto*/

    .loginIndex
        height 100%
        overflow auto
    .loginHtml
        height 100%
        width 100%
        overflow hidden
    .login
        height 100%
        width 100%
        .jq-modal
            display block
            position: absolute;
            z-index 1000
            left: 0;
            top: 0;
            right 0
            bottom 0
            background rgba(0, 0, 0, .5)
            opacity: 1;
            background: rgba(0, 0, 0, 0.6);
            text-align center
            .modal-content
                display inline-block
                margin-top 50%
                width 670px
                height 200px
                .modal-content-main
                    background #fff
                    border-radius 10px
                    .modal-title
                        border-top-left-radius 10px
                        border-top-right-radius 10px
                        height 88px
                        line-height 88px
                        background #ea324b
                        font-size: 32px;
                        color: #ffffff;
                .close
                    display inline-block
                    margin-top 22px
                    font-size 50px
                    color #fff
        /*登录*/
        .login-input-wrapper
            position relative
            width 585px
            margin-left auto
            margin-right auto
            padding 20px 0 40px 0
        .login-input-wrapper .mint-field-clear
            opacity 0

        .user-protocol
            /*position absolute*/
            margin-top 120px
            bottom 60px
            width 100%
            text-align center
            font-size 28px
            color #999

            a
                color #E9314A

        .login-input-wrapper .mint-cell-wrapper
            border-bottom 3px solid #e2e2e2
        .loginBtn
            margin-top 40px
            //mine
        .login-input-wrapper
            .pointer-events-none
                background:#d6d6d6;
                pointer-events none
            .send-captcha
                z-index 100
                height 60px
                line-height 60px
                position absolute
                right 10px
                width 200px
                padding 0
                display inline-block
                text-align center
                border-radius 40px
                top 130px
                background #fff
                border 2px solid #e2e2e2
                color #666



</style>


<script type="text/ecmascript-6">
    import api from '@/js/api';
    import {Toast, Field} from 'mint-ui';
    import utils from '@/js/utils';

    // 60秒倒计时
    function countDown() {
        var end = new Date() - 0 + 60 * 1000;
        var self = this;
        var tid = setTimeout(function _repeat() {
            var leftTime = Math.round((end - new Date()) / 1000);
            if (leftTime >= 1) {
                self.captcha_refresh_time = leftTime;
                setTimeout(_repeat, 1000);
            } else {
                self.captcha_status = 0;
                self.captcha_refresh_time = 60;
            }
        }, 1000);
    }

    export default {
        props: {
            value: {
                default: false
            }
        },
        components: {
            Field
        },
        data: function () {
            return {
                mobile: '',
                reg_mobile: /^0?1[3|4|5|7|8][0-9]\d{8}$/,
                reg_verify_code: /\d{6}/,
                verify_code: '',
                captcha_status: 0,
                captcha_refresh_time: 60,
                activity: 315,
            }
        },
        methods: {
            close: function(){
                this.$emit('input', false);
                window.removeLogin()
            },
            ismobile: function () {
                if(!this.reg_mobile.test(this.mobile)){
                    Toast('手机号错误');
                    return false;
                }
                return true;

            },
            // 获取验证码
            sendVerifyCode: function () {
                if(this.ismobile()){
                    var self = this;
                    api.sendVerifyCode(this.mobile, 'login').then(function () {
                        self.captcha_status = 1;
                        self.captcha_refresh_time = 60;
                        countDown.call(self);
                    }, function (err) {
                        Toast(err);
                    });
                }
            },

            login: function () {
                let _this = this;
                api.login(this.mobile, this.verify_code, '', '', this.activity).then(function () {
                    // Toast('登录成功');
                    // _this.loginVisible = false;
                    location.reload();
                }, function (err) {
                    Toast(err);
                })
            }
        },
        created(){

        },
    }
</script>
