<template>
    <el-menu
      default-active="course"
      class="navbar"
      background-color="#1b1c22"
      text-color="#fff"
      active-text-color="#268fff"
      mode="vertical"
      :router="true">
      <el-menu-item index="/homepage">
        <i class="el-icon-menu"></i>
        <span slot="title">首页</span>
      </el-menu-item>
      <el-submenu index="course">
        <template slot="title">
          <i class="el-icon-location"></i>
          <span>门店管理</span>
        </template>
          <el-menu-item index="store"><span class="margin20">门店信息</span></el-menu-item>
          <el-menu-item index="course"><span class="margin20">课程管理</span></el-menu-item>
          <el-menu-item index="teacher"><span class="margin20">老师管理</span></el-menu-item>
          <el-menu-item index="5"><span class="margin20">评价管理</span></el-menu-item>
      </el-submenu>
    </el-menu>
</template>
<script>
export default {

}
</script>
<style lang="stylus">
.navbar
  min-height 100%
  min-width 200px
.margin20
  margin-left 20px
</style>
