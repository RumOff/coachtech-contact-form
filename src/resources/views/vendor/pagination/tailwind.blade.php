@if ($paginator->hasPages())
<nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
    {{-- モバイル用レイアウト（省略） --}}
    <div class="flex justify-between flex-1 sm:hidden">
        {{-- ...既存のモバイル用コード... --}}
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        {{-- 左側：Showing... のテキスト（不要ならこの div ごと消してOK） --}}
        <div>
            <p class="text-sm text-gray-700 leading-5">
                {!! __('Showing') !!}
                <span class="font-medium">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-medium">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="font-medium">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex shadow-sm rounded-md">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                <span aria-disabled="true">
                    <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5">&lt;</span>
                </span>
                @else
                <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-l-md leading-5 hover:text-gray-400">&lt;</a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                {{-- Array Of Links --}}
                @if (is_array($element))
                @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();

                // 常に5個表示するための「開始ページ」を計算
                $start = max($current - 2, 1);
                $end = min($start + 4, $last);

                // もし最後の方のページで5個に満たない場合、開始位置を前にずらす
                if ($end - $start < 4) {
                    $start=max($end - 4, 1);
                    }
                    @endphp

                    @foreach ($element as $page=> $url)
                    {{-- 計算した start から end までの間だけ表示する --}}
                    @if ($page >= $start && $page <= $end)
                        @if ($page==$current)
                        <span aria-current="page">
                        <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">{{ $page }}</span>
                        </span>
                        @else
                        <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500">
                            {{ $page }}
                        </a>
                        @endif
                    @endif
                    @endforeach
                    @endif
                    {{--
                    注：is_string($element)（三点リーダー）のセクションは
                    常に非表示にしたいので、あえて記述を削除しています。
                        --}}
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400">&gt;</a>
            @else
            <span aria-disabled="true">
                <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5">&gt;</span>
            </span>
            @endif
            </span>
        </div>
    </div>
</nav>
@endif