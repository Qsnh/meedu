<div class="tabs">
    @foreach($tabs as $index => $tabItem)
        <div class="tabs-item {{$index === $active ? 'active' : ''}}" data-index="{{$index}}"
             data-dom="{{$tabItem['dom'] ?? ''}}">{{$tabItem['name']}}</div>
    @endforeach
    <div class="scroll-banner"></div>
</div>