<template>
	<div class="wangeditor"></div>
</template>
<script>
import E from 'wangeditor'
export default{
	mounted () {
	    let editor = this.editor = new E(this.$el);
	    editor.customConfig.onchange = (html) => {
	      //this.value = html;
	      this.$emit('input', html);
	    }
        editor.customConfig.zIndex = 100 ;
        if (this.value) {
        	editor.txt.html(this.value);
        }
	    editor.create();
  	},
  	props:{
  		value:{
  			type: String,
  			default: ''
  		}
  	},
  	methods: {
  		setContent(html)
	  		this.editor.txt.html(html);
	  	}
  	}
}
</script>
<style scoped>
.wangeditor{
	width: 700px;
}
</style>
