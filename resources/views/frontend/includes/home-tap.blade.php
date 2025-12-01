 <div class="flat-spacing flat-animate-tab pt-0">
    <div class="container">
        <div class="sect-title wow fadeInUp">
            <div class="h1 title text-center mb-24">Most Popular Products</div>
            <ul class="tab-product_list" role="tablist">
                <li class="nav-tab-item" role="presentation">
                    <a href="#trending" data-bs-toggle="tab" class="tf-btn-line tf-btn-tab active"> TRENDING </a>
                </li>
                <li class="nav-tab-item" role="presentation">
                    <a href="#best-seller" data-bs-toggle="tab" class="tf-btn-line tf-btn-tab"> Best selling </a>
                </li>
                <li class="nav-tab-item" role="presentation">
                    <a href="#on-sale" data-bs-toggle="tab" class="tf-btn-line tf-btn-tab"> Top Rated This Month </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane active show" id="trending" role="tabpanel">
                
                @if (!$trending->isEmpty())
                   <div class="wrapper-control-shop gridLayout-wrapper" >
                        <div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
                            @foreach ($trending as $product)
                                <div class="card-product grid">
                                    <div class="card-product_wrapper">
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
                        </div>
                    </div>
                @else
                    @include('frontend.includes.no-found')
                @endif
            </div>

            <div class="tab-pane" id="best-seller" role="tabpanel">
                @if ($selling->isEmpty())
                    <div class="wrapper-control-shop gridLayout-wrapper" >
                        <div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
                            @foreach ($selling as $product)
                                <div class="card-product grid">
                                    <div class="card-product_wrapper">
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
                        </div>
                    </div>
                @else
                    @include('frontend.includes.no-found')
                @endif
            </div>

            <div class="tab-pane" id="on-sale" role="tabpanel">
                @if (!$topReviewed ->isEmpty())
                    <div class="wrapper-control-shop gridLayout-wrapper" >
                        <div class="wrapper-shop tf-grid-layout tf-col-4" id="gridLayout">
                            @foreach ($topReviewed as $product)
                                <div class="card-product grid">
                                    <div class="card-product_wrapper">
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
                        </div>
                    </div>
                @else
                    @include('frontend.includes.no-found')
                @endif
            </div>
        </div>
    </div>
</div>