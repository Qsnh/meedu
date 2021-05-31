@extends('frontend.layouts.member')

@section('member')

    @forelse($records as $recordItem)
        @continue(!($videoItem = $videos[$recordItem['video_id'] ?? null]))
        <div class="bg-white p-5 mb-5 rounded shadow">
            <a href="{{route('video.show', [$videoItem['course_id'], $videoItem['id'], $videoItem['slug']])}}"
               class="flex items-center text-gray-500 group">
                <div class="flex-1 group-hover:text-gray-600">
                    {{$videoItem['title']}}
                </div>
                <div class="flex-shrink-0 ml-3 text-gray-400">
                    {{duration_humans($videoItem['duration'])}}
                </div>
            </a>
        </div>
    @empty
        @include('frontend.components.none')
    @endforelse

    <div>
        {{$records->render('frontend.components.common.paginator')}}
    </div>

@endsection