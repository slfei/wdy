<template>
    <div class="page-labels">
        <jui-header type="back">
            标签管理
            <div slot="right" @click="save">完成</div>
        </jui-header>

        <div class="labels-main has-header">
            <div class="section">
                <div class="section-hd">
                    <div class="hd-name">已选标签</div>
                    <span class="hd-name-desc">点击移除标签</span>
                </div>
                <div class="section-bd">
                    <div class="label-items">
                        <div v-for="(item, i) in tplData.my_label" class="btn btn-success"
                            @click="unChooseLabel(i)"
                        >
                            <span class="ion-android-close"></span>&nbsp;&nbsp;{{ item.lab_name }}
                        </div>
                    </div>
                </div>
            </div>


            <div class="section mt">
                <div class="section-hd">
                    <div class="hd-name">推荐标签</div>
                    <span class="hd-name-desc">点击添加标签</span>
                </div>
                <div class="section-bd">
                    <div class="label-row" v-for="(item, i) in tplData.all_label">
                        <div class="label-name" :class="'color-' + i">{{ item.lab_name }}</div>

                        <div class="label-items">
                            <div v-for="(_item, _i) in item.son_label"
                                 class=" btn btn-default"
                                @click="chooseLabel(i, _i)"
                                 v-if="!chosenHash[ _item.parent_id + '_' + _item.lab_id ]"
                            >
                                <span class="ion-plus-round"></span>&nbsp;&nbsp;{{ _item.lab_name }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script type="text/ecmascript-6">
    import JuiHeader from '../../components/Header.vue';
    import { Toast, Header } from 'mint-ui';
    import utils from '../../js/utils';
    import uc from '../../js/api';


    function chooseLabel(cateI, labelI) {
        if(this.tplData.my_label.length >= 5){
            return Toast('最多添加 5 个标签');
        }

        var item = this.tplData.all_label[cateI].son_label[labelI]

        this.tplData.my_label.push(item);
        this.chosenHash[ item.parent_id + '_' + item.lab_id ] = true;
    }


    function unChooseLabel(i) {
        var item = this.tplData.my_label.splice(i, 1)[0];
        this.chosenHash[ item.parent_id + '_' + item.lab_id ] = null;
        console.log(this.chosenHash);
    }


    function save() {
        var labels = this.tplData.my_label;
        var data = [];
        for(var i = 0, l = labels.length; i < l; i++){
            data.push(labels[i].lab_id);
        }

        uc.saveLabels(data).then(function (data) {
            Toast('标签保存成功');
            setTimeout(function () {
                if (window.isReactNative) {
                    window.postMessage(JSON.stringify({
                        action: 'goBack',
                        data: {}
                    }));
                    window.postMessage(JSON.stringify({
                        action: 'reloadHome',
                        data: {}
                    }));
                } else {
                    history.go(-1);
                }

            }, 1000);
        }, function (err) {
            Toast(err);
        })
    }


    export default {
        components: {
            JuiHeader,
            MtHeader: Header
        },
        data: function () {

            var chosenHash = {};
            for(var i = 0, l = $tplData.my_label.length; i < l; i++ ){
                var item = $tplData.my_label[i];
                chosenHash[ item.parent_id + '_' + item.lab_id ] = true;
            }

            return {
                tplData: $tplData,
                chosenHash: chosenHash
            }
        },
        created () {
            // from react-native
            window.document.addEventListener('message', (e) => {
                try {
                    var data = JSON.parse(e.data);
                    if (data.action === 'submit') {
                        this.save();
                    }
                } catch (e) {

                }
            });
        },
        methods: {
            chooseLabel,
            unChooseLabel,
            save
        }
    }
</script>


<style lang="stylus">
    .page-labels
        .ion-chevron-left
            padding 10px

        .mt
            margin-top 10px

        .section
            background #fff

        .section-hd
            overflow hidden
            padding 30px


            .hd-name
                float left
                color #333
                font-size 32px
                height 32px
                line-height 32px
                border-left 5px solid #f32e48
                padding 0 8px

            .hd-name-desc
                font-size 24px
                color #999


            .hd-more
                float right
                color #999
                font-size 28px

                i
                    position relative
                    top 1px


                &.highlight
                    color #E9314A
                    border 1px solid #E9314A
                    border-radius 50px
                    padding 0 20px


        .section-bd
            padding 0 30px
            overflow hidden


        .label-items
            margin-right -40px
            .btn
                margin-right 20px
                margin-bottom 20px


        .label-name
            font-size 32px
            margin 20px 0

        .label-row
            border-bottom 1px solid #E6E6E6


        .color-0
            color #E9314A
        .color-1
            color #9448FB
        .color-2
            color #FD9C4D
        .color-3
            color #E04EDE
        .color-4
            color #FE7854
        .color-5
            color #429AFD
        .color-6
            color #FE7854
        .color-7
            color #3CD69E
        .color-8
            color #429AFD
</style>
