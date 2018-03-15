<template>
<div id="app">
    <Navbar v-if="showNavBar"></Navbar>
    <div class="main-container">
        <div class="relative">
            <div class="guideBtn" @click="resee">{{$t('nav.createQuickly')}}</div>
            <div v-show="guideStage==1"><img src="./assets/images/guide1.png" class="guide1">
                <div class="next_1" @click="next"></div>
            </div>
            <div v-show="guideStage==2"><img src="./assets/images/guide2.png" class="guide2">
                <div class="next_2" @click="next"></div>
            </div>
            <div v-show="guideStage==3"><img src="./assets/images/guide3.png" class="guide3">
                <div class="next_3" @click="next"></div>
            </div>
            <div v-show="guideStage==4"><img src="./assets/images/guide4.png" class="guide4">
                <div class="next_4" @click="next"></div>
            </div>
            <div v-show="guideStage==5"><img src="./assets/images/guide5.png" class="guide5">
                <div class="next_5" @click="next"></div>
            </div>
            <div v-show="guideStage==6"><img src="./assets/images/guide6.png" class="guide6">
                <div class="next_6" @click="next"></div>
                <div class="close" @click="close"></div>
            </div>
        </div>
        <transition mode="out-in" enter-active-class="fadeIn" leave-active-class="fadeOut">
            <router-view class="animated"></router-view>
        </transition>
    </div>
    <div class="guide" v-show="showShadow">
    </div>
</div>
</template>

<script>
import Navbar from '@/layout/Navbar'

export default {
    name: 'app',
    components: {
        Navbar
    },
    computed: {
        showNavBar() {
            var routes = ['createCourse', 'modifyCourse', 'notice', 'noticeDetail', 'personalAccount', 'instituteAccount', 'liveNotice'];
            return routes.indexOf(this.$route.name) == -1;
        }
    },
    data() {
        return {
            guideStage: 1,
            showShadow: true,
        }
    },
    created() {
        if (window.localStorage.guide) {
            this.guideStage = 7;
            this.showShadow = false;
        } else {
            var storage = window.localStorage;
            storage.setItem("guide", 1);
            this.$router.push({
                path: '/course/video'
            })
        }
    },
    methods: {
        next() {
            this.guideStage == 6 ? this.guideStage = 1 : this.guideStage++;
            if (this.guideStage == 5) {
                this.$router.push({
                    path: '/course/data'
                })
            } else if (this.guideStage == 6) {
                this.$router.push({
                    path: '/course/list'
                })
            } else if (this.guideStage == 1) {
                this.$router.push({
                    path: '/course/video'
                })
            }
        },
        close() {
            this.guideStage = 7;
            this.showShadow = false;
        },
        resee() {
            this.guideStage = 1;
            this.showShadow = true;
            this.$router.push({
                path: '/course/video'
            })
        }
    }
}
</script>
<style scoped>
html,
body,
#app {
    height: 100%
}

.guide {
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, .6);
    position: fixed;
    left: 0;
    top: 0;
    z-index: 10000;
}

.relative {
    position: relative;
}

.guideBtn {
    height: 18px;
    width: 200px;
    font-size: 14px;
    color: #ffffff;
    position: absolute;
    top: -35px;
    left: 1030px;
    padding-left: 20px;
    cursor: pointer;
    background: url('./assets/images/guideIcon.png') no-repeat;
    background-size: 16px 16px
}

.guide1 {
    z-index: 20000;
    position: absolute;
    left: -20px;
    top: 20px;
    widows: 532px;
    height: 388px;
}

.guide2 {
    z-index: 20000;
    position: absolute;
    left: 250px;
    top: 45px;
    widows: 774px;
    height: 397px;
}

.guide3 {
    z-index: 20000;
    position: absolute;
    left: 270px;
    top: 45px;
    widows: 644px;
    height: 340px;
}

.guide4 {
    z-index: 20000;
    position: absolute;
    left: 420px;
    top: 20px;
    widows: 346px;
    height: 300px;
}

.guide5 {
    z-index: 20000;
    position: absolute;
    left: -15px;
    top: -5px;
    widows: 573px;
    height: 307px;
}

.guide6 {
    z-index: 20000;
    position: absolute;
    left: -22px;
    top: 7px;
    width: 556px;
}

.next_1 {
    position: absolute;
    z-index: 20000;
    left: 273px;
    top: 305px;
    height: 38px;
    width: 88px;
    cursor: pointer;
}

.next_2 {
    position: absolute;
    z-index: 20000;
    left: 785px;
    top: 243px;
    height: 38px;
    width: 88px;
    cursor: pointer;
}

.next_3 {
    position: absolute;
    z-index: 20000;
    left: 675px;
    top: 282px;
    height: 38px;
    width: 88px;
    cursor: pointer;
}

.next_4 {
    position: absolute;
    z-index: 20000;
    left: 572px;
    top: 217px;
    height: 38px;
    width: 88px;
    cursor: pointer;
}

.next_5 {
    position: absolute;
    z-index: 20000;
    left: 319px;
    top: 192px;
    height: 38px;
    width: 88px;
    cursor: pointer;
}

.next_6 {
    position: absolute;
    z-index: 20000;
    left: 347px;
    top: 338px;
    height: 38px;
    width: 96px;
    cursor: pointer;
}

.close {
    position: absolute;
    z-index: 20000;
    left: 237px;
    top: 338px;
    height: 38px;
    width: 96px;
    cursor: pointer;
}
</style>

<style lang="stylus" src="./App.styl"></style>
<style  src="./styl/global.css"></style>
<style  src="./styl/baseColor.scss" lang="scss"></style>
