<template>
<div class="page-evaluation">
    <div class="top-select">
        <el-select v-model="filter.course_id" :no-match-text="$t('evaluation.text.no-match-text')" filterable :placeholder="$t('evaluation.placeholder.select-coursename')" @change="handleValChange" class="w-select">
            <el-option v-for="item in courseList" :key="item.key" :label="item.label" :value="item.key">
            </el-option>
        </el-select>
        <el-select v-model="filter.answer" :placeholder="$t('evaluation.placeholder.select-ifreplay')" @change="handleValChange" class="w-select">
            <el-option v-for="item in replyList" :key="item.id" :label="item.name" :value="item.id">
            </el-option>
        </el-select>
        <el-radio-group v-model="filter.rank" @change="handleValChange" class="w-radio-group">
            <el-radio :label="0">{{$t('evaluation.checkbox.evaluation.all')}}</el-radio>
            <el-radio :label="3">{{$t('evaluation.checkbox.evaluation.good')}}</el-radio>
            <el-radio :label="2">{{$t('evaluation.checkbox.evaluation.medium')}}</el-radio>
            <el-radio :label="1">{{$t('evaluation.checkbox.evaluation.poor')}}</el-radio>
        </el-radio-group>
        <div class="score">{{$t('evaluation.text.evaluation-degree')}}<span>{{praiseDegree}}</span></div>
    </div>
    <div v-if="evaluationListData!=''">
        <ul class="evaList">
            <li class="eva-org" v-for="item in evaluationListData">
                <div class="eva-pane">
                    <div class="eva-img"><img :src="item.user_info.avatar_url"></div>
                    <div class="eva-block">
                        <div class="eva-nickname">{{item.user_info.nick_name}}</div>
                        <div class="stars" :class="item.starStyle"></div>
                        <p class="eva-content">{{item.text_content}}</p>
                        <div class="eva-bottom">
                            <div class="eva-time">{{$t('evaluation.text.evaluation-from')}}<a>{{item.course_name}}</a> <span>{{item.created_at}}</span></div>
                            <div class="eva-reply-btn">
                                <el-button type="text" v-if="item.answer==1" @click="replyEvaluation(item)">{{$t('evaluation.btn.replay')}}</el-button>
                                <el-button type="text" v-if="item.answer==2" @click="modifyReply(item)">{{$t('evaluation.btn.edit-replay')}}</el-button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="eva-reply-block" v-if="item.ifReply">
                    <div class="top-arrow"><span></span></div>
                    <div class="reply-block">
                        <div class="reply-edit" v-if="item.answer==1 || item.modifyFlag == true">
                            <el-form :model="item.ruleForm" :rules="rules" class="demo-ruleForm" :ref="'form'+item.comment_id">
                                <el-form-item prop="textareaReply">
                                    <div class="text-reply">
                                        <el-input type="textarea" v-model="item.ruleForm.textareaReply" :placeholder="$t('evaluation.placeholder.replay-content')" @change="letterLimit(item)" class="w-textarea"></el-input>
                                        <div class="remain">{{item.remnant}} / <span>200</span></div>
                                    </div>
                                </el-form-item>
                                <div class="btn-save-reply">
                                    <el-button type="primary" @click="saveReply(item,'form'+item.comment_id)">{{$t('evaluation.btn.post-replay')}}</el-button>
                                    <el-button @click="cancelReply(item)">{{$t('evaluation.btn.cancel')}}</el-button>
                                </div>
                            </el-form>
                        </div>
                        <div class="reply-msg" v-if="item.answer==2 && item.modifyFlag == false">
                            <p><span>{{$t('evaluation.text.replay-content')}}</span>{{item.answer_info.text}}</p>
                            <div class="reply-mag-time">{{item.answer_info.created_at}}</div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
        <div class="block">
            <el-pagination @current-change="handleCurrentChange" :current-page.sync="filter.page_num" :page-size="10" layout="prev, pager, next" :total="total" class="w-pagination">
            </el-pagination>
        </div>
    </div>
    <p class="nodataTip" v-if="evaluationListData==''">{{$t('evaluation.text.no-data')}}</p>
</div>
</template>
<script>
import Vue from 'vue'
import api from '@/js/api/evaluation.server';
export default {
    data() {
        return {
            courseList: [], //课程名称
            evaluationListData: [],
            praiseDegree: 0,
            total: 0,
            replyList: [{
                id: '0',
                name: this.$t('evaluation.select.ifreplay.all')
            }, {
                id: '1',
                name: this.$t('evaluation.select.ifreplay.no-replay')
            }, {
                id: '2',
                name: this.$t('evaluation.select.ifreplay.already-replay')
            }],
            filter: {
                course_id: '', // 课程 id
                answer: '', // 是否回复
                rank: 0, //评论等级
                page_num: 1,
                page_size: 10
            },
            rules: {
                textareaReply: [{
                    required: true,
                    message: this.$t('evaluation.rules.tip-null'),
                    trigger: 'blur'
                }, {
                    max: 200,
                    message: this.$t('evaluation.rules.tip-size'),
                    trigger: 'blur'
                }]
            }
        };
    },
    mounted() {
        this.getEvaluationList();
        this.getCourseList();
    },
    methods: {
        getEvaluationList() { //评价列表
            api.getEvaluationList(this.filter).then(res => {
                this.praiseDegree = res.praise;
                this.total = res.total;
                if (res.list) {
                    this.evaluationListData = res.list;
                    this.evaluationListData.map(function(item) {
                        Vue.set(item, 'ifReply', false);
                        Vue.set(item, 'modifyFlag', false);
                        Vue.set(item, 'remnant', 0);
                        Vue.set(item, 'ruleForm', {});
                        item.ruleForm.textareaReply = '';
                        item.starStyle = 'star' + item.star;
                    });
                    this.evaluationListData.forEach(function(item) {
                        if (item.answer == 2) {
                            item.ifReply = true;
                        }
                    });
                }
            });
        },
        getCourseList() { // 课程列表
            api.getCourseList().then(res => {
                this.courseList = res.list;
                let defaultAll = {
                    id: 0,
                    image: "",
                    key: 0,
                    label: this.$t('evaluation.label.all-course.label'),
                    name: this.$t('evaluation.label.all-course.name'),
                    price: 0
                };
                this.courseList.unshift(defaultAll);
            })
        },
        replyEvaluation(item) { // 回复
            item.ifReply = true;
            item.ruleForm.textareaReply = '';
            item.remnant = 0;
        },
        modifyReply(item) { // 修改回复
            item.ifReply = true;
            item.modifyFlag = true;
            item.ruleForm.textareaReply = item.answer_info.text;
            item.remnant = item.answer_info.text.length;
        },
        saveReply(item, formid) { //保存回复
            this.$refs[formid][0].validate((valid) => {
                if (valid) {
                    var params = {
                        answer_id: (item.answer_id_temporary || item.answer_info.answer_id) ? (item.answer_id_temporary || item.answer_info.answer_id) : '',
                        comment_id: item.comment_id,
                        answer_text: item.ruleForm.textareaReply
                    };
                    api.saveReply(params).then(res => {
                        if (res) {
                            this.$message({
                                type: 'success',
                                message: this.$t('evaluation.tips.success-reply')
                            });
                            item.answer_id_temporary = res.answer_id;
                            item.answer = 2;
                            item.modifyFlag = false;
                            item.answer_info.text = item.ruleForm.textareaReply;
                        }
                    })
                } else {
                    return false;
                }
            });
        },
        handleCurrentChange(val) {
            this.filter.page_num = val;
            this.getEvaluationList();
        },
        letterLimit(item) {
            item.remnant = item.ruleForm.textareaReply.length;
        },
        cancelReply(item) {
            if (item.answer == 2) {
                item.modifyFlag = false;
            }
            if (item.answer == 1) {
                item.ifReply = false;
            }
        },
        handleValChange() { //
            this.filter.page_num = 1;
            this.getEvaluationList();
        }
    }

};
</script>
<style lang="scss">
$baseWidth: 17px;
$border-color: #d9d9d9;
$background-color: #f5f5f5;
$gray-color: #999999;
.page-evaluation {
    .top-select {
        overflow: hidden;
        .el-select {
            float: left;
            margin-right: 15px;
        }
        .el-radio-group {
            float: left;
            margin-top: 10px;
        }
        .score {
            float: right;
            line-height: 40px;
            span {
                color: #ff1818;
                font-weight: bold;
                font-size: 20px;
                margin-left: 5px;
            }
        }
    }
    .evaList {
        border: 1px solid $border-color;
        border-radius: 4px;
        margin-top: 15px;
        .eva-org {
            padding: 15px;
            border-bottom: 1px solid $border-color;
            &:last-child {
                border: none;
            }
            .eva-pane {
                overflow: hidden;
                .eva-img {
                    width: 60px;
                    float: left;
                    img {
                        width: 60px;
                        height: 60px;
                        border-radius: 60px;
                    }
                }
                .eva-block {
                    width: 910px;
                    float: right;
                    position: relative;
                    overflow: hidden;
                    .stars {
                        width: 86px;
                        height: 12px;
                        background-image: url("../../assets/images/eva-star.png");
                        position: absolute;
                        top: 25px;
                    }
                    .star1 {
                        background-position: -$baseWidth*4 center;
                    }
                    .star2 {
                        background-position: -$baseWidth*3 center;
                    }
                    .star3 {
                        background-position: -$baseWidth*2 center;
                    }
                    .star4 {
                        background-position: -$baseWidth*1 center;
                    }
                    .eva-content {
                        margin-top: 30px;
                        line-height: 24px;
                    }
                    .eva-bottom {
                        overflow: hidden;
                        color: $gray-color;
                        line-height: 30px;
                        .eva-time {
                            float: left;
                            a {
                                color: #268fff;
                                margin-right: 10px;
                            }
                        }
                        .eva-reply-btn {
                            float: right;
                        }
                    }
                }
            }
        }
    }
    .eva-reply-block {
        .el-form-item {
            margin: 0;
        }
        .top-arrow {
            overflow: hidden;
            span {
                float: right;
                width: 0;
                height: 0;
                border-color: $background-color transparent;
                border-width: 0 0 10px 10px;
                border-style: solid;
            }
        }
        .reply-block {
            background-color: $background-color;
            padding: 11px 15px;
            border-radius: 4px 0 4px 4px;
            textarea {
                width: 100%;
                height: 120px;
                padding: 10px;
            }
            .btn-save-reply {
                overflow: hidden;
                margin-top: 10px;
                .el-button {
                    float: right;
                    margin-left: 10px;
                }
            }
            .reply-msg {
                p {
                    line-height: 24px;
                    margin: 0;
                    span {
                        color: $gray-color;
                    }
                }
                .reply-mag-time {
                    text-align: right;
                    color: $gray-color;
                }
            }
        }
        .text-reply {
            position: relative;
            .remain {
                position: absolute;
                right: 10px;
                bottom: 0;
                color: $gray-color;
                font-size: 12px;
                span {
                    color: #ff1818;
                    font-size: 14px;
                }
            }
        }
    }
    .block {
        text-align: center;
        margin: 15px 0;
    }
    .nodataTip {
        color: $gray-color;
        text-align: center;
        line-height: 58px;
        border: 1px solid $border-color;
    }
}
</style>
