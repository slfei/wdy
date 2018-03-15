<template>
    <div class="widget-news-comments" id="comment-hook">
        <div class="news-comments-hd">评论({{ tplData.all_comment_num }})</div>
        <div class="news-comments-bd">
            <div class="news-comments-list">
                <div class="news-comments-item" v-for="item in tplData.comment_list">
                    <div class="item-hd">
                        <img class="thumbnail" :src="item.avatar_url" alt="">
                        <span class="username">{{ item.nickname }}</span>
                    </div>

                    <div class="item-bd">
                        {{ item.text_content }}
                    </div>
                    <div class="item-ft clearfix">
                        <span class="pull-left">
                            {{ item.date }}
                        </span>

                        <span class="pull-right">
                            <div class="do-like" :data-cid="item.comment_id"> {{ item.like }} 点赞</div>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>



<style lang="stylus">
    .widget-news-comments
        color #333
        background #fff


        .news-comments-hd
            font-size 36px
            height 90px
            line-height 90px
            padding 0 36px
            border-bottom 2px solid #999

        .news-comments-bd
            background #f0f0f0

            .news-comments-item
                background #fff
                margin-bottom 10px
                padding 32px 36px

            .item-hd
                margin-bottom 30px

                .thumbnail
                    display inline-block
                    width 60px
                    height 60px

                .username
                    font-size 28px
                    position relative
                    top -10px

            .item-bd
                font-size 32px
                margin-bottom 46px

            .item-ft
                line-height 45px
                font-size 24px
                color #7B7B7B

                .do-like
                    border 2px solid #ccc
                    padding 0 23px
                    border-radius 25px

</style>

<script type="text/ecmascript-6">
    import api from '../js/api';


    export default {
        name: 'news-comments',
        data: function () {
            return {
                tplData: $tplData
            }
        },
        beforeCreate: function () {
            var self = this;
            api.getCommentList('news', $tplData.news_id).then(function (data) {
                console.log(data);
                self.tplData = data;
            })
        }
    }
</script>
