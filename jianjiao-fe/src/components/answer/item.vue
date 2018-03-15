<template>
    <div class="answer-item">
        <div class="answer-user clearfix">
            <div class="pull-left">
                <div class="pull-left">
                    <img class="avatar" :src="data.user_info.avatar_file">
                </div>
                <div class="pull-left name" :class="{'one-line': !data.user_info.signature}">
                    <div class="user-name">{{ data.user_info.user_name }}</div>
                    <div class="user-signature nowrap" v-if="data.user_info.signature">{{ data.user_info.signature }}</div>
                </div>
            </div>

            <!--<div class="pull-right right">
                <a class="focus-btn btn-with-icon">
                    <i class="ion-android-add"></i>
                    关注
                </a>
            </div>-->
        </div>
        <div class="answer-content">
            <div class="rich-text" v-html="data.answer_content"></div>
        </div>
        <div class="ft">
            <span class="time">
                {{ data.add_time}}
            </span>
            <div class="pull-right">
                <a class="agree-count btn-with-icon" :class="{active : agreeStatus == 1}" @click="agree">
                    <i class="icon-thumb"></i>
                    {{ agreeCount }}
                </a>
                <a class="against-count btn-with-icon" :class="{active: agreeStatus == -1}" @click="against">
                    <i class="icon-thumb-down"></i>
                    {{ againstCount }}
                </a>
            </div>
        </div>
    </div>
</template>
<style>
    .answer-item {
        background: #fff;
        margin-top: 12px;
    }

    .answer-item .icon-thumb {
        vertical-align: middle;
    }
    .answer-item .answer-user {
        border-bottom: 1px solid #f0f0f0;
        padding: 20px 30px;
    }
    .answer-item .answer-user .right {
        line-height: 78px;
    }
    .answer-item .avatar {
        width: 78px;
        height: 78px;
        border-radius: 50%;
        margin-right: 10px;
        border: 1px solid #f5f5f5;
    }
    .answer-item .one-line .user-name {
        margin-top: 20px;
    }
    .answer-item .name {
        line-height: 38px;
    }
    .answer-item .user-signature {
        color: #999;
        max-width: 6rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .answer-item .btn-with-icon {
        display: inline-block;
        border: 1px solid #e9314a;
        color: #e9314a;
    }
    .answer-item .against-count,
    .answer-item .agree-count {
        padding: 0 30px;
        height: 46px;
        border-radius: 23px;
        line-height: 44px;
        color: #4e4e4e;
        border-color: #4e4e4e;
    }
    .answer-item .agree-count {
        margin-right: 17px;
    }

    .answer-item .against-count.active,
    .answer-item .agree-count.active{
        border: 1px solid #e9314a;
        color: #e9314a;
    }
    .answer-item .focus-btn {
        height: 58px;
        line-height: 56px;
        border-radius: 29px;
        padding: 0 40px;
    }
    .answer-item .answer-content {
        padding: 30px 30px 0;
        font-size: 28px;
        line-height: 1.8;
    }
    .answer-item .ft {
        padding: 40px 30px;
        color: #999;
        font-size: 24px;
    }

    .answer-item .ft .time{
        position: relative;
        top: 4px;
    }

    .agree-count i, .against-count i {
        position: relative;
        top: 10px;
    }

    .agree-count i:before{
        background: #4e4e4e;
    } 
    .against-count i:before {
        background: #4e4e4e;
    }
</style>
<script type="text/ecmascript-6">
    import api from '@/js/api';

    export default {
        props: {
            data: {
                required: true,
                type: Object
            }
        },
        data(){
            return {
                agreeStatus: 0,
                agreeCount: 0,
                againstCount: 0
            }
        },

        created () {
            this._setStatus();
        },

        watch: {
            'data': '_setStatus'
        },

        methods: {
            agree() {
                api.voteAnswer(this.data.answer_id, 1).then( () => {
                    switch(this.agreeStatus) {
                        case 0:
                            this.agreeCount += 1;
                            this.agreeStatus = 1;
                            break;
                        case -1:
                            this.agreeCount += 1;
                            this.againstCount -= 1;
                            this.agreeStatus = 1;
                            break;
                        case 1:
                            this.agreeCount -= 1;
                            this.agreeStatus = 0;
                    }
                });
            },

            against() {
                api.voteAnswer(this.data.answer_id, -1).then(() => {
                    switch(this.agreeStatus) {
                        case 0:
                            this.againstCount += 1;
                            this.agreeStatus = -1;
                            break;
                        case 1:
                            this.againstCount += 1;
                            this.agreeCount -= 1;
                            this.agreeStatus = -1;
                            break;
                        case -1:
                            this.agreeStatus = 0;
                            this.againstCount -= 1;

                    }
                })
            },
            _setStatus () {
                this.agreeStatus = +this.data.agree_status; // 0 未操作 1 赞过 -1 踩过
                this.agreeCount = this.data.agree_count;
                this.againstCount = this.data.against_count;
            }
        }
    }
</script>
