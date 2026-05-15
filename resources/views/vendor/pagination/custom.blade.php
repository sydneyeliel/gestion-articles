@if ($paginator->hasPages())
<nav class="flex items-center justify-between gap-4 flex-wrap" aria-label="Pagination">

    {{-- Infos résultats --}}
    <p class="text-sm font-medium" style="color:#6C63FF;">
        Showing <span class="font-semibold" style="color:#1A1A2E;">{{ $paginator->firstItem() }}</span>
        to <span class="font-semibold" style="color:#1A1A2E;">{{ $paginator->lastItem() }}</span>
        of <span class="font-semibold" style="color:#1A1A2E;">{{ $paginator->total() }}</span> results
    </p>

    {{-- Boutons --}}
    <div class="flex items-center gap-1">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-2 rounded-lg text-sm font-medium cursor-not-allowed select-none"
                  style="color:#D1D5DB;background:#F9FAFB;border:1px solid #E5E7EB;">
                ‹
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="px-3 py-2 rounded-lg text-sm font-medium transition-all hover:opacity-80"
               style="color:#6C63FF;background:#F5F4FF;border:1px solid #E5E7EB;">
                ‹
            </a>
        @endif

        {{-- Pages --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-3 py-2 text-sm" style="color:#9CA3AF;">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-2 rounded-lg text-sm font-semibold text-white"
                              style="background:#6C63FF;border:1px solid #6C63FF;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           class="px-3 py-2 rounded-lg text-sm font-medium transition-all hover:opacity-80"
                           style="color:#1A1A2E;background:#ffffff;border:1px solid #E5E7EB;">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="px-3 py-2 rounded-lg text-sm font-medium transition-all hover:opacity-80"
               style="color:#6C63FF;background:#F5F4FF;border:1px solid #E5E7EB;">
                ›
            </a>
        @else
            <span class="px-3 py-2 rounded-lg text-sm font-medium cursor-not-allowed select-none"
                  style="color:#D1D5DB;background:#F9FAFB;border:1px solid #E5E7EB;">
                ›
            </span>
        @endif

    </div>
</nav>
@endif
