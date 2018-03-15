<template>
    <div class="test-bos-upload">
        <h1>BOS 视频上传测试</h1>
        <bos-uploader keyPrefix="18911732508" @fileUploaded="uploadMedia" @file-remove="onRemove">

        </bos-uploader>

        <single-bos-uploader></single-bos-uploader>
    </div>
</template>
<script type="text/ecmascript-6">
    import bosUploader from '@/components/bos-video-uploader/list.vue';
    import api from '@/js/api/video';
    import singleBosUploader from '@/components/bos-video-uploader/index.vue';

    export default {
        components: {
            bosUploader,
            singleBosUploader
        },

        methods: {
            uploadMedia(file) {
                return api.uploadMedia(file.bosKey, file.name)
                        .then(data => {
                            console.log(data);
                            //file.id = data.id;
                        });
            },

            onRemove(file) {
                console.log('remove file', file.name);
            },
        }
    }
</script>
