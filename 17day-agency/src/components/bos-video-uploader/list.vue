<template>
<div class="bos-video-upload multiple">
    <ul class="file-list">
        <li v-for="file in fileList" class="file-item" :key="file.uuid">
            <div class="content">
                <div class="mask" v-if="file.status != 'ready'">
                    <div class="download-info" v-if="file.status == 'uploading'">
                        <span>
                                {{ speed | speedWithUnit }} {{ remains | remainsInString }}
                            </span>
                        <div v-if="file.progress >= 0">
                            {{ file.progress | percentage}}
                        </div>
                    </div>
                    <div class="status-desc" v-if="file.status == 'success' || file.status == 'fail'">
                        <span class="text-success" :class="{'text-danger' : file.status == 'fail'}">
                                {{$t('video.msg.textUpload')}}  {{ file.status == 'success' ? $t('video.msg.textFulfill') : $t('video.msg.textFail') }}
                            </span>
                        <br>
                        <span class="text-success delicon" @click="removeFile(file)">
                                {{$t('video.btn.delete')}}
                            </span>
                    </div>
                    <div class="progress-track" v-if="file.progress > 0 && file.status == 'uploading'">
                        <div class="progress" :style="{width: file.progress * 100 + '%'}"></div>
                    </div>
                </div>
            </div>
            <div class="file-info">
                <h5 class="filename">{{ file.name }}</h5>
                <div class="size">
                    {{$t('video.msg.size')}} {{ file.size | sizeWithUnit }}
                </div>
            </div>
        </li>
        <li class="file-selector-btn" @click="_triggerSelector" v-if="!hideAddVideo">
            <i class="file-selector-img"></i>
            <input type="file" ref="fileSelector" class="file-selector" @change="addFile($event)" :accept="accept" :multiple="!ifPlayBack" />
        </li>
    </ul>
</div>
</template>
<script type="text/ecmascript-6">
import Uploader from './uploader.js';
import utils from '@/js/utils';
import i18n from '@/i18n';
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
        },
        keyPrefix: {
            type: Number,
            required: true
        },
        bucket: {
            type: String
        },
        ifPlayBack: {
            type: Boolean
        }
    },
    data() {
        return {
            fileList: [],
            speed: 0,
            remains: 0
        }
    },

    filters: {
        percentage(progress) {
            return (progress * 100).toFixed(2) + '%';
        },
        sizeWithUnit(size) {
            return utils.sizeWithUnit(size, 1024, 2);
        },
        speedWithUnit(s) {
            return utils.sizeWithUnit(s, 1024, 2) + '/s';
        },
        remainsInString(remains) {
            //console.log(i18n.t('video.msg.hours'));
            if (remains > 3600 * 24) {
                remains = i18n.t('video.msg.timelong');
            } else if (remains > 3600) {
                var h = Math.floor(remains / 3600);
                var m = Math.round((remains % 3600) / 60);
                remains = h + i18n.t('video.msg.hours') + m + i18n.t('video.msg.minute');
            } else if (remains > 60) {
                remains = Math.floor(remains / 60) + i18n.t('video.msg.minute') + (remains % 60) + i18n.t('video.msg.second');
            } else {
                remains = remains + i18n.t('video.msg.second');
            }
            return remains;
        }
    },
    computed: {
        fileIdMap() {
            var map = {};
            this.fileList.forEach(file => map[file.uuid] = file);
            return map;
        },
        hideAddVideo() {
            return this.ifPlayBack && this.fileList.length == 1;
        }
    },
    mounted() {
        //this.fileList = [];

        this.uploader = new Uploader(this.keyPrefix, this.bucket);
        this.uploader.createClient();
        var time;
        var logProgress = utils.throttle((file, progress, timestamp) => {
            this.log(file, {
                ev: 'uploadProgress',
                speed: this.speed,
                progress: progress,
                timestamp: timestamp
            });
        }, 2000);
        this.uploader.on('filesAdded', (files) => {
            var file = createCustomFile(files.length ? files[0] : files);
            file.status = 'ready';
            this.fileList.push(file);
        }).on('uploadProgress', (file, progress) => {
            this.getFileById(file.uuid).progress = progress;
            logProgress(file, progress, +new Date);
        }).on('networkSpeed', (bytes, time, pendings) => {
            var speed = this.speed = bytes / (time / 1000);
            this.remains = Math.round(pendings / speed);
        }).on('beforeUpload', (file) => {
            this.getFileById(file.uuid).status = 'uploading';
            this.log(file, {
                ev: 'uploadStart'
            });
            time = +new Date();
        }).on('fileUploaded', (file, info) => {
            var f = this.getFileById(file.uuid);
            f.status = 'success';
            f.bosKey = info.body.key;
            this.$emit('fileUploaded', f);
            this.log(file, {
                ev: 'uploadSuccess'
            });
        }).on('error', (msg, status, file) => {
            if (file && file.uuid) {
                this.getFileById(file.uuid).status = 'error';
                this.log(file, {
                    ev: 'uploadFail'
                });
            }
        }).on('uploadComplete', () => {
            this.$emit('uploadComplete');
            utils.log({
                ev: 'uploadComplete',
                duration: +new Date() - time
            });
        });
        window.uploader = this.uploader;
    },
    methods: {
        _triggerSelector() {
            this.$refs.fileSelector.click();
        },
        addFile(e) {
            var files = e.target.files;
            if (files.length == 0) return;
            if (files.length) {
                Array.from(files).forEach(file => this.uploader.addFile(file));
            }
            this.uploader.start();
        },
        removeFile(file) {
            this.fileList.splice(this.fileList.indexOf(file), 1);
            if (file.media_id) {
                this.$emit('fileRemoved', file);
            }
        },
        getFileById(id) {
            return this.fileIdMap[id];
        },
        log: function(file, data) {
            utils.log(Object.assign({
                opType: 'videoUpload',
                file_id: file.uuid,
                file_key: file.bosKey,
            }, data));
        },
        clear() {
            this.fileList = [];
        }
    }
}

function createCustomFile(file) {
    var obj = {};
    var keys = ['name', 'size', 'uuid', 'type', 'lastModified'];
    keys.forEach(key => {
        if (file[key]) {
            obj[key] = file[key]
        }
    });
    return obj;
}
</script>
<style lang="stylus">
    .bos-video-upload
        margin-right -20px
        .file-list
            margin 0
            padding 0
            list-style none
            max-height 200px
            overflow-y auto
        .file-selector
            display none
        .file-item .content
        .file-selector-btn
            width 160px
            height 90px
            position relative
            background-color #f5f5f5
            border-radius 4px
        .file-selector-btn,
        .file-item
            margin-right 20px
            float left
        .file-item
            .content
                position relative
                background-image url(../../assets/images/videoIcon01.png)
                background-position center center
                background-repeat no-repeat
                text-align center
                .mask
                    position absolute
                    top 0
                    left 0
                    width 100%
                    height 100%
                    background rgba(0,0,0,.8)
                    color #fff
            .file-info
                font-size 12px
                margin 16px 0
                .filename
                    color #333
                    margin 0
                    max-width 160px
                    word-break break-all
                .size
                    color #999
                    margin-top 8px
        .file-selector-btn
            line-height 90px
            text-align center
        .file-selector-img
            display inline-block
            width 70px
            height 64px
            vertical-align middle
            background url(../../assets/images/upload-plus.png) 0 0 no-repeat
            cursor pointer
        .download-info
            margin-top 20px
        .status-desc
            line-height 26px
            margin-top 18px
        .progress-track
            position absolute
            bottom 20px
            background rgba(255,255,255, .5)
            width 80%
            height 6px
            left 10%
            .progress
                height 100%
                background #268fff
        .text-success
            color #30ce6b
        .text-danger
            color #ff1818
        .delicon
            cursor pointer
            margin-left 5px
            color #fff
            &:hover
              text-decoration underline
</style>
