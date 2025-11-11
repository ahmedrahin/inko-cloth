@extends('frontend.layout.app')

@section('page-title')
    {{ $product->name }}
@endsection

@section('page-css')
    <link rel="stylesheet" href="{{ asset('frontend/css/drift-basic.min.css') }}">
    <link rel="stylesheet" href="{{asset('frontend/css/photoswipe.css')  }}">
    <style>
        .s-page-title{
            padding-top: 110px !important;
        }
        .s-page-title.style-2 .content{
            padding-bottom: 40px;
        }
    </style>
@endsection


@section('body-content')

    <section class="s-page-title style-2">
        <div class="container">
            <div class="content">
                <ul class="breadcrumbs-page">
                    <li><a href="{{ url('/') }}" class="h6 link">Home</a></li>
                    <li class="d-flex"><i class="icon icon-caret-right"></i></li>
                    <li><a href="{{ route('shop') }}" class="h6 link">Shop</a></li>
                    <li class="d-flex"><i class="icon icon-caret-right"></i></li>
                    <li>
                        <h6 class="current-page fw-normal">{{ $product->name }}</h6>
                    </li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Product Main -->
    <section class="flat-single-product flat-spacing-3">
        <div class="tf-main-product section-image-zoom">
            <div class="container">
                <div class="row">
                    <!-- Product Images -->
                    <div class="col-md-6">
                        <div class="tf-product-media-wrap sticky-top">
                            <div class="product-thumbs-slider">
                                <div dir="ltr" class="swiper tf-product-media-thumbs other-image-zoom" data-direction="vertical" data-preview="4.7">
                                    <div class="swiper-wrapper stagger-wrap">

                                        {{-- Main Thumbnail --}}
                                        <div class="swiper-slide stagger-item">
                                            <div class="item">
                                                <img class="lazyload" 
                                                    data-src="{{ asset($product->thumb_image) }}"
                                                    src="{{ asset($product->thumb_image) }}" 
                                                    alt="{{ $product->name }}">
                                            </div>
                                        </div>

                                        {{-- Gallery Images --}}
                                        @foreach ($product->galleryImages ?? [] as $gallery)
                                            <div class="swiper-slide stagger-item">
                                                <div class="item">
                                                    <img class="lazyload" 
                                                        data-src="{{ asset($gallery->image) }}"
                                                        src="{{ asset($gallery->image) }}" 
                                                        alt="{{ $product->name }}">
                                                </div>
                                            </div>
                                        @endforeach

                                        {{-- Variation Images --}}
                                        @php
                                            $variationImages = $product->productStock()->whereNotNull('image')->pluck('image');
                                        @endphp

                                        @foreach ($variationImages as $vImage)
                                            <div class="swiper-slide stagger-item">
                                                <div class="item">
                                                    <img class="lazyload" 
                                                        data-src="{{ asset($vImage) }}"
                                                        src="{{ asset($vImage) }}" 
                                                        alt="{{ $product->name }} Variation">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="flat-wrap-media-product">
                                    <div dir="ltr" class="swiper tf-product-media-main" id="gallery-swiper-started">
                                        <div class="swiper-wrapper">

                                            {{-- Main Image --}}
                                            <div class="swiper-slide">
                                                <a href="{{ asset($product->thumb_image) }}" target="_blank" class="item"
                                                    data-pswp-width="860px" data-pswp-height="1146px">
                                                    <img class="tf-image-zoom lazyload"
                                                        data-zoom="{{ asset($product->thumb_image) }}"
                                                        data-src="{{ asset($product->thumb_image) }}"
                                                        src="{{ asset($product->thumb_image) }}"
                                                        alt="{{ $product->name }}">
                                                </a>
                                            </div>

                                            {{-- Gallery Images --}}
                                            @foreach ($product->galleryImages ?? [] as $gallery)
                                                <div class="swiper-slide">
                                                    <a href="{{ asset($gallery->image) }}" target="_blank" class="item"
                                                        data-pswp-width="860px" data-pswp-height="1146px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="{{ asset($gallery->image) }}"
                                                            data-src="{{ asset($gallery->image) }}"
                                                            src="{{ asset($gallery->image) }}"
                                                            alt="{{ $product->name }}">
                                                    </a>
                                                </div>
                                            @endforeach

                                            {{-- Variation Images --}}
                                            @foreach ($variationImages as $vImage)
                                                <div class="swiper-slide">
                                                    <a href="{{ asset($vImage) }}" target="_blank" class="item"
                                                        data-pswp-width="860px" data-pswp-height="1146px">
                                                        <img class="tf-image-zoom lazyload"
                                                            data-zoom="{{ asset($vImage) }}"
                                                            data-src="{{ asset($vImage) }}"
                                                            src="{{ asset($vImage) }}"
                                                            alt="{{ $product->name }} Variation">
                                                    </a>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /Product Images -->

                    <!-- Product Info -->
                    <div class="col-md-6">
                        <div class="tf-product-info-wrap position-relative">
                            <div class="tf-zoom-main sticky-top"></div>
                            <div class="tf-product-info-list other-image-zoom">
                                <h2 class="product-info-name">{{ $product->name }}</h2>
                                <div class="product-info-meta">
                                    @php
                                        $averageRating = round($product->reviews->avg('rating'), 1);
                                    @endphp

                                    <div class="rating">
                                        <div class="d-flex gap-4">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @php
                                                    $isFull = $averageRating >= $i;
                                                    $isHalf = !$isFull && $averageRating > ($i - 1) && $averageRating < $i;
                                                @endphp

                                                @if ($isFull)
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="#EF9122" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"/>
                                                    </svg>
                                                @elseif ($isHalf)
                                                    <svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg">
                                                        <defs>
                                                            <linearGradient id="half-star-{{ $i }}">
                                                                <stop offset="50%" stop-color="#EF9122"/>
                                                                <stop offset="50%" stop-color="#ccc"/>
                                                            </linearGradient>
                                                        </defs>
                                                        <path d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="url(#half-star-{{ $i }})"/>
                                                    </svg>
                                                @else
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="#ccc" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                        </div>

                                        <div class="reviews text-main">
                                            ({{ $product->reviews->count() }} reviews)
                                        </div>
                                    </div>

                                </div>
                                <div class="tf-product-heading">
                                    <div class="product-info-price price-wrap">
                                        <span class="price-new price-on-sale h2 fw-4">$ {{ $product->offer_price }}</span>
                                        @if ($product->discount_option != 1)
                                            <span class="price-old compare-at-price h6">${{ $product->base_price }}</span>
                                            @php
                                                $discountPercentage = round(
                                                    ($product->discount_amount / $product->base_price) * 100,
                                                );
                                            @endphp
                                            <p class="badges-on-sale h6 fw-semibold">
                                                <span class="number-sale" data-person-sale="29">
                                                    -{{ $discountPercentage }} %
                                                </span>
                                            </p>
                                        @endif
                                    </div>

                                    @if($product->expire_date && config('website_settings.show_expire') == true)
                                        <div class="tf-product-info-countdown">
                                            <div class="countdown-title">
                                                <h5>Hurry up</h5>
                                                <p class="text-main">Offer ends in:</p>
                                            </div>
                                            <div class="tf-countdown style-1">
                                                <div class="js-countdown" 
                                                    data-countdown="{{ \Carbon\Carbon::parse($product->expire_date)->format('Y-m-d H:i:s') }}" 
                                                    data-labels="Days,Hours,Mins,Secs">
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="tf-product-variant">
                                    <div class="variant-picker-item variant-size">
                                        <div class="variant-picker-label">
                                            <div class="h4 fw-semibold">
                                                Size
                                                <span class="variant-picker-label-value value-currentSize">medium</span>
                                            </div>
                                            <a href="#size-guide" data-bs-toggle="modal" class="size-guide link h6 fw-medium">
                                                <i class="icon icon-ruler"></i>
                                                Size Guide
                                            </a>
                                        </div>
                                        <div class="variant-picker-values">
                                            <span class="size-btn" data-size="XS">XS</span>
                                            <span class="size-btn" data-size="S">S</span>
                                            <span class="size-btn" data-size="M">M</span>
                                            <span class="size-btn" data-size="L">L</span>
                                        </div>
                                    </div>
                                    <div class="variant-picker-item variant-color">
                                        <div class="variant-picker-label">
                                            <div class="h4 fw-semibold">
                                                Colors
                                                <span class="variant-picker-label-value value-currentColor">orange</span>
                                            </div>
                                        </div>
                                        <div class="variant-picker-values">
                                            <div class="hover-tooltip tooltip-bot color-btn active" data-color="blue">
                                                <span class="check-color bg-blue-1"></span>
                                                <span class="tooltip">Blue</span>
                                            </div>
                                            <div class="hover-tooltip tooltip-bot color-btn" data-color="gray">
                                                <span class="check-color bg-caramel"></span>
                                                <span class="tooltip">Gray</span>
                                            </div>
                                            <div class="hover-tooltip tooltip-bot color-btn" data-color="pink">
                                                <span class="check-color bg-hot-pink"></span>
                                                <span class="tooltip">Pink</span>
                                            </div>
                                            <div class="hover-tooltip tooltip-bot color-btn" data-color="green">
                                                <span class="check-color bg-dark-jade"></span>
                                                <span class="tooltip">Green</span>
                                            </div>
                                            <div class="hover-tooltip tooltip-bot color-btn" data-color="white">
                                                <span class="check-color bg-white"></span>
                                                <span class="tooltip">White</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="tf-product-total-quantity">
                                    <div class="group-btn">
                                        <div class="wg-quantity">
                                            <button class="btn-quantity btn-decrease">
                                                <i class="icon icon-minus"></i>
                                            </button>
                                            <input class="quantity-product" type="text" name="number" value="1">
                                            <button class="btn-quantity btn-increase">
                                                <i class="icon icon-plus"></i>
                                            </button>
                                        </div>
                                        <a href="#shoppingCart" data-bs-toggle="offcanvas" class="tf-btn animate-btn btn-add-to-cart">
                                            ADD TO CART
                                            <i class="icon icon-shopping-cart-simple"></i>
                                        </a>
                                        <button type="button" class="hover-tooltip box-icon btn-add-wishlist">
                                            <span class="icon icon-heart"></span>
                                            <span class="tooltip">Add to Wishlist</span>
                                        </button>
                                    </div>
                                    <a href="checkout.html" class="tf-btn btn-primary w-100">BUY IT NOW</a>
                                </div>

                                <div class="tf-product-extra-link">
                                    @if(config('website_settings.ask_qustion') == true)
                                        <a href="#askQuestion" data-bs-toggle="modal" class="product-extra-icon link">
                                            <i class="icon icon-ques"></i>Ask a question
                                        </a>
                                        <livewire:frontend.product.product-question :productId="$product->id" />
                                    @endif
                                    @if(config('website_settings.share') == true)
                                        <a href="#shareWith" data-bs-toggle="modal" class="product-extra-icon link">
                                            <i class="icon icon-share"></i>Share
                                        </a>
                                    @endif
                                </div>
                                
                                <ul class="tf-product-cate-sku">
                                    @if(!is_null($product->sku_code))
                                        <li class="item-cate-sku h6">
                                            <span class="label fw-6 text-black">SKU:</span>
                                            <span class="value link text-main-2">{{ $product->sku_code }}</span>
                                        </li>
                                    @endif
                                    @if(!is_null($product->brand_id) && isset($product->brand))
                                        <li class="item-cate-sku h6">
                                            <span class="label fw-6 text-black">Brand:</span>
                                            <a href="{{ url('shop') }}?filter[]=brand:{{ $product->brand->id }}" class="value link text-main-2">{{ $product->brand->name ?? '' }}</a>
                                        </li>
                                    @endif
                                    @if(!is_null($product->category_id) && isset($product->category))
                                        <li class="item-cate-sku h6">
                                            <span class="label fw-6 text-black">Categories:</span>
                                            <a href="{{ route('category.products', [$product->category->slug]) }}" class="value link text-main-2">{{ $product->category->name }}</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- /Product Info -->

                </div>
            </div>
        </div> 
    </section>
    <!-- /Product Main -->
    
    <section class="flat-spacing-3">
        <div class="container">
            <div class="flat-animate-tab tab-style-1">
                <ul class="menu-tab menu-tab-1" role="tablist">
                    <li class="nav-tab-item" role="presentation">
                        <a href="#descriptions" class="tab-link active" data-bs-toggle="tab">Descriptions</a>
                    </li>
                    
                    <li class="nav-tab-item" role="presentation">
                        <a href="#reviews" class="tab-link" data-bs-toggle="tab">Customer Reviews</a>
                    </li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane wd-product-descriptions active show" id="descriptions" role="tabpanel">
                        <div class="tab-descriptions">
                            
                        </div>
                    </div>
                    
                    <div class="tab-pane wd-product-descriptions" id="reviews" role="tabpanel">
                        <div class="tab-reviews write-cancel-review-wrap">
                            <div class="tab-reviews-heading">
                                <div class="top">
                                    <div class="text-center">
                                        <div class="number fw-6">4.8 <span>/5</span></div>
                                        <div class="list-star d-flex justify-content-center gap-4">
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                        </div>
                                        <p class="quantity-reviews">Based on 3.637 reviews</p>
                                    </div>
                                    <div class="rating-score">
                                        <div class="item">
                                            <div class="number-1">5</div>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <div class="line-bg">
                                                <div style="width: 100%;"></div>
                                            </div>
                                            <div class="number-2">100</div>
                                        </div>
                                        <div class="item">
                                            <div class="number-1">4</div>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <div class="line-bg">
                                                <div style="width: 97%;"></div>
                                            </div>
                                            <div class="number-2">97</div>
                                        </div>
                                        <div class="item">
                                            <div class="number-1">3</div>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <div class="line-bg">
                                                <div style="width: 37%;"></div>
                                            </div>
                                            <div class="number-2">37</div>
                                        </div>
                                        <div class="item">
                                            <div class="number-1">2</div>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <div class="line-bg">
                                                <div style="width: 24%;"></div>
                                            </div>
                                            <div class="number-2">24</div>
                                        </div>
                                        <div class="item">
                                            <div class="number-1">1</div>
                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                    fill="#EF9122"></path>
                                            </svg>
                                            <div class="line-bg">
                                                <div style="width: 0%;"></div>
                                            </div>
                                            <div class="number-2">0</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="btns-reviews">
                                    <div class="tf-btn btn-white animate-btn animate-dark line btn-comment-review btn-cancel-review">
                                        Cancel Review
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.9834 5.15866L12.8412 2.0171C12.7367 1.9126 12.6127 1.82971 12.4762 1.77316C12.3397 1.71661 12.1933 1.6875 12.0456 1.6875C11.8978 1.6875 11.7515 1.71661 11.615 1.77316C11.4785 1.82971 11.3545 1.9126 11.25 2.0171L2.57977 10.6873C2.47485 10.7914 2.39167 10.9153 2.33506 11.0518C2.27844 11.1884 2.24953 11.3348 2.25001 11.4826V14.6248C2.25001 14.9232 2.36853 15.2093 2.57951 15.4203C2.79049 15.6313 3.07664 15.7498 3.37501 15.7498H15.1875C15.3367 15.7498 15.4798 15.6906 15.5853 15.5851C15.6907 15.4796 15.75 15.3365 15.75 15.1873C15.75 15.0381 15.6907 14.8951 15.5853 14.7896C15.4798 14.6841 15.3367 14.6248 15.1875 14.6248H8.10844L15.9834 6.74983C16.0879 6.64536 16.1708 6.52133 16.2274 6.38482C16.2839 6.24831 16.313 6.102 16.313 5.95424C16.313 5.80649 16.2839 5.66017 16.2274 5.52367C16.1708 5.38716 16.0879 5.26313 15.9834 5.15866ZM6.51727 14.6248H3.37501V11.4826L9.56251 5.29506L12.7048 8.43733L6.51727 14.6248ZM13.5 7.6421L10.3584 4.49983L12.0459 2.81233L15.1875 5.9546L13.5 7.6421Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                    <div class="tf-btn btn-white animate-btn animate-dark line btn-comment-review btn-write-review">
                                        Write a review
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M15.9834 5.15866L12.8412 2.0171C12.7367 1.9126 12.6127 1.82971 12.4762 1.77316C12.3397 1.71661 12.1933 1.6875 12.0456 1.6875C11.8978 1.6875 11.7515 1.71661 11.615 1.77316C11.4785 1.82971 11.3545 1.9126 11.25 2.0171L2.57977 10.6873C2.47485 10.7914 2.39167 10.9153 2.33506 11.0518C2.27844 11.1884 2.24953 11.3348 2.25001 11.4826V14.6248C2.25001 14.9232 2.36853 15.2093 2.57951 15.4203C2.79049 15.6313 3.07664 15.7498 3.37501 15.7498H15.1875C15.3367 15.7498 15.4798 15.6906 15.5853 15.5851C15.6907 15.4796 15.75 15.3365 15.75 15.1873C15.75 15.0381 15.6907 14.8951 15.5853 14.7896C15.4798 14.6841 15.3367 14.6248 15.1875 14.6248H8.10844L15.9834 6.74983C16.0879 6.64536 16.1708 6.52133 16.2274 6.38482C16.2839 6.24831 16.313 6.102 16.313 5.95424C16.313 5.80649 16.2839 5.66017 16.2274 5.52367C16.1708 5.38716 16.0879 5.26313 15.9834 5.15866ZM6.51727 14.6248H3.37501V11.4826L9.56251 5.29506L12.7048 8.43733L6.51727 14.6248ZM13.5 7.6421L10.3584 4.49983L12.0459 2.81233L15.1875 5.9546L13.5 7.6421Z"
                                                fill="black" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <div class="reply-comment cancel-review-wrap">
                                <div class="reply-comment-filter d-flex mb_24 gap-20 align-items-center justify-content-between flex-wrap">
                                    <div class="d-flex align-items-center flex-wrap gap-12">
                                        <div class="h6 fw-5">Filter by:</div>
                                        <div class="filter-start-wrap">
                                            <div class="filter-item h6 active">
                                                All
                                            </div>
                                            <div class="filter-item h6">
                                                5 star (<span class="number">97</span>)
                                            </div>
                                            <div class="filter-item h6">
                                                4 star (<span class="number">12</span>)
                                            </div>
                                            <div class="filter-item h6">
                                                3 star (<span class="number">23</span>)
                                            </div>
                                            <div class="filter-item h6">
                                                2 star (<span class="number">0</span>)
                                            </div>
                                            <div class="filter-item h6">
                                                1 star (<span class="number">0</span>)
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tf-dropdown-sort" data-bs-toggle="dropdown">
                                        <div class="btn-select">
                                            <span class="text-sort-value">Most Recent</span>
                                            <span class="icon icon-caret-down"></span>
                                        </div>
                                        <div class="dropdown-menu">
                                            <div class="select-item active">
                                                <span class="text-value-item">Most Recent</span>
                                            </div>
                                            <div class="select-item">
                                                <span class="text-value-item">Oldest</span>
                                            </div>
                                            <div class="select-item">
                                                <span class="text-value-item">Most Popular</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reply-comment-wrap">
                                    <div class="reply-comment-item">
                                        <div class="image">
                                            <img class="lazyload" data-src="images/section/recent-1.jpg" src="images/section/recent-1.jpg" alt="">
                                        </div>
                                        <div>
                                            <div class="user">
                                                <div class="flex-grow-1">
                                                    <h4 class="name">
                                                        <a href="#" class="link">Esther Howard</a>
                                                    </h4>
                                                    <div class="user-infor">
                                                        <div class="color">Color: Black</div>
                                                        <div class="line"></div>
                                                        <div class="verified-purchase">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.6453 8.03281C17.3508 7.725 17.0461 7.40781 16.9312 7.12891C16.825 6.87344 16.8187 6.45 16.8125 6.03984C16.8008 5.27734 16.7883 4.41328 16.1875 3.8125C15.5867 3.21172 14.7227 3.19922 13.9602 3.1875C13.55 3.18125 13.1266 3.175 12.8711 3.06875C12.593 2.95391 12.275 2.64922 11.9672 2.35469C11.4281 1.83672 10.8156 1.25 10 1.25C9.18437 1.25 8.57266 1.83672 8.03281 2.35469C7.725 2.64922 7.40781 2.95391 7.12891 3.06875C6.875 3.175 6.45 3.18125 6.03984 3.1875C5.27734 3.19922 4.41328 3.21172 3.8125 3.8125C3.21172 4.41328 3.20312 5.27734 3.1875 6.03984C3.18125 6.45 3.175 6.87344 3.06875 7.12891C2.95391 7.40703 2.64922 7.725 2.35469 8.03281C1.83672 8.57188 1.25 9.18437 1.25 10C1.25 10.8156 1.83672 11.4273 2.35469 11.9672C2.64922 12.275 2.95391 12.5922 3.06875 12.8711C3.175 13.1266 3.18125 13.55 3.1875 13.9602C3.19922 14.7227 3.21172 15.5867 3.8125 16.1875C4.41328 16.7883 5.27734 16.8008 6.03984 16.8125C6.45 16.8187 6.87344 16.825 7.12891 16.9312C7.40703 17.0461 7.725 17.3508 8.03281 17.6453C8.57188 18.1633 9.18437 18.75 10 18.75C10.8156 18.75 11.4273 18.1633 11.9672 17.6453C12.275 17.3508 12.5922 17.0461 12.8711 16.9312C13.1266 16.825 13.55 16.8187 13.9602 16.8125C14.7227 16.8008 15.5867 16.7883 16.1875 16.1875C16.7883 15.5867 16.8008 14.7227 16.8125 13.9602C16.8187 13.55 16.825 13.1266 16.9312 12.8711C17.0461 12.593 17.3508 12.275 17.6453 11.9672C18.1633 11.4281 18.75 10.8156 18.75 10C18.75 9.18437 18.1633 8.57266 17.6453 8.03281ZM16.743 11.1023C16.3687 11.493 15.9812 11.8969 15.7758 12.393C15.5789 12.8695 15.5703 13.4141 15.5625 13.9414C15.5547 14.4883 15.5461 15.0609 15.3031 15.3031C15.0602 15.5453 14.4914 15.5547 13.9414 15.5625C13.4141 15.5703 12.8695 15.5789 12.393 15.7758C11.8969 15.9812 11.493 16.3687 11.1023 16.743C10.7117 17.1172 10.3125 17.5 10 17.5C9.6875 17.5 9.28516 17.1156 8.89766 16.743C8.51016 16.3703 8.10313 15.9812 7.60703 15.7758C7.13047 15.5789 6.58594 15.5703 6.05859 15.5625C5.51172 15.5547 4.93906 15.5461 4.69687 15.3031C4.45469 15.0602 4.44531 14.4914 4.4375 13.9414C4.42969 13.4141 4.42109 12.8695 4.22422 12.393C4.01875 11.8969 3.63125 11.493 3.25703 11.1023C2.88281 10.7117 2.5 10.3125 2.5 10C2.5 9.6875 2.88437 9.28516 3.25703 8.89766C3.62969 8.51016 4.01875 8.10313 4.22422 7.60703C4.42109 7.13047 4.42969 6.58594 4.4375 6.05859C4.44531 5.51172 4.45391 4.93906 4.69687 4.69687C4.93984 4.45469 5.50859 4.44531 6.05859 4.4375C6.58594 4.42969 7.13047 4.42109 7.60703 4.22422C8.10313 4.01875 8.50703 3.63125 8.89766 3.25703C9.28828 2.88281 9.6875 2.5 10 2.5C10.3125 2.5 10.7148 2.88437 11.1023 3.25703C11.4898 3.62969 11.8969 4.01875 12.393 4.22422C12.8695 4.42109 13.4141 4.42969 13.9414 4.4375C14.4883 4.44531 15.0609 4.45391 15.3031 4.69687C15.5453 4.93984 15.5547 5.50859 15.5625 6.05859C15.5703 6.58594 15.5789 7.13047 15.7758 7.60703C15.9812 8.10313 16.3687 8.50703 16.743 8.89766C17.1172 9.28828 17.5 9.6875 17.5 10C17.5 10.3125 17.1156 10.7148 16.743 11.1023ZM13.5672 7.68281C13.6253 7.74086 13.6714 7.80979 13.7029 7.88566C13.7343 7.96154 13.7505 8.04287 13.7505 8.125C13.7505 8.20713 13.7343 8.28846 13.7029 8.36434C13.6714 8.44021 13.6253 8.50914 13.5672 8.56719L9.19219 12.9422C9.13414 13.0003 9.06521 13.0464 8.98934 13.0779C8.91346 13.1093 8.83213 13.1255 8.75 13.1255C8.66787 13.1255 8.58654 13.1093 8.51066 13.0779C8.43479 13.0464 8.36586 13.0003 8.30781 12.9422L6.43281 11.0672C6.31554 10.9499 6.24965 10.7909 6.24965 10.625C6.24965 10.4591 6.31554 10.3001 6.43281 10.1828C6.55009 10.0655 6.70915 9.99965 6.875 9.99965C7.04085 9.99965 7.19991 10.0655 7.31719 10.1828L8.75 11.6164L12.6828 7.68281C12.7409 7.6247 12.8098 7.5786 12.8857 7.54715C12.9615 7.5157 13.0429 7.49951 13.125 7.49951C13.2071 7.49951 13.2885 7.5157 13.3643 7.54715C13.4402 7.5786 13.5091 7.6247 13.5672 7.68281Z"
                                                                    fill="black" />
                                                            </svg>
                                                            <div class="text">Verified Purchase</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-star d-flex justify-content-center gap-4">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <p class="h6 desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id massa in sapien
                                                ornare tristique vel vitae augue. Donec dictum sem semper, posuere leo eu, tempus ex. Morbi id
                                                ipsum urna. Duis elementum, nibh ut rutrum pellentesque, tortor nisi fermentum nulla, ut fringilla
                                                enim magna sed nunc. Nulla fringilla non purus vestibulum porta.</p>
                                            <div class="text-small time text-main-2">April 3, 2020 at 10:43</div>
                                        </div>
                                    </div>
                                    <div class="reply-comment-item">
                                        <div class="image">
                                            <img class="lazyload" data-src="images/section/recent-2.jpg" src="images/section/recent-2.jpg" alt="">
                                        </div>
                                        <div>
                                            <div class="user">
                                                <div class="flex-grow-1">
                                                    <h4 class="name">
                                                        <a href="#" class="link">Eleanor Pena</a>
                                                    </h4>
                                                    <div class="user-infor">
                                                        <div class="color">Color: Black</div>
                                                        <div class="line"></div>
                                                        <div class="verified-purchase">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.6453 8.03281C17.3508 7.725 17.0461 7.40781 16.9312 7.12891C16.825 6.87344 16.8187 6.45 16.8125 6.03984C16.8008 5.27734 16.7883 4.41328 16.1875 3.8125C15.5867 3.21172 14.7227 3.19922 13.9602 3.1875C13.55 3.18125 13.1266 3.175 12.8711 3.06875C12.593 2.95391 12.275 2.64922 11.9672 2.35469C11.4281 1.83672 10.8156 1.25 10 1.25C9.18437 1.25 8.57266 1.83672 8.03281 2.35469C7.725 2.64922 7.40781 2.95391 7.12891 3.06875C6.875 3.175 6.45 3.18125 6.03984 3.1875C5.27734 3.19922 4.41328 3.21172 3.8125 3.8125C3.21172 4.41328 3.20312 5.27734 3.1875 6.03984C3.18125 6.45 3.175 6.87344 3.06875 7.12891C2.95391 7.40703 2.64922 7.725 2.35469 8.03281C1.83672 8.57188 1.25 9.18437 1.25 10C1.25 10.8156 1.83672 11.4273 2.35469 11.9672C2.64922 12.275 2.95391 12.5922 3.06875 12.8711C3.175 13.1266 3.18125 13.55 3.1875 13.9602C3.19922 14.7227 3.21172 15.5867 3.8125 16.1875C4.41328 16.7883 5.27734 16.8008 6.03984 16.8125C6.45 16.8187 6.87344 16.825 7.12891 16.9312C7.40703 17.0461 7.725 17.3508 8.03281 17.6453C8.57188 18.1633 9.18437 18.75 10 18.75C10.8156 18.75 11.4273 18.1633 11.9672 17.6453C12.275 17.3508 12.5922 17.0461 12.8711 16.9312C13.1266 16.825 13.55 16.8187 13.9602 16.8125C14.7227 16.8008 15.5867 16.7883 16.1875 16.1875C16.7883 15.5867 16.8008 14.7227 16.8125 13.9602C16.8187 13.55 16.825 13.1266 16.9312 12.8711C17.0461 12.593 17.3508 12.275 17.6453 11.9672C18.1633 11.4281 18.75 10.8156 18.75 10C18.75 9.18437 18.1633 8.57266 17.6453 8.03281ZM16.743 11.1023C16.3687 11.493 15.9812 11.8969 15.7758 12.393C15.5789 12.8695 15.5703 13.4141 15.5625 13.9414C15.5547 14.4883 15.5461 15.0609 15.3031 15.3031C15.0602 15.5453 14.4914 15.5547 13.9414 15.5625C13.4141 15.5703 12.8695 15.5789 12.393 15.7758C11.8969 15.9812 11.493 16.3687 11.1023 16.743C10.7117 17.1172 10.3125 17.5 10 17.5C9.6875 17.5 9.28516 17.1156 8.89766 16.743C8.51016 16.3703 8.10313 15.9812 7.60703 15.7758C7.13047 15.5789 6.58594 15.5703 6.05859 15.5625C5.51172 15.5547 4.93906 15.5461 4.69687 15.3031C4.45469 15.0602 4.44531 14.4914 4.4375 13.9414C4.42969 13.4141 4.42109 12.8695 4.22422 12.393C4.01875 11.8969 3.63125 11.493 3.25703 11.1023C2.88281 10.7117 2.5 10.3125 2.5 10C2.5 9.6875 2.88437 9.28516 3.25703 8.89766C3.62969 8.51016 4.01875 8.10313 4.22422 7.60703C4.42109 7.13047 4.42969 6.58594 4.4375 6.05859C4.44531 5.51172 4.45391 4.93906 4.69687 4.69687C4.93984 4.45469 5.50859 4.44531 6.05859 4.4375C6.58594 4.42969 7.13047 4.42109 7.60703 4.22422C8.10313 4.01875 8.50703 3.63125 8.89766 3.25703C9.28828 2.88281 9.6875 2.5 10 2.5C10.3125 2.5 10.7148 2.88437 11.1023 3.25703C11.4898 3.62969 11.8969 4.01875 12.393 4.22422C12.8695 4.42109 13.4141 4.42969 13.9414 4.4375C14.4883 4.44531 15.0609 4.45391 15.3031 4.69687C15.5453 4.93984 15.5547 5.50859 15.5625 6.05859C15.5703 6.58594 15.5789 7.13047 15.7758 7.60703C15.9812 8.10313 16.3687 8.50703 16.743 8.89766C17.1172 9.28828 17.5 9.6875 17.5 10C17.5 10.3125 17.1156 10.7148 16.743 11.1023ZM13.5672 7.68281C13.6253 7.74086 13.6714 7.80979 13.7029 7.88566C13.7343 7.96154 13.7505 8.04287 13.7505 8.125C13.7505 8.20713 13.7343 8.28846 13.7029 8.36434C13.6714 8.44021 13.6253 8.50914 13.5672 8.56719L9.19219 12.9422C9.13414 13.0003 9.06521 13.0464 8.98934 13.0779C8.91346 13.1093 8.83213 13.1255 8.75 13.1255C8.66787 13.1255 8.58654 13.1093 8.51066 13.0779C8.43479 13.0464 8.36586 13.0003 8.30781 12.9422L6.43281 11.0672C6.31554 10.9499 6.24965 10.7909 6.24965 10.625C6.24965 10.4591 6.31554 10.3001 6.43281 10.1828C6.55009 10.0655 6.70915 9.99965 6.875 9.99965C7.04085 9.99965 7.19991 10.0655 7.31719 10.1828L8.75 11.6164L12.6828 7.68281C12.7409 7.6247 12.8098 7.5786 12.8857 7.54715C12.9615 7.5157 13.0429 7.49951 13.125 7.49951C13.2071 7.49951 13.2885 7.5157 13.3643 7.54715C13.4402 7.5786 13.5091 7.6247 13.5672 7.68281Z"
                                                                    fill="black" />
                                                            </svg>
                                                            <div class="text">Verified Purchase</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-star d-flex justify-content-center gap-4">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <p class="h6 desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id massa in sapien
                                                ornare tristique vel vitae augue. Donec dictum sem semper, posuere leo eu, tempus ex. Morbi id
                                                ipsum urna. Duis elementum, nibh ut rutrum pellentesque, tortor nisi fermentum nulla, ut fringilla
                                                enim magna sed nunc. Nulla fringilla non purus vestibulum porta.</p>
                                            <div class="text-small time text-main-2">April 3, 2020 at 10:43</div>
                                        </div>
                                    </div>
                                    <div class="reply-comment-item">
                                        <div class="image">
                                            <img class="lazyload" data-src="images/section/recent-1.jpg" src="images/section/recent-1.jpg" alt="">
                                        </div>
                                        <div>
                                            <div class="user">
                                                <div class="flex-grow-1">
                                                    <h4 class="name">
                                                        <a href="#" class="link">Cody Fisher</a>
                                                    </h4>
                                                    <div class="user-infor">
                                                        <div class="color">Color: Black</div>
                                                        <div class="line"></div>
                                                        <div class="verified-purchase">
                                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.6453 8.03281C17.3508 7.725 17.0461 7.40781 16.9312 7.12891C16.825 6.87344 16.8187 6.45 16.8125 6.03984C16.8008 5.27734 16.7883 4.41328 16.1875 3.8125C15.5867 3.21172 14.7227 3.19922 13.9602 3.1875C13.55 3.18125 13.1266 3.175 12.8711 3.06875C12.593 2.95391 12.275 2.64922 11.9672 2.35469C11.4281 1.83672 10.8156 1.25 10 1.25C9.18437 1.25 8.57266 1.83672 8.03281 2.35469C7.725 2.64922 7.40781 2.95391 7.12891 3.06875C6.875 3.175 6.45 3.18125 6.03984 3.1875C5.27734 3.19922 4.41328 3.21172 3.8125 3.8125C3.21172 4.41328 3.20312 5.27734 3.1875 6.03984C3.18125 6.45 3.175 6.87344 3.06875 7.12891C2.95391 7.40703 2.64922 7.725 2.35469 8.03281C1.83672 8.57188 1.25 9.18437 1.25 10C1.25 10.8156 1.83672 11.4273 2.35469 11.9672C2.64922 12.275 2.95391 12.5922 3.06875 12.8711C3.175 13.1266 3.18125 13.55 3.1875 13.9602C3.19922 14.7227 3.21172 15.5867 3.8125 16.1875C4.41328 16.7883 5.27734 16.8008 6.03984 16.8125C6.45 16.8187 6.87344 16.825 7.12891 16.9312C7.40703 17.0461 7.725 17.3508 8.03281 17.6453C8.57188 18.1633 9.18437 18.75 10 18.75C10.8156 18.75 11.4273 18.1633 11.9672 17.6453C12.275 17.3508 12.5922 17.0461 12.8711 16.9312C13.1266 16.825 13.55 16.8187 13.9602 16.8125C14.7227 16.8008 15.5867 16.7883 16.1875 16.1875C16.7883 15.5867 16.8008 14.7227 16.8125 13.9602C16.8187 13.55 16.825 13.1266 16.9312 12.8711C17.0461 12.593 17.3508 12.275 17.6453 11.9672C18.1633 11.4281 18.75 10.8156 18.75 10C18.75 9.18437 18.1633 8.57266 17.6453 8.03281ZM16.743 11.1023C16.3687 11.493 15.9812 11.8969 15.7758 12.393C15.5789 12.8695 15.5703 13.4141 15.5625 13.9414C15.5547 14.4883 15.5461 15.0609 15.3031 15.3031C15.0602 15.5453 14.4914 15.5547 13.9414 15.5625C13.4141 15.5703 12.8695 15.5789 12.393 15.7758C11.8969 15.9812 11.493 16.3687 11.1023 16.743C10.7117 17.1172 10.3125 17.5 10 17.5C9.6875 17.5 9.28516 17.1156 8.89766 16.743C8.51016 16.3703 8.10313 15.9812 7.60703 15.7758C7.13047 15.5789 6.58594 15.5703 6.05859 15.5625C5.51172 15.5547 4.93906 15.5461 4.69687 15.3031C4.45469 15.0602 4.44531 14.4914 4.4375 13.9414C4.42969 13.4141 4.42109 12.8695 4.22422 12.393C4.01875 11.8969 3.63125 11.493 3.25703 11.1023C2.88281 10.7117 2.5 10.3125 2.5 10C2.5 9.6875 2.88437 9.28516 3.25703 8.89766C3.62969 8.51016 4.01875 8.10313 4.22422 7.60703C4.42109 7.13047 4.42969 6.58594 4.4375 6.05859C4.44531 5.51172 4.45391 4.93906 4.69687 4.69687C4.93984 4.45469 5.50859 4.44531 6.05859 4.4375C6.58594 4.42969 7.13047 4.42109 7.60703 4.22422C8.10313 4.01875 8.50703 3.63125 8.89766 3.25703C9.28828 2.88281 9.6875 2.5 10 2.5C10.3125 2.5 10.7148 2.88437 11.1023 3.25703C11.4898 3.62969 11.8969 4.01875 12.393 4.22422C12.8695 4.42109 13.4141 4.42969 13.9414 4.4375C14.4883 4.44531 15.0609 4.45391 15.3031 4.69687C15.5453 4.93984 15.5547 5.50859 15.5625 6.05859C15.5703 6.58594 15.5789 7.13047 15.7758 7.60703C15.9812 8.10313 16.3687 8.50703 16.743 8.89766C17.1172 9.28828 17.5 9.6875 17.5 10C17.5 10.3125 17.1156 10.7148 16.743 11.1023ZM13.5672 7.68281C13.6253 7.74086 13.6714 7.80979 13.7029 7.88566C13.7343 7.96154 13.7505 8.04287 13.7505 8.125C13.7505 8.20713 13.7343 8.28846 13.7029 8.36434C13.6714 8.44021 13.6253 8.50914 13.5672 8.56719L9.19219 12.9422C9.13414 13.0003 9.06521 13.0464 8.98934 13.0779C8.91346 13.1093 8.83213 13.1255 8.75 13.1255C8.66787 13.1255 8.58654 13.1093 8.51066 13.0779C8.43479 13.0464 8.36586 13.0003 8.30781 12.9422L6.43281 11.0672C6.31554 10.9499 6.24965 10.7909 6.24965 10.625C6.24965 10.4591 6.31554 10.3001 6.43281 10.1828C6.55009 10.0655 6.70915 9.99965 6.875 9.99965C7.04085 9.99965 7.19991 10.0655 7.31719 10.1828L8.75 11.6164L12.6828 7.68281C12.7409 7.6247 12.8098 7.5786 12.8857 7.54715C12.9615 7.5157 13.0429 7.49951 13.125 7.49951C13.2071 7.49951 13.2885 7.5157 13.3643 7.54715C13.4402 7.5786 13.5091 7.6247 13.5672 7.68281Z"
                                                                    fill="black" />
                                                            </svg>
                                                            <div class="text">Verified Purchase</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="list-star d-flex justify-content-center gap-4">
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.4091L8.913 5.07466L6.99721 0.261719L5.08143 5.07466L0 5.4091L3.89741 8.7184L2.61849 13.7384L6.99721 10.9707L11.376 13.7384L10.097 8.7184L14 5.4091Z"
                                                            fill="#EF9122"></path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <p class="h6 desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean id massa in sapien
                                                ornare tristique vel vitae augue. Donec dictum sem semper, posuere leo eu, tempus ex. Morbi id
                                                ipsum urna. Duis elementum, nibh ut rutrum pellentesque, tortor nisi fermentum nulla, ut fringilla
                                                enim magna sed nunc. Nulla fringilla non purus vestibulum porta.</p>
                                            <div class="text-small time text-main-2">April 3, 2020 at 10:43</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <form class="form-write-review write-review-wrap">
                                <div class="heading h2 fw-4 text-black">Write a review:</div>
                                <div class="text h6 fw-4">All of your information will be kept confidential. Required fields are marked with an
                                    asterisk (*)</div>
                                <div class="your-rating">
                                    <div class="h4 fw-4 text-black">Your rating:</div>
                                    <div class="list-rating-check">
                                        <input type="radio" id="star5" name="rate" value="5">
                                        <label for="star5" title="text"></label>
                                        <input type="radio" id="star4" name="rate" value="4">
                                        <label for="star4" title="text"></label>
                                        <input type="radio" id="star3" name="rate" value="3">
                                        <label for="star3" title="text"></label>
                                        <input type="radio" id="star2" name="rate" value="2">
                                        <label for="star2" title="text"></label>
                                        <input type="radio" id="star1" name="rate" value="1">
                                        <label for="star1" title="text"></label>
                                    </div>
                                </div>
                                <div class="form-content">
                                    <fieldset class="box-field">
                                        <input type="text" placeholder="Review title" name="text" tabindex="2" value="" aria-required="true"
                                            required="">
                                    </fieldset>
                                    <fieldset class="box-field">
                                        <textarea rows="4" placeholder="Review" tabindex="2" aria-required="true" required=""></textarea>
                                    </fieldset>
                                    <div class="box-field group-2">
                                        <fieldset>
                                            <input type="text" placeholder="Your name" name="text" tabindex="2" value="" aria-required="true"
                                                required="">
                                        </fieldset>
                                        <fieldset>
                                            <input type="email" placeholder="Your email" name="email" tabindex="2" value="" aria-required="true"
                                                required="">
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="button-submit">
                                    <button class="tf-btn btn-fill animate-btn h6 w-100" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                </div>

            </div>
        </div>
    </section>
    <!-- /Product Description -->

    <!-- Size Guide -->
    <div class="modal modalCentered fade modal-size-guide" id="size-guide">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content widget-tabs style-2">
                <div class="header">
                    <ul class="widget-menu-tab">
                        <li class="item-title active">
                            <span class="inner h3">Size Guide</span>
                        </li>
                    </ul>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>
                <div class="wrap">
                    <div class="widget-content-tab">
                        <div class="widget-content-inner active">
                            <table class="tab-sizeguide-table">
                                <thead>
                                    <tr>
                                        <th>Size</th>
                                        <th>US</th>
                                        <th>Bust</th>
                                        <th>Waist</th>
                                        <th>Low Hip</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>XS</td>
                                        <td>2</td>
                                        <td>32</td>
                                        <td>24 - 25</td>
                                        <td>33 - 34</td>
                                    </tr>
                                    <tr>
                                        <td>S</td>
                                        <td>4</td>
                                        <td>26 - 27</td>
                                        <td>34 - 35</td>
                                        <td>35 - 26</td>
                                    </tr>
                                    <tr>
                                        <td>M</td>
                                        <td>6</td>
                                        <td>28 - 29</td>
                                        <td>36 - 37</td>
                                        <td>38 - 40</td>
                                    </tr>
                                    <tr>
                                        <td>L</td>
                                        <td>8</td>
                                        <td>30 - 31</td>
                                        <td>38 - 29</td>
                                        <td>42 - 44</td>
                                    </tr>
                                    <tr>
                                        <td>XL</td>
                                        <td>10</td>
                                        <td>32 - 33</td>
                                        <td>40 - 41</td>
                                        <td>45 - 47</td>
                                    </tr>
                                    <tr>
                                        <td>XXL</td>
                                        <td>12</td>
                                        <td>34 - 35</td>
                                        <td>42 - 43</td>
                                        <td>48 - 50</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Size Guide -->

    <!-- Share -->
    <div class="modal modalCentered fade modal-share" id="shareWith">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-heading">
                    <h2 class="fw-normal">Share</h2>
                    <span class="icon-close icon-close-popup" data-bs-dismiss="modal"></span>
                </div>

                {{-- Social Icons --}}
                <ul class="tf-social-icon">
                    <li>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(Request::fullUrl()) }}"
                        target="_blank" class="social-facebook">
                            <span class="icon"><i class="icon-fb"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(Request::fullUrl()) }}"
                        target="_blank" class="social-x">
                            <span class="icon"><i class="icon-x"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/"
                        target="_blank" class="social-instagram">
                            <span class="icon"><i class="icon-instagram-logo"></i></span>
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/"
                        target="_blank" class="social-tiktok">
                            <span class="icon"><i class="icon-tiktok"></i></span>
                        </a>
                    </li>
                </ul>

                <div class="wrap-code style-1">
                    <p class="coppyText h6" id="btnCopy">{{ Request::fullUrl() }}</p>
                    <div class="btn-coppy-text tf-btn" id="copyButton">Copy</div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Share -->

@endsection

@section('page-script')
    <script src="{{ asset('frontend/js/photoswipe-lightbox.umd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/photoswipe.umd.min.js') }}"></script>
    <script src="{{ asset('frontend/js/zoom.js') }}"></script>
    <script src="{{ asset('frontend/js/drift.min.js') }}"></script>
    <script src="{{ asset('frontend/js/count-down.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const copyButton = document.getElementById("btnCopy");
            const copyText = document.getElementById("coppyText");

            copyButton.addEventListener("click", function () {
                navigator.clipboard.writeText(copyText.textContent).then(() => {
                    copyButton.textContent = "Copied!";
                    copyButton.classList.add("copied");
                    setTimeout(() => {
                        copyButton.textContent = "Copy";
                        copyButton.classList.remove("copied");
                    }, 2000);
                }).catch(err => {
                    console.error("Failed to copy:", err);
                });
            });
        });
    </script>

    <script>

        let modals = document.querySelectorAll('#Reviews-modal, #askQuestion');
        modals.forEach((modal) => {
            modal.addEventListener('show.bs.modal', (e) => {
                Livewire.emit('open_add_modal');
            });
        });

        document.addEventListener('livewire:load', function() {
            Livewire.on('success', function() {
                const cancelButtons = document.querySelectorAll('.icon-close');
                cancelButtons.forEach(button => {
                    setInterval(() => {
                        button.click();
                    }, 1000);
                });
            });
        });
    </script>

@endsection
