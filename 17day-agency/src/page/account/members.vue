<template>
<div id="members">
    <v-dialog v-show="telFormVisible" :telform-visible='telFormVisible' :addform-visible='addFormVisible' @changeV="changeV" @changeaddV="changeaddV"></v-dialog>
    <v-addmember v-show="addFormVisible" :addform-visible='addFormVisible' @changeaddV="changeaddV" @vary="varyAdd"></v-addmember>
    <el-button class="btn_tittle w-button" @click="telFormVisible=true" size="medium">{{$t('members.btn.addMember')}}</el-button>

    <el-table class="table w-table" :data="tableData" style="width:1004px">
        <el-table-column prop="account_name" :label="$t('members.table.name')">
            <template scope="scope">
			        <img :src="scope.row.avatar" class="headerimg"/>
			        <span style="margin-left: 10px">{{scope.row.account_name }}</span>
			    </template>
        </el-table-column>
        <el-table-column prop="role_name" :label="$t('members.table.character')">
            <template scope="scope">
			        <span>{{scope.row.role_name }}</span>
			    </template>
        </el-table-column>
        <el-table-column prop="phone" :label="$t('members.table.phone')">
        </el-table-column>
        <el-table-column prop="email" :label="$t('members.table.email')">
        </el-table-column>
        <el-table-column :label="$t('members.table.operation')">
            <template scope="scope">
			        <el-button size="medium" type="text"  @click="handleModify(scope.$index, scope.row)"  v-if=" check(scope.row.role_id,scope.row.account_id,1)">{{$t('members.btn.edit')}}</el-button>
			        <el-button size="medium"  type="text" @click="delNotice(scope.$index, scope.row)"   v-if=" check(scope.row.role_id,scope.row.account_id,2)">{{$t('members.btn.delete')}}</el-button>
			    </template>
        </el-table-column>
    </el-table>
    <!--编辑页面 start-->
    <section class="dialogWraper" v-show="editFormVisible">
        <div class="dialog">
            <header>
                <span>{{$t('members.props.edit')}}</span>
                <span @click="editFormVisible=false" class="el-icon-close"></span>
            </header>
            <div class="content">
                <el-form :model="editForm" label-width="50px" :rules="editFormRules" ref="editForm">
                    <el-form-item :label="$t('members.form.avatar')" prop='avatar'>
                        <image-uploader v-model="editForm.avatar" class="avatar">
                            <div class="state" slot="desc">
                                {{$t('members.rules.fileSize')}}<br> {{$t('members.rules.fileType')}}
                                <br /> {{$t('members.rules.fileLimite')}}
                            </div>
                        </image-uploader>
                    </el-form-item>
                    <el-form-item :label="$t('members.form.name')" prop="account_name">
                        <el-input v-model='editForm.account_name'></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('members.form.tel')" prop="phone">
                        <el-input v-model='editForm.phone'></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('members.form.email')" prop="email">
                        <el-input v-model='editForm.email'></el-input>
                    </el-form-item>
                    <el-form-item :label="$t('members.form.introduction')" prop="desc">
                        <el-input v-model.trim='editForm.desc' :rows="4" type="textarea"></el-input>
                    </el-form-item>

                </el-form>
            </div>
            <div slot="footer" class="dialog-footer">
                <el-button type="primary" @click="submitForm('editForm')">{{$t('members.btn.save')}}</el-button>
                <el-button @click.native="cancel()">{{$t('members.btn.cancel')}}</el-button>
            </div>
        </div>
    </section>
    <!--编辑页面 end-->
    <!--  分页器start-->
    <div class="pagination">
        <el-pagination class="w-pagination" @current-change="handleCurrentChange" :current-page="currentPage" :page-size="pageSize" layout="prev, pager, next" :total="taskTotal">
        </el-pagination>
    </div>
    <!--  分页器end-->
</div>
</template>
<script>
import ImageUploader from "@/components/upload/ImageUploader"
import Dialog from '@/page/account/Dialog'
import Addmember from '@/page/account/addmember'
import * as api from '@/js/api'
import bus from "@/js/eventBus"
export default {
    name: 'members',
    data() {
        var checkTel = (rule, value, callback) => {
            var regTel = /^1[3|4|5|7|8]\d{9}$/;
            if (!value) {
                return callback(new Error(this.$t('members.rules.phoneNull')));
            } else if (!regTel.test(value)) {
                return callback(new Error(this.$t('members.rules.phonetype')));
            } else {
                callback()
            }
        };
        var checkName = (rule, value, callback) => {

            if (!value) {
                return callback(new Error(this.$t('members.rules.nameNull')));
            } else {
                callback()
            }
        };
        var checkEmail = (rule, value, callback) => {
            var reg = /^\w+(\.\w+)*@(\w){2,}((\.\w{2,3}){1,3})$/;
            var res = reg.test(value);
            if (!value) {
                return callback(new Error(this.$t('members.rules.emailNull')));
            } else if (!res) {
                return callback(new Error(this.$t('members.rules.emailType')));
            } else {
                callback()
            }
        };
        return {
            tableData: [],
            currentRole: '',
            currentAccount: '',
            editFormVisible: false, //编辑界面是否显示
            //编辑界面数据
            editForm: {
                avatar: '',
                id: '',
                account_name: '',
                phone: '',
                email: '',
                desc: '',
                account_id: ''
            },
            editFormRules: {
                account_name: [{
                        required: true,
                        message: this.$t('members.rules.nameNullError'),
                        trigger: 'blur'
                    },
                    {
                        max: 10,
                        message: this.$t('members.rules.uploadSize'),
                        trigger: 'change,blur'
                    }
                ],
                avatar: [{
                    required: true,
                    message: this.$t('members.rules.avatorNull'),
                    trigger: 'change'
                }],
                phone: [{
                    required: true,
                    validator: checkTel,
                    trigger: 'blur'
                }],
                email: [{
                    required: true,
                    validator: checkEmail,
                    trigger: 'blur'
                }],
                desc: [{
                        required: true,
                        message: this.$t('members.rules.insNull'),
                        trigger: 'blur'
                    },
                    {
                        max: 200,
                        message: this.$t('members.rules.insSize'),
                        trigger: 'change,blur'
                    }
                ]
            },
            telFormVisible: false, //新增界面是否显示
            addFormVisible: false,
            addFormRules: {
                name: [{
                    required: true,
                    message: this.$t('members.rules.nameNull'),
                    trigger: 'blur'
                }]
            },
            //新增界面数据
            addForm: {
                id: '',
                avatar: '',
                account_name: '',
                phone: '',
                email: '',
                desc: ''
            },
            currentPage: 1, //默认显示第一页
            taskTotal: 0, //总数据量，初始化为0
            pageSize: 10, //每页默认展示10条数据
        }
    },
    methods: {
        initData() {
            api.member.getMemberlist().then(res => {
                var data = res.data.data
                if (res.data.status == 200) {
                    this.taskTotal = data.total
                    this.handleCurrentChange(1)
                    this.currentRole = data.user_info.role_id;
                    this.currentAccount = data.user_info.account_id;
                }
            }).catch(err => {
                console.log(err)
            })
        },
        varyAdd() {
            this.initData()
        },

        handleModify(index, row) { //修改
            api.member.getMemberUpdatepage({
                "id": row.id,
                account_id: row.account_id
            }).then(res => {
                this.editForm = res.data.data.member_info
                this.initData()
                this.editFormVisible = true;
            })
        },
        handleDelete(index, row) { //删除
            this.tableData.splice(index, 1)
            api.member.delMemberlist({
                id: row.id,
                account_id: row.account_id
            }).then(res => {
                this.initData()
            })
        },
        delNotice(index, row) { //删除后提示
            this.$confirm(this.$t('members.props.deleteTip'), this.$t('members.props.delete'), {
                cancelButtonText: this.$t('members.btn.cancel'),
                confirmButtonText: this.$t('members.btn.confirm'),
                type: 'warning',
                customClass: "cancel"
            }).then(() => {
                this.handleDelete(index, row)
                this.$message({
                    type: 'success',
                    message: this.$t('members.tip.deleteSuccess')
                });
            }).catch(() => {
                this.$message({
                    type: 'info',
                    message: this.$t('members.tip.alreadyCancel')
                });
            });
        },
        changeV(msg) { //控制v-dialog的显示隐藏
            this.telFormVisible = msg
        },
        changeaddV(msg) { //v-addmember显示隐藏
            this.addFormVisible = msg
        },
        submitForm(editForm) {
            this.$refs[editForm].validate((valid) => {
                if (valid) {
                    api.member.postMemberUpdate(this.editForm).then(res => {
                        if (res.data.status == 200) {
                            this.initData()
                            this.$message({
                                type: 'success',
                                message: this.$t('members.tip.saveSuccess')
                            })
                            this.editFormVisible = false;
                        } else {
                            this.editFormVisible = true;
                            this.$message.error(res.data.msg)
                        }

                    });
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        cancel() { //点击取消
            this.$confirm(this.$t('members.props.cancerWarn'), this.$t('members.props.tip'), {
                confirmButtonText: this.$t('members.btn.confirm'),
                cancelButtonText: this.$t('members.btn.cancel'),
                type: 'warning',
                customClass: "cancel"
            }).then(() => {
                this.editFormVisible = false;
            }).catch(() => {

            });
        },
        // 翻页
        handleCurrentChange(current) { //current点击的页码
            this.currentPage = current
            api.member.getMemberlist({
                page_size: this.pageSize,
                page_num: this.currentPage
            }).then(res => {
                this.tableData = res.data.data.data
            });
        },
        check(role_id, account_id, type) {
            if (account_id == this.currentAccount) {
                if (type == 1) {
                    return true;
                } else {
                    return false;
                }
            }
            switch (this.currentRole) {
                case 1:
                    return true;
                    break;
                default:
                    switch (role_id) {
                        case 1:
                            return false;
                            break;
                        case 2:
                            return false;
                            break;
                        default:
                            return true;
                            break;
                    }
                    break;
            }
        }
    },
    computed: {

    },
    components: {
        ImageUploader,
        "v-dialog": Dialog,
        "v-addmember": Addmember
    },
    created() {
        this.initData();
    },
}
</script>

<style lang="scss">
#members {
    width: 1005px;
    .headerimg {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        vertical-align: middle;
    }
    .btn_tittle {
        margin-bottom: 20px;
        cursor: pointer;
    }
    .table {
        border-radius: 3px;
        font-size: 14px;
        th {
            height: 54px;
        }
        td {
            height: 70px;
        }
    }
    section.dialogWraper {
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 7;
    }
    .dialog {
        position: absolute;
        width: 534px;
        height: 488px;
        border-radius: 4px;
        background: #fff;
        left: 50%;
        top: 50%;
        margin-left: -267px;
        margin-top: -244px;
        z-index: 999;
        font-size: 12px !important;
        header {
            height: 44px;
            width: 100%;
            background: #268fff;
            line-height: 44px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            margin-bottom: 20px;
            box-sizing: border-box;
            color: #fff;
            font-size: 14px;
            border-top-left-radius: 4px;
            border-top-right-radius: 4px;
            .el-icon-close {
                cursor: pointer;
                font-size: 12px;
            }
        }
        .content {
            padding: 0 40px;
            box-sizing: border-box;
            .state {
                padding-top: 20px;
                box-sizing: border-box;
                font-size: 12px;
            }
            .avatar {
                .siu-input {
                    overflow: hidden;
                    border-radius: 50%;
                    text-align: center;
                    width: 90px;
                    height: 90px;
                    max-width: 90px;
                    min-width: 90px;
                    border: none;
                    .img-preview {
                        height: 100%;
                        width: 100%;
                        border: none;
                        img {
                            height: 100%;
                            width: 100%;
                        }
                    }
                }

            }

            .el-form-item__label {
                font-size: 12px !important;
            }
            .el-input__inner {
                font-size: 12px !important;
            }

            .el-form-item {
                margin-bottom: 18px !important;
            }
            .el-textarea__inner {
                font-size: 12px !important;
                height: 80px;
            }

        }
        .dialog-footer {
            display: flex;
            justify-content: center;
            .el-button {
                font-size: 12px !important;
                width: 64px;
                height: 32px;
                line-height: 0;
            }
            .el-button:first-child {
                margin-right: 10px !important;
            }
        }
    }
    .pagination {
        width: 1020px;
        text-align: center;
        margin-top: 20px;
        .el-pagination {
            display: inline-block;
        }
    }
}
</style>
<style lang="styl" src="@/styl/tip.scss"></style>
