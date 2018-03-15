<template>
    <div class="bd-row" :class="{'w-100': item.img_count == '0' }">
        <div v-if="item.img_count == '0'">
            <div  class="title" v-html="item.news_title"></div>
            <div class="clearfix text-info">
                <div class="pull-left">{{ item.news_people }}  {{item.created_at}}</div>
                <div class="pull-right">{{ item.views }}看过</div>
            </div>
        </div>


        <div v-else-if="item.img_count == '1'">
            <div class="flex">
                <div class="thumbnail flex-1">
                    <div>
                        <img class="" :src="item.imgs[0]" alt="">
                    </div>
                </div>
                <div class="main flex-2">
                    <div class="title"  v-html="item.news_title"></div>
                    <div class="clearfix text-info">
                        <div class="pull-left">
                        <span v-if="item.news_people.length>4">
                        {{ item.news_people.slice(0,4) }}
                        </span>
                        <span v-else-if="item.news_people.length<=4">
                            {{ item.news_people }}
                        </span>
                         <span>{{item.created_at}}</span></div>
                        <div class="pull-right">{{ item.views }}看过</div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="item.img_count == '3'">
            <div class="title"  v-html="item.news_title"></div>
            <div class="flex img-row">
                <div class="flex-item" :class="{ 'img-center': _i == 1 }" v-for="(_item, _i) in item.imgs">
                    <img :src="_item" alt="">
                </div>
            </div>
            <div class="clearfix text-info">
                <div class="pull-left">{{ item.news_people }} {{item.created_at}}</div>
                <div class="pull-right">{{ item.views }}看过</div>
            </div>
        </div>
    </div>
</template>
<style lang="stylus">

.page-discover
    .bd-row
        width 100%

.bd-row
    border-bottom 1px solid #f0f0f0
    padding 20px 5px 20px 15px
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
        font-size 32px
        line-height 44px
        margin-bottom 18px

    .text-info
        color #999
        font-size 28px
</style>
<script type="text/ecmascript-6">
    export default {
        props: {
            item: {
                required: true,
                type: Object
            }
        }
    }
</script>
