<template>
<div class="top-page-container">
    <div class="sub-page-nav">
        <div class="nav-list-wrap">
            <div class="list-bd">
                <router-link :to="{ name: 'order'}"><span :class="10 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.finacial.field.orderCheck')}}</router-link>
                <router-link :to="{ name: 'capitalManage'}"><span :class="11 | permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.finacial.field.finacialManage')}}</router-link>
                <router-link :to="{ name: 'refundManage'}"><span :class="9| permissionCtrl" class="ion-ios-locked"></span>{{$t('sidebarNav.finacial.field.refundManage')}}</router-link>
            </div>
        </div>
    </div>
    <div class="sub-page-content">
        <router-view></router-view>
    </div>
</div>
</template>
<style lang="styl" src="@/styl/subRoute.styl"></style>
