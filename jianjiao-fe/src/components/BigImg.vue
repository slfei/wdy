<template>
        <div class="img-view" @click="bigImg">
            <!-- 遮罩层 -->
            <div class="img-layer"></div>
            <div class="img">
                <img :src="imgSrc">
            </div>
        </div>
</template>
<script>
export default {
    props: ['imgSrc'],
    methods: {
        bigImg() {
            // 发送事件
            this.$emit('clickit')
        }
    }
}
</script>
<style lang="stylus">

/* bigimg */

.img-view 
    position relative
    width 100%
    height 100%


/*遮罩层样式*/
.img-view 
    .img-layer 
        position fixed
        z-index 999
        top 0
        left 0
        background rgba(0, 0, 0, 0.9)
        width 100%
        height 100%
        overflow hidden


/*不限制图片大小，实现居*/
.img-view .img img 
    max-width 100%
    display block
    position absolute
    left 0
    right 0
    margin 10% auto
    z-index 1000
</style>
