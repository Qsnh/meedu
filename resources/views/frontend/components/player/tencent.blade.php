<link href="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.css" rel="stylesheet">
<script src="//imgcache.qq.com/open/qcloud/video/tcplayer/libs/hls.min.0.12.4.js"></script>
<script src="//imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.min.js"></script>
<video id="xiaoteng-player" preload="auto" playsinline webkit-playsinline></video>
<script>
    TCPlayer('xiaoteng-player', {
        fileID: '{{$video['tencent_video_id']}}',
        appID: '{{config('tencent.vod.app_id')}}',
        poster: '{{$gConfig['system']['player_thumb']}}'
    });
</script>