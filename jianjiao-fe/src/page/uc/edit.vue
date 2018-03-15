<template>
    <div class="page-account-edit">
        <jui-header type="back" :backFn="goBack">
            个人信息
        </jui-header>
        <div class="page-account-edit-main has-header">

            <mt-cell title="头像">

                <vue-core-image-upload
                    :maxWidth="128"
                    :maxHeight="128"
                    crop-ratio="1:1"
                    crop="local"
                    :cropBtn="{'ok':'确认上传','cancel':'取消'}"
                    @imageuploaded="imageuploaded"
                    @errorhandle="imageerrorhandle"
                    :max-file-size="5242880"
                    extensions='png,jpg,gif'
                    :compress="80"
                    url="/api/universal/uploadimage"
                    inputOfFile="image" >
                    <img class="avatar" :src="tplData.avatar_url" alt="">
                </vue-core-image-upload>

            </mt-cell>
            <mt-field label="昵称" class="field-nick-name" v-model="tplData.nick_name" @change.native="onSet('nick_name')"></mt-field>
            <mt-cell title="性别">
                <span class="btn mr"
                      :class="{'btn-primary': tplData.sex == '男'}"
                      @click="setSex('男')">男</span>
                <span class="btn"
                      :class="{'btn-primary': tplData.sex == '女'}"
                      @click="setSex('女')">女</span>
            </mt-cell>
            <mt-field label="生日"
                      class="birth-date"
                      @change.native="onSet('birth_date')"
                      placeholder="点击设置生日" type="date" v-model="tplData.birth_date"></mt-field>
        </div>
    </div>
</template>


<style lang="stylus">
    .page-account-edit-main
        /*.picker-slot-wrapper*/
            /*height 504px !important*/
//
        /*.picker-item*/
            /*height 72px !important*/
            /*line-height 72px !important*/

        .mr
            margin-right 25px
        .btn
            color #fff
            background #e6e6e6
            padding 0
            width 50px
            height 50px
            line-height 50px
            border-radius 25px

        .btn-primary
            background #e9314a

        .mint-cell-wrapper
            padding 0 30px


        .mint-field-core
            text-align right

        .avatar
            width 96px
            height 96px
            padding 30px 0


        background #fff

        .mint-cell-text
            font-size 32px
            color #999

        .mint-cell-value
            color #333

        .mint-cell-wrapper
            border-bottom 1px solid #e5e5e5


        .birth-date
            .mint-field-core
                margin-right -30px

    .g-resize, .circle-btn
        transform scale(3)

    .g-resize-bar
        bottom 72px !important
        background-color #1e88e5 !important

    .g-core-image-corp-container div.info-aside
        bottom 0
        top auto
        background #000
        height auto

        .btn
            height auto
            width auto
            font-size 28px
            line-height 40px
            padding 10px 20px
            border-radius 30px
            margin 16px 16px

        .btn-upload
            background #e9324b
            border-color #e9324b
    .field-nick-name input
        padding-right 16px
</style>


<script type="text/ecmascript-6">
    import JuiHeader from '../../components/Header.vue';
    import { Toast, DatetimePicker } from 'mint-ui';
    import TimePicker from '@/components/TimePicker.vue';
    import api from '@/js/api';
    import VueCoreImageUpload from '../../widget/vue-core-image-upload/vue-core-image-upload.vue'

    export default {
        components: {
            JuiHeader,
            TimePicker,
            'vue-core-image-upload': VueCoreImageUpload,
        },
        data: function () {
            return {
                tplData: $tplData,
                pickerVisible: new Date(),
                pickerHeight: lib.flexible.rem2px(.96)
            }
        },
        methods: {
            setSex: function (sex) {
                this.tplData.sex = sex;
                this.onSet('sex');
            },
            onSet: function (key) {
                var self = this
                setTimeout(function () {
                    api.saveUserInfo(key, self.tplData[key]).then(function () {
                    }, function (err) {
                        Toast(err);
                    })
                }, 100)
            },
            imageuploaded(res) {
                if(res && res.status != 200) {
                    Toast('网络错误！');
                } else {
                    this.tplData.avatar_url = res.data.url || '';
                    api.saveUserInfo('avatar', res.data.url || '').then(function () {
                        Toast('头像修改成功！');
                    }, function (err) {
                        Toast(err);
                    })
                }
            },
            imageerrorhandle(err) {
                Toast(err);
            },
            pickDate: function(){
                this.$refs.datePicker.open();
            },
            goBack:  function () {
                location.href = "/account/center";
            }
        }
    }
</script>
