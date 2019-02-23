<div id="xiaoteng-player"></div>
<script src="https://g.alicdn.com/de/prismplayer/2.7.2/aliplayer-min.js"></script>
<script>
    var player = new Aliplayer({
        "id": "xiaoteng-player",
        "qualitySort": "asc",
        "format": "mp4",
        "mediaType": "video",
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
        "source": "{{$video->getPlayUrl()}}",
    },function(player){
    });

    $(function () {
        $('#xiaoteng-player').on('contextmenu', function (e) {
            e.preventDefault();
            return false;
        });
    });
</script>