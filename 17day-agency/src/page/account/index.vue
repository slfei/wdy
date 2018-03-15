<template>
<div class="top-page-container">
    <div class="sub-page-nav">
        <div class="nav-list-wrap">
            <div class="list-title">
                <i class="ion-ios-monitor-outline iconfont"></i>{{$t('sidebarNav.accountManagement.account.title')}}
            </div>
            <div class="list-bd">
                <router-link :to="{ name: 'profile'}"><span :class="22 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.accountManagement.account.field.dataModify')}}</router-link>
                <router-link :to="{ name: 'members'}"><span :class="23 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.accountManagement.account.field.memberManage')}}</router-link>
                <router-link :to="{ name: 'privilege'}"><span :class="24 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.accountManagement.account.field.permissionsManage')}}</router-link>
            </div>
        </div>
        <div class="nav-list-wrap">
            <div class="list-title">
                <i class="ion-ios-person-outline iconfont biggericon"></i> {{$t('sidebarNav.accountManagement.personalInformation.title')}}
            </div>
            <div class="list-bd">
                <router-link :to="{ name: 'personalInfo'}"> {{$t('sidebarNav.accountManagement.personalInformation.field.personnaInfo')}}</router-link>
            </div>
        </div>
    </div>
    <div class="sub-page-content">
        <router-view></router-view>
    </div>
</div>
</template>
<style lang="styl" src="@/styl/subRoute.styl"></style>