{{-- <div class="main-content p-items-wrap">
    @if (!$products->isEmpty())
    @foreach ($products as $product)
    <div class="p-item">
        <div class="p-item-inner">
            <div class="p-item-img"><a href="{{ route('product-details', $product->slug) }}"><img
                        src="{{ asset($product->thumb_image) }}" alt="{{ $product->name }}" width="228"
                        height="228"></a></div>
            <div class="p-item-details">
                <h4 class="p-item-name"> <a href="{{ route('product-details', $product->slug) }}">
                        {{ $product->name }}</a></h4>
                @if (!is_null($product->short_description) && $product->short_description != '<p><br></p>')
                <div class="short-description">
                    {!! $product->short_description !!}
                </div>
                @endif
                <div class="p-item-price">
                    <span class="price-new">{{ format_price($product->offer_price) }}৳</span>
                    @if ($product->discount_option != 1 )
                    <span class="price-old">{{ format_price($product->base_price) }}৳</span>
                    @endif
                </div>

                <livewire:frontend.shop.shop-product :productId="$product->id" />
            </div>
        </div>
    </div>
    @endforeach
    @else
    <div class="empty-content">
        <span class="icon material-icons">assignment</span>
        <div class="empty-text ">
            <h5>Sorry! No Product Founds</h5>
            <p>Please try searching for something else</p>
        </div>
    </div>
    @endif
</div> --}}


<div class="bottom-bar">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <ul class="pagination">
                {{-- PREV Button --}}
                @if ($products->onFirstPage())
                <li><span class="disabled">PREV</span></li>
                @else
                <li>
                    <a href="{{ $products->previousPageUrl() }}" style="cursor:pointer;">PREV</a>
                </li>
                @endif

                {{-- Page Numbers --}}
                @for ($page = 1; $page <= $products->lastPage(); $page++)
                    @if ($page == $products->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                    @else
                    <li>
                        <a href="{{ $products->url($page) }}" style="cursor:pointer;">{{ $page }}</a>
                    </li>
                    @endif
                    @endfor

                    {{-- NEXT Button --}}
                    @if ($products->hasMorePages())
                    <li>
                        <a href="{{ $products->nextPageUrl() }}" style="cursor:pointer;">NEXT</a>
                    </li>
                    @else
                    <li><span class="disabled">NEXT</span></li>
                    @endif
            </ul>
        </div>

        <div class="col-md-6 rs-none text-right">
            <p>
                Showing {{ $products->firstItem() }} to {{ $products->lastItem() }} of {{
                $products->total() }} ({{ $products->lastPage() }} Pages)
            </p>
        </div>
    </div>
</div>

<div class="wrapper-shop tf-grid-layout tf-col-3" id="gridLayout">
    <!-- Product 1 -->
    <div class="card-product grid" data-availability="In stock" data-brand="fisoew">
        <div class="card-product_wrapper">
            <a href="product-detail.html" class="product-img">
                <img class="lazyload img-product" src="images/products/product-23.jpg"
                    data-src="images/products/product-23.jpg" alt="Product">
                <img class="lazyload img-hover" src="images/products/product-24.jpg"
                    data-src="images/products/product-24.jpg" alt="Product">
            </a>
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
            <ul class="product-badge_list">
                <li class="product-badge_item h6 hot">Hot</li>
            </ul>
            <div class="product-countdown">
                <div class="js-countdown cd-has-zero" data-timer="25472" data-labels="d : ,h : ,m : ,s"></div>
            </div>
        </div>
        <div class="card-product_info">
            <a href="product-detail.html" class="name-product h4 link">V-neck button down vest</a>
            <div class="price-wrap">
                <span class="price-old h6 fw-normal">$99,99</span>
                <span class="price-new h6">$69,99</span>
            </div>
            <ul class="product-color_list">
                <li class="product-color-item color-swatch hover-tooltip tooltip-bot active">
                    <span class="tooltip color-filter">Beige</span>
                    <span class="swatch-value bg-light-beige"></span>
                    <img class="lazyload" src="images/products/product-23.jpg" data-src="images/products/product-23.jpg"
                        alt="Product">
                </li>
                <li class="product-color-item color-swatch hover-tooltip tooltip-bot">
                    <span class="tooltip color-filter">Dark</span>
                    <span class="swatch-value bg-dark-charcoal"></span>
                    <img class="lazyload" src="images/products/product-25.jpg" data-src="images/products/product-25.jpg"
                        alt="Product">

                </li>
                <li class="product-color-item color-swatch hover-tooltip tooltip-bot">
                    <span class="tooltip color-filter">Sage Green</span>
                    <span class="swatch-value bg-sage-green"></span>
                    <img class="lazyload" src="images/products/product-26.jpg" data-src="images/products/product-26.jpg"
                        alt="Product">
                </li>
            </ul>
        </div>
    </div>
    <!-- Pagination -->
    <div class="wd-full wg-pagination m-0 justify-content-center">
        <a href="#" class="pagination-item h6 direct"><i class="icon icon-caret-left"></i></a>
        <a href="#" class="pagination-item h6">1</a>
        <span class="pagination-item h6 active">2</span>
        <a href="#" class="pagination-item h6">3</a>
        <a href="#" class="pagination-item h6">4</a>
        <a href="#" class="pagination-item h6">5</a>
        <a href="#" class="pagination-item h6 direct"><i class="icon icon-caret-right"></i></a>
    </div>
</div>