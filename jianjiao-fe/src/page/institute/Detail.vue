<template>
    <div class="page-institute-detail">
        <jui-header type="back" forceBackUrl="/">
            机构详情
            <div slot="right">
                <a href="/" class="icon icon-home"></a>
            </div>
        </jui-header>
        <nav class="navbar has-header" role="navigation" :class="{'show' : this.scrolled}">
            <ul class="nav nav-menu">
                <li><a href="#info" :class="{'active' : this.location == 'info'}" v-on:click="scrollView('info', $event)">简介</a></li>
                <li><a href="#review" :class="{'active' : this.location == 'review'}" v-on:click="scrollView('review', $event)">评价</a></li>
                <li><a href="#intro" :class="{'active' : this.location == 'teacher'}" v-on:click="scrollView('teacher', $event)">详情</a></li>
                <li><a href="#recommend" :class="{'active' : this.location == 'recommend'}" v-on:click="scrollView('recommend', $event)">推荐</a></li>
            </ul>
        </nav>

        <div class="content has-header has-footer">
            <div class="section institute-info" id="info">
                <div class="section-col institute-maininfo">
                    <div class="img-cover" v-on:click="showLightbox(tplData.env_img_list, $event)">
                        <img class="cover" :src="tplData.env_img_list ?tplData.env_img_list[0].img:''" alt="institute">
                        <div class="img-text"><span>环境图册</span><br><span>({{ tplData.env_img_num }})</span></div>
                    </div>
                    <div class="title"><span>{{ tplData.institute_name }}</span></div>
                    <div class="subtitle" v-if="tplData.is_authorized"><span class="shield color-orange"><i class="icon icon-shield hd"></i></span><span class="label-verified">认证</span></div>
                    <div class="score color-red"><span>{{ tplData.rank }}分</span></div>
                    <div class="float-right subscore"><span>师资:{{ tplData.teacher_eval }}</span><span>环境:{{ tplData.env_eval }}</span><span>服务:{{ tplData.service_eval }}</span></div>
                </div>
                <div class="section-col institute-quantity">
                    <div class="quantity-item middle">
                        <div class="item-label">老师</div>
                        <div class="item-count color-red">{{ tplData.teacher_num }}</div>
                    </div>
                    <div class="quantity-item middle">
                        <div class="item-label">课程</div>
                        <div class="item-count color-red">{{ tplData.course_num }}</div>
                    </div>
                    <div class="quantity-item middle">
                        <div class="item-label">评论</div>
                        <div class="item-count color-red">{{ tplData.comment_num }}</div>
                    </div>
                </div>
                <div class="section-col institute-detail">
                    <div class="detail-item half"><span class="label">开办：</span><span>{{ tplData.found_time || '暂无' }}</span></div>
                    <div class="detail-item half"><span class="label">类型：</span><span>{{ tplData.institute_type || '暂无' }}</span></div>
                    <div class="detail-item half"><span class="label">形式：</span><span>{{ tplData.institute_course_type || '暂无' }}</span></div>
                    <div class="detail-item half"><span class="label">适龄：</span><span>{{ tplData.age_range || '暂无' }}</span></div>
                    <div class="detail-item"><span class="label">特色：</span><span>{{ tplData.characteristic || '暂无' }}</span></div>
                    <div class="detail-item"><span class="label">科目：</span><span>{{ tplData.course_desc || '暂无' }}</span></div>
                </div>
                <div class="section-hd">

                    <a :href="'/institute/address/'+tplData.campus_address_id + '?lat=' + tplData.lat + '&lon=' + tplData.lon"
                       class="full">
                        <div class="hd-name no-wrap"><i class="icon ion-ios-location-outline color-red hd"></i>{{ tplData.address }}</div>
                        <div class="hd-more"><i class="icon ion-ios-arrow-right ft"></i></div>
                    </a>
                </div>
                <div class="section-hd no-border" >
                    <a  v-on:click="selectMoblie(tplData.phone_number)" class="full">
                        <div class="hd-name no-wrap phone"><i class="icon ion-ios-telephone-outline color-green hd"></i>{{ tplData.phone_number }}</div>
                        <div class="hd-more">免费咨询<i class="icon ion-ios-arrow-right ft"></i></div>
                    </a>
                </div>
            </div>
            <mt-popup
              v-model="popupVisible"
              position="bottom"
              modal=false>
              <div class="showBlock">
              <div class="showMoblie" v-for="data1 in moblieArrs">
                 <a :href="'tel:'+data1"> {{data1}}</a>
              </div>
              </div>
              <div class="cancel" @click="close">取消</div>
            </mt-popup>

            <div id="review"></div>
            <div class="section institute-reviews mt" v-if="tplData.comment_list && tplData.comment_list.length > 0">
                <div class="section-hd">
                    <a :href="'/institute/review/'+tplData.institute_id" class="full">
                        <div class="hd-name no-wrap">评论({{ tplData.comment_num }})</div>
                        <div class="hd-more"><i class="icon ion-ios-arrow-right ft"></i></div>
                    </a>
                </div>

                <CommentList type="institute" v-on:showLightbox="showLightbox" :id="tplData.institute_id" :list="tplData.comment_list"></CommentList>

            </div>

            <div id="teacher"></div>
            <div class="section institute-teachers mt" v-if="tplData.teacher_list && tplData.teacher_list.length > 0">
                <div class="section-hd">
                    <a :href="'/institute/teacher/'+tplData.institute_id" class="full">
                        <div class="hd-name no-wrap">老师</div>
                        <div class="hd-more">共{{ tplData.teacher_list_num }}位老师<i class="icon ion-ios-arrow-right ft"></i></div>
                    </a>
                </div>
                <div class="section-list teacher-list">
                    <ul class="teacher-item-wrapper">
                        <li class="teacher-items" v-for="item in tplData.teacher_list">
                            <div class="item" href="#">
                                <img class="cover" :src="item.teacher_avatar_url" alt="teacher">
                                <div class="name"><span>{{ item.teacher_name }}</span></div>
                                <div class="subject no-wrap"><span>{{ item.course_name == 'NA' ? '   ' : item.course_name }}</span></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="section institute-courses mt" v-if="tplData.course_list && tplData.course_list.length > 0">
                <div class="section-hd">
                    <a :href="'/institute/course/'+tplData.institute_id" class="full">
                        <div class="hd-name no-wrap">课程</div>
                        <div class="hd-more">共{{ tplData.course_list_num }}门课程<i class="icon ion-ios-arrow-right ft"></i></div>
                    </a>
                </div>
                <div class="section-list course-list">
                    <ul class="course-item-wrapper">
                        <li class="course-items" v-for="item in tplData.course_list">
                            <div class="item" href="#">
                                <img class="cover" :src="item.course_img" alt="course">
                                <div class="title no-wrap"><span>{{ item.course_desc }}</span></div>
                                <div class="subtitle no-warp"><span>{{ item.course_subject }}</span></div>
                                <div class="price color-red"><span>¥{{ item.course_cur_price }}</span><span class="oriprice">¥{{ item.course_price }}</span></div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="section institute-intro mt" id="intro" v-if="tplData.intro">
                <div class="section-hd">
                    <a :href="'/institute/intro/'+tplData.institute_id" class="full">
                        <div class="hd-name no-wrap">机构介绍</div>
                        <div class="hd-more"><i class="icon ion-ios-arrow-right ft"></i></div>
                    </a>
                </div>
                <div class="intro-text" :class="{'expand' : this.introShow || tplData.intro.length <= 140}">
                    <p>{{ tplData.intro }}</p>
                </div>
                <div class="middle">
                    <a href="#intro" class="readmore" v-if="!introShow && tplData.intro.length > 140" v-on:click="showIntro($event)">更多介绍<i class="icon ion-ios-arrow-down ft"></i></a>
                </div>
                <div class="section-ft" v-if="tplData.campus_num">
                    <a :href="'/institute/campus/' + tplData.institute_id" class="full">
                        <div class="ft-name">机构校区({{ tplData.campus_num }})</div>
                        <a class="ft-more"><i class="icon ion-ios-arrow-right ft"></i></a>
                    </a>
                </div>
            </div>

            <div class="section institute-relatedins mt" id="recommend">
                <div class="section-hd no-border">
                    <div class="hd-name no-wrap">相关机构</div>
                </div>
                <div class="section-list institute-list">
	                <institute-list :data="tplData.relevant_institute">
	                    <div slot="empty">
	                        <div class="icon icon-no-result"></div>
	                        <div class="text">尚无相关机构</div>
	                    </div>
	                </institute-list>

	                <!--
                    <ul class="ins-item-wrapper">
                        <li class="ins-items" v-for="item in tplData.relevant_institute">
                            <a :href="'/institute/detail/' + item.institute_id">
                                <img class="cover" :src="item.cover_pic" alt="institute">
                                <div class="detail no-wrap"><span> {{ item.institute_name }} </span></div>
                            </a>
                        </li>
                    </ul>
                    -->

                </div>
            </div>

            <div class="section institute-relatedart mt" v-if="tplData.relevant_news && tplData.relevant_news.length > 0">
                <div class="section-hd">
                    <div class="hd-name no-wrap">相关文章</div>
                </div>
                <div class="section-list article-list">
                    <ul>
                        <li v-for="item in tplData.relevant_news">
                            <a :href="'/news/'+item.news_id" class="no-wrap">{{ item.news_title }}</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <!--<footer class="section institute-footer">-->
        <!--<div class="controls-wrapper">-->
        <!--<a href="/" v-on:click="goBack($event)" class="control-back icon-button"><i class="icon ion-ios-arrow-left color-grey"></i></a>-->
        <!--<a :href="'/comment/post/1/'+tplData.institute_id" class="control-review"><div>我要点评</div></a>-->
        <!--<a href="#" class="control-addstar icon-button"><i class="icon ion-ios-star color-orange"></i></a>-->
        <!--<a href="#" class="control-share icon-button"><i class="icon ion-ios-upload-outline color-grey"></i></a>-->
        <!--</div>-->
        <!--</footer>-->
        <CommentBar type="institute" :id="tplData.institute_id"></CommentBar>

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

<style lang="stylus">

    .page-institute-detail
        color #333333

    body.scroll-disabled
        height 100%
        overflow hidden

    a.full
        overflow auto
        display block

    .mint-popup
        width 90%
        background transparent
        border-radius 20px
        color #1d83f3  
        font-size 40px
        padding-bottom 10px
        margin-bottom 50px
        
    .showMoblie,.cancel
        padding 40px
        margin 0 auto
        text-align center
        border-bottom 1px solid rgba(128, 128, 128, 0.39)
        
    .showBlock,.cancel
        border-radius 20px
        background #fff
        border-bottom none

    .cancel
        margin-top 30px
        
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

    .mt
        margin-top 10px

    .section
        background #fff

    .section-hd, .section-ft
        overflow hidden
        border-bottom solid 2px #F0F0F0

        .hd-name, .ft-name
            padding 32px
            padding-right 0
            float left
            color #333
            font-size 28px
            line-height 36px
            max-width 80%

        .hd-name.phone
            max-width 70%

        .hd-more, .ft-more
            padding 32px
            float right
            color #999
            font-size 24px
            line-height 36px

    .section-hd.no-border
    	border none

    .section-ft
        border-top solid 2px #F0F0F0
        border-bottom none

    .navbar
        position fixed
        z-index 10
        left 0
        top 0
        width 100%
        height 90px
        transition transform .5s
        transform translateY(-90px)
        background-color #FFF
        .nav-menu
            margin 0
            padding 0
            display flex
            li
                flex-grow 1
                text-align center
                a
                    display block
                    font-size 28px
                    line-height 90px
                    height 90px
                    box-sizing border-box
                    border-bottom solid 2px #F0F0F0
                a.active
                    color #e9314a
                    border-bottom solid 4px #e9314a
    .navbar.show
        transform none

    .institute-info
        .section-col
            padding 32px
            border-bottom solid 3px #F0F0F0
        .institute-maininfo
            position relative
            overflow auto
            .img-cover
                position relative
                width 160px
                height 160px
                float left
                margin-right 32px
                background-color #000
                img
                    position absolute
                    width 100%
                    height 100%
                    object-fit cover
                    opacity .4
                .img-text
                    margin-top 50px
                    font-size 28px
                    line-height 30px
                    text-align center
                    color #FFF
            .title
                font-size 32px
                line-height 1
                margin-bottom 10px
            .subtitle
                margin-top 10px
                font-size 24px
                line-height 1
                .label-verified
                    display inline-block
                    background-color #ffa759
                    color #FFF
                    line-height 32px
                    padding 0 12px
                    font-size 20px
                    border-radius 18px
            .score
                position absolute
                left 222px
                bottom 32px
                font-size 42px
                line-height 1
            .subscore
                position absolute
                right 32px
                bottom 32px
                float right
                color #999
                font-size 28px
                line-height 1
                span
                    margin-left 24px
        .institute-quantity
            display flex
            padding 32px 0
            .quantity-item
                padding 8px 0
                flex-grow 1
                font-size 32px
                line-height 1.5
                border-right solid 3px #F0F0F0
            .quantity-item:last-child
                border-right none

        .institute-detail
            overflow auto
            .detail-item
                width 100%
                float left
                font-size 28px
                line-height 2
                .label
                    color #999
            .detail-item.half
                width 50%

    .teacher-list
        padding 12px
        .teacher-item-wrapper
            padding 0
            margin 0
            overflow auto
            .teacher-items
                list-style-type none
                width 20%
                float left
                .item
                    display block
                    margin 12px
                    text-align center
                    .cover
                        display block
                        width 100%
                        height 18vw
                        height calc(20vw - 26.4px)
                        object-fit cover
                        border-radius 50%
                    .name
                        margin-top 16px
                        font-size 24px
                        line-height 1.5
                    .subject
                        font-size 20px
                        line-height 1.5
                        color #999

    .course-list
        .course-item-wrapper
            padding 0
            margin 0
            .course-items
                list-style-type none
                border-bottom solid 1px #F0F0F0
                margin 1px
                .item
                    display block
                    position relative
                    padding 32px
                    overflow auto
                    .cover
                        display block
                        width 160px
                        height 160px
                        float left
                        margin-right 32px
                    .title
                        font-size 32px
                        line-height 1
                    .subtitle
                        margin-top 10px
                        font-size 24px
                        line-height 1
                        color #999
                    .price
                        position absolute
                        left 222px
                        bottom 32px
                        font-size 28px
                        line-height 1
                        .oriprice
                            margin-left 10px
                            color #999
                            text-decoration line-through

    .intro-text
        position relative
        padding 32px
        max-height 210px
        transition max-height .5s
        overflow hidden
        p
            margin 0
            font-size 28px
            line-height 1.5
            text-align justify

    .intro-text:after
        content ''
        position absolute
        left 0
        bottom 0
        width 100%
        height 96px
        background linear-gradient(to bottom,rgba(255,255,255,0),rgba(255,255,255,1) 75%)

    .intro-text.expand
        max-height 233333px
    .intro-text.expand:after
        display none

    a.readmore
        display inline-block
        color #999
        font-size 28px
        line-height 36px
        margin-bottom 32px

    .article-list
        ul
            padding 0
            margin 0
            li
                list-style-type none
                border-bottom solid 1px #F0F0F0
                a
                    display block
                    padding 32px
                    font-size 28px

    .institute-footer
        border-top solid 1px #F0F0F0
        position fixed
        bottom 0
        left 0
        width 100%
        .controls-wrapper
            padding 8px
            display flex
            height 84px
            .icon-button
                width 120px
                text-align center
                display inline-block
                .icon
                    font-size 60px
                    line-height 84px
            .control-review
                width 100%
                div
                    margin 16px
                    font-size 24px
                    line-height 50px
                    background-color #e9314a
                    color #FFF
                    text-align center
                    border-radius 42px


    .color-red
        color #e9314a

    .color-green
        color #3cc382

    .color-orange
        color #ffa759

    .color-grey
        color #999

    .icon
        vertical-align middle
        font-size 28px
        line-height 28px

    .icon.hd
        margin-right 16px

    .icon.hd:before
        transform scale(1.4)

    .icon.ft
        margin-left 10px
        font-size 36px
        line-height 36px

    .middle
        text-align center

    .no-border
        border none

    .no-wrap
        white-space nowrap
        text-overflow ellipsis
        overflow hidden
        font-size initial

    .icon-shield.hd:before
        transform scale(1.2)

    a
        transition background-color .3s

    li:last-child
        border none
</style>

<script type="text/ecmascript-6">
    import Vue from 'vue';
    import { Swipe, SwipeItem, Toast, Popup } from 'mint-ui';
    import CommentBar from '../../widget/CommentBar.vue';
    import JuiHeader from "../../components/Header.vue";
    import CommentList from '../../components/CommentList.vue';
    import InstituteList from '@/components/InstituteList.vue';
    import routine from '@/js/routine';

    Vue.component(Swipe.name, Swipe);
    Vue.component(SwipeItem.name, SwipeItem);
    Vue.component(Popup.name, Popup);


    export default {
        components: {
            JuiHeader,
            CommentBar,
            CommentList,
            InstituteList
        },
        data () {
            return {
                tplData: $tplData,
                scrolled: false,
                location: 'info',
                anchor_Y: [],
                scrolling: false,
                lightboxImages: [],
                lightboxShow: false,
                lightboxIndex: 0,
                introShow: false,
                popupVisible: false,
                moblieArrs: []
            };
        },
        methods: {
            goBack: function(event) {
                if(document.referrer) {
                    if (event) {
                        event.preventDefault();
                    }
                    window.history.go(-1);
                    return false;
                }
            },
            selectMoblie: function(mobiles) {
                 this.moblieArrs = mobiles.split(",")
                this.popupVisible = true;
                // document.getElementsByClassName('widget-comment-bar').style.zIndex = 200

            },
            close: function() {
              this.popupVisible = false;  
            },
            showIntro: function(event) {
                if (event) {
                    event.preventDefault();
                }
                this.introShow = true;
                return false;
            },
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
            },
            handleScroll: function () {
                this.scrolled = window.scrollY > 10;
                if (this.anchor_Y.length == 0) {
                    let anchor_list = ['info','review','teacher','recommend'];
                    let self = this;
                    anchor_list.forEach(function(item) {
                        let anchorTarget = window.document.getElementById(item);
                        if (anchorTarget !== null) {
                            let des_top =
                                window.scrollY +
                                anchorTarget.getBoundingClientRect().top -
                                anchorTarget.scrollTop +
                                anchorTarget.clientTop;
                            des_top -= 180 / 750 * window.innerWidth + 1;
                            self.anchor_Y.push(des_top);
                        }
                    });
                }
                if(this.scrolling) {
                    return;
                }
                if(window.scrollY < this.anchor_Y[1]) {
                    this.location = 'info';
                } else if(window.scrollY < this.anchor_Y[2]) {
                    this.location = 'review';
                } else if(window.scrollY < this.anchor_Y[3]) {
                    this.location = 'teacher';
                } else{
                    this.location = 'recommend';
                }
            },
            scrollView: function (anchor, event) {
                if (event) {
                    event.preventDefault();
                }
                let self = this;
                function scrollTop(top, des) {
                    if(top != window.scrollY) {
                        self.scrolling = false;
                        return;
                    } else if (Math.abs(des - window.scrollY) > 3) {
                        let go = Math.floor((des - window.scrollY) / 3);
                        top = window.scrollY + go;
                        window.scrollBy(0, go);
                        setTimeout(function() {
                            scrollTop(top, des)
                        }, 33);
                    } else {
                        self.scrolling = false;
                        window.scrollTo(0, des);
                    }
                }
                this.location = anchor;
                let anchorTarget = window.document.getElementById(anchor);
                if (anchorTarget !== null) {
                    let des_top =
                        window.scrollY +
                        anchorTarget.getBoundingClientRect().top -
                        anchorTarget.scrollTop +
                        anchorTarget.clientTop;
                    des_top -= 180 / 750 * window.innerWidth;
                    if (des_top < 0) {
                        des_top = 0;
                    }
                    if (window.scrollY != des_top) {
                        this.scrolling = true;
                        scrollTop(window.scrollY, des_top);
                    }
                }
                return false;
            }
        },
        created () {
            window.addEventListener('scroll', this.handleScroll);
        },
        destroyed () {
            window.removeEventListener('scroll', this.handleScroll);
        }
    }
</script>
