<template>
    <div class="page-feedback">
        <jui-header type="back">意见反馈</jui-header>
        <div class="main-feedback has-header">
            <div class="title">问题类型</div>
            <div class="ques-type">
                <div class="btn" :class="{'btn-primary': type === 1}" @click="setType(1)">功能建议</div>
                <div class="btn" :class="{'btn-primary': type === 2}" @click="setType(2)">Bug</div>
            </div>

            <div class="title">问题内容</div>
            <textarea class="feedback-input"
                      v-model="text"
                      placeholder="您的建议是我们最好的支持哦"></textarea>

            <div class="title">问题相关图片</div>
            <div class="comment-imagewrapper">
              <vue-clip ref="vc" :options="options" :on-added-file="addedFile" :on-sending="sending" :on-complete="complete" :on-max-files="maxFilesReached">

                <template slot="clip-uploader-body" scope="props">
                  <div class="comment-imageitem" :class="{'waiting' : file.customAttributes.status == 'waiting', 'sending' : file.customAttributes.status == 'sending','failed' : file.customAttributes.status == 'failed','finished' : file.customAttributes.status == 'finished'}" v-if="file.customAttributes.status != 'removed'" v-for="file in props.files">
                    <img v-bind:src="file.dataUrl" />
                    <div class="removeButton" v-on:click="removeImage(file)">✕</div>
                  </div>
                </template>

                <template slot="clip-uploader-action">
                    <div class="comment-imageitem dz-message">
                        <i class="icon ion-plus-round"></i>
                        <div class="comment-imagecount">{{ imageCount }}/3</div>
                    </div>
                </template>

              </vue-clip>
            </div>





            <div class="btn btn-block btn-large btn-primary" @click="sendFeedBack">提交</div>
        </div>

    </div>
</template>


<style lang="stylus">
    .main-feedback
        .title
            margin-top 20px

        .btn-large
            margin-top 30px

        padding 30px

        .ques-type
            margin-bottom 24px
            .btn
                margin-right 30px


        .feedback-input
            box-sizing border-box
            width 100%
            padding 20px
            height 440px
            font-size 28px
            color #999
            border none

        ::-webkit-input-placeholder
            font-size 28px
            color #999


    .title
        font-size 28px
        color #333
        margin-bottom 22px

    .comment-imagewrapper
        background-color #f0f0f0
        overflow auto
        padding 16px
        margin -30px
        margin-bottom -24px
        box-sizing border-box
        .comment-imageitem.waiting:after
            content '等待上传'
        .comment-imageitem.sending:after
            content '上传中'
        .comment-imageitem.failed:after
            content '上传错误'
        .comment-imageitem.waiting
            background #000
            img
                opacity .5
        .comment-imageitem.sending
            background #000
            img
                opacity .5
        .comment-imageitem.failed
            background #000
            img
                opacity .5
        .comment-imageitem:after
            position absolute
            display block
            pointer-events none
            content ''
            top 0
            left 0
            width 100%
            text-align center
            font-size 28px
            color #FFF
            font-weight bold
            line-height 160px
            line-height calc(33vw - 42px)
        .comment-imageitem
            float left
            position relative
            width 160px
            width calc(33vw - 42px)
            height 160px
            height calc(33vw - 42px)
            margin 16px
            background-color #FFF
            text-align center
            .removeButton
                position absolute
                width 64px
                height 64px
                top 0
                right 0
                line-height 64px
                font-size 48px
                text-align center
                font-weight bold
                color #FFF
                background rgba(0,0,0,.8)
            .icon
                color #999
                font-size 64px
                line-height 160px
                line-height calc(33vw - 42px)
                pointer-events none
            img
                width 100%
                height 100%
                object-fit cover
            .comment-imagecount
                position absolute
                right 16px
                bottom 8px
                color #999
                font-size 24px
                line-height 30px
                pointer-events none



</style>


<script type="text/ecmascript-6">
    import Vue from 'vue';
    import JuiHeader from '../../components/Header.vue';
    import api from '../../js/api';
    import {Toast} from 'mint-ui';
    import VueClip from 'vue-clip'

    Vue.use(VueClip)

    export default {
        components: {
            JuiHeader
        },
        data: function () {
            return {
                type: 1,
                text: '',
                images: [],
                imageCount: 0,
                options: {
                    url: '/api/universal/uploadimage',
                    paramName: 'image',
                    maxFilesize: {
                        limit: 4,
                        message: '图片大小不能大于{{ maxFilesize }}MB！'
                    },
                    maxFiles: {
                        limit: 3,
                        message: '图片总数不能大于3张图片！'
                    },
                    acceptedFiles: {
                        extensions: ['image/*'],
                        message: '只允许上传图片！'
                    },
                    parallelUploads: 3
                }
            }
        },
        methods: {
            setType: function (val) {
                this.type = val;
            },
            addedFile (file) {
                file.addAttribute('id', this.imageId);
                file.addAttribute('status', 'waiting');
                file.addAttribute('url', '');
                if(this.imageCount > 3) {
                    return;
                } else if (!file.type.startsWith('image')) {
                    this.imageCount += 1;
                    file.addAttribute('status', 'failed');
                    Toast('只允许上传图片！');
                } else if (file.size > 4096000) {
                    this.imageCount += 1;
                    Toast('图片大小不能大于4MB！');
                } else {
                    this.imageCount += 1;
                    this.images.push(file);
                }
            },
            sending (file, xhr, formData) {
                file.customAttributes.status = 'sending';
            },
            complete (file, status, xhr) {
                if(xhr && xhr.response) {
                    let res = JSON.parse(xhr.response);
                    if(res.status != 200) {
                        Toast('网络错误！');
                        file.customAttributes.status = 'failed';
                    } else {
                        file.customAttributes.status = 'finished';
                        file.customAttributes.url = res.data.url || '';
                    }
                } else {
                    file.customAttributes.status !== 'removed' && Toast('网络错误！');
                    file.customAttributes.status = 'failed';
                }
                this.$forceUpdate();
            },
            maxFilesReached (file) {
                this.removeImage(file);
                Toast('您最多只能上传3张图片！');
            },
            removeImage (file) {
                this.$refs.vc.removeFile(file);
                file.customAttributes.status = 'removed';
                this.imageCount -= 1;
                this.$forceUpdate();
            },
            sendFeedBack: function () {
                if(!this.text || this.text.length < 10){
                    return Toast('意见内容必须大于10个字');
                }
                let images = [];
                for(let i = 0; i < this.images.length; i += 1) {
                    if(this.images[i].customAttributes.status == 'sending') {
                        Toast('您有图片正在上传，请等待上传结束！');
                        return;
                    } else if(this.images[i].customAttributes.status == 'failed') {
                        this.removeImage(this.images[i]);
                    } else if(this.images[i].customAttributes.status == 'finished') {
                        images.push(this.images[i].customAttributes.url);
                    }
                }

                api.sendFeedback(this.type, this.text, images).then(function () {
                    Toast('反馈成功');
                    setTimeout(function () {
                        if (window.isReactNative) {
                            window.postMessage(JSON.stringify({
                                action: 'goBack',
                                data: {}
                            }));
                        } else {
                            history.go(-1);
                        }
                    }, 1000)
                }, function (err) {
                    Toast(err)
                })
            }
        }
    }
</script>
