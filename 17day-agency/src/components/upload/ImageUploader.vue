<template>
<div class="single-image-uploader">
    <div class="siu-wrapper">
        <div class="siu-input" @click="triggerInput()">
            <div v-if="value" class="img-preview">
                <img :src="value" alt="">
                <div class="mask">
                    {{$t('applicationPerson.btn.reUpload')}}
                </div>
            </div>
            <div v-else>
                <i class="el-icon-plus"></i>
                <div class="text">{{$t('applicationPerson.btn.uploadImg')}}</div>
            </div>

            <input type="file" class="file-input" @change="onChange($event)" :accept="accept">
        </div>
        <div class="siu-desc">
            <slot name="desc"></slot>
        </div>
    </div>
</div>
</template>

<style lang="stylus" scoped>
.single-image-uploader
    .file-input
        display none
    .siu-desc
        float left
        line-height 18px
        color #999
        max-width 400px

    .siu-input
        float left
        margin-right 20px
        min-width 160px
        max-width 240px
        height 95px
        background #f4f4f4
        text-align center
        color #bababa
        font-size 12px
        line-height 12px
        position relative
        border 1px solid #f4f4f4

        .mask
            display none
            width 100%
            height 100%
            position absolute
            top 0
            z-index 100
            background rgba(0,0,0,.4)
            color #fff
            line-height 95px

        .img-preview:hover
            .mask
                display block

        img
            height 95px
            max-width 100%

        i
            font-size 24px
            margin-top 25px
            margin-bottom 10px


.is-error
    .single-image-uploader
        .siu-input
            border 1px solid #ff4949
</style>

<script>
import api from '@/js/api/common'
import utils from '@/js/utils'
export default {
    props: {
        value: {
            type: String | Array,
            required: true
        },
        sizeMax: {
            type: Number,
            default: 20 << 20,
        },
        sizeMin: {
            type: Number,
            default: 0
        },
        accept: {
            type: String,
            default: 'image/jpeg, image/jpg, image/gif, image/png, image/bmp'
        }
    },

    methods: {
        triggerInput(e) {
            var ipt = this.$el.querySelector('.file-input')
            ipt.click()
        },
        onChange(e) {
            const files = e.target.files;
            if (files && files[0] && this.validate(files[0])) {
                this.src = URL.createObjectURL(files[0])
                api.uploadImage(files[0], function(e) {
                        console.log(e)
                    })
                    .then(data => {
                        this.$emit('input', data.url);
                        this.$emit('change', {
                            target: this,
                            value: data.url
                        });
                    });
            }
        },
        validate(file) {
            if (file.size > this.sizeMax) {
                this.$emit('error', {
                    message: `图片不能大于${ utils.sizeWithUnit(this.sizeMax) }`,
                    target: this
                });
                return false;
            } else if (file.size < this.sizeMin) {
                this.$emit('error', {
                    message: `图片不能小于${ utils.sizeWithUnit(this.sizeMin) }`,
                    target: this
                });
                return false;
            }

            return true;
        }
    }
}
</script>
