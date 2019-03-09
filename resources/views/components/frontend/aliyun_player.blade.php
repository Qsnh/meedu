<link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.8.1/skins/default/aliplayer-min.css" />
<div id="xiaoteng-player"></div>
<script src="https://g.alicdn.com/de/prismplayer/2.8.1/aliplayer-h5-min.js"></script>
<script>
    var player = new Aliplayer({
        "id": "xiaoteng-player",
        "width": "100%",
        "height": "500px",
        "autoplay": false,
        "isLive": false,
        "rePlay": false,
        "playsinline": true,
        "preload": true,
        "autoPlayDelay": 2,
        "autoPlayDelayDisplayText": '正在加载中...',
        "loadDataTimeout": "",
        "controlBarVisibility": "hover",
        "useH5Prism": true,
        "vid": "{{$video->aliyun_video_id}}",
        "playauth": "{{aliyun_play_auth($video)}}",
        "encryptType": 1
    },function(player){
    });

    $(function () {
        $('#xiaoteng-player').on('contextmenu', function (e) {
            e.preventDefault();
            return false;
        });
    });
</script>