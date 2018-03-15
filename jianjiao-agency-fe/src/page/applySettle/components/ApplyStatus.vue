<template>
<div class="apply-status text-center">
  <div class="state-image">
    <img src="../../../assets/images/apply-success.png" v-if="status==1">
    <img src="../../../assets/images/apply-fail.png" v-if="status==2">
    <img src="../../../assets/images/apply-inreview.png" v-if="status==0">
  </div>
  <p class="desc">{{ statusMap[status] }}</p>
  <div class="remark" v-if="status == 2">
    <p class="retip">建议您返回上一步修改资料</p>
    <el-button @click="prev">上一步</el-button>
  </div>
  <div class="remark" v-if="status == 1">
    <el-button @click="hrefGo">进入后台管理</el-button>
  </div>



</div>
</template>
<script>
export default {
  props: {
    status: {
      type: Number
    }
  },
  data() {
    return {
      statusMap: {
        0: '您的入驻申请已提交，我们会在3个工作日内完成审核，请耐心等待。',
        1: '恭喜，您已通过平台审核。',
        2: '很遗憾，经过综合考量您未达到本平台入驻标准，审核不通过。',
      }
    }
  },
  methods: {
    prev: function() {
      this.$emit('prev');
    }
  }
}
</script>
<style lang="stylus">
  .apply-status
      width 600px
      margin 0 auto
      .state-image
          img
            width 158px
            height 220px
            margin 20px auto
      .desc
          font-size 16px
      .retip
          color #999999
          margin-bottom 10px
      .remark
          margin-top 20px
          button
              border-color #268fff
          span
              color #268fff
</style>
