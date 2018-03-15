<template>
    <div>
        <jui-header type="back">
            <span class="text_over">{{tplData.title}}</span>
            <div slot="right">
                <a href="/" class="icon icon-home"></a>
            </div>
        </jui-header>
        <big-img v-if="showImg" @clickit="viewImg" :imgSrc="imgSrc"></big-img>
        <div v-if="test_show" class="test_detail_start has-header">
            <div class="start_bg">
                <div class="detail_img">
                    <img :src="tplData.cover_pic">
                </div>
                <div class="detail_descr">
                    <div v-html="tplData.description"></div>
                    <section>{{tplData.total_test}}人测过</section>
                </div>
            </div>
            <div>
                <div class="btn btn-block btn-test start_test" @click="start">开始测试</div>
            </div>
        </div>
        <div v-else class="test_subject test_detail_start has-header">
            <div v-for="(item,i) in tplData.section">
                <div  v-if="i===subject_count">
                    <p class="subj_count test-subject-image"><span class="count_test">{{i + 1}}/{{total_length}}</span>
                    </p>
                    <div class="per_test">
                        <div class="subj_img" v-for="(img_i,j) in item.cover_pic">
                            <img :src='img_i' @click="clickImg($event)">
                        </div>
                        <div class="subj_title">{{item.title}}</div>
                        <div v-if="item.option_type==='radio'" class="select_option">
                            <div class="select_item" v-for="(perm,j) in item.option"><label class="update_radio"><input 
                                type="radio" v-model="radio_score"
                                :value="perm.score" @click="radio_change(i,item.id, $event)"><i>✓</i>
                                {{perm.title}}</label>
                            </div>
                        </div>
                    </div>
                    <div class="operate_btn">
                        <span class="pull-left" v-if="i!==0">
                            <a @click="pre_subject">上一题</a>
                        </span>
                    </div>
                    <div :class="{'next_disabled': radio_score===''}" v-if="i===total_length-1"
                         class="btn btn-block btn-test start_test" @click="commit_final">提交
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="stylus">

    .text_over
        display block
        float left
        width 450px
        word-break keep-all
        white-space nowrap
        overflow hidden
        text-overflow ellipsis
        padding-left 30px

    .start_bg
        background #fff
        margin 60px 30px 50px

    .is-react-native .start_bg
    .is-open-web .start_bg
        margin-top 50px

    .detail_descr
        font-family 'HiraginoSansGB-W3'
        width 90%
        font-size 30px
        color #333333
        line-height 50px
        padding 0 0 10px
        margin 30px auto
        section
            font-size 27px
            color #999999
            text-align center
            margin 30px 0

    .next_disabled
        pointer-events none
        opacity 0.4

    .detail_img
        width 100%
        img
            width 100%
            height 100%

    .start_test,
    .next_test
        position fixed
        width 83%
        bottom 14px
        left 4%
        right 4%
        color #fff
        font-size 34px

    .next_test
        bottom 170px

    .test_subject
        font-size 32px
    .is-react-native
    .is-open-web
        .test_subject
            margin-top 0

    .per_test
        padding 20px
        margin 25px
        background #fff
        border-radius 5px

    .subj_count
        text-align center
        margin none

    .count_test
        display inline-block
        color #E9314A
        background #fff
        padding 14px 30px
        margin-top 27px
        border-radius 7px

    .subj_title
        color #333333
        padding 20px
        line-height 48px
        border-bottom 1px dashed #ccc

    .subj_img
        width 40%
        margin 0 auto
        img
            width 100%
            height 100%

    .update_radio
        line-height 48px
        i
            font-style normal
            display inline-block
            width 29px
            height 29px
            text-align center
            line-height 29px
            color #fff
            vertical-align middle
            margin -2px 2px 4px 0px
            border #ffc14a 3px solid

    .select_item, .select_option, .select_checkbox
        padding 10px
        color #333333
        font-size 30px
        font-weight 300
        font-family 'HiraginoSansGB-W3'
        line-height 34px
        margin-bottom 25px
        input[type="radio"], input[type="checkbox"]
            opacity 0
            cursor pointer
            padding-bottom 3px
        input[type="radio"] + i
            border-radius 100%
            padding 2px
        input[type="checkbox"] + i
            border-radius 7px
        input[type="radio"]:checked + i, input[type="checkbox"]:checked + i
            background #ffc14a

    .operate_btn
        text-align center
        margin 30px
        a
            color #ffc14a


</style>

<script type="text/ecmascript-6">
    import Vue from 'vue';
    import JuiHeader from '../../components/Header.vue';
    import BigImg from '../../components/BigImg.vue';
    import api from '../../js/api';
    import utils from '@/js/utils';
    export default {
        components: {
            JuiHeader,
            BigImg
        },
        data(){
            return {
                tplData: $tplData,
                test_show: true,
                total_length: $tplData.section.length,
                subject_count: Number,
                radio_score: '',
                subject_obj: [],
                commit_count: 0,
                showImg: false,
                imgSrc: '',
                is_transtion_true:true,
            }
        },
        methods: {
            clickImg(e) {
                this.showImg = true;
                // 获取当前图片地址
                this.imgSrc = e.currentTarget.src;
            },
            viewImg(){
                this.showImg = false;
            },
            start: function () {
                this.test_show = !this.test_show;
                this.subject_count = 0;
            },
            findElem(arrayToSearch, attr, val){
                for (var i = 0; i < arrayToSearch.length; i++) {
                    if (arrayToSearch[i][attr] === val) {
                        return i;
                    }
                }
                return -1;
            },
            radio_change: function (index, sub_id, e) {
                console.log(this.subject_obj)
                var self=this;  
                this.is_transtion_true = true
                var optValue = e.target.value
                var index_no = this.findElem(this.subject_obj, "subject_id", sub_id)
                if (index_no === -1) {
                    this.subject_obj.push({subject_id: sub_id, subject_score: optValue})
                }
                else {
                    this.subject_obj.splice(index_no, 1, {subject_id: sub_id, subject_score: optValue})
                }
                if (this.subject_count + 1 < this.total_length) {
                    setTimeout(function(){
                        self.subject_count = ++self.subject_count;
                        if (self.subject_obj.length < self.subject_count + 1) {//初始情况未添加所有题目的选项
                            self.radio_score = ''//将radio_score 置为空
                        }
                        else {//为了记住之前选过的每道题的选项
                            self.radio_score = self.subject_obj[self.subject_count].subject_score
                        }
                     },150)
                }
            },
            pre_subject: function () {
                this.is_transtion_true = false
                this.subject_count = --this.subject_count
                this.radio_score = this.subject_obj[this.subject_count].subject_score
            },
            commit_final: function () {
                var submit_paramas = {
                    title_id: this.tplData.id,
                    subject_obj: this.subject_obj
                }
                if (this.tplData.is_login !== 0) {
                    api.submit_test_data(this.tplData.id, this.subject_obj).then(function (res) {
                        utils.test_result_detail(submit_paramas.title_id);
                    }, function (err) {
                        // body...
                    })
                }
                else {
                    try {
                        localStorage.test_paramas = JSON.stringify(submit_paramas)
                        console.log(localStorage.test_paramas)
                    } catch (e) {
                        this.$cookies.set("test_paramas", JSON.stringify(submit_paramas), "1d")
                        console.log(this.$cookies.get("test_paramas"))
                    }
                    utils.login_page(submit_paramas);

                }
            }
        },
    }
</script>
