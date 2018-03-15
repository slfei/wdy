<template>
    <div class="page-common-comment">

        <jui-header type="back">
            <span v-if="object_type == 1">我要点评</span>
            <span v-else>我要评价</span>
        </jui-header>

        <div class="content has-header">
            <div class="comment-formwrapper">
                <form class="comment-form">
                    <div class="comment-textwrapper">
                        <textarea class="comment-textarea" placeholder="赶紧说点啥吧" rows="6" maxlength="140" v-model="comment_text"></textarea>
                        <div class="comment-lettercount">{{ comment_text.length }}/140</div>
                    </div>

                    <div class="comment-imagewrapper" v-if="object_type == 1">
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
                                    <div class="comment-imagecount">{{ imageCount }}/9</div>
                                </div>
                            </template>

                        </vue-clip>
                    </div>

                    <div class="comment-controls" id="controls" :class="{'finished' : isFinished}">
                        <div class="comment-ratewrapper" v-if="object_type == 1">
                            <h2 class="comment-ratetitle">给机构评个分吧</h2>
                            <ul class="comment-ratelist">
                                <li class="comment-rateitem">
                                    <span class="comment-rate">师资：</span>
                                    <span class="comment-ratestars">
										<i class="icon ion-ios-star" :class="{'active' : eval_0>0}" v-on:click="eval_0=1"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_0>1}" v-on:click="eval_0=2"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_0>2}" v-on:click="eval_0=3"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_0>3}" v-on:click="eval_0=4"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_0>4}" v-on:click="eval_0=5"></i>
									</span>
                                    <span class="comment-rateintro">{{ eval_list[eval_0] }}</span>
                                </li>
                                <li class="comment-rateitem">
                                    <span class="comment-rate">环境：</span>
                                    <span class="comment-ratestars">
										<i class="icon ion-ios-star" :class="{'active' : eval_1>0}" v-on:click="eval_1=1"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_1>1}" v-on:click="eval_1=2"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_1>2}" v-on:click="eval_1=3"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_1>3}" v-on:click="eval_1=4"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_1>4}" v-on:click="eval_1=5"></i>
									</span>
                                    <span class="comment-rateintro">{{ eval_list[eval_1] }}</span>
                                </li>
                                <li class="comment-rateitem">
                                    <span class="comment-rate">服务：</span>
                                    <span class="comment-ratestars">
										<i class="icon ion-ios-star" :class="{'active' : eval_2>0}" v-on:click="eval_2=1"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_2>1}" v-on:click="eval_2=2"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_2>2}" v-on:click="eval_2=3"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_2>3}" v-on:click="eval_2=4"></i>
										<i class="icon ion-ios-star" :class="{'active' : eval_2>4}" v-on:click="eval_2=5"></i>
									</span>
                                    <span class="comment-rateintro">{{ eval_list[eval_2] }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="comment-submit">
                            <button class="comment-button post disabled" id="submit" type="submit" v-on:click="post($event)" v-if="isPosting" :class="{'hide':isFinished}">提交中...</button>
                            <button class="comment-button post" id="submit" type="submit" v-on:click="post($event)" v-else>提交</button>
                        </div>

                        <div class="comment-finish">
                            <div class="comment-thanks"><i class="icon ion-checkmark-circled color-red"></i>感谢评价！您的评价将是其他用户的重要参考哦！</div>
                            <a class="comment-button" type="submit" :href="object_type == 1?'/account/mycomment':'/account/mycomment?target=news'">查看评价</a>
                            <div class="comment-sepline"></div>
                            <h2 class="comment-recommendtitle"><span>这些机构您也可能感兴趣哦</span></h2>
                            <div class="section-list institute-list">
				                <institute-list :data="relevant_institute">
				                    <div slot="empty">
				                        <div class="icon icon-no-result"></div>
				                        <div class="text">尚无相关机构</div>
				                    </div>
				                </institute-list>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</template>

<style lang="stylus">

    body
        background-color #FFF

    body.scroll-disabled
        overflow hidden

    .page-common-comment
        color #333333

    .comment-form
        .comment-textwrapper
            padding 32px
            position relative
            background-color #f0f0f0

            .comment-textarea
                border none
                font-size 28px
                line-height 40px
                height 272px
                width 100%
                padding 16px 20px
                resize none
                box-sizing border-box
                outline-width 0

            .comment-lettercount
                position absolute
                right 52px
                bottom 52px
                color #999
                font-size 24px
                line-height 30px

        .comment-imagewrapper
            background-color #f0f0f0
            overflow auto
            padding 16px
            margin-top -32px
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

        .comment-controls
            background-color #FFF
            height 100vh
            transition transform .5s ease-in

            .comment-ratetitle
                margin 0
                padding 0 32px
                font-size 28px
                font-weight normal
                line-height 84px
                border-bottom solid 1px #F0F0F0

            .comment-ratelist
                padding-top 16px
                li.comment-rateitem
                    padding 0 32px
                    font-size 28px
                    line-height 60px
                    .comment-rate
                        color #999
                        margin-right 6px
                    .comment-ratestars
                        color #999
                        margin-right 6px
                        .icon
                            font-size 32px
                            margin 8px
                            transform scale(1.5)
            .comment-submit
                padding 32px

            .comment-button
                display block
                position relative
                border none
                outline-width 0
                width 100%
                height 88px
                font-size 28px
                line-height 88px
                background-color #e9314a
                border-radius 44px
                color #FFF

            .comment-button.disabled
                opacity .6
                pointer-events none

            .comment-button.disabled.hide
                opacity 0

            .comment-finish
                text-align center
                opacity 0
                transition opacity .5s ease-in
                .comment-thanks
                    font-size 28px
                    line-height 48px
                    padding-bottom 24px
                    .icon
                        margin-right 12px
                        transform scale(1.5)
                .comment-button
                    display inline-block
                    font-size 24px
                    line-height 56px
                    height 56px
                    border-radius 28px
                    width 160px
                .comment-sepline
                    margin-top 36px
                    height 10px
                    background-color #F0F0F0
                .comment-recommendtitle
                    position relative
                    margin 0
                    padding 0 32px
                    font-size 28px
                    font-weight normal
                    line-height 84px
                    color #999
                    span
                        position relative
                        padding 0 16px
                        background-color #FFF
                .comment-recommendtitle:before
                    content ''
                    position absolute
                    left 32px
                    right 32px
                    top 41px
                    width auto
                    border-bottom solid 1px #999

    .comment-controls.finished
        .comment-finish
            opacity 1

    .color-red
        color #e9314a

    .color-green
        color #3cc382

    .color-orange
        color #ffa759

    .color-grey
        color #999

    .color-white
        color #FFF

    .icon.ft
        margin-left 10px

    .ion-ios-star.active
        color #fea758

    .middle
        text-align center

    .no-border
        border none

    .no-wrap
        white-space nowrap
        text-overflow ellipsis
        overflow hidden
        font-size initial

</style>

<script type="text/ecmascript-6">
    import Vue from 'vue';
    import JuiHeader from '../../components/Header.vue';
    import InstituteList from '@/components/InstituteList.vue'
    import api from '../../js/api';
    import { Toast } from 'mint-ui';
    import utils from '../../js/utils';
    import VueClip from 'vue-clip'

    Vue.use(VueClip)
    Vue.component(Toast.name, Toast);

    export default {
        components: {
            JuiHeader,
            InstituteList
        },
        data(){
            return {
                tplData: $tplData,
                options: {
                    url: '/api/universal/uploadimage',
                    paramName: 'image',
                    maxFilesize: {
                        limit: 4,
                        message: '图片大小不能大于{{ maxFilesize }}MB！'
                    },
                    maxFiles: {
                        limit: 9,
                        message: '图片总数不能大于9张图片！'
                    },
                    acceptedFiles: {
                        extensions: ['image/*'],
                        message: '只允许上传图片！'
                    },
                    parallelUploads: 3
                },
                object_type: 1,
                object_id: 0,
                comment_text: '',
                images: [],
                imageCount: 0,
                eval_0:5,
                eval_1:5,
                eval_2:5,
                eval_list:['','很不满意','不满意','一般吧','满意','很满意'],
                isFinished: false,
                isPosting: false,
                relevant_institute: []
            }
        },
        created () {
            this.object_type = this.tplData.object_type;
            this.object_id = this.tplData.object_id;
        },
        methods: {
            addedFile (file) {
                file.addAttribute('id', this.imageId);
                file.addAttribute('status', 'waiting');
                file.addAttribute('url', '');
                if(this.imageCount > 9) {
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
                        //Toast('网络错误！');
                        Toast(res.status+', '+res.msg);
                        file.customAttributes.status = 'failed';
                    } else {
                        file.customAttributes.status = 'finished';
                        file.customAttributes.url = res.data.url || '';
                    }
                } else {
                    Toast('网络错误！');
                    file.customAttributes.status = 'failed';
                }
                this.$forceUpdate();
            },
            maxFilesReached (file) {
                this.removeImage(file);
                Toast('您最多只能上传9张图片！');
            },
            removeImage (file) {
                this.$refs.vc.removeFile(file);
                file.customAttributes.status = 'removed';
                this.imageCount -= 1;
            },
            post: function(event) {
                if (event) {
                    event.preventDefault();
                }
                if (this.comment_text.length == 0) {
                    Toast('请输入评论信息！');
                    return;
                }
                let data;
                if(this.object_type == 1) {
                    data = {
                        object_id:this.object_id,
                        type:this.object_type,
                        text_content:this.comment_text,
                        teacher_eval:this.eval_0*2,
                        env_eval:this.eval_1*2,
                        service_eval:this.eval_2*2,
                        img_list:[]
                    };
                    for(let i = 0; i < this.images.length; i += 1) {
                        if(this.images[i].customAttributes.status == 'sending') {
                            Toast('您有图片正在上传，请等待上传结束！');
                            return;
                        } else if(this.images[i].customAttributes.status == 'failed') {
                            this.removeImage(this.images[i]);
                        } else if(this.images[i].customAttributes.status == 'finished') {
                            data.img_list.push(this.images[i].customAttributes.url);
                        }
                    }
                } else {
                    data = {
                        object_id:this.object_id,
                        type:this.object_type,
                        text_content:this.comment_text
                    };
                }
                this.isPosting = true;
                let self = this;
                api.postNewComment(this.object_type, this.object_id, data)
                    .then(function (data) {
                        console.log(data)
                        self.isFinished = true;
                        let top = document.getElementById('submit').getBoundingClientRect().top;
                        self.relevant_institute = data.relevant_institute;
                        document.getElementById('controls').style.transform = 'translateY(-'+top+'px)';
                        document.body.classList.add('scroll-disabled');
                    }, function (err) {
                        self.isPosting = false;
                        Toast(err);
                    });
            }
        }
    }
</script>
