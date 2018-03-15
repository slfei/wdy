<template>
    <div v-if="tplData.title === '关于我们'">
        <jui-header type="back"> {{ tplData.title }} </jui-header>
        <div class="page-about-us has-header">
            <div class="content">
                <span class="icon icon-logo-lg"></span>
                <div class="title">帮您找到更优质的教育机构</div>
                <div class="desc">尖椒{{ version}}</div>
                <a class="desc link rn-hidden" href="https://www.51jianjiao.com/app/about.html">访问尖椒官网</a>
            </div>

            <div class="footer">
                <!--<div class="terms-of-service">-->
                    <!--服务条款-->
                <!--</div>-->
                <div class="desc">
                    copyright © 2017 weichuang.All Rights Reserved.
                </div>
            </div>
        </div>
    </div>
    <div v-else>
        <jui-header type="back">{{ tplData.title }}</jui-header>
        <div class="main-content has-header" v-html="tplData.content">
        </div>
    </div>
</template>


<script type="text/ecmascript-6">
    import JuiHeader from '../../components/Header.vue';

    export default {
        components: {
            JuiHeader
        },
        data: function () {
            return {
                tplData: $tplData,
                version: window.ReactNativeVersion || '1.0'
            }
        }
    }
</script>


<style lang="stylus">
    body {
        background #fff
    }


    .main-content
        margin-top 30px
        padding 30px
        font-size 32px
        line-height 50px
        color #333


    .page-about-us
        .content
            margin-top 135px
            text-align center

            .title
                margin-top 30px
                font-size 36px
                color #333

            .desc
                font-size 28px
                color #999
                margin-top 20px

            .link
                display inline-block
                margin-top 20px
                text-decoration underline


        .footer
            width 100%
            text-align center
            position absolute
            bottom 30px

            .terms-of-service
                color #e9314a

            .desc
                font-size 24px
                color #999

</style>
