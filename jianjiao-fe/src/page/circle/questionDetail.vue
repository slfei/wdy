<template>
    <div class="page page-question-detail">
        <jui-header type="back">
            问题详情
        </jui-header>
        <div class="has-header">
            <div class="question-content">
                <ul class="topic-list">
                    <li class="topic-item" v-for="item in tplData.topics">{{ item.topic_title }}</li>
                </ul>
                <div class="title">
                    {{ tplData.question_content }}
                </div>
                <div class="question-detail" :class="{expand: !showExpandBar}">
                    <div class="rich-text" v-html="tplData.question_detail"></div>
                    <div class="expand-bar" @click="toggleExpandBar"  v-if="showExpandBar">
                        展开全部<i class="ion-ios-arrow-down"></i>
                    </div>
                </div>
                <div class="question-bar">
                    <span class="left question-left">
                    {{ tplData.answer_count }}回答 · 
                    {{ tplData.focus_count }} 收藏 · 
                    {{ tplData.view_count }} 浏览
                    </span>
                    <span class="pull-right" style="color:#000">
                        <i :class="{
                            'icon-pentagram': !isCollection,
                            'icon-pentagram_ac': isCollection
                        }" class="icon"
                           @click="toggleCollection(isCollection)">
                        </i>
                        <i class="icon icon-share"
                           @click="toggleShare"
                           v-if="showShare"
                        ></i>
                    </span>
                </div>
            </div>
            <!-- <div class="comment-background" v-if="editMode" @click="exitEditMode"></div> -->
            <mt-popup
                v-model="shareMode"
                popup-transition="popup-fade">
                <!-- hide for function -->
                <share :config="shareConfig"></share>

                <div class="share-container">
                    <div class="flex-1" @click="share('sina')">
                        <div class="icon-wrapper">
                            <span class="icon icon-sina"></span>
                        </div>
                        <div class="share-text">
                            分享到微博
                        </div>
                    </div>
                    <div class="flex-1" @click="share('qzone')">
                        <div class="icon-wrapper">
                            <span class="icon icon-qzone"></span>
                        </div>
                        <div class="share-text">
                            分享到空间
                        </div>
                    </div>
                    <span class="icon icon-close" @click="toggleShare"></span>
                </div>
            </mt-popup>
            <div class="answer-list"
                 v-infinite-scroll="loadMore"
                 infinite-scroll-disabled="disableLoadMore"
                 infinite-scroll-distance="40"
            >
                <answer-item :data="item" v-for="item in answer_arrays" :key="item.answer_id"></answer-item>
            </div>
        </div>
        <!-- <jui-footer></jui-footer> -->
        <!-- <jui-download></jui-download> -->
    </div>
</template>

<style>
    
</style>
<script type="text/ecmascript-6">
    import JuiHeader from "../../components/Header.vue";
    import AnswerItem from '../../components/answer/item.vue';
    import Vue from 'vue';
    import { Toast, Popup, InfiniteScroll} from 'mint-ui';
    import Share from 'vue-social-share';
    import "vue-social-share/dist/client.css";
    import rnMixin from '@/js/rn_login';
    import api from '@/js/api';

    Vue.use(InfiniteScroll);
    function getMetaContentByName(name) {
        return (document.getElementsByName(name)[0] || 0).content;
    }
    export default {
        mixins: [rnMixin],
        data(){
            var answers = $tplData.answers;
            var answer_ids=[];
            answers.forEach(function(item){
                answer_ids.push(item.answer_id)
            })
            return {
                tplData: $tplData,
                showExpandBar: true,
                isExpand: false,
                loadingMore: false,
                isCollection: false,
                editMode: false,
                shareMode: false,
                answer_ids: answer_ids,
                answer_arrays:[],
                showShare: !window.isWechat || String(window.ReactNativeVersion) < '1.0.1',
                shareConfig: {
                    sites: ['weibo', 'qzone'],
                    title: $tplData.question_content + '尖椒圈子'
                },

                showShare: !window.isWechat,
                pagination: $tplData.answers_page
            }
        },
        computed: {
            disableLoadMore: function() {
                return this.loadingMore || (this.pagination.page_num * this.pagination.page_size >= this.pagination.total);
            }
        },
        components:{
            JuiHeader,
            AnswerItem,
            MtPopup: Popup,
            Share
        },
        mounted () {
            var $content = this.$el.querySelector('.question-detail .rich-text');

            if ($content.scrollHeight <= $content.offsetHeight) {
                this.showExpandBar = false;
            }
        },
        methods: {
            getIsCollect() {
                api.isCollect({
                    typeid: 5,
                    objectid:this.tplData.question_id
                }).then(data => {
                    console.log(data)
                    if (data.collection===1) {
                        this.isCollection = true 
                    }

                });
            },

            toggleExpandBar () {
                this.showExpandBar = false;
            },

            toggleCollection () {

                api.focusquestion(this.tplData.question_id).then(() => this.isCollection = !this.isCollection);

            },

            toggleShare () {
                console.log("hehe")
                // this.shareMode = !this.shareMode;
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
            },
            enterEditMode(){
                this.editMode = true;
                document.scrollingElement.classList.add('modal-open');
            },

            exitEditMode() {
                this.editMode = false;
                document.scrollingElement.classList.remove('modal-open');
            },

            share(type) {
                    var className;
                    if(type=='sina'){
                        className = 'icon-weibo';
                    }else{
                        className = 'icon-qzone';
                    }
                    var evt = document.createEvent("MouseEvents");
                    evt.initEvent("click", false, false);// 或用initMouseEvent()，不过需要更多参数
                    document.querySelector('.share-component .' + className).dispatchEvent(evt);
            },

            loadMore () {
                console.log(this.disableLoadMore)
                this.loadingMore = true;
                api.getAnswerList({
                    questionid: this.tplData.question_id,
                    page_num: this.pagination.page_num++,
                    page_size: this.pagination.page_size
                }).then(data => {
                    this.loadingMore = false;
                    this.pagination.page_num = +data.page.page_num;
                    this.pagination.page_size = data.page.page_size;
                    this.pagination.total = data.page.total || this.pagination.total;

                }).catch(() => this.loadingMore = false);
            },

            answerIsAgree() {
                api.getAnswerIsAgrees({
                    answer_ids:this.answer_ids
                }).then(data => {
                    let answers = $tplData.answers.slice();
                    answers.forEach(function(item){
                        for(let i = 0;i<data.length;i++) {
                            if (data[i].answer_id==item.answer_id) {
                                item['against_count']=data[i].against_count
                                item['agree_count']=data[i].agree_count
                                item['agree_status']=data[i].agree_status
                            }
                        }
                    })
                    this.answer_arrays = answers
                }
                )
            }


        },
        created() {
          this.getIsCollect()
          this.answerIsAgree()
        }

    }

</script>
<style lang="stylus">
    .page-question-detail
        .question-left
            position relative
            top 4px

        .question-content
            background #fff
            padding 0 30px
            .title
                font-size 36px
                font-weight bold
                padding-top 30px
                margin 0 0 24px
                line-height 1.6

        .topic-item
            height 54px
            line-height 54px
            text-align center
            display inline-block
            color #999
            background #f7f7f7
            padding 0 24px
            margin 20px 20px 0 0
            border-radius 27px
        .question-detail
            font-size 28px
            line-height 1.4
            .rich-text
                line-height 1.8
                max-height 200px
                overflow hidden
                -webkit-mask-image: linear-gradient(to bottom, #000, transparent 95%, transparent)
                -webkit-mask-image: linear-gradient(#000 calc(100% - 60px),transparent)
            &.expand
                .rich-text
                    max-height inherit
                    -webkit-mask-image none
            .expand-bar
                position relative
                text-align center

        .question-bar
            padding 40px 0
            color #999
            margin-right -17px
            .question-left
                font-size 24px
                color #999
            .icon
                margin-right 17px
.mint-popup
    width 540px
    height 280px
    margin 0px auto
    background #fff
    border-radius 20px
    left 20px
    right 20px
        
.share-container
    font-size 28px
    color #333
    text-align center

    .icon-close
        margin-top 130px
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
            .icon-qzone
                margin-top 20px !important  
            .icon-sina
                margin-top 25px !important  
    .share-text
        margin-top 20px
.share-component
    position absolute
    z-index -100
    top -10000px
.v-modal
    position fixed
    left 0
    top 0
    width 100%
    height 100%
    opacity 0.5
    background #000
</style>
