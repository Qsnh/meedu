<div class="form-group">
    <ul class="nav nav-tabs nav-tabs-success">
        @if(!isset($video))
            <li class="nav-item">
                <a class="nav-link active" data-toggle="tab" href="#video-aliyun">阿里云</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#video-tencent">腾讯云</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="tab" href="#video-url">直链</a>
            </li>
            @else
            <li class="nav-item">
                <a class="nav-link {{$video->aliyun_video_id ? 'active' : ''}}" data-toggle="tab" href="#video-aliyun">阿里云</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{$video->tencent_video_id ? 'active' : ''}}" data-toggle="tab" href="#video-tencent">腾讯云</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{$video->url ? 'active' : ''}}" data-toggle="tab" href="#video-url">直链</a>
            </li>
            @endif
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane fade {{(!isset($video) || $video->aliyun_video_id) ? 'active show' : ''}}" id="video-aliyun">
            <div class="alert alert-warning">
                请确保您配置了阿里云视频服务的参数，否则会上传失败。<a href="{{route('backend.setting.index')}}">点击这里进行配置</a>
            </div>
            @if(optional($video ?? '')->aliyun_video_id)
                <ul class="nav nav-process nav-process-circle">
                    <li class="nav-item aliyun-step1 complete">
                        <span class="nav-title">选择视频</span>
                        <a class="nav-link" href="#"></a>
                        <span class="aliyun-filename">{{$video->name}}</span>
                    </li>
                    <li class="nav-item aliyun-step2 complete">
                        <span class="nav-title">上传视频</span>
                        <a class="nav-link" href="#"></a>
                        <span class="aliyun-process">100%</span>
                    </li>
                    <li class="nav-item aliyun-step3 complete">
                        <span class="nav-title">上传成功</span>
                        <a class="nav-link" href="#"></a>
                        <span class="aliyun-vid">{{$video->aliyun_video_id}}</span>
                    </li>
                </ul>
            @else
                <ul class="nav nav-process nav-process-circle">
                    <li class="nav-item aliyun-step1">
                        <span class="nav-title">选择视频</span>
                        <a class="nav-link" href="#"></a>
                        <span class="aliyun-filename"></span>
                    </li>
                    <li class="nav-item aliyun-step2">
                        <span class="nav-title">上传视频</span>
                        <a class="nav-link" href="#"></a>
                        <span class="aliyun-process"></span>
                    </li>
                    <li class="nav-item aliyun-step3">
                        <span class="nav-title">上传成功</span>
                        <a class="nav-link" href="#"></a>
                        <span class="aliyun-vid"></span>
                    </li>
                </ul>
            @endif
            <div class="file-group file-group-inline">
                <button class="btn btn-primary file-browser" id="aliyun-upload-button" type="button">选择视频文件</button>
                <input type="file" id="aliyun_video_files">
                <button class="btn btn-primary" id="aliyun-upload-start-button" type="button">开始上传</button>
                @if(optional($video ?? '')->aliyun_video_id)
                <button class="btn btn-warning" onclick="aliyunReset()" type="button">重新上传</button>
                @endif
            </div>
        </div>
        <div class="tab-pane fade {{(isset($video) && $video->tencent_video_id) ? 'active show' : ''}}" id="video-tencent">
            <div class="alert alert-warning">
                请确保您配置了腾讯云视频服务的参数，否则会上传失败。<a href="{{route('backend.setting.index')}}">点击这里进行配置</a>
            </div>
            @if(optional($video ?? '')->tencent_video_id)
                <ul class="nav nav-process nav-process-circle nav-process-info">
                    <li class="nav-item tencent-step1 complete">
                        <span class="nav-title">选择视频</span>
                        <a class="nav-link" href="#"></a>
                        <span class="tencent-filename">{{$video->name}}</span>
                    </li>
                    <li class="nav-item tencent-step2 complete">
                        <span class="nav-title">上传视频</span>
                        <a class="nav-link" href="#"></a>
                        <span class="tencent-process">100%</span>
                    </li>
                    <li class="nav-item tencent-step3 complete">
                        <span class="nav-title">上传成功</span>
                        <a class="nav-link" href="#"></a>
                        <span class="tencent-vid">{{$video->tencent_video_id}}</span>
                    </li>
                </ul>
            @else
                <ul class="nav nav-process nav-process-circle nav-process-info">
                    <li class="nav-item tencent-step1">
                        <span class="nav-title">选择视频</span>
                        <a class="nav-link" href="#"></a>
                        <span class="tencent-filename"></span>
                    </li>
                    <li class="nav-item tencent-step2">
                        <span class="nav-title">上传视频</span>
                        <a class="nav-link" href="#"></a>
                        <span class="tencent-process"></span>
                    </li>
                    <li class="nav-item tencent-step3">
                        <span class="nav-title">上传成功</span>
                        <a class="nav-link" href="#"></a>
                        <span class="tencent-vid"></span>
                    </li>
                </ul>
            @endif
            <div class="file-group file-group-inline">
                <button class="btn btn-info file-browser" id="tencent-select-button" type="button">上传</button>
                <input type="file" id="tencent-file-input">
            </div>
        </div>
        <div class="tab-pane fade {{(isset($video) && $video->url) ? 'active show' : ''}}" id="video-url">
            <input type="text" name="url" class="form-control"
                   placeholder="请输入视频直链"
                   value="{{optional($video ?? '')->url ?? ''}}">
        </div>
    </div>
    <input type="hidden" name="tencent_video_id" id="tencent_video_id" value="{{optional($video ?? '')->tencent_video_id ?? ''}}">
    <input type="hidden" name="aliyun_video_id" id="aliyun_video_id" value="{{optional($video ?? '')->aliyun_video_id ?? ''}}">
</div>

<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/lib/es6-promise.min.js')}}"></script>
<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/lib/aliyun-oss-sdk-5.2.0.min.js')}}"></script>
<script src="{{asset('/js/aliyun-upload-sdk-1.4.0/aliyun-upload-sdk-1.4.0.min.js')}}"></script>
<script crossorigin="anonymous" integrity="sha384-U/+EF1mNzvy5eahP9DeB32duTkAmXrePwnRWtuSh1C/bHHhyR1KZCr/aGZBkctpY" src="https://lib.baomitu.com/axios/0.18.0/axios.min.js"></script>
<script>
    var aliyunError = function (message) {
        $('.aliyun-step2').addClass('processing');
        $('.aliyun-process').text(message);
    };
    var aliyunReset = function () {
        $('.aliyun-step1').removeClass('complete').removeClass('processing');
        $('.aliyun-step2').removeClass('complete').removeClass('processing');
        $('.aliyun-step3').removeClass('complete').removeClass('processing');
        $('.aliyun-filename').text('');
        $('.aliyun-process').text('');
        $('.aliyun-vid').text('');
    };
    var aliyunUploader = new AliyunUpload.Vod({
        'partSize': 1048576,
        'parallel': 5,
        'retryCount': 3,
        'retryDuration': 2,
        'onUploadstarted': function (uploadInfo) {
            $('.aliyun-step1').removeClass('processing').addClass('complete');
            $('.aliyun-step2').addClass('processing');
            // console.log("onUploadStarted:" + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
            if (uploadInfo.videoId) {
                window.axios.post('{{route('video.upload.aliyun.refresh')}}', {
                    video_id: uploadInfo.videoId,
                    _token: '{{csrf_token()}}'
                }).then(function (res) {
                    if (res.data.code == 500) {
                        aliyunError(res.data.message);
                    } else {
                        aliyunUploader.setUploadAuthAndAddress(uploadInfo, res.data.upload_auth, res.data.upload_address, res.data.video_id);
                    }
                }).catch(function (errors) {
                    aliyunError('request auth error.1');
                });
            } else {
                // 创建
                window.axios.post('{{route('video.upload.aliyun.create')}}', {
                    title: uploadInfo.file.name,
                    filename: uploadInfo.file.name,
                    _token: '{{csrf_token()}}'
                }).then(function (res) {
                    if (res.data.code == 500) {
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
            // console.log("onUploadSucceed: " + uploadInfo.file.name + ", endpoint:" + uploadInfo.endpoint + ", bucket:" + uploadInfo.bucket + ", object:" + uploadInfo.object);
            $('.aliyun-step2').removeClass('processing').addClass('complete');
            $('.aliyun-step3').addClass('complete');
            $('.aliyun-process').text('100%');
            $('.aliyun-vid').text(uploadInfo.videoId);
            $('#aliyun_video_id').val(uploadInfo.videoId);
        },
        'onUploadFailed': function (uploadInfo, code, message) {
            $('.aliyun-step2').addClass('processing').removeClass('complete');
            $('.aliyun-process').text('error:' + message);
            $('.aliyun-step3').removeClass('complete');
            // console.log("onUploadFailed: file:" + uploadInfo.file.name + ",code:" + code + ", message:" + message);
        },
        'onUploadProgress': function (uploadInfo, totalSize, loadedPercent) {
            $('.aliyun-step2').addClass('processing').removeClass('complete');
            $('.aliyun-process').text(Math.ceil(loadedPercent * 100) + "%");
            // console.log("onUploadProgress:file:" + uploadInfo.file.name + ", fileSize:" + totalSize + ", percent:" + Math.ceil(loadedPercent * 100) + "%");
        },
        'onUploadTokenExpired': function (uploadInfo) {
            window.axios.post('{{route('video.upload.aliyun.refresh')}}', {
                video_id: uploadInfo.videoId,
                _token: '{{csrf_token()}}'
            }).then(function (res) {
                aliyunUploader.resumeUploadWithAuth(res.data.upload_auth);
            }).catch(function (errors) {
                aliyunError('request auth error.3');
            });
            // uploader.resumeUploadWithAuth(uploadAuth);
        },
        'onUploadEnd':function(uploadInfo){
        }
    });

    document.getElementById("aliyun_video_files")
        .addEventListener('change', function (event) {
            if (event.target.files.length == 0) {
                return;
            }
            for(var i=0; i<event.target.files.length; i++) {
                var file = event.target.files[i];
                aliyunUploader.addFile(file, null, null, null, '');
            }
            aliyunReset();
            $('.aliyun-step1').addClass('processing');
            $('.aliyun-filename').text(file.name);
        });

    document.getElementById("aliyun-upload-start-button").addEventListener('click', function (event) {
        aliyunUploader.startUpload();
    });
</script>
<script src="//unpkg.com/vod-js-sdk-v6"></script>
<script>
    var tencentReset = function () {
        $('.aliyun-step1').removeClass('complete').removeClass('processing');
        $('.aliyun-step2').removeClass('complete').removeClass('processing');
        $('.aliyun-step3').removeClass('complete').removeClass('processing');
        $('.aliyun-filename').text('');
        $('.aliyun-process').text('');
        $('.aliyun-vid').text('');
    };
    function uploadVideo(videoFile) {
        const tcVod = new TcVod.default({
            getSignature: function () {
                return axios.get('{{route('backend.ajax.tencent.upload.signature')}}').then(function (response) {
                    return response.data.signature;
                });
            }
        });
        const uploader = tcVod.upload({
            videoFile: videoFile,
        });
        uploader.on('video_progress', function (info) {
            $('.tencent-step2').addClass('processing').removeClass('complete');
            $('.tencent-process').text(info.percent + '%');
        });
        uploader.on('video_upload', function (info) {
            // console.log(info);
        });
        uploader.done().then(function (doneResult) {
            console.log(doneResult);
            $('.tencent-step2').removeClass('processing').addClass('complete');
            $('.tencent-step3').addClass('complete');
            $('.tencent-process').text('100%');
            $('.tencent-vid').text(doneResult.fileId);
            $('#tencent_video_id').val(doneResult.fileId);
        });
        return uploader;
    }
    // 文档[https://cloud.tencent.com/document/product/266/9239]
    document.getElementById("tencent-file-input").addEventListener('change', function (event) {
        var files = $('#tencent-file-input').get(0).files;
        if (files.length == 0) {
            return;
        }
        tencentReset();
        $('.tencent-step1').addClass('complete').removeClass('processing');
        $('.tencent-step2').removeClass('complete').addClass('processing');
        $('.tencent-process').text('0%');
        $('.tencent-filename').text(files[0].name);
        window.VodUploader = uploadVideo(files[0]);
    });
</script>