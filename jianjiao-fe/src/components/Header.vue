<template>
    <div>
        <header class="header fixed flex" v-if="type=='search' || type=='search-back'">
            <a class="area-picker" :href="'/selectcity?ref=' + urlPath" v-if="type== 'search'">
                {{ city }} <i class="ion-chevron-down"></i>
            </a>

            <div class="pull-left" v-else>
                <i class="ion-chevron-left" @click="goBack"></i>
            </div>
            <form action="/" class="search-wrapper">
                <!--<i class="ion-ios-search-strong"></i>-->
                <!--<div class="search-input" @click="toggleSearchBox">-->
                    <!--<i class="ion-ios-search-strong"></i> 请输入搜索词-->
                <!--</div>-->
                <i class="ion-ios-search-strong fixed-search-icon"></i>
                <input type="search" class="search-input"
                       @click="toggleSearchBox"
                       placeholder="  请输入关键字"
                       :value="query"
                >
            </form>
            <div class="cancel-search" @touchstart="toggleSearchBox">
                取消
            </div>
            <search-modal v-model="showSearch" :init-query="query"></search-modal>
        </header>


        <header class="header fixed" v-else-if="type == 'back'">
            <div class="pull-left">
                <i class="ion-chevron-left" @click="goBack"></i>
            </div>

            <slot></slot>
            <div class="pull-right">
                <slot name="right"></slot>
            </div>
        </header>

    </div>
</template>

<script>
    //import Search from 'mint-ui';
    import SearchModal from '@/components/Search.vue';
    import utils from '@/js/utils';
    import { MessageBox } from 'mint-ui';


    export default {
        name: 'jui-header',
        components: {
            SearchModal
        },
        props: {
            type: {
                type: String,
                default: 'search'
            },
            city: {
                type: String
            },
            query: {
                type: String
            },
            backFn: {
                type: Function
            },
            forceBackUrl: {
                type: String
            }
        },
        data: function () {
            return {
                showSearch: false,
                urlPath: location.pathname
            }
        },
        created () {
            this.$watch('showSearch', function(showSearch) {
                this.$emit(showSearch ? 'showSearch' : 'hideSearch');
            });
        },
        methods: {
            goBack: function () {
                if (location.href.indexOf('quiz/detail/')>0) {
                        MessageBox.confirm('你确定退出尖椒测试吗?').then(action => {
                            this.backFn ? this.backFn() :
                                utils.goBack(this.forceBackUrl);
                                          });
                }
                else if(location.href.indexOf('quiz/shareresult/')>0){
                    location.href = '/quiz/list';
                }
                else{
                    this.backFn ? this.backFn() :
                        utils.goBack(this.forceBackUrl);
                }
                this.$emit('goBack')
            },
            toggleSearchBox: function (e) {
                this.showSearch = true;
            }
        }
    }
</script>

<style lang="stylus">
    .header
        font-size 32px

        .area-picker
            overflow hidden
            width 180px
            text-align center
            transition: width  0.2s;
            padding 0

            i
                font-size .4rem !important


        .search-wrapper
            width 100%
            box-sizing border-box
            text-align center
            position relative
            color #999
            padding 0 20px 0 0


            .fixed-search-icon
                position absolute

            .ion-ios-search-strong
                /*position absolute*/
                font-size .6rem
                left 22px
                top 3px

            ::-webkit-input-placeholder
                /* Chrome/Opera/Safari */
                color: #999;


            .search-input
                color #999
                width 100%
                display block
                background #fff
                height 60px
                line-height 60px
                border-radius 30px
                margin-top 14px
                text-align left
                font-size 28px
                padding-left 60px
                border none
                box-sizing border-box


        .pull-right, .pull-left
            width 100px
            height 100%


        .cancel-search
            width 0
            overflow hidden
            transition: width  0.2s;


    .search-result
        background #fff
        position fixed
        z-index 1000
        padding-top 90px
        width 100%
        height 100%


    .search-mode

        .search-wrapper
            padding-left 20px

            .ion-ios-search-strong
                left 40px

        .cancel-search
            width 110px
            text-align left

        .area-picker
            width 0

    .mint-searchbar-inner
        .mint-searchbar-core
            font-size 24px


    .search-page
        width 100%
        height 100%
        position fixed;
        z-index 2000;
        background #FFF


        .do-search-input-wrapper
            padding 15px 20px
            flex 1

            .do-search-input
                display block
                font-size 28px
                height 60px
                line-height 60px
                border none
                width 100%
                border-radius 30px
                padding-left 66px
                color #999


        .cancel-search
            width 100px
            text-align center
</style>


