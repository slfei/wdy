<template>
<div class="page-data-mangement">

    <div class="data-main-top">
        <div class="elui-btn-upload">
            <data-uploader @upload-success="getDataList"></data-uploader>
        </div>
        <div class="data-search-input pull-right-el">
            <div>
                <el-input v-model="filename" :placeholder="$t('data.placeholder.input-search')" @keyup.13.native="searchData" class="w-input"></el-input>
            </div>
            <div>
                <el-button type="primary" @click="searchData()">{{ $t('data.btn.search') }}</el-button>
            </div>
        </div>
        <div class="pull-right-el my-upload-block">
            <el-checkbox v-model="checked" @change="searchMyData(checked)" value="1" class="w-checkbox">{{ $t('data.checkbox.myupload') }}</el-checkbox>
        </div>
    </div>
    <el-table :data="listData" :empty-text="$t('data.table.tip-nodata')" border style="width: 100%" class="w-table">
        <el-table-column :label="$t('data.table.tilte-file-info')" width="400">
            <template scope="props">
                    <div class="iccon">
                        <input v-if="props.$index==editIndex" class="noedit" v-model="props.row.temp_filename" @blur="endEdit(props.row)" v-bind:class="{ edit:props.$index==editIndex}" maxlength="50">
                        <span v-if="props.$index!=editIndex">{{props.row.file_name}}</span>
                        <i class="ion-ios-compose-outline icon-pencil" v-if="props.row.operation==1" @click="editName(props.row,props.$index)"></i>
                    </div>
                </template>
        </el-table-column>
        <el-table-column :label="$t('data.table.tilte-file-size')" width="180">
            <template scope="scope">
                    {{scope.row.size | sizeWithUnit}}
                </template>
        </el-table-column>
        <el-table-column prop="author" :label="$t('data.table.tilte-file-author')">
        </el-table-column>
        <el-table-column :label="$t('data.table.tilte-file-operation')" width="100">
            <template scope="scope">
                    <el-button v-if="scope.row.operation==1" @click="deleteItem(scope.row.id)" type="text" size="small">{{ $t('data.btn.file-delete') }}</el-button>
                </template>
        </el-table-column>
    </el-table>
    <div class="pagination-footer" v-if="listData.length>0">
        <el-pagination @current-change="handleCurrentChange" :current-page.sync="filter.page_num" :page-size="10" layout="prev, pager, next" :total="total" class="w-pagination"></el-pagination>
    </div>
</div>
</template>
<script>
import Vue from 'vue'
import dataUploader from "./dataUploader"
import api from '@/utils/http';
import utils from '@/js/utils';
export default {
    components: {
        dataUploader
    },
    data() {
        return {
            checked: false,
            isreadOnly: true,
            ifedit: true,
            listData: [],
            editIndex: -1,
            total: 0,
            filename: '',
            filter: {
                page_size: 10,
                page_num: 1,
                myupload: 0,
                filename: ''
            }
        };
    },
    filters: {
        sizeWithUnit(size) {
            return utils.sizeWithUnit(size, 1024, 2);
        },
    },
    mounted() {
        this.getDataList();
    },
    methods: {
        getDataList() { //获取上传资料列表数据
            api.getDataList(this.filter).then(res => {
                if (res) {
                    this.total = res.tatal;
                    this.listData = res.list;
                    this.listData.map(function(item) {
                        Vue.set(item, 'temp_filename', item.file_name);
                    });
                }
            })
        },
        deleteItem(id) { //删除上传资料
            api.checkdelfile({
                    id: id
                })
                .then(res => {
                    if (res) {
                        this.$confirm(this.$t('data.layer.toggle'), this.$t('data.layer.tips'), {
                            customClass: "w-dialog",
                            confirmButtonText: this.$t('data.layer.btn.ok'),
                            cancelButtonText: this.$t('data.layer.btn.cancel'),
                            type: 'warning'
                        }).then(() => {
                            api.delfile({
                                    id: id
                                })
                                .then(res => {
                                    this.$message({
                                        type: 'success',
                                        message: this.$t('data.tips.success-delete')
                                    });
                                    this.getDataList();
                                });
                        })
                    }
                })
        },
        searchMyData(checked) { //获取我上传的资料
            if (checked) {
                this.filter.myupload = '1';
            }
            if (!checked) {
                this.filter.myupload = '0';
            }
            this.getDataList();
        },
        searchData() { //输入精确搜索
            this.filter.filename = this.filename;
            this.getDataList();
            //if (this.filename.replace(/(^\s*)/g, "") != '') {
            //    this.getDataList();
            // }
        },
        editName(item, index) { // 点击“编辑”图标
            this.editIndex = index;
            item.temp_filename = item.file_name;
        },
        endEdit(item) { // 修改文件名
            if (!item.temp_filename.replace(/(^\s*)/g, "")) {
                this.$message({
                    type: 'error',
                    message: this.$t('data.tips.prompt-filename-null')
                });
                return false;
            } else {
                api.savefile({
                        id: item.id,
                        filename: item.temp_filename
                    })
                    .then(res => {
                        this.editIndex = -1;
                        item.file_name = item.temp_filename;
                    });
            }
        },
        handleCurrentChange(val) {
            this.filter.page_num = val;
            this.getDataList();
        }
    }
}
</script>
<style>
.page-data-mangement {
    margin-top: 10px;
}

.page-data-mangement .footerOver {
    overflow: hidden;
}

.page-data-mangement .footerOver p.intip {
    float: left;
    font-size: 12px;
    color: #999999;
    width: 300px;
    text-align: left;
    line-height: 20px;
    margin: 0;
}

.page-data-mangement .footerOver button {
    float: right;
    margin-left: 5px;
}

.page-data-mangement .icontip {
    color: #1c9cf5;
    margin-right: 5px;
}

.page-data-mangement .labelcontrol {
    margin-top: 8px;
}

.page-data-mangement .btnsearch {
    text-align: right;
}

.page-data-mangement .btnsearch button {
    width: 100%;
    display: block;
}

.page-data-mangement .iconcolor {
    color: #268fff;
    cursor: pointer;
    margin-left: 5px;
}

.page-data-mangement .iccon {
    overflow: hidden;
}

.page-data-mangement input.noedit {
    background-color: transparent;
    border: none;
    overflow-x: visible;
    overflow-y: visible;
    width: 300px;
}

.page-data-mangement input.edit {
    border: 1px solid #e5e5e5;
    background-color: #fff;
}

.page-data-mangement .el-pagination {
    text-align: center;
    margin-top: 20px;
}

.page-data-mangement .el-message-box {
    background-color: #268fff;
    padding: 20px 20px 0;
}

.page-data-mangement .el-table td {
    height: 54px;
    border-right: none;
    border-bottom: 1px solid #dadada;
}

.page-data-mangement .el-table th.is-leaf {
    border-bottom: 1px solid #dadada;
}

.page-data-mangement .el-table {
    border-color: #dadada;
}

.page-data-mangement .el-table--border th {
    border-right: none;
}

.page-data-mangement .icon-pencil {
    display: inline-block;
    color: #268fff;
    font-size: 18px;
    cursor: pointer;
    margin-left: 5px;
}

.el-table--enable-row-hover .el-table__body tr:hover>td {
    background-color: #f5f5f5;
}

.el-message-box__header {
    background-color: #268fff;
    padding: 10px;
}

.el-message-box__title {
    color: #fff;
    font-weight: 500;
    font-size: 14px;
}

.el-message-box__headerbtn {
    top: 10px;
    right: 10px;
}

.el-message-box__headerbtn .el-message-box__close {
    color: #fff;
    font-size: 12px;
}

.page-data-mangement .data-main-top {
    overflow: hidden;
    margin: 20px 0;
}

.page-data-mangement .elui-btn-upload {
    float: left;
}

.page-data-mangement .pull-right-el {
    float: right;
    margin-left: 10px;
}

.page-data-mangement .data-search-input>div {
    float: left;
    margin-left: 10px;
}

.page-data-mangement .data-search-input>div input {
    width: 280px;
}

.page-data-mangement .my-upload-block {
    margin-top: 8px;
}
</style>
