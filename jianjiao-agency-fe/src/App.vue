<template>
<div id="app">
    <Header/>
    <div class="sidebar">
      <Navbar></Navbar>
    </div>
    <div class="main-content">
      <transition mode="out-in" enter-active-class="fadeIn" leave-active-class="fadeOut">
        <router-view class="animate"></router-view>
      </transition>
    </div>
</div>
</template>

<script>
import Navbar from '@/layout/Navbar'
import Header from '@/layout/Header.vue'
export default {
  name: 'App',
  components:{
  	Navbar,
  	Header,
  },
  computed: {
    showNavBar() {
      var routes = [];
      return routes.indexOf(this.$route.name) == -1;
    },
    showHeader() {
      var routes = [];
      return routes.indexOf(this.$route.name) == -1;
    }
	},
}
</script>

<style lang="stylus">
@import "./assets/ionicons/css/ionicons.min.css"
@import "./style/global.styl"
@import "./style/element.css"
#app
  font-family 'Avenir', Helvetica, Arial, sans-serif
  -webkit-font-smoothing antialiased
  -moz-osx-font-smoothing grayscale
  color #2c3e50
  height 100%
  width 100%
  .sidebar
    width 12.5%
    height calc(100% - 60px)
    display inline-block
    float left
  .main-content
    display inline-block
    width 87.5%
    float right
    height calc(100% - 60px)
    overflow auto
    background #f5f5f5
    .animate
      margin 40px

</style>
