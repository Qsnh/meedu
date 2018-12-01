<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/lib/es6-promise.min.js')}}"></script>
<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/lib/aliyun-oss-sdk-5.2.0.min.js')}}"></script>
<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/aliyun-upload-sdk-1.4.0.min.js')}}"></script>
<script>
    var uploader = new AliyunUpload.Vod({
        partSize: 1048576,
        parallel: 5,
        retryCount: 3,
        retryDuration: 2,
        // 开始上传
        'onUploadstarted': function (uploadInfo) {
            console.log("onUploadStarted:" + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
            // uploader.setUploadAuthAndAddress(uploadInfo, uploadAuth, uploadAddress,videoId);
            if (uploadInfo.videoId) {
                // 刷新
                window.axios.post('{{route('video.upload.aliyun.refresh')}}', {
                    video_id: uploadInfo.videoId,
                    _token: '{{csrf_token()}}'
                }).then(function (res) {
                    if (res.data.code == 500) {
                        alert(res.data.message);
                    } else {
                        uploader.setUploadAuthAndAddress(uploadInfo, res.data.upload_auth, res.data.upload_address, res.data.video_id);
                    }
                }).catch(function (errors) {
                    console.log(errors)
                });
            } else {
                // 创建
                window.axios.post('{{route('video.upload.aliyun.create')}}', {
                    title: uploadInfo.file.name,
                    filename: uploadInfo.file.name,
                    _token: '{{csrf_token()}}'
                }).then(function (res) {
                    if (res.data.code == 500) {
                        alert(res.data.message);
                    } else {
                        uploader.setUploadAuthAndAddress(uploadInfo, res.data.upload_auth, res.data.upload_address, res.data.video_id);
                    }
                }).catch(function (errors) {
                    console.log(errors)
                });
            }
        },
        // 文件上传成功
        'onUploadSucceed': function (uploadInfo) {
            console.log("onUploadSucceed: " + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
            document.getElementById('aliyun_video_id').value = uploadInfo.videoId;
            document.getElementById('upload-progress').innerText = "上传成功";
        },
        // 文件上传失败
        'onUploadFailed': function (uploadInfo, code, message) {
            console.log("onUploadFailed: file:" + uploadInfo.file.name + ",code:" + code + ", message:" + message);
        },
        // 文件上传进度，单位：字节
        'onUploadProgress': function (uploadInfo, totalSize, loadedPercent) {
            console.log("onUploadProgress:file:" + uploadInfo.file.name + ", fileSize:" + totalSize + ", percent:" + Math.ceil(loadedPercent * 100) + "%");
            document.getElementById('upload-progress').innerText = Math.ceil(loadedPercent * 100) + "%";
        },
        // 上传凭证超时
        'onUploadTokenExpired': function (uploadInfo) {
            console.log("onUploadTokenExpired");
            window.axios.post('{{route('video.upload.aliyun.refresh')}}', {
                video_id: uploadInfo.videoId,
                _token: '{{csrf_token()}}'
            }).then(function (res) {
                uploader.resumeUploadWithAuth(res.data.upload_auth);
            }).catch(function (errors) {
                console.log(errors)
            });
            // uploader.resumeUploadWithAuth(uploadAuth);
        },
        //全部文件上传结束
        'onUploadEnd':function(uploadInfo){
            console.log("onUploadEnd: uploaded all the files");
        }
    });

    var userData = '';
    document.getElementById("video_files")
        .addEventListener('change', function (event) {
            for(var i=0; i<event.target.files.length; i++) {
                uploader.addFile(event.target.files[i], null, null, null, userData);
            }
        });

    document.getElementById("start-upload").addEventListener('click', function (event) {
        document.getElementById('upload-progress').innerText = "正在初始化...";
        uploader.startUpload();
    });
    document.getElementById("stop-upload").addEventListener('click', function (event) {
        uploader.stopUpload();
        document.getElementById('upload-progress').innerText = document.getElementById('upload-progress').innerText + ',点击开始上传按钮可继续上传';
    });
</script>