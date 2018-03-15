<template>
    <div class="bd-row news-item" @click="go_detail(item.news_id)">
        <div v-if="item.img_count == '0'">
            <h3  class="title">{{ item.news_title }}</h3>
            <div class="clearfix text-info">
                <div class="middle-ud">
                    <span>{{ item.news_people }} · {{ item.views }}看过 ·     {{item.created_at.slice(5)}}
                    </span>
                    <span v-if="item.find_type=='news'" class="news_type common_type">资讯</span>
                    <span v-if="item.find_type=='raiders'" class="raiders_type common_type">攻略</span>
                </div>
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
                    <h3 class="title">{{ item.news_title }}</h3>
                    <div class="clearfix text-info">
                        <div class="middle-ud">
                            <span v-if="item.news_people.length>4">
                            {{ item.news_people.slice(0,4) }} · 
                            </span>
                            <span v-else-if="item.news_people.length<=4">
                                {{ item.news_people }} ·  </span>
                             <span>  {{ item.views }}看过 · {{item.created_at.slice(5)}}
                             </span>
                             <span v-if="item.find_type=='news'" class="news_type common_type">资讯</span>
                             <span v-if="item.find_type=='raiders'" class="raiders_type common_type">攻略</span>
                         </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-else-if="item.img_count == '3'">
            <h3 class="title">{{ item.news_title }}</h3>
            <div class="flex img-row">
                <div class="flex-item" :class="{ 'img-center': _i == 1 }" v-for="(_item, _i) in item.imgs">
                    <img :src="_item" alt="">
                </div>
            </div>
            <div class="clearfix text-info">
                <div class="middle-ud">
                    <span>{{ item.news_people }} · {{ item.views }}看过 ·{{item.created_at.slice(5)}}
                    </span>
                    <span v-if="item.find_type=='news'" class="news_type common_type">资讯</span>
                    <span v-if="item.find_type=='raiders'" class="raiders_type common_type">攻略</span>
                </div>
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
        font-weight 500
        line-height 44px
        margin-bottom 18px

    .text-info
        color #999
        font-size 27px
    .common_type 
        padding 6px 9px
        border-radius 10px
        margin-left 10px
    .raiders_type
        color #38d67f
        border 1px solid #38d67f
    .news_type
        color #e9314a
        border 1px solid #e9314a 

</style>
<script type="text/ecmascript-6">
    export default {
        props: {
            item: {
                required: true,
                type: Object
            }
        },
        methods: {
            go_detail: function(id){
                window.location.href = '/news/' + id;

            }
        }
    }
</script>
