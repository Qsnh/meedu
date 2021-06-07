<div style="background-color: #0F0B1E;margin-top: 150px">
    <div class="max-w-7xl mx-auto py-12 overflow-hidden">
        <div class="text-center text-sm text-gray-600">
            &copy;
            {{date('Y')}}
            {{config('app.name')}}
            @if($gConfig['system']['icp'])
            &bull;
            <a href="{{$gConfig['system']['icp_link'] ?: 'http://beian.miit.gov.cn'}}"
               target="_blank">{{$gConfig['system']['icp']}}</a>
            @endif
            @if($gConfig['system']['icp2'])
            &bull;
            <a href="{{$gConfig['system']['icp2_link']}}" target="_blank">{{$gConfig['system']['icp2']}}</a>
            @endif
        </div>
        <div class="text-center text-sm text-gray-600 mt-3">
            PoweredBy <a href="https://meedu.vip" target="_blank">MeEdu</a>
        </div>
    </div>
</div>