<template>
    <div :class="'comment-' + type">

        <div class="comment-background" v-if="editMode" @click="exitEditMode"></div>
        <div class="widget-comment-bar flex" :class="{'edit-mode': editMode == true }">
            <!--<span @click="goBack" class="backward">-->
                <!--<i class="ion-ios-arrow-back"></i>-->
            <!--</span>-->
            <div class="leave-comment flex-1">
                <!--

                <textarea
                    @click="enterEditMode"
                    class="comment-input" name="" id="" cols="" rows="" placeholder="说点啥...">
                </textarea>
                -->

                <a :href="'/comment/post/' + ( type === 'institute' ? '1' : '2')
                    + '/' + id"
                   class="btn btn-primary btn-block btn-leave-comment" @click="checkLogin($event)">说点啥...</a>


                <!--<div class="btn btn-primary submit-comment" v-if="editMode">-->
                    <!--发表-->
                <!--</div>-->
            </div>
            <div class="operation-panel" :class="{'no-share-icon': noShareIcon}">
                <span class="comment-num" v-if="type === 'news' && comment_num > 0">{{ comment_num }}</span>
                <a href="#comment-hook"
                   v-if="type === 'news'"
                   class="icon icon-msg"
                ></a>
                <i :class="{
                        'icon-pentagram': collection === 0,
                        'icon-pentagram_ac': collection === 1,
                        'last': noShareIcon
                    }" class="icon" @click="toggleCollection"></i>
                <i class="icon icon-share last icon" @click="toggleShare"
                    v-if="!noShareIcon"
                ></i>
            </div>

            <mt-popup
                v-if="!noShareIcon"
                v-model="shareMode"
                popup-transition="popup-fade">
                <!-- hide for function -->
                <share :config="shareConfig"></share>

                <div class="share-container">
                    <div class="flex-1" @click="share('sina')">
                        <div class="icon-wrapper">
                            <span class="icon icon-sina"></span>
                        </div>
                        <div>
                            分享到微博
                        </div>
                    </div>
                    <div class="flex-1" @click="share('qzone')">
                        <div class="icon-wrapper">
                            <span class="icon icon-qzone"></span>
                        </div>
                        <div>
                            分享到空间
                        </div>
                    </div>
                    <span class="icon icon-close" @click="toggleShare"></span>
                </div>
            </mt-popup>

            <div v-else class="v-modal"  v-show="shareMode" @click="toggleShare">
                <span class="wechat-share-guide" alt=""></span>
            </div>
        </div>

    </div>

</template>

<style lang="stylus">

    .comment-background
        background rgba(0, 0, 0, .7)
        position fixed
        width 100%
        bottom 0
        top 0


    .widget-comment-bar
        .v-modal
            opacity 1
            background rgba(0, 0, 0, .6)

        .btn-primary
            background #e6e6e6
            color #999
            text-align left
            padding 0 20px
            border-radius 50px

        z-index 2
        border-top 1px solid #ccc
        background #fff
        position fixed
        bottom 0
        height 100px
        line-height 100px
        color #ccc


        i, .backward, .ion-ios-chatboxes-outline
            font-size 60px

        .mint-popup
            width 540px
            height 280px
            background #fff
            border-radius 20px

        .mint-popup
            width 540px
            height 280px
            background #fff

        .ion-ios-star
            color #FFA759

        .btn-leave-comment
            margin-top 18px
            margin-left 20px
            line-height 65px
            height 65px


            .comment-input
                background #fff
                width 100%
                box-sizing border-box
                border 1px solid #ccc
                height 65px
                line-height 65px
                font-size 24px
                border-radius 33px
                margin-top 20px
                padding 0 11px

            ::-webkit-input-placeholder
                font-size 24px


        .backward
            width 80px
            text-align center


        .operation-panel
            width 300px
            text-align right
            position relative

            .comment-num
                position absolute
                background #E9314A
                color #fff
                border-radius 20px
                line-height 30px
                padding 0 10px
                left 60px
                top 12px

            .icon
                margin-right 50px

            .last
                margin-right 20px
        .operation-panel
            a,i
                padding 2px
    .edit-mode
        height 320px
        top 0

        .backward,.operation-panel
            display none

        .leave-comment
            padding 16px 14px

            .comment-input
                border-radius 5px
                height 165px
                color #999
                font-size 28px
                line-height 44px


            .submit-comment
                background #E9314A
                color #fff
                font-size 28px
                line-height 60px
                height 60px
                padding 0 55px
                border-radius 30px
                display inline-block
                float right
                position relative
                top -10px

    .comment-institute
        .operation-panel
            width 200px
            &.no-share-icon
                width 85px


    .comment-news
        .operation-panel.no-share-icon
             width 200px
    .share-container
        font-size 28px
        color #333
        text-align center

        .icon-close
            margin-top 30px


        .flex-1
            float left
            width 50%

        .icon-wrapper
            display inline-block
            width 120px
            height 120px
            border-radius 60px
            border 1px solid #ccc
            margin-top 56px


    .share-component
        position: absolute
        z-index: -100
        top: -10000px
</style>

<script type="text/ecmascript-6">

    import api from '../js/api';
    import { Toast, Popup } from 'mint-ui';
    import Share from 'vue-social-share';
    import "vue-social-share/dist/client.css";
    import rnMixin from '../js/rn_login';

    function toggleCollection() {
        var self = this;

        if(this.collection === 1){
            console.log(this.typeid)
            api.removeCollection(this.typeid, this.id).then(function () {
                Toast('取消收藏');
                self.collection = 0;
            }, function (err) {
                Toast(err);
            })
        }else{
            api.addCollection(this.typeid, this.id).then(function (data) {
                self.collection = 1;
                Toast({
                    message: '收藏成功'
                });
            }, function (err) {
                Toast(err);
            });
        }
    }


    function enterEditMode(){
        this.editMode = true;
        document.scrollingElement.classList.add('modal-open');
    }

    function exitEditMode() {
        this.editMode = false;
        document.scrollingElement.classList.remove('modal-open');
    }

    function toggleShare() {
        if (window.isReactNative) {
            window.postMessage(JSON.stringify({
                action: 'share',
                data: Object.assign({
                    desc: this.shareConfig.description || getMetaContentByName('description') || '',
                    title: this.shareConfig.title || getMetaContentByName('title') || document.title,
                    link: this.shareConfig.url || location.href,
                    pic: this.shareConfig.image || ''
                })
            }));
        } else {
            this.shareMode = !this.shareMode;

        }
    }


    function share(type) {
        var className;
        if(type=='sina'){
            className = 'icon-weibo';
        }else{
            className = 'icon-qzone';
        }
        var evt = document.createEvent("MouseEvents");
        evt.initEvent("click", false, false);// 或用initMouseEvent()，不过需要更多参数
        document.querySelector('.share-component .' + className).dispatchEvent(evt);
    }


    export default {
        name: 'comment-bar',
        mixins: [rnMixin],
        props: {
            'type': {
                type: String,
                required: true
            },
            'id': {
                type: Number,
                required: true
            }
        },
        components: {
            MtPopup: Popup,
            Share
        },
        methods: {
            getIsCollect() {
                api.isCollect({
                    typeid: this.typeid,
                    objectid:this.id
                }).then(data => {
                    // console.log(data)
                    if (data.collection===1) {
                        this.collection = 1 
                    }

                });
            },

            goBack: function () {
                history.go(-1);
            },

            checkLogin (e) {
                if (!this.checkRNLogin()) {
                    e.preventDefault();
                }
            },
            enterEditMode,
            exitEditMode,
            toggleCollection,
            toggleShare,
            share
        },

        created() {
          this.getIsCollect()
        },

        data: function () {
            var type;
            var current_href = window.location.href;
            if (current_href.indexOf('news')>0) {
                type = 2
            }
            else{
                type = 1
            }

            return {
                editMode: false,
                collection: 0,
                typeid: type,
                comment_num: $tplData.comment_num,
                shareMode: false,
                noShareIcon: window.isWechat || String(window.ReactNativeVersion) < '1.0.1',
                shareConfig: this.type == 'institute' ? {
                    sites: ['weibo', 'qzone'],
                    title: $tplData.institute_name + '_尖椒',
                    image: $tplData.cover_pic
                } : {
                    sites: ['weibo', 'qzone'],
                    title: $tplData.news_title + '_尖椒'
                }
            }
        }
    }

    function getMetaContentByName(name) {
        return (document.getElementsByName(name)[0] || 0).content;
    }
</script>
