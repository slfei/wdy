<template>
    <div class="page-index">

        <jui-header :city="tplData.cur_city_info.name"
                    @showSearch="showContent=false"
                    @hideSearch="showContent=true"></jui-header>

        <div class="content has-header has-footer" v-show="showContent">
            <div class="slider clearfix">
                <mt-swipe :auto="4000" @change="slideChange">
                    <mt-swipe-item v-for="item in tplData.index_banner_list">
                        <a :href=item.url>
                            <img :src=item.img alt="">
                        </a>
                    </mt-swipe-item>
                </mt-swipe>
                <div class="slider-item-desc">
                    <span v-if="sliderActiveItem.text.length>20">
                    {{ sliderActiveItem.text.slice(0,20) }} ...
                    </span>
                    <span v-else-if="sliderActiveItem.text.length<=20">
                       {{ sliderActiveItem.text }}
                    </span>

                </div>
            </div>

            <div id="strategy_id" class="strategy clearfix">
                <div :class="cateBarFixed == true ? 'isFixed' :''" class="categories clearfix" id="cateBar" >
                    <a v-for="(item,no) in categories" :class="{'has-selected': item.is_select}" @click="switch_cate(no,item.cat_id)">
                        {{item.cat_name}}
                    </a>
                </div>

                <div class="recommend clearfix" v-infinite-scroll="loadMore" infinite-scroll-disabled="canLoadMore">
                    <div v-for="item in recommendList">
                        <topiccircle-item :item="item" :showlabel="true" :showres="true" v-if="item.find_type=='question'"></topiccircle-item>

                        <news-item :item="item"  v-if="item.find_type=='news'"></news-item>

                        <news-item :item="item"  v-if="item.find_type=='raiders'"></news-item>

                        <quiz-item :item="item" v-if="item.find_type =='quiz'"></quiz-item>
                    </div>
                    <div v-if="loading" class="loadmore">
                        正在加载...
                    </div>
                </div>
            </div>

            <div v-if="select_institute" class="section mt relative-hook section-need-location">
                <div class="section-hd on-top-layer">
                    <div class="mask-guide-text"></div>
                    <div class="mask-confirm-button"></div>

                    <div class="hd-name">按您的兴趣为您推荐</div>
                    <a href="/account/mytag" class="hd-more highlight customize-tag">定义兴趣标签</a>
                </div>
                <div  class="section-bd">
                    <institute-list :data="instituteList"></institute-list>
                </div>
            </div>

        </div>

        <div class="customize-tag-mask">

        </div>

        <jui-footer></jui-footer>
    </div>
</template>


<style lang="stylus">
    .page-index
        width 100%
        background #f0f0f0
        .strategy
            background #fff
            .isFixed
                background #fff
                position fixed
                top 90px
                z-index 99999
            .loadmore
                text-align center
                margin 35px
                font-size 26px
            .categories
                width 100%
                padding 15px 16px
                margin-bottom 15px
                box-sizing border-box 
                box-shadow 0px 6px 15px #eee
                a
                    display inline-block
                    padding 12px 26px
                    margin 5px 0px
                    font-size 0.38rem
                    color #333
                .has-selected
                    color #fff
                    background #e9314a
                    border-radius 50px
        .on-top-layer
            .mask-guide-text, .mask-confirm-button
                display none
        .relative
            position relative

            .on-top-layer
                position absolute
                width 100%
                box-sizing border-box
                background #fff
                z-index 10001
                overflow visible

            .section-bd
                padding-top 92px

            .mask-guide-text
                display block
                position absolute
                right 60px
                top -225px

            .mask-confirm-button
                display block
                position absolute
                top 120px
                left 50%
                margin-left -91px

        .customize-tag-mask
            display none
            z-index 10000
            position fixed
            top 0
            bottom 0
            width 100%
            height 100%
            background rgba(0, 0, 0, .6)

        .w-100
            width 100%


        .mt
            margin-top 10px
        .section-hd
            overflow hidden
            padding 30px
            position relative

            .hd-name
                float left
                color #333
                font-size 32px
                height 32px
                line-height 32px
                border-left 5px solid #f32e48
                padding 0 8px

            .hd-more
                float right
                color #999
                font-size 28px

                i
                    position relative
                    top 1px

                &.highlight
                    color #E9314A
                    border 1px solid #E9314A
                    border-radius 50px
                    padding 0 20px
                    font-size 24px
                    line-height 50px
                    height 50px
                    position absolute
                    right 30px
                    top 21px

    .slider
        position relative
        height 350px
        img
            width 100%
        .mint-swipe-indicators
            position: absolute;
            bottom: 0;
            text-align right
            background: rgba(0, 0, 0, .5);
            height: 65px;
            line-height 65px
            width: 100%;
            padding-right 20px
            font-size 28px

            .mint-swipe-indicator
                text-align right
                background #a1a0a0
                opacity 1

            .mint-swipe-indicator
                width 13px
                height 13px

            .is-active
                background #fff
                position relative
                top 2px
                width 17px
                height 17px

        .slider-item-desc
            position absolute
            bottom 0
            padding-left 20px
            height 65px
            line-height 65px
            font-size 28px
            color #fff
</style>


<script type="text/ecmascript-6">
    import Vue from 'vue';
    import {Swipe, SwipeItem} from 'mint-ui';
    import JuiHeader from '../components/Header.vue';
    import InstituteList from '../components/InstituteList.vue';
    import NewsItem from '../components/NewsItem.vue';
    import TopiccircleItem from '../components/TopiccircleItem.vue';
    import quizItem from "../components/quizItem.vue";
    import JuiFooter from '../components/Footer.vue';
    import routine from '@/js/routine';
    import utils from '@/js/utils';
    import api from '@/js/api';

    Vue.component(Swipe.name, Swipe);
    Vue.component(SwipeItem.name, SwipeItem);
    export default {
        components: {
            JuiHeader,
            InstituteList,
            NewsItem,
            TopiccircleItem,
            quizItem,
            JuiFooter
        },
        data(){
            var cates = $tplData.all_cat;
            cates.forEach(function(item,i){
                item.is_select = false;
            })
            cates[0].is_select = true;
            return {
                tplData: $tplData,
                showContent: true,
                cateBarFixed: false,
                select_institute: true,
                loading: false,
                cur_id:1,
                total:0,
                page_num:1,
                size:5,
                categories: cates,
                recommendList:$tplData.recommend.list,
                instituteList: $tplData['institute_list'],
                sliderActiveItem: {}
            }
        },
        computed: {
            canLoadMore () {
                return this.loading || this.total <= this.size * this.page_num;
            }
        },
        created () {
            this.sliderActiveItem = this.tplData.index_banner_list[0];
        },
        mounted(){

            window.addEventListener('scroll', this.handleScroll)


            var self = this;

            function once(key, fn) {
                var isCalled = self.$cookie.get(key);
                if (!isCalled) {
                    fn && fn();
                    self.$cookie.set(key, 'true', {expires: '2Y'});
                }
            }

            once('_customize_tag_guide_', function () {
               // routine.initIndexTagGuide()
            });

            routine.firstShowElement(this.$el.querySelector('.section-need-location'), () => {
                routine.uploadLocation((data) => {
                    this.getInterestInstitute();
                })
            });

        },
        destroyed () {
          window.removeEventListener('scroll', this.handleScroll)
        },
        methods: {
            slideChange (index) {
                this.sliderActiveItem = this.tplData.index_banner_list[index];
            },

            getInterestInstitute () {
                api.getInterestInstitute().then(data => this.instituteList = data.list);
            },

            switch_cate(no,id) {
                this.cur_id = id;
                this.page_num = 1;
                this.categories.forEach(function(item,i){
                    if (no==i) {
                        item.is_select = true;
                    }
                    else{
                        item.is_select = false
                    }
                })
                if (no==0) {
                    this.select_institute = true;
                    this.recommendList = $tplData.recommend.list;
                }
                else {
                    this.select_institute = false;
                    this.loadRecommend(id);
                }

                if (this.cateBarFixed) {
                    var anchor = document.querySelector('#strategy_id')
                    document.documentElement.scrollTop = anchor.offsetTop
                    document.body.scrollTop = anchor.offsetTop
                }
            },
            loadRecommend(id) {
                var $self = this;
                api.switchRecommend({
                    cat_id: id,
                    page_size:this.size,
                    page_num:this.page_num
                }).then(data => {
                    $self.loading = false;
                    if (data.page_num !==1) {
                        $self.recommendList = $self.recommendList.concat(data.list)
                    }
                    else {
                        $self.recommendList = data.list
                    }
                    $self.page_num = ++data.page_num;
                    $self.total = data.total;
                    $self.size = data.page_size;
                }).catch(() => this.loading = false);
            },

            loadMore () {
                var $self = this;
                this.loading = true;
                this.loadRecommend($self.cur_id);
            },
            handleScroll () {
              var scrollTop = window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop
              var offsetTop = document.querySelector('#cateBar').offsetTop
              if (scrollTop > offsetTop) {
                this.cateBarFixed = true
              } else {
                this.cateBarFixed = false
              }

            }
        }
    }

    function getLocation() {
        routine.uploadLocation(function (data) {

            if (!data.cur_city_info && !data.is_in_list) {
                return once('__first_not_working_area__', function () {
                    Mint.MessageBox.alert("系统定位地区暂未开通服务，请您先看看北京的机构资源吧");
                })
            }

            // 带 search 的为选择城市
            if (!utils.getParameterByName('cid')) {
                if (data.cur_city_info.citycode != data.actual_city_info.citycode) {
                    return once('__first_not_located_area__', function () {
                        Mint.MessageBox.confirm(
                                '是否切换至' + data.actual_city_info.name,
                                '系统定位地区您在' + data.actual_city_info.name
                        ).then(function () {
                            location.href = '/?cid=' + data.actual_city_info.cityid;
                        })
                    });
                }
            } else {

            }
        });
    }

</script>
