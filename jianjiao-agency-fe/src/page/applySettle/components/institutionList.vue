<template>
<div class="institution-main">
  <div class="section-filter">
    <div class="pull-left select-block">
      <el-select v-model="institutionfilter.city" placeholder="城市">
        <el-option v-for="item in citieslist" :key="item.value" :label="item.label" :value="item.value">
        </el-option>
      </el-select>
    </div>
    <div class="pull-left input-block">
      <el-input v-model="institutionfilter.name" placeholder="经营名称" @keyup.13.native="query"></el-input>
    </div>
    <div class="pull-left">
      <el-button type="primary" @click="query">搜索</el-button>
    </div>
  </div>
  <ul class="institution-list">
    <li v-for="item in this.institutionList">
      <img :src="item.cover_pic" class="pull-left">
      <div class="institution-info pull-left">
        <div class="institution-name">{{item.institute_name}}</div>
        <p class="institution-address">地址：{{item.address}}</p>
      </div>
      <div class="claim-btn pull-right">
        <el-button type="primary" plain @click="applyClaim(item.institute_id)" v-if="!item.is_claim">我要认领</el-button>
        <el-button type="info" disabled v-if="item.is_claim">已被认领</el-button>
      </div>
    </li>

  </ul>
  <p class="no-insitution">没有找到您的机构？
    <el-button type="text" @click="creatInstitution">点此创建</el-button>
  </p>
  <div class="pagination-block">
    <el-pagination background @current-change="handleCurrentChange" :current-page.sync="institutionfilter.page_num" :page-size="institutionfilter.page_size" layout="prev, pager, next" :total="listTotal">
    </el-pagination>
  </div>
  <el-dialog title="尖椒机构入驻协议" :visible.sync="PrototalDialogVisible" width="60%" :before-close="handleClose" class="j-dialog">
    <apply-protocol></apply-protocol>
    <div class="protocol-btn">
      <el-button type="primary" @click="agreePrototal">我已阅读并同意此协议</el-button>
    </div>
  </el-dialog>
</div>
</template>
<script>
import applyProtocol from './protocol.vue'
import api from '@/js/api/applySettle'

const citieslist = [{
  value: '北京',
  label: '北京'
}, {
  value: '上海',
  label: '上海'
}, {
  value: '广州',
  label: '广州'
}, {
  value: '深圳',
  label: '深圳'
}, {
  value: '青岛',
  label: '青岛'
}];
export default {
  components: {
    applyProtocol
  },
  mounted() {
    this.getInstitutionList();
  },
  methods: {
    getInstitutionList() { //机构列表
      api.getInstitutionList(this.institutionfilter).then(res => {
        this.institutionList = res.data;
        this.listTotal = res.total;
      })
    },
    query() { //查询
      this.institutionfilter.page_num = 1;
      this.getInstitutionList();
    },
    handleCurrentChange(val) {
      this.institutionfilter.page_num = val;
      this.getInstitutionList();
    },
    getDraftData() {
      var params = {};
      api.getDraftData(params).then(res => {

      })

    },
    applyClaim(id) { //认领机构
      //判断草稿箱是否有数据


      this.institutionID = id;
      this.creatModelShow();
    },
    creatInstitution() { //创建机构
      this.institutionID = '';
      this.creatModelShow();

    },
    creatModelShow() {
      this.PrototalDialogVisible = true;
    },
    agreePrototal() {
      this.PrototalDialogVisible = false;
      this.$emit('changeStage');
    },
    handleClose(done) {
      this.$confirm('确认关闭?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning',
          customClass: 'j-dialog'
        })
        .then(_ => {
          done();
        })
        .catch(_ => {});
    }
  },
  destroyed() {
    bus.$emit('transInstitutionID', this.institutionID);
  },
  data() {
    return {
      citieslist: citieslist,
      institutionList: [],
      listTotal: 0,
      institutionfilter: {
        city: '北京',
        name: '',
        page_size: 10,
        page_num: 1
      },
      PrototalDialogVisible: false,
      institutionID: ''
    };
  }
}
</script>

<style lang="stylus">
  .institution-main
    .section-filter
      border-bottom 1px solid #e5e5e5
      overflow hidden
      margin 30px 0
      padding-bottom 20px
      padding-left 60px
      label
        line-height 40px
        color red
        width 60px
        text-align right
      .select-block
        margin 0 10px
      .input-block
        margin-right 10px
        width 400px
    .institution-list
      width 760px
      margin 0 auto
      li
        overflow hidden
        border-bottom 1px solid #e5e5e5
        padding-bottom 10px
        margin 20px 0
        img
          width 120px
          height 120px
        .institution-info
          margin-left 20px
          margin-top 10px
          .institution-name
            color #333
            line-height 40px
            font-size 18px
            text-align left
          .institution-address
            color #999
            font-size 12px
            margin 0
        .claim-btn
          margin-top 20px
    .no-insitution
      text-align center
      background-color #f4f4f4
      padding 8px 0
      color #666
    .pagination-block
      text-align center
    .protocol-btn
      button
        width 200px
        margin 20px auto
        margin-bottom 0
        display block
</style>
