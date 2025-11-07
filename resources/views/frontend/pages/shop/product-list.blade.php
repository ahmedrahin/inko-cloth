
    @if (!$products->isEmpty())
        @foreach ($products as $product)
            <div class="card-product grid" data-availability="In stock" data-brand="{{ $product->brand->name ?? '' }}">
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

                    {{-- Action Buttons --}}
                    <ul class="product-action_list">
                        <li>
                            <a href="#shoppingCart" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon">
                                <span class="icon icon-shopping-cart-simple"></span>
                                <span class="tooltip">Add to cart</span>
                            </a>
                        </li>
                        <li class="wishlist">
                            <a href="javascript:void(0);" class="hover-tooltip tooltip-left box-icon">
                                <span class="icon icon-heart"></span>
                                <span class="tooltip">Add to Wishlist</span>
                            </a>
                        </li>
                        <li class="compare">
                            <a href="#compare" data-bs-toggle="offcanvas" class="hover-tooltip tooltip-left box-icon ">
                                <span class="icon icon-compare"></span>
                                <span class="tooltip">Compare</span>
                            </a>
                        </li>
                        <li>
                            <a href="#quickView" data-bs-toggle="modal" class="hover-tooltip tooltip-left box-icon">
                                <span class="icon icon-view"></span>
                                <span class="tooltip">Quick view</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Product Info --}}
                <div class="card-product_info">
                    <a href="{{ route('product-details', $product->slug) }}" class="name-product h4 link">
                        {{ $product->name }}
                    </a>

                    <div class="price-wrap">
                        <span class="price-new h6">{{ format_price($product->offer_price) }}৳</span>
                        @if ($product->discount_option != 1)
                            <span class="price-old h6 fw-normal">{{ format_price($product->base_price) }}৳</span>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Pagination --}}
        <div class="wd-full wg-pagination m-0 justify-content-center">

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

