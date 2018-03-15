<template>
    <div class="teacherinfo-wrap">
        <h2 class="title">{{$t('marketing.teacher.title')}}</h2>
        <div class="cont">
            <el-form :model="teacherInfoFrom" ref="teacherInfoFrom" label-width="100px" class="w-demo-form">
                <el-form-item :label="$t('marketing.teacher.subject')">
                    <el-input class="w-input" v-model="teacherInfoFrom.person_type" :placeholder="$t('marketing.teacher.placeholder[0]')"></el-input>
                </el-form-item>
                <el-form-item :label="$t('marketing.teacher.school_age')">
                    <el-select class="w-select" v-model="teacherInfoFrom.school_age" :placeholder="$t('marketing.teacher.placeholder[1]')">
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item :label="$t('marketing.teacher.desc')" prop="desc" :rules="[{ min: 0, max: 200, message: $t('marketing.teacher.filter'), trigger: 'blur' }]">
                    <el-input
                        class="w-input"
                        type="textarea"
                        :rows="5"
                        :placeholder="$t('marketing.teacher.placeholder[2]')"
                        v-model="teacherInfoFrom.desc">
                    </el-input>
                </el-form-item>

            </el-form>

        </div>
    </div>
</template>
<script type="es6">
    import selectLayer from './PersonSelectLayer.vue'
    export default {
        name: 'teacher',
        props:{
            teacherInfo:{
                type:Array,
                default:function(){
                    return []
                }
            }
        },
        data() {
            return {
                options: [{
                  value: 0,
                  label: this.$t('marketing.teacher.age_options[0]')
                }, {
                  value: 1,
                  label: this.$t('marketing.teacher.age_options[1]')
                }, {
                  value: 2,
                  label: this.$t('marketing.teacher.age_options[2]')
                }, {
                  value: 3,
                  label: this.$t('marketing.teacher.age_options[3]')
                }, {
                  value: 4,
                  label: this.$t('marketing.teacher.age_options[4]')
                }],
                teacherInfoFrom:{
                    person_type: "", desc: "", school_age: ""
                }
            }
        },
        methods:{
            submitData(){
                this.$emit('getData',[0,this.teacherInfoFrom])
            },
            incrementTotal(){//在父组件验证表单
                let formName="teacherInfoFrom"
                this.$refs[formName].validate((valid) => {
                    if (valid) {
                        this.$emit('submitType',["teacher",true])
                    }else{
                        this.$emit('submitType',["teacher",false])
                        return false;
                    }
                });
            }
        },
        components: {
            selectLayer
        },
        watch:{
            teacherInfo:function(){
                if(this.teacherInfo.length>0){
                    for(let i in this.teacherInfo[0]){
                        this.teacherInfoFrom[i]=this.teacherInfo[0][i]
                    }
                }
            },
            teacherInfoFrom:{
                handler: function (val, oldVal) {
                    this.submitData()
                },
                deep: true
            }
        }
    }
</script>
<style lang="scss" scoped="" type="text/css">
    .teacherinfo-wrap{
        .title{
            font-size: 16px;
            color: #333;
            font-weight:inherit;
            padding:20px 0 25px;
            margin:0;

        }
        .cont{
            width: 500px;
        }
    }
</style>
