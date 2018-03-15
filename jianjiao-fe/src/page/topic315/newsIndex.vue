<template>
<div class="">
    <div class="news_home">
        <news-head :title="title" :content="new_content" :rule="rule" :isExposure="false"></news-head>
        <div class="list_bg">
            <div class="list" v-for="(item, i) in tplData.list"> 
                <div class="flex" @click="go_detail(item.news_id)">
                    <div class="new_left flex-2">
                        <h3>{{item.news_title}}</h3>
                        <div class="label">
                            <span>
                                {{ item.news_people.slice(0,4) }}
                            </span>
                            <span>
                                {{ item.view }}看过
                            </span>
                            <span>
                                {{item.show_time.slice(5)}}
                            </span>
                            <span>
                                <span v-if="item.type==1" class="news_type common_type">资讯</span>
                                <span v-if="item.type==2" class="raiders_type common_type">攻略</span>
                            </span>
                        </div>
                    </div>
                    <div class="flex-1 right">
                        <img :src="item.imgs[0]">
                    </div>
                </div>
            </div>            
        </div>
    </div>
</div>
</template>


<script type="text/ecmascript-6">
    import JuiHeader from "../../components/Header.vue";
    import newsHead from "./newsHead.vue";
    export default {
        components: {
            JuiHeader,
            newsHead
        },
        data: function () {
            return {
                tplData: $tplData,
                title:'看资讯 兑豪礼',
                new_content:`过去，透过<b>尖椒</b>看教育行业热门事件，了解跑路、欺诈背后的风起云涌；未来，<b>尖椒</b>将为优秀的你提供变得更优秀的途径，健康家庭教育、高效学习方法、优质备考攻略，教育有更远的路要走。`,
                rule:`每点赞、收藏1篇资讯，可赚取<span class="red"> 1 </span>积分；<br/>
                每分享1篇资讯，可赚取<span class="red"> 3 </span>积分。<br/>
                每天最高可赚取<span class="red"> 40 </span> 积分。`
            }
        },
        methods: {
            go_detail: function(id){
                window.location.href = '/activity/newsdetail/'+id;
            }

        },
        created(){

        }
    }

</script>

<style lang="stylus">
body
    background #fff !important
.news_home
    .list_bg
        background #fff
        padding 0px 30px 20px
        .list
            padding 30px 0px
            border-bottom 1px solid #d8d8d8
            .new_left
                h3
                    font-size 30px
                    line-height 40px
                .label
                    margin-top 30px
                    span
                        font-size 25px
                        margin-right 15px
                        color #999
                    .raiders_type
                        color #38d67f
                        border 1px solid #38d67f
                    .news_type
                        color #ea304a
                        border 1px solid #ea304a 
                    .common_type 
                        padding 2px 10px
                        border-radius 10px
                        margin-left 5px
            .right
                margin-left 5px
                img
                    width 100%
                    height 150px
                    display block

</style>
