<div class="index-grid-nav-box">
    @foreach(array_chunk($block['config_render']['items'], $block['config_render']['line_count']) as $rows)
        <div class="grid-nav-item">
            @foreach($rows as $rowItem )
                <a href="{{$rowItem['href']}}" class="nav-item">
                    <div class="icon">
                        <img src="{{$rowItem['src']}}" width="44" height="44">
                    </div>
                    <div class="name">
                        {{$rowItem['name']}}
                    </div>
                </a>
            @endforeach
        </div>
    @endforeach
</div>