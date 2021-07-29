<div class="w-full px-3 pb-6 lg:max-w-6xl lg:mx-auto">
    <div class="mb-20">
        <div class="text-3xl text-gray-900 pb-12 flex justify-center">
            <span class="ml-3 font-bold">{{$block['config_render']['title']}}</span>
        </div>
        <div class="grid gap-6 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4">
            @foreach($block['config_render']['items'] as $index => $course)
                @continue(!$course['id'])
                @include('frontend.components.course-item', ['course' => $course])
            @endforeach
        </div>
    </div>
</div>