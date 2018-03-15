<template>
<div class="test-list">
    <div v-if="data.length > 0" class="hot-topic" v-infinite-scroll="loadMore"  infinite-scroll-disabled="disableLoadMore"
infinite-scroll-distance="40">
        <ul class="">
            <li class="clearfix" v-for="item in quizData">
                <a :href="'/quiz/detail/' + item.id">
                    <div class="test_img"><img class="" :src="item.cover_pic" alt="course"></div>
                    <div class="test_intro">
                        <h3>{{ item.title }}</h3>
                        <div class="test_count">{{ item.total_test }}人测过</div>
                    </div>
                </a>
            </li>
        </ul>
        <div v-if="loadingMore" class="loadmore">
            正在加载...
        </div>
    </div>


</div>
</template>

<style lang="stylus">
    .loadmore
        text-align center
        margin 35px
        font-size 26px
    .test_img
        float left
        img 
            float left
            width 260px
            height 124px
            margin-right 20px

    .test-list
        ul
            li
                margin  20px
                padding 20px
                cursor pointer
                background #fff
                h3
                    font-size 27px
                    font-weight 400
                    height 39px
                    line-height 39px

    .test_count
        color #a9acb1
        font-size 28px
        margin-top 60px


</style>
<script>
    import api from '@/js/api';
    export default {
        name: 'quiz-list',
        props: ['data','page', 'loadMoreUrl', 'loadMoreParams'],
        data: function () {
            var page = this.page || {};
            page.pageNow = page.page_num || 1;
            page.pageCount = page.total || 1;

            return {
                quizData: this.data,
                pageData: page,
                loadingMore:false
            }
        },
        methods: {
            loadMore: function () {
                this.disableLoadMore = true;
                var $self = this;
                if(this.loadingMore || this.pageData.total <= this.pageData.page_num*this.pageData.page_size){
                    this.disableLoadMore = true;
                }else{
                    this.loadingMore = true;
                    var params = {};
                    params.page_num = ++this.pageData.page_num;
                    api.loadMore(this.loadMoreUrl,params).then(function (data) {
                        $self.quizData = $self.quizData.concat(data.list);
                        $self.disableLoadMore = false;
                        $self.loadingMore = false;
                    }, function () {
                        self.disableLoadMore = false;
                        self.loadingMore = false;
                    })
                }

            }
        }
    }

</script>
