<template>
<div class="w-steps">
  <div class="w-step" v-for="(step, index) in steps" :style="{width: width}" :class="{active: index == current - 1}">
    <div class="title">
      {{ step }}
    </div>
  </div>
</div>
</template>
<script>
export default {
  // name: 'WSteps',
  props: {
    steps: {
      type: Array,
      required: true
    },
    current: {
      type: Number,
      default: 1
    },
    space: {
      type: Number,
      default: 20
    }
  },
  computed: {
    width: function() {
      return this.steps.length ? (1 / this.steps.length * 100).toFixed(6) + '%' : '0%';
    }
  }
}
</script>
<style lang="styl">
.w-steps
    margin 30px 0 30px -10px
    box-sizing border-box
    font-size 14px
    color #999
    height 45px
    line-height 45px
    *
        box-sizing border-box

    .w-step
        padding 0 10px
        float left
        box-sizing border-box

        .title
            position relative
            background #f4f4f4
            padding-left 40px
            text-align center
            &:before
            &:after
                position absolute
                top 0
                right -26px
                z-index 0
                content ' '
                font-size 0
                vertical-align middle
                width 0
                height 0
                border-top 22.5px solid transparent
                border-bottom 22.5px solid transparent
                border-left 26px solid #f4f4f4
                z-index 2
            &:before
                border-left-color #fff
                left 0
                z-index 1
        &:first-child .title
            padding-left 20px
            &:before
                display none

    .active .title
        color #fff
        background #268fff
        &:after
            border-left-color #268fff
</style>
