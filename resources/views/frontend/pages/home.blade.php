@extends('frontend.layout.app')

@section('page-title')
    Home
@endsection

@section('page-css')
    <style>
        #featured_category .swiper-slide img{
            height: 350px;
        }
    </style>
@endsection

@section('body-content')

    <!-- Banner Slider -->
    <div class="tf-slideshow type-abs tf-btn-swiper-main hover-sw-nav">
        <div dir="ltr" class="swiper tf-swiper sw-slide-show slider_effect_fade" data-auto="true" data-loop="true" data-effect="fade"
            data-delay="3000">
            <div class="swiper-wrapper">
                @foreach ($banners as $banner)
                    <div class="swiper-slide">
                        <div class="slider-wrap">
                            <div class="sld_image">
                                <img src="{{ asset($banner->image) }}" data-src="{{ asset($banner->image) }}" alt="Image" class="lazyload">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="sw-dot-default tf-sw-pagination"></div>
        </div>
        <div class="tf-sw-nav nav-prev-swiper">
            <i class="icon icon-caret-left"></i>
        </div>
        <div class="tf-sw-nav nav-next-swiper">
            <i class="icon icon-caret-right"></i>
        </div>
    </div>
    <!-- /Banner Slider -->

    <!-- Collection -->
    <div class="s-collection" id="featured_category">
        <div class="sect-title" style="margin: 25px 0;">
            <div class="h1 title text-center">Top Categories</div>
        </div>

        <div dir="ltr" class="swiper tf-swiper" data-preview="4" data-tablet="2" data-mobile-sm="2" data-mobile="1" data-pagination="1"
            data-space-lg="24" data-space-md="15" data-space="10" data-pagination-sm="1" data-pagination-md="2" data-pagination-lg="3">
            <div class="swiper-wrapper">
                @foreach ($featuredCategories as $category)
                    <div class="swiper-slide">
                        <div class="wg-cls-2 d-flex hover-img">
                            <a href="{{ route('category.products', $category->slug) }}" class="image img-style" style="display:block;width:100%">
                               <img class="lazyload" src="{{ asset($category->image ?? 'frontend/images/noimg.jpg') }}" data-src="{{ asset($category->image ?? 'frontend/images/noimg.jpg') }}" alt="">
                            </a>
                            <div class="cls-content_wrap b-16">
                                <div class="cls-content">
                                    <a href="{{ route('category.products', $category->slug) }}" class="tag_cls h3 link">{{ $category->name }}</a>
                                    <span class="br-line type-vertical"></span>
                                    <a href="{{ route('shop') }}" class="tf-btn-line text-nowrap"> Shop now </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- /Collection -->

    <div class="flat-spacing flat-animate-tab">
        <div class="container">
            <div class="sect-title wow fadeInUp">
                <div class="h1 title text-center mb-24">New Arrivals</div>
            </div>

            @if (!$newArrivales->isEmpty())
                <div class="wrapper-shop tf-grid-layout tf-col-4">
                    @foreach ($newArrivales as $product)
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
                </div>
            @else
                @include('frontend.includes.no-found')
            @endif
            
        </div>
    </div>
 
    @include('frontend.includes.home-tap')

    @livewire('frontend.home.special-product')

    @if(!empty($featuredReviews))
        <!-- Testimonial -->
        <section class="flat-spacing pb-10 pt-0">
            <div class="container">
                <div class="h1 sect-title text-black fw-medium text-center wow fadeInUp">Customer Reviews</div>
                <div dir="ltr" class="swiper tf-swiper" data-preview="3" data-tablet="2" data-mobile-sm="1" data-mobile="1" data-space-lg="48"
                    data-space-md="24" data-space="12" data-pagination="1" data-pagination-sm="1" data-pagination-md="2" data-pagination-lg="3">
                    <div class="swiper-wrapper">
                        @foreach ($featuredReviews as $review)
                            <div class="swiper-slide">
                                <div class="testimonial-V01 wow fadeInLeft">
                                    <div class="">
                                        <p class="tes_text h4">
                                           {{ $review->comment }}
                                        </p>
                                        <div class="tes_author">
                                            <p class="author-name h5">
                                                {{ $review->user_id && optional($review->user)->name ? $review->user->name : $review->name }}
                                            </p>
                                        </div>
                                        <div class="rate_wrap">
                                            @php
                                                $rating = $review->rating;
                                            @endphp

                                            @for($i = 1; $i <= 5; $i++)
                                                @if($rating >= $i)
                                                    {{-- Full star --}}
                                                    <i class="icon-star text-star"></i>
                                                @elseif($rating > ($i - 1) && $rating < $i)
                                                    {{-- Half star --}}
                                                    <i class="icon-star text-star-half"></i>
                                                @else
                                                    {{-- Empty star --}}
                                                    <i class="icon-star text-star-empty"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <span class="br-line"></span>
                                    <div class="tes_product">
                                        <a class="product-image" href="{{ route('product-details', $product->slug) }}">
                                            <img class="lazyload" src="{{ asset($review->product->thumb_image) }}">
                                        </a>
                                        <div class="product-infor">
                                            <h5 class="prd_name">
                                                <a href="{{ route('product-details', $product->slug) }}" class="link"> {{ $review->product->name }} </a>
                                            </h5>
                                            <div class="price-wrap">
                                                <span class="price-new h6">${{ format_price($review->product->offer_price) }}</span>
                                                @if ($review->product->discount_option != 1)
                                                    <span class="price-old h6 fw-normal">${{ format_price($review->product->base_price) }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                    </div>
                    <div class="sw-dot-default tf-sw-pagination"></div>
                </div>
            </div>
        </section>
        <!-- /Testimonial -->
    @endif    
    
@endsection

@section('page-script')
     <script>
         window.addEventListener('load', function () {
            document.getElementById('featured_category').style.display = 'block';
        });
    </script>
@endsection
