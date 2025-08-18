<div class="row g-0 align-items-center pb-4">
    <div class="col-sm-6">
        <div>
            <p class="mb-sm-0">
                نمایش {{ $paginator->firstItem() }} تا {{ $paginator->lastItem() }} از {{ $paginator->total() }} ورودی
            </p>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="float-sm-end">
            <ul class="pagination mb-sm-0">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i class="mdi mdi-chevron-left"></i></a>
                </li>
                @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="mdi mdi-chevron-left"></i></a>
                </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><a class="page-link" href="#">{{ $element }}</a>
                    </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><a class="page-link" href="#">{{ $page }}</a></li>
                            @else
                            <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i
                            class="mdi mdi-chevron-right"></i></a>
                </li>
                @else
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true"><i
                            class="mdi mdi-chevron-right"></i></a>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>