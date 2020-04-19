<div id="meedu-player"></div>
<script>
    const XGPlayerConfig = {
        el: document.querySelector('#meedu-player'),
        width: 1200,
        height: 675,
        poster: "{{$gConfig['system']['player_thumb']}}",
        playsinline: true,
        playbackRate: [0.5, 0.75, 1, 1.5, 2],
        defaultPlaybackRate: 1,
        pip: true,
        cssFullscreen: true,
        url: "{{$playUrls->first()['url']}}",
        keyShortcut: 'on',
        definitionActive: 'click'
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