<template>
    <div class="page-collections">
        <jui-header type="back">
            我的收藏
        </jui-header>
        <div class="mycollection clearfix">
            <div class="mytab-switch clearfix" >
                    <a v-for="(item, i) in collect_title" class="base-tab" :class="{'active': item.is_active}" @click="tab_click(i)">
                        {{item.name}}
                    </a>
            </div>
            <div class="tab-contents clearfix">
                <div v-if="institutes" class="clearfix">
                    <institute-list :data="tplData.list" :operable="true">
                        <div slot="empty">
                            <i class="icon icon-no-result"></i>
                            <div class="text">
                                暂无收藏机构
                            </div>
                        </div>
                    </institute-list>
                </div>
                <div class="full-width clearfix" v-if="news">
                    <jui-showcase :data="news_list" :operable="true">
                        <div slot="empty">
                            <i class="icon icon-no-result"></i>
                            <div class="text">
                                暂无收藏新闻
                            </div>
                        </div>
                    </jui-showcase>
                </div>
                <div v-if="questions" class="border-top clearfix">
                    <jui-topic :data="circle_hot_question" :showlabel='true' :operable="true">
                        <div slot="empty">
                            <i class="icon icon-no-result"></i>
                            <div class="text">
                                暂无收藏话题
                            </div>
                        </div>
                    </jui-topic>
                </div>
            </div>
        </div>
    </div>
</template>


<script type="text/ecmascript-6">
    import JuiHeader from '../../components/Header.vue';
    import InstituteList from '../../components/InstituteList.vue';
    import JuiShowcase from '../../components/Showcase.vue';
    import JuiTopic from '../../components/TopicCircle.vue';
    import { NavBar, TabContainer, TabContainerItem } from 'mint-ui';
    import api from '../../js/api';
    import utils from '@/js/utils';
    import {Toast} from 'mint-ui';
    export default {
        components: {
            JuiHeader,
            InstituteList,
            JuiShowcase,
            JuiTopic,
            NavBar,
            TabContainer,
            TabContainerItem,
            Toast
        },
        data: function () {
            return {
                tplData: $tplData,
                selected: '1',
                collect_title:[{name:'机构',is_active:true},{name:'文章',is_active:false},{name:'问题',is_active:false}],
                institutes:true,
                news:false,
                questions:false,
                news_list:[],
                circle_hot_question:[]
            }
        },
        methods: {
            tab_click:function(no){
                let this_ = this;
                console.log(no);
                console.log(this.collect_title)
                switch (no) {
                    case 0:
                        this.institutes = true;
                        this.news = false;
                        this.questions = false;
                        break;
                    case 1:
                        this_.institutes = false;
                        this_.questions = false;
                        api.getMycollect('news').then(function (res) {
                            console.log(res,'news')
                            this_.news_list = res.list;
                            this_.news = true;
                        }, function (err) {
                            Toast(err);
                        });
                        break;
                    case 2:
                        this_.institutes = false;
                        this_.news = false;
                        api.getMycollect('question').then(function (res) {
                            this_.circle_hot_question = res.list;
                            this_.questions = true;
                        }, function (err) {
                            Toast(err);
                        });
                        break;
                }
                for(let i=0;i<this.collect_title.length;i++){
                    if (i==no) {
                        this.collect_title[i].is_active = true;
                    }
                    else{
                        this.collect_title[i].is_active = false;
                    }
                }
            },
        }
    }

</script>


<style lang="stylus">

    body
        background #fff
        .mycollection
            margin-top 96px
            .full-width
                width 100%
            .mytab-switch
                // border-bottom 2px solid #f5f5f5
                a
                    display inline-block
                    font-size 28px
                    color #999
                    padding 30px 96.7px
                    // border-bottom 2px solid #e3e3e3
                .active
                    border-bottom 4px solid #e9314a
                    color #e9314a
            .tab-contents
                width 100%
                .border-top
                    border-top 1px solid #f0f0f0
            .topic-li
                border-bottom none
</style>
