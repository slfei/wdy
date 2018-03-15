<template>
    <div class="hot_head">
        <div class="activity_con">
            <div class="">
                <div class="activity">{{title}}</div>
            </div>
            <div class="text" v-html="content"></div>
            <div class="rule-area">
                <div class="spread clearfix" :class="{new_rule:!isExposure}" v-html="rule">
                </div>
                <div class="expose" v-if="isExposure">
                    <a class="expose_bg" v-if="status==0" @click="go">我要曝光</a>
                    <a class="is_write" v-else-if="status==1">
                    您的曝光正在审核中
                    </a>
                    <a class="is_write" v-else-if="status==2" :href="'/activity/exposuredetail/'+ exposureId ">
                        您的曝光已通过审核,积分+100 点击查看
                    </a>
                    <a class="is_write" v-else href="/activity/saveexposure">
                        您的曝光未通过审核，点击前去修改
                    </a>
                </div>
            </div>
        </div>
        <Topic315-login v-model="showLogin"></Topic315-login>
    </div>
</template>
<style lang="stylus">
.hot_head
    .activity_con
        padding 80px 
    .activity
        font-size 26px
        line-height 34px
        color #b66c2e
        font-weight 500
    .text
        padding 37px 0 27px
        font-size 26px
        color #4a4a4a
        line-height 44px
        border-bottom 3px dashed #f8eac1
        letter-spacing 1px
        p
            height 15px !important
    .rule-area
        position relative
        .spread
            margin-top 26px
            font-size 26px
            font-weight bold
        .new_rule
            margin 30px 0
            line-height 50px
        .red
            color #ea324b
        .expose
            margin-top  23px
            font-size 32px
            color #a85a33
            text-align center
            .is_write 
                display inline-block
                margin-top 15px
</style>
<script type="text/ecmascript-6">
import Topic315Login from '../../components/Topic315Login.vue';
import '@/js/topicLogin';

    export default {
        components: {
            Topic315Login
        },
        props: {
            title: {
                required: true,
                type: String
            },
            content: {
                required: true,
                type: String
            },
            rule: {
                required: true,
                type: String
            },
            status: {
                required: false,
                type: Number
            },
            isExposure:{
                required: true,
                type: Boolean
            },
            exposureId:{
                required: false,
                type: Number
            },
            isLogin:{
                required: false,
                type: Boolean
            }
        },
        data: function(){
            return {
                showLogin:false,
            }
        },
        methods: {
            checkLogin: function () {
               if(!this.isLogin){
                    window.addLogin();
                   this.showLogin = true;
                   return false;
               }
               return true;
            },
            go:function(){
                if (this.checkLogin()) {
                     location.href='/activity/saveexposure'
                } 
            }

        }
    }
</script>
