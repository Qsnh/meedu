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
    <title>腾讯云视频上传</title>
</head>
<body>

<div class="container-fluid" style="padding-top: 10px;">
    <div class="row">
        <div class="col-sm-12">
            <div class="alert alert-info">腾讯云视频上传，上传成功之后，请将VID复制并粘贴到创建视频页面的腾讯云视频ID输入框中。</div>
            <p class="error" style="color: red;"></p>
            <input type="file" id="tencent-file-input">
            <p class="processing"></p>
        </div>
    </div>
</div>

<script crossorigin="anonymous" integrity="sha384-U/+EF1mNzvy5eahP9DeB32duTkAmXrePwnRWtuSh1C/bHHhyR1KZCr/aGZBkctpY"
        src="https://lib.baomitu.com/axios/0.18.0/axios.min.js"></script>
<script src="//unpkg.com/vod-js-sdk-v6"></script>
<script>
    var axiosInstance = window.axios.create({
        timeout: 10000,
        headers: {'Authorization': 'Bearer {{$token}}'}
    });
    var tencentError = function (message) {
        $('.error').text(message);
    };
    var tencentReset = function () {
        $('.error').text('');
        $('.processing').text('');
    };
    function uploadVideo(videoFile) {
        const tcVod = new TcVod.default({
            getSignature: function () {
                return axiosInstance.post('/backend/api/v1/video/token/tencent').then(function (response) {
                    if (typeof response.data.code !== 'undefined' && response.data.code === 500) {
                        tencentError(response.data.message || '获取token错误');
                        return null;
                    }
                    return response.data.data.signature;
                });
            }
        });
        const uploader = tcVod.upload({
            videoFile: videoFile,
        });
        uploader.on('video_progress', function (info) {
            $('.processing').text((info.percent * 100) + '%');
        });
        uploader.on('video_upload', function (info) {
        });
        uploader.done().then(function (doneResult) {
            // console.log(doneResult);
            $('.processing').text('上传完成，VID：' + doneResult.fileId);
        });
        return uploader;
    }
    // 文档[https://cloud.tencent.com/document/product/266/9239]
    document.getElementById("tencent-file-input").addEventListener('change', function (event) {
        var files = $('#tencent-file-input').get(0).files;
        if (files.length === 0) {
            return;
        }
        tencentReset();
        window.VodUploader = uploadVideo(files[0]);
    });
</script>

</body>
</html>