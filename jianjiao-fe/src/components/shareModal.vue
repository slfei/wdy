<template>
    <div class="jq-modal">
        <div class="share-modal-content">
            <div class="modal-main">
                <div class="modal-title">{{title}}</div>
                <div class="text-main" v-html="content">
                </div>
            </div>
            <a class="close ion-close-round" @click="hidePanel"></a>
        </div>
    </div>
</template>
<style lang="stylus">
.jq-modal
    position fixed
    z-index 1000
    left 0
    top 0
    width 100%
    height 100%
    background rgba(0, 0, 0, .5)
    opacity 1
    background rgba(0,0,0,0.6)
    text-align center
    .share-modal-content
        display inline-block
        margin-top 50%
        width 670px
        height 200px
        .modal-main
            .modal-title
                background #ea324b
                font-size 32px
                color #ffffff
                height 88px
                line-height 88px
                border-top-left-radius 10px
                border-top-right-radius 10px
            .text-main
                background #fff
                font-size 32px
                font-weight 300
                color #72777d
                text-align center
                line-height 52px
                letter-spacing 1px
                padding 60px 83px
                border-bottom-left-radius 10px
                border-bottom-right-radius 10px
                .red
                    color #ea324b
            .modal-desc
                padding 31px 0
                font-size 32px
                line-height 52px
                span
                    color #ea324b
                    padding 0 .5em
        .close
            display inline-block
            margin-top 22px
            font-size 50px
            color #fff

</style>
<script>
    export default {
        name: 'share-modal',
        props: {
            title:{
                type:String
            },
            panelShow: {
                type: Boolean
            },
            content:{
                type:String
            }
        },
        data:function(){
            return {
            }
        },
        methods: {
            hidePanel:function(){
                this.$emit('hidePanel')
            }
        },
        created(){
            // console.log(this.panelShow,'panelShow')
        }
    }

</script>
