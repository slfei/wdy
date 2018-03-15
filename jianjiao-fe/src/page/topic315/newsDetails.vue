<template>
    <div class="pageIndex">
        <div class="page-news-detail">
            <div class="news-detail-main">
                <h3 class="title">
                    {{ tplData.title }}
                </h3>
                <div class="news-info" id="new_label">
                    <div>{{ tplData.news_people }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ tplData.show_time }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{tplData.view}}看过</div>
                </div>
                <div class="news-detail" v-html="tplData.text"></div>
                <a href="/activity/index" class="foot-banner"></a>
            </div>
        </div>
        <div class="foot_bar clearfix">
            <div class="operate pull-left">
                <span v-if="is_like==1" @click="like()">
                    <i class="is_like has_like"></i>    {{fabul}}
                </span>
                <span v-else @click="like()">
                    <i class="is_like no_like"></i> 点赞
                </span>
            </div>
            <div class="operate pull-right">
                <span v-if="is_col==1" @click="collection()">
                    <i class="is_col has_col"></i> 已收藏
                </span>
                <span v-else @click="collection()">
                    <i class="is_col no_col"></i>  收藏
                </span>
            </div>
        </div>
        <Topic315-login v-model="showLogin"></Topic315-login>
        <share-modal @hidePanel=hidePanel v-show="panelShow" :panelShow="panelShow" :title="shareTitle" :content="shareContent" ></share-modal>
        <a class="get_score share" @click="openShare"></a>
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
    import '@/js/topicLogin';
    import '@/js/shareWeibo';
    import { Toast } from 'mint-ui';
    import Topic315Login from '../../components/Topic315Login.vue';
    import shareModal from '../../components/shareModal.vue';

    export default {
        components: {
            JuiHeader,
            NewsComments,
            CommentBar,
            CommentList,
            api,
            Topic315Login,
            shareModal
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
                panelShow:false,
                shareTitle:'点击右上角分享',
                shareContent:`每分享一篇文章,您将获得<span class="red"> 3 </span>积分,每天分享资讯最多获得<span class="red"> 30 </span>积分`,
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
            openShare:function(){
                // console.log("cdcd")
                this.panelShow = true;
            },
            hidePanel:function(){
                this.panelShow = false
            },
            like:function(){
                var $self = this;
                if ($self.checkLogin()) {
                    var obj = {
                        object_id:$self.news_id,
                        object_type:7,
                    };
                    if ($self.is_like==0) {
                        api.thumbsUp(obj).then(function(suc){
                            $self.is_like=1;
                             ++$self.fabul;
                            Toast(suc.msg);
                        },function(err){
                            Toast(err);
                        })
                    }
                    else{
                        api.thumbsDown(obj).then(function(suc){
                            $self.is_like=0;
                            --$self.fabul;
                            Toast('取消点赞');
                        },function(err){
                            Toast(err);
                        })
                    }
                }
            },

            collection:function(){
                var $self = this;
                if ($self.checkLogin()) {
                    if($self.is_col == 1){
                        api.removeCollection(7, $self.news_id).then(function (suc) {
                            $self.is_col = 0;
                            Toast('取消收藏');
                        }, function (err) {
                            Toast(err);
                        })
                    }else{
                        api.addCollection(7, $self.news_id).then(function (suc) {
                            $self.is_col = 1;
                            Toast(suc.msg);
                        }, function (err) {
                            Toast(err);
                        });
                    }
                }
            }
        },
        created(){

        }
    }
</script>

<style lang="stylus">
    body
        background #fff

    .page-news-detail
        .news-detail-main
            position relative
            background #fff
            padding 20px 30px 5.2rem
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
            font-size 32px
            line-height 48px
            text-align justify
            img
                width 100%
                margin 70px 0
.foot_bar
    position fixed
    bottom 0px
    left 0
    right 0
    padding 40px 120px
    border-top 2px solid #eee
    background #fff
    .operate
        font-size 32px
        color #313133
</style>
