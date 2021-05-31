@if($video['aliyun_video_id'] && (int)($gConfig['system']['player']['enabled_aliyun_private'] ?? 0) === 1)
    @include('frontend.components.player.aliyun', ['video' => $video, 'isTry' => isset($isTry) ? $isTry : false])
@else
    @if($video['player_pc'] === \App\Constant\FrontendConstant::PLAYER_ALIYUN)
        @include('frontend.components.player.aliyun', ['video' => $video, 'isTry' => isset($isTry) ? $isTry : false])
    @elseif($video['player_pc'] === \App\Constant\FrontendConstant::PLAYER_TENCENT)
        @include('frontend.components.player.tencent', ['video' => $video, 'isTry' => isset($isTry) ? $isTry : false])
    @else
        @include('frontend.components.player.xg', ['video' => $video, 'isTry' => isset($isTry) ? $isTry : false])
    @endif
@endif