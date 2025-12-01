
@if (!$products->isEmpty())
    @foreach ($products as $product)
        <div class="card-product grid">
            <div class="card-product_wrapper">

                {{-- Product Image --}}
                <a href="{{ route('product-details', $product->slug) }}" class="product-img">
                    <img class="lazyload img-product"
                        src="{{ asset($product->thumb_image ?? 'frontend/images/noimg.jpg') }}"
                        data-src="{{ asset($product->thumb_image ?? 'frontend/images/noimg.jpg') }}"
                        alt="{{ $product->name }}">
                    @if ($product->gallery && count($product->gallery) > 0)
                        <img class="lazyload img-hover"
                            src="{{ asset($product->gallery[0]->image ?? $product->thumb_image) }}"
                            data-src="{{ asset($product->gallery[0]->image ?? $product->thumb_image) }}"
                            alt="{{ $product->name }}">
                    @endif
                </a>

                <livewire:frontend.shop.shop-product :productId="$product->id" />
                
            </div>

            {{-- Product Info --}}
            <div class="card-product_info">
                <a href="{{ route('product-details', $product->slug) }}" class="name-product h4 link">
                    {{ Str::limit($product->name, 25, '...') }}
                </a>

                <div class="price-wrap">
                    <span class="price-new h6">${{ format_price($product->offer_price) }}</span>
                    @if ($product->discount_option != 1)
                        <span class="price-old h6 fw-normal">${{ format_price($product->base_price) }}</span>
                    @endif
                </div>
                @include('frontend.includes.rating')
            </div>
        </div>
    @endforeach

    {{-- Pagination --}}
    <div class="wd-full wg-pagination mb-4 justify-content-center">

        {{-- Previous Page Link --}}
        @if ($products->onFirstPage())
            <span class="pagination-item h6 direct disabled">
                <i class="icon icon-caret-left"></i>
            </span>
        @else
            <a href="{{ $products->previousPageUrl() }}" class="pagination-item h6 direct">
                <i class="icon icon-caret-left"></i>
            </a>
        @endif

        {{-- Pagination Numbers --}}
        @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
            @if ($page == $products->currentPage())
                <span class="pagination-item h6 active">{{ $page }}</span>
            @else
                <a href="{{ $url }}" class="pagination-item h6">{{ $page }}</a>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="pagination-item h6 direct">
                <i class="icon icon-caret-right"></i>
            </a>
        @else
            <span class="pagination-item h6 direct disabled">
                <i class="icon icon-caret-right"></i>
            </span>
        @endif

    </div>
    
@else
    <div class="empty-content text-center py-5">
        <h5 class="text-danger">Sorry! No Product Found</h5>
        <p>Please try searching for something else</p>
    </div>
@endif

