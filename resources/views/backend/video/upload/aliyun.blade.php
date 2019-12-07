<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link crossorigin="anonymous" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T"
          href="https://lib.baomitu.com/twitter-bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <script crossorigin="anonymous" integrity="sha384-qu2J8HSjv8EaYlbzBdbVeJncuCmfBqnZ4h3UIBZ9WTZ/5Wrqt0/9hofL0046NCkc"
            src="https://lib.baomitu.com/zepto/1.2.0/zepto.min.js"></script>
    <title>阿里云视频上传</title>
</head>
<body>

<div class="container-fluid" style="padding-top: 10px;">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info">阿里云视频上传，上传成功之后，请将VID复制并粘贴到创建视频页面的阿里云视频ID输入框中。</div>
            <p class="error" style="color: red;"></p>
            <input type="file" id="aliyun_video_files">
            <button class="btn btn-primary" id="aliyun-upload-start-button">开始上传</button>
            <p class="processing"></p>
        </div>
    </div>
</div>

<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/lib/es6-promise.min.js')}}"></script>
<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/lib/aliyun-oss-sdk-5.2.0.min.js')}}"></script>
<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/aliyun-upload-sdk-1.4.0.min.js')}}"></script>
<script crossorigin="anonymous" integrity="sha384-U/+EF1mNzvy5eahP9DeB32duTkAmXrePwnRWtuSh1C/bHHhyR1KZCr/aGZBkctpY"
        src="https://lib.baomitu.com/axios/0.18.0/axios.min.js"></script>
<script>
    var axiosInstance = window.axios.create({
        timeout: 10000,
        headers: {'Authorization': 'Bearer {{$token}}'}
    });
    var aliyunError = function (message) {
        $('.error').text(message);
    };
    var aliyunReset = function () {
        $('.error').text('');
        $('.processing').text('');
    };
    var aliyunUploader = new AliyunUpload.Vod({
        'partSize': 1048576,
        'parallel': 5,
        'retryCount': 3,
        'retryDuration': 2,
        'onUploadstarted': function (uploadInfo) {
            // console.log("onUploadStarted:" + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
            if (uploadInfo.videoId) {
                axiosInstance.post('/backend/api/v1/video/token/aliyun/refresh', {
                    video_id: uploadInfo.videoId,
                }).then(function (res) {
                    console.log(res);
                    if (res.data.code === 500) {
                        aliyunError(res.data.message);
                    } else {
                        aliyunUploader.setUploadAuthAndAddress(uploadInfo, res.data.upload_auth, res.data.upload_address, res.data.video_id);
                    }
                }).catch(function (errors) {
                    aliyunError('request auth error.1');
                });
            } else {
                // 创建
                axiosInstance.post('/backend/api/v1/video/token/aliyun/create', {
                    title: uploadInfo.file.name,
                    filename: uploadInfo.file.name,
                }).then(function (res) {
                    if (res.data.code === 500) {
                        aliyunError(res.data.message);
                    } else {
                        aliyunUploader.setUploadAuthAndAddress(uploadInfo, res.data.upload_auth, res.data.upload_address, res.data.video_id);
                    }
                }).catch(function (errors) {
                    aliyunError('request auth error.2');
                });
            }
        },
        'onUploadSucceed': function (uploadInfo) {
            console.log(uploadInfo);
            $('.processing').text('上传成功。VID：' + uploadInfo.videoId);
            // console.log("onUploadSucceed: " + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
        },
        'onUploadFailed': function (uploadInfo, code, message) {
            // console.log("onUploadFailed: file:" + uploadInfo.file.name + ",code:" + code + ", message:" + message);
            $('.processing').text('上传失败:' + message + ':code:' + code);
        },
        'onUploadProgress': function (uploadInfo, totalSize, loadedPercent) {
            $('.processing').text(Math.ceil(loadedPercent * 100) + "%");
            // console.log("onUploadProgress:file:" + uploadInfo.file.name + ", fileSize:" + totalSize + ", percent:" + Math.ceil(loadedPercent * 100) + "%");
        },
        'onUploadTokenExpired': function (uploadInfo) {
            axiosInstance.post('/backend/api/v1/video/token/aliyun/refresh', {
                video_id: uploadInfo.videoId,
            }).then(function (res) {
                aliyunUploader.resumeUploadWithAuth(res.data.upload_auth);
            }).catch(function (errors) {
                aliyunError('request auth error.3');
            });
            // uploader.resumeUploadWithAuth(uploadAuth);
        },
        'onUploadEnd': function (uploadInfo) {
        }
    });

    document.getElementById("aliyun_video_files")
        .addEventListener('change', function (event) {
            if (event.target.files.length === 0) {
                return;
            }
            console.log(event.target.files);
            for (var i = 0; i < event.target.files.length; i++) {
                var file = event.target.files[i];
                aliyunUploader.addFile(file, null, null, null, '');
                // 只上传一个
                break;
            }
            aliyunReset();
        });

    document.getElementById("aliyun-upload-start-button").addEventListener('click', function (event) {
        aliyunUploader.startUpload();
    });
</script>
</body>
</html>