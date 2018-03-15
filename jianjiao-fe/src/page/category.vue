<template>
    <div class="page-wrapper">
        <jui-header :city="city"></jui-header>
        <div class="page-category has-header has-footer">
            <aside id="sideBar" v-iscroll="scrollOption">
                <div class="scroller">
                    <div v-for="cate in data"
                         :class="{active: activeItem == cate}"
                         class="cate-item"
                         @tap="activeItem = cate"
                    >
                        <img class="cate-icon" :src="cate.cat_icon_url"/>
                        {{ cate.cat_name }}
                    </div>
                </div>
            </aside>
            <div class="sub-cate-list" v-if="activeItem">
                <cate-nodes :data="activeItem.child_cat"></cate-nodes>
            </div>
        </div>
        
        <jui-footer></jui-footer>
    </div>
</template>
<style lang="stylus">
    body
        background #F5F5F5
    .page-category
        box-sizing border-box
        display flex
        color #333333
        aside
            position fixed
            top 90px
            bottom 100px
            width 200px
            background #EBEBEB
            //background #fff
        .cate-icon
            width 40px
            margin-right 20px
            vertical-align middle
        .cate-item
            height: 99px
            line-height: 99px
            text-align: center;
            font-size: 28px;
            border-bottom: 1px solid #CCC

            &.active
                background #F5F5F5
                border-color #E9314A
                color #E9314A

    .sub-cate-list
        margin-left 200px
        padding 10px 40px
        flex 1

</style>
<script>
    import JuiHeader from '../components/Header.vue'
    import CateNodes from '../components/CateNodes.vue'
    import JuiFooter from '../components/Footer.vue'
    import  '@/directives/iscroll';

    export default {
        components: {
            JuiHeader,
            CateNodes,
            JuiFooter
        },
        data(){
            return {
                data: $tplData.category_list,
                activeItem: null,
                city: $tplData.cur_city_info.name,
                scrollOption: {
                    tap: true,
                    mouseWheel: true
                }
            }
        },
        created () {
            this.activeItem = this.data[0];
        }
    }
</script>
