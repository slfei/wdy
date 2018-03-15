<template>
<div class="upcon">
    <el-button @click="dialogFormVisible = true" class="btn-up">{{ $t('data.btn.upload-data') }}</el-button>
    <el-dialog :title="$t('data.title.dialog')" :visible.sync="dialogFormVisible" @close="removeFile" custom-class="w-dialog">
        <el-upload class="upload-demo" ref="upload" multiple :on-remove="handleRemove" action="/api/universal/uploadfile" :on-success="successUpload" :on-change="handleChange" :on-error="errorUpload" :auto-upload="false">
            <el-button slot="trigger" type="primary">{{ $t('data.btn.select-file') }}</el-button>
        </el-upload>
        <div slot="footer" class="dialog-footer footerOver">
            <i class="ion-information-circled icons"></i>
            <p class="intip">{{ $t('data.upload-tip') }}</p>
            <el-button @click="dialogFormVisible = false">{{ $t('data.btn.cancel') }}</el-button>
            <el-button type="primary" @click="submitUpload">{{ $t('data.btn.upload-confirm') }}</el-button>
        </div>
    </el-dialog>
</div>
</template>
<script>
import api from '@/utils/http'
import Vue from 'vue'
export default {
    data() {
        return {
            dialogFormVisible: false,
            errorFiles: [],
            errorUploadFiles: [],
            typeErrorFiles: []
        };
    },
    mounted() {

    },
    methods: {
        removeFile() {
            this.$refs.upload.clearFiles();
        },
        handleChange(file, filelist) {
            if (file.status == 'ready') {
                var isSizeLimit = file.size > 2 * 1024 * 1024 * 1024;
                if (isSizeLimit) {
                    this.$refs.upload.handleRemove(file);
                    this.errorFiles.push(file);
                    if (this.timer) clearTimeout(this.timer);
                    this.timer = setTimeout(function() {
                        this.showUploadErrorFiles(this.errorFiles, this.$t('data.tips.prompt-filesize-overflow'));
                    }.bind(this), 0);
                }
            }
        },
        handleRemove(file, fileList) {
            if (file.id) {
                api.delfile({
                        id: file.id
                    })
                    .then(res => {

                    });
            }
        },
        submitUpload() { // 上传
            this.$refs.upload.submit();
        },
        successUpload(response, file, fileList) { //上传
            if (response.status == '200') {
                Vue.set(file, 'id', response.data.id);
                this.$message.success(this.$t('data.tips.success-upload'));
            } else { //上传失败--格式错误
                file.status = 'fail';
                this.typeErrorFiles.push(file);
                if (this.timer) clearTimeout(this.timer);
                this.timer = setTimeout(function() {
                    this.showUploadErrorFiles(this.typeErrorFiles, this.$t('data.tips.prompt-filetype-error'));
                }.bind(this), 0);
            }
            var isAllSuccess = fileList.every(file => file.status === 'success');
            this.$emit('upload-success'); // 刷新列表
            if (isAllSuccess) {
                this.dialogFormVisible = false;
            } else {
                this.dialogFormVisible = true;
            }
        },
        errorUpload(err, file, fileList) { //上传失败
            fileList.push(file);
            this.errorUploadFiles.push(file);
            if (this.timer) clearTimeout(this.timer);
            this.timer = setTimeout(function() {
                this.showUploadErrorFiles(this.errorUploadFiles, this.$t('data.tips.error-upload'));
            }.bind(this), 0);
        },
        showUploadErrorFiles(errorList, msg) {
            if (errorList.length == 0) return;
            var files = errorList.map(f => f.name).join(',')
            this.$message.error(`“${files}“ ${msg}`);
            errorList = [];
            this.timer = null;
        }
    }
}
</script>
<style>
.upcon .el-upload-list {
    background-color: #f7f7f7;
    max-height: 200px;
    overflow: hidden;
    overflow-y: scroll;
    margin-top: 10px;
}

.upcon .el-upload-list li {
    padding: 0 15px;
}

.upcon .el-upload-list li:first-child {
    margin-top: 10px;
}

.upcon .el-upload-list li:last-child {
    margin-bottom: 10px;
}

.upcon .icons {
    float: left;
    color: #268fff;
    margin-right: 3px;
    margin-top: 2px;
}

.upcon .footerOver {
    padding-left: 20px;
}

.upcon .btn-up {
    background-color: transparent;
    border: 1px solid #268fff;
    color: #268fff;
}

.upcon .btn-up.el-button--primary span {
    color: #268fff;
}
</style>
