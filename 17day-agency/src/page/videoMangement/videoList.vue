<template>
<div class="video-list-data">
    <el-dialog :title="uploadTitle" :visible.sync="dialogClassifyVisible" @close="removeFile" :before-close="handleClose" custom-class="w-dialog w-dialog-regular">
        <div class="uploadStep1 max-con-height" v-if="uploadStep==1">
            <div class="classify-con" v-if="this.activeName=='first'">
                <div class="label-classify">{{$t('video.text.belongTo')}}</div>
                <div class="select-con">
                    <el-select v-model="selectedVal" :placeholder="$t('video.placeholder.select')" @change="changeValue(selectedVal)" class="w-select">
                        <el-option v-for="item in AlbumNameList" :key="item.id" :label="item.name" :value="item.id">
                        </el-option>
                        <div class="add-classification">
                            <div v-if="!addClassifyBtn">
                                <el-button type="text" class="btn-add" @click="showAddAlbum">{{$t('video.btn.addClassify')}}</el-button>
                            </div>
                            <div class="add-box" v-if="addClassifyBtn">
                                <el-input :placeholder="$t('video.placeholder.inputAdd')" class="editclassify" v-model="albumName"></el-input>
                                <el-button type="text" @click="addAlbum">{{$t('video.btn.ok')}}</el-button>
                                <el-button type="text" @click="cancelAdd">{{$t('video.btn.cancel')}}</el-button>
                            </div>
                        </div>
                    </el-select>
                </div>
            </div>
            <div class="classify-con" v-if="this.activeName=='second'">
                <div class="label-classify">{{$t('video.text.bindCourse')}}</div>
                <div class="select-con">
                    <div class="w-select">
                        <el-cascader :placeholder="$t('video.placeholder.select')" class="w-cascader" :options="courseNameList" v-model="selectedOptions" @change="handleChange">
                        </el-cascader>
                    </div>
                </div>
            </div>
            <div slot="footer" class="dialog-footer footerBtn foot-move" v-if="ifFromMove">
                <el-button @click="closeUploadModel">{{$t('video.btn.cancel')}}</el-button>
                <el-button type="primary" @click="moveToAlbum">{{$t('video.btn.ok')}}</el-button>
            </div>
        </div>
        <div class="uploadStep2 max-con-height" v-if="uploadStep==2">
            <div class="header-upload" v-if="this.activeName=='first'">{{$t('video.text.belongTo')}}<span>{{videoClassificationName}}</span></div>
            <div class="header-upload" v-if="this.activeName=='second'">{{$t('video.text.bindCourse')}}<span>{{playBackName}}</span></div>
            <div class="model-upload">
                <bos-uploader v-bind:ifPlayBack="ifPlayBack" v-bind:keyPrefix="instituteId" @fileUploaded="uploadMedia" @fileRemoved="onRemove" ref="bosUploader">
                </bos-uploader>
            </div>
            <div slot="footer" class="dialog-footer footerBtn" v-if="this.activeName=='first'">
                <el-button @click="cancelUploadModel" :disabled="VideoIdList.length>0">{{$t('video.btn.cancel')}}</el-button>
                <el-button type="primary" @click="saveUpload" :disabled="VideoIdList.length==0">{{$t('video.btn.confirmUpload')}}</el-button>
            </div>
            <div slot="footer" class="dialog-footer footerBtn" v-if="this.activeName=='second'">
                <el-button type="primary" @click="cancelUploadModel">{{$t('video.btn.ok')}}</el-button>
            </div>
        </div>
    </el-dialog>
    <el-row :gutter="20">
        <el-col :span="6">
            <div class="grid-content box-up">
                <div class="upvideo">
                    <el-button type="primary" @click="modelShow" class="btn-up">{{$t('video.btn.paneUploadVideo')}}</el-button>
                </div>
            </div>
        </el-col>
        <el-col :span="4" :offset="5">
            <div class="grid-content labelcontrol">
                <el-checkbox v-model="checked" @change="searchMyData" class="w-checkbox">{{$t('video.text.myUpload')}}</el-checkbox>
            </div>
        </el-col>
        <el-col :span="6">
            <div class="grid-content">
                <el-input v-model="filename" :placeholder="$t('video.placeholder.inputSearch')" @keyup.13.native="searchData" class="w-input"></el-input>
            </div>
        </el-col>
        <el-col :span="3">
            <div class="grid-content btnsearch">
                <el-button type="primary" @click="searchData()">{{$t('video.btn.search')}}</el-button>
            </div>
        </el-col>
    </el-row>
    <el-tabs v-model="activeName" @tab-click="handleClick" class="w-tabs">
        <el-tab-pane :label="$t('video.tabs.titleRecord')" name="first"></el-tab-pane>
        <el-tab-pane :label="$t('video.tabs.titleLive')" name="second"></el-tab-pane>
    </el-tabs>
    <div class="block-albums" v-if="!isSearchData&&this.activeName=='first'">
        <div class="data-box">
            <div class="table-head">
                <span class="name-album">{{$t('video.table.fileInfo')}}</span>
                <span class="num-album">{{$t('video.table.count')}}</span>
                <span class="author-album">{{$t('video.table.author')}}</span>
                <span class="status-album">{{$t('video.table.status')}}</span>
                <span class="operation-album">{{$t('video.table.operation')}}</span>
            </div>
            <ul class="video-list">
                <li v-for="item in albumListData">
                    <div class="category" @click="getVideoList(item)">
                        <div class="name-album">
                            <div class="nameicon-block">
                                <img class="icon-folder" src="../../assets/images/icon-folder.png">
                                <div class="editname-block">
                                    <span v-if="item.id != editIndex" class="nameAlbum">{{item.name}}</span>
                                    <input class="edit-input" v-if="item.id == editIndex" v-model="item.temp_name" @blur="saveFileName(item)" maxlength="50">
                                    <span class="ion-ios-compose-outline iconcolor" v-if="item.operation==1" @click="editName(item,$event)"></span>
                                </div>
                            </div>
                            <span class="video-time name-video-time">{{$t('video.text.videoTime')}} {{item.time}}</span>
                        </div>
                        <div class="line-all num-album">{{item.class_num}}</div>
                        <div class="line-all author-album">{{item.author?item.author:'--'}}</div>
                        <div class="all-status line-all status-album">
                            <div>{{item.status?item.status:'--'}}</div>
                        </div>
                        <div class="btn-group operation-album">
                            <el-button type="text" @click="uploadToAlbum(item)" class="upload-btn">{{$t('video.btn.paneUploadVideo')}}</el-button>
                            <el-button type="text" @click="deleteAlbum(item.id)" v-if="item.operation==1">{{$t('video.btn.delete')}}</el-button>
                        </div>
                    </div>
                    <ul class="children" v-if="item.showChildData">
                        <li v-for="s in item.videoListData">
                            <div>
                                <div class="videoname-block">
                                    <div class="playicon-block">
                                        <span class="gray">一</span>
                                        <img class="playicon" src="../../assets/images/icon-play.png">
                                    </div>
                                    <div class="editvideo-block">
                                        <span v-if="s.id != editChildrenIndex">{{s.name}}</span>
                                        <input class="editname-input" type="text" v-model="s.temp_name" v-if="s.id == editChildrenIndex" @blur="saveChildrenFileName(s)" maxlength="50">
                                        <span class="ion-ios-compose-outline iconcolor" @click="editChildrenFileName(s)" v-if="s.operation==1"></span>
                                    </div>
                                </div>
                                <span class="video-time">{{$t('video.text.videoTime')}} {{s.time}}</span>
                            </div>
                            <div class="line-height-control">{{s.author?s.author:'--'}}</div>
                            <div class="line-height-control" :class="[{nopass:(s.code==4)},{notranscode:(s.code==6)}]">
                                <span>{{s.status?s.status:'--'}}</span>
                                <br>
                                <span v-if="s.code==6" class="reupload">{{$t('video.text.tipError')}}</span>
                                <span class="no-pass" v-if="s.code==4" @click="checkOpinion(s.reason)">{{$t('video.btn.checkOpinion')}}</span>
                            </div>
                            <div v-if="s.operation==1" class="btn-group btn-over">
                                <div class="btn-show-control">
                                    <el-button v-if="s.code!=6" type="text" @click="moveAlbum(s.id)" class="upload-btn">{{$t('video.btn.moveToAlbum')}}</el-button>
                                </div>
                                <div>
                                    <el-button type="text" @click="delChildrenFile(item,s.id)">{{$t('video.btn.delete')}}</el-button>
                                </div>
                            </div>
                        </li>
                        <div class="block childrenPagination" v-if="item.videoListData && item.videoTotal>4" style="margin:20px 0">
                            <el-pagination @current-change="handleCurrentChangeVideo(item)" :current-page.sync="item.page_num" :page-size="4" layout="prev, pager, next" :total="item.videoTotal" class="w-pagination">
                            </el-pagination>
                        </div>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="block" v-if="albumListData.length>0">
            <el-pagination @current-change="handleCurrentChangeAlbum" :current-page.sync="albumFilter.page_num" :page-size="4" layout="prev, pager, next" :total="albumTotal" class="w-pagination">
            </el-pagination>
        </div>
    </div>
    <div class="block-albums" v-if="!isSearchData&&this.activeName=='second'">
        <div class="data-box">
            <div class="table-head">
                <span class="name-album">{{$t('video.table.fileInfo')}}</span>
                <span class="num-album">{{$t('video.table.count')}}</span>
                <span class="author-album">{{$t('video.table.author')}}</span>
                <span class="status-album">{{$t('video.table.status')}}</span>
                <span class="operation-album">{{$t('video.table.operation')}}</span>
            </div>
            <ul class="video-list">
                <li v-for="item in courseList">
                    <div class="category" @click="getPlayBackList(item)">
                        <div class="name-album">
                            <div class="nameicon-block">
                                <img class="icon-folder" src="../../assets/images/icon-folder.png">
                                <div class="editname-block">
                                    <span class="nameAlbum">{{item.course_name}}</span>
                                </div>
                            </div>
                            <span class="video-time name-video-time">{{$t('video.text.videoTime')}} {{item.total_time}}</span>
                        </div>
                        <div class="line-all num-album">{{item.count}}</div>
                        <div class="line-all author-album">--</div>
                        <div class="all-status line-all status-album">--</div>
                        <div class="all-status line-all status-album course-operation">--</div>
                    </div>
                    <ul class="children" v-if="item.ifShowPlayBackList">
                        <li v-for="s in item.playBackList">
                            <div>
                                <div class="videoname-block">
                                    <div class="playicon-block">
                                        <span class="gray">一</span>
                                        <img v-if="s.media_id!=0" class="playicon" src="../../assets/images/icon-play.png">
                                    </div>
                                    <div class="editvideo-block">
                                        <span>{{s.name}}</span>
                                    </div>
                                </div>
                                <span class="video-time">{{$t('video.text.videoTime')}} {{s.timelong}}</span>
                            </div>
                            <div class="line-height-control">{{s.author?s.author:'--'}}</div>
                            <div class="line-height-control" :class="{nopass:(s.code==4)}">
                                {{s.status?s.status:'--'}}
                                <span v-if="s.code==6" class="reupload">{{$t('video.text.tipError')}}</span>
                                <span class="no-pass" v-if="s.code==4" @click="checkOpinion(s.reason)">{{$t('video.btn.checkOpinion')}}</span>
                            </div>
                            <div class="btn-group btn-over btn-playback">
                                <el-button v-if="s.media_id==0" type="text" @click="singleUpload(item,s)">{{$t('video.btn.paneUploadVideo')}}</el-button>
                                <el-button v-if="s.operation==1&&s.media_id>0" type="text" @click="delPlayBackFile(item,item.course_id,s.media_id)">{{$t('video.btn.delete')}}</el-button>
                            </div>
                        </li>
                        <div class="block childrenPagination" v-if="item.playBackList && item.backTotal>1" style="margin:20px 0">
                            <el-pagination @current-change="handleCurrentChangePlayBack(item)" :current-page.sync="item.page_num" :page-size="playBackFilter.page_size" layout="prev, pager, next" :total="item.backTotal" class="w-pagination">
                            </el-pagination>
                        </div>
                    </ul>
                </li>
                <p v-if="courseList.length==0" class="nodata">{{$t('video.text.noData')}}</p>
            </ul>
        </div>

        <div class="block" v-if="courseList.length>0">
            <el-pagination @current-change="handleCurrentChangeCourse" :current-page.sync="courseFilter.page_num" :page-size="courseFilter.page_size" layout="prev, pager, next" :total="courseTotal" class="w-pagination">
            </el-pagination>
        </div>
    </div>
    <div class="block-search-data" v-if="isSearchData&&this.activeName=='first'">
        <div class="data-box">
            <div class="table-head">
                <span class="info-album">{{$t('video.table.fileInfo')}}</span>
                <span>{{$t('video.table.belongTo')}}</span>
                <span>{{$t('video.table.author')}}</span>
                <span>{{$t('video.table.status')}}</span>
                <span>{{$t('video.table.operation')}}</span>
            </div>
            <ul class="search-data-list children singleVideo">
                <li v-for="s in searchVideoData" class="li-video">
                    <div class="info-block">
                        <div class="infovideo-block">
                            <div class="infoicon-block">
                                <span class="gray">一</span>
                                <img class="playicon" src="../../assets/images/icon-play.png">
                            </div>
                            <div class="infoedit-block">
                                <span v-if="s.id != editChildrenIndex">{{s.name}}</span>
                                <input type="text" v-model="s.temp_name" v-if="s.id == editChildrenIndex" @blur="saveChildrenFileName(s)" class="infoedit" maxlength="50">
                                <span class="ion-ios-compose-outline iconcolor" @click="editChildrenFileName(s)" v-if="s.operation==1"></span>
                            </div>
                        </div>
                        <span class="video-time">{{$t('video.text.videoTime')}} {{s.time}}</span>
                    </div>
                    <div class="line-height-control">{{s.album_name?s.album_name:$t('video.text.defaultCategory')}}</div>
                    <div class="line-height-control">{{s.author?s.author:'--'}}</div>
                    <div class="line-height-control" :class="[{nopass:(s.code==4)},{notranscode:(s.code==6)}]">
                        {{s.status?s.status:'--'}}
                        <br>
                        <span v-if="s.code==6" class="reupload">{{$t('video.text.tipError')}}</span>
                        <span class="no-pass" v-if="s.code==4" @click="checkOpinion(s.reason)">{{$t('video.btn.checkOpinion')}}</span>
                    </div>
                    <div v-if="s.operation==1" class="">
                        <el-button v-if="s.code!=6" type="text" @click="moveAlbum(s.id)">{{$t('video.btn.moveToAlbum')}}</el-button>
                        <el-button type="text" @click="delvideoFile(s.id)">{{$t('video.btn.delete')}}</el-button>
                    </div>
                </li>
            </ul>
            <p v-if="searchVideoData.length==0" class="nodata">{{$t('video.text.noData')}}</p>
        </div>
        <div class="block" v-if="searchVideoData && searchVideoData.length>0">
            <el-pagination @current-change="handleCurrentChangeSearchBlock" :current-page.sync="videoFilter.page_num" :page-size="4" layout="prev, pager, next" :total="searchListTotal" class="w-pagination">
            </el-pagination>
        </div>
    </div>
    <div class="block-search-data" v-if="isSearchData&&this.activeName=='second'">
        <div class="data-box">
            <div class="table-head">
                <span class="info-album">{{$t('video.table.fileInfo')}}</span>
                <span>{{$t('video.table.author')}}</span>
                <span>{{$t('video.table.status')}}</span>
                <span>{{$t('video.table.operation')}}</span>
            </div>
            <ul class="search-data-list children singleVideo">
                <li v-for="s in searchPlayBackData" class="li-video">
                    <div class="info-block">
                        <div class="infovideo-block">
                            <div class="infoicon-block">
                                <span class="gray">一</span>
                                <img v-if="s.media_id!=0" class="playicon" src="../../assets/images/icon-play.png">
                            </div>
                            <div class="infoedit-block">
                                <span>{{s.name}}</span>
                            </div>
                        </div>
                        <span class="video-time">{{$t('video.text.videoTime')}} {{s.timelong}}</span>
                    </div>
                    <div class="line-height-control">{{s.author?s.author:'--'}}</div>
                    <div class="line-height-control" :class="{nopass:(s.code==4)}">
                        {{s.status?s.status:'--'}}
                        <span v-if="s.code==6" class="reupload">{{$t('video.text.tipError')}}</span>
                        <span class="no-pass" v-if="s.code==4" @click="checkOpinion(s.reason)">{{$t('video.btn.checkOpinion')}}</span>
                    </div>
                    <div v-if="s.operation==1" class="">
                        <el-button type="text" v-if="s.operation==1&&s.media_id>0" @click="singleDelPlayBackFile(s.media_id)">{{$t('video.btn.delete')}}</el-button>
                    </div>
                    <el-button v-if="s.media_id==0" type="text" @click="uploadModalHandle(s)">{{$t('video.btn.paneUploadVideo')}}</el-button>
                </li>
            </ul>
            <p v-if="searchPlayBackData.length==0" class="nodata">{{$t('video.text.noData')}}</p>
        </div>
        <div class="block" v-if="searchPlayBackData && searchPlayBackData.length>0">
            <el-pagination @current-change="handleCurrentChangeSearchPlayBack" :current-page.sync="playBackFilter.page_num" :page-size="playBackFilter.page_size" layout="prev, pager, next" :total="searchPlayBackListTotal" class="w-pagination">
            </el-pagination>
        </div>
    </div>
</div>
</template>
<script>
import Vue from 'vue'
import utils from '@/js/utils'
import bosUploader from '@/components/bos-video-uploader/list.vue';
import '@/lib/jquery.min.js';
import '@/lib/bce-bos-uploader-lite.min.js';
import apiUp from '@/js/api/video';
import videoApi from '@/utils/videoServer'
//const Uploader = baidubce.sdk.Uploader;
export default {
    components: {
        bosUploader
    },
    data() {
        return {
            activeName: 'first',
            ifPlayBack: false,
            instituteId: 0, //机构ID
            checked: false,
            albumListData: [], //视频合辑列表
            courseList: [], //回放列表
            editIndex: -1,
            editChildrenIndex: -1,
            albumTotal: 0,
            videoTotal: 0,
            filename: '',
            albumFilter: { // 合辑 params
                page_size: 4,
                page_num: 1
            },
            courseFilter: { // 直播回放课程
                page_size: 4,
                page_num: 1
            },
            videoFilter: { // 合辑下列表 params
                page_size: 4,
                page_num: 1,
                myupload: 0,
                filename: '',
                albumid: ''
            },
            playBackFilter: { // 直播回放课时
                page_size: 4,
                page_num: 1,
                myupload: 0,
                filename: '',
                course_id: ''
            },
            dialogClassifyVisible: false, // model 是否显示
            AlbumNameList: [], // 合辑name
            videoClassificationName: '', //上传所属分类
            transAlbumID: '',
            ifFromMove: false,
            selectedAlbumId: '',
            toMoveVideoId: [],
            isSearchData: false,
            searchVideoData: [], //录播
            searchPlayBackData: [], // 直播回放
            VideoIdList: [],
            uploadStep: 1,
            showNoClassifyDataList: false,
            selectedVal: '',
            addClassifyBtn: false,
            albumName: '',
            searchListTotal: 0,
            showFlag: 1,
            uploadParams: {
                key: '',
                title: '',
                type: '',
                catalog_id: ''
            },
            playBackName: '', //绑定课时名
            playBackId: '', //绑定课时名id
            courseNameList: [],
            selectedOptions: [],
            fromCourseId: ''
        }
    },
    computed: {
        uploadTitle() {
            if (this.showFlag == 1) {
                return this.$t('video.tips.titleUpload');
            } else {
                return this.$t('video.tips.titleMove');
            }
        }
    },
    mounted() {
        this.getAlbumList(); //合辑列表--录播视频
        this.getAlbumNameList(); //视频分类列表--录播视频
        this.getCourseList(); //课程列表 -- 直播回放
        this.getCourseNameList(); // 课程目录
        this.getInstituteId(); // institute_id
    },
    methods: {
        getInstituteId() {
            videoApi.getInstituteId().then(res => { // 获取 institute_id
                this.instituteId = res.institute_id;
            });
        },
        handleClick(tab, event) {
            if (this.activeName == 'first') {
                this.ifPlayBack = false;
            }
            if (this.activeName == 'second') {
                this.ifPlayBack = true;
            }
        },
        getAlbumList() {
            var _this = this;
            videoApi.getAlbumList(this.albumFilter).then(res => { //获取视频合辑列表数据
                this.albumTotal = res.total;
                this.albumListData = res.list;
                if (res.list.length != 0) {
                    this.albumListData.map(function(item) {
                        Vue.set(item, 'flag', '-1');
                        Vue.set(item, 'showChildData', false); // 是否显示合辑下的视频列表
                        Vue.set(item, 'videoTotal', 0);
                        Vue.set(item, 'page_num', '1');
                        Vue.set(item, 'temp_name', item.name); //
                    });
                    // 默认分类 默认展开
                    this.albumListData.forEach(function(item) {
                        if (item.unnamed == 1) {
                            _this.getVideoList(item);
                        }
                    });
                }
            })
        },
        getCourseList() {
            videoApi.getCourseList(this.courseFilter).then(res => { //直播回放列表
                this.courseTotal = res.total;
                this.courseList = res.data;
                this.courseList.map(function(item) {
                    Vue.set(item, 'playBackList', []);
                    Vue.set(item, 'ifShowPlayBackList', false);
                    Vue.set(item, 'flag', '-1');
                    item.total_time = utils.secToTime(item.total_time);
                });
            })
        },
        getPlayBackList(item) { //回放课程列表
            item.ifShowPlayBackList = !item.ifShowPlayBackList;
            this.playBackFilter.course_id = item.course_id;
            this.playBackFilter.page_num = 1;
            if (item.ifShowPlayBackList && item.flag == -1 && item.count > 0) {
                videoApi.getPlayBackList(this.playBackFilter).then(res => {
                    item.flag = 1;
                    item.backTotal = res.total;
                    item.playBackList = res.list;
                    item.playBackList.map(function(v) {
                        v.timelong = utils.secToTime(v.timelong);
                    });
                })
            }
        },
        singleUpload(item, s) { //直播回放上传弹窗
            this.dialogClassifyVisible = true;
            this.uploadStep = 2;
            this.playBackName = s.name;
            this.playBackId = s.id;
            this.fromCourseId = item.course_id;
        },
        uploadModalHandle(s) { // 搜索列表 -- 直播回放上传
            this.dialogClassifyVisible = true;
            this.uploadStep = 2;
            this.playBackName = s.name;
            this.playBackId = s.id;
            this.fromCourseId = '';
        },
        searchMyData() { //获取用户自己上传的视频
            this.videoFilter.page_num = 1;
            this.videoFilter.albumid = '';
            this.playBackFilter.page_num = 1;
            this.playBackFilter.course_id = '';

            this.isSearchData = true;
            if (this.checked) {
                this.videoFilter.myupload = 1;
                this.getSearchList();
                this.playBackFilter.myupload = 1;
                this.getSearchPlayBackList();
            } else {
                this.videoFilter.myupload = 0;
                this.playBackFilter.myupload = 0;
                if (this.filename.replace(/(^\s*)/g, "") == '') {
                    this.videoFilter.filename = '';
                    this.playBackFilter.filename = '';
                    this.isSearchData = false;
                    this.albumFilter.page_num = 1;
                    this.courseFilter.page_num = 1;
                    this.albumListData = [];
                    this.courseList = [];
                    this.getAlbumList();
                    this.getCourseList();
                } else {
                    this.getSearchList();
                    this.getSearchPlayBackList();
                }
            }
        },
        searchData() { // 搜索视频列表
            this.videoFilter.page_num = 1;
            this.videoFilter.albumid = '';
            this.videoFilter.filename = this.filename;
            this.playBackFilter.page_num = 1;
            this.playBackFilter.course_id = '';
            this.playBackFilter.filename = this.filename;
            if (this.isSearchData) {
                if (this.filename.replace(/(^\s*)/g, "") == '' && !this.checked) {
                    this.isSearchData = false;
                    this.albumFilter.page_num = 1;
                    this.albumListData = [];
                    this.getAlbumList();
                    this.playBackFilter.page_num = 1;
                    this.courseList = [];
                    this.getCourseList();
                } else {
                    this.isSearchData = true;
                    this.getSearchList();
                    this.getSearchPlayBackList();
                }
            } else {
                if (this.filename.replace(/(^\s*)/g, "") != '') {
                    this.isSearchData = true;
                    this.getSearchList();
                    this.getSearchPlayBackList();
                }
            }
        },
        getSearchList() { // 录播-搜索列表
            videoApi.getVideoList(this.videoFilter).then(res => {
                this.searchListTotal = res.total;
                this.searchVideoData = res.list;
                this.searchVideoData.map(function(item) {
                    Vue.set(item, 'temp_name', item.name);
                });
            })
        },
        getSearchPlayBackList() { // 直播回放
            videoApi.getPlayBackList(this.playBackFilter).then(res => {
                this.searchPlayBackListTotal = res.total;
                this.searchPlayBackData = res.list;
                this.searchPlayBackData.map(function(item) {
                    item.timelong = utils.secToTime(item.timelong);
                });
            })
        },
        getVideoList(item) { //获取合辑下的视频列表
            item.showChildData = !item.showChildData;
            this.videoFilter.albumid = item.id;
            item.page_num = 1;
            this.videoFilter.page_num = item.page_num;
            if (item.showChildData && item.flag == -1 && item.class_num > 0) {
                videoApi.getVideoList(this.videoFilter).then(res => {
                    Vue.set(item, 'videoListData', res.list);
                    Vue.set(item, 'flag', '-1');
                    item.videoTotal = res.total;
                    item.flag = item.id;
                    item.videoListData.map(function(v) {
                        Vue.set(v, 'temp_name', v.name);
                    });
                })
            }
        },
        editName(item, event) { // 编辑
            this.editIndex = item.id;
            item.temp_name = item.name;
            //event.cancelBubble = true;
        },
        saveFileName(item) { // 保存合辑名
            if (!item.temp_name.replace(/(^\s*)/g, "")) {
                this.$message({
                    type: 'error',
                    message: this.$t('video.rules.tipClassfyNull')
                });
                return false;
            } else {
                var params = {
                    id: item.id,
                    name: item.temp_name
                };
                videoApi.savealbum(params).then(res => {
                    this.editIndex = -1;
                    item.name = item.temp_name;
                    this.getAlbumNameList();
                });
            }
        },
        deleteAlbum(id) { //删除合辑
            videoApi.checkdelAlbum({
                id: id
            }).then(res => {
                if (res) {
                    this.handleTip().then(() => {
                        videoApi.deleteAlbum({
                            id: id
                        }).then(res => {
                            this.$message({
                                type: 'success',
                                message: this.$t('video.tips.message.successDelete')
                            });
                            this.getAlbumList();
                            this.getAlbumNameList();
                        });
                    })
                }
            });
        },
        editChildrenFileName(item) { //编辑
            this.editChildrenIndex = item.id;
            item.temp_name = item.name;
        },
        saveChildrenFileName(item) { //保存单个视频文件名
            if (!item.temp_name.replace(/(^\s*)/g, "")) {
                this.$message({
                    type: 'error',
                    message: this.$t('video.rules.tipClassfyNull')
                });
                return false;
            } else {
                var params = {
                    id: item.id,
                    name: item.temp_name
                };
                videoApi.saveChildrenFile(params).then(res => {
                    this.editChildrenIndex = -1;
                    item.name = item.temp_name;
                });
            }
        },
        delChildrenFile(item, id) { //删除单个视频文件
            videoApi.checkdelvideo({
                id: id
            }).then(res => {
                return this.handleDelFile(id);
            }).then(() => {
                item.class_num--;
                videoApi.getVideoList(this.videoFilter).then(res => {
                    Vue.set(item, 'videoListData', res.list);
                    item.videoTotal = res.total;
                })
            });
        },
        handleDelFile(id) { //删除视频处理
            return this.handleTip().then(() => {
                return videoApi.delChildrenFile({
                    id: id
                }).then(res => {
                    this.$message({
                        type: 'success',
                        message: this.$t('video.tips.message.successDelete')
                    });
                });
            })
        },
        delvideoFile(id) {
            videoApi.checkdelvideo({
                id: id
            }).then(res => {
                return this.handleDelFile(id);
            }).then(() => {
                this.getSearchList();
            });
        },
        modelShow() { //
            this.uploadStep = 1;
            this.dialogClassifyVisible = true;
            this.showFlag = 1; // model title
            //this.selectedVal = '';
            this.addClassifyBtn = false; // 新增分类 btn
            this.ifFromMove = false;
        },
        uploadMedia(file) { //上传
            this.uploadParams.key = file.bosKey;
            this.uploadParams.title = file.name;
            this.uploadParams.type = (this.activeName === 'first') ? '' : '2';
            this.uploadParams.catalog_id = (this.activeName === 'first') ? '' : this.playBackId;
            return apiUp.uploadMedia(this.uploadParams)
                .then(res => {
                    Vue.set(file, 'media_id', res.media_id);
                    this.VideoIdList.push(res.media_id);
                    if (this.activeName === 'second') { // 直播回放上传
                        this.$message({
                            type: 'success',
                            message: this.$t('video.tips.message.successUpload')
                        });
                        this.getCourseNameList();
                        if (this.fromCourseId != '') { //_this.fromCourseId
                            var obj = {};
                            var _this = this;
                            obj = this.courseList.find(function(item) {
                                return item.course_id === _this.fromCourseId;
                            });
                            this.playBackFilter.course_id = obj.course_id;
                            videoApi.getPlayBackList(this.playBackFilter).then(data => {
                                obj.backTotal = data.total;
                                obj.playBackList = data.list;
                                obj.playBackList.map(function(v) {
                                    v.timelong = utils.secToTime(v.timelong);
                                });
                            });
                        }
                        this.getSearchPlayBackList();
                    }
                    utils.log({
                        opType: 'videoUpload',
                        ev: 'uploadMedia',
                        file_id: file.uuid,
                        file_key: file.bosKey,
                        media_id: res.media_id
                    });
                }, function(error) {
                    utils.log({
                        opType: 'videoUpload',
                        ev: 'uploadMediaFail',
                        message: error,
                        file_id: file.uuid,
                        file_key: file.bosKey
                    })
                    throw new Error(error);
                });
        },
        onRemove(file) { // 删除已上传视频列表 model
            this.VideoIdList.splice(this.VideoIdList.indexOf(file.media_id), 1);
            var removeParams = {
                id: file.media_id,
                type: ''
            };
            if (this.ifPlayBack) {
                removeParams.type = 2;
                videoApi.delChildrenFile(removeParams).then(res => {
                    this.getSearchPlayBackList();
                    var obj = {};
                    var _this = this;
                    obj = this.courseList.find(function(item) {
                        return item.course_id === _this.fromCourseId;
                    });
                    this.playBackFilter.course_id = obj.course_id;
                    videoApi.getPlayBackList(this.playBackFilter).then(data => {
                        obj.backTotal = data.total;
                        obj.playBackList = data.list;
                        obj.playBackList.map(function(v) {
                            v.timelong = utils.secToTime(v.timelong);
                        });
                    });

                });
            } else {
                removeParams.type = '';
                videoApi.delChildrenFile(removeParams).then(res => {});
            }

        },
        uploadToAlbum(item) { // 上传视频到合辑
            this.showFlag = 1;
            this.dialogClassifyVisible = true;
            this.uploadStep = 2;
            this.videoClassificationName = item.name;
            this.transAlbumID = item.id;
        },
        moveAlbum(id) { // 移到其他分类
            this.uploadStep = 1;
            this.showFlag = 2;
            this.dialogClassifyVisible = true;
            this.ifFromMove = true;
            //this.selectedVal = '';
            this.toMoveVideoId = [];
            this.toMoveVideoId.push(id);
            this.selectedAlbumId = ''; //清空分类id
        },
        moveToAlbum() { // 移到其他分类 / 上传
            videoApi.moveAlbum({
                videoid: this.toMoveVideoId,
                albumid: this.selectedAlbumId
            }).then(res => {
                this.$message({
                    type: 'success',
                    message: this.$t('video.tips.message.successOperation')
                });
                this.dialogClassifyVisible = false;
                if (this.isSearchData) {
                    this.getSearchList();
                } else {
                    this.getAlbumList();
                }
            });
        },
        saveUpload() { // 确定上传按钮
            var checkList = this.$refs.bosUploader.fileList;
            var inProgressArr = [];
            for (var i = 0; i < checkList.length; i++) {
                if (checkList[i].progress < 1) {
                    inProgressArr.push(checkList[i]);
                }
            }
            if (inProgressArr.length > 0) {
                this.$confirm(this.$t('video.tips.message.warnUpload'), this.$t('video.tips.tip'), {
                        customClass: "w-dialog",
                        type: 'warning'
                    })
                    .then(_ => {
                        this.goUpload();
                    });
            } else {
                this.goUpload();
            }
        },
        goUpload() { // 确定上传  videoid
            this.selectedAlbumId = this.transAlbumID;
            this.toMoveVideoId = this.VideoIdList;
            this.moveToAlbum();
        },
        handleChange(value) {
            this.uploadStep = 2;
            var obj = {};
            var selectedObj = {};
            obj = this.courseNameList.find(function(item) {
                return item.value === value[0];
            });
            selectedObj = obj.children.find(function(item) {
                return item.value === value[1];
            });
            this.playBackName = selectedObj.label;
            this.playBackId = value[1];
            this.fromCourseId = value[0];
        },
        handleCurrentChangeVideo(item) { //视频列表 分页
            this.videoFilter.page_num = item.page_num;
            videoApi.getVideoList(this.videoFilter).then(res => {
                Vue.set(item, 'videoListData', res.list);
                item.videoTotal = res.total;
            })
        },
        handleCurrentChangePlayBack(item) { // 直播回放 -- 课时
            this.playBackFilter.page_num = item.page_num;
            videoApi.getPlayBackList(this.playBackFilter).then(res => {
                item.playBackList = res.list;
                item.videoTotal = res.total;
            })
        },
        handleCurrentChangeAlbum(val) { //合辑列表 分页
            this.albumFilter.page_num = val;
            this.getAlbumList();
        },
        handleCurrentChangeCourse(val) { //直播回放
            this.courseFilter.page_num = val;
            this.getCourseList();
        },
        handleCurrentChangeSearchBlock(val) { // 搜索列表 分页 -- 录播
            this.videoFilter.page_num = val;
            this.getSearchList();
        },
        handleCurrentChangeSearchPlayBack(val) { //搜索--直播回放
            this.playBackFilter.page_num = val;
            this.getSearchPlayBackList();
        },
        getAlbumNameList() { //获取视频所属分类列表
            videoApi.getAlbumNameList().then(res => {
                this.AlbumNameList = res;
            });
        },
        getCourseNameList() { //课程目录列表
            videoApi.getAlbumNameList({
                type: 2
            }).then(res => {
                this.courseNameList = res;
                this.courseNameList.forEach(function(item) {
                    item.value = item.course_id;
                    delete item.course_id;
                    item.label = item.course_name;
                    delete item.course_name;
                    item.children = item._child;
                    delete item._child;
                    item.children.forEach(function(v) {
                        v.value = v.id;
                        delete v.id;
                        v.label = v.title;
                        delete v.title;
                    });
                });
            });
        },
        addAlbum() { //添加分类名
            videoApi.savealbum({
                id: '',
                name: this.albumName
            }).then(res => {
                this.AlbumNameList.unshift({
                    id: res.id,
                    name: this.albumName
                });
                let obj = {};
                obj = this.AlbumNameList.find(function(item) {
                    return item.id === res.id;
                });
                this.selectedVal = obj.id;
                this.addClassifyBtn = false;
            });
        },
        showAddAlbum() { // 显示新增分类
            this.addClassifyBtn = true;
            this.albumName = '';
        },
        cancelAdd() { //取消新增
            this.addClassifyBtn = false;
        },
        changeValue(selectedVal) { // 选择分类
            if (!this.ifFromMove) {
                let obj = {};
                obj = this.AlbumNameList.find(function(item) {
                    return item.id === selectedVal;
                });
                this.uploadStep = 2;
                this.transAlbumID = selectedVal;
                this.videoClassificationName = obj.name;
            } else {
                this.selectedAlbumId = selectedVal;
            }
        },
        removeFile() { // modal关闭 清空视频列表
            this.VideoIdList = [];
            this.$refs.bosUploader && this.$refs.bosUploader.clear();
            this.selectedVal = '';
            this.selectedOptions = [];
        },
        delSingleVideoHandle(params) { // 删除视频
            return videoApi.delChildrenFile(params).then(res => {
                this.$message({
                    type: 'success',
                    message: this.$t('video.tips.message.successDelete')
                });
            });
        },
        delPlayBackFile(item, course_id, media_id) {
            return this.handleTip().then(() => {
                var delParams = {
                    id: media_id,
                    type: '2'
                };
                return this.delSingleVideoHandle(delParams);
            }).then(() => {
                this.getCourseNameList();
                this.playBackFilter.course_id = course_id;
                videoApi.getPlayBackList(this.playBackFilter).then(data => {
                    item.backTotal = data.total;
                    item.playBackList = data.list;
                    item.playBackList.map(function(v) {
                        v.timelong = utils.secToTime(v.timelong);
                    });
                });
            });
        },
        singleDelPlayBackFile(id) { //搜索视频删除 -- 直播回放
            this.handleTip().then(() => {
                var delParams = {
                    id: id,
                    type: '2'
                };
                return this.delSingleVideoHandle(delParams);
            }).then(() => {
                this.getCourseNameList();
                this.getSearchPlayBackList();
            });
        },
        handleClose(done) { // 上传弹窗关闭，二次确认
            if (this.$refs.bosUploader && this.$refs.bosUploader.fileList) {
                var checkList = this.$refs.bosUploader.fileList;
                var inProgressArr = [];
                for (var i = 0; i < checkList.length; i++) {
                    if (checkList[i].progress < 1) {
                        inProgressArr.push(checkList[i]);
                    }
                }
                if (inProgressArr.length > 0) {
                    this.$confirm(this.$t('video.tips.message.warnCloseUpload'), this.$t('video.tips.title'), {
                            customClass: "w-dialog",
                            confirmButtonText: this.$t('video.btn.ok'),
                            cancelButtonText: this.$t('video.btn.cancel'),
                            type: 'warning'
                        })
                        .then(_ => {
                            done();
                        });
                } else {
                    this.handleUploadClose().then(_ => {
                        done();
                    });
                }
                return false;
            }
            this.handleUploadClose().then(_ => {
                done();
            });
        },
        handleTip() { // 关闭弹窗
            return this.$confirm(this.$t('video.tips.message.warnDelete'), this.$t('video.tips.title'), {
                customClass: "w-dialog",
                confirmButtonText: this.$t('video.btn.ok'),
                cancelButtonText: this.$t('video.btn.cancel'),
                type: 'warning'
            })
        },
        handleUploadClose() { // 上传时 关闭弹窗
            return this.$confirm(this.$t('video.tips.message.warnClose'), this.$t('video.tips.title'), {
                customClass: "w-dialog",
                confirmButtonText: this.$t('video.btn.ok'),
                cancelButtonText: this.$t('video.btn.cancel'),
                type: 'warning'
            })
        },
        checkOpinion(reason) { //查看审核意见
            if (reason == null) {
                reason = '';
            }
            this.$alert(reason, this.$t('video.tips.checkOpinion'), {
                confirmButtonText: this.$t('video.btn.ok'),
                customClass: "w-dialog"
            });
        },
        cancelUploadModel() { // 上传视频时，点击取消按钮
            var checkList = this.$refs.bosUploader.fileList;
            if ((checkList.length == 1) && checkList[0].progress < 1) {
                this.$confirm(this.$t('video.tips.message.warnCancelUpload'), this.$t('video.tips.title'), {
                        customClass: "w-dialog",
                        confirmButtonText: this.$t('video.btn.ok'),
                        cancelButtonText: this.$t('video.btn.cancel'),
                        type: 'warning'
                    })
                    .then(_ => {
                        this.dialogClassifyVisible = false;
                    });
            } else {
                this.handleUploadClose().then(_ => {
                    this.dialogClassifyVisible = false;
                });
            }
        },
        closeUploadModel() { // 选择分类 取消
            this.dialogClassifyVisible = false;
        }
    }
}
</script>
<style scoped>
.video-list-data .video-list>li div.category>div.line-all {
    line-height: 34px;
}

.video-list-data .el-row {
    margin-bottom: 20px;
    &:last-child {
        margin-bottom: 0;
    }
}

.video-list-data .el-col {
    border-radius: 4px;
}

.video-list-data {
    margin-top: 10px;
}

.video-list-data .labelcontrol {
    margin-top: 8px;
}

.video-list-data .btnsearch {
    text-align: right;
}

.video-list-data .btnsearch button {
    width: 100%;
    display: block;
}

.video-list-data .iconcolor {
    color: #268fff;
    cursor: pointer;
    margin-left: 3px;
    padding: 0 !important;
    padding-top: 4px;
    font-size: 18px;
}

.video-list-data .w-cascader {
    width: 280px;
}

.video-list-data .children li>div.line-height-control {
    line-height: 34px;
}

.video-list-data .children li>div.line-height-control.nopass {
    line-height: 18px;
    margin-top: 8px;
}

.video-list-data .children li>div.line-height-control.notranscode {
    line-height: 18px;
    margin-top: 8px;
}

.video-list-data .el-tree {
    border: none;
}

.video-list-data .table-head {
    overflow: hidden;
    padding: 0 15px;
}

.video-list-data .table-head span {
    float: left;
    width: 17%;
    text-align: left;
    line-height: 50px;
    font-weight: 400;
    font-size: 14px;
}

.video-list-data .table-head span.info-album {
    width: 32%;
}

.video-list-data .table-head span.name-album {
    width: 28%;
}

.video-list-data .table-head span.author-album {
    width: 18%;
}

.video-list-data .table-head span.num-album {
    width: 18%;
}

.video-list-data .table-head span.status-album {
    width: 18%;
}

.video-list-data .table-head span.operation-album {
    width: 13%;
    padding-left: 5%;
}

.video-list-data .video-list,
.video-list-data .search-data-list {
    padding: 0;
}

.video-list-data .reupload {
    font-size: 12px;
    color: #999;
}

.video-list-data .no-pass {
    font-size: 12px;
    color: red;
    cursor: pointer;
    display: block;
}

.video-list-data .course-operation {
    padding-left: 50px;
}

.video-list-data .nameAlbum {
    line-height: 24px;
}

.video-list-data .video-list li,
.video-list-data .video-list>li>div.category {
    overflow: hidden;
}

.video-list-data .video-list>li>div.category {
    padding: 20px 10px;
}

.video-list-data .video-list>li>div.category:hover {
    background-color: #f5f5f5;
    cursor: pointer;
}

.video-list-data .video-list>li {
    border-bottom: 1px solid #d9d9d9;
    font-size: 14px;
}

.video-list-data .video-list>li div.category>div {
    width: 20%;
    float: left;
    text-align: left;
}

.video-list-data .video-list>li div.category>div.name-album {
    width: 28%;
}

.video-list-data .video-list>li div.category>div.num-album {
    width: 18%;
}

.video-list-data .video-list>li div.category>div.status-album {
    width: 18%;
}

.video-list-data .video-list>li div.category>div.operation-album {
    width: 18%;
}

.video-list-data .video-list>li div.category>div.author-album {
    width: 18%;
}

.video-list-data .videoname-block {
    overflow: hidden;
}

.video-list-data .videoname-block .playicon-block {
    float: left;
    margin-top: 3px;
    margin-right: 4px;
}

.video-list-data .videoname-block .editvideo-block {
    width: 330px;
    float: left;
}

.video-list-data .nameicon-block {
    overflow: hidden;
}

.video-list-data .nameicon-block img {
    float: left;
    width: 16px;
    margin-top: 3px;
    margin-right: 5px;
}

.video-list-data .nameicon-block .editname-block {
    width: 240px;
    float: left;
}

.video-list-data .nameicon-block .edit-input {
    width: 210px;
}

.video-list-data .editname-input {
    width: 280px;
}

.video-list-data .children {
    padding: 0;
}

.video-list-data .children li {
    overflow: hidden;
    padding: 16px 0;
}

.video-list-data .video-list>li:last-child,
.video-list-data .children.singleVideo li:last-child {
    border: none;
}

.video-list-data .children.singleVideo li.li-video {
    padding: 15px;
}

.video-list-data .children li>div:first-child {
    width: 42%;
    margin-left: 4%;
}

.video-list-data .children.singleVideo li .info-block {
    margin-left: 0;
    width: 32%;
}

.video-list-data .children.singleVideo li>div {
    width: 17%;
}

.video-list-data .children.singleVideo li {
    border-bottom: 1px solid #d9d9d9;
}

.video-list-data .children li>div {
    float: left;
    width: 18%;
    text-align: left;
}

.video-list-data .data-box {
    border: 1px solid #d9d9d9;
    border-radius: 4px;
}

.video-list-data .table-head {
    background-color: #f5f5f5;
    border-bottom: 1px solid #d9d9d9;
}

.video-list-data .video-time {
    color: #999999;
    margin-left: 16px;
}

.video-list-data .name-video-time {
    margin-left: 20px;
}

.video-list-data .gray {
    color: #d9d9d9;
}

.video-list-data .icon-folder {
    width: 16px;
    height: 14px;
}

.video-list-data .btn-over {
    overflow: hidden;
    padding-right: 20px;
}

.video-list-data .btn-playback {
    padding: 0;
    padding-left: 40px;
}

.video-list-data .btn-over>div {
    float: left;
    margin-right: 20px;
}

.video-list-data .btn-over>div.btn-show-control {
    width: 92px;
    height: 34px;
}

.video-list-data .header-upload span {
    color: #999;
}

.video-list-data .model-upload {
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #d9d9d9;
    border-radius: 4px;
    min-height: 227px;
}

.video-list-data .nodata {
    color: #5e7382;
    text-align: center;
    line-height: 32px;
    font-size: 14px;
}

.video-list-data .block {
    text-align: center;
    margin: 20px 0;
}

.video-list-data .el-pager li {
    padding: 0;
}

.video-list-data .classify-con {
    overflow: hidden;
}

.video-list-data .max-con-height {
    min-height: 310px;
}

.video-list-data .classify-con .label-classify {
    float: left;
    line-height: 34px;
}

.video-list-data .classify-con .select-con {
    float: left;
    width: 280px;
}

.video-list-data .classify-con .select-con .w-select {
    width: 320px;
}

.el-select-dropdown .add-classification {
    border-top: 1px solid #e4e8f1;
    padding-top: 5px;
}

.el-select-dropdown .add-box {
    padding-left: 5px;
}

.el-select-dropdown .editclassify {
    width: 160px;
    margin-right: 10px;
}

.el-select-dropdown .btn-add {
    display: block;
    margin: 0 auto !important;
    padding: 10px 0;
}

.video-list-data .footerBtn {
    overflow: hidden;
}

.video-list-data .foot-move {
    margin-top: 227px;
}

.video-list-data .footerBtn button {
    float: right;
    margin-left: 15px;
    margin-top: 10px;
}

.video-list-data .childrenPagination {
    margin: 0;
    margin-bottom: 5px;
}

.video-list-data .box-up .el-dialog__body {
    padding: 20px;
}

.video-list-data .video-list>li div.category>div.btn-group .upload-btn {
    text-align: right;
    width: 98px;
}

.video-list-data .children li>div.btn-group .upload-btn {
    text-align: right;
    width: 92px;
}

.el-message-box__title {
    font-size: 14px;
    color: #fff;
    font-weight: normal;
}

.video-list-data .btn-up {
    background-color: transparent;
    border: 1px solid #268fff;
}

.video-list-data .btn-up.el-button--primary {
    color: #268fff !important;
}

.video-list-data .infovideo-block {
    overflow: hidden;
}

.video-list-data .infovideo-block .infoicon-block {
    float: left;
    margin-top: 3px;
    margin-right: 4px;
}

.video-list-data .infovideo-block .infoedit-block {
    width: 250px;
    float: left;
}

.video-list-data .infovideo-block .infoedit {
    width: 220px;
}
</style>
