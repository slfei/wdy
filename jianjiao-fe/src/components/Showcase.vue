<template>
    <div class="showcase-wrapper" v-if="list.length > 0"
         v-infinite-scroll="loadMore"
         infinite-scroll-disabled="disableLoadMore"
    >
        <mt-cell-swipe v-for="(item, i) in list"
                       @click.native="clickItem(item)"
                       :right="operable ?  [{
                               content: '删除',
                               style: { background: '#E9314A', color: '#fff' },
                               handler:  function() {
                                   deleteItem(item, i);
                               }
                       }] : []"
        >
            <showcase-item :item="item"></showcase-item>
        </mt-cell-swipe>
        <div v-if="loading" class="load-more-loading">
            正在加载...
        </div>
    </div>

    <div v-else class="no-result">
        <slot name="empty">
            <i class="icon icon-no-result"></i>
            <div class="text">空空如也</div>
        </slot>
    </div>
</template>


<script>
    import { CellSwipe, Toast } from 'mint-ui';
    import ShowcaseItem from './ShowcaseItem.vue';
    import api from '@/js/api';


    export default {
        components: {
            CellSwipe,
            ShowcaseItem
        },
        name: 'jui-showcase',
        props: ['data', 'operable', 'page', 'loadMoreUrl', 'loadMoreParams'],
        data: function () {
            var page = this.page || {};
            page.pageNow = page.pageNow || 1;
            page.pageCount = page.pageCount || 1;

            console.log(page);

            return {
                swipeRightOpt: [
                    {
                        content: '删除',
                        style: { background: '#E9314A', color: '#fff' },
                        handler: () => this.$messagebox('delete')
                    }
                ],
                list: this.data,
                pageData: page,
                disableLoadMore: false,
                loading: false
            }
        },
        methods: {
            deleteItem: function (item, i) {
                var self = this;
                api.removeCollection('news', item.news_id).then(function () {
                    self.data.splice(i, 1);
                }, function (err) {
                    Toast(err);
                });
            },
            clickItem (item) {
                window.location.href = '/news/' + item.news_id;
            },
            loadMore: function () {
                this.disableLoadMore = true;
                var self = this;
                if(this.pageData.pageCount <= this.pageData.pageNow){
                    this.disableLoadMore = true;
                }else{
                    this.loading = true;
                    var params = this.loadMoreParams;
                    params.pageNow = ++this.pageData.pageNow;
                    api.loadMore(this.loadMoreUrl, params).then(function (data) {
                        self.list = self.list.concat(data.list);
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
    .mint-cell-value
        width 100%

    .bd-row
        border-bottom 1px solid #f0f0f0
        padding 20px 15px
        color #333
        background #fff


        img
            width 100%
            height 150px
            display block

        .thumbnail
            margin-right .16rem

        .img-row
            width 100%
            margin-top .1rem
            margin-bottom .2rem

        .img-center
            margin 0 .16rem


        .title
            color #333
            display block
            font-size 36px
            line-height 44px
            margin-bottom 18px

        .text-info
            font-size 28px
            color #999

        .mint-cell-title
            display none

        .mint-cell-value
            display block
            width 100%

        .mint-cell-wrapper
            padding 0

    .mint-tab-container,.section-bd,.showcase-wrapper
        .mint-cell-wrapper
            background none

    .mint-navbar .mint-tab-item.is-selected
        border-bottom 4px solid #26a2ff
</style>
