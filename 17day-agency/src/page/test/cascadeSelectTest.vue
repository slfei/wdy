<template>
    <div class="test-bos-upload">
        <h1>级联选择框测试</h1>

        <cascade-select :data="data" v-model="model" value-key="category_id" label-key="name" child-key="_child" >
        </cascade-select>
    </div>
</template>
<script type="text/ecmascript-6">
    import CascadeSelect from '@/components/cascade-select/index';
    import api from '@/js/api/createCourse'
    export default {
    mounted(){
      this.getType();
    },
        components: {
            CascadeSelect
        },
        data () {
            return {
              data:null,
              model:'',

            }

        },
        methods: {
            getType(){
              api.getType().then(res=>{
                this.data = res.data.data;
                console.log(this.data)
            })
          }
        }
    }
</script>
