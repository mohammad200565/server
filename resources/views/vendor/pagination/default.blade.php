@if ($paginator->hasPages())
    @php
        $current = $paginator->currentPage();
        $last = $paginator->lastPage();
        
        // For few pages, show all
        if ($last <= 7) {
            $showAll = true;
        } else {
            $showAll = false;
            // Show 2 pages on each side of current
            $window = 2;
        }
    @endphp

    <div class="pagination-container">
        <nav class="pagination-modern" role="navigation" aria-label="Pagination Navigation">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn pagination-prev disabled">
                    <svg class="pagination-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span class="pagination-btn-text">Previous</span>
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn pagination-prev">
                    <svg class="pagination-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span class="pagination-btn-text">Previous</span>
                </a>
            @endif

            {{-- Page Numbers --}}
            <div class="pagination-numbers">
                @if ($showAll)
                    {{-- Show all pages --}}
                    @for ($i = 1; $i <= $last; $i++)
                        @if ($i == $current)
                            <span class="pagination-number active" aria-current="page">{{ $i }}</span>
                        @else
                            <a href="{{ $paginator->url($i) }}" class="pagination-number">{{ $i }}</a>
                        @endif
                    @endfor
                @else
                    {{-- Smart pagination for many pages --}}
                    {{-- First Page --}}
                    <a href="{{ $paginator->url(1) }}" class="pagination-number @if($current == 1) active @endif">1</a>
                    
                    {{-- Left Dots --}}
                    @if ($current > 4)
                        <span class="pagination-ellipsis">...</span>
                    @endif
                    
                    {{-- Pages around current --}}
                    @for ($i = max(2, $current - $window); $i <= min($last - 1, $current + $window); $i++)
                        @if ($i == $current)
                            <span class="pagination-number active" aria-current="page">{{ $i }}</span>
                        @else
                            <a href="{{ $paginator->url($i) }}" class="pagination-number">{{ $i }}</a>
                        @endif
                    @endfor
                    
                    {{-- Right Dots --}}
                    @if ($current < $last - 3)
                        <span class="pagination-ellipsis">...</span>
                    @endif
                    
                    {{-- Last Page --}}
                    <a href="{{ $paginator->url($last) }}" class="pagination-number @if($current == $last) active @endif">{{ $last }}</a>
                @endif
            </div>

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn pagination-next">
                    <span class="pagination-btn-text">Next</span>
                    <svg class="pagination-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            @else
                <span class="pagination-btn pagination-next disabled">
                    <span class="pagination-btn-text">Next</span>
                    <svg class="pagination-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 5l7 7-7 7"/>
                    </svg>
                </span>
            @endif
        </nav>

        {{-- Page Info --}}
        <div class="pagination-info">
            Showing {{ $paginator->firstItem() ?? 0 }} to {{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }} results
            (Page {{ $current }} of {{ $last }})
        </div>
    </div>
@endif