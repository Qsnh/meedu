<script src="//unpkg.com/vod-js-sdk-v6"></script>
<script>
    var getSignature = function () {
        return axios.get('{{route('backend.ajax.tencent.upload.signature')}}').then(function (response) {
            return response.data.signature;
        });
    };

    function uploadVideo(videoFile) {
        const tcVod = new TcVod.default({
            getSignature: getSignature
        });
        const uploader = tcVod.upload({
            videoFile: videoFile,
        });
        uploader.on('video_progress', function (info) {
            console.log(info.percent);
            $('#vod-upload-progress').text(info.percent + '%');
        });
        uploader.on('video_upload', function (info) {
            console.log(info);
            $('#vod_video_id').val();
            $('#vod-upload-progress').text('已完成');
        });
        uploader.done().then(function (doneResult) {
            console.log(doneResult);
        });
        return uploader;
    }

    function cancelVideoUpload() {
        window.VodUploader.cancel();
        // 已取消
        $('#vod-upload-progress').text('已取消');
    }

    // 文档[https://cloud.tencent.com/document/product/266/9239]
    $(function () {
        $('#vod-start-upload').click(function () {
            window.VodUploader = uploadVideo($('#vod_video_file').get(0).files[0]);
        });
        $('#vod-stop-upload').click(function () {
            cancelVideoUpload();
        });
    });
</script>