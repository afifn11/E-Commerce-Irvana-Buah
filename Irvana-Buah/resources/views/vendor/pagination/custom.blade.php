@if ($paginator->hasPages())
<nav role="navigation" aria-label="Pagination">
    <ul>
        {{-- Previous Page --}}
        @if ($paginator->onFirstPage())
            <li style="opacity:0.4; pointer-events:none;">
                <a href="#" aria-disabled="true"><i class="bi bi-chevron-left"></i></a>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="bi bi-chevron-left"></i></a>
            </li>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="ellipsis">{{ $element }}</li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li><a href="{{ $url }}" class="active" aria-current="page"><span>{{ $page }}</span></a></li>
                    @else
                        <li><a href="{{ $url }}"><span>{{ $page }}</span></a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="bi bi-chevron-right"></i></a>
            </li>
        @else
            <li style="opacity:0.4; pointer-events:none;">
                <a href="#" aria-disabled="true"><i class="bi bi-chevron-right"></i></a>
            </li>
        @endif
    </ul>
</nav>
@endif
