<template>
<div class="page-appliciton">
    <div class="content-area">

        <w-steps :steps="[$t('applicationPerson.step.step1'), $t('applicationPerson.step.step2'), $t('applicationPerson.step.step3')]" :current="stage"></w-steps>

        <div class="section-current" v-if="stage==1">
            <entrence-protocol :env="ifEnlishVersion"></entrence-protocol>
            <div class="agreement-opr">
                <el-checkbox v-model="agreeProtocol">{{$t('applicationPerson.text.checkboxLabel')}}</el-checkbox>
            </div>
        </div>

        <div class="section-current" v-if="stage==2">
            <person-form @success="checkApplyRecord" :init-data="instituteData" :env="ifEnlishVersion"></person-form>
        </div>

        <div class="section-current" v-if="stage==3">
            <apply-status :status="applyStatus" :env="ifEnlishVersion" @prev="prev"></apply-status>
        </div>

        <div class="text-center operation-bar">
            <el-button type="primary" v-if="stage == 1" style="margin-top: 12px;" @click="doAgreement()" :disabled="!agreeProtocol">
                {{$t('common.btn.nextStep')}}
            </el-button>
        </div>

    </div>
</div>
</template>
<script>
import PersonForm from "./PersonalForm"
import EntrenceProtocol from "./Protocol"
import ApplyStatus from './ApplyStatus'
import WSteps from '@/components/steps/steps'
import mixin from './mixin';

export default {
    mixins: [mixin],

    components: {
        PersonForm,
        EntrenceProtocol,
        ApplyStatus,
        WSteps
    },
    computed: {
        ifEnlishVersion() {
            return (window.LOCALE == 'en');
        }
    },
    data() {
        return {
            type: 'personal',
            stage: 0,
            agreeProtocol: true,
            applyStatus: {
                reason: ''
            },
            instituteData: {} //initData
        };
    }
}
</script>

<style lang="stylus">
.page-appliciton
    .content-area
        padding 40px 0
        width 840px
        margin auto

    .agreement-opr
        border 1px solid #d9d9d9
        border-top none
        height 35px
        line-height 35px
        padding 0 20px
        color #333

        .el-checkbox__label
            font-size 12px

    .operation-bar
        margin-top 40px
    .w-steps
        margin-bottom 30px
    .apply-status
        width 600px
        margin 0 auto
        text-align center
        font-size 14px

    .state-image
        img
        width 158px
        height 220px
        display block
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
