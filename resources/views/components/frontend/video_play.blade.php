<div id="player"></div>
<script src="https://g.alicdn.com/de/prismplayer/2.7.2/aliplayer-min.js"></script>
@if($video->url != '')
    <script>
        var player = new Aliplayer({
            "id": "player",
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
            "source": "{{$video->url}}",
        },function(player){
        });
    </script>
    @else
    <script>
        var player = new Aliplayer({
            "id": "player",
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
            "vid" : '{{$video->aliyun_video_id}}',
            "playauth" : '{{aliyun_play_auth($video)}}',
        },function(player){
        });
    </script>
@endif