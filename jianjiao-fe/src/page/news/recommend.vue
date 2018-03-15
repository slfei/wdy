<template>
    <div class="page-discover">
        <discovery-header>
        </discovery-header>
        <div class="recommend-content page-bd has-header has-footer" v-infinite-scroll="loadMore"  infinite-scroll-disabled="disableLoadMore">
            <div v-for="(item,i) in recommendList">
                <topiccircle-item :item="item" :showlabel="showlabel" :showres="true" v-if="item.find_type=='question'"></topiccircle-item>
                <news-item :item="item" v-if="item.find_type=='news'"></news-item>

                <quiz-item :item="item" v-if="item.find_type =='quiz'"></quiz-item>
            </div>
            <div v-if="loading" class="load-more-loading">
                正在加载...
            </div>
        </div>
        <jui-footer></jui-footer>
    </div>
</template>


<script type="text/ecmascript-6">
    import JuiTopic from '../../components/TopicCircle.vue';
    import quizItem from "../../components/quizItem.vue";
    import NewsItem from '../../components/NewsItem.vue';
    import JuiFooter from '@/components/Footer.vue';
    import discoveryHeader from "../../components/discoverHeader.vue";
    import TopiccircleItem from '../../components/TopiccircleItem.vue';
    import api from '../../js/api';
        export default {
            components: {
                JuiTopic,
                quizItem,
                NewsItem,
                JuiFooter,
                discoveryHeader,
                TopiccircleItem
            },
            data: function () {
                var page = {};
                page.pageNow = $tplData.pageNow || 1;
                page.pageCount = $tplData.pageCount || 1;
                console.log(page,'page');
                $tplData["news_cat"] = {cat_id: 0,cat_name: "推荐"};
                return {
                    tplData: $tplData,
                    isDropDownOpen: false,
                    recommendList: $tplData.list,
                    loading:false,
                    disableLoadMore: false,
                    pageData:page,
                    showlabel:true,
                    loadMoreUrl: '/api/news/recommend'
                }
            },
            filters: {
                getComponent(type) {
                    var map = {
                        'news': 'news-item',
                        'quiz': 'quiz-item',
                        'question': 'topiccircle-item'
                    };
                    return map[type] || 'news-item';
                }
            },
            methods: {
                loadMore: function () {
                    this.disableLoadMore = true;
                    var self = this;
                    if(this.pageData.pageCount <= this.pageData.pageNow){
                        this.disableLoadMore = true;
                    }else{
                        this.loading = true;
                        this.pageData.pageNow++;
                        console.log(this.loadMoreUrl)
                        var params = {};
                        params.pageNow = this.pageData.pageNow;
                        api.loadMore(this.loadMoreUrl, params).then(function (data) {
                            //initData(data.list);
                            self.recommendList = self.recommendList.concat(data.list);
                            self.disableLoadMore = false;
                            self.loading = false;
                        }, function () {
                            self.disableLoadMore = false;
                            self.loading = false;
                        })
                    }
                }
            }
        }
</script>

<style lang="stylus">
    .page-discover
        .recommend-content
            background #fff
            margin-bottom 20px
            .quiz_border
                border-top 2px solid #f0f0f0
                border-bottom 2px solid #f0f0f0
        .no-result
            margin-top 100px

        .page-bd
            margin-top 12px
        .load-more-loading
            margin-top 20px
    .is-open-web .page-discover .page-bd
         margin-top 0
</style>
