<template>
    <div class="has-footer">
        <jui-header type="back" forceBackUrl="/" v-if="!isReactNative">
            <span v-if="tplData.type ==1">资讯</span><span v-if="tplData.type ==2">攻略</span><span v-if="tplData.type ==3">资料</span>详情
            <div slot="right">
                <a href="/" class="icon icon-home"></a>
            </div>
        </jui-header>
        <div class="page-news-detail" :class="{'has-header': !isReactNative}">
            <div class="news-detail-main">
                <div class="title">
                    {{ tplData.news_title }}
                </div>
                <div class="news-info">
                    <div>{{ tplData.news_people }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ tplData.created_at }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{tplData.views}}看过</div>
                </div>
                <div v-if="tplData.type ==1">
                    <div class="news-detail" v-html="tplData.news_text"></div>
                </div>
                <div v-if="tplData.type ==2">
                    <div class="news-detail" :class="{expand: is_login}">
                        <div class="rich-text" v-html="tplData.news_text"></div>
                        <div class="expand-bar" @click="toggleExpandBar($event)"  v-if="!is_login">
                            展开全部<i class="ion-ios-arrow-down"></i>
                        </div>
                    </div>
                </div>
                <div class="news-tags">
                    <span class="news-tag" v-for="item in tplData.lable">{{ item.lab_name }}</span>
                </div>
            </div>
        </div>

        <div class="news-comment-wrapper clearfix" id="comment-hook">
            <div class="news-comment-hd clearfix">
                评论（{{tplData.comment_num}}）
            </div>
            <comment-list type="news" :list="tplData.comment_list" :id="tplData.news_id">
                <div slot="empty">
                    目前还没有人评论，快来抢沙发吧~
                </div>
            </comment-list>
        </div>

        <comment-bar type="news" :id="tplData.news_id" v-if="!isMiniProgram"></comment-bar>
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

    export default {
        components: {
            JuiHeader,
            NewsComments,
            CommentBar,
            CommentList,
            api
        },
        data: function () {
            return {
                tplData: $tplData,
                is_login:Boolean,
                isReactNative: window.isReactNative,
                isMiniProgram: window.__wxjs_environment === 'miniprogram'

            }
        },
        methods: {
            toggleExpandBar (e) {
                if (!this.is_login) {
                    location.href = "/account/login?type=2";
                }
            },
        },
        created(){
            var _this = this;
            api.isLogin().then(function (data) {
                _this.is_login = data.is_login
            }, function (err) {
                Toast(err);
            });
            wx && wx.ready(function() {
                _this.window.__wxjs_environment === 'miniprogram'
            });
        }
    }
</script>


<style lang="stylus">
    #app
        min-height initial

    .page-news-detail
        .news-detail-main
            background #fff
            padding 20px
            margin-bottom 10px

        .title
            font-size 46px
            line-height 70px
            margin-bottom 20px

        .news-info
            font-size 24px
            color #999
            margin-bottom 60px

        .news-detail
            color #333
            font-size 32px
            line-height 48px
            .rich-text
                line-height 1.8
                max-height 3200px
                overflow hidden
                -webkit-mask-image: linear-gradient(to bottom, #000, transparent 95%, transparent)
                -webkit-mask-image: linear-gradient(#000 calc(100% - 60px),transparent)
            &.expand
                .rich-text
                    max-height inherit
                    -webkit-mask-image none
            .expand-bar
                position relative
                text-align center

            img
                width 100%
                margin 70px 0

        .news-tags
            margin-top 20px
            margin-bottom 20px


        .news-tag
            display inline-block
            color #999
            font-size 24px
            line-height 40px
            height 40px
            border 1px solid #d1d1d1
            border-radius 25px
            padding 0 10px
            margin-right 20px
            margin-bottom 20px

        .widget-news-comments
            background #fff





    .news-comments-bd
        padding-bottom 100px


    .news-comment-wrapper
        background #fff

        .news-comment-hd
            font-size: 0.48rem
            height: 1.2rem
            line-height: 1.2rem
            padding 0 24px
            border-bottom 3px solid #f0f0f0
</style>
