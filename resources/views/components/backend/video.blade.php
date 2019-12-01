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