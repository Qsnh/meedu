<div id="meedu-player" style="width: 100%;height: 500px;background-color: #000"></div>
<script>
    $(function () {
        var dplayerObj = null;

        $.post('{{route('ajax.video.playUrls')}}', {
            data: '{{encrypt(['video_id' => $videoItem['id'], 'is_try' => $isTry ? 1 : 0, 'time' => time()])}}',
            _token: $('meta[name="csrf-token"]').attr('content')
        }, function (res) {
            if (res.code !== 0) {
                window.flashError(res.message);
            } else {
                var list = [];
                for (var i = 0; i < res.data.length; i++) {
                    var item = res.data[i];
                    list.push({
                        name: item.name,
                        url: item.url,
                        type: 'auto',
                    })
                }

                dplayerObj = new DPlayer({
                    container: document.getElementById('meedu-player'),
                    preload: 'metadata',
                    video: {
                        defaultQuality: 0,
                        quality: list,
                        pic: "{{$gConfig['system']['player_thumb']}}",
                    }
                });

                var PREV_SECONDS = 0;
                window.recordHandle = function (isEnd = false) {
                    var s = parseInt(dplayerObj.video.currentTime);
                    if (s > PREV_SECONDS) {
                        PREV_SECONDS = s;
                        $.post('{{route('ajax.video.watch.record', [$video['id']])}}', {
                            _token: '{{csrf_token()}}',
                            duration: (isEnd ? s + 1 : s)
                        }, function (res) {
                            // console.log(res);
                        }, 'json');
                    }
                };

                setInterval('recordHandle()', 10000);

                dplayerObj.on('ended', function () {
                    recordHandle(true);
                    $('#meedu-player').hide();
                    $('.video-play-alert-info').show();
                });
            }
        }, 'json');

        function randomString(e) {
            e = e || 32;
            var t = "ABCDEFGHJKMNPQRSTWXYZabcdefhijkmnprstwxyz2345678",
                a = t.length,
                n = "";
            for (i = 0; i < e; i++) {
                n += t.charAt(Math.floor(Math.random() * a));
            }
            return n
        }

        function randomNum(min, max) {
            return (min + Math.round((max - min) * Math.random()));
        }

        // 跑马灯
        @if((int)$gConfig['system']['player']['enabled_bullet_secret'] === 1)
        setInterval(function () {
            var domId = randomString(12);
            var top = randomNum(0, $('.dplayer-video-wrap').height());
            var left = randomNum(0, $('.dplayer-video-wrap').width() - 100);
            $('.dplayer-video-wrap').append(`
            <div class="${domId}" style="position:absolute;top:${top}px !important;left:${left}px !important;color:red;width: auto;font-size: 10px">{{$user['mobile']}}</div>
            `);
            setTimeout(function () {
                $('.' + domId).remove();
            }, 4500);
        }, 5000);
        @endif
    });
</script>