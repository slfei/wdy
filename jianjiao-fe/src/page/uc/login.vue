<template>
    <div class="page-login">

        <!--<jui-header type="back">登录</jui-header>-->
        <span @click="goBack" class="icon icon-pure-close"></span>
        <div class="login-form">
            <div class="logo-wrapper">
                <div v-if="!weixin_openid">
                    <span class="icon icon-logo"></span>
                    <div class="main-info">短信快捷登录</div>
                    <div class="sub-info">验证即登录，未注册则自动生成新账号</div>
                </div>
                <div v-else>
                    <span class="icon icon-complete"></span>
                    <div class="sub-info">
                        为了您的账户安全请及时绑定手机
                    </div>
                </div>
            </div>

            <div class="login-input-wrapper">
                <span class="ion-ios-close clear_mobile" v-if="this.mobile.length > 0" @click="clearInput"></span>
                <span class="ion-ios-close clear_code" v-if="this.verify_code.length > 0" @click="clearInput"></span>

                <span class="btn btn-primary send-captcha btn-plain"
                      :class="{'btn-disabled': !reg_mobile.test(mobile)}"
                      @click="sendVerifyCode" v-if="captcha_status === 0"> 获取验证码
                </span>
                <span class="btn send-captcha btn-disabled btn-plain"
                      v-else
                > {{ captcha_refresh_time }}s 后重新发送
                </span>
                <field label="" placeholder="请输入手机号" v-model="mobile"></field>
                <field label="" placeholder="请输入验证码" v-model="verify_code"></field>
                <div>
                    <span class="btn btn-primary btn-block btn-large" @click="login">
                        <span v-if="weixin_openid">
                            立即绑定
                        </span>
                        <span class="loginBtn" v-else>
                            登录
                        </span>

                    </span>
                </div>
            </div>
        </div>
        <div class="user-protocol">
            <!--<fieldset>其他登录方式</fieldset>-->
            <!--<legend>其他登录方式</legend>-->

            <fieldset v-if="isWechat && !weixin_openid">
                <legend>其他登录方式</legend>
            </fieldset>

            <div v-if="isWechat && !weixin_openid">
                <a href="/account/weixinauthredirect"
                   class="icon icon-wechat"></a>
            </div>

            <div v-if="!weixin_openid">
                登录/注册表示您已阅读并同意
                <a href="/agreement">《尖椒用户协议》</a>
            </div>

        </div>
    </div>
</template>


<style lang="stylus">
    body {
        background #fff
    }

    .page-login

        .icon-complete
            margin-top 40px
            margin-bottom 40px

        .extra-desc
            font-size 28px

        fieldset
            margin 0 74px
            color #333
            border-top #999 solid 2px

        legend
            background #fff
            font-size 28px
            color #999
            padding 0 20px

        .icon-wechat
            margin 30px 0 40px

        .clear_mobile
            position absolute
            right 210px
            z-index 200
            font-size 50px
            color #ccc
            top 21px
        .clear_code
            position absolute
            right 10px
            z-index 200
            font-size 50px
            color #ccc
            top 120px

        .icon-pure-close
            padding 30px 42px
            background-repeat no-repeat
            background-position center center

        .logo-wrapper
            text-align center

        .icon-logo
            margin-bottom 30px

        .main-info
            font-size 36px
            color #333
            margin-bottom 10px

        .sub-info
            font-size 28px
            color #999
            margin-bottom 50px

        .login-form
            margin 0 74px

    .login-form
        position relative

        input:
        :-webkit-input-placeholder
            color #ccc

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
            top 16px

        .btn-plain
            right 0

        .btn-large
            width 80%
            margin 160px auto 80px

    .login-input-wrapper
        position relative
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
        border-bottom 3px solid #e9314a

</style>


<script type="text/ecmascript-6">
    import api from '../../js/api';
    import JuiHeader from '../../components/Header.vue';
    import {Toast, Field} from 'mint-ui';
    import utils from '@/js/utils';


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

    function clearInput() {
        this.mobile = '';
    }


    export default {
        components: {
            JuiHeader,
            Field
        },
        data: function () {
            return {
                mobile: '',
                reg_mobile: /^0?1[3|4|5|7|8][0-9]\d{8}$/,
                verify_code: '',
                captcha_status: 0,
                captcha_refresh_time: 60,
                isWechat: window.isWechat,
                weixin_openid: $tplData.weixin_openid || ''
            }
        },

        methods: {
            sendVerifyCode: function () {
                var self = this;
                api.sendVerifyCode(this.mobile, 'login').then(function () {
                    self.captcha_status = 1;
                    self.captcha_refresh_time = 60;
                    countDown.call(self);
                }, function (err) {
                    Toast(err);
                });
            },
            login: function () {
                var rgs_origin;
                var type = utils.getParameterByName('type');
                if (type) {
                    rgs_origin = type
                }
                else{
                    rgs_origin = 0
                }
                console.log(rgs_origin)
                api.login(this.mobile, this.verify_code, rgs_origin,$tplData.weixin_openid).then(function () {
                    Toast('登录成功');

                    if (localStorage.test_paramas) {
                        try{
                            let test_params = JSON.parse(localStorage.test_paramas)
                            console.log(localStorage.test_paramas)
                            api.submit_test_data(test_params.title_id,test_params.subject_obj).then(function(res){
                                   utils.test_result_detail(test_params.title_id);
                                   localStorage.removeItem('test_paramas')
                            })
                        }catch(e){
                           let test_params = JSON.parse(this.$cookies.get("test_paramas"))
                           api.submit_test_data(test_params.title_id,test_params.subject_obj).then(function(res){
                                  utils.test_result_detail(test_params.title_id);
                                  this.$cookies.remove("test_paramas")
                           })
                        }

                    }
                    else{
                        var href = utils.getParameterByName('redirect_url');
                        var redirect_url = href || $tplData.redirect_url;
                        try{
                            redirect_url && history.replaceState({}, '尖椒', redirect_url);
                        }catch (e){
                            console.log(e)
                        }

                        setTimeout(function () {
                            if(redirect_url){
                                location.reload()
                            }else {
                                history.go(-1);
                                location.replace(document.referrer);
                            }
                        }, 1000)
                    }

                    // console.log(location.href)
                    // var login_href = location.href
                    // var test_parama_index =location.href.indexOf('?')
                    // var test_parama = decodeURI(login_href.substring(test_parama_index+1,login_href.length))
                    // console.log(JSON.parse(test_parama))
                    // var commit_params = JSON.parse(test_parama)
                    // console.log('title_id',commit_params.title_id)
                    // console.log('subject_obj',commit_params.subject_obj)
                    // console.log()
                    // api.submit_test_data(commit_params.title_id,commit_params.subject_obj).then(function(res){
                    //        utils.test_result_detail(commit_params.title_id);
                    // })

                }, function (err) {
                    Toast(err);
                })
            },
            goBack: function () {
                utils.goBack('/account/center');
            },
                clearInput
        }
    }
</script>
