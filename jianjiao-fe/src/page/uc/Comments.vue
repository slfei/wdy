<template>
    <div class="page-comment">

        <jui-header type="back">
            我的点评
        </jui-header>

        <mt-navbar v-model="selected" class="jui-navbar has-header">
            <mt-tab-item id="1">机构点评</mt-tab-item>
            <mt-tab-item id="2">文章评论</mt-tab-item>
        </mt-navbar>

        <!-- tab-container -->
        <mt-tab-container v-model="selected">
            <mt-tab-container-item id="1"
                :class="{'no-bb': tplData.institute.length == 0}"
            >
                <comment-list v-on:showLightbox="showLightbox" type="institute" :list="tplData.institute">
                    <div slot="empty">
                        <i class="icon icon-no-result"></i>
                        <div class="text">
                            暂无点评内容，赶快去点评吧
                        </div>
                    </div>
                </comment-list>
            </mt-tab-container-item>
            <mt-tab-container-item id="2"
                :class="{'no-bb': tplData.news.length == 0}"
            >
                <comment-list type="news" :list="tplData.news">

                    <div slot="empty">
                        <i class="icon icon-no-result"></i>
                        <div class="text">
                            暂无评论内容
                        </div>
                    </div>
                </comment-list>
            </mt-tab-container-item>
        </mt-tab-container>

        <div id="lightbox" :class="{'show' : this.lightboxShow}" v-on:click="hideLightbox($event)">
            <mt-swipe @change="lightboxChange" :auto="0" :show-indicators="false" :continuous="false" id="lightbox-container">
                <mt-swipe-item v-for="item in lightboxImages">
                    <img v-if="typeof item == 'string'" class="lightbox-img" :src=item >
                    <img v-else class="lightbox-img" :src="item.img || item.img_url" >
                </mt-swipe-item>
            </mt-swipe>
            <div class="lightbox-index">{{lightboxIndex + 1}}/{{lightboxImages.length}}</div>
        </div>
    </div>
</template>


<script type="text/ecmascript-6">
    import JuiHeader from '../../components/Header.vue';
    import {NavBar, TabItem, TabContainer, TabContainerItem, Swipe, SwipeItem} from 'mint-ui';
    import CommentList from "../../components/CommentList.vue";
    import utils from "@/js/utils";

    /**
     * 将 nick_name 和 avatar_url 传入 item
     */
    function wrapData($tplData) {
        for(var i = 0, l = $tplData.news.length; i < l; i++){
            $tplData.news[i].nick_name = $tplData.nick_name;
            $tplData.news[i].avatar_url = $tplData.avatar_url;
        }

        for(var i = 0, l = $tplData.institute.length; i < l; i++){
            $tplData.institute[i].nick_name = $tplData.nick_name;
            $tplData.institute[i].avatar_url = $tplData.avatar_url;
        }
    }


    export default {
        components: {
            CommentList,
            JuiHeader,
            NavBar,
            TabItem,
            TabContainer,
            TabContainerItem,
            SwipeItem,
            Swipe
        },
        data: function () {

            wrapData($tplData);
            var target = utils.getParameterByName('target');

            return {
                lightboxImages: [],
                lightboxIndex: 0,
                lightboxShow: false,
                selected:target === 'news' ? "2" : "1",
                tplData: $tplData
            }
        },
        methods: {
            showLightbox: function(images, event) {
                if(document.getElementById("lightbox").style.display == "block") {
                    return;
                }
                let size = event.target.getBoundingClientRect();
                let ele = document.getElementById("lightbox-container");
                ele.style.width = size.width + 'px';
                ele.style.height = size.height + 'px';
                ele.style.top = size.top + 'px';
                ele.style.left = size.left + 'px';
                document.getElementById("lightbox").style.display = "block";
                this.lightboxImages = images;
                this.lightboxIndex = 0;
                let self = this;
                document.body.classList.add('scroll-disabled');
                requestAnimationFrame(function(){
                    self.lightboxShow = true;
                });
            },
            hideLightbox: function(event) {
                this.lightboxShow = false;
                setTimeout(function(){
                    document.body.classList.remove('scroll-disabled');
                    document.getElementById("lightbox").style.display = "none";
                },500);
            },
            lightboxChange(index) {
                this.lightboxIndex = index;
            }
        }
    }
</script>

<style lang="stylus">
    body
        background #fff

    .page-comment
        .mint-tab-container
            background #fff

    #lightbox
        display none
        position fixed
        left 0
        top 0
        width 100%
        height 100%
        z-index 100000
        background-color rgba(0,0,0,0)
        pointer-events none
        transition background-color .5s

        .lightbox-index
            position absolute
            left 0
            bottom 0
            width 100%
            text-align center
            font-size 32px
            line-height 64px
            z-index 233
            color #FFF
            background-color rgba(0,0,0,.8)
            opacity 0
            transition opacity .3s

        .mint-swipe
            position absolute
            left 0
            top 0
            width 100%
            height 100%
            opacity 0
            transition all .3s

            .mint-swipe-items-wrap
                position relative
                overflow hidden
                height 100%

                .mint-swipe-item
                    position absolute
                    transform translateX(-100%)
                    width 100%
                    height 100%
                    display none

                    .lightbox-img
                        width 100%
                        height 100%
                        object-fit contain

                .mint-swipe-item.is-active
                    display block
                    transform none

    #lightbox.show
        pointer-events all
        background-color rgba(0,0,0,.8)
        .lightbox-index
            opacity 1
        .mint-swipe
            opacity 1
            width 100% !important
            height 100% !important
            left 0 !important
            top 0 !important
</style>
