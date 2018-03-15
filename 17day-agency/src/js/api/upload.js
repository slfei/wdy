
import axios from 'axios';
import * as errorHandle from './globalErrorHandle'

export default {
    uploadImage(file, onProgress) {
        var form = new FormData();
        form.append('image', file);

        return axios.post('/api/universal/uploadimage', form, {
            onUploadProgress: onProgress
        }).then(errorHandle.apiError, errorHandle.networkStateError);
    }
}