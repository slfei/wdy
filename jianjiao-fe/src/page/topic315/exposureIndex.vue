<template>
    <div class="pageIndex">
        <div class="exposure_home">
            <news-head :title="title" :content="new_content" :rule="rule" :isExposure="true" :status="status" :isLogin="isLogin" :exposureId="exposureId"></news-head>
            <div class="list_bg"  v-infinite-scroll="loadMore"  infinite-scroll-disabled="disableLoadMore"
infinite-scroll-distance="40">
                <div class="list"  v-for="(item, i) in exposureList" >
                    <div @click="go_detail(item.id)">
                        <h3>{{item.title}}</h3>
                        <div class="text">
                            {{item.text}}
                        </div>
                        <div class="img">
                             <span v-for="(it, k) in item.imgs">
                                <img :src="it">
                             </span>
                        </div>
                        <div class="label">
                            <span class="">{{item.nick_name}}</span>
                            <span>{{item.view}}看过</span>
                            <span>{{item.created_at}}</span>
                        </div>
                    </div>
                </div>
                <div v-if="loadingMore" class="loadmore">
                    <i class="ion ion-load-a Rotation"></i> 正在加载
                </div>
            </div>
            <a v-if="status==0" class="get_score make_money" @click="expEdit">     
            </a>
        </div>
        <Topic315-login v-model="showLogin"></Topic315-login>
    </div>
</template>


<script type="text/ecmascript-6">
    import JuiHeader from "../../components/Header.vue";
    import newsHead from "./newsHead.vue";
    import api from '@/js/api';
    import Topic315Login from '../../components/Topic315Login.vue';
    import '@/js/topicLogin';
    export default {
        components: {
            JuiHeader,
            newsHead,
            Topic315Login
        },
        data: function () {
            return {
                tplData: $tplData,
                title:'你曝光 我赠礼',
                loadingMore:false,
                status:$tplData.exposure_status,
                isLogin:$tplData.user_info.is_login,
                exposureId:$tplData.exposure_id,
                exposureList:$tplData.list,
                showLogin:false,
                new_content:`据“新华视点”记者不完全统计，2016年，全国仅被曝光的民办教育培训机构卷款跑路案件就有十余起，涉案金额达十几亿元。<br/>
                <p> <br/> </p>
                你是否也是被骗一员？是否退费无门投诉无望？如果你曾有过被骗的痛苦经历，曝光黑心机构，维护净土。`,
                rule:`<p class="red" style="text-align:center">曝光黑心机构得100积分，换大奖！</p>`
            }
        },
        methods: {
            checkLogin: function () {
               if(!this.isLogin){
                    window.addLogin();
                    this.showLogin = true;
                    return false;
               }
               return true;
            },
            expEdit:function(){
               if (this.checkLogin()) {
                    location.href='/activity/saveexposure'
               } 
            },
            go_detail: function(id){
                window.location.href = '/activity/exposuredetail/'+id;

            },
            loadMore: function () {
                this.disableLoadMore = true;
                var $self = this;
                if(this.loadingMore || this.tplData.total <= this.tplData.page_num*this.tplData.page_size){
                    this.disableLoadMore = true;
                }else{
                    this.loadingMore = true;
                    var params = {};
                    params.page_num = ++this.tplData.page_num;
                    api.loadMore('/api/activity/exposurelist',params).then(function (data) {
                        $self.exposureList = $self.exposureList.concat(data.list);
                        $self.disableLoadMore = false;
                        $self.loadingMore = false;
                    }, function (err) {
                        self.disableLoadMore = false;
                        self.loadingMore = false;
                    })
                }

            }

        },
        created(){

        }
    }

</script>

<style lang="stylus">
body
    background #fff !important
.exposure_home
    .list_bg
        background #fff
        padding 0px 30px 20px
        .list
            padding 30px 0px
            border-bottom 1px solid #d8d8d8
            h3
                font-size 30px
                font-weight 500
                line-height 44px
            .text
                color #4a4a4a
                font-size 26px
                line-height 42px
                margin-top 15px
                text-align justify
                word-wrap break-word
            .img
                margin 20px 0
                span
                    img
                        width 212px
                        height 132px
                        margin-right 15px
            .label
                span
                    font-size 26px
                    color #9b9b9b
                    margin-right 23px
                
        .loadmore
            text-align center
            margin 30px 0
            font-size 32px
            color #9b9b9b
            i
                font-size 45px
                position relative
                top 4px

@-webkit-keyframes rotation{
from {-webkit-transform: rotate(0deg);}
to {-webkit-transform: rotate(360deg);}
}

.Rotation{
-webkit-transform: rotate(360deg);
animation: rotation 2s linear infinite;
-moz-animation: rotation 2s linear infinite;
-webkit-animation: rotation 2s linear infinite;
-o-animation: rotation 2s linear infinite;
}
</style>
