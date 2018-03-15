<template>
    <div class="page-index">

        <jui-header :city="tplData.cur_city_info.name"
                    @showSearch="showContent=false"
                    @hideSearch="showContent=true"></jui-header>

        <div class="institute-categories content has-header has-footer">
           <div class="categories">
                    <a :href="item.url" v-for="item in tplData.category_list" class="category">
                        <img class="icon-cate" :src="item.cat_icon_url" alt="">
                        <div class="cate-name">
                            {{ item.cat_name }}
                        </div>
                    </a>
            </div>
            <div>
                <institute-list :data="instituteList"></institute-list>
            </div>
        </div>

        <jui-footer></jui-footer>

    </div>
</template>


<style lang="stylus">
.institute-categories
    .categories
        background #fff
        padding 43px 0 23px
        text-align center
        color #000

        .category
            display inline-block
            width 2rem
            margin-bottom 20px

            i
                font-size 1rem

        .icon-cate
            width 80px
            height 80px
            margin-bottom 15px

</style>


<script type="text/ecmascript-6">
    import Vue from 'vue';
    import {Swipe, SwipeItem} from 'mint-ui';
    import JuiHeader from '../../components/Header.vue';
    import InstituteList from '../../components/InstituteList.vue';
    import JuiFooter from '../../components/Footer.vue';
    import JuiShowcase from '../../components/Showcase.vue';
    import utils from '@/js/utils';
    import api from '@/js/api';

    Vue.component(Swipe.name, Swipe);
    Vue.component(SwipeItem.name, SwipeItem);
    export default {
        components: {
            JuiHeader,
            InstituteList,
            JuiShowcase,
            JuiFooter
        },
        data(){
            return {
                tplData: $tplData,
                instituteList: $tplData['institute_list']
            }
        },
        created () {

        },
        mounted(){


        },
        methods: {


        }
    }


</script>
