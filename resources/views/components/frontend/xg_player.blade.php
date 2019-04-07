<div id="xiaoteng-player"></div>
<script src="//cdn.jsdelivr.net/npm/xgplayer@1.1.3/browser/index.js" type="text/javascript"></script>
<script>
    new Player({
        id: 'xiaoteng-player',
        url: '{{$video->getPlayUrl()}}',
        playbackRate: [0.5, 0.75, 1, 1.5, 2],
        download: false,
        width: '100%',
        height: 500,
        enterLogo:{
            url: '/images/player-logo.png',
            width: 200,
            height: 100
        },
    });
</script>