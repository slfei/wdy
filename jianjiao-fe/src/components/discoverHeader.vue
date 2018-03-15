<template>
        <header class="header fixed">
            <ul class="menu-inline">
                <a class="menu-inline-item" v-for="(num, i) in otherHeader"
                    :href="num.href"
                    :class="{active: num.cat_name == tplData.news_cat.cat_name}"
                    @click="quickChoose(i)"
                >
                    {{ num.cat_name }}
                </a>
                <a class="menu-inline-item" v-for="(item, i) in tplData.newsCat_all"
                    :href="'/news/discovery?catid=' + item.cat_id "
                    :data-index="i"
                    :data-id="item.cat_id"
                    :class="{active: item.cat_id == tplData.news_cat.cat_id}"
                    @click="quickChoose(i)"
                >
                    {{ item.cat_name }}
                </a>
                <span class="clear-float"></span>
            </ul>
            <div @click="openDropDown" class="btn-drop-down">
                <i :class="{
                    'ion-chevron-down': isDropDownOpen == false,
                    'ion-chevron-up': isDropDownOpen == true
                }"></i>
            </div>
            <ul class="drop-down-menu" :class="{'open': isDropDownOpen== true}">
                <div class="drop-down-menu-item-wrapper">
                
                <a class="drop-down-menu-item" v-for="(num, i) in otherHeader"
                    :href="num.href"
                    :class="{active: num.cat_name == tplData.news_cat.cat_name}"
                    @click="quickChoose(i,true)"
                >
                    {{ num.cat_name }}
                </a>
                    <a class="drop-down-menu-item" v-for="(item, i) in tplData.newsCat_all"
                       :href="'/news/discovery?catid=' + item.cat_id "
                       :data-id="item.cat_id"
                       :data-item="i"
                       :class="{
                        active: item.cat_id == tplData.news_cat.cat_id,
                    }"
                       @click="quickChoose(i, true)"
                    >
                        {{ item.cat_name }}
                    </a>
                </div>
            </ul>
        </header>
</template>

<script>
    function openDropDown() {
        this.isDropDownOpen = !this.isDropDownOpen;
        console.log('toggle');
    }


    function quickChoose(i, needScroll) {
        return;
        var menuInline = document.querySelector('.menu-inline');
        menuInline.querySelector('.active').classList.remove('active');
        var targetElem = menuInline && menuInline.childNodes[i];
        targetElem.classList.add('active');

        var menu = document.querySelector('.drop-down-menu');
        menu.querySelector('.active').classList.remove('active');
        menu && menu.childNodes[i].classList.add('active');

        needScroll && (menuInline.scrollLeft = targetElem.offsetLeft);
    }

    export default {
        name: 'discovery-header',
        data: function () {
            return {
                tplData: $tplData,
                otherHeader:[{catid:0,cat_name:'推荐',href:'/news/recommend'},{catid:8,cat_name:'话题圈子',href:'/circle/home'},{catid:9,cat_name:'心理测试',href:'/quiz/list'}],
                isDropDownOpen: false
            }
        },
        methods: {
            openDropDown,
            quickChoose
        },
        mounted: function () {
            var root = this.$el;
            var menuInline = root.querySelector('.menu-inline');
            var targetElem = menuInline.querySelector('.active');

            menuInline.scrollLeft = targetElem.offsetLeft;
        }
    }

</script>

<style lang="stylus">
    .header
        position relative
        top 0

    .btn-drop-down
        position absolute
        width 90px
        height 90px
        top 0
        right 0
        background #D52C43


    .drop-down-menu
        display none
        padding 40px 0 14px 15px
        position absolute
        top 90px
        background rgba(0,0,0,.85)
        width 100%
        box-sizing border-box
        overflow hidden


        .drop-down-menu-item-wrapper
            margin-right -35px

        &.open
            display block

        .drop-down-menu-item
            font-size 28px
            line-height 55px
            float left
            padding 0 44px
            border 2px solid #fff
            border-radius 30px
            margin-right 44px
            margin-bottom 40px

            &.active
                color #E9314A
                background #fff

            &.no-mr
                margin-right 0
    ul
        list-style none
        margin 0

    .menu
        background #000


    .menu-inline
        overflow hidden
        margin 0
        padding 0 100px 0 10px
        font-size 32px
        white-space nowrap
        overflow-x scroll



        .clear-float
            clear both


        .menu-inline-item
            display inline-block
            padding 0 20px

            &.active
                font-size 36px
                border-top 5px solid transparent
                border-bottom 5px solid #fff
                line-height 82px
</style>
