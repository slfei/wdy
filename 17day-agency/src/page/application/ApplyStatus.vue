<template>
<div class="apply-status">
    <i class="status" :class="{
            'fail': status.code == 2,
            'undergoing': status.code == 1,
            'success': status.code == 0
        }"></i>
    <div class="state-image" v-if="env">
        <img v-if="status.code == 0" src="../../assets/images/apply-success-en.png">
        <img v-if="status.code == 2" src="../../assets/images/apply-fail-en.png">
        <img v-if="status.code == 1" src="../../assets/images/apply-inreview-en.png">
    </div>
    <div class="state-image" v-if="!env">
        <img v-if="status.code == 0" src="../../assets/images/apply-success.png">
        <img v-if="status.code == 2" src="../../assets/images/apply-fail.png">
        <img v-if="status.code == 1" src="../../assets/images/apply-inreview.png">
    </div>
    <p class="desc">{{ statusMap[status.code] }}</p>
    <div class="remark" v-if="status.code == 2">
        <div class="reason">{{reason}}</div>
        <p class="retip">{{$t('applicationPerson.tip.backEdit')}}</p>
        <el-button @click="prev">{{$t('common.btn.nextStep')}}</el-button>
    </div>
    <div class="remark" v-if="status.code == 0">
        <el-button @click="hrefGo">{{$t('applicationPerson.btn.hrefGo')}}</el-button>
    </div>
</div>
</template>
<script>
export default {
    props: {
        status: {
            type: Object
        },
        env: {
            type: Boolean
        }
    },
    computed: {
        reason: function() {
            return this.status.reason;
        }
    },
    data() {
        return {
            statusMap: {
                0: this.$t('applicationPerson.status.auditPassed'),
                1: this.$t('applicationPerson.status.auditing'),
                2: this.$t('applicationPerson.status.auditNotPassed'),
            }
        }
    },
    methods: {
        prev: function() {
            this.$emit('prev');
        },
        hrefGo() {
            //后台管理地址
            location.href = "/insitute/index";
        }
    }
}
</script>
