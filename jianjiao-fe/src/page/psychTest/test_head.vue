<template>
  <div>
  <jui-header type="back" @goBack="exit_test">
      <span class="text_over">{{jtest_title}}</span>
      <div slot="right">
          <a href="/" class="icon icon-home"></a>
      </div>
  </jui-header>
  </div>
</template>


<style lang="stylus">

</style>



<script>
import Vue from 'vue';
import JuiHeader from '../../components/Header.vue';

export default {
  components: {
      JuiHeader
  },
  name: 'jtest-header',
  props: {
    jtest_title: String
  },

  data() {
    return {
    }
  },
  created() {

  },
  methods: {
    exit_test: function () {
      alert("你确定要退出吗")
    }
     
  }
}
</script>
