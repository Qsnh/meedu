<div class="top-navbar {{$class ?? ''}}">
    @if(isset($back))
        <a href="javascript:void(0)" class="back back-button"
           data-url="{{$back === request()->url() ? route('index') : $back}}">
            <img src="{{ isset($class) ? asset('/h5/images/icons/back-white.png') : asset('/h5/images/icons/back.png')}}"
                 width="24" height="24">
        </a>
    @endif
    <span class="title">{{$title}}</span>
</div>