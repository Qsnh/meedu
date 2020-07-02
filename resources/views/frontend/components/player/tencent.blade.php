<link href="https://imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.css" rel="stylesheet">
<script src="https://imgcache.qq.com/open/qcloud/video/tcplayer/libs/hls.min.0.13.2m.js"></script>
<script src="https://imgcache.qq.com/open/qcloud/video/tcplayer/tcplayer.v4.1.min.js"></script>
<div id="meedu-player">
    <video id="xiaoteng-player" preload="auto" playsinline webkit-playsinline></video>
</div>
<script>
    var tcPlayer = TCPlayer('xiaoteng-player', {
        fileID: '{{$video['tencent_video_id']}}',
        appID: '{{config('tencent.vod.app_id')}}',
        poster: '{{$gConfig['system']['player_thumb']}}',
        playbackRates: [0.5, 1, 1.25, 1.5, 2],
        plugins: {
            ContinuePlay: {},
        },
        controlBar: {
            @if($video['ban_drag'] === 1)
            progressControl: false,
            @endif
            playToggle: true
        },
        psign: '{{app()->make(\App\Meedu\Player\TencentKey::class)->psign($video, isset($isTry) ? $isTry : false)}}'
    });

    var PREV_SECONDS = 0;
    var recordHandle = function (isEnd = false) {
        var s = parseInt(tcPlayer.currentTime());
        if (s > PREV_SECONDS) {
            PREV_SECONDS = s;
            $.post('{{route('ajax.video.watch.record', [$video['id']])}}', {
                _token: '{{csrf_token()}}',
                duration: (isEnd ? s + 1 : s)
            }, function (res) {
            }, 'json');
        }
    };
    setInterval('recordHandle()', 10000);
    tcPlayer.on('ended', function () {
        recordHandle(true);
        $('#meedu-player').hide();
        $('.need-login').show();
    });
</script>