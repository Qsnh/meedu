<div id="meedu-player"></div>
<script>
    const XGPlayerConfig = {
        el: document.querySelector('#meedu-player'),
        width: window.innerWidth,
        height: 192,
        poster: "{{$gConfig['system']['player_thumb']}}",
        // playbackRate: [0.5, 0.75, 1, 1.5, 2],
        defaultPlaybackRate: 1,
        url: "{!! $playUrls->first()['url'] !!}",
        // 'x5-video-player-type': 'h5',
        // 'x5-video-player-fullscreen': false,
        // 'x5-video-orientation': 'landscape',
        playsinline: false,
        airplay: true,
        useHls: true
    };
            @if($playUrls->first()['format'] === 'm3u8')
    const XGPlayer = new HlsJsPlayer(XGPlayerConfig);
            @else
    const XGPlayer = new Player(XGPlayerConfig);
    @endif

    @if($playUrls->count() > 1)
    XGPlayer.emit('resourceReady', @json($playUrls));
    @endif
</script>