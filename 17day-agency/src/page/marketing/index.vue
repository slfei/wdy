<template>
    <div class="top-page-container">
        <div class="sub-page-nav">
            <div class="nav-list-wrap"  v-if="type==2">
                <div class="list-title">
                    <i class="ion-ios-home-outline iconfont bigicon"></i>
                    {{$t('marketing.layout.organization.title')}}
                </div>
                <div class="list-bd">
                    <router-link :to="{ name: 'indexpage'}"><span :class="18 | permissionCtrl" class="ion-ios-locked"></span>{{$t('marketing.layout.organization.index')}}</router-link>
                    <router-link :to="{ name: 'about'}"><span :class="19 | permissionCtrl" class="ion-ios-locked"></span>{{$t('marketing.layout.organization.about')}}</router-link>
                    <router-link :to="{ name: 'consultation'}"><span :class="108 | permissionCtrl" class="ion-ios-locked"></span>{{$t('marketing.layout.organization.online')}}</router-link>
                </div>
            </div>
            <div class="nav-list-wrap" v-else-if="type==1" >
                <div class="list-title">
                    <i class="ion-ios-home-outline"></i>
                    {{$t('marketing.layout.person.title')}}
                </div>
                <div class="list-bd">
                    <router-link :to="{ name: 'indexpage'}"><span :class="18 | permissionCtrl" class="ion-ios-locked"></span>{{$t('marketing.layout.person.index')}}</router-link>
                </div>
            </div>
            <div class="nav-list-wrap">
                <div class="list-title">
                    <i class="ion-ios-stopwatch-outline iconfont"></i>
                    {{$t('marketing.layout.discounts.title')}}
                </div>
                <div class="list-bd">
                    <router-link :to="{name: 'discount'}"><span :class="20 | permissionCtrl" class="ion-ios-locked"></span>{{$t('marketing.layout.discounts.title')}}</router-link>
                    <!-- <router-link :to="{name: 'ActivityApply'}">{{$t('marketing.layout.discounts.activity')}}</router-link> -->
                    <router-link :to="{name: 'studentQuery'}"><span :class="21 | permissionCtrl" class="ion-ios-locked"></span>{{$t('marketing.layout.discounts.query')}}</router-link>
                </div>
            </div>

        </div>

        <div class="sub-page-content">
            <router-view></router-view>
        </div>
    </div>
</template>
<style lang="styl" src="@/styl/subRoute.styl"></style>
<script type="text/ecmascript-6" >
    import * as api from '@/js/api';
    export default {
        data() {
        return {
            type: "",
        }
    },
    created() {
        this.getData()
    },
    methods:{
        getData(){
            api.common.checkCurrenttype().then(res=> {
                if (res.status == 200) {
                    this.type = res.data.type
                }
            })

        }
    }
    }
</script>
