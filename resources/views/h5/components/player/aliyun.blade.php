<link rel="stylesheet" href="https://g.alicdn.com/de/prismplayer/2.8.1/skins/default/aliplayer-min.css"/>
<div id="xiaoteng-player"></div>
<script src="https://g.alicdn.com/de/prismplayer/2.8.1/aliplayer-h5-min.js"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('/js/aliplayercomponents-1.0.3.min.js')}}"></script>
<script>
    var ALI_PLAYER = new Aliplayer({
        "id": "xiaoteng-player",
        "width": "100%",
        "height": "192px",
        "autoplay": false,
        "isLive": false,
        "rePlay": false,
        "playsinline": true,
        "preload": true,
        "cover": "{{$gConfig['system']['player_thumb']}}",
        "controlBarVisibility": "hover",
        "useH5Prism": true,
        "vid": "{{$video['aliyun_video_id']}}",
        "playauth": "{{aliyun_play_auth($video, isset($isTry) ? $isTry : false)}}",
        "skinLayout": [
            {
                "name": "bigPlayButton",
                "align": "blabs",
                "x": 30,
                "y": 80
            },
            {
                "name": "H5Loading",
                "align": "cc"
            },
            {
                "name": "errorDisplay",
                "align": "tlabs",
                "x": 0,
                "y": 0
            },
            {
                "name": "infoDisplay"
            },
            {
                "name": "tooltip",
                "align": "blabs",
                "x": 0,
                "y": 56
            },
            {
                "name": "thumbnail"
            },
            {
                "name": "controlBar",
                "align": "blabs",
                "x": 0,
                "y": 0,
                "children": [
                        @if($video['ban_drag'] !== 1)
                    {
                        "name": "progress",
                        "align": "blabs",
                        "x": 0,
                        "y": 44
                    },
                        @endif
                    {
                        "name": "playButton",
                        "align": "tl",
                        "x": 15,
                        "y": 12
                    },
                    {
                        "name": "timeDisplay",
                        "align": "tl",
                        "x": 10,
                        "y": 7
                    },
                    {
                        "name": "fullScreenButton",
                        "align": "tr",
                        "x": 10,
                        "y": 12
                    },
                    {
                        "name": "volume",
                        "align": "tr",
                        "x": 5,
                        "y": 10
                    }
                ]
            }
        ],
        @if((int)($gConfig['system']['player']['enabled_aliyun_private'] ?? 0) === 1)
        "encryptType": 1,
        @endif
        components: [
                @if((int)$gConfig['system']['player']['enabled_bullet_secret'] === 1)
            {
                name: 'BulletScreenComponent',
                type: AliPlayerComponent.BulletScreenComponent,
                args: ['{{$user ? sprintf('会员%s', $user['mobile']) : config('app.name')}}', {
                    fontSize: '16px',
                    color: '#000000'
                }, 'random']
            }
            @endif
        ]
    }, function (player) {
    });

    var PREV_SECONDS = 0;
    var recordHandle = function (isEnd = false) {
        var s = parseInt(ALI_PLAYER.getCurrentTime());
        if (s > PREV_SECONDS) {
            PREV_SECONDS = s;
            $.post('{{route('ajax.video.watch.record', [$video['id']])}}', {
                _token: '{{csrf_token()}}',
                duration: (isEnd ? s + 1 : s)
            }, function (res) {
                console.log(res);
            }, 'json');
        }
    };
    setInterval('recordHandle()', 10000);
    ALI_PLAYER.on('ended', function () {
        recordHandle(true);
        $('#xiaoteng-player').hide();
        $('.watched-over').show();
    });
</script>