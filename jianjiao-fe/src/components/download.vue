<template>
    <div class="download clearfix" v-if="download">
        <div class="pull-left">
            <div class="clearfix">
                <div class="pull-left">
                    <i class="icon icon-j_app"></i>
                </div>
                <div class="pull-right j-slogn">
                    <h3>尖椒教育点评</h3>
                    <p>最辛辣的教育点评</p>
                </div>
            </div>
        </div>
        <div class="down-href pull-right clearfix">
            <a>下载</a> <i class="ion-close-round"  @click="close()"></i>
        </div>
    </div>
</template>
<style lang="stylus">
    .download
        position fixed
        top 0px
        width 100%
        background #333
        color #fff
        padding 20px 25px
        box-sizing border-box
        font-size 32px
        z-index 9999
        .j-slogn
            margin-left 20px
            h3
                font-size 32px
                margin-top 7px
                margin-bottom 15px
            p
                font-size 22px
        .down-href
            margin-top 25px
            a
                background #e9314a
                padding 8px 25px 
                border-radius 8px
            i
                margin-left 10px
</style>
<script>

    export default {
        name: 'jui-download',
        data(){
            return {
                download: true
            }
        },
        methods: {
            close: function () {
                this.download = false;
            }
        }
    }
</script>
