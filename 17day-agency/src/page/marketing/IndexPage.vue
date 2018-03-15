<template>
    <div>
        <div v-if="type==1">
            <teacher-index></teacher-index>
        </div>
        <div v-else-if="type==2">
            <person-setting></person-setting>
        </div>
    </div>
</template>
<script type="text/ecmascript-6">
    import personSetting from './PersonSetting.vue'
    import teacherIndex from './TeacherIndex.vue'
    import * as api from '@/js/api'
    export default{
        data(){
            return {
                type:""
            }
        },
        created(){
            this.getData()
        },
        methods:{
            getData(){
                api.common.checkCurrenttype().then(res=>{
                    if(res.status==200){
                        this.type=res.data.type
                    }
                })
            }
        },
        components: {
            personSetting,
            teacherIndex
        }
    }
</script>
<style>
    .tips-blue{
        text-align: center;
        color: #268fff;
        font-size: 20px;
        line-height: 410px;
        position: relative;
        left: -80px;
    }
</style>
