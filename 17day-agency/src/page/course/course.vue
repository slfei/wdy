<template>
<div class="top-page-container">
    <div class="sub-page-nav">
        <div class="nav-list-wrap">
            <div class="list-title">
                <i class="ion-ios-list-outline iconfont"></i> {{$t('sidebarNav.teachingManagement.content.title')}}
            </div>
            <div class="list-bd">
                <router-link :to="{ name: 'courseManage'}"><span :class="14 | permissionCtrl" class="ion-ios-locked"></span> {{$t('sidebarNav.teachingManagement.content.field.courseManage')}}</router-link>
                <router-link :to="{ name: 'videoManage'}"><span :class="16 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.teachingManagement.content.field.videoManage')}}</router-link>
                <router-link :to="{ name: 'dataManage'}"><span :class="15 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.teachingManagement.content.field.dataManage')}}</router-link>
            </div>
        </div>
        <div class="nav-list-wrap">
            <div class="list-title">
                <i class="ion-ios-folder-outline iconfont"></i> {{$t('sidebarNav.teachingManagement.teach.title')}}
            </div>
            <div class="list-bd">
                <router-link :to="{name: 'liveList'}"><span :class="114 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.teachingManagement.teach.field.liveList')}}</router-link>
                <router-link :to="{name: 'commentManage'}"><span :class="17 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.teachingManagement.teach.field.evaluationManage')}}</router-link>
            </div>
        </div>
    </div>
    <div class="sub-page-content">
        <router-view></router-view>
    </div>
</div>
</template>
<style lang="styl" src="@/styl/subRoute.styl"></style>
