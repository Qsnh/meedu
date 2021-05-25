@if ($paginator->hasPages())
    <div class="w-full text-center">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <a href="javascript:void(0)" class="inline-block px-3 mx-2 my-1 text-gray-400 text-sm">上一页</a>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="inline-block px-3 mx-2 my-1 text-gray-700 text-sm">上一页</a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <a href="javascript:void(0)" class="inline-block px-3 py-1 my-1 rounded-full text-gray-700 mx-2 text-sm">
                    {{ $element }}
                </a>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <a href="javascript:void(0)"
                           class="inline-block px-3 py-1 my-1 rounded-full bg-gray-700 text-white mx-2 text-sm">{{ $page }}</a>
                    @else
                        <a class="inline-block px-3 py-1 my-1 rounded-full text-gray-700 hover:bg-gray-300 mx-2 text-sm"
                           href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-block px-3 mx-2 my-1 text-gray-700 text-sm">下一页</a>
        @else
            <a href="javascript:void(0)" class="inline-block px-3 mx-2 my-1 text-gray-400 text-sm">下一页</a>
        @endif
    </div>
@endif
