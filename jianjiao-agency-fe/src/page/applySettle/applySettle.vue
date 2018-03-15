<template>
<div class="apply-main">
  <steps :steps="['1 认领机构', '2 提交资料', '3 入驻审核']" :current="stage"></steps>
  <div class="section-current" v-if="stage===1">
    <institution-list @changeStage="changeStage"></institution-list>
  </div>
  <div class="section-current" v-if="stage===2">
    <claim-form @success="submitSuccess" :ifClaimInfo="ifClaimInfo"></claim-form>
  </div>
  <div class="section-current" v-if="stage===3">
    <apply-status :status="scode" @prev="backStep"></apply-status>
  </div>
</div>
</template>
<script>
import steps from './components/steps.vue'
import institutionList from './components/institutionList.vue'
import claimForm from './components/claimForm.vue'
import ApplyStatus from './components/ApplyStatus.vue'

import api from '@/js/api/applySettle'


export default {
  components: {
    steps,
    institutionList,
    claimForm,
    ApplyStatus
  },
  data() {
    return {
      stage: 1,
      scode: '',
      ifClaimInfo: false
    };
  },
  mounted() {
    this.getStatus();
  },
  methods: {
    changeStage() {
      this.stage = 2;
    },
    backStep() { //返回上一步修改
      this.stage = 2;
      this.ifClaimInfo = true;
    },
    submitSuccess() {
      this.stage = 3;
      this.scode = 0;
    },
    getStatus() { // -2未认领，-1草稿箱 0提交审核，1审核成功，2审核失败
      api.getStatus().then(res => {
        this.scode = res.claim_status;
        this.scode = -1;
        if (this.scode == -2) {
          this.stage = 1;
        } else if (this.scode == -1) {
          this.stage = 2;
        } else if (this.scode == 0) {
          this.stage = 3;
        } else if (this.scode == 1) {
          this.stage = 3;
        } else {
          this.stage = 3;
        }
      })
    }
  }
}
</script>

<style lang="stylus">
.apply-main
    width 840px
    margin 0 auto
</style>
