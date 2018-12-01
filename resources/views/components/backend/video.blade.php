<div class="pt-2 pb-2" style="background-color: #467fcf">
    <div class="col-sm-12 mt-1 mb-1">
        <input type="file" name="file" id="video_files"/>
        <span>上传进度：<span id="upload-progress">暂无</span></span>
    </div>
    <div class="col-sm">
        <div class="input-group">
            <div class="input-group-append">
                <button type="button" class="btn btn-info" id="start-upload">开始上传</button>
                <button type="button" class="btn btn-danger" id="stop-upload">停止上传</button>
            </div>
            <input type="text" class="form-control col-sm-2"
                   name="aliyun_video_id" id="aliyun_video_id"
                   disabled="disabled" placeholder="阿里云视频ID"
            value="{{isset($video) ? ($video->aliyun_video_id ?? '') : ''}}">
            <input type="text" name="url" class="form-control"
                   placeholder="如果不使用阿里云视频服务请在这里输入视频的URL地址"
            value="{{isset($video) ? ($video->url ?? '') : ''}}">
        </div>
    </div>
</div>