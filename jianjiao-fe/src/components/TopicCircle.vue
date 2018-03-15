<template>
    <div v-if="topiclist.length > 0" class="hot-topic" v-infinite-scroll="loadMore"  infinite-scroll-disabled="disableLoadMore">
        <mt-cell-swipe v-for="(item, i) in topiclist"
                       @click.native="clickItem(item)"
                       :right="operable ?  [{
                               content: '删除',
                               style: { background: '#E9314A', color: '#fff' },
                               handler:  function() {
                                   deleteItem(item, i);
                               }
                       }] : []">
            <topiccircle-item :item="item" :showres='showres' :showlabel='showlabel'></topiccircle-item>
        </mt-cell-swipe>

        <div v-if="loading" class="loadmore">
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
    import api from '@/js/api';
    import TopiccircleItem from './TopiccircleItem.vue';


    export default {
        components: {
            CellSwipe,
            TopiccircleItem
        },
        name: 'jui-topic',
        props: ['data', 'showres','showlabel', 'operable', 'page', 'loadMoreUrl', 'loadMoreParams'],
        data: function () {
            var page = this.page || {};
            page.pageNow = page.page_num || 1;
            page.pageCount = page.total || 1;

            return {
                topiclist: this.data,
                pageData: page,
                loading:false,
                disableLoadMore: false
            }
        },
        methods: {
            deleteItem: function (item, i) {
                var self = this;
                api.focusquestion(item.question_id).then(function () {
                    self.data.splice(i, 1);
                }, function (err) {
                    Toast(err);
                });
            },
            clickItem (item) {
                // console.log(item.institute_id)
                // window.location.href = '/institute/detail/' + item.institute_id;
            },
            loadMore: function () {
                this.disableLoadMore = true;
                var $self = this;
                if(this.pageData.pageCount <= this.pageData.pageNow){
                    this.disableLoadMore = true;
                }else{
                    this.loading = true;
                    var params = {};
                    params.page_num = ++this.pageData.pageNow;
                    api.loadMore(this.loadMoreUrl,params).then(function (data) {
                        $self.topiclist = $self.topiclist.concat(data.list);
                        $self.disableLoadMore = false;
                        $self.loading = false;
                    }, function () {
                        $self.disableLoadMore = false;
                        $self.loading = false;
                    })
                }
            }
        }
    }
</script>


<style lang="stylus">
    .hot-topic
        margin-bottom 140px
        .mint-cell
            border-bottom 1px solid #f5f5f5
        .mint-cell-value
            width 100%
        .loadmore
            text-align center
            margin 35px
            font-size 26px
</style>
