/**
 * @file overview imageUploader跟 element-ui form一起使用，表单验证处理
**/

export default {
    methods: {
        onImageSelectError(data) {
            let { target, message } = data;
            let parent = target.$parent;
            let parentName = parent.$options.componentName;
            while(parentName !== 'ElFormItem') {
                parent = parent.$parent;
                parentName = parent.$options.componentName;
            }
            if (parentName == 'ElFormItem') {
                parent.validateState = 'error';
                parent.validateMessage = message;
            }
        },

        onCustomError(data) {
            let { target, message } = data;
            let parent = target.$parent;
            let parentName = parent.$options.componentName;
            while(parentName !== 'ElFormItem') {
                parent = parent.$parent;
                parentName = parent.$options.componentName;
            }
            if (parentName == 'ElFormItem') {
                parent.validateState = 'error';
                parent.validateMessage = message;
            }
        },

        dispatchChangeForElItem(data) {
            let { target } = data;
            let parent = target.$parent;
            let parentName = parent.$options.componentName;
            while(parentName !== 'ElFormItem') {
                parent = parent.$parent;
                parentName = parent.$options.componentName;
            }
            if (parentName == 'ElFormItem') {
                parent.$emit('el.form.change');
            }
        }
    }
}
