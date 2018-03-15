
<template>
<div class="bce-video-upload">
    <div class="file-selector-btn" @click="_click">
        <slot name="button">
            <i class="el-icon-plus"></i>
        </slot>
    </div>
    <input type="file" class="file-selector" :accept="accept" ref="fileSelector" @change="_selectFile" />
    <div class="mask" v-show="file.name">
        <video preload="meta" :src="fileUrl" ref="video" v-show="fileUrl" :poster="videoPoster">
            </video>
        <div class="upload-stat" v-if="status">
            <div class="blur-bg"></div>
            <div class="content">
                <el-progress type="circle" :percentage="Math.floor(progress * 100)" :width="60" :stroke-width="3" :status="progressStatus"></el-progress>
                <div class="speed" style="height: 36px">
                    下载速度：{{speed}}<br/>
                    <span v-if="remains">剩余时间：{{ remainsInString }}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="file-info" v-if="file.name">
        <h4>{{ file.name }}</h4>
        <p>{{ fileSize }}</p>
    </div>
</div>
</template>
<script>
import Uploader from './uploader.js';
import utils from '@/js/utils';
export default {
    props: {
        accept: {
            type: String,
            default: '.mp4,.flv,.mov,.rmvb,.wmv,.avi,.ts,.swf,.mpg,.mpeg'
        },
        max: {
            type: Number
        },
        min: {
            type: Number,
            default: 0
        }
    },

    data() {
        return {
            file: {},
            fileUrl: '',
            progress: 0,
            speed: 0,
            remains: 0,
            status: '',
            videoError: '',
            poster: 'http://17dayup-dev.bj.bcebos.com/ugc/2017101313563359e05591dc5a8.jpg'
        }
    },

    computed: {
        progressStatus() {
            var map = {
                success: 'success',
                error: 'exception'
            };
            return map[this.status] || '';
        },
        remainsInString() {
            var remains = this.remains;
            if (remains > 3600 * 24) {
                remains = "大于1天";
            } else if (remains > 3600) {
                var h = Math.floor(remains / 3600);
                var m = Math.round((remains % 3600) / 60);
                remains = h + '小时' + m + '分钟';
            } else if (remains > 60) {
                remains = (remains / 60) + '分钟' + (remains % 60) + '秒';
            } else {
                remains = remains + '秒';
            }
            return remains;
        },
        fileSize() {
            return utils.sizeWithUnit(this.file.size, 1024, 2);
        },
        videoPoster() {
            var poster = this.videoError ? this.poster : '';
            console.log(poster);
            return poster;
        }
    },

    mounted() {
        this.uploader = new Uploader();
        this.uploader.createClient();
        this.uploader.on('filesAdded', (files) => {
            this.file = files[0];
            console.log(this.file);
            this.fileUrl = URL.createObjectURL(this.file);
        });
        this.uploader.on('uploadProgress', (file, progress) => {
            this.progress = progress;
        });
        this.uploader.on('networkSpeed', (bytes, time, pendings) => {
            var speed = bytes / (time / 1000);
            this.speed = utils.sizeWithUnit(speed, 1024, 2) + "/s";
            this.remains = Math.round(pendings / speed);

        }).on('beforeUpload', () => {
            this.status = 'uploading';
        }).on('fileUploaded', () => {
            this.status = 'success';
        }).on('error', function() {
            this.staus = 'error';
        });
        this.videoEvent();
    },

    methods: {
        _click() {
            this.$refs.fileSelector.click()
        },
        _selectFile(e) {
            var files = e.target.files;
            if (files.length == 0) return;
            var file = files[0];
            this.uploader.addFile(files[0]);
            this.start();
        },

        start() {
            this.uploader.start();
        },
        _validFile(file) {
            if (file.size > this.max) {
                return false;
            } else if (file.size < this.min) {
                return false;
            }

            return true;
        },
        videoEvent() {
            var video = this.$refs.video;
            video.addEventListener('canplay', () => {
                console.log('meta', );
                this.videoError = '';
            });
            video.addEventListener('error', (err) => {
                this.videoError = video.error;
            });
            console.log(this.$refs.video);
        }
    }
}
</script>
<style lang="styl">
    .bce-video-upload
        position relative
        display inline-block
        width 160px
        height 160px
        text-align center
        font-size 16px
        .file-selector-btn
            border 1px solid #d4d4d4
            width 100%
            height 100%
            line-height 160px
            font-size 30px
            color #666
        .file-info
            font-size 12px
            text-align left
        .file-selector
            display none
        .mask
            position absolute
            top 0
            left 0
            width 100%
            height 100%
            background rgba(0,0,0,.7)
            overflow hidden
            .el-progress
                margin-top 10px
            video, .upload-stat
                width 100%
                height 100%
            .upload-stat
                position absolute
                top 0
                left 0
                color #fff
                font-size 12px
                z-index 1
                .content
                    margin-top 50%
                    transform translateY(-50%)
                .blur-bg
                    position absolute
                    top 0
                    left 0
                    width 100%
                    height 100%
                    background rgba(55,55,55,.9)
                    /*filter blur(3px)*/
                    z-index -1
        .el-progress-circle__track
            stroke #fff
        .el-progress-circle__path
            stroke #268fff
        .is-success .el-progress-circle__path
            stroke #13ce66
</style>
