<template>
    <div class="prize clearfix pageIndex">
        <div class="winning-list">
            <div class="ueser clearfix">
                <div class="pull-left score">
                    <span class="score-detail">{{tplData.branch}}</span>
                    <span class="score-desc">您当前积分</span>
                </div>
                <div class="pull-left winning-detail">
                    <a href="javascript:void(0)" @click="userPrizeVisible=true">我的奖品</a>
                </div>
            </div>
            <a href="/activity/index" class="get-score">积分不够？快去赚积分！Go >></a>
            <div class="ranking-title">积分排行榜</div>
            <ul class="ranking-list">
                <li class="ranking-user" v-for="(item, index) in rankingList">
                    <span class="number" v-if="index==0">
                        <img src="/build/img/topic315/prize_list/icon_first@2x.png"></img>
                    </span>
                    <span class="number" v-if="index!=0">{{index+1}}</span>
                    <span class="name">{{item.nick_name}}</span>
                    <span class="user-score">{{item.branch}}</span>
                </li>
            </ul>
        </div>
        <ul class="prize-list">
            <li class="prize-item" v-for="(item, index) in prizeList">
                <img :src="item.cover" alt="item.cover">
                <div class="center">
                    <div class="title">{{item.name}}</div>
                    <div class="branch">所需积分{{item.branch}}分</div>
                    <div class="left_num">剩余{{item.left_num}}份</div>
                    <div class="tag" v-if="index==0">注：积分排名第一名可兑换</div>
                </div>
                <a href="javascript:void(0)" class="action pointer-events-none" v-if="item.exchange==1">已兑换</a>
                <a href="javascript:void(0)" class="action pointer-events-none" v-else-if="item.exchange==2">已兑完</a>
                <a href="javascript:void(0)" class="action" @click="go_redeem(item)" v-else>兑换</a>
            </li>
        </ul>
        <!--todo：兑换规则-->
        <div class="rules">
            <a href="javascript:void(0)" class="toggle-rules" @click="rulesVisible=true">兑奖规则</a>
        </div>
        <div class="jq-modal user-prize-list" v-show="userPrizeVisible">
            <div class="modal-content">
                <div class="modal-content-main">
                    <div class="modal-title">我的奖品</div>
                    <ul class="user-prize">
                        <li v-for="item in userPrizeList" v-if="item.is_exchange && userPrizeList">{{item.name}}</li>
                        <li class="no-data" v-if="!userPrizeList.length">无</li>
                    </ul>
                </div>
                <a href="javascript:void(0)" class="close ion-close-round" @click="userPrizeVisible=false"></a>
            </div>
        </div>
        <div class="jq-modal rules-detail" v-show="rulesVisible">
            <div class="modal-content">
                <div class="modal-content-main">
                    <div class="modal-title rules-title">兑奖规则</div>
                    <div class="text">
                        1.兑换时间：活动期间内，积分达到兑换标准即可随时兑换; <br>
                        2.积分兑换方式：当积分达到兑换标准时，您可在我的积分页面“积分兑换”专区申请积分兑换，将及时抵扣积分并生成兑换订单; <br>
                        3.本次活动未兑换的积分，截止积分兑换日结束即清零（即2018年3月30日24：00积分清零）; <br>
                        4.活动结束前，累计积分最高者，将获得5000元现金大奖。每一种奖品，每个用户只能兑换1次，同一用户最多可兑换2次奖品; <br>
                        5.所有兑换奖品数量有限，兑完为止。 <br>
                    </div>
                </div>
                <a href="javascript:void(0)" class="close ion-close-round" @click="rulesVisible=false"></a>
            </div>
        </div>

        <Topic315-login v-model="showLogin"></Topic315-login>
    </div>

</template>
<script type="text/ecmascript-6">

    import api from '@/js/api';
    import {Popup, Toast, MessageBox} from 'mint-ui';
    import rnMixin from '../../js/rn_login';
    import Topic315Login from '../../components/Topic315Login.vue';
    export default {
        mixins: [rnMixin],
        components: {
            Topic315Login
        },
        data: function () {
            return {
                tplData: $tplData,
                prizeList: $tplData.list,
                rankingList: $tplData.ranking,
                isLogin: $tplData.user_info.is_login,
                userPrizeList: [],
                userPrizeVisible: false,
                rulesVisible: false,
                showLogin: false,

            }
        },
        methods: {
            go_redeem: function (item) {
                if(!this.isLogin){
                    addLogin()
                    this.showLogin = true;
                }else{
                    var status = false;
                    api.redeemScore({prize_id: item.id}).then(function(suc){
                        MessageBox.confirm(`您是否确认使用${item.branch}积分兑换</br>${item.name}`).then( action => {
                            if(action=='confirm') {
                                api.redeem({prize_id: item.id}).then(function(suc){
                                    Toast('兑换成功');
                                    // location.reload();
                                    $tplData.branch -= item.branch;
                                    item.left_num--;
                                    item.exchange = 1
                                },function (err) {
                                    Toast(err);
                                })
                            }
                        })
                    },function (err) {
                        Toast(err);
                    })
                    /*MessageBox.confirm(`您是否确认使用${item.branch}积分兑换</br>${item.name}`).then( action => {
                        if(action=='confirm') {
                            api.redeem({prize_id: item.id}).then(function(suc){
                                Toast('兑换成功');
                                // location.reload();
                                $tplData.branch -= item.branch;
                                item.left_num--;
                                item.exchange = 1
                            },function (err) {
                                Toast(err);
                            })
                        }
                    })*/
                }
            }
        },
        created() {
            // this.userPrizeList = this.prizeList.map( prize => prize.is_exchange == 1 && prize)
            this.prizeList.map( prize => prize.is_exchange == 1 && this.userPrizeList.push(prize))
        }
    }

</script>
<style lang="stylus" type="text/stylus">
    *{
        box-sizing border-box
    }
    .prize
        background #FEEEC1
        .winning-list
            width 690px
            margin 30px auto
            background url(/build/img/topic315/prize_list/box2@2x.png) no-repeat
            background-size 100%
            height 508px
            text-align center
            color #fff
            .ueser
                padding-top 40px
                .score, .winning-detail
                    width 50%

                    .score-detail
                        font-size 48px
                        display block
                    .score-desc
                        display block
                        font-size 26px
                        padding-top 12px
                .winning-detail
                    a
                        margin-top 8px
                        display inline-block
                        width: 196px;
                        height 64px
                        line-height 64px
                        border-radius 32px
                        border: 2px solid #c4edff;
                        font-size 32px
            .get-score
                display inline-block
                margin-top 24px
                height 60px
                line-height 60px
                /*color #fff*/
                font-size 26px
            .ranking-title
                margin-top 36px
                margin-bottom 29px
                height 48px
                line-height 51px
                padding-left 70px
                font-size: 26px;
                color: #b66c2e;
                font-weight bold
                text-align left
            .ranking-list
                color #666
                font-size: 26px;
                font-weight bold
                li
                    display flex
                    height 37px
                    line-height 37px
                    margin-bottom 19px
                    .number
                        width 138px
                        img
                            width 26px
                            height 34px
                    .name
                        width 202px
                        flex 1
                        text-align left
                        padding-left 20px
                    .user-score
                        width 310px

        .prize-list
            width 690px
            margin 0 auto 30px auto
            .prize-item
                display flex
                margin-bottom 28px
                background #fff
                padding 35px 0
                img
                    width 208px
                    height 128px
                    padding 0 20px
                .center
                    width 243px
                    flex 1em
                    .title
                        margin 10px
                        margin-left 0
                        height 45px
                        line-height 45px
                        font-size: 32px;
                        color: #333333;
                    .branch, .left_num
                        line-height 37px
                        font-size: 26px;
                        color: #666666;
                    .tag
                        font-size: 22px;
                        color: #ea324b;
                        margin-top 19px
                .action
                    margin-top 55px
                    margin-right 20px
                    background: #ea324b;
                    width: 150px;
                    height: 72px;
                    line-height 72px
                    border-radius: 36px;
                    text-align center
                    font-size: 32px;
                    color: #ffffff;
                .pointer-events-none
                    pointer-events none
                    background: #cccccc;

    /*模态框样式抽离*/

    .jq-modal
        position: fixed;
        z-index 1000
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background rgba(0, 0, 0, .5)
        opacity: 1;
        background: rgba(0, 0, 0, 0.6);
        text-align center
        .modal-content
            display inline-block
            margin-top 50%
            width 670px
            height 200px
            .modal-content-main
                background #fff
                border-radius 10px
                padding-bottom 44px
                .modal-title
                    border-top-left-radius 10px
                    border-top-right-radius 10px
                    height 88px
                    line-height 88px
                    background #ea324b
                    font-size: 32px;
                    color: #ffffff;
            .close
                display inline-block
                margin-top 22px
                font-size 50px
                color #fff
    .user-prize-list
        .user-prize
            text-align left
            margin 0 auto
            padding: 30px 0
            width 300px
            font-size: 32px;
            color: #333333;
            li
                height 45px
                line-height 45px
                margin-bottom 9px
            .no-data
                text-align center
    .rules
        .toggle-rules
            position absolute
            top 19px
            right 0
            z-index 10
            background url(/build/img/topic315/prize_list/tittle2@2x.png) no-repeat
            background-size 100%
            width 178px
            height 48px
            line-height 48px
            font-size:26px;
            color:#b66c2e;
            padding-left 58px
    .rules-detail
        .modal-content
            margin-top 20%
        .modal-content-main
            /*height 800px*/
            overflow-y:scroll
        .text
            margin-top 88px
            text-align left
            font-size 26px
            line-height 39px
            padding 30px 40px
.rules-title
    position fixed
    z-index 1001
    width 670px
</style>
