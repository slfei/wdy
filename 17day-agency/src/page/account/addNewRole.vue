<template>
<div id="addNewRole">
    <div class="title" @click="back">
        <span class="el-icon-arrow-left "></span>{{$t('common.btn.return')}}
    </div>

    <el-form class="wraper"  label-width="118px" :model="content" :rules="contentRules" ref='content'>
        <el-form-item :label="$t('privilege.modify.role_name')" prop="role_name">
            <el-input v-model="content.role_name"></el-input>
        </el-form-item>
        <el-form-item :label="$t('privilege.modify.role_desc')" prop="role_desc">
            <el-input type="textarea" v-model="content.role_desc"></el-input>
        </el-form-item>

        <el-form-item :label="$t('privilege.modify.role_permission')" style="width:1020px;" prop="list">
            <el-checkbox-group  v-model="content.list" class="w-checkbox-group">
                <div class="table" v-for="(item,index) in content.checkList" v-bind:class="[item.son.length<2 ? 'w':'']">
                    <h3>{{item.title}}</h3>
                    <dl v-for="val in item.son">
                        <dt>
                             <el-checkbox :label=val.id  v-show="val.id"  name="list">
                                {{val.title}}
                             </el-checkbox>
                        </dt>
                        <dd  v-for="(arr,index) in val.son">
                           <el-checkbox :label=arr.id  v-show="arr.id"   name="list">
                                {{arr.title}}
                           </el-checkbox>
                        </dd>
                    </dl>
                </div>
            </el-checkbox-group>
        </el-form-item>
        <!--<span>{{content.list}}</span>-->
         <div class="btns">
                <el-button type="primary" @click="submitForm('content')" classs="w-button">{{$t('common.btn.save')}}</el-button>
                <el-button @click="cancel">{{$t('common.btn.cancel')}}</el-button>
         </div>
    </el-form>

</div>
</template>

<script>
    import * as api from '@/js/api'
    export default{
        name:"addNewRole",
        data(){
            return {
                contentRules:{
                    role_name:[{required: true, message:  this.$t('privilege.filter.name[0]'), trigger: 'blur' },
                                { max:20, message: this.$t('privilege.filter.name[1]'), trigger: 'change,blur' }
                    ],
                    role_desc:[{required: true, message: this.$t('privilege.filter.desc[0]'), trigger: 'blur' },
                               { max:200, message: this.$t('privilege.filter.desc[1]'), trigger: 'change' }
                    ],
                    "list":[{required: true, message: this.$t('privilege.filter.permission'), trigger: 'change',type:"array" }]
                },
                content:{   //内容对象
                    list:[],
                    role_name:"",
                    role_desc:"",
                    checkList:[]
                  }
            }

        },
        methods:{
            initData(){
                api.roleSet.addNewRole().then(res=>{
                    //console.log(res.data)
                    this.content.checkList=res.data.access_list
                })
            },
            submitForm(addForm) {
                this.$refs[addForm].validate((valid) => {
                    if (valid) {
                        var obj={
                            role_name:this.content.role_name,
                            role_desc:this.content.role_desc,
                            access_ids:this.content.list
                        }
                        api.roleSet.addNewRoleSuc(obj).then(res=>{
                            //console.log("提交新增的数据")
                            if(res.status==200){
                                this.$message({
                                   type: 'success',
                                   message: this.$t('privilege.tips.success')
                                })
                                this.back()
                            }else{
                                this.$message({
                                    type: 'warning',
                                    message: this.$t('privilege.tips.fail')
                                });
                            }
                        });
                    } else {
                        console.log('error submit!!');
                        return false;
                    }
                });
            },
            cancel(){
                this.$confirm(this.$t('privilege.confirm.cont.cancel'), this.$t('privilege.confirm.title'), {
                    cancelButtonText: this.$t('common.btn.cancel'),
                    confirmButtonText: this.$t('common.btn.ok'),
                    type: 'warning',
                    customClass:"cancel"
                }).then(() => {
                    this.back()
                }).catch(()=>{

                })
            },
            back(){
                this.$router.go(-1)
            },
        },
        created(){
            this.initData()
        },
        watch:{
            "content.list"(val,old){
                this.content.list=val;
            }

        }
    }
</script>

<style  lang="scss">
#addNewRole{
    .title{
        width: 50px;
        color: #268fff;
        font-size: 12px;
        margin-bottom: 20px;
        margin-top:20px;
        cursor: pointer;
        span.el-icon-arrow-left{
            font-size: 16px !important;
            transform: scale(0.5);
            color:#268FFF;
            vertical-align: middle;
        }
    }
    .w{
        width: 135px !important;
    }
    .btns{
        width:1057px;
        display: flex;
        align-items: center;
        justify-content: center;
        button{
            margin-right: 10px;
        }
    }
    .wraper{
        width: 520px;
        .el-form-item__label{
            font-size: 12px !important;
        }
    }
    .el-input,.el-textarea{
        width: 400px !important;
    }
    .table{
        width: 270px;
        float: left;
        vertical-align: middle;
        h3{
            text-align: center;
            width: 100%;
            border: 1px solid #d9d9d9;
            border-right: none;
            border-bottom: none;
            height: 50px;
            line-height: 50px;
            font-size: 14px;
            margin: 0;
        };
        dl{
            float: left;
            text-align: center;
            width: 135px;
            border: 1px solid #d9d9d9;
            border-right-width: 0;
            border-left-width: 0;
            margin: 0;
            dt,dd{
                border: 1px solid #d9d9d9;
                border-right-width: 0;
                border-bottom-width: 0;
                height: 40px;
                margin: 0;
            }
            dt{
                border-top: none;
            }
        }

    }
    .table:last-child{
        dl:last-child{
            border-right-width: 1px;}
        h3{
            border-right: 1px solid #d9d9d9;
        }
    }
}
</style>
<style lang="scss" src="@/styl/tip.scss"></style>
