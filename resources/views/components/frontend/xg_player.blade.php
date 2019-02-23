<div id="xiaoteng-player"></div>
<script>
    $(function () {
        var xgPalyer = new Player({
            id: 'xiaoteng-player',
            url: '{{$video->getPlayUrl()}}',
            fluid: true,
            playbackRate: [0.5, 0.75, 1, 1.5, 2],
            download: false,
            enterLogo:{
                url: '/images/player-logo.png',
                width: 200,
                height: 100
            },
        });

        $('#xiaoteng-player').on('contextmenu', function (e) {
            e.preventDefault();
            return false;
        });
    });
</script>