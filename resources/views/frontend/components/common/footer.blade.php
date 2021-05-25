<footer>
    <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
        <p class="text-center text-base text-gray-400">
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
        </p>
    </div>
</footer>