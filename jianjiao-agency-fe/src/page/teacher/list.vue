<template>
  <div class="page page-teacher-list">
    <router-link :to="{path: '/teacher/add'}">
      <el-button type="primary">添加老师</el-button>
    </router-link>
    <div class="main">
      <el-table
      :data="teacherList"
      style="width: 100%">
      <el-table-column
        label="老师信息">
        <template slot-scope="scope">
          <div class="teacher-info">
            <img :src="scope.row.avatar" class="avatar"/>
            <div class="right">
              <div class="name">{{ scope.row.name }}</div>
              <a class="tag m-r-16">{{ scope.row.degrees }}</a>
              <a class="tag">{{ scope.row.titles }}</a>
            </div>
          </div>
       </template>
      </el-table-column>
      <el-table-column
        label="授课科目"
        prop="course">
      </el-table-column>
      <el-table-column
        label="教龄(年)"
        prop="school_age">
      </el-table-column>
      <el-table-column
        label="更新时间"
        prop="updated_at">
      </el-table-column>
      <el-table-column
        label="操作"
      >
        <template slot-scope="scope">
          <el-button type="text" @click="editTeacherInfo(scope.row.id)">编辑</el-button>
          <el-button type="text" @click="delTeacher(scope.row.id)">删除</el-button>
        </template>
      </el-table-column>
    </el-table>
    <el-pagination
      class="pager"
      background
      layout="prev, pager, next"
      :total="this.pagination.total"
      :page-size="this.pagination.pageSize"
      :current-page="this.pagination.page_num"
      prev-text="上一页"
      next-text="下一页"
      >
    </el-pagination>
    </div>
  </div>
</template>

<script>
  import api from '@/js/api/teacher'

  export default {

    data: function () {
      return {
        teacherList: [],
        pagination: {
          page_num: 1,
          pageSize: 10,
          total: 0
        }
      }
    },
    created () {
        this.getList();
    },
    methods: {

      getList () {
        api.getTeacherList({
          page_num: this.pagination.page
        }).then(data => {
          this.teacherList = data.list;
          this.pagination.page_num = data.page_num;
          this.pagination.total = data.total;
        });
      },

      editTeacherInfo (id) {
          this.$router.push('/teacher/edit/' + id);
      },

      delTeacher (id) {
          return api.deleteTeacher(id).then(() => {
            return this.getList();
          });
      }
    }
  }
</script>
<style lang="styl">
  .m-r-16
    margin-right 16px
  .page-teacher-list
      .pager
        text-align center
        margin-top 40px
  .teacher-info
    font-size 14px
    .avatar
      float left
      width 68px
      height 68px
      border-radius 50%
    .right
        padding 5px 0 0 78px
    .name
      font-size 14px
      color #333
      padding-bottom 8px
    .tag
      height 24px
      border 1px solid #d9d9d9
      text-align center
      line-height 24px
      padding 0 14px
      border-radius 4px

</style>
