@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation">
        <div class="flex justify-between">
            
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 text-gray-600 bg-gray-800 rounded-md cursor-default">
                    &laquo; Prethodna
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" 
                   class="px-4 py-2 text-blue-400 bg-gray-800 rounded-md hover:text-blue-300 transition-colors">
                    &laquo; Prethodna
                </a>
            @endif

           
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" 
                   class="px-4 py-2 text-blue-400 bg-gray-800 rounded-md hover:text-blue-300 transition-colors">
                    Sledeća &raquo;
                </a>
            @else
                <span class="px-4 py-2 text-gray-600 bg-gray-800 rounded-md cursor-default">
                    Sledeća &raquo;
                </span>
            @endif
        </div>
    </nav>
@endif