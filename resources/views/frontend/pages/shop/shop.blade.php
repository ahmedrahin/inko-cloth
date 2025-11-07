@extends('frontend.layout.app')

@section('page-title')
    Shop Products
@endsection

@section('page-css')
    <link rel="stylesheet" type="text/css" href="{{ asset('frontend/vendor/nouislider/nouislider.min.css') }}">
    <style>
        .empty-content {
            position: absolute;
            left: 50%;
            top: 0;
            height: 100%;
            transform: translate(-50%, 95%);
        }
    </style>
@endsection

@section('body-content')
    
    <div id="wrapper">
        <!-- Page Title -->
        <section class="s-page-title">
            <div class="container">
                <div class="content">
                    <h1 class="title-page">Shop Default Grid</h1>
                    <ul class="breadcrumbs-page">
                        <li><a href="index.html" class="h6 link">Home</a></li>
                        <li class="d-flex"><i class="icon icon-caret-right"></i></li>
                        <li>
                            <h6 class="current-page fw-normal">Shop</h6>
                        </li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- <div class="flat-spacing pb-0">
            <div class="container">
                <div dir="ltr" class="swiper tf-swiper" data-preview="5" data-tablet="4" data-mobile-sm="3" data-mobile="2" data-space-lg="40"
                    data-space-md="24" data-space="12" data-pagination="2" data-pagination-sm="3" data-pagination-md="4" data-pagination-lg="5">
                    <div class="swiper-wrapper">
                        @foreach (App\Models\Category::where('featured', 1)->where('status', 1)->latest()->get() as $category)
                            <div class="swiper-slide">
                                <div class="box-image_category style-2 hover-img">
                                    <a href="" class="box-image_image img-style">
                                        <img class="lazyload" src="{{ asset($category->image ?? 'frontend/images/noimg.jpg') }}" data-src="{{ asset($category->image ?? 'frontend/images/noimg.jpg') }}" alt="">
                                    </a>
                                    <div class="box-image_content">
                                        <a href="" class="tf-btn btn-white animate-btn animate-dark">
                                            <span class="h5 fw-medium">
                                                {{ $category->name }}
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="sw-dot-default tf-sw-pagination"></div>
                </div>
            </div>
        </div> --}}

        <div class="flat-spacing-3" style="margin-bottom: 70px;">
            <div class="container">
                <div class="row">
                    <div class="col-xl-3">
                        @include('frontend.pages.shop.filter')
                    </div>
                    
                    <div class="col-xl-9">
                        <div class="tf-shop-control">
                            <div class="tf-control-filter d-xl-none">
                                <button type="button" id="filterShop" class="tf-btn-filter">
                                    <span class="icon icon-filter"></span><span class="text">Filter</span>
                                </button>
                            </div>

                            <div class="meta-filter-shop active" style="">
                                <div id="product-count-grid" class="count-text"><span class="count">12</span> Products found</div>
                                <div id="applied-filters"><span class="filter-tag remove-tag"><span class="icon icon-close"></span>Price: $0 - $458</span></div>
                                <button id="remove-all" class="remove-all-filters" style="">
                                    <i class="icon icon-close"></i>
                                    Clear all</button>
                            </div>

                            <div class="tf-control-sorting">
                                <p class="h6 d-none d-lg-block">Sort by:</p>
                                <div class="custom-select">
                                    <select id="input-sort">
                                        <option value="" {{ request('sort') == '' ? 'selected' : '' }}>Sorting..</option>
                                        <option value="best_selling" {{ request('sort') == 'best_selling' ? 'selected' : '' }}>Best Selling</option>
                                        <option value="offer_price" {{ request('sort') == 'offer_price' ? 'selected' : '' }}>Price, low to high</option>
                                        <option value="offer_price_desc" {{ request('sort') == 'offer_price_desc' ? 'selected' : '' }}>Price, high to low</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                        <div class="wrapper-control-shop gridLayout-wrapper">

                            <div class="wrapper-shop tf-grid-layout tf-col-3" id="gridLayout">
                                @include('frontend.pages.shop.product-list')
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="overlay-filter" id="overlay-filter"></div>
    </div>

    <div id="ajax-loader">
        <div style="width: 100%;height:100%;display:flex;align-items: center;justify-content: center;">
            <div class="spinner"></div>
        </div>
    </div>

@endsection


@section('page-script')

    <script src="{{ asset('frontend/js/nouislider.min.js') }}"></script>
    <script src="{{ asset('frontend/js/shop.js') }}"></script>

@endsection
