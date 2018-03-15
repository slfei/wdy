<template>
    <div id="app">
        <div class="main-container">
            <transition mode="out-in" enter-active-class="fadeIn" leave-active-class="fadeOut">
                <router-view class="animated"></router-view>
            </transition>
        </div>
    </div>
</template>

<style lang="stylus" src="./App.styl"></style>
