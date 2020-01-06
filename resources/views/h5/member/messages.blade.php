@extends('h5.app-notab')

@section('content')

    <div class="weui-flex">
        <div class="weui-flex__item">
            <div class="weui-tab">
                <div class="weui-navbar">
                    <div class="weui-navbar__item" data-tab="message">
                        我的消息
                    </div>
                    <div class="weui-navbar__item weui-bar__item_on" data-tab="announcement">
                        公告
                    </div>
                </div>
                <div class="weui-tab__panel">
                    <div id="message" style="display: none">
                        <div class="weui-panel">
                            <div class="weui-panel__bd">
                                @forelse($messages as $message)
                                    <div class="weui-media-box weui-media-box_text">
                                        <p class="weui-media-box__desc">{!! $message['message'] !!}</p>
                                    </div>
                                @empty
                                    @include('h5.components.none')
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div id="announcement">
                        <div class="weui-panel">
                            <div class="weui-panel__bd">
                                <div class="weui-media-box weui-media-box_text">
                                    @if($gAnnouncement)
                                        <p class="weui-media-box__desc">{!! $gAnnouncement['announcement'] !!}</p>
                                    @else
                                        @include('h5.components.none')
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function () {
            $('.weui-navbar__item').on('click', function () {
                $(this).addClass('weui-bar__item_on').siblings('.weui-bar__item_on').removeClass('weui-bar__item_on');
                var tab = $(this).attr('data-tab');
                $("#" + tab).show().siblings().hide();
            });
        });
    </script>

@endsection