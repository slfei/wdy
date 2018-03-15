<template>
    <transition name="search-pop">
        <div class="search-modal" @touchstart="onPageTouchStart" v-if="value">
            <header class="header fixed flex search-mode">
                <form method="get" action="/search" class="search-wrapper">
                    <i class="ion-ios-search-strong fixed-search-icon"></i>
                    <input type="search"
                           name="q"
                           class="search-input"
                           ref="input"
                           v-model="query"
                           placeholder="  请输入关键字">
                    <i class="ion-ios-close fixed-close-icon" @click="query = ''" v-show="query.length"></i>
                </form>
                <div class="cancel-search" @click="cancelSearch">
                    取消
                </div>
            </header>
            <div class="search-content" v-iscroll="scrollOption">
                <div class="v-scroll">
                    <div class="sug-list" v-show="query">
                        <div class="mint-search-list-warp">
                            <div class="sug-item word" v-for="sug in sugList.words_list" @tap="doSearch(sug.name)">
                                <i class="ion-ios-search-strong"></i>
                                <span class="text">{{ sug.name }}</span>
                                <span class="extract-info">约{{ sug.count }}个结果</span>
                            </div>
                            <div class="sug-item institute" v-for="sug in sugList.institute_list" @tap="viewDetail(sug)">
                                <div class="institute-info">
                                    <i class="ion-ios-location-outline"></i>
                                    <span class="text">{{ sug.institute_name }}</span>
                                </div>
                                <span class="location">{{ sug.address }}</span>
                                <span class="extract-info">{{ sug.distance }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="content" v-show="!query">
                        <section class="hot">
                            <h3 class="section-title">
                                热门搜索
                            </h3>
                            <ul class="hot-list">
                                <li class="hot-word" v-for="word in hotSearchList" @tap="doSearch(word, false)">
                                    {{ word }}
                                </li>
                            </ul>
                        </section>
                        <section class="search-history">
                            <h3 class="section-title">
                                历史搜索
                                <i class="ion-ios-trash-outline" @tap="clearHistory"></i>
                            </h3>
                            <ul class="history-list">
                                <li class="history-word" v-for="word in searchHistory" @tap="doSearch(word, false)">
                                    {{ word }}
                                </li>
                            </ul>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>
<style lang="stylus">
.search-modal
    position fixed
    top 0
    left 0
    bottom 0
    width 100%
    z-index 9999
    background #F5F5F5
    text-align left
    .search-content
        position absolute
        top 90px
        bottom 0
        width 100%

    .search-wrapper
        .search-input
            line-height 1
            padding-right 60px
            box-sizing border-box
        .fixed-close-icon
            position absolute
            top 0
            right 37.5px
            color #ccc
            font-size 33px
    .sug-list
        width 100%
        background #fff
        .sug-item
            padding-left 26px
            height 100px
            border-bottom 1px solid rgba(0,0,0,.08)
            font-size 32px
            color #999
            &.word
                line-height 100px
            &.institute
                line-height 1.5
        .text
            color #333
            padding-left 6px
        .extract-info
            float right
            font-size 24px
            margin-right 18px
        .institute-info
            line-height 1
            margin-top 28px
        .location
            font-size 24px
            margin-left 32px
    .section-title
        margin 37px 0 20px 19px
        color #999
        font-size 28px
        line-height 37px
        height 37px
        border-left 5px solid #E9314A
        padding-left 10px
        i
            float right
            margin-right 20px
            font-size 40px
            color #333
    .hot-list,
    .history-list
        margin-left 19px
        margin-right -19px
    .hot-word,
    .history-word
        display inline-block
        box-sizing border-box
        height 72px
        border-radius 36px
        padding 23px 54px
        background #fff
        font-size 28px
        line-height 1
        color #333
        margin 0 24px 19px 0


</style>
<script type="text/ecmascript-6">
    //import JuiHeader from '@/components/Header.vue';
    import api from '@/js/api';
    import '@/directives/iscroll';
    import utils from '@/js/utils';
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
        props: {
            value: {
                type: Boolean,
                required: true
            },
            initQuery: {
                type: String,
                default: ''
            }
        },
        data(){
            return {
                autofocus: true,
                query: '',
                sugList: {
                    words_list: [],
                    institute_list: [ ]
                },
                hotSearchList: [],
                searchHistory: searchHistory,
                scrollOption: {
                    tap: true,
                    //click: true,
                    mouseWheel: true
                }
            }
        },
        created () {
            this.query = this.initQuery;
            this.getHotWords();
            this.$watch('query', function(res) {
            if (res==="" || res===null) {
                try {
                    var str = localStorage.getItem(storageKey);
                    if (str) {
                        this.searchHistory = JSON.parse(str);
                    }
                } catch(e) {

                }
            }
            })
        },
        mounted () {
            //function lockScroll(e){e.preventDefault()}
            this.$watch('value', function(newValue) {
                if (newValue && this.autofocus) {
                    this.$refs.input.focus();
                }

                if (!newValue) {
                    this.query = this.initQuery
                } else {
                    this.getSuggest();
                }

                //document.body[newValue ? 'addEventListener' : 'removeEventListener']('touchmove', lockScroll);
            });

            this.$watch('query', this.getSuggest);
        },

        methods: {
            onPageTouchStart () {
                this.$refs.input.blur();
            },
            cancelSearch () {
                this.$emit('input', false);
            },

            getSuggest () {
                var _timer = this._sugTimer = +new Date();
                if (!this.query) {
                    return ;
                }
                api.getSuggest(this.query).then(data => {
                    if (_timer == this._sugTimer) {
                        this.sugList = data;
                    }
                });
            },

            getHotWords () {
                return api.getHotWords().then(data => {
                    this.hotSearchList = data.hot_keywords;
                })
            },
            doSearch (query, addToHistory = true) {
                query = query || this.query;
                location.href = '/search?q=' + query;
            },

            viewDetail(institute) {
                window.location.href = 'institute/detail/' + institute.institute_id;
            },

            clearHistory () {
                this.searchHistory = [];
                localStorage.removeItem(storageKey);
            }

        }
    }
</script>
