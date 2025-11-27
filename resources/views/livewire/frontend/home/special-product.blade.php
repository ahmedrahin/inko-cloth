<div class="flat-spacing flat-animate-tab pt-0">
    <div class="container">
        <div class="sect-title wow fadeInUp">
            <div class="h1 title text-center mb-24">Featured Products</div>
        </div>

        <div class="wrapper-shop tf-grid-layout tf-col-4">
            @if (!$featuredProducts->isEmpty())
                @foreach ($featuredProducts as $product)
                    <div class="card-product grid" data-availability="In stock" data-brand="{{ $product->brand->name ?? '' }}">
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

                        {{-- Product Info --}}
                        <div class="card-product_info">
                            <a href="{{ route('product-details', $product->slug) }}" class="name-product h4 link">
                                {{ $product->name }}
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
            @else
                @include('frontend.includes.no-found')
            @endif
        </div>
    </div>
</div>