@if ($paginator->hasPages())
    <ul class="pagination pagination-template d-flex justify-content-center">
       
        @if ($paginator->onFirstPage())
            <li class="disabled page-item">
                <span><i class="fa fa-angle-left"></i></span>
            </li>
        @else
            <li class="page-item">
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="page-link"><i class="fa fa-angle-left"></i></a>
            </li>
        @endif


      
        @foreach ($elements as $element)
           
            @if (is_string($element))
                <li class="disabled page-item">
                    <span>{{ $element }}</span>
                </li>
            @endif


           
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active my-active page-item">
                            <span>{{ $page }}</span>
                        </li>
                    @else
                        <li class="page-item">
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach


        
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="page-link"><i class="fa fa-angle-right"></i></a>
            </li>
        @else
            <li class="disabled page-item">
                <span><i class="fa fa-angle-right"></i></span>
            </li>
        @endif
    </ul>
@endif