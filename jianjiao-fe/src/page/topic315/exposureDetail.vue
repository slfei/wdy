<template>
    <div class="pageIndex">
        <div class="page-news-detail">
            <div class="news-detail-main">
                <h3 class="title">
                    {{ tplData.title }}
                </h3>
                <div class="news-info">
                    <div>{{ tplData.nick_name }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ tplData.created_at }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{tplData.view}}看过</div>
                </div>
                <div class="news-detail" v-html="tplData.text"></div>
                <div class="img" v-for="(it, k) in tplData.imgs">
                    <img :src="it">
                </div>
                <a v-if="expStatus==0" class="myexposure" @click="goExpsure">
                    我也要曝光黑心机构，赚100积分 >>
                </a>
            </div>
        </div>
        <a v-if="expStatus==0" class="get_score make_money" @click="goExpsure">     
        </a>
        <Topic315-login v-model="showLogin"></Topic315-login>
    </div>
</template>

<script>
    import NewsComments from '../../widget/NewsComments.vue';
    import CommentBar from '../../widget/CommentBar.vue';
    import JuiHeader from "../../components/Header.vue";
    import CommentList from '../../components/CommentList.vue';
    import routine from '@/js/routine';
    import utils from '@/js/utils';
    import api from '@/js/api';
    import '@/js/shareWeibo';
    import { Toast } from 'mint-ui';
    import Topic315Login from '../../components/Topic315Login.vue';
    import '@/js/topicLogin';

    export default {
        components: {
            JuiHeader,
            NewsComments,
            CommentBar,
            CommentList,
            api,
            Topic315Login
        },
        data: function () {
            return {
                 tplData: $tplData,
                 is_like: $tplData.is_like,
                  is_col: $tplData.collection,
                is_login: $tplData.user_info.is_login,
                 news_id: $tplData.news_id,
                   fabul: $tplData.fabul, 
                   showLogin:false,
                   expStatus: $tplData.exposure_status,
                isReactNative: window.isReactNative,
                isMiniProgram: window.__wxjs_environment === 'miniprogram'

            }
        },
        methods: {
            checkLogin: function () {
               if(!this.is_login){
                    window.addLogin();
                    this.showLogin = true;
                    return false;
               }
               return true;
            },
            goExpsure:function(){
                if (this.checkLogin()) {
                    location.href='/activity/saveexposure'
                }
            }
        },
        created(){

        }
    }
</script>


<style lang="stylus">
    body
        background #fff !important
    #app
        min-height initial

    .page-news-detail
        .news-detail-main
            background #fff
            padding 30px
            margin-bottom 10px
            text-align justify

        .title
            font-size 42px
            line-height 70px
            margin-bottom 20px

        .news-info
            font-size 24px
            color #999
            margin-bottom 60px

        .news-detail
            color #333
            font-size 30px
            line-height 55px
            word-wrap:break-word
            letter-spacing 0.7px
        .img
            img
                width 100%
                margin 70px 0
        .myexposure
            display inline-block
            font-size 26px
            color #ea324b
            margin 30px 0
            
.foot_bar
    position fixed
    bottom 0px
    left 0
    right 0
    padding 40px 120px
    border-top 1px solid #eee
    background #fff
    .operate
        font-size 32px
        color #313133
</style>
