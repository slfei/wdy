
import api from '@/js/api/video';
import '@/lib/jquery.min.js';
import '@/lib/bce-bos-uploader-lite.min.js';
import Events from './events';
/**
{
    kPostInit: 'PostInit',
    kKey: 'Key',
    kListParts: 'ListParts',
    kObjectMetas: 'ObjectMetas',
    // kFilesRemoved  : 'FilesRemoved',
    kFileFiltered: 'FileFiltered',
    kFilesAdded: 'FilesAdded',
    kFilesFilter: 'FilesFilter',
    kNetworkSpeed: 'NetworkSpeed',
    kBeforeUpload: 'BeforeUpload',
    // kUploadFile    : 'UploadFile',       // ??
    kUploadProgress: 'UploadProgress',
    kFileUploaded: 'FileUploaded',
    kUploadPartProgress: 'UploadPartProgress',
    kChunkUploaded: 'ChunkUploaded',
    kUploadResume: 'UploadResume', // 断点续传
    // kUploadPause: 'UploadPause',   // 暂停
    kUploadResumeError: 'UploadResumeError', // 尝试断点续传失败
    kUploadComplete: 'UploadComplete',
    kError: 'Error',
    kAborted: 'Aborted'
}
*/
var events = {
    //PostInit: 'PostInit',
    //Key: 'Key',
    //ListParts: 'ListParts',
    //ObjectMetas: 'ObjectMetas',

    //FileFiltered: 'FileFiltered',
    FilesAdded: 'filesAdded',
    FilesFilter: 'filesFilter',
    NetworkSpeed: 'networkSpeed',
    BeforeUpload: 'beforeUpload',

    UploadProgress: 'uploadProgress',
    FileUploaded: 'fileUploaded',
    UploadPartProgress: 'uploadPartProgress',
    ChunkUploaded: 'chunkUploaded',
    UploadResume: 'uploadResume', // 断点续传

    UploadResumeError: 'uploadResumeErorr', // 尝试断点续传失败
    UploadComplete: 'uploadComplete',
    //Error: 'error',
    Aborted: 'aborted'
};

export default class Uploader {

    constructor (keyPrefix, bucket = 'vod-bj', endPoint = 'http://bj.bcebos.com', tokenExpireTime) {
        this.client = null;
        this.tokenExpireTime = tokenExpireTime || 2 * 3600 * 1e3;
        this.bucket = bucket;
        this.endPoint = endPoint;
        this.keyPrefix = keyPrefix;
        this.stashFiles = [];
    }

    createClient () {
        if (this.client && +new Date() < this._expireTime) {
            return Promise.resolve(this.client);
        }

        var init = {
            Key: (_, file) => {
                return this.keyPrefix ? (this.keyPrefix + '/' + file.name) : file.name;
            },
            Error: (...args) => {
                console.log(...args);
                this.trigger('error',...args);
            }
        };
        for (var key in events) {
            if (events.hasOwnProperty(key)) {
                init[key] = this._eventProxy(events[key])
            }
        }
        return api.getToken().then((data) => {
            this._expireTime = +new Date() + this.tokenExpireTime;
            return this.client = new baidubce.bos.Uploader({
                bos_bucket: data.bucket || this.bucket,
                bos_endpoint: this.endPoint,
                bos_ak: data.accessKeyId,
                bos_sk: data.secretAccessKey,
                uptoken: data.sessionToken,
                bos_task_parallel: 1,
                init: init
            });
        });
    }

    addFile (file) {
        if (this.isExpired()) {
            this.stashFiles.push(file);
            this.updateToken();
        }
        this.client.addFile(file);
    }

    start () {
        this.client.start();
    }

    isExpired () {
        return +new Date() >= this._expireTime;
    }

    updateToken () {
        if (this.isUpdating) {
            return ;
        }
        this.isUpdating = true;
        api.getToken().then((data) => {
            this.isUpdating = false;
            this._expireTime = +new Date() + this.tokenExpireTime;
            this.client.setOptions({
                bos_ak: data.accessKeyId,
                bos_sk: data.secretAccessKey,
                uptoken: data.sessionToken,
            });
            this.stashFiles.forEach(file => this.client.addFile(file));
            this.stashFiles.length = 0;
        });
    }

    _eventProxy(event) {
        return (_, ...args) => {
            //console.log(event, ...args)
            this.trigger(event, ...args);
        }
    }
}

Events.mixTo(Uploader);
