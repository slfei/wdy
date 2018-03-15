<template>
<div class="institute-header-wrap">
    <div class="institute-header main-container clearfix">
        <div class="info pull-left">
            <div class="logo">
                <a href="javascript:;">
                        <img :src="info.logo" class="logo-img" alt=""></img>
                    </a>
            </div>
            <div class="title">
                <h4 class="institute-name">{{ info.show_name }}</h4>
                <div class="category">
                    {{$t('nav.mainCategory')}}： {{ insTypes[info.category] }}
                </div>
            </div>
        </div>
       <!--  <div class="notice pull-right">
            <div class="hd">
                <div @click="loadData(0)" :class="['today-live',blue == true ? '' : 'blue']"><span>{{$t('notification.todayWork')}}</span><span class="red">({{count[0]}})</span></div>|
                <div @click="loadData(1)" :class="['today-notice',blue == true ? 'blue' : '']"><span>{{$t('notification.notice')}}</span><span class="red">({{count[1]}})</span></div>
            </div>
            <div class="bd">
                <div v-for="item in notices" v-if="blue">
                    <router-link :to="'/notification/' + item.id" class="item">
                        <div class="title">{{ item.title }}</div>
                        <span class="time">{{ item.time }}</span>
                    </router-link>
                </div>
                <div v-for="item in notices" v-if="!blue">
                    <div class="nowlive">{{ item.content }}</div>
                </div>
                <div v-show="!Datalength" class="nodata">{{$t('common.btn.noData')}}</div>
            </div>
            <div class="ft" v-show="Datalength">
                <router-link to="/notification" v-show="blue == true">{{$t('common.btn.more')}}</router-link>
                <router-link to="/liveNotification" v-show="blue == false">{{$t('common.btn.more')}}</router-link>
            </div>
        </div> -->
    </div>

    <div class="nav-bar">
        <ul class="main-container">
            <router-link tag="li" to="/course/">
                <a>{{ $t('nav.courseManage')}}</a>
            </router-link>
            <router-link tag="li" to="/marketing/">
                <a>{{ $t('nav.marketingManage') }}</a>
            </router-link>
            <router-link tag="li" to="/finance/">
                <a>{{ $t('nav.finacialManage') }}</a>
            </router-link>
            <router-link tag="li" to="/account/">
                <a>{{ $t('nav.accountManage') }}</a>
            </router-link>
        </ul>
    </div>

</div>
</template>
<script>
import * as api from '@/js/api';

var accountType = 'institute';
if (window.USER_INFO) {
    accountType = window.USER_INFO.enter_tyep || accountType;
}
export default {
    data() {
        return {
            accountType: accountType,
            info: {

            },
            insTypes: {},
            notices: [],
            blue: true,
            Datalength: '',
            count: [0, 0],
        }
    },
    created() {
        this.loadData(1);
        this.loadData(0);
        this.getInfo().then(() => console.log(this.info));
        this.getInsType();
    },
    methods: {
        getInfo() {
            var map = {
                per_show_name: 'show_name',
                ins_show_name: 'show_name',
                personal_logo: 'logo',
                logo: 'logo',
                ins_type: 'category',
                person_type: 'category'
            };

            function tanslateKey(obj, map) {
                var ret = {};
                Object.keys(map).forEach((key) => {
                    if (obj[key]) {
                        ret[map[key]] = obj[key];
                    }
                });
                return ret;
            }
            if (this.accountType) {
                return api.institute.getInstituteInfo().then(res => this.info = tanslateKey(res.data.data, map));
            } else {
                return api.personal.getPersonalInfo().then(res => this.info = tanslateKey(res.data.data, map));
            }
        },
        loadData(type){
            if(type){
                api.notification.list({page_size: 3}).then((data)=>{
                    this.blue = true;
                    this.notices = data.data;
                    this.Datalength = data.total;
                    this.count[1] = data.total;
                });
            } else {
                api.notification.livelist({page_size: 3}).then((data)=>{
                    this.blue = false;
                    this.notices = data.data;
                    this.Datalength = data.data.length;
                    this.count[0] = data.data.length;
                });
            }
        },
        getInsType () {
            api.institute.getInsType().then(res => this.insTypes = res);
        }
    }
}
</script>
<style lang="styl">
    .institute-header-wrap
        background #f5f5f5
    .institute-header
        padding 40px 0
        .logo, .title
            vertical-align middle
            display inline-block
        .title
            margin-left 16px
            font-size 14px
        .institute-name
            font-size 20px
            font-weight bold
            margin-bottom 20px
        .category
            color #999
        .logo-img
            width 168px
            height 168px
            border-radius 4px
        .notice
            width 360px
            background #fff
            border-radius 4px
            max-height 168px
            .hd

            .bd
                padding 0 12px
                line-height 28px
                font-size 12px
                overflow hidden
                .title
                    max-width 260px
                    text-overflow ellipsis
                    white-space nowrap
                    overflow hidden
                    margin 0
                    font-size 12px
                .nowlive
                    max-width 336px
                .time
                    color #999
                .nodata
                    margin-top 20px
                    text-align center
                    background url('../assets/images/nodata.png') no-repeat
                    background-position center top
                    padding-top 70px
                    color #a7a7a7
                    background-size 113px;
                    height 100px

            .ft
                hegiht 34px
                line-height 33px
                padding 0 12px

            .hd
                border-bottom 1px solid #f5f5f5
                text-align center
                font-size 14px
                .today-live,.today-notice
                    cursor pointer
                    width 163px
                    display inline-block
                    span:first-of-type
                        background-position left center
                        padding-left 18px
                    .red
                        margin-left 5px
                        color red
                .today-live
                    span:first-of-type
                        background url('../assets/images/notice01.png') no-repeat
                .today-notice
                    span:first-of-type
                        background url('../assets/images/notice02.png') no-repeat

                .blue
                    color #268fff


            .ft
                text-align center
                border-top 1px solid #f5f5f5
                a
                    color #268fff

    .nav-bar
        height 54px
        background #268fff
        line-height 54px
        overflow hidden
        li
            display inline-block
            width 135px
            text-align center
        .router-link-active
            background #1977db
        a
            display block
            color #fff
            font-size 14px

</style>
