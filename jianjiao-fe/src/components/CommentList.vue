<template>
    <div>
        <div class="section-list comment-list" v-if="list.length > 0">
            <ul class="comment-item-wrapper clearfix">
                <li :id="'comment-item-id-'+item.comment_id" class="comment-items" v-for="item in list">
                    <img class="cover" :src="item.avatar_url" alt="user">
                    <div class="name">
                        <span v-if="item.nick_name">{{ item.nick_name }}</span>
                        <span v-else>不知名用户</span>
                    </div>
                    <div class="comment clearfix">
                        <p v-html="item.text_content"></p></div>
                    <div class="comment-images clearfix" v-on:click="showLightbox(item.img, $event)">
                        <div class="image-item" v-for="img in item.img"><img :src="img.img_url || img" alt="review">
                        </div>
                    </div>
                    <div class="comment-controls clearfix">
                        <div class="comment-date">{{ item.date }}</div>
                        <div class="comment-like clearfix" :class="{ 'liked': item.is_like === 1 }" @click="toggleLike(item)">
                            <i class="icon icon-thumb clearfix"></i>
                            <span v-if="item.like">{{ item.like }}</span>
                            <span v-else>点赞</span>
                        </div>
                    </div>
                    <a :href="sourceHref + item.object_id" v-if="item.object_name" class="comment-src">
                        {{ (type === 'institute' ? '点评机构' : '评论文章') + '：' + item.object_name }}
                    </a>
                </li>
            </ul>
        </div>
        <div class="no-result" v-else>
            <slot name="empty">
                <div class="icon icon-no-result"></div>
                <div class="text">空空如也</div>
            </slot>
        </div>
    </div>
</template>

<script>
    import api from '../js/api';
    import {Toast} from 'mint-ui';
    
    var env = "browser";
    var userKey = "";
    var nativeBridge;

function setupWebViewJavascriptBridge(callback) {
	if (window.WebViewJavascriptBridge) { return callback(WebViewJavascriptBridge); }
	if (window.WVJBCallbacks) { return window.WVJBCallbacks.push(callback); }
	window.WVJBCallbacks = [callback];
	var WVJBIframe = document.createElement('iframe');
	WVJBIframe.style.display = 'none';
	WVJBIframe.src = 'https://__bridge_loaded__';
	document.documentElement.appendChild(WVJBIframe);
	setTimeout(function() { document.documentElement.removeChild(WVJBIframe) }, 0)
}
    if (!window.isReactNative && !window.isWechat && !window.isOpenWeb) {
        setupWebViewJavascriptBridge(function(bridge) {
            nativeBridge = bridge;
            /* Initialize your app here */
            bridge.callHandler('judgeIsLogin', {'key':'value'}, function responseCallback(responseData) {
                env = "native";
                userKey = responseData
            })
            bridge.registerHandler("updateUserKey", function(userInfo){
                userKey = userInfo
            })
        });
    }


    export default {
        name: 'comment-list',
        components: {},
        props: {
            type: {
                type: String
            },
            id: {
                type: Number
            },
            list: {
                type: Array
            }
        },
        data: function () {
            var sourceHref;
            if (this.type === 'institute') {
                sourceHref = '/institute/detail/';
            } else if (this.type === 'news') {
                sourceHref = '/news/';
            }
            return {
                sourceHref
            }
        },
        methods: {
            showLightbox(img, event) {
                this.$emit('showLightbox', img, event);
            },
            toggleLike(item){
                if(env=="native" && userKey == "(null)") {
                    return this.nativeLogin();
                }

                console.log(item.is_like);
                if (item.is_like === 1) {
                    api.unLike('comment', item.comment_id, userKey).then(function () {
                        item.is_like = 0;
                        item.like--;
                    }, function (err) {
                        Toast(err);
                    });
                } else {
                    api.like('comment', item.comment_id, userKey).then(function () {
                        item.is_like = 1;
                        item.like++;
                    }, function (err) {
                        Toast(err);
                    });
                }
            },
            nativeLogin(){
                nativeBridge.callHandler('loginMethod', function(data){
                    userKey = data;
                })
            }
        }
    }
</script>

<style lang="stylus">
    .comment-list
        .comment-item-wrapper
            background #FFF
            padding 0
            margin 0
            .comment-items
                list-style-type none
                border-bottom solid 1px #F0F0F0
                margin 2px 0
                display block
                padding 24px
                overflow auto
                .cover
                    display block
                    width 60px
                    height 60px
                    border solid 1px #F0F0F0
                    box-sizing border-box
                    border-radius 50%
                    float left
                    margin-right 24px
                .name
                    font-size 28px
                    line-height 60px

                    span
                        display inline-block

                .comment
                    p
                        font-size 32px
                        line-height 48px
                        margin 24px 0
                        word-break break-word
                .comment-images
                    margin -12px
                    margin-bottom 12px
                    overflow auto
                    .image-item
                        width 33.33%
                        width calc(100% / 3)
                        height 160px
                        padding 12px
                        box-sizing border-box
                        float left
                        img
                            width 100%
                            height 100%
                            object-fit cover
                    .image-item:only-child
                        width 50%
                        height 200px
                .comment-controls
                    margin-top 1px
                    .comment-date
                        font-size 24px
                        line-height 44px
                        float left
                        color #7B7B7B

                    .comment-like
                        .icon
                            font-size 24px
                            margin-right 8px
                            vertical-align text-top
                        float right
                        color #000
                        border solid 1px #000
                        margin 2px 1px
                        opacity .3
                        box-sizing border-box
                        font-size 24px
                        height 46px
                        padding 2px 14px 6px
                        border-radius 22px

                        span
                            line-height 46px

                    .comment-like.liked
                        opacity 1
                        color #e9314a
                        border-color #e9314a
                        .icon-thumb:before
                            background #e9314a

                .comment-src
                    margin-top 20px
                    display inline-block
                    font-size 24px
                    color #333
                    background #E6E6E6
                    height 48px
                    line-height 48px
                    padding 0 20px
                    border-radius 24px
                    overflow hidden
                    white-space nowrap
                    text-overflow ellipsis
                    width 100%
                    box-sizing border-box
</style>


