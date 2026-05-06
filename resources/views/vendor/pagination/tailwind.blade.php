@if ($paginator->hasPages())
<nav class="flex items-center gap-1.5" aria-label="Pagination">

    {{-- Previous --}}
    @if ($paginator->onFirstPage())
        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed bg-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}"
           class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)

        {{-- Ellipsis --}}
        @if (is_string($element))
            <span class="w-9 h-9 flex items-center justify-center text-sm text-gray-400">
                {{ $element }}
            </span>
        @endif

        {{-- Page numbers --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg text-sm font-semibold text-white"
                          style="background:#6C63FF;">
                        {{ $page }}
                    </span>
                @else
                    <a href="{{ $url }}"
                       class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-sm font-medium text-gray-600 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all">
                        {{ $page }}
                    </a>
                @endif
            @endforeach
        @endif

    @endforeach

    {{-- Next --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}"
           class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 bg-white hover:bg-gray-50 hover:border-gray-300 transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </a>
    @else
        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 cursor-not-allowed bg-white">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </span>
    @endif

</nav>
@endif
