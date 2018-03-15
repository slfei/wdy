<template>
    <div class="page-search-result" :class="{ 'is-react-native': isReactNative}">
        <jui-header :query="query" city="北京" :type="'search-back'" v-if="!isReactNative"></jui-header>
        <div class="content has-header">
            <div class="sticky">
                <div class="tab">
                    <a class="tab-indicator" @click="tabIndicator = 'institute'" :class="{ active: tabIndicator == 'institute'}">机构</a>
                    <a class="tab-indicator" @click="tabIndicator = 'news'" :class="{ active: tabIndicator == 'news'}">文章</a>
                    <a class="tab-indicator" @click="tabIndicator = 'question'" :class="{ active: tabIndicator == 'question'}">问题</a>
                </div>
                <institute-filter :data="filterData" @changeFilter="reload" v-show="tabIndicator == 'institute'" v-if="!isReactNative"></institute-filter>
            </div>
            <mt-tab-container v-model="tabIndicator" :swipeable="true">

                <mt-tab-container-item id="institute" class="list-container">
                    <div
                         v-infinite-scroll="getInstitute"
                        infinite-scroll-disabled="disableInstituteLoadmore">
                        <institute-list :data="institute_list">
                            <div slot="empty">
                                <div class="icon icon-no-result"></div>
                                <div class="text">
                                    没有搜索到"{{query}}"相关的机构
                                </div>
                                <div class="text">更多机构正在收录中，敬请期待~</div>
                            </div>
                        </institute-list>
                    </div>

                </mt-tab-container-item>

                <mt-tab-container-item id="news" class="list-container">
                    <div v-infinite-scroll="getNews"
                         infinite-scroll-disabled="disableNewsLoadmore">
                        <news-summary-item v-for="item in news_list" :item="item" @click.native="clickNews(item)"></news-summary-item>
                        <div v-if="news_list.length == 0" class="no-result">
                            <div class="icon icon-no-result"></div>
                            <div class="text">
                                没有搜索到"{{query}}"相关的文章
                            </div>
                        </div>
                    </div>
                </mt-tab-container-item>


                <mt-tab-container-item id="question" class="list-container">
                    <div v-infinite-scroll="getQuestions"
                         infinite-scroll-disabled="disableQuestionsLoadmore">
                         <div v-for="(num, k) in question_list">
                             <topiccircle-item :item="num" :showlabel='true'></topiccircle-item>
                         </div>
                        <div v-if="question_list.length == 0" class="no-result">
                            <div class="icon icon-no-result"></div>
                            <div class="text">
                                没有搜索到"{{query}}"相关的问题
                            </div>
                        </div>
                    </div>
                </mt-tab-container-item>

            </mt-tab-container>
        </div>

    </div>
</template>
<style lang="stylus">
    .page-search-result
        color #333
        font-size 28px
        background #fff
        .tab
            position relative
            z-index 100
            height 89px
            width 100%
            line-height 89px
            display flex
            text-align center
            background #fff
        .sticky
            position sticky
            top 90px
            z-index 1


        .tab-indicator
            flex 1
            border-bottom 2px solid #ccc
            &.active
                color #E9314A
                border-color #E9314A
        .list-container
            min-height 10rem

    .page-search-result.is-react-native
        .sticky
            position fixed
            width 100%
            top 0
        .mint-tab-container
            padding-top 90px
</style>
<script type="text/ecmascript-6">
    import JuiHeader from '@/components/Header.vue';
    import utils from '@/js/utils';
    import InstituteFilter from '@/components/InstituteFilter.vue';
    import InstituteList from '@/components/InstituteList.vue'
    import NewsSummaryItem from '@/components/ShowcaseItem.vue';
    import TopiccircleItem from '@/components/TopiccircleItem.vue';
    import api from '@/js/api';
    import { Toast } from 'mint-ui';
    import { transformFilterData } from '@/js/utils';
    var query = decodeURIComponent(utils.getQuery('q')) || '';

    var filterData = transformFilterData($tplData.position, $tplData.filter.distance_filter, $tplData.category_list);
    var storageKey = 'searchHistory';
    var searchHistory = [];
    try {
        var str = localStorage.getItem(storageKey);
        if (str) {
            searchHistory = JSON.parse(str);
        }
    } catch(e) {

    }
    export default {
        data(){
            return {
                query: query,
                tabIndicator: 'institute',
                city: 'city',
                institute_list: [],
                news_list: [],
                question_list: [],
                searchHistory: searchHistory,
                institutePager: {
                    start: 0,
                    limit: 10,
                    total: 0
                },
                newsPager: {
                    start: 0,
                    limit: 10,
                    total: 0
                },
                questionPager: {
                    start: 0,
                    limit: 10,
                    total: 0
                },
                loadingInstitute: false,
                loadingNews: false,
                loadingQuestions: false,
                filterData: filterData,
                filter: {
                    area: null,
                    sortType: null,
                    distance: null,
                    category: null
                },
                isReactNative: window.isReactNative
            }
        },
        components: {
            JuiHeader,
            InstituteFilter,
            InstituteList,
            NewsSummaryItem,
            TopiccircleItem
        },

        computed: {
            disableInstituteLoadmore() {
                return this.tabIndicator  != "institute" ||this.loadingInstitute || this.institutePager.total <= this.institutePager.start;
            },
            disableNewsLoadmore() {
                return this.tabIndicator  != "news" || this.loadingNews || this.newsPager.total <= this.newsPager.start;
            },
            disableQuestionsLoadmore() {
                return this.tabIndicator  != "question" || this.loadingQuestions || this.questionPager.total <= this.questionPager.start;
            }
        },

        created () {
            this.getInstitute();
            this.getNews();
            this.getQuestions();
            this.getQueryData();
        },

        methods: {
            getInstitute (needClear) {
                this.loadingInstitute = true;
                return api.searchInstitute({
                    query: this.query,
                    city_id: this.filter.area,
                    distance_range: this.filter.distance,
                    sort_type: this.filter.sortType,
                    category_id: this.filter.category,
                    limit: this.institutePager.limit,
                    start: needClear ? 0 : this.institutePager.start
                }).then( data => {
                    this.institute_list = needClear ? data.result_list: this.institute_list.concat(data.result_list); //this.institute_list.concat(new Array(10).fill(data.result_list[0]));
                    this.institutePager.total = data.total;
                    this.institutePager.start = this.institute_list.length;
                    this.loadingInstitute = false;
                    console.log(this.disableInstituteLoadmore, this.institutePager.total,this.institutePager.start);
                }).catch( err => {
                    this.loadingInstitute = false;
                    Toast(err);
                });
            },

            getNews (needClear) {
                this.loadingNews = true;
                return api.searchNews({
                    query: this.query,
                    limit: this.newsPager.limit,
                    start: needClear ? 0 :  this.newsPager.start
                }).then( data => {
                    this.news_list = needClear ? data.result_list : this.news_list.concat(data.result_list);
                    //[].splice.apply(this.news_list, [this.news_list.length, 0].concat(data.result_list));
                    this.newsPager.total = data.total;
                    this.newsPager.start = this.news_list.length;
                    this.loadingNews = false;
                }).catch( err => {
                    this.loadingNews = false;
                    Toast(err);
                });
            },

            getQuestions (needClear) {
                this.loadingQuestions = true;
                return api.searchQuestion({
                    query: this.query,
                    limit: this.questionPager.limit,
                    start: needClear ? 0 :  this.questionPager.start
                }).then( data => {
                    this.question_list = needClear ? data.list : this.question_list.concat(data.list);
                    //[].splice.apply(this.news_list, [this.news_list.length, 0].concat(data.result_list));
                    this.questionPager.total = data.total;
                    this.questionPager.start = this.question_list.length;
                    this.loadingQuestions = false;
                }).catch( err => {
                    this.loadingQuestions = false;
                    Toast(err);
                });
            },

            getQueryData () {
                /*如果之前搜索的数据再次搜索将其放置最前面，大于20条记录时将最后一条数据pop出，*/
                let queryKey = this.query;
                var _previousIndex = this.searchHistory.indexOf(queryKey);
                if(_previousIndex !== -1){
                    this.searchHistory.splice(_previousIndex, 1);
                }else if(this.searchHistory.length >= 20){
                    this.searchHistory.pop();
                }
                this.searchHistory.unshift(queryKey);
                try{
                    localStorage.setItem(storageKey, JSON.stringify(this.searchHistory));
                }catch (E){
                }
            },
            reload (filter) {
                console.log(filter);
                if (filter.category) {
                    this.filter.category = filter.category.id;
                }
                if (filter.sort) {
                    this.filter.sortType = filter.sort.id;
                }
                if (filter.area) {
                    var area = filter.area;
                    if (String(area.id).indexOf('distance_') == 0) {
                        this.filter.distance = area.distance_key;
                        this.filter.area = null;
                    } else {
                        this.filter.area = area.id;
                        this.filter.distance = null;
                    }
                }
                this.getInstitute(true);
            },

            clickNews (item) {
                window.location.href = '/news/' + item.news_id;
            }
        }
    }
</script>
