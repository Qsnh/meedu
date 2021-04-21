@if((int)$gConfig['mp_wechat']['enabled_share'] === 1 && is_wechat())
    <script src="https://res.wx.qq.com/open/js/jweixin-1.6.0.js"></script>
    <script>
        wx.config(@json(wechat_jssdk(['updateAppMessageShareData', 'updateTimelineShareData'])));
        var config = {
            title: '{{$gConfig['mp_wechat']['share']['title']}}',
            desc: '{{$gConfig['mp_wechat']['share']['desc']}}',
            imgUrl: '{{$gConfig['mp_wechat']['share']['imgUrl']}}',
            link: '{{request()->fullUrl()}}'
        };
        if (typeof window.wechatShareInfo !== 'undefined') {
            Object.assign(config, window.wechatShareInfo);
        }

        wx.ready(function () {
            wx.updateAppMessageShareData(config);

            // 删除desc字段
            delete config.desc;
            wx.updateTimelineShareData(config);
        });
    </script>
@endif