<div class="index-image-group-box">
    @if($block['config_render']['v'] === 'v-1')
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][0]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][0]['src'] ?? ''}}" width="100%">
            </a>
        </div>
    @elseif ($block['config_render']['v'] === 'v-2')
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][0]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][0]['src'] ?? ''}}" width="100%">
            </a>
        </div>
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][1]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][1]['src'] ?? ''}}" width="100%">
            </a>
        </div>
    @elseif ($block['config_render']['v'] === 'v-3')
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][0]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][0]['src'] ?? ''}}" width="100%">
            </a>
        </div>
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][1]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][1]['src'] ?? ''}}" width="100%">
            </a>
        </div>
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][2]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][2]['src'] ?? ''}}" width="100%">
            </a>
        </div>
    @elseif ($block['config_render']['v'] === 'v-4')
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][0]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][0]['src'] ?? ''}}" width="100%">
            </a>
        </div>
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][1]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][1]['src'] ?? ''}}" width="100%">
            </a>
        </div>
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][2]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][2]['src'] ?? ''}}" width="100%">
            </a>
        </div>
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][3]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][3]['src'] ?? ''}}" width="100%">
            </a>
        </div>
    @elseif ($block['config_render']['v'] === 'v-1-2')
        <div class="image-group-item">
            <a href="{{$block['config_render']['items'][0]['url'] ?? ''}}">
                <img src="{{$block['config_render']['items'][0]['src'] ?? ''}}" width="100%">
            </a>
        </div>
        <div class="image-group-item">
            <div>
                <a href="{{$block['config_render']['items'][1]['url'] ?? ''}}">
                    <img src="{{$block['config_render']['items'][1]['src'] ?? ''}}" width="100%">
                </a>
            </div>
            <div>
                <a href="{{$block['config_render']['items'][2]['url'] ?? ''}}">
                    <img src="{{$block['config_render']['items'][2]['src'] ?? ''}}" width="100%">
                </a>
            </div>
        </div>
    @endif
</div>